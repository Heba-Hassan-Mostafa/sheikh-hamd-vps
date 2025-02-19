@extends('frontend.design.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" rel="stylesheet"/>
@endsection
@section('title')
    {{ trans('frontend.login') }}
@endsection
@section('content')
    <div class="shadow-head">
        <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt=" {{ trans('frontend.login') }}" title=" {{ trans('frontend.login') }}" />
    </div>

    <div class="row m-0 loginForm">
        <div class="col-md-5 loginFormBox">
            <h1>{{ trans('frontend.login') }}</h1>
            <img src="{{ asset('frontend/img/login.svg') }}" alt=" {{ trans('frontend.login') }}" title=" {{ trans('frontend.login') }}"/>
            <div class="loginWithSocial">
                    <a href="{{ url('redirect/facebook') }}" class="btn btn-primary">
                        {{ trans('frontend.facebook_login') }}
                        <i class="fab fa-facebook-f"></i>
                    </a> 
                    <a href="{{ url('redirect/google') }}" class="btn btn-danger">
                         {{ trans('frontend.google_login') }}
                        <i class="fab fa-google-plus-g"></i>
                    </a> 
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input class="form-control" type="email" name="email" placeholder="{{ trans('clients.email') }}" />
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                 @enderror
                <input class="form-control" type="password" name="password" placeholder="{{ trans('clients.password') }}" />
                @error('password')
                 <span class="text-danger">{{ $message }}</span>
                     @enderror
                <a href="{{ route('password.request') }}" title="{{ trans('frontend.forget-pass') }}"> {{ trans('frontend.forget-pass') }}</a>
                <button class="main-btns" title="{{ trans('frontend.login') }}">{{ trans('frontend.login') }}</button>
            </form>
        </div>
        <div class="col-md-5 signFormBox">
            <h2> {{ trans('frontend.register') }}</h2>
            <img src="{{ asset('frontend/img/sign.svg') }}" alt="{{ trans('frontend.register') }}"  title="{{ trans('frontend.register') }}"/>
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <input class="form-control" type="text" name="first_name" placeholder="{{ trans('clients.fname') }}" />
                @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                <input class="form-control" type="text" name="last_name" placeholder="{{ trans('clients.lname') }}" />
                @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                <input class="form-control" type="email" name="email" placeholder="{{ trans('clients.email') }}" />
                @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror



                <input id="phone_number" type="tel" name="phone[main]"  class="form-control tel" placeholder="{{ trans('clients.phone') }}">
                @error('phone')
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
                <button class="main-btns" title="{{ trans('frontend.register') }}"> {{ trans('frontend.register') }}</button>
            </form>
        </div>
    </div>

    <!-- start login form -->
@endsection
@section('script')
<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script>
        var phone_number = window.intlTelInput(document.querySelector("#phone_number"), {
        separateDialCode: true,
        preferredCountries:["kw"],
        hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
        });

        $("#tel_form").submit(function() {
        var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[name='phone[full]'").val(full_number);
        alert(full_number);
});
</script>

@endsection
