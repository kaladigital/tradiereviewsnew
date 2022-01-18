<!DOCTYPE html>
<html lang="en">
<head>
    @if(env('APP_ENV') != 'local')
        @include('elements.seo.google_tag_manager')
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The easiest way to get more reviews for your trade, contractor or home improvement business. FREE Trial. Start generating five star reviews today!">
    <meta name="keywords" content="Tradie Reviews, Get More Reviews, Get Online Reviews">
    <title>TradieReviews: Get More Reviews For Your Tradie Business</title>
    @yield('view_css')
    <link rel="stylesheet" href="/js/noty/noty.css">
    @if(env('APP_ENV') == 'local')
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/custom.css">
    @else
        <link rel="stylesheet" href="/css/main.css?v={{ \Carbon\Carbon::now()->timestamp }}">
        <link rel="stylesheet" href="/css/custom.css?v={{ \Carbon\Carbon::now()->timestamp }}">
    @endif
    <link rel="shortcut icon" href="/favicon-icons/favicon.ico" type="image/x-icon">
</head>
<body>
@if(env('APP_ENV') !== 'local')
    @include('elements.seo.google_tag_manager_no_script')
@endif
<main class="main">
    <section id="call_received_box"></section>
    <header class="main-header row no-gutters align-items-center">
        <button class="nav-toggler btn col-auto" id="nav_toggle">
            <span></span>
        </button>
        <a href="{{ $auth_user ? '/settings/account' : '/' }}" class="logo-wrap col-auto">
            <img src="/images/tradiereviews.svg" alt="Tradieflow logo">
        </a>
        <?php
            $onboarding_pending = isset($user_onboarding) && $user_onboarding->status == 'pending' ? true : false;
        ?>
        @if($onboarding_pending)
            <div class="ml-auto col-auto setup-progress-wrap d-none d-sm-inline">
                <a href="/setup/tradiereviews" class="btn btn-primary d-flex align-items-center">
                    <span class="d-none d-sm-inline">Set Up TradieReviews</span>
                    <span class="setup-progress">{{ $auth_user->onboarding_state }}%</span>
                </a>
            </div>
        @else
            <a href="/referrals" class="btn btn-primary btn--sqr ml-auto d-none d-sm-block free-month-btn">Get FREE Months</a>
        @endif
        <div class="notification ml-auto {{ $onboarding_pending ? 'ml-lg-0' : 'ml-sm-0 dropdown' }} dropdown" id="header_notifications_container" >
            <button class="btn notification-triger" id="notification_icon">
                <span class="count notifications-bubble" id="notification_bubble" style="display: none;"></span>
                <img src="/images/notification-icon-gray.svg" alt="" class="gray-icon">
                <img src="/images/notification-icon-active.svg" alt="" class="green-icon">
            </button>
            <div class="dropdown-menu dropdown-menu-center card expanded" aria-labelledby="notificationMenuButton" id="notification_box" style="display: none;">
                <div class="card-header d-flex align-items-center">
                    <h5>Notifications</h5>
                    <button class="btn close-notification ml-auto" id="close_notification_btn">
                        <img src="/images/notification-close.svg" alt="Close icon black">
                    </button>
                </div>
                <div class="dropdown-inner card-body" aria-labelledby="notificationMenuButton" id="incoming_calls_container" style="display:none;"></div>
                <div class="dropdown-inner card-body" aria-labelledby="notificationMenuButton" id="notification_body"></div>
            </div>
        </div>
        <div class="profile col-auto dropdown">
            <button class="btn profile-pic dropdown-triger" id="profileMenuButton">
                <span>{{ $auth_user->name_initials }}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileMenuButton">
                <div class="dropdown-inner" aria-labelledby="profileMenuButton">
                    <a class="dropdown-item" href="/contact-us">
                        <img src="/images/contact-us-icon.svg" alt="Contact us icon">
                        <span>Contact Us</span>
                    </a>
                    <a class="dropdown-item" href="/privacy-policy">
                        <img src="/images/privacy-policy-icon.svg" alt="Privacy Policy icon">
                        <span>Privacy Policy</span>
                    </a>
                    <a class="dropdown-item" href="/terms">
                        <img src="/images/terms-icon.svg" alt="Terms icon">
                        <span>Terms</span>
                    </a>
                    <a class="dropdown-item" href="/auth/logout">
                        <img src="/images/log-out-icon.svg" alt="Log Out icon">
                        <span>Log Out</span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <div class="content-row row no-gutters">
        @yield('content')
    </div>
