@extends('layouts.master')
@section('view_css')
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/js/jquery-bar-rating/themes/fontawesome-stars.css">
    <link rel="stylesheet" href="/js/select2/css/select2.min.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'send-review'])
    <div class="col-md-auto col-12 content-wrap reviews-list-view">
        <div class="content-inner">
            <div class="heading-row d-flex">
                <h2>Send Review Invites</h2>
            </div>
            <div class="widget-box">
                <div class="row">
                    <div class="col-12 col-md-auto intro-col">
                        <div class="title-wrap">
                            <h2>{{ $auth_user->name }}</h2>
                            <p class="d-flex justify-content-center align-items-center mb-0">
                                <img src="/images/location-icon-blue.svg" alt="Location icon" class="icon">
                                <span>{{ $auth_user->city ? $auth_user->city.', ' : '' }}{{ $auth_user->Country ? $auth_user->Country->name : '' }}</span>
                            </p>
                        </div>
                        <div class="review-hint">
                            <h3>Customer Reviews</h3>
                            <div class="rating-points d-flex align-items-center">
                                <select class="rating star-rating" data-current-rating="0" autocomplete="off">
                                    <option hidden="" value="0">0</option>
                                    <option value="1" {{ $avg_reviews_received_star == '1' ? 'selected="selected"' : '' }}>1</option>
                                    <option value="2" {{ $avg_reviews_received_star == '2' ? 'selected="selected"' : '' }}>2</option>
                                    <option value="3" {{ $avg_reviews_received_star == '3' ? 'selected="selected"' : '' }}>3</option>
                                    <option value="4" {{ $avg_reviews_received_star == '4' ? 'selected="selected"' : '' }}>4</option>
                                    <option value="5" {{ $avg_reviews_received_star == '5' ? 'selected="selected"' : '' }}>5</option>
                                </select>
                                <span class="points">{{ $avg_reviews_received }} out of 5</span>
                            </div>
                            <p>{{ $total_reviews_received }} customer ratings</p>
                            <div class="review-rating-slide-wrap">
                                <div class="slide-item d-flex align-items-center">
                                    <span>5 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $five_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$five_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>4 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $four_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$four_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>3 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $three_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$three_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>2 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $two_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$two_start_review_percentage) }}%</span>
                                </div>
                                <div class="slide-item d-flex align-items-center">
                                    <span>1 star</span>
                                    <div class="progress-slide" data-rating-progress="{{ $one_start_percentage_rounded }}">
                                        <span class="progress-slide--thumb"></span>
                                    </div>
                                    <span class="rating-percent">{{ sprintf('%.2f',$one_start_review_percentage) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto des-col mt-4 mt-lg-0">
                        <div role="tabpanel" class="review-invite-contents tab-pane fade show active">
                            <h3>How it Works</h3>
                            <p>See how our review process works and make the most out of it!</p>
                            <div class="process-steps">
                                <div class="row">
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-complete-icon.svg" alt="Setting icon">
                                        </figure>
                                        <h5>Complete Jobs</h5>
                                        <p>After each completed jobs, send review requests to the customers.</p>
                                    </div>
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-send-invites-icon.svg" alt="Complete icon">
                                        </figure>
                                        <h5>Share Link</h5>
                                        <p>Copy from below and share your review link with your customers.</p>
                                    </div>
                                    <div class="col-12 col-md-4 process-steps--item">
                                        <figure>
                                            <img src="/images/step-review-icon.svg" alt="Review icon">
                                        </figure>
                                        <h5>Get Reviews</h5>
                                        <p>Get more positive reviews for your business!</p>
                                    </div>
                                </div>
                            </div>


                            <h3>Share Your Review Link</h3>
                            <p>You can share your review link by copying and sending.</p>
                            <div class="review-link-field d-flex">
                                <div class="link-wrap d-flex">
                                    <span class="ref-link">{{ $app_url.'/review/'.$auth_user->public_reviews_code }}</span>
                                    <button type="button" class="btn copy-link blue-text" id="copy_reviews_link">Copy Link</button>
                                </div>
                                <a class="btn mail-btn" href="mailto:?subject=Leave%20Review&amp;body={{ $app_url.'/review/'.$auth_user->public_reviews_code }}">
                                    <img src="/images/outline-email-icon-blue.svg" alt="Outline Email icon green">
                                </a>
                            </div>
                            <h3>Invite Your Clients</h3>
                            <p>Insert your clients’ email addresses and send them review requests!</p>
                            <div class="form-group">
                                {!! Form::text('review_emails',null,['class' => 'form-control', 'required' => 'required', 'id' => 'review_emails', 'placeholder' => 'Email addresses', 'multiple' => 'multiple', 'autocomplete' => 'off']) !!}
                                <button type="submit" class="btn btn--sqr btn-primary" id="send_email_invite">Send</button>
                                <div id="email_send_loading" class="mt-2" style="display:none;">
                                    <img src="/images/loader.gif" width="24px" class="float-left">
                                    <span class="float-left ml-1 loader-text">Sending invitation(s), please stand by...</span>
                                </div>
                            </div>
                            @if($has_tradieflow_subscription)
                                <div class="devider"><span>Or send via Text</span></div>
                                <p>Insert one phone number at a time and send the review request!</p>
                                {!! Form::open(['url' => 'reviews/send', 'id' => 'send_txt_form']) !!}
                                    <div class="phone-number-group-wrapper">
                                        <div class="phone-number-group d-flex">
                                            <div class="country-code">
                                                {!! Form::select('phone_country',$phone_countries,null,['class' => 'form-control', 'required' => 'required', 'id' => 'phone_country']) !!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::text('phone',null,['class' => 'form-control', 'required' => 'required', 'id' => 'phone', 'placeholder' => 'Phone Number']) !!}
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn--sqr btn-primary" id="send_txt_invite">Send</button>
                                        <div id="txt_send_loading" class="mt-2" style="display:none;">
                                            <img src="/images/loader.gif" width="24px" class="float-left">
                                            <span class="float-left ml-1 loader-text">Sending invitation, please stand by...</span>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            @endif
                            <h3>Import Several Emails via Google Sheets and Atomatically Send Requests</h3>
                            <p>
                                Please only fill your first column of your Google Sheet file.
                                <a href="https://docs.google.com/spreadsheets/d/1V8FCr_F5qyiM_pg4295vglW4Vio4-ibRKuuoUGXBsvA/edit#gid=0" target="_blank">
                                    Here yo can check an example of Google Sheet.
                                </a>
                                <br>
                                Click Share button in Google Sheets document, then select Get link with option Anyone with the link can access document. Copy link from Google Sheets and paste it below.
                            </p>
                            <div class="input-link-row form-group">
                                {!! Form::open(['url' => 'send-review', 'id' => 'import_google_sheet_form']) !!}
                                    {!! Form::text('google_sheet_file_url',null,['class' => 'form-control', 'id' => 'google_sheet_file_url', 'placeholder' => 'Link to Your Google Sheets File', 'required' => 'required']) !!}
                                    {!! Form::label('google_sheet_file_url','Link to Your Google Sheets File',['id' => 'google_sheet_file_url']) !!}
                                    <figure class="icon-wrap">
                                        <img class="icon" src="/images/google-sheets-icon.svg" alt="Google sheets icon">
                                    </figure>
                                    <div id="google_sheet_loading" class="mt-2" style="display:none;">
                                        <img src="/images/loader.gif" width="24px" class="float-left">
                                        <span class="float-left ml-1 loader-text">Processing, please stand by...</span>
                                    </div>
                                    <button type="submit" id="google_sheet_import_btn" class="btn btn--sqr btn-primary">Import & Send</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/jquery-bar-rating/jquery.barrating.min.js"></script>
<script type="text/javascript" src="/js/select2/js/select2.min.js"></script>
<script type="text/javascript" src="/js/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="/js/tagsinput/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        handle_star_ratings();

        $('#review_emails').tagsinput({
            allowDuplicates: false,
            tagClass: 'added-email-item',
            trimValue: true,
            maxTags: 100
        });

        $(document).on('change','#phone_country',function(){
            set_country_mask($(this).val());
            return false;
        });

        $(document).on('submit','#send_email_form',function(e){
            e.preventDefault();
            return false;
        });

        $(document).on('click','#send_email_invite',function(){
            var emails = $('#review_emails').val();
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
                    App.render_message('warning','"' + non_valid_email + '" is not valid email address')
                }
                else{
                    $('#send_email_invite').hide();
                    $('#email_send_loading').show();
                    $.post('/reviews/send/invite',{ type: 'email', email: email_obj },function(data){
                        $('#email_send_loading').hide();
                        $('#send_email_invite').show();
                        if (data.status) {
                            $('#review_emails').tagsinput('removeAll');
                            $('#review_emails').val('');
                            App.render_message('success','Invitation sent successfully');
                        }
                        else{
                            App.render_message('info',data.error);
                            if (data.reload) {
                                location.reload();
                            }
                        }
                    },'json');
                }
            }
            else{
                App.render_message('info','Please enter at least one email')
            }

            return false;
        });

        $(document).on('submit','#send_txt_form',function(){
            @if($is_android_user)
                var full_phone = $.trim($('#selected_phone_country_code').text()) + $('#phone').val().replace(/\D/g,'');
                location.href = 'sms:' + full_phone + '?body=' + 'How would you rate your experience with {{ $auth_user->name }}? ' + $('.ref-link').text();
            @else
            $('#send_txt_invite').hide();
            $('#txt_send_loading').show();
            $.post('/reviews/send/invite',{ type: 'phone', phone: $('#phone').val(), country: $('#phone_country').val() },function(data){
                $('#txt_send_loading').hide();
                $('#send_txt_invite').show();
                if (data.status) {
                    $('#phone').val('');
                    App.render_message('success','Invitation sent successfully');
                }
                else{
                    App.render_message('info',data.error);
                }
            },'json');
            @endif
                return false;
        });

        $(document).on('click','#copy_reviews_link',function(){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val('{{ $app_url.'/review/'.$auth_user->public_reviews_code }}').select();
            document.execCommand("copy");
            $temp.remove();
            App.render_message('success','Successfully copied to clipboard');
            return false;
        });

        $(document).on('submit','#import_google_sheet_form',function(){
            var google_sheet_file_url = $('#google_sheet_file_url').val();
            if (google_sheet_file_url && google_sheet_file_url.length) {
                $('#google_sheet_import_btn').hide();
                $('#google_sheet_loading').show();
                $.post('/reviews/google/sheet',{ google_sheet_file_url: google_sheet_file_url },function(data){
                    $('#google_sheet_loading').hide();
                    $('#google_sheet_import_btn').show();
                    if (data.status) {
                        App.render_message('success',data.total_items + ' queued successfully');
                        $('#google_sheet_file_url').val('');
                    }
                    else{
                        App.render_message('error',data.error);
                    }
                    console.log('data received',data);
                },'json');
            }
            else{
                App.render_message('info','Please enter valid Google Sheets URL');
            }
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
                    '<span class="flag-text" id="selected_phone_country_code">' + state.text + ' ' + "</span>"
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

    var handle_star_ratings = function(){
        $('.star-rating').barrating({
            theme: 'css-stars',
            showSelectedRating: false,
            readonly: true,
            allowEmpty: true,
            emptyValue: 0,
        });
    }

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
