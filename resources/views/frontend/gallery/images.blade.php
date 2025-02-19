@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="معرض,الصور,الشيخ,حمد,الهاجرى,دينية,اسلامية,احاديث,صور">
    <meta name="description"
        content="معرض الصور للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
    <meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.gallery') }}
@endsection
@section('content')
    <!-- start categories content -->

    <div class="headCategoriesImg">
        @if (setting()->gallery_banner)
            <img src="{{ asset('Files/settings/' . setting()->gallery_banner) }}" alt=" {{ trans('frontend.gallery') }}"
                title=" {{ trans('frontend.gallery') }}" />
            {{-- @else
        <img src="{{ asset('frontend/img/pic-back.png') }}" alt="" /> --}}
        @endif
    </div>

    <!-- start row  with categories-->
    <div class="row m-0 cardCat align-items-start">

        <div class="col-md-11 row allCategoriesCard">
            <div class=" row row-cols-1 row-cols-md-3 g-4">
                @forelse ($categories as $category)
                            <?php
                            $gallery = App\Models\Gallery::withCount('images')
                                ->where('gallery_category_id', $category->id)
                                ->first();
                            $count = $gallery->images_count ?? 0;
                            ?>
                    <div>
                        <div class="pic">
                            <a href="{{ asset('Files/GalleryCategory/'.$category->image) }}" title="{{ $category->name }}">
                                <img style="height: 175px" src="{{ asset('Files/GalleryCategory/'.$category->image) }}"
                                    class="card-img-top" alt="" title="">
                            </a>
                        </div>
                        <span class="img-caption text-white d-block w-100 text-center"
                            style=" background: #967C15;
                                    border-radius: 0 0 10px 10px;">

                            <a class="text-white" href="{{ route('frontend.gallery.category',$category->slug) }}">{{ $category->name }}</a>
                            <span> ({{ $count }}) </span>
                        </span>
                    </div>
                @empty

                    <h2 class="font-weight-bold mt-5 text-center" style="width: 100%;pointer-events: none;">
                        {{ trans('frontend.no-images') }}
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
