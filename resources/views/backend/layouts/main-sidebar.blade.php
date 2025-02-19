<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll printPage ">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url(route('admin.index')) }}">
            <img src="{{ URL::asset('Files/settings/' . setting()->logo) }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url(route('admin.index')) }}">
            <img src="{{ URL::asset('Files/settings/' . setting()->logo) }}" class="main-logo dark-theme" alt="logo"></a>

    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    @if (!empty(auth()->user()->image))
                        <img alt="user-img" class="avatar avatar-xl brround"
                            src="{{ asset('Files/users/' . auth()->user()->image) }}">
                    @else
                        <img alt="user-img" class="avatar avatar-xl brround"
                            src="{{ asset('assets/img/faces/6.jpg') }}">
                    @endif
                    <span class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->full_name }}</h4>
                    <span class="mb-0 text-muted"></span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">{{ trans('main_sidebar.Main') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ url(route('admin.index')) }}">

                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                        <path
                            d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                    </svg> --}}
                    <i class="fas fa-home side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.Dashboard') }}</span>

                </a>
            </li>

            {{-- Events --}}
            
             @can('Events-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.events') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="far fa-calendar-alt side-icon "></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.comming-events') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                     @can('Events-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.events.index') }}">{{ trans('main_sidebar.comming-events') }}</a>
                    </li>
                    @endcan
                    @can('Past-Events-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.events.old_events') }}">{{ trans('main_sidebar.old-events') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
              @endcan
              
              {{-- fatwa --}}
              
              @can('Fatwa-List')
              <li class="side-item side-item-category">{{ trans('main_sidebar.fatwa') }}</li>
              <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                      <i class="fas fa-question-circle side-icon"></i>
                      <span class="side-menu__label">{{ trans('main_sidebar.fatwa') }}</span>
                      <i class="angle fe fe-chevron-down">
                      </i>
                  </a>
                  <ul class="slide-menu">
                       @can('Fatwa-List')
                      <li><a class="slide-item"
                              href="{{ route('admin.fatwa.index') }}">{{ trans('main_sidebar.questions') }}</a></li>
                        @endcan
                        @can('Fatwa-Answer-List')
                      <li><a class="slide-item"
                              href="{{ route('admin.fatwa_answers.index') }}">{{ trans('main_sidebar.answers') }}</a>
                      </li>
                      @endcan

                  </ul>
              </li>
            @endcan

            {{-- Slider --}}
            
            @can('Slider-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.slider') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-image side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.slider') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Slider-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.slider.index') }}">{{ trans('main_sidebar.slider-list') }}</a>
                            </li>
                    @endcan

                </ul>
            </li>
            <li class="side-item side-item-category">{{ trans('main_sidebar.General') }}</li>
            @endcan

            {{-- lessons --}}
            
              @can('Lessons-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-book-open side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.Lessons') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Lessons-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.lesson-categories.index') }}">{{ trans('main_sidebar.Lessons-categories') }}</a>
                    </li>
                    @endcan
                      @can('Lessons-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.lessons.index') }}">{{ trans('main_sidebar.Lessons') }}</a></li>
                            @endcan
                     @can('Lessons-Comments-List')    
                    <li><a class="slide-item"
                            href="{{ route('admin.comments.index') }}">{{ trans('main_sidebar.lessons-comments') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan


            {{-- Lectures --}}
            
             @can('Lectures-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-pencil-ruler side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.lectures') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Lectures-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.lecture-categories.index') }}">{{ trans('main_sidebar.lectures-categories') }}</a>
                    </li>
                    @endcan
                    @can('Lectures-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.lectures.index') }}">{{ trans('main_sidebar.lectures') }}</a>
                            </li>
                        @endcan
                        @can('Lectures-Comments-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.lecture-comments.index') }}">{{ trans('main_sidebar.lectures-comments') }}</a>
                    </li>
                    @endcan


                </ul>
            </li>
            @endcan


            {{-- Speeches --}}
            
            @can('Speeches-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-microphone-alt side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.speeches') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Speeches-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.speech-categories.index') }}">{{ trans('main_sidebar.speeches-categories') }}</a>
                    </li>
                    @endcan
                    @can('Speeches-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.speeches.index') }}">{{ trans('main_sidebar.speeches') }}</a>
                            </li>
                    @endcan
                    @can('Speeches-Comments-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.speech-comments.index') }}">{{ trans('main_sidebar.speeches-comments') }}</a>
                    </li>
                    @endcan


                </ul>
            </li>
            @endcan

            {{-- Articles --}}
            
            @can('Articles-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-pen-square side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.articles') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Articles-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.article-categories.index') }}">{{ trans('main_sidebar.articles-categories') }}</a>
                    </li>
                    @endcan
                    @can('Articles-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.articles.index') }}">{{ trans('main_sidebar.articles') }}</a>
                            </li>
                    @endcan
                    @can('Articles-Comments-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.article-comments.index') }}">{{ trans('main_sidebar.articles-comments') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan
            
            
            {{-- Books --}}
            
            @can('Books-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-book side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.books') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Books-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.book-categories.index') }}">{{ trans('main_sidebar.books-categories') }}</a>
                    </li>
                    @endcan
                    @can('Books-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.books.index') }}">{{ trans('main_sidebar.books') }}</a>
                    </li>
                    @endcan
                    @can('Books-Comments-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.book-comments.index') }}">{{ trans('main_sidebar.books-comments') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            
            
            {{-- benefits --}}
            
            @can('Benefits-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-hand-holding-heart side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.benefits') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Benefits-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.benefit-categories.index') }}">{{ trans('main_sidebar.benefits-categories') }}</a>
                    </li>
                    @endcan
                    @can('Benefits-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.benefits.index') }}">{{ trans('main_sidebar.benefits') }}</a>
                    </li>
                    @endcan
                    @can('Benefits-Comments-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.benefit-comments.index') }}">{{ trans('main_sidebar.benefits-comments') }}</a>
                    </li>
                    @endcan


                </ul>
            </li>
            @endcan





            {{-- gallery --}}
            
            @can('Gallery-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-photo-video side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.galleries') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Gallery-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.gallery-categories.index') }}">{{ trans('main_sidebar.gallery-categories') }}</a>
                    </li>
                    @endcan
                    @can('Gallery-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.galleries.index') }}">{{ trans('main_sidebar.galleries') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            
             {{-- matwiaat --}}

            @can('Matwiaat-List') 
             <li class="slide">
                 <a class="side-menu__item" data-toggle="slide" href="#">
                     <i class="fas fa-photo-video side-icon"></i>
                     <span class="side-menu__label">{{ trans('main_sidebar.matwiaat') }}</span>
                     <i class="angle fe fe-chevron-down">
                     </i>
                 </a>
                 <ul class="slide-menu">
                     {{-- @can('Gallery-List') --}}
                     <li><a class="slide-item"
                             href="{{ route('admin.matwiaat.index') }}">{{ trans('main_sidebar.matwiaat') }}</a>
                     </li>
                     {{-- @endcan --}}
                 </ul>
             </li>
             @endcan 

            {{-- live --}}
            
            @can('Live-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.live') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-video side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.live') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Live-List')
                    <li>
                        <a class="slide-item"
                            href="{{ route('admin.live.index') }}">{{ trans('main_sidebar.live') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan


            {{-- library --}}
            
            @can('Audio-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.library') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-swatchbook side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.audio') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Audio-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.audio-categories.index') }}">{{ trans('main_sidebar.audio-category') }}</a>
                    </li>
                    @endcan
                    @can('Audio-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.library-audio.index') }}">{{ trans('main_sidebar.all-audio') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @can('Video-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-swatchbook side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.video') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
               <ul class="slide-menu">
                   @can('Video-Categories-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.video-categories.index') }}">{{ trans('main_sidebar.video-category') }}</a>
                    </li>
                    @endcan
                    @can('Video-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.library-video.index') }}">{{ trans('main_sidebar.all-video') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan
            @endcan

            {{-- users --}}
            
            @can('Users-List')
            <li class="side-item side-item-category">{{ trans('users.users') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-users-cog side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.users') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Users-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.users.index') }}">{{ trans('main_sidebar.users') }}</a>
                    </li>
                    @endcan
                    @can('Roles-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.roles.index') }}">{{ trans('main_sidebar.roles') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            
            {{-- clients --}}
            
            @can('Subscribers-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.clients') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-envelope side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.subscribers') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Subscribers-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.subscribers.index') }}">{{ trans('main_sidebar.subscribers-list') }}</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan


            @can('Clients-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-users side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.clients') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Clients-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.clients.index') }}">{{ trans('main_sidebar.clients-list') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan
            
            @can('Contact-Us-List')
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fas fa-phone-square-alt side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.contacts') }}</span>
                    <i class="angle fe fe-chevron-down">
                    </i>
                </a>
                <ul class="slide-menu">
                    @can('Contact-Us-List')
                    <li><a class="slide-item"
                            href="{{ route('admin.contacts.index') }}">{{ trans('main_sidebar.contacts-list') }}</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan




            {{-- settings --}}
            
            @can('Settings-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.settings') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ url(route('admin.settings.index')) }}">
                    <i class="fas fa-cogs side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.settings') }}</span>
                </a>
            </li>
            @endcan

            {{-- reports --}}
            
            @can('Reports-List')
            <li class="side-item side-item-category">{{ trans('main_sidebar.reports') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ url(route('admin.reports')) }}">
                    <i class="fas fa-server side-icon"></i>
                    <span class="side-menu__label">{{ trans('main_sidebar.reports') }}</span>
                </a>
            </li>
            @endcan

        </ul>
    </div>
</aside>
<!-- main-sidebar -->
