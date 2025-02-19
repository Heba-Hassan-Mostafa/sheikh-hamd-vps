@extends('frontend.design.master')
@section('meta')
<meta name="keywords" content="معرض,الصور,الشيخ,حمد,الهاجرى,دينية,اسلامية,احاديث,صور">
<meta name="description" content="معرض الصور للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
<meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.gallery') }}
@endsection
@section('content')
    <!-- start categories content -->

    <div class="headCategoriesImg">
        @if (setting()->gallery_banner)
        <img src="{{ asset('Files/settings/'.setting()->gallery_banner) }}" alt=" {{ trans('frontend.gallery') }}" title=" {{ trans('frontend.gallery') }}"/>
        {{-- @else
        <img src="{{ asset('frontend/img/pic-back.png') }}" alt="" /> --}}
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
                        <a href="{{ route('frontend.gallery.images') }}"
                            style="color: var(--main-color);" title="{{ trans('frontend.all') }}">{{ trans('frontend.all') }}
                            <span>({{ $images->count() }})</span></a></h2>
                </div>

                <div class="categoriesListUl">
                    <ul>
                        <i class="fas fa-bars"></i>
                        {{-- <h6 class="d-inline-block"> {{ trans('frontend.img-cat') }}</h6> --}}
                        @forelse ($categories as $category)
                        <?php
                        $gallery = App\Models\Gallery::withCount('images')->where('gallery_category_id',$category->id)->first();
                         $count =  $gallery->images_count ?? 0 ;
                      //dd($count);
                        ?>
                            <li>
                                <i class="fas fa-level-down-alt"></i>
                                <a href="{{ route('frontend.gallery.category',$category->slug) }}" title="{{ $category->name }}">
                                    {{ $category->name }} <span> ({{ $count }}) </span>
                                </a>
                            </li>
                        @empty

                            <span>{{ trans('frontend.no-cats') }}</span>
                        @endforelse

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 row allCategoriesCard">
            <div class="pic row row-cols-1 row-cols-md-3 g-4">
                @forelse ($images as $image)
                <a href="{{ asset('Files/gallery/'.$image->file_name) }}" class="col-sm-6 col-md-4 col-lg-4" data-sub-html="{{ $image->description }}">
                    <div class="card galleryPageCard h-100">
                        <img style="height: 175px" src="{{ asset('Files/gallery/'.$image->file_name) }}" class="card-img-top img-zoom" alt="{{ $image->imageable->title }}" title="{{ $image->imageable->title }}"/>
                        <span class="img-caption">
                         @if ($image->description)
                        <i class="fas fa-pen-square title-icon"></i>
                        {{  $image->description }}
                        @endif

                        </span>
                    </div>
                </a>
                @empty

                <h2 class="font-weight-bold mt-5 text-center"
                style="width: 100%;pointer-events: none;">{{ trans('frontend.no-images') }}
                </h2>
                @endforelse

            </div>
            <div class="float-right">
                {!! $images->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
    <!-- end row  with categories-->
    <!-- end categories content -->
@endsection
@section('script')

<script defer src="{{ asset('frontend/js/lightgallery.min.js') }}"></script>
<script defer src="{{ asset('frontend/js/lg-autoplay.min.js') }}"></script>
<script defer src="{{ asset('frontend/js/light.js') }}"></script>

<script defer src="{{ asset('frontend/js/allPages.js') }}"></script>
@endsection
