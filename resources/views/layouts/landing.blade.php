<!DOCTYPE html>
<html lang="en">
<head>
    @if(env('APP_ENV') !== 'local')
        @include('elements.seo.google_tag_manager')
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The easiest way to get more reviews for your trade, contractor or home improvement business. FREE Trial. Start generating five star reviews today!">
    <meta name="keywords" content="Tradie Reviews, Get More Reviews, Get Online Reviews">
    @yield('meta_tags')
    <title>TradieReviews: Get More Reviews For Your Tradie Business</title>
    <link rel="shortcut icon" href="/favicon-icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-icons/favicon-16x16.png">
    <link rel="manifest" href="/favicon-icons/site.webmanifest">
{{--    @if(env('APP_ENV') == 'local')--}}
{{--        <link rel="stylesheet" href="/landing_media/css/main.css">--}}
{{--    @else--}}
{{--        <link rel="stylesheet" href="/landing_media/css/main.css">--}}
{{--    @endif--}}
    <link rel="stylesheet" href="/landing_media/css/main.css">
    <link rel="stylesheet" href="{{ $app_cdn_url }}/js/noty/noty.css">
    @include('elements.seo.inspectlet_code')
</head>
<body>
@if(env('APP_ENV') !== 'local')
    @include('elements.seo.google_tag_manager_no_script')
@endif
@yield('content')
<script type="text/javascript" src="{{ $app_cdn_url }}/js/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="{{ $app_cdn_url }}/js/popper.min.js"></script>
<script type="text/javascript" src="{{ $app_cdn_url }}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ $app_cdn_url }}/landing_media/js/swiper-bundle.min.js"></script>
<script type="text/javascript" src="{{ $app_cdn_url }}/js/noty/noty.min.js"></script>
@yield('view_script')
@yield('view_script_ext')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
</body>
</html>
