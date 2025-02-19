@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="{{ $video->keywords }}">
    <meta name="description" content="{{ $video->description }}">
    <meta name="author" content="{{ setting()->site_name }}">
    <meta property="og:title" content="{{ $video->name }}">
    <meta property="og:url" content="https://hamadalhajri.net/library/{{ $video->slug }}">
    <meta id="faceDes" property="og:description">
    <meta property="og:sitename" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ $video->name }}
@endsection
@section('content')
    <!-- start content -->
    <div class="content">
        <hr />
        <div class="allCont row m-0">
            <div class="col-lg-12 contentTopic">
                <div class="contentTitle">
                    <i class="fas fa-pen-square"></i>
                    <h1> {{ $video->name }} </h1>
                </div>
                <div class="contentDetails row m-0">
                    <div class="col-md-6">
                        <div class="filter mb-3">
                            <i style="transform: rotate(90deg);font-size: 20px;margin: 0 5px;"
                                class="fas fa-level-down-alt icon-path"></i>
                            <span>
                                    <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                        href="{{ route('frontend.library.another.video') }}"
                                        title="{{ trans('frontend.another-videos') }}">
                                        {{ trans('frontend.another-videos') }}
                                    </a>

                            </span>
                            <i class="far fa-window-minimize dash-icon"></i>
                            <span>

                                @if ($video->category)
                                    <span>{{ $video->category->name }}</span>
                                @endif


                            </span>
                        </div>
                        <div class="publishDate d-flex">
                            <i class="fas fa-calendar"></i>
                            <p>
                                {{ trans('lessons.publish-date') }} :
                                <span>{{ $video->publish_date->format('Y-m-d') }}</span>
                            </p>
                        </div>
                        <div class="watchCount d-flex">
                            <i class="fas fa-eye"></i>
                            <p>
                                {{ trans('frontend.views-count') }}:
                                <span>{{ $video->view_count }}</span>
                            </p>
                        </div>
                        <div class="downCount d-flex">
                            <i class="fas fa-download"></i>
                            <p>
                                {{ trans('frontend.download-count') }}:
                                <span class="downloaders">{{ $video->download_count }}</span>
                            </p>
                        </div>
                        <div class="shareContent d-flex">
                            <i class="fas fa-share-alt-square"></i>
                            <p>{{ trans('frontend.share') }}</p>
                        </div>
                        <div class="col-11 socialShare">
                            <button class="button"
                                data-sharer="twitter"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fab fa-twitter twitter"></i>
                            </button>
                            <button class="button" data-sharer="facebook"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fab fa-facebook-square facebook"></i>
                            </button>
                            <button class="button" data-sharer="whatsapp"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fab fa-whatsapp whatsapp"></i>
                            </button>
                            <button class="button" data-sharer="telegram"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fab fa-telegram telegram"></i>
                            </button>
                            <button class="button" data-sharer="email"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fas fa-envelope gmail"></i>
                            </button>
                            <button class="button" data-sharer="line"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                                <i class="fab fa-line line"></i>
                            </button>
                            <button class="button" data-sharer="viber"
                                data-url="{{ route('frontend.library.videos.content', $video->slug) }}">
                               <i class="fab fa-viber viber"></i>
                            </button>
                                
                                
                                
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('frontend/img/vediodefault.webp') }}" class="card-img-top mt-2" style="width: 70%" alt="{{ $video->name }}" title="{{ $video->name }}"/>
                    </div>

                    <hr class="mt-2" />
                    <!-- content -->
                    <div class="textEditor text-center mt-4">

                        <div class="audioFile mt-5">
                            @if (!empty($video->video_file))

                                <video controls="" download="" class="m-auto mw-100">
                                    <source
                                        src="{{ asset('Files/videos/' . $video->name . '/' . $video->video_file) }}" />
                                </video>
                                <div class="mt-3">
                                    <a title="{{ trans('frontend.download') }}" class="link_to_down main-btns ms-2"
                                        style="color: var(--scoundry-color);"
                                        href="{{ asset('Files/videos/' . $video->name . '/' . $video->video_file) }}">
                                        {{ trans('frontend.download') }}</a>
                                </div>
                            @endif
                        </div>

                        <div class="embeedVideo">

                            <?php
                            $url = getYoutubeId($video->youtube_link);
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
