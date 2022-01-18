@extends('layouts.landing')
@section('content')
<main class="main">
    @include('elements.landing_header')
    <section class="hero-section content-with-thumb thumb-right" id="home">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/hero-figure.png" alt="Section thumb" class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h1>Earn 5-Star Reviews While You Sleep. <span class="blue-text">Then Watch Sales Grow</span></h1>
                    <p class="lead-text">Quickly generate 100’s of online reviews from authentic customers. 95% of customers read reviews before making a purchase and that’s why top-rated businesses win more sales and grow faster with TradieReviews.</p>
                    <ul class="list-items">
                        <li>Explode your online word of mouth</li>
                        <li>Send high-converting review requests</li>
                        <li>Turn reviews into FREE advertising</li>
                        <li>Generate 5-star reviews 24/7</li>
                    </ul>
                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                </div>
            </div>
        </div>
    </section>
    <section class="promo-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 promo-item text-center">
                    <span class="heading-text">9 out of 10</span>
                    <p class="lead-text">9 out of 10 customers read online reviews before making a purchase.</p>
                </div>
                <div class="col-12 col-md-4 promo-item text-center">
                    <span class="heading-text">3.5x</span>
                    <p class="lead-text">Conversion rates increase by an average of 3.5x with customer reviews.</p>
                </div>
                <div class="col-12 col-md-4 promo-item text-center">
                    <span class="heading-text">78%</span>
                    <p class="lead-text">78% of customers trust reviews as much as personal recommendations.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="about-section content-with-thumb thumb-right" id="about">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/about-thumb.png" alt="Section thumb" class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h6 class="section-label">About</h6>
                    <h2>What is a <span class="blue-text">Review Machine?</span></h2>
                    <p class="lead-text">Quickly generate 100’s of online reviews from authentic customers. 95% of customers read reviews before making a purchase and that’s why top-rated businesses win more sales and grow faster with TradieReviews.</p>
                    <div class="options-wrap">
                        <div class="option-item">
                            <h3>Become the #1 business on Google</h3>
                            <p>Win reviews on Google to help you rank higher in search results when customers look for contractors and tradesmen online (reviews are a top ranking factor). With TradieReviews you can help boost your SEO and become the #1 business in your area.</p>
                        </div>
                        <div class="option-item">
                            <h3>Become unmissable on Facebook</h3>
                            <p>Generate and share reviews on the world’s most popular social media platform to build trust, boost your credibility, and help more customers find their way to your business. Send reviews directly to your Facebook Page to raise your reputation and revenue.</p>
                        </div>
                        <div class="option-item">
                            <h3>Free advertising online</h3>
                            <p>TradieReviews lets you turn happy customers into raving fans. Each 5-star review acts as a vote of confidence that helps you convert more site visitors to paying customers. That’s how you use your customer’s positive feedback as free advertising.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="features-section" id="features">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-auto features-nav d-none d-md-block">&nbsp;</div>
                <div class="col-12 col-md-auto features-content mt-0">
                    <h6 class="section-label">Features</h6>
                    <h2>More Reviews = More Trust, More Leads, and <span class="blue-text">More Revenue</span></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-auto features-nav">
                    <div class="nav-items">
                        <div class="nav-item active">
                            <h6>Automate Reviews</h6>
                        </div>
                        <div class="nav-item">
                            <h6>Publish Reviews</h6>
                        </div>
                        <div class="nav-item">
                            <h6>Monitor Reviews</h6>
                        </div>
                        <div class="nav-item">
                            <h6>Manage Reviews</h6>
                        </div>
                        <div class="nav-item">
                            <h6>Analyze Reviews</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-auto features-content">
                    <div class="content-wrap">
                        <div class="inner-container">
                            <div class="swiper contentSwiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="content-with-thumb thumb-right">
                                            <div class="row">
                                                <div class="col-12 col-lg-7 figure-col">
                                                    <figure class="figure">
                                                        <img src="/landing_media/images/features-thumb/feature-thumb1.png" alt="Figure thumb"
                                                             class="figure-img">
                                                    </figure>
                                                </div>
                                                <div class="col-12 col-lg-5 mt-3 mt-md-4 mt-lg-0 content-col">
                                                    <h3>Automate Reviews</h3>
                                                    <p>Request reviews at scale with high-converting templates designed to earn 5-star feedback. No more chasing up customers and asking for their input. The entire process is automated so you can focus on the bigger picture.</p>
                                                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content-with-thumb thumb-right">
                                            <div class="row">
                                                <div class="col-12 col-lg-7 figure-col">
                                                    <figure class="figure">
                                                        <img src="/landing_media/images/features-thumb/feature-thumb2.png" alt="Figure thumb" class="figure-img">
                                                    </figure>
                                                </div>
                                                <div class="col-12 col-lg-5 mt-3 mt-md-4 mt-lg-0 content-col">
                                                    <h3>Publish Reviews</h3>
                                                    <p>
                                                        Stop jumping from one platform to the next trying to build your online reputation. TradieReviews exports reviews where you need them most. Show up where it counts on Google, Facebook, industry directories, and dozens of other key touchpoints.
                                                    </p>
                                                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content-with-thumb thumb-right">
                                            <div class="row">
                                                <div class="col-12 col-lg-7 figure-col">
                                                    <figure class="figure">
                                                        <img src="/landing_media/images/features-thumb/feature-thumb3.png" alt="Figure thumb" class="figure-img">
                                                    </figure>
                                                </div>
                                                <div class="col-12 col-lg-5 mt-3 mt-md-4 mt-lg-0 content-col">
                                                    <h3>Monitor Reviews</h3>
                                                    <p>With TradieReviews, you’re not just listening to feedback, you’re acting on it. Keep track of customer sentiment and guide the conversation towards more leads and higher sales. When a home improvement service secures 5 reviews, the likelihood of a sale grows by 270%.</p>
                                                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content-with-thumb thumb-right">
                                            <div class="row">
                                                <div class="col-12 col-lg-7 figure-col">
                                                    <figure class="figure">
                                                        <img src="/landing_media/images/features-thumb/feature-thumb4.png" alt="Figure thumb"
                                                             class="figure-img">
                                                    </figure>
                                                </div>
                                                <div class="col-12 col-lg-5 mt-3 mt-md-4 mt-lg-0 content-col">
                                                    <h3>Manage Reviews</h3>
                                                    <p>Forget endless passwords and platforms. TradieReviews lets you respond and publish reviews across Google, Facebook, directories, citation sites, and more - all from one simple, user-friendly dashboard.</p>
                                                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="content-with-thumb thumb-right">
                                            <div class="row">
                                                <div class="col-12 col-lg-7 figure-col">
                                                    <figure class="figure">
                                                        <img src="/landing_media/images/features-thumb/feature-thumb5.png" alt="Figure thumb"
                                                             class="figure-img">
                                                    </figure>
                                                </div>
                                                <div class="col-12 col-lg-5 mt-3 mt-md-4 mt-lg-0 content-col">
                                                    <h3>Analyze Reviews</h3>
                                                    <p>Tap into customer sentiment with real-time feedback and performance analysis. Are your customers waiting too long? Frustrated by price? Looking for more after-sales support? Understand the weaknesses in your trade business and plug the gaps.</p>
                                                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="amplify-word-section content-with-thumb pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/amplify-word-thumb.png" alt="Amplify word thumb" class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h6 class="section-label">AMPLIFY WORD OF MOUTH</h6>
                    <h2>Your Customer Feedback Becomes <span class="blue-text">Free Advertising</span></h2>
                    <p>You’re only as successful as your word of mouth. With TradieReviews, your best customers become your most powerful advertising strategy. Satisfied customer voices are amplified at just the right time to generate new leads and drive new business.</p>
                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                    <div class="content-row row">
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/dashboard-icon.png" alt="Dashboard icon" class="icon">
                            </figure>
                            <h5>User-Friendly Dashboard</h5>
                            <p>View and respond to reviews from one simple app. Whether it’s on Google, Facebook, Yelp, or anywhere else online, you’re in control with TradieReviews.</p>
                        </div>
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/exposurrer-icon.png" alt="Exposurrer icon" class="icon">
                            </figure>
                            <h5>10x Your Exposure</h5>
                            <p>You’re in control of where reviews are published. Google, Facebook, or industry-specific review sites - use word of mouth to dominate the online conversation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="automatic-review-section content-with-thumb thumb-right pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/automatic-review-generation-thumb.png" alt="Automatic review thumb"
                             class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h6 class="section-label">AUTOMATIC REVIEW GENERATION</h6>
                    <h2><span class="blue-text">Collect reviews</span> in your sleep</h2>
                    <p>Let TradieReviews do the heavy lifting with automated review requests, filtering, and publishing that take the hassle out of earning reviews. With high-converting templates, all you have to do is point and click. TradieReviews does the rest.</p>
                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                    <div class="content-row row">
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/sleep-icon.png" alt="Sleep icon" class="icon">
                            </figure>
                            <h5>Up Your Customer Service</h5>
                            <p>Getting reviews used to be a hassle. Now it’s a couple of clicks and 30 seconds of your customer’s time. So easy you’ll collect reviews in your sleep.</p>
                        </div>
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/reminder-icon.png" alt="Reminder icon" class="icon">
                            </figure>
                            <h5>Review Reminders</h5>
                            <p>No more awkward emails asking for feedback. TradieReviews automates your requests and reminders to ensure your best customers leave reviews without clogging up your time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="automatic-review-section content-with-thumb">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/bad-review-blocker-thumb.png" alt="Bad review blocker thumb" class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h6 class="section-label">BAD REVIEW BLOCKER</h6>
                    <h2>Capture Negative Reviews to <span class="blue-text">Improve Your Reputation</span></h2>
                    <p>1-star reviews are part of life...but that doesn’t mean they need to be made public. With built-in review filtering, TradieReviews stops negative reviews (1-star or 2-star) from appearing online, while automatically publishing positive feedback.</p>
                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                    <div class="content-row row">
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/reviews-icon.png" alt="Reviews icon" class="icon">
                            </figure>
                            <h5>Reputation Management</h5>
                            <p>Catch negative reviews and 1-star feedback before they go public online. By resolving problems offline, you keep your customers happy and your ratings up.</p>
                        </div>
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/management-icon.png" alt="Management icon" class="icon">
                            </figure>
                            <h5>Reputation Monitoring</h5>
                            <p>Receive alerts and take action when new reviews are posted. Whether it’s sharing high praise, or resolving negative feedback offline, you’re in control of your reputation.</p>
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
                    <h2>Earn 5-star reviews and grow your business without paying a cent.</h2>
                </div>
                <div class="col-12 col-md-auto btn-col ml-md-auto  mt-4 mt-md-0">
                    <a href="/free-trial" class="btn btn--sqr bg-white">Start Free Trial</a>
                </div>
            </div>
        </div>
    </section>
    <section class="customer-sentiment-section content-with-thumb">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 figure-col">
                    <figure class="figure">
                        <img src="/landing_media/images/customer-sentiment-figure.png" alt="Customer sentiment thumb"
                             class="figure-img">
                    </figure>
                </div>
                <div class="col-12 col-md-6 content-col">
                    <h6 class="section-label">CUSTOMER SENTIMENT TRACKING</h6>
                    <h2>Use real-time customer feedback to <span class="blue-text">drive more sales </span> at higher prices</h2>
                    <p>Track positive, negative, and neutral feedback to figure out how your customers are feeling. Improve your trade, home improvement, or contractor business using real-time data and insights from the people who matter most.</p>
                    <a href="/free-trial" class="btn btn-primary btn--sqr">Start Free Trial</a>
                    <div class="content-row row">
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/increrase-icon.png" alt="Increrase icon" class="icon">
                            </figure>
                            <h5>Increase Average Sales</h5>
                            <p>Customers spend 31% more when reading positive reviews. With TradieReviews you turn customers and clients into revenue generators.</p>
                        </div>
                        <div class="col-12 col-lg-6 content-item">
                            <figure class="figure">
                                <img src="/landing_media/images/notifications-icon.png" alt="Notifications icon" class="icon">
                            </figure>
                            <h5>Instant Notifications</h5>
                            <p>Never let a negative review fall through the cracks. Receive instant alerts and engage with customers to resolve problems and turn frowns into fans.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonial-section" style="display:none;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-wrap">
                        <div class="swiper-container testimonial-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide text-center">
                                    <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies <span class="blue-text">ultricies dui, a hendrerit nunc</span>lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                    </h3>
                                    <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                </div>
                                <div class="swiper-slide text-center">
                                    <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies <span
                                                class="blue-text">ultricies dui, a hendrerit nunc</span>
                                        lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                    </h3>
                                    <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                </div>
                                <div class="swiper-slide text-center">
                                    <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies <span
                                                class="blue-text">ultricies dui, a hendrerit nunc</span>
                                        lacinia vitae. Nam iaculis velit vel iaculis convallis. Fusce lectus purus, volutpat.
                                    </h3>
                                    <h5>– Full Name, Co-Founder & CEO, Parvenu</h5>
                                </div>
                                <div class="swiper-slide text-center">
                                    <h3>nteger efficitur eget magna vel mollis. Vivamus ultricies <span
                                                class="blue-text">ultricies dui, a hendrerit nunc</span>
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
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="true" aria-controls="collapse-1">Who should use TradieReviews?
                                        </button>
                                    </h6>
                                </div>

                                <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                     data-parent="#faqsAccordion">
                                    <div class="card-body">
                                        TradieReviews is suitable for any trade, home improvement, or contractor business. Whether you run a brick-and-mortar store or provide a service, you’re judged on your track record. 7 out of 10 customers won’t take action until they’ve read reviews and TradieReviews ensures new customers find nothing but high praise when researching your business online.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading-2">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">What is reputation management?</button>
                                    </h6>
                                </div>
                                <div id="collapse-2" class="collapse" aria-labelledby="heading-2"
                                     data-parent="#faqsAccordion">
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
                                <div id="collapse-3" class="collapse" aria-labelledby="heading-3"
                                     data-parent="#faqsAccordion">
                                    <div class="card-body">
                                        No. Choose from a monthly subscription or pay annually to receive a discounted rate. However you choose to use TradieReviews, you can leave anytime without being stuck or forced to stick around.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="heading-4">
                                    <h6 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-4" aria-expanded="false" aria-controls="collapse-4">Does TradieReviews help my business in any other way?</button>
                                    </h6>
                                </div>
                                <div id="collapse-4" class="collapse" aria-labelledby="heading-4"
                                     data-parent="#faqsAccordion">
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
    <section class="free-trial-section" id="free-trial-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-auto content-col">
                    <h6 class="section-label">TRY TRADIEREVIEWS FOR FREE</h6>
                    <h2>Earn 5-star reviews and grow your business without paying a cent.</h2>
                </div>
                <div class="col-12 col-md-auto btn-col ml-md-auto  mt-4 mt-md-0">
                    <a href="/free-trial" class="btn btn--sqr bg-white">Start Free Trial</a>
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
                        <img src="/landing_media/images/step-icon-1.png" alt="Step icon">
                    </figure>
                    <h3>STEP 01</h3>
                    <p>Add your social profiles (Google Maps and Facebook).</p>
                </div>
                <div class="col-12 col-md-4 step-item">
                    <figure class="figure">
                        <img src="/landing_media/images/step-icon-2.png" alt="Step icon">
                    </figure>
                    <h3>STEP 02</h3>
                    <p>Share your review link with your customers.</p>
                </div>
                <div class="col-12 col-md-4 step-item">
                    <figure class="figure">
                        <img src="/landing_media/images/step-icon-3.png" alt="Step icon">
                    </figure>
                    <h3>STEP 03</h3>
                    <p>Get more positive reviews for your business!</p>
                </div>
            </div>
        </div>
    </section>
    <section class="pricing-section" id="pricing">
        <div class="container text-center">
            <h6 class="section-label">Pricing</h6>
            <h2>Simple, transparent <span class="blue-text">Pricing</span></h2>
            <div class="inner-container">
                <div class="row pricing-card-row text-left">
                    <div class="col-12 col-md-6 pricing-card-item">
                        <div class="widget-box">
                            <div class="title-wrap d-flex align-items-center">
                                <div class="figure d-flex">
                                    <img src="/landing_media/images/star-icon.png" alt="Ster icon" class="icon">
                                </div>
                                <h3>Monthly Starter</h3>
                            </div>
                            <h2 class="price">{{ $currency == 'usd' ? '$79.00' : 'AUD 97.00' }} <span>/ month</span></h2>
                            <ul class="list-items feature-list">
                                <li>Explode your online word of mouth</li>
                                <li>Turn reviews into FREE advertising</li>
                                <li>Send high-converting review requests</li>
                                <li>Generate 5-star reviews 24/7</li>
                                <li>Collect Reviews In Your Sleep</li>
                            </ul>
                            <a href="/free-trial" class="btn btn-primary btn--sqr">Choose Plan</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 pricing-card-item">
                        <div class="widget-box">
                            <div class="title-wrap d-flex align-items-center">
                                <div class="figure d-flex">
                                    <img src="/landing_media/images/3star-with-thumb.png" alt="Ster icon" class="icon">
                                </div>
                                <div class="title-col">
                                    <h3>Yearly Professional</h3>
                                </div>
                            </div>
                            <h2 class="price">{{ $currency == 'usd' ? '$758.00' : 'AUD 931.20' }}<span>/ year</span></h2>
                            <ul class="list-items feature-list">
                                <li>Explode your online word of mouth</li>
                                <li>Turn reviews into FREE advertising</li>
                                <li>Send high-converting review requests</li>
                                <li>Generate 5-star reviews 24/7</li>
                                <li>Collect Reviews In Your Sleep</li>
                            </ul>
                            <a href="/free-trial" class="btn btn-primary btn--sqr">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="feature-list-section" id="features_review">
        <div class="container">
            <h6 class="section-label">FeatuRe list</h6>
            <h2>Browse <span class="blue-text">Features</span></h2>
            <ul class="list-items">
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/monitoring-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Review Monitoring</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/manage-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Reputation Management</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/instant-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Instant Notifications</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/layout-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Personalized Templates</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/negative-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Negative Review Blocking</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/generation-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Review Generation</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/google-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Google Reviews</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/reminder-calendar-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Auto-Reminders</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/performance-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Performance Insights</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/distribution-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Smart Distribution</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/filtering-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Review Filtering</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/facebook-icon-blue.png" alt="list icon" class="icon">
                        </figure>
                        <span>Facebook Reviews</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/follow-up-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Review Follow-Up</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/integrartionns-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>App Integrations</span>
                    </div>
                </li>
                <li>
                    <div class="list-content">
                        <figure class="figure">
                            <img src="/landing_media/images/list-dashboard-icon.png" alt="list icon" class="icon">
                        </figure>
                        <span>Anywhere Dashboard</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="tradiereview-section" id="tradieflow">
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12 text-center">--}}
{{--                    <div class="inner-container">--}}
{{--                        <h6 class="section-label">TradieReviews</h6>--}}
{{--                        <h2>--}}
{{--                            Tradie<span class="green-text">Flow</span> + Tradie<span class="blue-text">Reviews</span> = Your Business on <span class="blue-text">Autopilot</span>--}}
{{--                        </h2>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="row widget-row">--}}
{{--                <div class="col-12 col-md-6">--}}
{{--                    <div class="widget-box">--}}
{{--                        <figure class="figure">--}}
{{--                            <img src="/landing_media/images/time-icon.png" alt="Widget icon" class="icon">--}}
{{--                        </figure>--}}
{{--                        <h3>Slash 20+ hours of weekly admin</h3>--}}
{{--                        <p>Is paperwork not working for you? With our suite of tools, you can automate your time-sucking tasks and do more of what you.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6">--}}
{{--                    <div class="widget-box">--}}
{{--                        <figure class="figure">--}}
{{--                            <img src="/landing_media/images/money-icon.png" alt="Widget icon" class="icon">--}}
{{--                        </figure>--}}
{{--                        <h3>Save thousands of dollars a year</h3>--}}
{{--                        <p>Stop juggling dozens of apps and software that only make your life harder. Combine our tools to work faster and smarter, while paying.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6">--}}
{{--                    <div class="widget-box">--}}
{{--                        <figure class="figure">--}}
{{--                            <img src="/landing_media/images/adv-icon.png" alt="Widget icon" class="icon">--}}
{{--                        </figure>--}}
{{--                        <h3>Unlock the power of free advertising</h3>--}}
{{--                        <p>Every 5-star review acts as an ad for your business. The more reviews you earn, the easier it is to land a new customer.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6">--}}
{{--                    <div class="widget-box">--}}
{{--                        <figure class="figure">--}}
{{--                            <img src="/landing_media/images/anywhere-icon.png" alt="Widget icon" class="icon">--}}
{{--                        </figure>--}}
{{--                        <h3>Run your business from ANYWHERE</h3>--}}
{{--                        <p>At home, at work, at the beach - with our tools you can automate your workflow from securing a lead to earning a glowing review.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row sharing-row" id="integrations">
                <div class="col-12">
                    <h2>Your <span class="blue-text">Favorite Integrations</span> to Unleash the Power of Reviews</h2>
                    <div class="review-icons-wrap owl-carousel d-md-flex align-items-center justify-content-center">
                        <div class="icon-item">
                            <img src="/landing_media/images/gmail-icon.png" alt="Gmail icon" class="icon">
                        </div>
                        <div class="icon-item">
                            <img src="/landing_media/images/apple-icon.png" alt="Apple icon" class="icon">
                        </div>
                        <div class="icon-item">
                            <img src="/landing_media/images/facebook-icon.png" alt="Facebook icon" class="icon">
                        </div>
                        <div class="icon-item">
                            <img src="/landing_media/images/google-poly-icon.png" alt="Google icon" class="icon">
                        </div>
                        <div class="icon-item">
                            <img src="/landing_media/images/xero-icon.png" alt="Xero icon" class="icon">
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
                    <h2>Earn 5-star reviews and grow your business without paying a cent.</h2>
                </div>
                <div class="col-12 col-md-auto ml-md-auto btn-col mt-4 mt-md-0">
                    <a href="/free-trial" class="btn btn--sqr bg-white">Start Free Trial</a>
                </div>
            </div>
        </div>
    </section>
    @include('elements.footer',['hide_footer' => false])
</main>
@endsection
@section('view_script')
<script type="text/javascript" src="/js/owl.carousel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var mainHeader = $('header.main-header');
        var headerHeight = mainHeader.outerHeight();

        $(document).on('click','.navbar-toggler',function(){
            mainHeader.toggleClass("navExpanded");
            return false;
        });

        if ($(window).width() > 991) {
            mainHeader.clone().insertAfter(mainHeader).addClass("sticky-header");
        }

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

        $(window).on('scroll', function () {
            if ($('.sticky-header').length && $(window).scrollTop() > headerHeight + 100) {
                $('.sticky-header').addClass('fixedTop');
            } else {
                $('.sticky-header').removeClass('fixedTop');
            }

            //
            var header = document.getElementById('main_header');
            var sticky = header.offsetTop;
            var takeOffset = window.pageYOffset + 50;
            if (takeOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }

            $('.nav-item').removeClass('active');
            if (takeOffset < $('#about').offset().top) {
                $('.nav-link[href="/#home"]').parent().addClass('active');
            }
            else if(takeOffset > $('#about').offset().top && takeOffset < $('#faqs').offset().top) {
                $('.nav-link[href="/#about"]').parent().addClass('active');
            }
            else if(takeOffset > $('#faqs').offset().top && takeOffset < $('#free-trial-section').offset().top) {
                $('.nav-link[href="/#faqs"]').parent().addClass('active');
            }
            else if(takeOffset > $('#pricing').offset().top && takeOffset < $('#features_review').offset().top) {
                $('.nav-link[href="/#pricing"]').parent().addClass('active');
            }
            else if (takeOffset > $('#tradieflow').offset().top){
                $('.nav-link[href="/#integrations"]').parent().addClass('active');
            }
        });

        $(document).on('click','.nav-link',function(e){
            e.preventDefault();
            $('.navbar-toggler').trigger('click');
            var id = $(this).attr('href').substring(1);
            var top = $(id).offset().top;
            var parent_obj = $(this).parent();
            $('.nav-item').not(parent_obj).removeClass('active');
            parent_obj.addClass('active');
            if (id == '#integrations') {
                top -= 150;
            }
            $('body,html').animate({
                scrollTop: top
            }, 1500);
            return false;
        });


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
    });

    var menu = ['Automate Reviews', 'Publish Reviews', 'Monitor Reviews', 'Manage Reviews', 'Analyze Reviews'];
    var contentSwiper = new Swiper('.contentSwiper', {
        loop: true,
        spaceBetween: 10,
        pagination: {
            el: '.features-nav .nav-items',
            clickable: true,
            renderBullet: function (index, className) {
                return '<div class="nav-item ' + className + '"><h6>' + (menu[index]) + '</h6></div>';
            },
        },
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
</script>
@endsection
