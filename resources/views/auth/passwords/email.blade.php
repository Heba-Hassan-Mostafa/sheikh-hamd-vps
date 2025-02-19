@extends('backend.layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{ asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('title')
Forgot Password
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{ asset('Files/login/forgot-password.svg')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
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
                                    <a href="{{ route('admin.password.request') }}">
                                        <img src="{{ asset('Files/settings/'.setting()->icon) }}"
                                        class="sign-favicon" alt="logo"  style="height:300px">
                                    </a>
                                </div>
                                        <div class="main-card-signin d-md-flex bg-white text-left">
										<div class="wd-100p">
											<div class="main-signin-header">
												<h2>! Forgot Password</h2>
												<h4>Please Enter Your Email</h4>
												<form action="{{ route('admin.password.email') }}" method="POST">
                                                    @csrf
													<div class="form-group">
														<label>Email</label>
                                                        <input style="direction: ltr" name="email" type="email" class="form-control" placeholder="Enter your Email" >
                                                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror

                                                    </div>
													<button type="submit" name=" send" class="btn btn-main-primary btn-block">Send</button>
												</form>
											</div>
											<div class="main-signup-footer mg-t-20">
												<p>Forget it, <a href="{{ route('admin.login.show','admin') }}"> Send me back</a> to the sign in screen.</p>
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