</main>
<script type="text/javascript" src="/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/underscore-min.js"></script>
<script type="text/javascript" src="/js/noty/noty.min.js"></script>
@if(env('APP_ENV') != 'local')
<script src="https://sdk.twilio.com/js/client/v1.14/twilio.js"></script>
@endif
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}});
        window.App = {
            render_message: function (type, message) {
                new Noty({
                    type: type,
                    theme: 'metroui',
                    layout: 'topRight',
                    text: message,
                    timeout: 2500,
                    progressBar: false
                }).show();
            },
            notifications: {
                items: [],
                has_more_items: false
            },
            loadNotifications: function(){
                $.post('/dashboard/notifications',{},function(data){
                    App.notifications.items = data.notifications;
                    App.notifications.has_more_items = data.has_more_items;
                    if (data.notifications.length > 0) {
                        $('#notification_bubble').show();
                    }
                    else{
                        $('#notification_bubble').hide();
                    }
                },'json');
            },
            convertNumberWithComma(amount) {
                return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            call: {
                call_start_timer: null,
                current_connection: null,
                twilio_token: null,
                twilio_current_call: null,
                twilio_outgoing_obj: null,
                connection_details: {},
                process_outgoing_call: function(twilio_connection, phone_number, caller_number, type, client_name, client_id, phone_format){
                    var params = {
                        "to": phone_number,
                        "coming_from": caller_number,
                        "to_number" : "true"
                    };

                    var connection = twilio_connection.connect(params);
                    var connection_details = {
                        call_sid: connection.parameters.CallSid,
                        from_number: phone_number,
                        client_name: client_name,
                        type: type,
                        client_id: client_id,
                        phone_format: phone_format
                    }

                    accept_call_connection('outgoing', connection, connection_details);
                }
            }
        }

        $(document).on('click','#notification_icon',function(){
            if ($('#notification_box').is(':visible')) {
                $('#notification_box').slideUp(150);
            }
            else{
                $('#notification_body').html(_.template($('#header_notification_template').html())({
                    items : App.notifications.items,
                    has_more_items : false
                }));
                $('#notification_box').slideDown(150);
            }
            return false;
        });

        $(document).on('click','#close_notification_btn',function(){
            $('#notification_box').slideUp(150);
            return false;
        });

        $(document).on('click','#nav_toggle',function(){
            if ($(this).hasClass('expanded')) {
                $('#nav_toggle,#sidebar_container').removeClass('expanded');
            }
            else{
                $('#nav_toggle,#sidebar_container').addClass('expanded');
            }
            return false;
        });

        App.loadNotifications();
        @if(env('APP_ENV') != 'local')
            setInterval(function(){
                App.loadNotifications();
            },2000);
        @endif
    });

    var accept_call_connection = function(type, connection, connection_details) {
        /**End Interval*/
        $('body').addClass('in-call');
        if (App.call.call_start_timer) {
            clearInterval(App.call.call_start_timer);
        }

        /**End Old Call*/
        if (App.call.current_connection) {
            App.call.call_start_timer = null;
            App.call.current_connection = null;
            App.call.current_connection = null;
        }


        if (type == 'incoming') {
            connection.accept();
        }
        else{
            setTimeout(function(){
                $.post('/history/track',{ phone: connection_details.from_number, twilio_call_id: connection.parameters.CallSid, client_id: connection_details.client_id });
            },700);
        }

        $('#incoming_call_modal').modal('hide');
        $('#call_received_box').html(_.template($('#call_started_template').html())(connection_details)).slideDown();

        var totalSeconds = 0;
        App.call.current_connection = connection;
        App.call.call_start_timer = setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            var total_seconds = pad(totalSeconds % 60);
            var total_minutes = pad(parseInt(totalSeconds / 60));
            var hours = totalSeconds / 3600;
            if (hours >= 1) {
                hours = pad(hours);
                var timer_format = hours + ':' + total_minutes + ':' + total_seconds;
            } else {
                var timer_format = total_minutes + ':' + total_seconds;
            }

            $('#call_start_timer').text(timer_format);
        }

        function pad(val) {
            var valString = val + "";
            if (valString.length < 2) {
                return "0" + valString;
            } else {
                return valString;
            }
        }
    }

    var hide_notification = function(connection){
        if (App.call.twilio_current_call && App.call.twilio_current_call.parameters.CallSid == connection.parameters.CallSid) {
            $('#call_received_box').slideUp(function () {
                $(this).empty();
            });

            if (App.call.call_start_timer) {
                clearInterval(App.call.call_start_timer);
                App.call.call_start_timer = null;
                App.call.current_connection = null;
            }

            App.call.twilio_current_call = null;
            $('body').removeClass('in-call');
        }

        if (connection) {
            if ($('#incoming_call_modal').attr('data-call-sid') == connection.parameters.CallSid) {
                $('#incoming_call_modal').modal('hide');
                $('#incoming_call_modal').attr('data-call-sid', '');
            }

            $('.incoming_call_item[data-id="' + connection.parameters.CallSid + '"]').slideUp(function(){
                $(this).remove();
            });
        }

        if (!$('.incoming_call_item').length) {
            $('#incoming_calls_container').hide();
        }
    }
