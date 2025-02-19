@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="البث,المرئى,الصوتى,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,مرئى">
<meta name="description" content="البث المرئى والصوتى للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.live') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt=" {{ trans('frontend.live') }}" title=" {{ trans('frontend.live') }}"/>
    </div>
  <!-- contact Us content -->
  <div class="libraryPage">
    <h1 class="text-center">{{ trans('frontend.live') }}</h1>
    <div class="row align-items-center libBox">
      <div class="videoSvg text-center col-md-6">
        <div>
          <img src="{{ asset('frontend/img/videoAir.svg') }}" alt="{{ trans('frontend.live-tube') }}" title="{{ trans('frontend.live-tube') }}"/>
          <a href="{{ route('frontend.live-tube') }}" class="d-block main-btns" title="{{ trans('frontend.live-tube') }}"> {{ trans('frontend.live-tube') }}</a>
        </div>
      </div>
      <div class="audioSvg text-center col-md-6">
        <img src="{{ asset('frontend/img/audioAir.svg') }}" alt="{{ trans('frontend.live-sound') }}" title="{{ trans('frontend.live-sound') }}"/>
        <a href="{{ route('frontend.live-sound') }}" class="d-block main-btns" title="{{ trans('frontend.live-sound') }}"> {{ trans('frontend.live-sound') }} </a>
      </div>
    </div>
  </div>
  @endsection
  @section('script')
      <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
  @endsection
