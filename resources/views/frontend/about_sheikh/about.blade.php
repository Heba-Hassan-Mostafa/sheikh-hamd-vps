@extends('frontend.design.master')
@section('css')
@endsection
@section('title')
{{ trans('frontend.about') }}
@endsection
@section('content')

<!-- start about Dr content -->
<div class="aboutDr">
    <div class="shadow-head">
      <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.about-doc') }}"
      title="{{ trans('frontend.about-doc') }}"/>
    </div>
    <div class="aboutDrContent">
      <h1 class="text-center">{{ trans('frontend.about-doc') }}</h1>
      <p>
                {!! setting()->about_sheikh !!}


    </p>
    </div>
    <div class="shadow-head">
      <img class="shadow-img img-shadow-down" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.about-doc') }}"
      title="{{ trans('frontend.about-doc') }}" />
    </div>
  </div>
  <!-- end about Dr content -->

@endsection
@section('script')
<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
