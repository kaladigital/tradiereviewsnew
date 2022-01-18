<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TradieReviews | Reviews</title>
    <link rel="shortcut icon" href="/favicon-icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-icons/favicon-16x16.png">
    <link rel="manifest" href="/favicon-icons/site.webmanifest">
    <link rel="stylesheet" href="/js/select2/css/select2.min.css">
    <link rel="stylesheet" href="/js/noty/noty.css">
    <link rel="stylesheet" href="/css/main.css?v={{ Carbon\Carbon::now()->timestamp }}">
</head>
<body>
<main class="main">
    <header class="secondary-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-12 col-lg-auto mx-auto">
                    <div class="logo-wrap d-flex align-items-center">
                        <div class="logo-figure">
                            @if($user->reviews_logo)
                                <img src="/review-logo/{{ $user->reviews_logo }}" alt="Company logo" class="company-logo">
                            @else
                                <img src="/images/company-logo.png" alt="Company logo" class="company-logo">
                            @endif
                        </div>
                        @if($user->reviews_company_name || $user->invoice_company_name)
                            <h2 class="company-name">
                                {{ $user->reviews_company_name ? $user->reviews_company_name : $user->invoice_company_name }}
                            </h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="content-body secondary-content-body thank-you were-sorry">
        <form>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>
                            We are sorry! We are unable to process your review because {{ $user->name }}’s subscription expired
                            in our system.
                        </h2>
                        <h3>We hope that we will soon meet again here!</h3>
                        <div class="figure">
                            <img src="/images/thank-you-figure.svg" alt="Thank you">
                        </div>
                        <h2 class="thank-you-text" data-title="Have a great day">Have a great day</h2>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>
