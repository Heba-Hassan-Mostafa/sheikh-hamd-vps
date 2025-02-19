<div class="frist-nav row">
    <div class="col-md-6 text-center">
        <a href="{{ route('frontend.index') }}" title="{{ setting()->site_name }}">
            <img class="logo" src="{{ asset('Files/settings/' . setting()->logo) }}" alt="{{ setting()->site_name }}"
                title="{{ setting()->site_name }}" />
        </a>

    </div>
    <div class="col-md-6 text-center">
        <div class="frist-nav-list">
            <ul class="ul align-items-center">
                <li class="main-btns">

                    <a href="{{ route('frontend.client') }}" title="{{ trans('frontend.client-page') }}">
                        @if (auth()->guard('client')->check())
                            {{ trans('frontend.hi') }}
                            {{ auth()->guard('client')->user()->first_name }}
                        @else
                            <i class="fas fa-user text-white"></i>
                            <a href="{{ route('login.show', 'client') }}"
                                title="{{ trans('frontend.login') }}">{{ trans('frontend.login') }}</a>
                        @endif

                    </a>
                </li>

                <li>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btnLang" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (App::getLocale() == 'ar')
                                {{ LaravelLocalization::getCurrentLocaleName() }}
                                <img src="{{ URL::asset('Files/image/flags/KW.png') }}" alt="AR">
                            @else
                                {{ LaravelLocalization::getCurrentLocaleName() }}
                                <img src="{{ URL::asset('Files/image/flags/US.png') }}" alt="EN">
                            @endif
                        </button>
                        <ul class="dropdown-menu langSelect">
                            <li>
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </li>



            </ul>
            <form action="{{ route('frontend.search') }}" method="GET" class="search-form">
                @csrf
                <input type="text" name="search" placeholder="{{ trans('frontend.search') }}"
                    class="form-control search-input" />

                <button type="submit" title="{{ trans('frontend.search') }}"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
</div>
<!-- start navBar -->
<nav>
    <!-- menu-bar----------------------------------------->
    <div class="navigation">
        <div class="toggle"><i class="fas fa-bars"></i></div>
        <!-- menu----------------->
        <ul class="menu" id="liSen">
            <li><a href="{{ route('frontend.index') }}"
                    title="{{ trans('frontend.index') }}">{{ trans('frontend.index') }}</a></li>
            <li><a href="{{ route('frontend.about') }}"
                    title="{{ trans('frontend.about') }}">{{ trans('frontend.about') }}</a></li>
            <li><a href="{{ route('frontend.lessons.all-lessons') }}"
                    title="{{ trans('frontend.lessons') }}">{{ trans('frontend.lessons') }}</a></li>
            <li><a href="{{ route('frontend.lectures.all-lectures') }}"
                    title="{{ trans('frontend.lectures') }}">{{ trans('frontend.lectures') }}</a></li>
            <li><a href="{{ route('frontend.speeches.all-speeches') }}"
                    title="{{ trans('frontend.speeches') }}">{{ trans('frontend.speeches') }}</a></li>
            <li><a href="{{ route('frontend.articles.all-articles') }}"
                    title="{{ trans('frontend.articles') }}">{{ trans('frontend.articles') }}</a></li>
            <li><a href="{{ route('frontend.books.all-books') }}"
                    title="{{ trans('frontend.books') }}">{{ trans('frontend.books') }}</a></li>
            <!--<li><a href="{{ route('frontend.benefits.all-benefits') }}"-->
            <!--        title="{{ trans('frontend.benefits') }}">{{ trans('frontend.benefits') }}</a></li>-->
            <li><a href="{{ route('frontend.fatwa.questions') }}"
                    title="{{ trans('frontend.fatwa') }}">{{ trans('frontend.fatwa') }}</a></li>
            <li><a href="{{ route('frontend.gallery.matwiaat') }}"
                    title="{{ trans('frontend.matwiaat') }}">{{ trans('frontend.matwiaat') }}</a></li>
            <li><a href="{{ route('frontend.gallery.images') }}"
                    title="{{ trans('frontend.gallery') }}">{{ trans('frontend.gallery') }}</a></li>
            <li><a href="{{ route('frontend.library.main') }}"
                    title="{{ trans('frontend.library') }}">{{ trans('frontend.library') }}</a></li>
            <li><a href="{{ route('frontend.live') }}"
                    title="{{ trans('frontend.live') }}">{{ trans('frontend.live') }}</a></li>
            <li><a href="{{ url('/contact-us') }}"
                    title=" {{ trans('frontend.contact-us') }}">
                    {{ trans('frontend.contact-us') }}</a></li>
        </ul>
    </div>
</nav>
<!-- End navBar -->
