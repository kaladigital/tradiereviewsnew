@extends('layouts.landing')
@section('content')
    <style>
        .display-hidden{
            display:none !important;
        }
    </style>
    <main class="main">
        @include('elements.landing_header')
        <div class="referrals-page-container">
            <section class="referrals-section" id="home">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="inner-container">
                                <div class="section-lead text-center">
                                    <h1>Refer Your Friends And Get Your <span class="blue-text">Free Months!</span></h1>
                                    <p class="lead-text">TradieReviews helps you quickly generate 100’s of online reviews from authentic customers. For every successful person you refer you receive 1 month free and each friend will receive one month free too. All you need to do is filling out a simple form that should not take longer than a minute.</p>
                                </div>
                                <section id="refer_friend_container">
                                    <div class="claim-form-wrap mx-auto text-center reached-limit" id="limit_reached_container" style="{{ $auth_user && $has_limit_reached ? '' : 'display:none;' }}">
                                        <figure class="figure">
                                            <img src="/landing_media/images/reached-limit-icon.svg" alt="Reached limit icon"/>
                                        </figure>
                                        <h3>
                                            You have
                                            <span class="red-text">reached your daily limit</span>
                                            (of a 100 requests). Please try sending new referral requests tomorrow!
                                        </h3>
                                    </div>
                                    @if(!$auth_user)
                                        <div class="claim-form-wrap mx-auto text-center" id="refer_friend_check_container">
                                            <form id="send_referral_check_form">
                                                <h3>Get your <span class="blue-text">free months</span></h3>
                                                <div class="form-group">
                                                    <input type="email" name="email" placeholder="Your Email" id="email" class="form-control" required="required">
                                                    <label for="email">Your Email</label>
                                                </div>
                                                <p class="error-text text-left red-text" id="no_email_found_template" style="display:none;">Sorry, we couldn’t find an account with that email.</p>
                                                <div class="loading_container mb-2 clearfix" style="display:none;">
                                                    <img src="/images/loader.gif" width="24px" class="float-left">
                                                    <span class="float-left ml-1 loader-text">Processing</span>
                                                </div>
                                                <button class="btn btn-primary btn--sqr w-100 btn-submit" type="submit">Continue</button>
                                                <p>
                                                    You agree to our
                                                    <a href="/terms" target="_blank">Terms</a>
                                                    and
                                                    <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                                                </p>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="claim-form-wrap mx-auto text-center invite-friends-multiple" id="invite_friend_container" style="{{ (!$auth_user || ($auth_user && $has_limit_reached)) ? 'display:none;' : '' }}">
                                        <form id="invite_friends_form">
                                            <h3>
                                                Invite your
                                                <span class="blue-text">friends</span>
                                            </h3>
                                            <section id="invite_friends_container">
                                                <section class="invite_friend_item">
                                                    <div class="title-row d-flex align-items-center">
                                                        <h6 class="friend_invite_month_item">Friend #1 - One Free Month</h6>
                                                        <button type="button" class="btn remove-btn d-flex align-items-center ml-auto invite_friend_item_delete_item display-hidden">
                                                            <span>Remove</span>
                                                            <img src="/landing_media/images/close-icon-red.svg" alt="Close icon" class="icon">
                                                        </button>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Your Friend’s First Name" id="friends_name_1" class="form-control friend_name" required="required">
                                                        <label for="friends_name_1">
                                                            Your Friend’s First Name
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="email" placeholder="Your Friend’s Email" id="friends_email_1" class="form-control friend_email" required="required">
                                                        <label for="friends_email_1">Your Friend’s Email</label>
                                                    </div>
                                                </section>
                                            </section>
                                            @if($max_allowed_send_referrals > 1)
                                                <button type="button" class="btn btn-outline btn--sqr w-100 btn-add-another d-flex align-items-center justify-content-center" id="invite_new_friend_btn">
                                                    <img src="/landing_media/images/add-new.svg" alt="Add new icon" class="icon"/>
                                                    Invite Another Friend
                                                </button>
                                            @endif
                                            <div class="mb-2 mt-2 clearfix" id="invite_loading_container" style="display:none;">
                                                <img src="/images/loader.gif" width="24px" class="float-left">
                                                <span class="float-left ml-1 loader-text">Processing</span>
                                            </div>
                                            <button class="btn btn-primary btn--sqr w-100 btn-submit mx-0" id="invite_submit_btn" type="submit">
                                                Get FREE Months
                                            </button>
                                        </form>
                                    </div>
                                    <div class="claim-form-wrap mx-auto text-center invite-friends-by-link" id="share_referral_container" style="{{ !$auth_user || $has_limit_reached ? 'display:none' : '' }}">
                                        <h3>
                                            Share your link on
                                            <br>
                                            <span class="blue-text">Social Media</span>
                                        </h3>
                                        <h6>Copy the Link and Share</h6>
                                        <div class="link-wrap d-flex align-items-center">
                                            <span class="ref-link" id="referral_share_url">{{ $app_url }}/referrals/{{ $referral_code }}</span>
                                            <button id="copy_referral_link" class="btn copy-link blue-text ml-auto">Copy Link</button>
                                        </div>
                                        <h6>Or Share Directly on the Following</h6>
                                        <div class="share-link-section d-flex align-items-center">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $app_url }}/referrals/{{ $referral_code }}" id="facebook_share_btn" target="_blank" class="btn share-with-facebook">
                                                <img src="/landing_media/images/facebook-icon-blue.svg" alt="Facebook icon">
                                                <div class="preview-img">
                                                    <img src="/landing_media/images/facebook-preview.png" alt="Facebook in preview">
                                                </div>
                                            </a>
                                            <a href="https://twitter.com/share?url={{ $app_url }}/referrals/{{ $referral_code }}" target="_blank" id="twitter_share_btn" class="btn share-with-facebook">
                                                <img src="/landing_media/images/twitter-icon-blue.svg" alt="Twitter icon">
                                                <div class="preview-img">
                                                    <img src="/landing_media/images/twitter-preview.png" alt="Twitter in preview">
                                                </div>
                                            </a>
                                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $app_url }}/referrals/{{ $referral_code }}" id="linkedin_share_btn" target="_blank" class="btn share-with-facebook">
                                                <img src="/landing_media/images/linkedin-icon-blue.svg" alt="Linked icon">
                                                <div class="preview-img">
                                                    <img src="/landing_media/images/linkedin-preview.png" alt="Linked in preview">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </section>
                                <div class="reviews-row d-sm-flex justify-content-center">
                                    <figure>
                                        <img src="/landing_media/images/reviews-google.png" alt="Reviews img"/>
                                    </figure>
                                    <figure>
                                        <img src="/landing_media/images/reviews-google-business.png" alt="Reviews img"/>
                                    </figure>
                                    <figure>
                                        <img src="/landing_media/images/reviews-facebook.png" alt="Reviews img"/>
                                    </figure>
                                </div>
                                <div class="sales-grow">
                                    <h2>TradieReviews’s user-friendly system helps you organize, manage, and grow your Online Social Media Presence. Then Watch Sales Grow.</h2>
                                    <ul class="list-items">
                                        <li>
                                            <h5>
                                                <strong>Earn 5-Star Reviews While You Sleep. Then Watch Sales Grow</strong>
                                            </h5>
                                        </li>
                                        <li>
                                            <h5>
                                                <strong>Your Customer Feedback Becomes Free Advertising.</strong> You’re only as successful as your word of mouth. With TradieReviews, your best customers become your most powerful advertising strategy. Satisfied customer voices are amplified at just the right time to generate new leads and drive new business.
                                            </h5>
                                        </li>
                                        <li>
                                            <h5>
                                                <strong>Collect reviews in your sleep.</strong> Let TradieReviews do the heavy lifting with automated review requests, filtering, and publishing that take the hassle out of earning reviews. With high-converting templates, all you have to do is point and click. TradieReviews does the rest.
                                            </h5>
                                        </li>
                                        <li>
                                            <h5>
                                                <strong>Capture Negative Reviews to Improve Your Reputation.</strong> 1-star reviews are part of life...but that doesn’t mean they need to be made public. With built-in review filtering, Tradie Review stops negative reviews (1-star or 2-star) from appearing online, while automatically publishing positive feedback.
                                            </h5>
                                        </li>
                                        <li>
                                            <h5>
                                                <strong>Use real-time customer feedback to drive more sales at higher prices.</strong> Work Track positive, negative, and neutral feedback to figure out how your customers are feeling. Improve your trade, home improvement, or contractor business using real-time data and insights from the people who matter most.
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="free-trial-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto content-col">
                            <h6 class="section-label">TRY TRADIEREVIEWS FOR FREE</h6>
                            <h2>&#60;Full Name&#62; Tried. Why Shouldn’t You Start Growing Your Sales?</h2>
                        </div>
                        <div class="col-12 col-md-auto btn-col ml-md-auto mt-4 mt-md-0">
                            <a href="#" class="btn btn--sqr bg-white">Get Free Month</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="how-it-works-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="inner-container text-center">
                                <h6 class="section-label">HOW IT WORKS</h6>
                                <h2>Get Set Up In <span class="blue-text">Under 120 Seconds</span> & Collect Reviews 24/7</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row steps-row">
                        <div class="col-12 col-md-4 step-item">
                            <figure class="figure">
                                <img src="/landing_media/images/step-icon-1.svg" alt="Step icon" />
                            </figure>
                            <h3>STEP 01</h3>
                            <p>Add your social profiles (Google Maps and Facebook).</p>
                        </div>
                        <div class="col-12 col-md-4 step-item">
                            <figure class="figure">
                                <img src="/landing_media/images/step-icon-2.svg" alt="Step icon" />
                            </figure>
                            <h3>STEP 02</h3>
                            <p>Share your review link with your customers.</p>
                        </div>
                        <div class="col-12 col-md-4 step-item">
                            <figure class="figure">
                                <img src="/landing_media/images/step-icon-3.svg" alt="Step icon" />
                            </figure>
                            <h3>STEP 03</h3>
                            <p>Get more positive reviews for your business!</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="testimonial-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="testimonial-wrap">
                                <div class="swiper-container testimonial-slider">
                                    <!-- Additional required wrapper -->
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                        <div class="swiper-slide text-center">
                                            <h3>Nteger Efficitur Eget Magna Vel Mollis. Vivamus Ultricies <span class="blue-text"> Ultricies Dui, A Hendrerit Nunc </span> Lacinia Vitae. Nam Iaculis Velit Vel Iaculis Convallis. Fusce Lectus Purus, Volutpat.</h3>
                                            <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                        </div>
                                        <div class="swiper-slide text-center">
                                            <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies
                                                <span class="blue-text"> ultricies dui, a hendrerit nunc</span> lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                            </h3>
                                            <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                        </div>
                                        <div class="swiper-slide text-center">
                                            <h3> nteger efficitur eget magna vel mollis. Vivamus ultricies <span class="blue-text">ultricies dui, a hendrerit nunc</span> lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat. </h3>
                                            <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                        </div>
                                        <div class="swiper-slide text-center">
                                            <h3> nteger efficitur eget magna vel mollis. Vivamus ultricies <span class="blue-text"> ultricies dui, a hendrerit nunc</span> lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.</h3>
                                            <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="faqs-section" id="faqs">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="inner-container">
                                <h2>FAQs</h2>
                                <div class="accordion" id="faqsAccordion">
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">Who should use TradieReviews?</button>
                                            </h6>
                                        </div>
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#faqsAccordion">
                                            <div class="card-body"> TradieReviews is suitable for any trade, home improvement, or contractor business. Whether you run a brick-and-mortar store or provide a service, you’re judged on your track record. 7 out of 10 customers won’t take action until they’ve read reviews and TradieReviews ensures new customers find nothing but high praise when researching your business online.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-2">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">What is reputation management?</button>
                                            </h6>
                                        </div>
                                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#faqsAccordion">
                                            <div class="card-body"> You’re in control of your products and services - but your customers are in control of your reputation. Reputation management is how your business is perceived offline and on. TradieReviews gives you control over your online reputation, to drive positive offline experiences and interactions.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-3">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">Will I need to sign a contract to use TradieReviews?</button>
                                            </h6>
                                        </div>
                                        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#faqsAccordion">
                                            <div class="card-body">No. Choose from a monthly subscription or pay annually to receive a discounted rate. However you choose to use TradieReviews, you can leave anytime without being stuck or forced to stick around.</div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-4">
                                            <h6 class="mb-0">
                                                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">Does TradieReviews help my business in any other way?</button>
                                            </h6>
                                        </div>
                                        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#faqsAccordion">
                                            <div class="card-body">Absolutely. Earning reviews isn’t just about showing off. Positive reviews help build trust, and your customers won’t hire you unless they trust you, that’s why 9 out of 10 customers read reviews before dealing with a business. On top of a boost to your bottom line, reviews are a top ranking signal used by Google. So when you start being spoken about online, you’re more likely to appear when people go searching for businesses in your local area. Win-Win.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="tradiereview-section" id="tradieFlow">
                <div class="container">
                    <div class="row sharing-row" id="integrations">
                        <div class="col-12">
                            <h2>Your <span class="blue-text">Favorite Integrations</span> to Unleash the Power of Reviews</h2>
                            <div class="review-icons-wrap owl-carousel d-md-flex align-items-center justify-content-center">
                                <div class="icon-item">
                                    <img src="/landing_media/images/gmail-icon.svg" alt="Gmail icon" class="icon"/>
                                </div>
                                <div class="icon-item">
                                    <img src="/landing_media/images/apple-icon.svg" alt="Apple icon" class="icon"/>
                                </div>
                                <div class="icon-item">
                                    <img src="/landing_media/images/facebook-icon.png" alt="Facebook icon" class="icon"/>
                                </div>
                                <div class="icon-item">
                                    <img src="/landing_media/images/google-poly-icon.svg" alt="Google icon" class="icon"/>
                                </div>
                                <div class="icon-item">
                                    <img src="/landing_media/images/xero-icon.svg" alt="Xero icon" class="icon"/>
                                </div>
                                <div class="icon-item twilio-icon">
                                    <img src="/landing_media/images/twilio-icon.png" alt="Twilio icon" class="icon"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="free-trial-section">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto content-col">
                            <h6 class="section-label">TRY TRADIEREVIEWS FOR FREE</h6>
                            <h2>&#60;Full Name&#62; Tried. Why Shouldn’t You Start Growing Your Sales?</h2>
                        </div>
                        <div class="col-12 col-md-auto ml-md-auto btn-col mt-4 mt-md-0">
                            <a href="#" class="btn btn--sqr bg-white">Get Free Month</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="/js/underscore-min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        window.send_max = parseInt('{{ $max_allowed_send_referrals }}');
        window.user_email = '{{ $auth_user ? $auth_user->email : '' }}';
        window.digit_nums = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        window.digit_tens = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Sighty', 'Ninety'];
        var owl = $('.review-icons-wrap');
        if ($(window).width() < 768) {
            owl.owlCarousel({
                loop: false,
                margin: 15,
                smartSpeed: 700,
                dots: false,
                nav: false,
                items: 4,
            });
        }
        else{
            owl.addClass("off");
        }

        $(document).on('submit','#send_referral_check_form',function(){
            $('#no_email_found_template').hide();
            var email = $('#email').val();
            $(this).find('.btn-submit').hide();
            $(this).find('.loading_container').show();
            var $this = $(this);
            if (email.length) {
                $this.find('.btn-submit').show();
                $this.find('.loading_container').hide();
                $.post('/refer/check',{ email: email },function(data){
                    if (data.status) {
                        if (data.check) {
                            user_email = email;
                        }

                        $('#refer_friend_check_container').fadeOut(function(){
                            $('#invite_friend_container').fadeIn();
                            $('#share_referral_container').fadeIn();
                            var share_referral_url = '{{ $app_url }}/referrals/' + data.code;
                            $('#referral_share_url').text(share_referral_url);
                            $('#facebook_share_btn').attr('href','https://www.facebook.com/sharer/sharer.php?u=' + share_referral_url);
                            $('#twitter_share_btn').attr('href','https://twitter.com/share?url=' + share_referral_url);
                            $('#linkedin_share_btn').attr('href','https://www.linkedin.com/sharing/share-offsite/?url=' + share_referral_url);
                            $(this).remove();
                        });
                    }
                    else{
                        $('#no_email_found_template').show();
                    }
                },'json');
            }
            return false;
        });

        $(document).on('click','#copy_referral_link',function(){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($.trim($('#referral_share_url').text())).select();
            document.execCommand("copy");
            $temp.remove();
            new Noty({
                type: 'success',
                theme: 'metroui',
                layout: 'topRight',
                text: 'Successfully copied to clipboard',
                timeout: 2500,
                progressBar: false
            }).show();
            return false;
        });

        /**Send Invitations*/
        $(document).on('click','#invite_new_friend_btn',function(){
            $('#invite_friends_container').append(_.template($('#invite_friend_template').html())({
                num: $('.invite_friend_item').length + 1,
                unique_num: (new Date()).getTime() * 1000
            }));

            $('.invite_friend_item:last').slideDown(function(){
                friend_invite_handle();
            });

            return false;
        });

        $(document).on('click','.invite_friend_item_delete_item',function(){
            $(this).closest('.invite_friend_item').slideUp(function(){
                $(this).remove();
                friend_invite_handle();
            });
            return false;
        });

        $(document).on('submit','#invite_friends_form',function(){
            var emails_used = [];
            var invite_emails = [];
            var allow_send = true;
            $('.invite_friend_item').each(function(){
                var email_obj = $(this).find('.friend_email');
                var email = email_obj.val();
                if (emails_used.indexOf(email) == -1) {
                    invite_emails.push({
                        name: $(this).find('.friend_name').val(),
                        email: email
                    });

                    emails_used.push(email);
                }
                else{
                    allow_send = false;
                    email_obj.focus();
                    new Noty({
                        type: 'error',
                        theme: 'metroui',
                        layout: 'topRight',
                        text: 'Email already exists in list',
                        timeout: 2500,
                        progressBar: false
                    }).show();
                    return false;
                }
            });

            if (allow_send) {
                $('#invite_submit_btn').hide();
                $('#invite_loading_container').show();
                $.post('/send/refer-friend',{ email: user_email, data: invite_emails },function(data) {
                    if (data.status) {
                        new Noty({
                            type: 'success',
                            theme: 'metroui',
                            layout: 'topRight',
                            text: 'Invitation' + (invite_emails.length ? 's' : '') + ' were sent successfully',
                            timeout: 2500,
                            progressBar: false
                        }).show();

                        send_max = parseInt(data.max_allowed_send_referrals);
                        if (send_max == 1) {
                            $('#invite_new_friend_btn').hide();
                        }

                        if (data.limit_reached) {
                            $('#invite_friend_container').remove();
                            $('#limit_reached_container').show();
                        }
                        else{
                            $('.invite_friend_item').not($('.invite_friend_item:first')).remove();
                            $('#invite_friends_form')['0'].reset();
                            $('#invite_submit_btn').show();
                            $('#invite_loading_container').hide();
                            friend_invite_handle();
                        }
                    }
                    else{
                        $('#invite_submit_btn').show();
                        $('#invite_loading_container').hide();
                        new Noty({
                            type: 'error',
                            theme: 'metroui',
                            layout: 'topRight',
                            text: data.error,
                            timeout: 2500,
                            progressBar: false
                        }).show();
                    }
                },'json');
            }
            return false;
        });

        $(window).resize(function () {
            if ($(window).width() < 768) {
                owl.owlCarousel({
                    loop: false,
                    margin: 15,
                    smartSpeed: 700,
                    dots: false,
                    nav: false,
                    items: 4,
                });
                if ($(".review-icons-wrap").hasClass("off")) {
                    owl.removeClass("off");
                }
            } else {
                if (!$(".review-icons-wrap").hasClass("off")) {
                    owl.addClass("off").trigger("destroy.owl.carousel");
                    owl.find(".owl-stage-outer").children(":eq(0)").unwrap();
                }
            }
        });

        // Take nav for feature items
        var menu = [
            "Automate Reviews",
            "Publish Reviews",
            "Monitor Reviews",
            "Manage Reviews",
            "Analyze Reviews",
        ];

        var contentSwiper = new Swiper(".contentSwiper", {
            loop: true,
            spaceBetween: 10,
            pagination: {
                el: ".features-nav .nav-items",
                clickable: true,
                renderBullet: function (index, className) {
                    return (
                        '<div class="nav-item ' +
                        className +
                        '"><h6>' +
                        menu[index] +
                        "</h6></div>"
                    );
                },
            },
        });

        // Testimonial slider
        var testimonialSwiper = new Swiper(".testimonial-slider", {
            loop: true,
            spaceBetween: 100,
            slidesPerView: 1,
            // If we need pagination
            pagination: {
                el: ".testimonial-slider .swiper-pagination",
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: ".testimonial-wrap .swiper-button-next",
                prevEl: ".testimonial-wrap .swiper-button-prev",
            },
        });
    });

    var friend_invite_handle = function(){
        var total_items = $('.invite_friend_item').length;
        if ($('.invite_friend_item').length >= send_max) {
            $('#invite_new_friend_btn').addClass('display-hidden');
        }
        else{
            $('#invite_new_friend_btn').removeClass('display-hidden');
        }

        if (total_items > 1) {
            $('.invite_friend_item_delete_item').removeClass('display-hidden');
        }
        else{
            $('.invite_friend_item_delete_item').addClass('display-hidden');
        }

        $('.invite_friend_item').each(function(key,value){
            var num = key + 1;
            $(this).find('.friend_invite_month_item').text('Friend #' + num + ' - ' + convert_number_to_words(num) + ' Free Month' + (num > 1 ? 's' : ''));
        });
    }

    function convert_number_to_words(n){
        if (n < 20) {
            return digit_nums[n];
        }

        var digit = n % 10;
        if (n < 100) {
            return digit_tens[~~(n/10)-2] + (digit? '-' + digit_nums[digit]: '');
        }

        return 'Hundred';
    }
