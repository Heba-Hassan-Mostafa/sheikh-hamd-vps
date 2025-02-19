@extends('frontend.design.master')
@section('css')
@endsection
@section('title')
    {{ trans('frontend.forget-pass') }}
@endsection
@section('content')
<div class="shadow-head">
    <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.forget-pass') }}" title="{{ trans('frontend.forget-pass') }}"/>
</div>

<div class="row m-0 loginForm">
    <div class="col-md-5 loginFormBox">
        <h1>{{ trans('frontend.forget-pass') }}</h1>

        <img src="{{ asset('frontend/img/login.svg') }}" alt="{{ trans('frontend.forget-pass') }}" title="{{ trans('frontend.forget-pass') }}"/>
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <h4>{{ trans('frontend.enter-email') }}</h4>
            <input class="form-control" type="email" name="email" placeholder="{{ trans('clients.email') }}" />
            @error('email')
            <span class="text-danger">{{ $message }}</span>
         @enderror
         <div class="main-signup-footer mg-t-20">
            <p> <a href="{{ route('login.show','client') }}" title="{{ trans('frontend.login-back') }}"> {{ trans('frontend.login-back') }}</a></p>
        </div>
        <button class="main-btns" title="{{ trans('frontend.send') }}">{{ trans('frontend.send') }}</button>
        </form>
    </div>
</div>

@endsection
@section('script')
<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

@endsection
