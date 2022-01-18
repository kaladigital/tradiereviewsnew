@extends('layouts.master')
@section('view_css')
    <link rel="stylesheet" href="/js/select2/css/select2.min.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'reviews'])
    <div class="col-md-auto col-12 content-wrap referrals-user">
        <div class="content-inner">
            <h2>Referrals</h2>
            <div class="widget-box">
                <div class="row">
                    <div class="col-12 col-lg-auto intro-col">
                        <h1 class="blue-text">Get One Month Free For Every Person</h1>
                        <div class="illustrator-row row">
                            <div class="col-12 col-sm-6 col-lg-12">
                                <p class="gray-text">For every successful person you refer you receive 1 month free and each friend will receive one month free too.</p>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="illustration-wrap">
                                    <img src="/images/referrals-illustrator.png" alt="Referrals illustration">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto mt-5 mt-lg-0 desc-col">
                        <div class="review-invite-contents">
                            <h3>Enjoy Your Free Months to Boost Your Business</h3>
                            <p>You can check the ratio of your referral requests sent versus the activated ones.</p>
                            <div class="card-row d-flex">
                                <div class="card card-item">
                                    <h2 id="total_emails_sent">{{ $total_emails_sent }}</h2>
                                    <div class="content d-flex align-items-center">
                                        <p>sent email requests</p>
                                    </div>
                                </div>
                                <div class="card card-item">
                                    <h2>{{ $total_free_months_received }}</h2>
                                    <div class="content d-flex align-items-center">
                                        <p>free months</p>
                                    </div>
                                </div>
                            </div>
                            <h3>99% of Our Business Comes From Referrals</h3>
                            <p>We would love to help you and your friends. Get a free month of TradieReviews for every person you refer.</p>
                            <div class="process-steps">
                                <div class="row">
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-send-invites-icon.png" alt="Setting icon">
                                        </figure>
                                        <h5>Send Invitation</h5>
                                        <p>Send your referral link to a friend and tell them how awesome TradieReviews is!
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-registration-icon.png" alt="Registration icon">
                                        </figure>
                                        <h5>Registration</h5>
                                        <p>Let them register to our services using your referral link.</p>
                                    </div>
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-use-free-icon.png" alt="Use free icon">
                                        </figure>
                                        <h5>Use of Free!</h5>
                                        <p>You and your friends get 1 month premium subscription for free!</p>
                                    </div>
                                </div>
                            </div>
                            <h3>Share Your Unique Referral Link</h3>
                            <p>You can share your referral link by copying and sending it or sharing it on your social media.</p>
                            <div class="review-link-field d-flex">
                                <div class="link-wrap d-flex">
                                    <span class="ref-link">{{ $referral_share_url }}</span>
                                    <button type="button" id="copy_referral_link" class="btn copy-link blue-text">Copy Link</button>
                                </div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $referral_share_url }}" class="btn mail-btn">
                                    <img src="/images/facebook-icon.svg" alt="Facebook icon">
                                </a>
                                <a href="https://twitter.com/share?url={{ $referral_share_url }}" class="btn mail-btn">
                                    <img src="/images/twitter-icon.svg" alt="Twitter icon">
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $referral_share_url }}" class="btn mail-btn">
                                    <img src="/images/linkedin-icon.svg" alt="Linkedin icon">
                                </a>
                            </div>
                            <div class="devider">
                                <span>Or</span>
                            </div>
                            <h3>Invite Your Friends</h3>
                            <p>Insert your friends’ email addresses and send them invitations to join TradieReviews!</p>
                            <div class="form-group">
                                {!! Form::email('email',null,['class' => 'form-control', 'required' => 'required', 'id' => 'email', 'placeholder' => 'Email addresses', 'multiple' => 'multiple', 'autocomplete' => 'off']) !!}
                                <button type="button" id="send_email_invite" class="btn btn--sqr btn-primary">Send</button>
                                <div id="email_send_loading" class="mt-2" style="display:none;">
                                    <img src="/images/loader.gif" width="24px" class="float-left">
                                    <span class="float-left ml-1 loader-text">Processing</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/select2/js/select2.min.js"></script>
