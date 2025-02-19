@extends('backend.layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{ asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('title')
Reset Password
@endsection
@section('content')
<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
            <div class="row wd-100p mx-auto text-center">
                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                    <img src="{{ asset('Files/login/reset-password.svg')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
                </div>
            </div>
        </div>
        <!-- The content half -->
        <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
            <div class="login d-flex align-items-center py-2">
                <!-- Demo content-->
                <div class="container p-0">
                    <div class="row">
                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                            <div class="mb-5 d-flex justify-content-center">
                                    <img src="{{ asset('Files/settings/'.setting()->icon) }}"
                                    class="sign-favicon" alt="logo"  style="height:300px">
                            </div>
                                <div class="main-card-signin d-md-flex bg-white text-left">
                                <div class="wd-100p">
                                    <div class="main-signin-header">
                                        <h2>! Reset Password</h2>
                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                            <label for="email">{{ __('Email Address') }}</label>
                            <div class="form-group">
                                <input style="direction: ltr" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            <label for="password">{{ __('Password') }}</label>

                            <div class="form-group">
                                <input style="direction: ltr" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <label for="password-confirm">{{ __('Confirm Password') }}</label>

                            <div class="form-group">
                                <input style="direction: ltr" id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>


                            <div>
                                <button type="submit" class="btn btn-main-primary btn-block">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</div><!-- End -->
</div>
</div><!-- End -->
</div>
</div>
@endsection
@section('js')
@endsection

