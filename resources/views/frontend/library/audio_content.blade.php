@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="{{ $audio->keywords }}">
    <meta name="description" content="{{ $audio->description }}">
    <meta name="author" content="{{ setting()->site_name }}">
    <meta property="og:title" content="{{ $audio->name }}">
    <meta property="og:url" content="https://hamadalhajri.net/library/{{ $audio->slug }}">
    <meta id="faceDes" property="og:description">
    <meta property="og:sitename" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ $audio->name }}
@endsection
@section('content')
    <!-- start content -->
    <div class="content">
        <hr />
        <div class="allCont row m-0">
            <div class="col-lg-12 contentTopic">
                <div class="contentTitle">
                    <i class="fas fa-pen-square"></i>
                    <h1> {{ $audio->name }} </h1>
                </div>
                <div class="contentDetails row m-0">
                    <div class="col-md-6">
                        <div class="filter mb-3">
                            <i style="transform: rotate(90deg);font-size: 20px;margin: 0 5px;"
                                class="fas fa-level-down-alt icon-path"></i>
                            <span>
                                @if ($audio->audioable_type == 'App\Models\Lesson')
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.lessons.all-lessons') }}"
                                        title="{{ trans('frontend.lessons') }}">{{ trans('frontend.lessons') }}
                                    </a>
                                @elseif ($audio->audioable_type == 'App\Models\Lecture')
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.lectures.all-lectures') }}"
                                        title="{{ trans('frontend.lectures') }}">
                                        {{ trans('frontend.lectures') }}
                                    </a>
                                @elseif ($audio->audioable_type == 'App\Models\Article')
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.articles.all-articles') }}"
                                        title="{{ trans('frontend.articles') }}">
                                        {{ trans('frontend.articles') }}
                                    </a>
                                @elseif ($audio->audioable_type == 'App\Models\Speech')
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.speeches.all-speeches') }}"
                                        title="{{ trans('frontend.speeches') }}">
                                        {{ trans('frontend.speeches') }}
                                    </a>
                                @elseif ($audio->audioable_type == 'App\Models\Benefit')
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.benefits.all-benefits') }}"
                                        title="{{ trans('frontend.benefits') }}">
                                        {{ trans('frontend.benefits') }}
                                    </a>
                                @else
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.library.another.audio') }}"
                                        title="{{ trans('frontend.audioes') }}">
                                        {{ trans('frontend.audioes') }}
                                    </a>
                                @endif
                            </span>
                            <i class="far fa-window-minimize dash-icon"></i>
                            <span>

                                @if ($audio->category)
                                    <span>{{ $audio->category->name }}</span>
                                @elseif($audio->audioable)
                                    <span>{{ $audio->audioable->category->name }}</span>
                                @else
                                @endif

                            </span>
                        </div>
                        <div class="publishDate d-flex">
                            <i class="fas fa-calendar"></i>
                            <p>
                                {{ trans('lessons.publish-date') }} :
                                <span>{{ $audio->publish_date->format('Y-m-d') }}</span>
                            </p>
                        </div>
                        <div class="watchCount d-flex">
                            <i class="fas fa-eye"></i>
                            <p>
                                {{ trans('frontend.views-count') }}:
                                <span>{{ $audio->view_count }}</span>
                            </p>
                        </div>
                        <div class="downCount d-flex">
                            <i class="fas fa-download"></i>
                            <p>
                                {{ trans('frontend.download-count') }}:
                                <span class="downloaders">{{ $audio->download_count }}</span>
                            </p>
                        </div>
                        <div class="shareContent d-flex">
                            <i class="fas fa-share-alt-square"></i>
                            <p>{{ trans('frontend.share') }}</p>
                        </div>
                        <div class="col-11 socialShare">
                       
                                
                            <button class="button"
                                data-sharer="twitter"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fab fa-twitter twitter"></i>
                            </button>
                            <button class="button" data-sharer="facebook"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fab fa-facebook-square facebook"></i>
                            </button>
                            <button class="button" data-sharer="whatsapp"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fab fa-whatsapp whatsapp"></i>
                            </button>
                            <button class="button" data-sharer="telegram"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fab fa-telegram telegram"></i>
                            </button>
                            <button class="button" data-sharer="email"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fas fa-envelope gmail"></i>
                            </button>
                            <button class="button" data-sharer="line"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                                <i class="fab fa-line line"></i>
                            </button>
                            <button class="button" data-sharer="viber"
                                data-url="{{ route('frontend.audio-library.audio.content', $audio->slug) }}">
                               <i class="fab fa-viber viber"></i>
                            </button>
                                
                                
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('frontend/img/hqdefault.png') }}" class="card-img-top" style="width: 70%" alt="{{ $audio->name }}" title="{{ $audio->name }}"/>
                    </div>

                    <hr class="mt-2" />
                    <!-- content -->
                    <div class="textEditor mt-4">

                        <div class="audioFile d-flex align-items-center mt-5">
                            @if (!empty($audio->audio_file))
                                <div>
                                    <a title="{{ trans('frontend.download') }}" class="link_to_down ms-2"
                                        style="color: #1da499;"
                                        href="{{ asset('Files/audioes/' . $audio->name . '/' . $audio->audio_file) }}">
                                        {{ trans('frontend.download') }}</a>
                                </div>
                                <audio controls="" download="">
                                    <source
                                        src="{{ asset('Files/audioes/' . $audio->name . '/' . $audio->audio_file) }}" />
                                </audio>
                            @endif
                        </div>

                        <div class="embeedVideo">

                            <?php
                            $url = getYoutubeId($audio->embed_link);
                            ?>
                            @if ($url)
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/{{ $url }}" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            @endif

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
    <hr />
    <!-- End content -->
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>

    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

    <script>
        $(document).on('click', '.link_to_down', function() {

            var firstNum = $('.downloaders'),
                effect = $('.downloaders').text();

            effect++;

            $(firstNum).text(effect++);

            var newValue = $(firstNum).text();

            $.ajax({
                url: '{{ URL::current() }}',
                type: "get",
                dataType: "json",
                data: {
                    'download_count': newValue
                },
                success: function(data) {
                    console.log('done');
                }
            });


        });
    </script>
@endsection
