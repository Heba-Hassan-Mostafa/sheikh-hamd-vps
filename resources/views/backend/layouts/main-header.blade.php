<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item printPage ">
				<div class="container-fluid printPage ">
					<div class="main-header-left ">
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
					</div>
					<div class="main-header-right">
                        <div class="btn-group mb-1">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              @if (App::getLocale() == 'ar')
                              {{ LaravelLocalization::getCurrentLocaleName() }}
                             <img src="{{ URL::asset('Files/image/flags/KW.png') }}" alt="">
                              @else
                              {{ LaravelLocalization::getCurrentLocaleName() }}
                              <img src="{{ URL::asset('Files/image/flags/US.png') }}" alt="">
                              @endif
                              </button>
                            <div class="dropdown-menu">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                @endforeach
                            </div>
                        </div>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" role="search">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Search">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>


							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href="">
                                    @if(!empty(auth()->user()->image))
                                    <img alt="user-img" class="" src="{{ asset('Files/users/'.auth()->user()->image) }}">
                                    @else
                                    <img alt="" src="{{URL::asset('assets/img/faces/6.jpg')}}" class="">
                                    @endif
                                </a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user">
                                                @if(auth()->user()->image != '')
                                                    <img alt="user-img" class="" src="{{ asset('Files/users/'.auth()->user()->image) }}">
                                                    @else
                                                    <img alt="" src="{{ asset('assets/img/faces/6.jpg') }}" class="">
                                                    @endif
                                            </div>
											<div class="mr-3 my-auto">
												<h6>{{ auth()->user()->full_name }}</h6><span></span>
											</div>
										</div>
									</div>
									@can('Users-Informations')
									<a class="dropdown-item" href="{{ route('admin.users.profile') }}"><i class="bx bx-user-circle"></i>{{ trans('main_sidebar.profile') }}</a>
									@endcan
									@can('Users-Change-Password')
									<a class="dropdown-item" href="{{ route('admin.users.change-password') }}"><i class="bx bx-cog"></i>{{ trans('main_sidebar.change-pass') }}</a>
									@endcan
									@can('Settings-List')
									<a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bx bx-cog"></i>{{ trans('main_sidebar.settings') }}</a>
									@endcan
									@can('Reports-List')
									<a class="dropdown-item" href="{{ route('admin.reports') }}"><i class="bx bx-cog"></i>{{ trans('main_sidebar.reports') }}</a>
									@endcan
									@can('Activity-Log-List')
									<a class="dropdown-item" href="{{ route('admin.activity-log') }}"><i class="bx bx-cog"></i>{{ trans('setting.activities') }}</a>
                                    @endcan
                                 @if (auth('web')->check())
                                 <form method="GET" action="{{ route('admin.logout', 'web') }}">
                               @endif
                               @csrf
                               <a class="dropdown-item" href="#"
                                   onclick="event.preventDefault();this.closest('form').submit();"><i
                                       class="bx bx-log-out"></i>{{ trans('main_sidebar.logout') }}</a>
                               </form>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
