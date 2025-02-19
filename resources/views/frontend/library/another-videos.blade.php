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
                    <?php
                    $categories = App\Models\VideoCategory::Active()->orderBy('order_position','asc')->get();

                    ?>
                    <ul>
                        <i class="fas fa-bars allCa"></i>
                        <a class="otherAudio" href="{{ route('frontend.library.another.video') }}" title="{{ trans('frontend.another-videos') }}">
                            {{ trans('frontend.another-videos') }} <span>
                                ({{ App\Models\Video::whereHasMorph(
                                'videoable',[App\Models\Video::class],
                                function (Illuminate\Database\Eloquent\Builder $query) {
                                    $query->where('youtube_link', '!=' ,'')
                                            ->orWhere('video_file', '!=' , '')
                                    ->Active()->ActiveCategory();

                                })->count() }})</span>
                        </a>
                        @forelse ($categories as $category)
                        <li>
                            <i class="fas fa-level-down-alt"></i>
                            <a href="{{ route('frontend.library.video.category',$category->slug) }}" title="{{ $category->name }}">
                                {{ $category->name }} <span>({{ $category->videos->count() }})</span></a>
                        </li>
                        @empty

                        <!--<span>{{ trans('frontend.no-cats') }}</span>-->
                        @endforelse

                    </ul>
                  </div>
            </div>
        </div>
        <div class="col-md-8 row my_card allCategoriesCard">
            <div class="audioLib row row-cols-1 row-cols-md-3 g-4 justify-content-center ">
                @forelse ($videos as $video)
                    <div class="col-sm-6 col-md-4">
                        <div class="card h-100">
                            <img src="{{ asset('frontend/img/vediodefault.webp') }}" class="card-img-top"
                                alt="{{ $video->name }}" title="{{ $video->name }}" />
                            <div class="card-body">
                                <div class="d-inline-flex">
                                    <i class="fas fa-pen-square title-icon"></i>
                                    <h6 class="card-title">
                                        {{ $video->name }}
                                    </h6>
                                </div>
                                <div class="date-details">
                                    <i class="fas fa-calendar-alt date-icon"></i>
                                    <span>{{ $video->publish_date->format('Y-m-d') }}</span>
                                </div>
                                <div class="text-center mt-4">
                                    <a href="{{ route('frontend.library.videos.content', $video->slug) }}"
                                        class="btn-card-more"
                                        title="{{ trans('frontend.watch') }}">{{ trans('frontend.watch') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty

                    <span class="text-center">{{ trans('frontend.no-videoes') }}</span>
                @endforelse
            </div>
            <div class="float-right">
                {!! $videos->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
