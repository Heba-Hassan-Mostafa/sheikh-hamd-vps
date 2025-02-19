@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="البث,المرئى,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,مرئى">
<meta name="description" content="البث المرئى  للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.live-tube') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt=" {{ trans('frontend.live-tube') }}" title=" {{ trans('frontend.live-tube') }}"/>
    </div>
    <!-- contact Us content -->
    <div class="libraryPage">
        <h1 class="text-center">{{ trans('frontend.live') }}</h1>
        <div class="row align-items-center libBox">
            <div class="embeedVideo">
                @if(!empty($live->live_link))
                <?php
                $url = getYoutubeId($live->live_link)
                ?>
                  @if($url)
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $url }}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                    @endif
                    @else
                    <h6 class="alram-text"> {{ trans('frontend.no-live') }} </h6>
                    @endif
            </div>
        </div>
    </div>
    <!-- start login form -->
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
