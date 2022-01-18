<!DOCTYPE html>
<html lang="en">
<head>
    @if(env('APP_ENV') !== 'local')
        @include('elements.seo.google_tag_manager')
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="The easiest way to get more reviews for your trade, contractor or home improvement business. FREE Trial. Start generating five star reviews today!">
    <meta name="keywords" content="Tradie Reviews, Get More Reviews, Get Online Reviews">
    <title>TradieReviews: Get More Reviews For Your Tradie Business</title>
    <link rel="shortcut icon" href="/favicon-icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-icons/favicon-16x16.png">
    <link rel="stylesheet" href="/css/main.css?v={{ Carbon\Carbon::now()->timestamp }}">
    <link rel="stylesheet" href="/js/noty/noty.css">
    @include('elements.seo.inspectlet_code')
</head>
<body>
@if(env('APP_ENV') !== 'local')
    @include('elements.seo.google_tag_manager_no_script')
@endif
@yield('content')
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/noty/noty.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
@yield('view_script')
@yield('view_script_ext')
@if(env('APP_ENV') != 'local')
<script>
    // // This will initiate Upscope connection. It's important it is added to all pages, even when the user is not logged in.
    // (function(w, u, d){var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};var l = function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://code.upscope.io/3TNBfi4H6Z.js';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(typeof u!=="function"){w.Upscope=i;l();}})(window, window.Upscope, document);
    //
    // Upscope('init');
</script>

<script>
    // // If the user is logged in, optionally identify them with the following method.
    // // You can call Upscope('updateConnection', {}); at any time.
    // Upscope('updateConnection', {
    //     // Set the user ID below. If you don't have one, set to undefined.
    //     uniqueId: "USER UNIQUE ID",
    //
    //     // Set the user name or email below (e.g. ["John Smith", "john.smith@acme.com"]).
    //     identities: ["list", "of", "identities", "here"]
    // });
</script>
@endif
</body>
</html>
