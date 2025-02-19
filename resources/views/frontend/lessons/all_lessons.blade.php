@extends('frontend.design.master')
@section('meta')
    <meta name="keywords" content="الدروس,اسلامية,تفسير,اية,قرآن كريم,مقاطع صوتية,تحميل,ملفات,الشيخ">
    <meta name="description" content="دروس فضيلة الشيخ الدكتور حمد بن محمد الهاجرى دروس دينية فقة شريعة تفسير">
    <meta name="author" content="{{ setting()->site_name }}">
@endsection
@section('title')
    {{ trans('frontend.lessons') }}
@endsection
@section('content')
    <!-- start row  with categories-->
    <?php
    $categories = \App\Models\LessonCategory::tree();
    ?>
    <div class="headCategoriesImg">
        @if (setting()->lesson_banner)
            <img src="{{ asset('Files/settings/' . setting()->lesson_banner) }}" alt=" {{ trans('frontend.lessons') }}"
                title=" {{ trans('frontend.lessons') }}" />
            {{-- @else
    <img src="{{ asset('frontend/img/les-back.png') }}" alt=""> --}}
        @endif
    </div>
    <div class="categoriesSearch">
        <form class="search-form">
            @csrf
            <input type="text" name="search" id="search" placeholder="{{ trans('frontend.search') }}"
                class="form-control search-input" />
            <button type="button" title="{{ trans('frontend.search') }}"><i class="fas fa-search"></i></button>
        </form>

    </div>
    <div class="row m-0 cardCat align-items-start">
        <div class="col-md-4 m-auto sideCategories">
            <div class=" allCategories">
                <h1> <i class="fas fa-bars"></i> {{ trans('frontend.categories') }} </h1>
            </div>
            <div class="categoriesList">
                <div class="allLinks">
                    <i class="fas fa-bars allCa"></i>
                    <h2><a href="{{ route('frontend.lessons.all-lessons') }}" title="{{ trans('frontend.lessons') }}">
                            {{ trans('frontend.all') }} <span style="color: var(--scoundry-color)">(<span style="color: var(--black-color)">{{\App\Models\Lesson::Active()->Publish()->count()}}</span>)</span></a></h2>
                </div>

                <div class="categoriesListUl">
                    @forelse ($categories as $category)
                        <ul>
                            <i class="fas fa-bars"></i>
                            <a href="{{ route('frontend.lessons.category.lessons', $category->slug) }}"
                                title=" {{ $category->name }}">
                                {{ $category->name }} <span style="color: var(--scoundry-color)"> (<span style="color: var(--black-color)">{{ $category->lessons->where('status',1)->where('publish_date','<=',\Carbon\Carbon::now())->count() }}</span>) </span>
                            </a>


                            @include('frontend.lessons.subCategoryList', [
                                'subcategories' => $category->subcategory,
                            ])

                        </ul>

                    @empty

                        <span>{{ trans('frontend.no-cats') }}</span>
                    @endforelse


                </div>
            </div>
        </div>
        <div class="col-md-8 my_card row allCategoriesCard">
            @forelse ($lessons as $lesson)
                <div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">
                        @if (!empty($lesson->image->file_name))
                            <img src="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                class="card-img-top" alt="{{ $lesson->name }}" title="{{ $lesson->name }}" />
                        @else
                            <img src="{{ asset('frontend/img/lessons.webp') }}" alt="{{ $lesson->name }}"
                                title="{{ $lesson->name }}">
                        @endif
                        <div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">
                                    {{ \Illuminate\Support\Str::limit($lesson->name, 25) }}
                                </h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>{{ $lesson->publish_date->format('Y-m-d') }}</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>

                                <p>يقدم ا.د حمد بن محمد الهاجرى درس بعنوان
                                    {{ \Illuminate\Support\Str::limit($lesson->name, 35) }}
                                </p>

                            </div>
                            <div class="text-center m-2">
                                <a href="{{ route('frontend.lessons.lesson_content', $lesson->slug) }}"
                                    class="btn-card-more"
                                    title="{{ trans('frontend.more') }}">{{ trans('frontend.more') }}</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>{{ $lesson->view_count }}</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>{{ $lesson->download_count }}</span>
                            </p>
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
                        @if ($check)
                            <button class="addToWish like" data-id="{{ $lesson->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        @else
                            <button class="addToWish" data-id="{{ $lesson->id }}">
                                <i class="far fa-heart"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @empty

                <h2 class="font-weight-bold mt-5 text-center">{{ trans('frontend.no-lessons') }}</h2>
            @endforelse
            <div class="float-right">
                {!! $lessons->appends(request()->all())->links() !!}
            </div>
        </div>

    </div>
    <!-- end row  with categories-->
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
    <script defer src="{{ asset('frontend/js/allPages.js') }}"></script>

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

                } else {
                    //alert('danger');
                    // $(this).find(">:first-child").toggleClass("like");

                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#search').on('keyup', function() {

                var value = $(this).val();
                // console.log(value);
                $.ajax({
                    url: " {{ route('frontend.lessons.lesson.search') }}",
                    type: "GET",
                    datType: "json",
                    data: {
                        'search': value
                    },
                    success: function(data) {
                        $('.my_card').html(data);
                    }

                });
            });
        });
    </script>
@endsection
