<footer>
    <div class="row m-0">
        <div class="col-md-4 text-center">
            <div>
                <a href="{{ route('frontend.index') }}"   title="{{ setting()->site_name }}" >
                    <img src="{{ asset('Files/settings/' . setting()->logo) }}"alt="{{ setting()->site_name }}"
                    title="{{ setting()->site_name }}" />
                   </a>

            </div>
            <div>
                <span class="main-btns h6-footer m-auto mt-4"> {{ trans('frontend.connect-us') }}</span>

                <ul class="footer-social">
                    <li>
                        <a rel="nofollow" href="{{ setting()->facebook }}" target="_blank" title="facebook"><i class="fab fa-facebook"></i></a>
                    </li>
                    <li>
                        <a rel="nofollow" href="{{ setting()->instagram }}" target="_blank" title="instagram"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a rel="nofollow" href="{{ setting()->twitter }}" target="_blank" title="twitter"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li>
                        <a rel="nofollow" href="{{ setting()->telegram }}" target="_blank" title="telegram">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                    </li>
                    <li>
                        <a rel="nofollow" href="{{ setting()->youtube }}" target="_blank" title="youtube"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>

                <div class="visitors main-btns d-inline-block">
                    <p>{{ trans('frontend.visitores') }} <p>
                    <span>{{ $visitor->visitor_count }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 quick-link">
            <p class="pt-4 fw-bold">{{ trans('frontend.fast-links') }} </p>
            <ul class="row m-0">
                <li class="col-6"><a href="{{ route('frontend.about') }}" title="{{ trans('frontend.about') }}">{{ trans('frontend.about') }} </a></li>
                <li class="col-6"><a href="{{ route('frontend.live') }}" title="{{ trans('frontend.live')  }}"> {{ trans('frontend.live') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.lessons.all-lessons') }}" title="{{ trans('frontend.lessons') }}">{{ trans('frontend.lessons') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.gallery.matwiaat') }}" title="{{ trans('frontend.matwiaat') }}"> {{ trans('frontend.matwiaat') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.lectures.all-lectures') }}" title="{{ trans('frontend.lectures') }}">{{ trans('frontend.lectures') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.gallery.images') }}" title="{{ trans('frontend.gallery') }}"> {{ trans('frontend.gallery') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.books.all-books') }}" title="{{ trans('frontend.books') }}">{{ trans('frontend.books') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.speeches.all-speeches') }}" title="{{ trans('frontend.speeches') }}">{{ trans('frontend.speeches') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.benefits.all-benefits') }}" title="{{ trans('frontend.benefits') }}">{{ trans('frontend.benefits') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.fatwa.questions') }}" title="{{ trans('frontend.fatwa') }}"> {{ trans('frontend.fatwa') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.library.videos') }}" title="{{ trans('frontend.video-library') }}">{{ trans('frontend.video-library') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.articles.all-articles') }}" title="{{ trans('frontend.articles') }}">{{ trans('frontend.articles') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.audio-library.audio') }}" title="{{ trans('frontend.audio-library') }}">{{ trans('frontend.audio-library') }}</a></li>
                <li class="col-6"><a href="{{ route('frontend.contact.us') }}" title="{{ trans('frontend.contact-us') }}">{{ trans('frontend.contact-us') }}</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <p class="pt-4 fw-bold"> {{ trans('frontend.footer-greeting') }}</p>
            <div class="whatsBox">
                <i class="fab fa-whatsapp-square"></i>
                <p>{{ trans('frontend.whatsup-connect') }} </p>
                <img style="width:100% ; height : 100%" src="{{ asset('frontend/img/call.svg') }}" alt="{{ trans('frontend.whatsup-connect') }}"
                title="{{ trans('frontend.whatsup-connect') }}" />
                <p class="row">
                    <span class="forWomen col-6">
                        <span class="d-block">{{ trans('frontend.women') }}</span>
                        <a rel="nofollow" href="https://api.whatsapp.com/send?phone={{ setting()->women_phone }}"
                            target="_blank" title="{{ trans('frontend.women') }}">
                            {{  setting()->women_phone }}
                        </a>
                    </span>
                    <span class="forMen col-6">
                        <span class="d-block">{{ trans('frontend.men') }}</span>
                        <a rel="nofollow" href="https://api.whatsapp.com/send?phone={{ setting()->phone }}"
                            target="_blank" title="{{ trans('frontend.men') }}">
                            {{ setting()->phone }}
                        </a>
                    </span>
                </p>
                <i class="far fa-envelope g-mail"></i>
                <p>{{ trans('frontend.email-connect') }} </p>
                <span>
                    <a href="mailto:{{ setting()->email }}" rel="nofollow" title="{{ trans('frontend.email-connect') }}">
                       {{ setting()->email }}
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="copyRight">
        <div class="row m-0 align-items-center">
            <div class="col-md-7 text-center owner-copyright">
                {{ setting()->site_right }}&#169; 2021 -
                2024
            </div>
            <div class="col-md-5 text-center developers-copyright">
                <span> {{ trans('frontend.des-dev') }}</span>
                <div>
                    <a rel="nofollow" href="https://www.linkedin.com/in/mohammed-a-ghanem" target="_blank" title="Eng/ Mohammed Ghanem">
                        Eng/ Mohammed Ghanem
                    </a>
                    &
                    <a rel="nofollow" href="https://www.linkedin.com/in/heba-hassan-mostafa" target="_blank" title="  Eng/ Heba Hassan">
                        Eng/ Heba Hassan
                    </a>
                </div>
            </div>
        </div>
    </div>
    <button id="scrollToTop">
        <i class="fas fa-chevron-circle-up"></i>
    </button>
    <div class="sideSocial">
        <ul>
            <li>
                <a rel="nofollow" href="{{ setting()->facebook }}" target="_blank" title="facebook"><i class="fab fa-facebook"></i></a>
            </li>
            <li>
                <a rel="nofollow" href="{{ setting()->instagram }}" target="_blank" title="instagram"><i class="fab fa-instagram"></i></a>
            </li>
            <li>
                <a rel="nofollow" href="{{ setting()->twitter }}" target="_blank" title="twitter"><i class="fab fa-twitter"></i></a>
            </li>
            <li>
                <a rel="nofollow" href="{{ setting()->telegram }}" target="_blank" title="telegram">
                    <i class="fab fa-telegram-plane"></i>
                </a>
            </li>
            <li>
                <a rel="nofollow" href="{{ setting()->youtube }}" target="_blank" title="youtube"><i class="fab fa-youtube"></i></a>
            </li>
        </ul>
    </div>
    <div itemscope="" itemtype="http://schema.org/Movie"></div>
</footer>
