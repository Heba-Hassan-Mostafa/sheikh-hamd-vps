@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="المكتبة,المرئية,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,صوتية,مرئية,تحميل">
<meta name="description" content="المكتبة المرئية والمكتبة الصوتية للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.library') }}
@endsection
@section('content')

<div class="shadow-head">
    <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.library') }}" title="   {{ trans('frontend.library') }}"/>
  </div>
  <!-- contact Us content -->
  <div class="libraryPage">
    <h1 class="text-center"> {{ trans('frontend.library') }}</h1>
    <div class="row align-items-center libBox">
      <div class="videoSvg text-center col-md-6">
        <div>
          <img style="max-width:47%" src="{{ asset('frontend/img/VideoPage.svg') }}" alt="{{ trans('frontend.video-library') }}" title="{{ trans('frontend.video-library') }}"/>
          <a href="{{ route('frontend.library.videos') }}" class="d-block main-btns" title="{{ trans('frontend.video-library') }}">  {{ trans('frontend.video-library') }}</a>
        </div>
      </div>
      <div class="audioSvg text-center col-md-6">
        <img src="{{ asset('frontend/img/VoicePage.svg') }}" alt="{{ trans('frontend.audio-library') }}" title="{{ trans('frontend.audio-library') }}"/>
        <a href="{{ route('frontend.audio-library.audio') }}" class="d-block main-btns" title="{{ trans('frontend.audio-library') }}">{{ trans('frontend.audio-library') }} </a>
      </div>
    </div>
  </div>
@endsection
@section('script')

<script defer src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
<script defer src="{{ asset('frontend/js/lg-autoplay.min.js') }}"></script>
<script defer src="{{ asset('frontend/js/light.js') }}"></script>

<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
