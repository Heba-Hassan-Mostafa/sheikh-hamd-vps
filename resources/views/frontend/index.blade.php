@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="{{ setting()->keywords }}">
<meta name="description" content="{{ setting()->description }}">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('css')
@endsection
@section('title')
    {{ setting()->site_name }}
@endsection
@section('content')
    <!-- start slider -->

    @include('frontend.design.slider')
    <!-- end slider -->
    <!-- start new data -->
    <section class="newData">
        <div class="shadow-head">
            <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" loading="lazy" alt="{{ trans('frontend.news') }}"
                title="{{ trans('frontend.news') }}" />
            <h1 class="text-center">{{ trans('frontend.news') }}</h1>
        </div>
        <div class="allTabs row m-0">
            <!-- i removed fade-out class from allTabs -->
            <a href="#lessonScreen" class="tab col-sm-2 col-lg-4 text-center activeTab" data-content=".les">
                <img src="{{ asset('frontend/img/lesseons.webp') }}" loading="lazy" alt="{{ trans('frontend.lessons') }}+1"
                    title="{{ trans('frontend.lessons') }}" />
                <p>{{ trans('frontend.lessons') }}</p>
            </a>
            <a href="#lectureScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".lec">
                <img src="{{ asset('frontend/img/lecture.webp') }}" loading="lazy" alt="{{ trans('frontend.lectures') }}+1"
                    title="{{ trans('frontend.lectures') }}" />
                <p>{{ trans('frontend.lectures') }}</p>
            </a>
            <a href="#speechesScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".spe">
                <img src="{{ asset('frontend/img/speeches.webp') }}" loading="lazy" alt="{{ trans('frontend.speeches') }}+1"
                    title="{{ trans('frontend.speeches') }}" />
                <p>{{ trans('frontend.speeches') }}</p>
            </a>
            <a href="#articlesScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".art">
                <img src="{{ asset('frontend/img/articles.webp') }}" loading="lazy" alt="{{ trans('frontend.articles') }}+1"
                    title="{{ trans('frontend.articles') }}" />
                <p>{{ trans('frontend.articles') }}</p>
            </a>
            <a href="#booksScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".boo">
                <img src="{{ asset('frontend/img/bks.webp') }}" loading="lazy" alt="{{ trans('frontend.books') }}+1"
                    title="{{ trans('frontend.books') }}" />
                <p>{{ trans('frontend.books') }}</p>
            </a>
            <a href="#galleryScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".pic">
                <img src="{{ asset('frontend/img/picture.webp') }}" loading="lazy" alt="{{ trans('frontend.gallery') }}+1"
                    title="{{ trans('frontend.gallery') }}" />
                <p>{{ trans('frontend.gallery') }}</p>
            </a>
            <a href="#videoScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".ved">
                <img src="{{ asset('frontend/img/vedios.webp') }}" loading="lazy" alt="{{ trans('frontend.video-library') }}+1"
                    title="{{ trans('frontend.video-library') }}" />
                <p>{{ trans('frontend.video-library') }} </p>
            </a>
            <a href="#audioScreen" class="tab col-sm-2 col-lg-4 text-center" data-content=".mic">
                <img src="{{ asset('frontend/img/audio.webp') }}" loading="lazy" alt="{{ trans('frontend.audio-library') }}+1"
                    title="{{ trans('frontend.audio-library') }}" />
                <p>{{ trans('frontend.audio-library') }}</p>
            </a>
        </div>
    </section>
    <section class="newDataContent">
        <!-- lessons Content -->
        <div id="lessonScreen" class="les row row-cols-1 row-cols-md-3 g-4">
            <?php
            $lessons = \App\Models\Lesson::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('id', 'desc')
                ->paginate(4);
            ?>
            @forelse ($lessons as $lesson)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if (!empty($lesson->image->file_name))
                            <img src="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                              loading="lazy"  class="card-img-top" title="{{ $lesson->name }}" alt="{{ $lesson->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/lessons.webp') }}" loading="lazy" class="card-img-top"
                                title=" {{ $lesson->name }}" alt="{{ $lesson->name }}" />
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h2 class="card-title">
                                    {{ \Illuminate\Support\Str::limit($lesson->name, 25) }}

                                </h2>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span> {{ $lesson->publish_date->format('Y-m-d') }} </span>
                            </div>
                            <div class="card-text">
                                <i class="fas fa-book-open book-icon"></i>

                                <p>يقدم ا.د حمد بن محمد الهاجرى درس بعنوان
                                    {{ \Illuminate\Support\Str::limit($lesson->name, 35) }}
                                </p>


                            </div>
                            <div class="text-center">
                                <a href="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}"
                                    class="btn-card-more" title="{{ trans('frontend.more') }}">
                                    {{ trans('frontend.more') }}
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-lessons') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
            <a href="{{ route('frontend.lessons.all-lessons') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
        <!-- lectures Content -->
        <div id="lectureScreen" class="lec row row-cols-1 row-cols-md-3 g-4">
            <?php
            $lectures = \App\Models\Lecture::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('id', 'desc')
                ->paginate(4);
            ?>
            @forelse ($lectures as $lecture)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if (!empty($lecture->image->file_name))
                            <img src="{{ asset('/Files/image/Lectures/' . $lecture->name . '/' . $lecture->image->file_name) }}"
                               loading="lazy" class="card-img-top" title="{{ $lecture->name }}" alt="{{ $lecture->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/lectures.webp') }}" loading="lazy" class="card-img-top"
                                title="{{ $lecture->name }}" alt="{{ $lecture->name }}" />
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h3 class="card-title">
                                    {{ \Illuminate\Support\Str::limit($lecture->name, 25) }}

                                </h3>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span> {{ $lecture->publish_date->format('Y-m-d') }} </span>
                            </div>
                            <div class="card-text">
                                <i class="fas fa-book-open book-icon"></i>

                                <p>يقدم ا.د حمد بن محمد الهاجرى محاضرة بعنوان
                                    {{ \Illuminate\Support\Str::limit($lecture->name, 30) }}

                                </p>

                            </div>
                            <div class="text-center">
                                <a href="{{ route('frontend.lectures.lecture_content', $lecture->slug) }}"
                                    class="btn-card-more"
                                    title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-lectures') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
            <a href="{{ route('frontend.lectures.all-lectures') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
        <!-- speaches content -->
        <div id="speechesScreen" class="spe row row-cols-1 row-cols-md-3 g-4">
            <?php
            $speeches = \App\Models\Speech::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('id', 'desc')
                ->paginate(4);
            ?>
            @forelse ($speeches as $speech)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if (!empty($speech->image->file_name))
                            <img src="{{ asset('/Files/image/Speeches/' . $speech->name . '/' . $speech->image->file_name) }}"
                              loading="lazy"  class="card-img-top" title="{{ $speech->name }}" alt="{{ $speech->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/spee.webp') }}" loading="lazy" class="card-img-top"
                                title="{{ $speech->name }}" alt="{{ $speech->name }}" />
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h3 class="card-title">
                                    {{ \Illuminate\Support\Str::limit($speech->name, 25) }}

                                </h3>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>{{ $speech->publish_date->format('Y-m-d') }}</span>
                            </div>
                            <div class="card-text">
                                <i class="fas fa-book-open book-icon"></i>
                                <p>يقدم ا.د حمد بن محمد الهاجرى خطبة بعنوان
                                    {{ \Illuminate\Support\Str::limit($speech->name, 35) }}

                                </p>

                            </div>
                            <div class="text-center">
                                <a href="{{ route('frontend.speeches.speech_content', $speech->slug) }}"
                                    class="btn-card-more"
                                    title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-speeches') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
          <a href="{{ route('frontend.speeches.all-speeches') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
        <!-- articles content -->
        <div id="articlesScreen" class="art row row-cols-1 row-cols-md-3 g-4">
            <?php
            $articles = \App\Models\Article::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('id', 'desc')
                ->paginate(4);
            ?>
            @forelse ($articles as $article)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if (!empty($article->image->file_name))
                            <img src="{{ asset('/Files/image/Articles/' . $article->name . '/' . $article->image->file_name) }}"
                              loading="lazy"  class="card-img-top" title="{{ $article->name }}" alt="{{ $article->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/art.webp') }}" loading="lazy" class="card-img-top"
                                title="{{ $article->name }}" alt="{{ $article->name }}" />
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h3 class="card-title">
                                    {{ \Illuminate\Support\Str::limit($article->name, 25) }}

                                </h3>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>{{ $article->publish_date->format('Y-m-d') }}</span>
                            </div>
                            <div class="card-text">
                                <i class="fas fa-book-open book-icon"></i>

                                <p>يقدم ا.د حمد بن محمد الهاجرى مقال بعنوان
                                    {{ \Illuminate\Support\Str::limit($article->name, 35) }}

                                </p>

                            </div>
                            <div class="text-center">
                                <a href="{{ route('frontend.articles.article_content', $article->slug) }}"
                                    class="btn-card-more"
                                    title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-articles') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
                <a href="{{ route('frontend.articles.all-articles') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>

        </div>
        <!-- books content -->
        <div id="booksScreen" class="boo row row-cols-1 row-cols-md-3 g-4">
            <?php
            $books = \App\Models\Book::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('id', 'desc')
                ->paginate(4);
            ?>
            @forelse ($books as $book)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if (!empty($book->image->file_name))
                            <img src="{{ asset('Files/image/Books/' . $book->name . '/' . $book->image->file_name) }}"
                              loading="lazy"  class="card-img-top" title="{{ $book->name }}" alt="{{ $book->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/books.webp') }}" loading="lazy" class="card-img-top"
                                title="{{ $book->name }}" alt="{{ $book->name }}" />
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h3 class="card-title">
                                    {{ \Illuminate\Support\Str::limit($book->name, 25) }}

                                </h3>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>{{ $book->publish_date->format('Y-m-d') }}</span>
                            </div>
                            <div class="card-text">
                                <i class="fas fa-book-open book-icon"></i>

                                <p>يقدم ا.د حمد بن محمد الهاجرى كتاب بعنوان
                                    {{ \Illuminate\Support\Str::limit($book->name, 35) }}

                                </p>

                            </div>
                            <div class="text-center">
                                <a href="{{ route('frontend.books.book_content', $book->slug) }}" class="btn-card-more"
                                    title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-books') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
            <a href="{{ route('frontend.books.all-books') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
        <!-- pic content -->
        <div id="galleryScreen" class="pic row row-cols-1 row-cols-md-3 g-4">
            <?php
            $images = \App\Models\Image::whereHasMorph('imageable', [\App\Models\Gallery::class], function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->Active()->ActiveCategory();
            })
                ->orderBy('id', 'desc')
                ->paginate(8);
            ?>
            @forelse ($images as $image)
                <a href="{{ asset('Files/gallery/' . $image->file_name) }}" title="{{ $image->imageable->title }}"
                    class="col-sm-6 col-md-4 col-lg-3"
                    data-sub-html="{{ $image->description ? $image->description : ' ' }}">
                    <div class="card h-100">
                        <img src="{{ asset('Files/gallery/' . $image->file_name) }}" loading="lazy" class="card-img-top img-zoom"
                            alt="{{ $image->imageable->title }}" title="{{ $image->imageable->title }}" />
                        <small class="img-caption">
                            @if ($image->description)
                                <i class="fas fa-pen-square title-icon"></i>
                                {{ $image->description }}
                            @endif
                        </small>
                    </div>
                </a>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-images') }}</span>
            @endforelse

            <div class="d-flex col-lg-12 w-100">
          <a href="{{ route('frontend.gallery.images') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
        <!-- ved content-->
        <div id="videoScreen" class="ved row row-cols-1 row-cols-md-3 g-4">
            <?php
            $videos = \App\Models\Video::whereHasMorph('videoable', '*', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query
                    ->where('youtube_link', 'like', 'https%')
                    ->orWhere('youtube_link', '!=', '')
                    ->Active()
                    ->ActiveCategory();
            })
                ->orderBy('id', 'desc')
                ->paginate(8);
            ?>
            @forelse ($videos as $video)
                <?php
                $url = getYoutubeId($video->youtube_link);
                ?>
                <div rel="nofollow" class="col-sm-6 col-md-4 col-lg-3" data-src="{{ $video->youtube_link }}">
                    <div class="card h-100">
                        <div class="overlay">
                            <img src="{{ asset('frontend/img/vedios.webp') }}" loading="lazy" alt=""
                                class="img-youtube-icon" />
                        </div>
                        <img src="https://img.youtube.com/vi/{{ $url }}/mqdefault.jpg"
                          loading="lazy"  class="card-img-top img-zoom" />
                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-videoes') }}</span>
            @endforelse
             <div class="d-flex col-lg-12 w-100">
            <a href="{{ route('frontend.library.videos') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
             </div>
        </div>
        <!-- mic content -->
        <div id="audioScreen" class="mic row row-cols-1 row-cols-md-3 g-4">
            <?php
            $audioes = \App\Models\Audio::whereHasMorph('audioable', '*', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query
                    ->where('embed_link', '!=', '')
                    ->orWhere('audio_file', '!=', '')
                    ->Active()
                    ->ActiveCategory()
                    ->Publish();
            })
                ->orderBy('id', 'desc')
                ->paginate(8);
            ?>
            @forelse ($audioes as $audio)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        <img src="{{ asset('frontend/img/hqdefault.webp') }}" loading="lazy" class="card-img-top"
                            alt="{{ $audio->name }}" title="{{ $audio->name }}" />
                        <div class="card-body">
                            <div class="d-inline-flex">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h3 class="card-title">

                                    {{ \Illuminate\Support\Str::limit($audio->name, 50) }}

                                </h3>
                            </div>
                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span> {{ $audio->publish_date->format('Y-m-d') }} </span>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('frontend.audio-library.audio.content', $audio->slug) }}"
                                    class="btn-card-more"
                                    title=" {{ trans('frontend.listen') }}">{{ trans('frontend.listen') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span class="noContentNew">{{ trans('frontend.no-audioes') }}</span>
            @endforelse
            <div class="d-flex col-lg-12 w-100">
         <a href="{{ route('frontend.audio-library.audio') }}" class="main-btns dataAttrMore" target="_blank">{{ trans('frontend.more_details') }}</a>
            </div>
        </div>
    </section>
    <!-- end new data -->
    <!-- start coming soon event -->
     <section class="coming-soon">
        <div class="shadow-head">
            <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" alt="{{ trans('frontend.events') }}"
                title="{{ trans('frontend.events') }}" />
            <h2 class="text-center mb-5">{{ trans('frontend.events') }}</h2>
        </div>
        <?php
        $events = \App\Models\Event::where('start', '>', \Carbon\Carbon::now())
            ->orderBy('id', 'desc')
            ->paginate(3);
        ?>
        @if ($events->count() > 0)
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            @if ($events->count() > 1)
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              @endif
            <div class="carousel-inner">
                @foreach ($events as $event)
                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }} ">
                    <div class=" justify-content-center w-100 eventSliderContent">
                    <div  class="d-flex align-items-center eventSliderContentCard" style="width : 420px">
                        <div class="eventSlider">
                            <div class="eventSliderTitles">
                                <p>
                                    <i class="fas fa-comment-alt"></i>
                                  {{ $event->title }}
                                </p>
                                <p class="text-black d-flex">
                                    <i class="fas fa-video"></i>
                                  {{ $event->type }}
                                </p>
                                <p class="text-secondary d-flex">
                                    <i class="fas fa-map-marked-alt"></i>
                                     {{ $event->place }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center time-details">
                                <div>
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="text-center m-auto d-flex align-items-center">
                                  <span class="day-time">
                                    {{ \Carbon\Carbon::parse($event->start)->format('d') }}

                                </span>
                                  <p class="month-time" style="margin: 0 16px ; color: var(--scoundry-color);">
                                    {{ \Carbon\Carbon::parse($event->start)->locale('ar')->isoFormat('MMMM') }}
                                </p>
                                  <p class="t-time d-flex m-0">
                                    <span>
                                        {{ date('g:ia', strtotime($event->start)) }}
                                    </span>
                                  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('Files/image/Events/'.$event->title.'/'.$event->photo) }}"
                     class="d-block" style="width: 420px ; height : 420px" alt="{{ $event->title }} " title="{{ $event->title }} ">
                    </div>
                </div>


            @endforeach

            </div>

          </div>
          @else

         <div class="coming-soon-content align-items-center m-0 row">
            <div class="col-md-5 col-lg-6 text-center p-svg">
                <img class="w-75 h-50" src="{{ asset('frontend/img/calender.svg') }}" alt="{{ trans('frontend.events') }}"
                    title="{{ trans('frontend.events') }}" />
            </div>


            <div class="col-md-7 col-lg-6 real-come">
                    <div class="text-center defult-come">
                        <div class="defult-come-content">
                            <i class="fas fa-microphone-alt-slash"></i>
                            <p class="text-white mt-4 fw-bold "> {{ trans('frontend.event-title1') }}</p>
                            <p> {{ trans('frontend.event-title2') }}</p>
                        </div>
                    </div>
            </div>

        </div>

          @endif
    </section>
    <!--end coming soon event -->
    <!-- start statistics -->
    <?php
    $fatwa = \App\Models\Fatwa::with('fatwa_answer')
        ->HasAnswer()
        ->Active()
        ->count();
    $lecture = \App\Models\Lecture::Active()
        ->Publish()
        ->count();
    $lesson = \App\Models\Lesson::Active()
        ->Publish()
        ->count();
    $speech = \App\Models\Speech::Active()
        ->Publish()
        ->count();
    $article = \App\Models\Article::Active()
        ->Publish()
        ->count();
    $book = \App\Models\Book::Active()
        ->Publish()
        ->count();
    $image = \App\Models\Image::where('imageable_type', 'App\Models\Gallery')->count();
    $audio = \App\Models\Audio::whereHasMorph('audioable', '*', function (\Illuminate\Database\Eloquent\Builder $query) {
                    $query->where('embed_link', '!=', '')
                    ->orWhere('audio_file', '!=', '')
                    ->Active()
                    ->ActiveCategory()
                    ->Publish();
            })->Publish()->count();

        $video = \App\Models\Video::whereHasMorph('videoable', '*', function (\Illuminate\Database\Eloquent\Builder $query) {
            $query
                ->where('youtube_link', 'like', 'https%')
                ->orWhere('youtube_link', '!=', '')
                ->Active()
                ->ActiveCategory();
        })->count();
    ?>
    <section class="statistics mt-5 pt-3 pb-5">
        <h2 class="text-center my-4">{{ trans('frontend.statistics') }}</h2>
        <div class="row m-0 align-items-center">
            <div class="col-md-6 text-center">
                <img class="img-fluid" style="width:100% ; height : 100%" src="{{ asset('frontend/img/statistics.svg') }}"
                   loading="lazy"  alt="{{ trans('frontend.statistics') }}" title="{{ trans('frontend.statistics') }}" />
            </div>

            <div class="col-md-6 statistics-counter">
                <div class="row allCounters justify-content-center">
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-book-open"></i>
                        <span class="d-block counter-num" data-goal="{{ $lesson }}">0</span>
                        <p>{{ trans('frontend.lessons') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-microphone-alt"></i>
                        <span class="d-block counter-num" data-goal="{{ $lecture }}">0</span>
                        <p>{{ trans('frontend.lectures') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-microphone"></i>
                        <span class="d-block counter-num" data-goal="{{ $speech }}">0</span>
                        <p>{{ trans('frontend.speeches') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-pen"></i>
                        <span class="d-block counter-num" data-goal="{{ $article }}">0</span>
                        <p>{{ trans('frontend.articles') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-book"></i>
                        <span class="d-block counter-num" data-goal="{{ $book }}">0</span>
                        <p>{{ trans('frontend.books') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-question"></i>
                        <span class="d-block counter-num" data-goal="{{ $fatwa }}">0</span>
                        <p>{{ trans('frontend.fatwa') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-images"></i>
                        <span class="d-block counter-num" data-goal="{{ $image }}">0</span>
                        <p>{{ trans('frontend.gallery') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fab fa-youtube"></i>
                        <span class="d-block counter-num" data-goal="{{ $video }}">0</span>
                        <p>{{ trans('frontend.video') }}</p>
                    </div>
                    <div class="col-md-4 col-lg-3 counter-box text-center">
                        <i class="fas fa-microphone-alt"></i>
                        <span class="d-block counter-num" data-goal="{{ $audio }}">0</span>
                        <p>{{ trans('frontend.audio') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end statistics -->
    <!--start pray times -->
    <section class="pray-times">
        <div class="shadow-head">
            <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}" loading="lazy" alt="{{ trans('frontend.pray') }}"
                title="{{ trans('frontend.pray') }}" />
            <h2 class="text-center">{{ trans('frontend.pray') }}</h2>
        </div>
        <div class="row m-0 align-items-center pray">
            <div class="col-md-7 text-center p-svg">
                <img style=" width : 100% ; max-width: 80%  ; margin-bottom : 15px ; height : 100%" src="{{ asset('frontend/img/pray.svg') }}"
                    alt="{{ trans('frontend.pray') }}" title="{{ trans('frontend.pray') }}" />
            </div>
            <div class="col-md-5 text-center pray-embbed"></div>
            <div class="col-md-5 text-center pray-api-box prayFadeOut">
                <div class="dayTime d-inline-flex align-items-center">
                    <div>
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="day-time">
                        <span>{{ trans('frontend.today') }}</span>
                        <span class="d-block dayInWeek"></span>
                    </div>
                    <div class="day-time-dd">
                        <p class="day-time-date day-hajri"></p>
                        <p class="day-time-date d-block day-m"></p>
                    </div>
                </div>
                <div class="all-prayTime">
                    <div class="prayTime-box d-inline-flex">
                        <i class="fas fa-moon"></i>
                        <p>
                            {{ trans('frontend.fajr') }}
                            <span class="t fajr"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                    <div class="prayTime-box d-inline-flex">
                        <i class="fas fa-cloud-sun fs-4"></i>
                        <p>
                            {{ trans('frontend.shrouk') }}
                            <span class="t shrouk"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                    <div class="prayTime-box d-inline-flex">
                        <i class="fas fa-sun"></i>
                        <p>
                            {{ trans('frontend.zuhr') }}

                            <span class="t zuhr"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                    <div class="prayTime-box d-inline-flex">
                        <i class="far fa-sun"></i>
                        <p>
                            {{ trans('frontend.aser') }}

                            <span class="t aser"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                    <div class="prayTime-box d-inline-flex">
                        <i class="fas fa-cloud-moon fs-4"></i>
                        <p>
                            {{ trans('frontend.maqhreb') }}

                            <span class="t maqhreb"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                    <div class="prayTime-box d-inline-flex">
                        <i class="far fa-moon fs-3"></i>
                        <p>
                            {{ trans('frontend.easha') }}

                            <span class="t easha"></span>
                            <span class="tt"></span>
                            <i class="fas fa-clock tt"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--end pray times -->
    <!-- start subscribe & twitter -->
    <section class="sub-twitter mt-5 pt-3 pb-5">
        <div class="row m-0 text-center align-items-center">
            <div class="col-md-6">
                <div class="twite-ifram nicescroll-rails m-auto" id="ascrail2000" style="width: 75%;">
                    <iframe loading="lazy" id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true"
                        allowfullscreen="true" class=""
                        style="
                              position: static;
                              visibility: visible;
                              width: 360px;
                              height: 5000px;
                              display: block;
                              flex-grow: 1;
                    "
                        title="Twitter Timeline"
                        src="https://syndication.twitter.com/srv/timeline-profile/screen-name/DrHamadAlhajri?dnt=false&amp;embedId=twitter-widget-0&amp;features=eyJ0ZndfdGltZWxpbmVfbGlzdCI6eyJidWNrZXQiOlsibGlua3RyLmVlIiwidHIuZWUiLCJ0ZXJyYS5jb20uYnIiLCJ3d3cubGlua3RyLmVlIiwid3d3LnRyLmVlIiwid3d3LnRlcnJhLmNvbS5iciJdLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X2hvcml6b25fdGltZWxpbmVfMTIwMzQiOnsiYnVja2V0IjoidHJlYXRtZW50IiwidmVyc2lvbiI6bnVsbH0sInRmd190d2VldF9lZGl0X2JhY2tlbmQiOnsiYnVja2V0Ijoib24iLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X3JlZnNyY19zZXNzaW9uIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19zaG93X2J1c2luZXNzX3ZlcmlmaWVkX2JhZGdlIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19jaGluX3BpbGxzXzE0NzQxIjp7ImJ1Y2tldCI6ImNvbG9yX2ljb25zIiwidmVyc2lvbiI6bnVsbH0sInRmd190d2VldF9yZXN1bHRfbWlncmF0aW9uXzEzOTc5Ijp7ImJ1Y2tldCI6InR3ZWV0X3Jlc3VsdCIsInZlcnNpb24iOm51bGx9LCJ0Zndfc2Vuc2l0aXZlX21lZGlhX2ludGVyc3RpdGlhbF8xMzk2MyI6eyJidWNrZXQiOiJpbnRlcnN0aXRpYWwiLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X2V4cGVyaW1lbnRzX2Nvb2tpZV9leHBpcmF0aW9uIjp7ImJ1Y2tldCI6MTIwOTYwMCwidmVyc2lvbiI6bnVsbH0sInRmd19kdXBsaWNhdGVfc2NyaWJlc190b19zZXR0aW5ncyI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdmlkZW9faGxzX2R5bmFtaWNfbWFuaWZlc3RzXzE1MDgyIjp7ImJ1Y2tldCI6InRydWVfYml0cmF0ZSIsInZlcnNpb24iOm51bGx9LCJ0Zndfc2hvd19ibHVlX3ZlcmlmaWVkX2JhZGdlIjp7ImJ1Y2tldCI6Im9uIiwidmVyc2lvbiI6bnVsbH0sInRmd19zaG93X2dvdl92ZXJpZmllZF9iYWRnZSI6eyJidWNrZXQiOiJvZmYiLCJ2ZXJzaW9uIjpudWxsfSwidGZ3X3Nob3dfYnVzaW5lc3NfYWZmaWxpYXRlX2JhZGdlIjp7ImJ1Y2tldCI6Im9mZiIsInZlcnNpb24iOm51bGx9LCJ0ZndfdHdlZXRfZWRpdF9mcm9udGVuZCI6eyJidWNrZXQiOiJvbiIsInZlcnNpb24iOm51bGx9fQ%3D%3D&amp;frame=false&amp;hideBorder=false&amp;hideFooter=false&amp;hideHeader=false&amp;hideScrollBar=false&amp;lang=ar&amp;origin=https%3A%2F%2Fhamadalhajri.net%2F&amp;sessionId=6dbe317b63cb46451a94d3afb6172c4ff09356b1&amp;showHeader=true&amp;showReplies=false&amp;transparent=false&amp;widgetsVersion=a3525f077c700%3A1667415560940">
                        <div id="ascrail2000-hr" class="nicescroll-rails"
                            style="
                        height: 10px;
                        z-index: 2999;
                        position: fixed;
                        left: 0px;
                        width: 60%;
                        bottom: 0px;
                        opacity: 1;
                        cursor: default;
                        display: none;
                      ">
                            <div
                                style="
                          position: relative;
                          top: 0px;
                          height: 10px;
                          width: 1536px;
                          background-color: rgb(240, 159, 5);
                          border: none;
                          background-clip: padding-box;
                          border-radius: 0px;
                        ">
                            </div>
                        </div>
                    </iframe>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card-subscribe">
                    <h3 class="pt-4"> {{ trans('frontend.subscribering') }}</h3>
                    <img class="img-fluid" style="width:100% ; height : 100%" src="{{ asset('frontend/img/subscribe.svg') }}"
                       loading="lazy" alt="{{ trans('frontend.subscribering') }}" title="{{ trans('frontend.subscribering') }}" />
                    <p> {{ trans('frontend.add-subscribe') }}</p>
                    <form action="{{ route('frontend.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" name="email" class="form-control"
                            placeholder=" {{ trans('clients.email') }}" />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
{{--                         {!! RecaptchaV3::field('contact_us') !!}--}}
                          @error('g-recaptcha-response')
                          <span class="text-danger">{{ $message }}</span>
                          @enderror
                        <button class="main-btns m-3"
                            title=" {{ trans('frontend.send') }}">{{ trans('frontend.send') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- end subscribe & twitter -->
    <!-- start more download and more watchers -->
    <section class="allMore pt-4 pb-4">
        <div class="row m-0 justify-content-center text-center">
            <div class="col-md-6 moreDown">
                <div class="more-box d-inline-block">
                    <h4>{{ trans('frontend.more-download') }} </h4>
                    <?php
                    $lesson = \App\Models\Lesson::Active()
                        ->ActiveCategory()
                        ->Publish()
                        ->orderBy('download_count', 'desc')
                        ->first();
                    $lecture = \App\Models\Lecture::Active()
                        ->ActiveCategory()
                        ->Publish()
                        ->orderBy('download_count', 'desc')
                        ->first();
                    $article = \App\Models\Article::Active()
                        ->ActiveCategory()
                        ->Publish()
                        ->orderBy('download_count', 'desc')
                        ->first();
                    $speech = \App\Models\Speech::Active()
                        ->ActiveCategory()
                        ->Publish()
                        ->orderBy('download_count', 'desc')
                        ->first();
                    $book = \App\Models\Book::Active()
                        ->ActiveCategory()
                        ->Publish()
                        ->orderBy('download_count', 'desc')
                        ->first();

                    ?>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-download"></i>
                        <a href="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}"
                            title="{{ $lesson->name }}">{{ \Illuminate\Support\Str::limit($lesson->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-download"></i>
                        <a href="{{ route('frontend.lectures.lecture_content', $lecture->slug) }}"
                            title="{{ $lecture->name }}">{{ \Illuminate\Support\Str::limit($lecture->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-download"></i>
                        <a href="{{ route('frontend.articles.article_content', $article->slug) }}"
                            title="{{ $article->name }}">{{ \Illuminate\Support\Str::limit($article->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-download"></i>
                        <a href="{{ route('frontend.speeches.speech_content', $speech->slug) }}"
                            title="{{ $speech->name }}">{{ \Illuminate\Support\Str::limit($speech->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-download"></i>
                        <a href="{{ route('frontend.books.book_content', $book->slug) }}"
                            title="{{ $book->name }}">{{ \Illuminate\Support\Str::limit($book->name, 35)  ?? '' }}</a>
                    </div>
                </div>
            </div>
            <?php
            $lesson = \App\Models\Lesson::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('view_count', 'desc')
                ->first();
            $lecture = \App\Models\Lecture::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('view_count', 'desc')
                ->first();
            $article = \App\Models\Article::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('view_count', 'desc')
                ->first();
            $speech = \App\Models\Speech::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('view_count', 'desc')
                ->first();
            $book = \App\Models\Book::Active()
                ->ActiveCategory()
                ->Publish()
                ->orderBy('view_count', 'desc')
                ->first();

            ?>
            <div class="col-md-6 moreWatch">
                <div class="more-box d-inline-block">
                    <h4>{{ trans('frontend.more-view') }}</h4>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-eye"></i>
                        <a href="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}"
                            title="{{ $lesson->name }}">{{ \Illuminate\Support\Str::limit($lesson->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-eye"></i>
                        <a href="{{ route('frontend.lectures.lecture_content', $lecture->slug) }}"
                            title="{{ $lecture->name }}">{{ \Illuminate\Support\Str::limit($lecture->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-eye"></i>
                        <a href="{{ route('frontend.articles.article_content', $article->slug) }}"
                            title="{{ $article->name }}">{{ \Illuminate\Support\Str::limit($article->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-eye"></i>
                        <a href="{{ route('frontend.speeches.speech_content', $speech->slug) }}"
                            title="{{ $speech->name }}">{{ \Illuminate\Support\Str::limit($speech->name, 35)  ?? '' }}</a>
                    </div>
                    <div class="text-end mt-3 mb-4">
                        <i class="fas fa-eye"></i>
                        <a href="{{ route('frontend.books.book_content', $book->slug) }}"
                            title="{{ $book->name }}">{{ \Illuminate\Support\Str::limit($book->name, 35)  ?? '' }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end more download and more watchers -->
    <!-- start ask for fatwa -->
    <section class="fatwa">
        <div class="shadow-head">
            <img class="shadow-img" src="{{ asset('frontend/img/shadow.svg') }}"
                alt="{{ trans('frontend.fatwa-req') }}" title="{{ trans('frontend.fatwa-req') }}" />
            <h2 class="text-center">{{ trans('frontend.fatwa-req') }}</h2>
            <p class="text-center" >{{ trans('frontend.fatwa-title') }}</p>
            <p class="text-center" style="color:var(--text-color)">{{ trans('btns.login-first') }}</p>
        </div>
        <form action="" method="" id="offerForm" class="fadeFatwa fade-out">
            @csrf
            <div class="row m-auto justify-content-center inputHead">
                <input class="col-sm-12 col-lg-6 form-control" id="nameContent" type="text" name="name"
                    placeholder="{{ trans('clients.name') }}" />
                <!--<input class="col-sm-12 col-lg-6 form-control" id="phoneContent" type="text" name="phone"-->
                <!--    placeholder="{{ trans('clients.phone') }}" />-->
                <input class="email-input form-control col-sm-12 col-lg-6" type="email" id="emailContent" name="email"
                placeholder="{{ trans('clients.email') }}" />
            </div>

            <textarea class="p-2 mt-2" name="message" id="textAreaContent" placeholder="{{ trans('frontend.message') }}"></textarea>
            <button class="main-btns m-auto d-block mt-4" id="save_fatwa"
                title="{{ trans('frontend.send') }}">{{ trans('frontend.send') }}</button>
        </form>
    </section>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->

    <script  src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
    <script  src="{{ asset('frontend/js/lg-autoplay.min.js') }}"></script>
    <script   src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script>
    $("#ascrail2000").niceScroll({
      cursorwidth: 5,
      cursoropacitymin: 0.4,
      cursorcolor: "rgb(240, 159, 5)",
      cursorborder: "none",
      cursorborderradius: 4,
      autohidemode: "leave",
    });
    </script>
    <script defer src="{{ asset('frontend/js/main.js') }}"></script>


    {{-- add fatwa --}}

    <script>
     $(document).ready(function(){
         $(".twite-ifram").attr("tabindex","0");
     })
    </script>
    <script>
        $(document).ready(function() {
            $('#save_fatwa').on('click', function(e) {

                e.preventDefault();

                    Swal.fire({
                    title: "Loading...",
                    html: "Please wait a moment"
                    })
                    Swal.showLoading()
                var formData = new FormData($('#offerForm')[0]);

                $.ajax({
                    url: "{{ route('frontend.fatwa') }}",
                    type: "POST",
                    datType: "json",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
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
                $("#nameContent").val("");
                //$("#phoneContent").val("");
                $("#emailContent").val("");
                $("#textAreaContent").val("");

            });
        });
    </script>

@endsection
