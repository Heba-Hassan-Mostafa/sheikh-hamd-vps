@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="معرض,الصور,الشيخ,حمد,الهاجرى,دينية,اسلامية,احاديث,صور">
    <meta name="description"
        content="معرض الصور للشيخ الدكتور حمد بن محمد الهاجرى فى علوم الشريعة والفقة المقارن والسياسة الشرعية">
    <meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.matwiaat') }}
@endsection
@section('content')
    <!-- start categories content -->

    <div class="headCategoriesImg">
        @if (setting()->matwiaat_banner)
            <img src="{{ asset('Files/settings/' . setting()->matwiaat_banner) }}" alt=" {{ trans('frontend.gallery') }}"
                title=" {{ trans('frontend.matwiaat') }}" />
            {{-- @else
        <img src="{{ asset('frontend/img/pic-back.png') }}" alt="" /> --}}
        @endif
    </div>

    <!-- start row  with categories-->
    <div class="row m-0 cardCat align-items-start">

        <div class="col-md-11 row allCategoriesCard">
            <div class=" row row-cols-1 row-cols-md-3 g-4">


                @forelse ($matwiaats as $matwiaat)
                    <div>
                        <div class="pic">
                            <a href="{{ asset('Files/Matwiaat/' . $matwiaat->image) }}" title="{{ $matwiaat->title }}">
                                <img style="height: 250px" src="{{ asset('Files/Matwiaat/' . $matwiaat->image) }}"
                                    class="card-img-top" alt="{{ $matwiaat->title }}" title="{{ $matwiaat->title }}">
                            </a>
                        </div>
                        <span class="img-caption text-white d-block w-100 text-center"
                            style=" background: #967C15;
                                    border-radius: 0 0 10px 10px;">

                            <a class="text-white" href=""></a>
                            <div
                                style="
                            display: flex;
                            justify-content: space-between;
                            padding: 0 24px;
                        ">
                                <span> {{ $matwiaat->title }}

                                </span>
                                <span>
                                    <a href="{{ asset('Files/Matwiaat/PDF/'.$matwiaat->pdf_file) }}" class="downMatwaya" download>
                                        <i class="fas fa-download"
                                            style="
                                    color: #fff;
                                    font-size: 18px;"></i>
                                    </a>
                                </span>
                            </div>
                        </span>
                    </div>

                @empty
                @endforelse



            </div>
            <div class="float-right">

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
