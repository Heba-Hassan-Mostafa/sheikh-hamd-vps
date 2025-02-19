@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="المكتبة,المرئية,الشيخ,حمد,الهاجرى,دينية,اسلامية,مقاطع,صوتية,مرئية,تحميل">
    <meta name="description"
        content="المكتبة المرئية للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
    <meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.video-library') }}
@endsection
@section('content')
    <div class="headCategoriesImg">
        @if (setting()->video_banner)
            <img src="{{ asset('Files/settings/' . setting()->video_banner) }}" alt="{{ trans('frontend.video-library') }}"
                title="{{ trans('frontend.video-library') }}" />
            {{-- @else
        <img src="{{ asset('frontend/img/vid-back.png') }}" alt="" /> --}}
        @endif
    </div>

    <!-- start row  with categories-->
    <div class="row m-0 cardCat align-items-start">
        <div class="col-md-3 sideCategories">
            <div class="allCategories">
                <h1>
                    <i class="fas fa-bars"></i>
                    {{ trans('frontend.categories') }}
                </h1>
            </div>
            <div class="categoriesList">
                <div class="allLinks">
                    <i class="fas fa-bars allCa"></i>
                    <h2>
                        <a href="{{ route('frontend.library.videos') }}" title="{{ trans('frontend.all') }}"
                            style="color: var(--main-color);">{{ trans('frontend.all') }}
                            <span>({{ App\Models\Video::whereHasMorph('videoable', '*', function (Illuminate\Database\Eloquent\Builder $query) {
                                $query->where('youtube_link', 'like', 'https%')->orWhere('youtube_link', '!=', ' ')->Active()->ActiveCategory();
                            })->count() }})</span></a>
                    </h2>
                </div>
                <div class="categoriesListUl">
                    <ul>

                        <li>
                            <i class="fas fa-level-down-alt"></i>
                            <a href="{{ route('frontend.library.lesson.videos') }}"
                                title="{{ trans('frontend.lessons') }}">
                                {{ trans('frontend.lessons') }}
                                <span>({{ App\Models\Video::whereHasMorph('videoable', [App\Models\Lesson::class], function (
                                    Illuminate\Database\Eloquent\Builder $query,
                                ) {
                                    $query->where('youtube_link', 'like', 'https%')->orWhere('youtube_link', '!=', ' ')->Active()->ActiveCategory();
                                })->count() }})</span></a>
                        </li>
                        <li>
                            <i class="fas fa-level-down-alt"></i>
                            <a href="{{ route('frontend.library.lecture.videos') }}"
                                title="{{ trans('frontend.lectures') }}">
                                {{ trans('frontend.lectures') }}<span>({{ App\Models\Video::whereHasMorph('videoable', [App\Models\Lecture::class], function (
                                    Illuminate\Database\Eloquent\Builder $query,
                                ) {
                                    $query->where('youtube_link', 'like', 'https%')->orWhere('youtube_link', '!=', ' ')->Active()->ActiveCategory();
                                })->count() }})</span></a>
                        </li>
                        <li>
                            <i class="fas fa-level-down-alt"></i>
                            <a href="{{ route('frontend.library.article.videos') }}"
                                title="{{ trans('frontend.articles') }}">
                                {{ trans('frontend.articles') }}
                                <span>({{ App\Models\Video::whereHasMorph('videoable', [App\Models\Article::class], function (
                                    Illuminate\Database\Eloquent\Builder $query,
                                ) {
                                    $query->where('youtube_link', 'like', 'https%')->orWhere('youtube_link', '!=', ' ')->Active()->ActiveCategory();
                                })->count() }})</span></a>
                        </li>
                        <li>
                            <i class="fas fa-level-down-alt"></i>
                            <a href="{{ route('frontend.library.speech.videos') }}"
                                title="{{ trans('frontend.speeches') }}">
                                {{ trans('frontend.speeches') }}
                                <span>({{ App\Models\Video::whereHasMorph('videoable', [App\Models\Speech::class], function (
                                    Illuminate\Database\Eloquent\Builder $query,
                                ) {
                                    $query->where('youtube_link', 'like', 'https%')->orWhere('youtube_link', '!=', ' ')->Active()->ActiveCategory();
                                })->count() }})</span></a>
                        </li>
                    </ul>
                </div>
          <div class="categoriesListUl">
                    <?php
                    $categories = App\Models\VideoCategory::Active()->orderBy('order_position','asc')->get();

                    ?>
                    <ul>
                        <i class="fas fa-bars allCa"></i>
                        <a class="otherAudio" href="{{ route('frontend.library.another.video') }}" title="{{ trans('frontend.another-videos') }}">
                            {{ trans('frontend.another-videos') }} <span>
                                ({{ App\Models\Video::where(
                                'videoable_type',[App\Models\Video::class],
                                function (Illuminate\Database\Eloquent\Builder $query) {
                                    $query->where('youtube_link', 'like', 'https%')
                                            ->orWhere('video_file', '!=' , '')
                                    ->Active()->ActiveCategory();

                                })->count() }})</span>
                        </a>

                    </ul>
                  </div>
            </div>
        </div>
        <div class="col-md-8 row allCategoriesCard">
            <div class="pic row row-cols-1 row-cols-md-3 g-4">
                @forelse ($videos as $video)
                    <?php
                    $url = getYoutubeId($video->youtube_link);
                    ?>
                        <a class="col-sm-6 col-md-4" data-src="{{ $video->youtube_link }}">
                            <div class="card h-100">
                                <div class="overlay">
                                    <img src="{{ asset('frontend/img/vedios.webp') }}" alt=""
                                        class="img-youtube-icon" />
                                </div>
                                <img src="https://img.youtube.com/vi/{{ $url }}/mqdefault.jpg"
                                    class="card-img-top img-zoom" />
                            </div>
                        </a>

                @empty

                    <h2 class="font-weight-bold mt-5 text-center" style="width: 100%;pointer-events: none;">
                        {{ trans('frontend.no-videoes') }}
                    </h2>
                @endforelse


            </div>
            <div class="float-right">
                {!! $videos->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/lg-autoplay.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/light.js') }}"></script>

    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
