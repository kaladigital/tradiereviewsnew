@extends('layouts.master')
@section('view_css')
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/js/jquery-bar-rating/themes/fontawesome-stars.css">
    <link rel="stylesheet" href="/js/select2/css/select2.min.css">
@endsection
@section('content')
    @include('dashboard.left_sidebar_full_menu',['active_page' => 'send-review'])
    <div class="col-md-auto col-12 content-wrap reviews-setting version-2">
        <div class="content-inner">
            <h2>Set Up Reviews</h2>
            <div class="widget-box">
                <div class="row">
                    <div class="col-12 col-lg-auto intro-col">
                        <h1 class="blue-text">How to get More reviews</h1>
                        <div class="illustrator-row row">
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="info-box">
                                    <img src="/images/info-icon.svg" alt="Inco icon">
                                    <p>
                                        Quickly generate 100’s of online reviews from authentic customers. 95% of customers read reviews before making a purchase and that’s why top-rated businesses win more sales and grow faster with TradieReviews.
                                    </p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-12">
                                <div class="illustration-wrap">
                                    <img src="/images/setting-review-illustration.png" alt="Review illustration">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto mt-5 mt-lg-0 desc-col">
                        <h3>How it Works</h3>
                        <p>See how our review process work and make the most out of it!</p>
                        <div class="process-steps">
                            <div class="row">
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-setting-icon.svg" alt="Setting icon">
                                    </figure>
                                    <h5>Set Up</h5>
                                    <p>Connect your Google My Business and Facebook link. </p>
                                </div>
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-complete-icon.svg" alt="Complete icon">
                                    </figure>
                                    <h5>Complete Jobs</h5>
                                    <p>Get satisfied customers! </p>
                                </div>
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-review-icon.svg" alt="Review icon">
                                    </figure>
                                    <h5>Get Reviews</h5>
                                    <p>Share your link with your customers to get more reviews! </p>
                                </div>
                            </div>
                        </div>
                        <div class="inner-container progress-steps-wrapper">
                            <h3>Set Up Your Reviews on Social Media</h3>
                            <form id="setup_form">
                                <div class="progress-steps d-flex align-items-center">
                                    <p>Step <span class="current-step" id="current_progress_step">{{ $auth_user->reviews_logo ? '2' : '1' }}</span> of 3</p>
                                    <ul class="progressbar d-flex align-items-center" id="progressbar">
                                        <li class="active setup_progress_item" data-type="logo">&nbsp;</li>
                                        <li class="setup_progress_item {{ $auth_user->reviews_logo ? 'active' : '' }}" data-type="facebook">&nbsp;</li>
                                        <li class="setup_progress_item" data-type="google">&nbsp;</li>
                                    </ul>
                                </div>
                                <fieldset>
                                    <section id="business_logo_container" style="{{ $auth_user->reviews_logo ? 'display:none;' : '' }}">
                                        <div class="form-card">
                                            <h6>Business Logo</h6>
                                            <p>Upload the logo of your business so we can further personalize the review requests sent to your clients.</p>
                                            <div id="upload_logo"></div>
                                        </div>
                                        <input type="button" name="next" class="btn btn-primary btn--sqr action-button next_item" data-type="logo" value="Next">
                                        <input type="button" name="skip" class="btn btn-secondary btn--sqr action-button next_item" data-type="logo" value="Skip">
                                    </section>
                                    <section id="facebook_container" style="{{ $auth_user->reviews_logo ? '' : 'display:none;' }}">
                                        <div class="form-card">
                                            <h6>Link to your Business Page on Facebook</h6>
                                            <p>Paste your Facebook Business Page URL to help you get more reviews on Social Media.</p>
                                            <div class="input-link-row form-group">
                                                <input type="text" class="form-control" id="facebook_reviews_url" placeholder="URL to Your Facebook Business Page">
                                                <label for="facebook_reviews_url">URL to Your Facebook Business Page</label>
                                                <figure class="icon-wrap">
                                                    <img class="icon" src="/images/social-icon-facebook.svg" alt="Facebook icon">
                                                </figure>
                                            </div>
                                        </div>
                                        <input type="button" name="next" class="btn btn-primary btn--sqr next action-button next_item" data-type="facebook" value="Next">
                                        <input type="button" name="skip" class="btn btn-secondary btn--sqr skip action-button next_item" data-type="facebook" value="Skip">
                                    </section>
                                    <section id="google_container" style="display:none;">
                                        <div class="form-card">
                                            <h6>Link to Your Google My Business Account</h6>
                                            <p>Please follow the walkthrough below to find your Google My Business Link</p>
                                            <div class="tutorial-section">
                                                <div class="tutorial-steps d-flex">
                                                    <div class="widget-box step-item">
                                                        <div class="figure">
                                                            <img src="/images/social-g-store-icon.svg" alt="Tutorial step icon" class="icon">
                                                        </div>
                                                        <p>Sign in to Google My Business.</p>
                                                        <a href="https://business.google.com/?gmbsrc=ww-ww-et-gs-z-gmb-l-z-d~bhc-core-u&ppsrc=GMBB0&utm_campaign=ww-ww-et-gs-z-gmb-l-z-d~bhc-core-u&utm_source=gmb&utm_medium=et" class="btn btn-outline btn--round" target="_blank">Open Link</a>
                                                    </div>
                                                    <div class="widget-box step-item">
                                                        <div class="figure">
                                                            <img src="/images/home-tutorial-step-icon.svg" alt="Tutorial step icon" class="icon">
                                                        </div>
                                                        <p>In the left menu, click Home.</p>
                                                    </div>
                                                    <div class="widget-box step-item">
                                                        <div class="figure">
                                                            <img src="/images/copy-tutorial-step-icon.svg" alt="Tutorial step icon" class="icon">
                                                        </div>
                                                        <p>In the “Get more reviews” card, you can copy your short URL to share with
                                                            customers.</p>
                                                    </div>
                                                    <div class="widget-box step-item">
                                                        <div class="figure">
                                                            <img src="/images/video-play-icon.svg" alt="Video play icon" class="icon">
                                                        </div>
                                                        <p>Watch video to get some extra help.</p>
                                                        <a class="btn btn-outline btn--round btn-preview-video">Preview Video</a>
                                                        <div class="preview-wrap">
                                                            <img src="/images/preview-video.gif" alt="Preview video">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-link-row form-group">
                                                    <input type="url" class="form-control" id="google_review_url" placeholder="Enter Your Google My Business Link">
                                                    <label for="google_review_url">Enter Your Google My Business Link</label>
                                                    <figure class="icon-wrap">
                                                        <img class="icon" src="/images/social-g-store-icon.svg" alt="Google store icon">
                                                    </figure>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="loading_container" class="mb-5 clearfix" style="display:none;">
                                            <img src="/images/loader.gif" width="24px" class="float-left">
                                            <span class="float-left ml-1 loader-text">Setting Up Reviews</span>
                                        </div>
                                        <section id="action_btn_container">
                                            <input type="button" class="btn btn-primary btn--sqr saveFinish action-button next_item" data-type="google" value="Save & Finish">
                                            <input type="submit" name="previous" class="btn btn-secondary btn--sqr previous action-button-previous" id="prev_google_item" value="Previous">
                                        </section>
                                    </section>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/upload_file/jquery.form.min.js"></script>