<script type="text/javascript" src="/js/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="/js/tagsinput/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#email').tagsinput({
            allowDuplicates: false,
            tagClass: 'added-email-item',
            trimValue: true,
            maxTags: 100
        });

        $(document).on('change','#phone_country',function(){
            set_country_mask($(this).val());
            return false;
        });

        $(document).on('click','#send_email_invite',function(){
            var emails = $('#email').val();
            if (emails.length) {
                var email_obj = emails.split(',');
                var non_valid_email = null;
                for (var i = 0; i < email_obj.length; i++) {
                    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    if (!non_valid_email && !re.test(email_obj[i].toLowerCase())) {
                        non_valid_email = email_obj[i];
                    }
                }

                if (non_valid_email) {
                    App.render_message('warning', '"' + non_valid_email + '" is not valid email address')
                } else {
                    $('#send_email_invite').hide();
                    $('#email_send_loading').show();
                    $.post('/referrals/send/invite',{ type: 'email', email: email_obj },function(data){
                        if (data.status) {
                            $('#email_send_loading').hide();
                            $('#send_email_invite').show();
                            $('#email').tagsinput('removeAll');
                            $('#email').val('');
                            if (data.total_emails_sent) {
                                $('#total_emails_sent').text(parseInt($('#total_emails_sent').text()) + parseInt(data.total_emails_sent));
                            }

                            App.render_message('success','Invitation sent successfully');
                        }
                        else{
                            App.render_message('info',data.error);
                        }
                    },'json');
                }
            }
            return false;
        });

        $(document).on('submit','#send_txt_form',function(){
            $('#send_txt_invite').hide();
            $('#txt_send_loading').show();
            $.post('/referrals/send/invite',{ type: 'phone', phone: $('#phone').val(), country: $('#phone_country').val() },function(data){
                if (data.status) {
                    $('#txt_send_loading').hide();
                    $('#send_txt_invite').show();
                    $('#phone').val('');
                    App.render_message('success','Invitation sent successfully');
                }
                else{
                    App.render_message('info',data.error);
                }
            },'json');
            return false;
        });

        $(document).on('click','#copy_referral_link',function(){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val('{{ $referral_share_url }}').select();
            document.execCommand("copy");
            $temp.remove();
            App.render_message('success','Successfully copied to clipboard');
            return false;
        });

        $('#phone_country').select2({
            width: '100%',
            minimumResultsForSearch: -1,
            templateSelection: function(state){
                if (!state.id) {
                    return state.text;
                }

                var state_lowcase = state.id.toLowerCase();

                return $(
                    '<span class="flag-icon flag-icon-' + state_lowcase + '">' +
                    '<img src="/images/flags/' + state.id + '.png"/>' +
                    '</span>' +
                    '<span class="flag-text">' + state.text + ' ' + "</span>"
                );
            },
            templateResult: function(state) {
                if (!state.id) {
                    return state.text;
                }
                var state_lowcase = state.id.toLowerCase();
                return $(
                    '<span class="flag-icon flag-icon-' + state_lowcase + '">' +
                    '<img src="/images/flags/' + state.id + '.png"/>' +
                    '</span>' +
                    '<span class="flag-text">' + state.text + "</span>"
                );
            },
        });

        set_country_mask($('#phone_country').val());
    });

    var set_country_mask = function(country_code) {
        switch (country_code) {
            case 'au':
                $('#phone').inputmask("(99) 9999 9999",{ clearIncomplete: true });
            break;
            case 'us':
            case 'ca':
                $('#phone').inputmask('(999) 999-9999',{ clearIncomplete: true });
            break;
            case 'gb':
                $('#phone').inputmask('99 999 9999',{ clearIncomplete: true });
            break;
        }
    }
</script>
@endsection
