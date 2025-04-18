@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="{{ $lesson->keywords }}">
    <meta name="description" content="{{ $lesson->description }}">
    <meta name="author" content="{{ setting()->site_name }}">
    <meta property="og:title" content="{{ $lesson->name }}">
    <meta property="og:image" content="{{ $lesson->image->file_name === null ? asset('frontend/img/lessons.png') : asset('Files/image/Lessons/'. $lesson->name.'/'. $lesson->image->file_name) }}">
    <meta property="og:url" content="https://hamadalhajri.net/lessons/{{ $lesson->slug }}">
    <meta id="faceDes" property="og:description">
    <meta property="og:sitename" content="{{ setting()->site_name }}">
@endsection
@section('css')
@endsection
@section('title')
    {{ $lesson->name }}
@endsection
@section('content')
    <!-- start content -->
    <div class="content">
        <hr />
        <div class="allCont row m-0">
            <div class="col-lg-9 contentTopic">
                <div class="contentTitle">
                    <i class="fas fa-pen-square"></i>
                    <h1> {{ $lesson->name }} </h1>
                </div>
                <div class="contentDetails row m-0">
                    <div class="col-md-6">
                        <div class="filter mb-3">
                            <i style="transform: rotate(90deg);font-size: 20px;margin: 0 5px;"
                                class="fas fa-level-down-alt icon-path"></i>
                            <span>
                                <a style="color: var(--main-color);font-weight:bold;margin-left: 8px;"
                                    href="{{ route('frontend.lessons.all-lessons') }}"
                                    title="{{ trans('frontend.lessons') }}">
                                    {{ trans('frontend.lessons') }}</a>
                            </span>
                            <i class="far fa-window-minimize dash-icon"></i>
                            <span>
                                <a style="color: var(--main-color);font-weight:bold;"
                                    href="{{ route('frontend.lessons.category.lessons', $lesson->category->slug) }}"
                                    title="{{ $lesson->category->name }}">{{ $lesson->category->name }}</a>
                            </span>
                        </div>
                        <div class="publishDate d-flex">
                            <i class="fas fa-calendar"></i>
                            <p>
                                {{ trans('lessons.publish-date') }} :
                                <span>{{ $lesson->publish_date->format('Y-m-d') }}</span>
                            </p>
                        </div>
                        <div class="watchCount d-flex">
                            <i class="fas fa-eye"></i>
                            <p>
                                {{ trans('frontend.views-count') }}:
                                <span>{{ $lesson->view_count }}</span>
                            </p>
                        </div>
                        <div class="downCount d-flex">
                            <i class="fas fa-download"></i>
                            <p>
                                {{ trans('frontend.download-count') }}:
                                <span class="downloaders">{{ $lesson->download_count }}</span>
                            </p>
                        </div>
                        <div class="shareContent d-flex">
                            <i class="fas fa-share-alt-square"></i>
                            <p>{{ trans('frontend.share') }}</p>
                        </div>
                        <div class="col-11 socialShare">
                            <button class="button"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-sharer="twitter"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fab fa-twitter twitter"></i>
                            </button>
                            <button class="button" data-sharer="facebook"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fab fa-facebook-square facebook"></i>
                            </button>
                            <button class="button" data-sharer="whatsapp"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fab fa-whatsapp whatsapp"></i>
                            </button>
                            <button class="button" data-sharer="telegram"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fab fa-telegram telegram"></i>
                            </button>
                            <button class="button" data-sharer="email"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fas fa-envelope gmail"></i>
                            </button>
                            <button class="button" data-sharer="line"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                                <i class="fab fa-line line"></i>
                            </button>
                            <button class="button" data-sharer="viber"
                                data-image="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                data-url="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}">
                               <i class="fab fa-viber viber"></i>
                            </button>
                        </div>
                        <hr />
                        <div class="row m-0">
                            <div class="col-md-12 col-lg-6 downloadPdf d-flex">
                                <i class="fas fa-download"></i>
                                <button class="btnAllFiles" title="{{ trans('frontend.download') }}">
                                    {{ trans('frontend.download') }}</button>
                                <ul class="allPdfFiles pdfListAction">
                                    @forelse ($lesson->attachments as $file)
                                        <li>
                                            <i class="fas fa-file-pdf"></i>
                                            <a id="download-numbers" download title="{{ $file->file_name }}"
                                                href="{{ asset('Files/Pdf-Files/Lessons/' . $lesson->name . '/' . $file->file_name) }}">
                                                {{ $file->file_name }}</a>
                                        </li>
                                    @empty
                                        <span class="noFiles">{{ trans('frontend.no-files') }}</span>
                                    @endforelse
                                </ul>
                            </div>
                            <?php
                            $client_id = auth()
                                ->guard('client')
                                ->id();
                            $check = App\Models\Wish::with('client')
                                ->where('client_id', $client_id)
                                ->where('wishable_type', 'App\Models\Lesson')
                                ->where('wishable_id', $lesson->id)
                                ->first();
                            ?>
                            <div class="col-md-12 col-lg-6 p-0 mb-2 loveContent d-flex">
                                @if ($check)
                                    <button class="addToWish like loveContent" data-id="{{ $lesson->id }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                @else
                                    <button class="addToWish loveContent" data-id="{{ $lesson->id }}">
                                        <i class="far fa-heart"></i>
                                    </button>
                                @endif

                                <span> {{ trans('frontend.add-wish') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 contentImg">
                        @if (!empty($lesson->image->file_name))
                        <div class="img-title">
                            <a href="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}">
                               <img src="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                class="img-fluid" title="{{ $lesson->name }}" alt="{{ $lesson->name }}" />
                            </a>
                        </div>
                            
                        @else
                        <div class="img-title">
                            <a href="{{ asset('frontend/img/lessons.webp') }}">
                               <img src="{{ asset('frontend/img/lessons.webp') }}" class="img-fluid" title="{{ $lesson->name }}"
                                alt="{{ $lesson->name }}" />
                            </a>
                        </div>
                            
                        @endif
                    </div>
                    <hr class="mt-2" />
                    <!-- content -->
                    <div class="textEditor mt-4">
                        <p>
                            {!! $lesson->content !!}
                        </p>
                        <div class="audioFile mt-5">
                            @foreach ($lesson->audioes as $audio)
                                @if (!empty($audio->audio_file))
                                    <audio controls="" download="">
                                        <source
                                            src="{{ asset('Files/audioes/' . $lesson->name . '/' . $audio->audio_file) }}" />
                                    </audio>
                                @endif
                            @endforeach

                        </div>

                        <div class="embeedVideo">
                            @foreach ($lesson->audioes as $audio)
                                <?php
                                $url = getYoutubeId($audio->embed_link);
                                ?>
                                @if ($url)
                                    <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/{{ $url }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                @endif
                            @endforeach
                        </div>
                        <div class="vedioFile text-center">
                            @foreach ($lesson->videos as $video)
                            @if (!empty($video->video_file))
                            <video width="320" height="240" controls>
                                    <source
                                        src="{{ asset('Files/videos/' . $lesson->name . '/' . $video->video_file) }}" />
                                    </video>
                            @endif
                        @endforeach

                        </div>
                        <div class="embeedAudio">
                            @foreach ($lesson->videos as $video)
                                @php
                                    $url = getYoutubeId($video->youtube_link);
                                @endphp
                                @if ($url)
                                    <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/{{ $url }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- start comment -->
                <hr />
                <div class="comments">
                    <h3 class="allCommentsHead">{{ trans('frontend.comments') }}</h3>
                    <div class="allCommentContent">
                        @forelse ($lesson->comments as $comment)
                            @if ($comment->status == 1)
                                <div class="commentBox">
                                    <i class="fas fa-user-circle"></i>
                                    <div class="comBox">
                                        <h5>{{ $comment->client->full_name }}</h5>
                                        <span>{{ $comment->created_at->format('Y-m-d') }}</span>
                                        <p>
                                            {{ $comment->message }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <span>{{ trans('frontend.no-comment') }}</span>
                        @endforelse
                    </div>
                    <hr />
                    <div class="addComment">
                        <h4 class="addCommentHead"> {{ trans('frontend.add-comment') }}</h4>
                        <form action="" method="">
                            @csrf
                            <input type="hidden" name='lesson_id' value={{ $lesson->id }}>
                            <textarea class="count-limit" name="message" id="textAreaContent" cols="30" rows="10"
                                placeholder="{{ trans('frontend.comment') }}"></textarea>
                            @error('message')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="countLimit">
                                <button title="  {{ trans('frontend.send') }}"
                                    class="saveComment main-btns m-auto d-block mt-4 p-2 pe-3 ps-3" id="save_comment">
                                    {{ trans('frontend.send') }}
                                </button>
                                <p class="error-msg"> {{ trans('frontend.message-count') }} </p>
                                <p class="num-lim">
                                    <span class="counting">0</span>
                                    /
                                    <span class="limitVal"></span>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end comment -->
            </div>
            <!-- start side defult links  -->

            <div class="col-lg-3 sideDefultLinks">
                <h2> {{ trans('frontend.random-lesson') }}</h2>
                <div class="row m-0">


                    @forelse ($randomLessons->except($lesson->id) as $random)
                    @if ($random->lesson_category_id == $lesson->lesson_category_id)
                    <div class="col-12 categoriesCard">
                        <div class="card h-100">
                            @if (!empty($random->image->file_name))
                                <img src="{{ asset('Files/image/Lessons/' . $random->name . '/' . $random->image->file_name) }}"
                                    class="card-img-top" title="{{ $random->name }}" alt="{{ $random->name }}" />
                            @else
                                <img src="{{ asset('frontend/img/lessons.webp') }}" class="card-img-top"
                                    title="{{ $random->name }}" alt="{{ $random->name }}" />
                            @endif
                            <div class="card-body">
                                <div class="d-inline-flex mt-3">
                                    <i class="fas fa-pen-square title-icon m-1 me-0"></i>
                                    <h6 class="card-title mt-2">
                                        {{ \Illuminate\Support\Str::limit($random->name, 25) }}
                                    </h6>
                                </div>

                                <div class="date-details">
                                    <i class="fas fa-calendar-alt date-icon m-1 me-0"></i>
                                    <span>{{ $random->publish_date->format('Y-m-d') }}</span>
                                </div>
                                <div class="card-text d-flex mt-2">
                                    <i class="fas fa-book-open book-icon m-1 me-0"></i>

                                    <p>يقدم ا.د حمد بن محمد الهاجرى درس بعنوان
                                        {{ \Illuminate\Support\Str::limit($random->name, 35) }}
                                    </p>

                                </div>
                                <div class="text-center m-2">
                                    <a href="{{ route('frontend.lessons.lesson_content', $random->slug) }}"
                                        class="btn-card-more"
                                        title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                                </div>
                                <p class="allWatch">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $random->view_count }}</span>
                                </p>
                                <p class="allDown">
                                    <i class="fas fa-download"></i>
                                    <span>{{ $random->download_count }}</span>
                                </p>
                            </div>
                            <?php
                            $client_id = auth()
                                ->guard('client')
                                ->id();
                            $check = App\Models\Wish::with('client')
                                ->where('client_id', $client_id)
                                ->where('wishable_type', 'App\Models\Lesson')
                                ->where('wishable_id', $random->id)
                                ->first();
                            ?>
                            @if ($check)
                                <button class="addToWish" data-id="{{ $random->id }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            @else
                                <button class="addToWish" data-id="{{ $random->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            @endif

                        </div>
                    </div>
                    @else
                    <div class="col-12 categoriesCard">
                        <div class="card h-100">
                            @if (!empty($random->image->file_name))
                                <img src="{{ asset('Files/image/Lessons/' . $random->name . '/' . $random->image->file_name) }}"
                                    class="card-img-top" title="{{ $random->name }}" alt="{{ $random->name }}" />
                            @else
                                <img src="{{ asset('frontend/img/lessons.webp') }}" class="card-img-top"
                                    title="{{ $random->name }}" alt="{{ $random->name }}" />
                            @endif
                            <div class="card-body">
                                <div class="d-inline-flex mt-3">
                                    <i class="fas fa-pen-square title-icon m-1 me-0"></i>
                                    <h6 class="card-title mt-2">
                                        {{ \Illuminate\Support\Str::limit($random->name, 25) }}
                                    </h6>
                                </div>

                                <div class="date-details">
                                    <i class="fas fa-calendar-alt date-icon m-1 me-0"></i>
                                    <span>{{ $random->publish_date->format('Y-m-d') }}</span>
                                </div>
                                <div class="card-text d-flex mt-2">
                                    <i class="fas fa-book-open book-icon m-1 me-0"></i>

                                    <p>يقدم ا.د حمد بن محمد الهاجرى درس بعنوان
                                        {{ \Illuminate\Support\Str::limit($random->name, 35) }}
                                    </p>

                                </div>
                                <div class="text-center m-2">
                                    <a href="{{ route('frontend.lessons.lesson_content', $random->slug) }}"
                                        class="btn-card-more"
                                        title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                                </div>
                                <p class="allWatch">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $random->view_count }}</span>
                                </p>
                                <p class="allDown">
                                    <i class="fas fa-download"></i>
                                    <span>{{ $random->download_count }}</span>
                                </p>
                            </div>
                            <?php
                            $client_id = auth()
                                ->guard('client')
                                ->id();
                            $check = App\Models\Wish::with('client')
                                ->where('client_id', $client_id)
                                ->where('wishable_type', 'App\Models\Lesson')
                                ->where('wishable_id', $random->id)
                                ->first();
                            ?>
                            @if ($check)
                                <button class="addToWish" data-id="{{ $random->id }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            @else
                                <button class="addToWish" data-id="{{ $random->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            @endif

                        </div>
                    </div>
                    @endif
                    @empty
                        <span>{{ trans('frontend.no-random-lessons') }}</span>
                    @endforelse
                </div>
            </div>
            <!-- end side defult links  -->
        </div>
    </div>
    <hr />
    <!-- End content -->
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <script defer src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
    <script defer src="{{ asset('frontend/js/contJs.js') }}"></script>
    {{-- add wishlist --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('.addToWish').on('click', function() {
                var id = $(this).data('id');
                if (id) {
                    $.ajax({
                        url: " {{ url('/lessons/add/wishlist/') }}/" + id,
                        type: "GET",
                        datType: "json",
                        success: function(data) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                onOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })
                            if ($.isEmptyObject(data.error)) {
                                Toast.fire({
                                    icon: 'success',
                                    title: data.success
                                })
                            } else {
                                $(".addToWish").html(`<i class="far fa-heart"></i>`);
                                Toast.fire({
                                    icon: 'error',
                                    title: data.error
                                })
                            }
                        },
                    });
                }
            });
        });
    </script>
    {{-- add comment --}}
    <script>
        $(document).ready(function() {
            $('#save_comment').on('click', function(e) {

                e.preventDefault();

                $.ajax({
                    url: "{{ route('frontend.lessons.add.comment', $lesson->id) }}",
                    type: "POST",
                    datType: "json",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'client_id': "{{ Auth::guard('client')->id() }}",
                        'message': $("textarea[name='message']").val(),
                        'commentable_id': '{{ $lesson->id }}',
                        'commentable_type': 'App\Models\Lesson',

                    },
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer)
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer)
                            }
                        })
                        if ($.isEmptyObject(data.error)) {
                            Toast.fire({
                                icon: 'success',
                                title: data.success
                            })
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: data.error
                            })
                        }
                    },

                });
                $("#textAreaContent").val("");

            });
        });
    </script>
    <script>
        // toggle show & hide pdf list download
        let btnDownLoad = document.querySelector('.allPdfFiles')
        let btnAllFiles = document.querySelector('.btnAllFiles')
        let btnDownLoadAll = document.querySelectorAll('.allPdfFiles li')

        btnAllFiles.addEventListener('click', () => {
            btnDownLoad.classList.toggle('pdfListAction')
        })
        
    </script>
    <script>
        $(document).on('click', '#download-numbers', function() {

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