</script>
@include('elements.seo.inspectlet_code')
@yield('view_script')
<script type="text/template" id="incoming_call_template">
    <a class="notification-item d-flex success" href="">
        <div class="info">
            <p>
                Incoming Call
                <%= call_from %>
            </p>
        </div>
    </a>
</script>
<script type="text/template" id="header_notification_template">
    <%
        if (items.length) {
            for (let i in items) {

                switch(items[i].type) {
                    case 'form':
                %>
                        <a class="notification-item d-flex <%= items[i].status == 'success' ? 'success' : 'error' %>" href="/settings/forms">
                            <div class="icon">
                                <img src="/images/<%= items[i].status == 'success' ? 'form-icon' : 'error-icon' %>.svg">
                            </div>
                            <div class="info">
                                <p>
                                    <span><%= items[i].title %></span><br>
                                    <%= items[i].description %>
                                </p>
                                <span><%= items[i].timeframe %> ago</span>
                            </div>
                            <img src="/images/arrow-right-green.svg" alt="Arrow right green" class="view-arrow">
                        </a>
                <%
                    break;
                    case 'subscription':
                %>
                        <a class="notification-item d-flex error" href="/settings/subscriptions">
                            <div class="icon">
                                <img src="/images/subscriptions-notification-icon.svg" alt="Subscriptions icon">
                            </div>
                            <div class="info">
                                <p><span><%= items[i].title %></span> · <%= items[i].description %></p>
                                <span><%= items[i].timeframe %></span>
                            </div>
                            <img src="/images/arrow-right-green.svg" alt="Arrow right green" class="view-arrow">
                        </a>
                <%
                    break;
                    case 'success_payment':
                %>
                        <div class="notification-item d-flex success">
                            <div class="icon">
                                <img src="/images/notification-subscriptions-success-icon.svg" alt="Subscriptions icon">
                            </div>
                            <div class="info">
                                <p><span><%= items[i].title %></span> · <%= items[i].description %></p>
                                <span><%= items[i].timeframe %></span>
                            </div>
                        </div>
                <%
                    break;
                    case 'fail_payment':
                    %>
                        <div class="notification-item d-flex error">
                            <div class="icon">
                                <img src="/images/subscriptions-notification-icon.svg" alt="Payment fail icon">
                            </div>
                            <div class="info">
                                <p><span><%= items[i].title %></span> · <%= items[i].description %></p>
                                <span><%= items[i].timeframe %></span>
                            </div>
                        </div>
                    <%
                    break;
                }
            }
        } else { %>
            <div class="notification-item d-flex success" href="#">
                <div class="info">
                    <p><span>No notifications found</span></p>
                </div>
            </div>
        <% } %>
    <% if (has_more_items) { %>
        <div class="card-footer">
            <a href="/notifications" class="green-text">Show All</a>
        </div>
    <% } %>
