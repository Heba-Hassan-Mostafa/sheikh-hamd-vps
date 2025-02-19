@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="البث,الصوتى,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,صوتى">
<meta name="description" content="البث الصوتي للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">

<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.live-sound') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.live-sound') }}" title="{{ trans('frontend.live-sound') }}" />
    </div>

    <div class="libraryPage">
        <h1 class="text-center">  {{ trans('frontend.live') }}</h1>
        <div class="row align-items-center libBox">
            <div class="live-air">
                <iframe src="https://mixlr.com/users/8885383/embed" width="100%" height="180px" scrolling="no" frameborder="no" marginheight="0" marginwidth="0">
                </iframe>
                <small>
                    <a rel="nofollow" href="https://mixlr.com/drhamadalhajri" style="color:#1a1a1a;text-align:left; font-family:Helvetica, sans-serif; font-size:11px;">
                    </a>
                </small>
            </div>
        </div>
      </div>
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