<script type="text/javascript" src="/js/upload_file/jquery.uploadfile.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','.next_item',function(){
            var type = $(this).attr('data-type');
            switch (type) {
                case 'logo':
                    $('#business_logo_container').slideUp();
                    $('#facebook_container').slideDown();
                    $('.setup_progress_item[data-type="facebook"]').addClass('active');
                    $('#current_progress_step').text('2');
                break;
                case 'facebook':
                    var facebook_url = $('#facebook_reviews_url').val();
                    if (facebook_url.length) {
                        if (!is_facebook_review_page_link_valid()) {
                            App.render_message('Please type valid Facebook URL');
                        }
                    }
                    $('#facebook_container').slideUp();
                    $('#google_container').slideDown();
                    if (facebook_url.length && facebook_url.indexOf('/reviews') == -1) {
                        $('#facebook_reviews_url').val(facebook_url + (facebook_url.substr(facebook_url.length - 1) == '/' ? '' : '/') + 'reviews');
                    }
                    $('.setup_progress_item[data-type="google"]').addClass('active');
                    $('#current_progress_step').text('3');
                break;
                case 'google':
                    $('#setup_form').trigger('submit');
                break;
            }
            return false;
        });

        $(document).on('submit','#setup_form',function(){
            var facebook_reviews_url = $('#facebook_reviews_url').val();
            var google_review_url = $('#google_review_url').val();
            if (facebook_reviews_url.length || google_review_url.length) {
                $('#action_btn_container').hide();
                $('#loading_container').show();
                $.post('/send-review/setup',{ facebook_reviews_url: facebook_reviews_url, google_review_url: google_review_url },function(data){
                    if (data.status) {
                        location.href = '/send-review';
                    }
                    else{
                        App.render_message('info',data.error);
                    }
                },'json');
            }
            else{
                App.render_message('info','Please specify Facebook or Google URL');
            }
            return false;
        });

        $(document).on('click','#prev_google_item',function(){
            $('.setup_progress_item[data-type="google"]').removeClass('active');
            $('#google_container').slideUp();
            $('#facebook_container').slideDown();
            $('#current_progress_step').text('2');
            return false;
        });

        $(document).on('keyup','#facebook_reviews_url',function(){
            var facebook_url = $.trim($(this).val());
            if (facebook_url.length) {
                if (!is_facebook_review_page_link_valid()) {
                    App.render_message('info','Please type valid facebook URL');
                }
            }
            return false;
        });

        $('#upload_logo').uploadFile({
            url: '/reviews/business/logo',
            dragDrop: true,
            fileName: 'qqfile',
            multiple : false,
            returnType: 'json',
            showStatusAfterSuccess: false,
            showAbort: false,
            showDone: false,
            uploadButtonClass : '',
            dragDropStr: $('#upload_logo_box_template').html(),
            ajax_drag_drop_class: '',
            browse_btn_class: 'browse_image',
            showProgressBar: false,
            showLoading: false,
            onCancel: function(files,pd) {
                $('.ajax-file-upload-statusbar').remove();
            },
            onError: function(files,status,errMsg,pd)
            {
                $('.ajax-file-upload-statusbar').remove();
            },
            onSuccess:function(files,data,xhr){
                if (data.status) {
                    $('#review_logo_img').attr('src','/review-logo/' + data.file_name + '?t=' + (new Date()).getTime())
                    $('.upload-box').addClass('uploaded');
                    App.render_message('success','Logo successfully uploaded');
                }
                else{
                    App.render_message('error',data.error);
                }
            }
        });
    });

    var is_facebook_review_page_link_valid = function(){
        var facebook_url = $.trim($('#facebook_reviews_url').val());
        var facebook_obj = facebook_url.split('/');
        if (facebook_url.length && (!/^(https?:\/\/)?((w{3}\.)?)?(?:business\.)?facebook.com\/.*/i.test(facebook_url))) {
            $('#facebook_wrong_link_container').show();
            $('#facebook_reviews_url').focus();
            return false;
        }
        else{
            $('#facebook_wrong_link_container').hide();
        }

        return true;
    }
</script>
<script type="text/template" id="upload_logo_box_template">
    <div class="upload-box {{ $auth_user->reviews_logo ? 'uploaded' : '' }}">
        <figure class="icon-wrap browse_image">
            <img src="{{ $auth_user->reviews_logo ? '/review-logo/'.$auth_user->reviews_logo : '/images/upload-img.svg' }}" alt="Image upload" class="icon single-img" id="review_logo_img">
            <img src="/images/upload-img-multiple.svg" alt="Multiple image upload" class="icon multiple-img">
        </figure>
        <h6 class="browse_image">
            Drop your image here or
            <button type="button" class="btn browse-img-btn">browse</button>
        </h6>
        <span class="browse_image">Supports: JPG, PNG</span>
        <div class="action-row align-items-center">
            <button type="button" class="btn delete-btn" id="delete_review_logo">Delete Image</button>
            <button type="button" class="btn btn--round green-outline ml-auto browse_image">Replace Image</button>
        </div>
    </div>
</script>
@endsection
