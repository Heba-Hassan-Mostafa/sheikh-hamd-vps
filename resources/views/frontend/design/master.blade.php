<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="" name="twitter:site">
    <meta content="" name="twitter:creator">
    <meta content="" property="fb:pages">
    <meta content="" property="fb:app_id">
    <meta content="" property="fb:admins">
    <meta name="twitter:card" content="summary">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/">
    @yield('meta')
    @include('frontend.design.head')
    @include('feed::links')


       <!-- Global site tag (gtag.js) - Google Analytics -->
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-GBHXKBN92Y"></script>-->
<!--<script>-->
<!--  window.dataLayer = window.dataLayer || [];-->
<!--  function gtag(){dataLayer.push(arguments);}-->
<!--  gtag('js', new Date());-->

<!--  gtag('config', 'G-GBHXKBN92Y');-->
<!--</script>-->
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-GF11LFKH80"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-GF11LFKH80');
</script>

    <title>@yield('title')</title>
{{--     {!! RecaptchaV3::initJs() !!}--}}
</head>

<body>
    <?php
    $visitor =App\Models\Visitor::orderBy('id','desc')->first();
    $visitor->increment('visitor_count');

    ?>

    <div class="loader"></div>
    <div class="layout container bg-white">

        @include('frontend.design.nav')

        @yield('content')


        @include('frontend.design.footer')

    </div>

    @include('frontend.design.footer-script')
</body>

</html>
