@extends('backend.layouts.master')

@section('css')
@endsection
@section('title')
    {{ trans('main_sidebar.Dashboard') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">{{ trans('main_sidebar.welcome-back') }}</h2>
            </div>
        </div>

    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h4 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.user-count') }}</h4>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <?php
                            $users = \App\Models\User::whereHas('roles')->count();
                            ?>
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $users }}</h4>
                                <a href="{{ route('admin.users.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="ion ion-person-add"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h4 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.lesson-count') }}</h4>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Lesson::count() }}</h4>
                                <a href="{{ route('admin.lessons.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="ion ion-person-add"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.lecture-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Lecture::count() }}</h4>
                                <a href="{{ route('admin.lectures.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.speech-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Speech::count() }}</h4>
                                <a href="{{ route('admin.speeches.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>

                            </div>
                            <span class="float-right my-auto mr-auto">

                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-secondary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.article-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Article::count() }}</h4>
                                <a href="{{ route('admin.articles.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>

                            </div>
                            <span class="float-right my-auto mr-auto">

                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline5" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-info-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.book-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Book::count() }}</h4>
                                <a href="{{ route('admin.books.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>

                            </div>
                            <span class="float-right my-auto mr-auto">

                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline6" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.benefit-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Benefit::count() }}</h4>
                                <a href="{{ route('admin.benefits.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>

                            </div>
                            <span class="float-right my-auto mr-auto">

                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline8" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">{{ trans('main_sidebar.fatwa-count') }}</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ \App\Models\Fatwa::count() }}</h4>
                                <a href="{{ route('admin.fatwa.index') }}" class="mb-0 tx-12 text-white op-7">
                                    {{ trans('main_sidebar.more-info') }} <i class="fas fa-arrow-circle-right"></i></a>

                            </div>
                            <span class="float-right my-auto mr-auto">

                                <span class="text-white op-7"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline7" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>


    </div>
    <!-- row closed -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">

                        {{ trans('main_sidebar.top_clients') }}
                    </div>
                    <p class="mg-b-20">
                        {{ trans('main_sidebar.get-subs') }}
                        <br>
                        {{ trans('main_sidebar.get-fatwa') }}
                    </p>
                    <div class="chartjs-wrapper-demo">
                        <canvas id="chartArea1"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- col-6 -->
        <div class="col-sm-12 col-md-6">
            <div class="card mg-b-md-20 overflow-hidden">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ trans('main_sidebar.top_visitors') }}
                    </div>
                    <p class="mg-b-20"> {{ trans('main_sidebar.get-visitors') }}</p>
                    <div class="chartjs-wrapper-demo">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
            </div>
        </div><!-- col-6 -->
    </div>

    <!-- /row -->
    <div class="row">

        <div style="height: 400px;" class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="tab nav-border" style="position: relative;">
                        <div class="d-block d-md-flex justify-content-between">
                            <div class="d-block w-100">
                                <h5 style="font-family: 'Cairo', sans-serif" class="card-title">
                                    {{ trans('main_sidebar.last-operations') }} </h5>
                            </div>
                            <div class="d-block d-md-flex nav-tabs-custom navCustom">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active show" id="lessons-tab" data-toggle="tab"
                                            href="#lessons" role="tab" aria-controls="lessons" aria-selected="true">
                                            {{ trans('main_sidebar.Lessons') }}</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="lectures-tab" data-toggle="tab" href="#lectures"
                                            role="tab" aria-controls="lectures"
                                            aria-selected="false">{{ trans('main_sidebar.lectures') }}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="articles-tab" data-toggle="tab" href="#articles"
                                            role="tab" aria-controls="articles" aria-selected="false">
                                            {{ trans('main_sidebar.articles') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="speeches-tab" data-toggle="tab" href="#speeches"
                                            role="tab" aria-controls="speeches" aria-selected="false">
                                            {{ trans('main_sidebar.speeches') }}
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="books-tab" data-toggle="tab" href="#books"
                                            role="tab" aria-controls="books" aria-selected="false">
                                            {{ trans('main_sidebar.books') }}
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefits"
                                            role="tab" aria-controls="benefits" aria-selected="false">
                                            {{ trans('main_sidebar.benefits') }}
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">

                            {{-- lessons Table --}}
                            <div class="tab-pane fade active show" id="lessons" role="tabpanel"
                                aria-labelledby="lessons-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('lessons.lesson-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(\App\Models\Lesson::latest()->take(5)->get() as $lesson)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lesson->name }}</td>
                                                    <td>{{ $lesson->category->name }}</td>
                                                    <td>{{ $lesson->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($lesson->publish_date)->diffforhumans() }}
                                                    </td>
                                                @empty
                                                    <td class="alert-danger" colspan="8">
                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- lectures Table --}}
                            <div class="tab-pane fade" id="lectures" role="tabpanel" aria-labelledby="lectures-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('lectures.lecture-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }} </th>
                                            </tr>
                                        </thead>

                                        @forelse(\App\Models\Lecture::latest()->take(5)->get() as $lecture)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lecture->name }}</td>
                                                    <td>{{ $lecture->category->name }}</td>
                                                    <td>{{ $lecture->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($lecture->publish_date)->diffforhumans() }}
                                                    </td>
                                                @empty
                                                    <td class="alert-danger" colspan="8">
                                                        {{ trans('main_sidebar.no-data') }} </td>
                                                </tr>
                                            </tbody>
                                        @endforelse
                                    </table>
                                </div>
                            </div>

                            {{-- articles Table --}}
                            <div class="tab-pane fade" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('articles.article-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(\App\Models\Article::latest()->take(5)->get() as $article)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $article->name }}</td>
                                                    <td>{{ $article->category->name }}</td>
                                                    <td>{{ $article->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($article->publish_date)->diffforhumans() }}
                                                    </td>
                                                @empty
                                                    <td class="alert-danger" colspan="8">
                                                        {{ trans('main_sidebar.no-data') }} </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- speeches Table --}}
                            <div class="tab-pane fade" id="speeches" role="tabpanel" aria-labelledby="speeches-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('speeches.speech-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(\App\Models\Speech::latest()->take(10)->get() as $speech)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $speech->name }}</td>
                                                    <td>{{ $speech->category->name }}</td>
                                                    <td>{{ $speech->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($speech->publish_date)->diffforhumans() }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="alert-danger" colspan="9">
                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- books Table --}}
                            <div class="tab-pane fade" id="books" role="tabpanel" aria-labelledby="books-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('books.book-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(\App\Models\Book::latest()->take(10)->get() as $book)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $book->name }}</td>
                                                    <td>{{ $book->category->name }}</td>
                                                    <td>{{ $book->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($book->publish_date)->diffforhumans() }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="alert-danger" colspan="9">
                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- benefits Table --}}
                            <div class="tab-pane fade" id="benefits" role="tabpanel" aria-labelledby="benefits-tab">
                                <div class="table-responsive mt-15">
                                    <table style="text-align: center" class="table center-aligned-table table-hover mb-0">
                                        <thead>
                                            <tr class="table-info text-danger">
                                                <th>#</th>
                                                <th>{{ trans('benefits.benefit-name') }}</th>
                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                <th>{{ trans('lessons.status') }}</th>
                                                <th>{{ trans('lessons.publish-date') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse(\App\Models\Benefit::latest()->take(10)->get() as $benefit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $benefit->name }}</td>
                                                    <td>{{ $benefit->category->name }}</td>
                                                    <td>{{ $benefit->status() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($benefit->publish_date)->diffforhumans() }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="alert-danger" colspan="9">
                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /row -->
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Chartjs js -->
    <script src="{{ URL::asset('assets/js/chart.chartjs.js') }}"></script>

    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
@endsection