</script>
@if(env('APP_ENV') !== 'local')
    <script>
        // This will initiate Upscope connection. It's important it is added to all pages, even when the user is not logged in.
        (function(w, u, d){var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};var l = function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://code.upscope.io/3TNBfi4H6Z.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(typeof u!=="function"){w.Upscope=i;l();}})(window, window.Upscope, document);

        Upscope('init');
    </script>

    <script>
        // If the user is logged in, optionally identify them with the following method.
        // You can call Upscope('updateConnection', {}); at any time.
        Upscope('updateConnection', {
            // Set the user ID below. If you don't have one, set to undefined.
            uniqueId: "USER UNIQUE ID",

            // Set the user name or email below (e.g. ["John Smith", "john.smith@acme.com"]).
            identities: ["list", "of", "identities", "here"]
        });
    </script>
@endif
<script type="text/template" id="incoming_call_info_template">
    <% if (type == 'no_client') { %>
        <h2><%= from_number %></h2>
    <% } else { %>
        <h2>
            <%= name %>
            <% if (value && value >= 0) { %>
            <span>Value : <%= value && value >= 0 ? '$' + App.convertNumberWithComma(value) : ''  %></span>
            <% } %>
        </h2>
        <div class="label <%= status %>"><%= status_label %></div>
    <% } %>
</script>
<script type="text/template" id="incoming_other_call_info_template">
    <div class="notification-item d-flex success incoming_call_item" data-id="<%= connection_details.call_sid %>">
        <div class="icon">
            <img src="/images/notification-call-icon-call.svg" alt="Form icon">
        </div>
        <div class="info">
            <p>
                <span>Incoming Call</span> ·
                <span class="orange-text"><%= (connection_details.type == 'no_client') ? connection_details.from_number : connection_details.client_name %></span> is calling you. If you accept this call, we will terminate your current call.
            </p>
            <div class="btn-row d-flex align-items-center">
                <button type="button" class="btn accept-btn d-flex align-items-center accept_incoming_call">
                    <img src="/images/notification-accept-icon.svg" alt="Accept icon">
                    <span>Accept</span>
                </button>
                <button type="button" class="btn decline-btn d-flex align-items-center reject_incoming_call">
                    <img src="/images/notification-decline-icon.svg" alt="Decline icon">
                    <span>Decline</span>
                </button>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="call_started_template">
    <div class="calling-box d-flex align-items-center">
        <div class="caller-info">
            <h2>
                <% if (type == 'no_client') { %>
                    <%= phone_format && phone_format.length ? phone_format : from_number %>
                <% } else { %>
                    <%= client_name %>
                <% } %>
            </h2>
            <h6 id="call_start_timer"></h6>
        </div>
        <div class="call-actions d-flex">
            <button class="btn btn-mute-unmute" id="mute_call" data-type="on">
                <img src="/images/mute-on-icon.svg" data-status="on" data-on="mute-on-icon" data-off="mute-unmute-icon">
            </button>
            <button class="btn call-reject-btn" id="end_call">
                <img src="/images/call-End-.svg" alt="Mute icon">
            </button>
        </div>
    </div>
</script>
</body>
</html>
