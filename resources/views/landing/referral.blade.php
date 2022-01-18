@extends('layouts.landing')
@section('meta_tags')
<meta property="og:image" content="{{ $app_url }}/landing_media/images/linkedin-website-img.png"/>
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="627" />
<meta property="og:image" content="{{ $app_url }}/landing_media/images/facebook-website-img.png"/>
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="314" />
<meta name=”twitter:image” content="{{ $app_url }}/landing_media/images/twitter-website-img.png">
@endsection
@section('content')
<main class="main">
    @include('elements.landing_header')
    <div class="referrals-page-container">
        <section class="referrals-section" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="inner-container">
                            <div class="section-lead text-center">
                                <h1>
                                    {{ $user->name }} referred you as a friend. <span class="blue-text">Get your free month!</span>
                                </h1>
                                <p class="lead-text">TradieReviews helps you quickly generate 100’s of online reviews from authentic customers. If you subscribe to TradieReviews, you and {{ $user->name }} will get a 1-month premium subscription for free, and everybody wins! All you need to do is filling out a simple form that should not take longer than a minute.</p>
                            </div>
                            <div class="claim-form-wrap mx-auto text-center">
                                {!! Form::open(['url' => 'referrals', 'id' => 'referral_form']) !!}
                                <form>
                                    <h3>Claim your <span class="blue-text">free month</span></h3>
                                    <div class="form-group">
                                        {!! Form::text('name',null,['id' => 'name', 'class' => 'form-control', 'placeholder' => 'Full Name', 'required' => 'required']) !!}
                                        {!! Form::label('name','Full Name') !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::email('email',null,['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) !!}
                                        {!! Form::label('email','Email') !!}
                                    </div>
                                    <div id="loading_container" class="mb-5 clearfix" style="display:none;">
                                        <img src="/images/loader.gif" width="24px" class="float-left">
                                        <span class="float-left ml-1 loader-text">Processing</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn--sqr w-100 btn-submit" id="process_referral_btn">Get Free Month</button>
                                    <p>
                                        You agree to our
                                        <a href="/terms" target="_blank">Terms</a> and
                                        <a href="/privacy-policy" target="_blank">Privacy Policy</a>.
                                    </p>
                                {!! Form::close() !!}
                            </div>
                            <div class="reviews-row d-sm-flex align-items-center justify-content-center">
                                <figure><img src="/landing_media/images/reviews-google.png" alt="Reviews img"></figure>
                                <figure><img src="/landing_media/images/reviews-google-business.png" alt="Reviews img"></figure>
                                <figure><img src="/landing_media/images/reviews-facebook.png" alt="Reviews img"></figure>
                            </div>
                            <div class="sales-grow">
                                <h2>
                                    TradieReviews’s user-friendly system helps you organize, manage, and grow your Online Social Media Presence. Then Watch Sales Grow.
                                </h2>
                                <ul class="list-items">
                                    <li>
                                        <h5>
                                            <strong>
                                                Earn 5-Star Reviews While You Sleep. Then Watch Sales Grow
                                            </strong>
                                        </h5>
                                    </li>
                                    <li>
                                        <h5><strong>Your Customer Feedback Becomes Free Advertising.</strong> You’re only as
                                            successful
                                            as your word of mouth. With TradieReviews, your best customers become your most
                                            powerful advertising strategy. Satisfied customer voices are amplified at just
                                            the right time to generate new leads and drive new business.</h5>
                                    </li>
                                    <li>
                                        <h5>
                                            <strong>Collect reviews in your sleep.</strong>
                                            Let TradieReviews do the heavy lifting with automated review requests, filtering, and publishing that take the hassle out of earning reviews. With high-converting templates, all you have to do is point and click. TradieReviews does the rest.
                                        </h5>
                                    </li>
                                    <li>
                                        <h5>
                                            <strong>Capture Negative Reviews to Improve Your Reputation.</strong>
                                            1-star reviews are part of life...but that doesn’t mean they need to be made public. With built-in review filtering, Tradie Review stops negative reviews (1-star or 2-star) from appearing online, while automatically publishing positive feedback.
                                        </h5>
                                    </li>
                                    <li>
                                        <h5>
                                            <strong>
                                                Use real-time customer feedback to drive more sales at higher prices.</strong>Work Track positive, negative, and neutral feedback to figure out how your customers are feeling. Improve your trade, home improvement, or contractor business using real-time data and insights from the people who matter most.
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
                        <h2>{{ $user->name }} Tried. Why Shouldn’t you start growing your sales?</h2>
                    </div>
                    <div class="col-12 col-md-auto btn-col ml-md-auto  mt-4 mt-md-0">
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
                            <h6 class="section-label">How it Works</h6>
                            <h2>Get Set Up in <span class="blue-text">Under 120 Seconds</span> & Collect Reviews 24/7</h2>
                        </div>
                    </div>
                </div>
                <div class="row steps-row">
                    <div class="col-12 col-md-4 step-item">
                        <figure class="figure">
                            <img src="/landing_media/images/step-icon-1.svg" alt="Step icon">
                        </figure>
                        <h3>STEP 01</h3>
                        <p>Add your social profiles (Google Maps and Facebook).</p>
                    </div>
                    <div class="col-12 col-md-4 step-item">
                        <figure class="figure">
                            <img src="/landing_media/images/step-icon-2.svg" alt="Step icon">
                        </figure>
                        <h3>STEP 02</h3>
                        <p>Share your review link with your customers.</p>
                    </div>
                    <div class="col-12 col-md-4 step-item">
                        <figure class="figure">
                            <img src="/landing_media/images/step-icon-3.svg" alt="Step icon">
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
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide text-center">
                                        <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies <span
                                                    class="blue-text">ultricies dui, a hendrerit nunc</span>
                                            lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus,
                                            volutpat.
                                        </h3>
                                        <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                    </div>
                                    <div class="swiper-slide text-center">
                                        <h3>
                                            nteger efficitur eget magna vel mollis. Vivamus ultricies
                                            <span class="blue-text">ultricies dui, a hendrerit nunc</span>
                                            lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                        </h3>
                                        <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                    </div>
                                    <div class="swiper-slide text-center">
                                        <h3>
                                            nteger efficitur eget magna vel mollis. Vivamus ultricies
                                            <span class="blue-text">ultricies dui, a hendrerit nunc</span>
                                            lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                        </h3>
                                        <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                    </div>
                                    <div class="swiper-slide text-center">
                                        <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies
                                            <span class="blue-text">ultricies dui, a hendrerit nunc</span>
                                            lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                        </h3>
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
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                                Who should use TradieReviews?
                                            </button>
                                        </h6>
                                    </div>
                                    <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#faqsAccordion">
                                        <div class="card-body">
                                            TradieReviews is suitable for any trade, home improvement, or contractor business. Whether you run a brick-and-mortar store or provide a service, you’re judged on your track record. 7 out of 10 customers won’t take action until they’ve read reviews and TradieReviews ensures new customers find nothing but high praise when researching your business online.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading-2">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                                What is reputation management?
                                            </button>
                                        </h6>
                                    </div>
                                    <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#faqsAccordion">
                                        <div class="card-body">
                                            You’re in control of your products and services - but your customers are in control of your reputation. Reputation management is how your business is perceived offline and on. TradieReviews gives you control over your online reputation, to drive positive offline experiences and interactions.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading-3">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                                Will I need to sign a contract to use TradieReviews?
                                            </button>
                                        </h6>
                                    </div>
                                    <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#faqsAccordion">
                                        <div class="card-body">
                                            No. Choose from a monthly subscription or pay annually to receive a discounted rate. However you choose to use TradieReviews, you can leave anytime without being stuck or forced to stick around.
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="heading-4">
                                        <h6 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                                Does TradieReviews help my business in any other way?
                                            </button>
                                        </h6>
                                    </div>
                                    <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#faqsAccordion">
                                        <div class="card-body">
                                            Absolutely. Earning reviews isn’t just about showing off. Positive reviews help build trust, and your customers won’t hire you unless they trust you, that’s why 9 out of 10 customers read reviews before dealing with a business. On top of a boost to your bottom line, reviews are a top ranking signal used by Google. So when you start being spoken about online, you’re more likely to appear when people go searching for businesses in your local area. Win-Win.
                                        </div>
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
                                <img src="/landing_media/images/gmail-icon.svg" alt="Gmail icon" class="icon">
                            </div>
                            <div class="icon-item">
                                <img src="/landing_media/images/apple-icon.svg" alt="Apple icon" class="icon">
                            </div>
                            <div class="icon-item">
                                <img src="/landing_media/images/facebook-icon.png" alt="Facebook icon" class="icon">
                            </div>
                            <div class="icon-item">
                                <img src="/landing_media/images/google-poly-icon.svg" alt="Google icon" class="icon">
                            </div>
                            <div class="icon-item">
                                <img src="/landing_media/images/xero-icon.svg" alt="Xero icon" class="icon">
                            </div>
                            <div class="icon-item twilio-icon">
                                <img src="/landing_media/images/twilio-icon.png" alt="Twilio icon" class="icon">
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
                        <h2>
                            {{ $user->name }} Tried. Why Shouldn’t you start growing your sales?
                        </h2>
                    </div>
                    <div class="col-12 col-md-auto ml-md-auto btn-col mt-4 mt-md-0">
                        <a href="#" class="btn btn--sqr bg-white">Get Free Month</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('elements.footer',['hide_footer' => false])
</main>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var owl = $('.review-icons-wrap'),
            owlOptions = {
                loop: false,
                margin: 15,
                smartSpeed: 700,
                dots: false,
                nav: false,
                items: 4
            };

        if ($(window).width() < 768) {
            var owlActive = owl.owlCarousel(owlOptions);
        } else {
            owl.addClass('off');
        }

        var reviewIconsSwiper = {};
        $(window).resize(function () {
            if ($(window).width() < 768) {
                if ($('.review-icons-wrap').hasClass('off')) {
                    var owlActive = owl.owlCarousel(owlOptions);
                    owl.removeClass('off');
                }
            } else {
                if (
                    !$('.review-icons-wrap').hasClass('off')) {
                    owl.addClass('off').trigger('destroy.owl.carousel');
                    owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
                }
            }
        });

        var testimonialSwiper = new Swiper(".testimonial-slider", {
            loop: true,
            spaceBetween: 100,
            slidesPerView: 1,
            pagination: {
                el: '.testimonial-slider .swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.testimonial-wrap .swiper-button-next',
                prevEl: '.testimonial-wrap .swiper-button-prev',
            },
        });

        $(document).on('submit','#referral_form',function(){
            $('#loading_container').show();
            $('#process_referral_btn').hide();
            $.post('/referral/process',{ name: $('#name').val(), email: $('#email').val(), code: '{{ $code }}' },function(data){
                if (data.status) {
                    location.href = '/register/set/password';
                }
                else{
                    $('#loading_container').hide();
                    $('#process_referral_btn').show();
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


            return false;
        });
    });
</script>
@endsection