</script>
<script type="text/template" id="number_reached_template">
    <div class="claim-form-wrap mx-auto text-center reached-limit">
        <figure class="figure">
            <img src="/landing_media/images/reached-limit-icon.svg" alt="Reached limit icon"/>
        </figure>
        <h3>
            You have
            <span class="red-text">reached your daily limit</span>
            (of a 100 requests). Please try sending new referral requests tomorrow!
        </h3>
    </div>
</script>
<script type="text/template" id="invite_friend_template">
    <section class="invite_friend_item" style="display:none;">
        <div class="title-row d-flex align-items-center">
            <h6 class="friend_invite_month_item">Friend #<%= num %> - <%= convert_number_to_words(num) %> Free Month<%= num > 1 ? 's' : '' %></h6>
            <button type="button" class="btn remove-btn d-flex align-items-center ml-auto invite_friend_item_delete_item">
                <span>Remove</span>
                <img src="/landing_media/images/close-icon-red.svg" alt="Close icon" class="icon"/>
            </button>
        </div>
        <div class="form-group">
            <input type="text" placeholder="Your Friend’s First Name" id="friend_name_<%= unique_num %>" class="form-control friend_name" required="required">
            <label for="friend_name_<%= unique_num %>">
                Your Friend’s First Name
            </label>
        </div>
        <div class="form-group">
            <input type="email" placeholder="Your Friend’s Email" id="friend_email_<%= unique_num %>" class="form-control friend_email" required="required">
            <label for="friend_email_<%= unique_num %>">Your Friend’s Email</label>
        </div>
    </section>
</script>
@endsection
