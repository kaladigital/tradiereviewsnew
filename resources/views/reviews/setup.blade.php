@extends('layouts.master')
@section('view_css')
<link rel="stylesheet" href="/js/upload_file/uploadfile.css">
@endsection
@section('content')
@include('dashboard.left_sidebar_full_menu',['active_page' => 'settings'])
<div class="col-md-auto col-12 content-wrap reviews-setting version-2">
    <div class="content-inner">
        <h2>Set Up Reviews</h2>
        <div class="profile-widget">
            <div class="row">
                @include('settings.settings_menu',['active_page' => 'reviews', 'user_onboaridng' => $user_onboarding])
                <div class="col-12 col-lg-auto mt-5 mt-lg-0 desc-col">
                    <h3>How it Works</h3>
                    <p>See how TradieReviews work and make the most out of it!</p>
                    {!! Form::model($auth_user,['action' => ['ReviewsController@setup'], 'method' => 'patch', 'autocomplete' => 'off', 'id' => 'reviews_setup_form']) !!}
                        <div class="process-steps">
                            <div class="row">
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-setting-icon.svg" alt="Setting icon">
                                    </figure>
                                    <h5>Set Up</h5>
                                    <p>Connect your Google My Business and Facebook link.</p>
                                </div>
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-complete-icon.svg" alt="Complete icon">
                                    </figure>
                                    <h5>Complete Jobs</h5>
                                    <p>Get satisfied customers!</p>
                                </div>
                                <div class="col-12 col-md-4 process-steps--item">
                                    <figure>
                                        <img src="/images/step-review-icon.svg" alt="Review icon">
                                    </figure>
                                    <h5>Get Reviews</h5>
                                    <p>Share your link with your customers to get more reviews!</p>
                                </div>
                            </div>
                        </div>
                        <div class="inner-container">
                            <h6>Link to your Business Page on Facebook</h6>
                            <p>Paste your Facebook Business Page URL to help you get more reviews on Social Media.</p>
                            <div class="input-link-row form-group">
                                {!! Form::url('facebook_reviews_url',null,['class' => 'form-control', 'id' => 'facebook_reviews_url', 'placeholder' => 'URL to Your Facebook Business Page']) !!}
                                {!! Form::label('facebook_reviews_url','URL to Your Facebook Business Page') !!}
                                <figure class="icon-wrap">
                                    <img class="icon" src="/images/social-icon-facebook.svg" alt="Facebook icon">
                                </figure>
                            </div>
                            <h6>Let’s Find Your Google My Business Account</h6>
                            <p>If your company has a real physical address use this method. Please start typing your
                                business name or address below.</p>
                            <div class="url-form-wrap inner-container" id="facebook_wrong_link_container" style="display:none;">
                                <div class="card website-card-item">
                                    <img src="/images/error-icon.png" class="w32" alt="Refresh icon">
                                    <p><span class="red-text">Sorry, we cannot use this link! Please use a valid URL that has the following format: facebook.com/&lt;YourPage&gt;/reviews</span></p>
                                </div>
                            </div>
                            <div class="input-link-row form-group">
                                {!! Form::text('google_review_address',null,['class' => 'form-control', 'id' => 'google_review_address', 'placeholder' => 'Enter Your "Google My Business" URL']) !!}
                                {!! Form::label('google_review_address','Enter Your "Google My Business" URL') !!}
                                <figure class="icon-wrap">
                                    <img class="icon" src="/images/social-icon-google-map.svg" alt="Facebook icon">
                                </figure>
                            </div>
                            <div class="devider">
                                <span>Or</span>
                            </div>
                            <p>
                                If your company does NOT have a physical address use this method. Please follow the steps of our tutorial.
                            </p>
                            <div class="tutorial-section">
                                <div class="tutorial-steps d-flex">
                                    <div class="widget-box step-item">
                                        <div class="figure">
                                            <img src="/images/social-g-store-icon.svg" alt="Tutorial step icon" class="icon">
                                        </div>
                                        <p>Sign in to Google My Business.</p>
                                        <a href="https://business.google.com/?gmbsrc=ww-ww-et-gs-z-gmb-l-z-d~bhc-core-u&amp;ppsrc=GMBB0&amp;utm_campaign=ww-ww-et-gs-z-gmb-l-z-d~bhc-core-u&amp;utm_source=gmb&amp;utm_medium=et" class="btn btn-outline btn--round" target="_blank">Open Link</a>
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
                                    {!! Form::url('google_review_url',null,['class' => 'form-control', 'id' => 'google_review_url', 'placeholder' => 'Enter Your Business URL']) !!}
                                    {!! Form::label('google_review_url','Enter Your Business Address URL') !!}
                                    <figure class="icon-wrap">
                                        <img class="icon" src="/images/social-g-store-icon.svg" alt="Facebook icon">
                                    </figure>
                                </div>
                            </div>
                            <h6>Business Logo</h6>
                            <p>
                                Upload the logo of your business so we can further personalize the review requests sent to your clients.
                            </p>
                            <div id="upload_logo"></div>
                        </div>
                        <div class="action-row">
                            <button type="submit" class="btn btn--round btn-primary">Save</button>
                        </div>
                        {!! Form::hidden('google_place_id',null,['id' => 'google_place_id']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/upload_file/jquery.form.min.js"></script>
<script type="text/javascript" src="/js/upload_file/jquery.uploadfile.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places"></script>
<script type="text/javascript">
    $(document).ready(function(){
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

        $(document).on('change','#facebook_reviews_url',function(){
            var facebook_url = $(this).val();
            if (facebook_url.length && facebook_url.indexOf('/reviews') == -1) {
                $('#facebook_reviews_url').val(facebook_url + (facebook_url.substr(facebook_url.length - 1) == '/' ? '' : '/') + 'reviews');
            }
        });

        $(document).on('submit','#reviews_setup_form',function() {
            var facebook_url = $('#facebook_reviews_url').val();
            var facebook_added = facebook_url.length;
            var google_address = $('#google_review_address').val();
            var google_address_url = $('#google_review_url').val();
            if (!facebook_added && !google_address.length && !google_address_url.length) {
                $('#facebook_reviews_url').focus();
                App.render_message('info', 'Please enter your Facebook Business page url or Google Address in order to receive reviews');
                return false;
            }

            if (facebook_added && facebook_url.indexOf('/reviews') == -1) {
                $('#facebook_reviews_url').val(facebook_url + (facebook_url.substr(facebook_url.length - 1) == '/' ? '' : '/') + 'reviews');
            }

            if (facebook_added && !is_facebook_review_page_link_valid()) {
                App.render_message('Please enter valid Facebook URL');
                return false;
            }
        });

        $(document).on('click','#delete_review_logo',function(){
            $('#review_logo_img').attr('src','/images/upload-img.svg?t=' + (new Date).getTime());
            $('.upload-box').removeClass('uploaded');
            $.post('/reviews/remove/logo',{});
            return false;
        });

        /**Default US country*/
        @if($auth_user->Country)
            var lat = 1 * '{{ $auth_user->Country->lat }}';
            var lng = 1 * '{{ $auth_user->Country->lng }}';
            var def_country = '{{ $auth_user->Country->code }}';
        @else
            var lat = 50.064192;
            var lng = -130.605469;
            var def_country = 'us';
        @endif

        const center = { lat: lat, lng: lng };
        const defaultBounds = {
            north: center.lat + 0.1,
            south: center.lat - 0.1,
            east: center.lng + 0.1,
            west: center.lng - 0.1,
        };
        const input = document.getElementById("google_review_address");
        const options = {
            bounds: defaultBounds,
            componentRestrictions: { country: def_country },
            fields: ["address_components", "geometry", "icon", "name", "place_id"],
            strictBounds: false,
            types: ["establishment"],
        };

        const autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (place && place.place_id) {
                $('#google_place_id').val(place.place_id);
            }
        });
    });

    var is_facebook_review_page_link_valid = function(){
        var facebook_url = $.trim($('#facebook_reviews_url').val());
        var facebook_obj = facebook_url.split('/');
        if (facebook_url.length && (!/^(https?:\/\/)?((w{3}\.)?)?(?:business\.)?facebook.com\/.*/i.test(facebook_url)) || facebook_url.indexOf('/reviews') == -1) {
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
