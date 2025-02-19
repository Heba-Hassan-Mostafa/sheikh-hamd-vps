@extends('frontend.design.master')
@section('css')
@endsection
@section('title')
    {{ trans('frontend.reset-pass') }}
@endsection
@section('content')
<div class="row m-0 loginForm">
    <div class="col-md-5 loginFormBox">
        <h1>{{ trans('frontend.reset-pass') }}</h1>

        <img src="{{ asset('frontend/img/login.svg') }}" alt=" {{ trans('frontend.reset-pass') }}" title=" {{ trans('frontend.reset-pass') }}"/>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
            @error('email')
            <span class="text-danger">{{ $message }}</span>
         @enderror
         <input class="form-control" type="password" name="password" placeholder="{{ trans('clients.password') }}" />
         @error('password')
                 <span class="text-danger">{{ $message }}</span>
               @enderror
         <input class="form-control" type="password" name="password_confirmation"  placeholder=" {{ trans('clients.pass-confirm') }}" />
         @error('password_confirmation')
                 <span class="text-danger">{{ $message }}</span>
               @enderror

        <button class="main-btns" {{ trans('frontend.send') }}>{{ trans('frontend.send') }}</button>
        </form>
    </div>
</div>
@endsection
@section('script')
<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

@endsection
