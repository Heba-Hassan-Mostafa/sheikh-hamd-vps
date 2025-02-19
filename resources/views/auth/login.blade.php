@extends('backend.layouts.master2')
@section('css')
    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{ asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}" rel="stylesheet">
@endsection
@section('title')
    Login
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p mx-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                        <img src="{{ asset('Files/login/login.svg') }}"
                            class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
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
                                <div class="card-sigin">
                                    <div class="mb-5 d-flex justify-content-center">
                                        <a href="{{ route('admin.login.show', 'admin') }}">
                                            <img src="{{ asset('Files/settings/'.setting()->icon) }}"
                                                class="sign-favicon" alt="logo"  style="height:300px">
                                        </a>
                                        {{-- <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">{{ config('app.name') }}</h1> --}}
                                    </div>
                                    <div class="card-sigin">
                                        <div class="main-signup-header text-left" style="direction: ltr">
                                            {{-- <h5 class="font-weight-semibold mb-4">Please sign in to continue.</h5> --}}
                                            <form action="{{ route('login') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="hidden" name="type" value="{{ $type }}">
                                                    <input name="email" class="form-control"
                                                        placeholder="Enter your Email" type="email">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input name="password" class="form-control"
                                                        placeholder="Enter your password" type="password">
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>

                                                <div class="form-group ">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox" name="remember"
                                                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <label class="custom-control-label text-small" for="remember">
                                                            Remember Me
                                                        </label>

                                                    </div>
                                                </div>
                                                <button type="submit" name="signin"
                                                    class="btn btn-main-primary btn-block">Sign In</button>
                                            </form>
                                            <div class="main-signin-footer mt-1">
                                                <p><a href="{{ route('admin.password.request') }}">Forgot password?</a></p>
                                            </div>
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
