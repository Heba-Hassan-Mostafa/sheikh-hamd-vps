@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
    <style>
        @page {
            size: auto;
            margin: 25mm 25mm 25mm 25mm;
        }

        @media print {
            .printPage {
                display: none !important;
            }
        }
    </style>
@endsection
@section('title')
    {{ trans('setting.reports') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('setting.reports') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('setting.main') }} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    {{-- <div class="printbtn printPage btn btn-info-gradient font-weight-bold m-3 ">
    <a class="printPage text-white" href="#">طباعة التقارير</a>
  </div> --}}
    {{-- more-downloaded --}}
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="tab nav-border moreDownRepo" style="position: relative;">


                        <div class="panel-group1" id="accordion11">
                            <div class="panel panel-default">
                                <div class="panel-heading1 bg-primary ">
                                    <h4 class="panel-title1">
                                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                                            data-parent="#accordion11" href="#collapseFour1" aria-expanded="false">
                                            <i class="fe fe-arrow-left ml-2"></i>
                                            {{ trans('main_sidebar.more-download') }}</a>
                                    </h4>
                                </div>
                                <div id="collapseFour1" class="panel-collapse collapse" role="tabpanel"
                                    aria-expanded="false">
                                    <div class="panel-body border">
                                        <div class="d-block d-md-flex justify-content-between">
                                            <div class="d-block w-100">
                                                <h5 style="font-family: 'Cairo', sans-serif" class="card-title">
                                                </h5>
                                            </div>
                                            <div class="d-block d-md-flex nav-tabs-custom navCustom">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="lessons-tab" data-toggle="tab"
                                                            href="#lessons" role="tab" aria-controls="lessons"
                                                            aria-selected="true">
                                                            {{ trans('main_sidebar.Lessons') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="lectures-tab" data-toggle="tab"
                                                            href="#lectures" role="tab" aria-controls="lectures"
                                                            aria-selected="false">{{ trans('main_sidebar.lectures') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="articles-tab" data-toggle="tab"
                                                            href="#articles" role="tab" aria-controls="articles"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.articles') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="speeches-tab" data-toggle="tab"
                                                            href="#speeches" role="tab" aria-controls="speeches"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.speeches') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="books-tab" data-toggle="tab" href="#books"
                                                            role="tab" aria-controls="books"
                                                            aria-selected="false">{{ trans('main_sidebar.books') }}
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <?php
                                            $lesson_downs = \App\Models\Lesson::where('download_count', '>', '0')
                                                ->orderBy('download_count', 'desc')
                                                ->paginate(10);
                                                $lecture_downs = \App\Models\Lecture::where('download_count', '>', '0')
                                                ->orderBy('download_count', 'desc')
                                                ->paginate(10);
                                                $article_downs = \App\Models\Article::where('download_count', '>', '0')
                                                ->orderBy('download_count', 'desc')
                                                ->paginate(10);
                                                $speech_downs = \App\Models\Speech::where('download_count', '>', '0')
                                                ->orderBy('download_count', 'desc')
                                                ->paginate(10);
                                                $book_downs = \App\Models\Book::where('download_count', '>', '0')
                                                ->orderBy('download_count', 'desc')
                                                ->paginate(10);
                                            ?>
                                            <div class="tab-pane fade active show" id="lessons" role="tabpanel"
                                                aria-labelledby="lessons-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('lessons.lesson-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.download-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @forelse($lesson_downs  as $lesson)
                                                                <tr>
                                                                    <td>{{ $lesson->id }}</td>
                                                                    <td>{{ $lesson->name }}</td>
                                                                    <td>{{ $lesson->category->name }}</td>
                                                                    <td>{{ $lesson->download_count }}</td>
                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }} </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $lesson_downs->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="lectures" role="tabpanel"
                                                aria-labelledby="lectures-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('lectures.lecture-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.download-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                            <tbody>
                                                                @forelse($lecture_downs as $lecture)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $lecture->name }}</td>
                                                                    <td>{{ $lecture->category->name }}</td>
                                                                    <td>{{ $lecture->download_count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <div class="float-right">
                                                                            {!! $lecture_downs->appends(request()->all())->links() !!}
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="articles" role="tabpanel"
                                                aria-labelledby="articles-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('articles.article-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.download-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($article_downs as $article)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $article->name }}</td>
                                                                    <td>{{ $article->category->name }}</td>
                                                                    <td>{{ $article->download_count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $article_downs->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="speeches" role="tabpanel"
                                                aria-labelledby="speeches-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('speeches.speech-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.download-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($speech_downs as $speech)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $speech->name }}</td>
                                                                    <td>{{ $speech->category->name }}</td>
                                                                    <td>{{ $speech->download_count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $speech_downs->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="books" role="tabpanel"
                                                aria-labelledby="books-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('books.book-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.download-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($book_downs as $book)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $book->name }}</td>
                                                                    <td>{{ $book->category->name }}</td>
                                                                    <td>{{ $book->download_count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $book_downs->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- more-views --}}
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics ">
                <div class="card-body">

                    <div class="panel-group1" id="accordion11">
                        <div class="panel panel-default mb-0">
                            <div class="panel-heading1  bg-primary">
                                <h4 class="panel-title1">
                                    <a class="accordion-toggle mb-0 collapsed" data-toggle="collapse"
                                        data-parent="#accordion11" href="#collapseFive2" aria-expanded="false">
                                        <i class="fe fe-arrow-left ml-2"></i> {{ trans('main_sidebar.more-views') }}</a>
                                </h4>
                            </div>
                            <div id="collapseFive2" class="panel-collapse collapse" role="tabpanel"
                                aria-expanded="false">
                                <div class="panel-body border">
                                    <div class="tab nav-border" style="position: relative;">
                                        <div class="d-block d-md-flex justify-content-between">
                                            <div class="d-block w-100">
                                                <h5 style="font-family: 'Cairo', sans-serif" class="card-title">
                                                </h5>
                                            </div>
                                            <div class="d-block d-md-flex nav-tabs-custom navCustom">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="lessons-tab"
                                                            data-toggle="tab" href="#lessons-view" role="tab"
                                                            aria-controls="lessons" aria-selected="true">
                                                            {{ trans('main_sidebar.Lessons') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="lectures-tab" data-toggle="tab"
                                                            href="#lectures-view" role="tab" aria-controls="lectures"
                                                            aria-selected="false">{{ trans('main_sidebar.lectures') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="articles-tab" data-toggle="tab"
                                                            href="#articles-view" role="tab" aria-controls="articles"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.articles') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="speeches-tab" data-toggle="tab"
                                                            href="#speeches-view" role="tab" aria-controls="speeches"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.speeches') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="books-tab" data-toggle="tab"
                                                            href="#books-view" role="tab" aria-controls="books"
                                                            aria-selected="false">{{ trans('main_sidebar.books') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="benefits-tab" data-toggle="tab"
                                                            href="#benefits-view" role="tab" aria-controls="benefits"
                                                            aria-selected="false">{{ trans('main_sidebar.benefits') }}
                                                        </a>
                                                    </li>




                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="myTabContent">
                                            <?php
                                            $lesson_views = \App\Models\Lesson::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                                $lecture_views = \App\Models\Lecture::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                                $article_views = \App\Models\Article::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                                $speech_views = \App\Models\Speech::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                                $book_views = \App\Models\Book::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                                $benefit_views = \App\Models\Benefit::where('view_count', '>', '0')
                                                ->orderBy('view_count', 'desc')
                                                ->paginate(10);
                                            ?>
                                            <div class="tab-pane fade active show" id="lessons-view" role="tabpanel"
                                                aria-labelledby="lessons-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('lessons.lesson-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @forelse($lesson_views as $lesson)
                                                                <tr>
                                                                    <td>{{ $lesson->id }}</td>
                                                                    <td>{{ $lesson->name }}</td>
                                                                    <td>{{ $lesson->category->name }}</td>
                                                                    <td>{{ $lesson->view_count }}</td>
                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }} </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $lesson_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="lectures-view" role="tabpanel"
                                                aria-labelledby="lectures-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('lectures.lecture-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            @forelse($lecture_views as $lecture)
                                                                <tr>
                                                                    <td>{{ $lecture->id }}</td>
                                                                    <td>{{ $lecture->name }}</td>
                                                                    <td>{{ $lecture->category->name }}</td>
                                                                    <td>{{ $lecture->view_count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $lecture_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="articles-view" role="tabpanel"
                                                aria-labelledby="articles-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('articles.article-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($article_views as $article)
                                                                <tr>
                                                                    <td>{{ $article->id }}</td>
                                                                    <td>{{ $article->name }}</td>
                                                                    <td>{{ $article->category->name }}</td>
                                                                    <td>{{ $article->view_count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $article_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="speeches-view" role="tabpanel"
                                                aria-labelledby="speeches-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('speeches.speech-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($speech_views  as $speech)
                                                                <tr>
                                                                    <td>{{ $speech->id }}</td>
                                                                    <td>{{ $speech->name }}</td>
                                                                    <td>{{ $speech->category->name }}</td>
                                                                    <td>{{ $speech->view_count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $speech_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="books-view" role="tabpanel"
                                                aria-labelledby="books-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('books.book-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($book_views as $book)
                                                                <tr>
                                                                    <td>{{ $book->id }}</td>
                                                                    <td>{{ $book->name }}</td>
                                                                    <td>{{ $book->category->name }}</td>
                                                                    <td>{{ $book->view_count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $book_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="benefits-view" role="tabpanel"
                                                aria-labelledby="benefits-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>ID</th>
                                                                <th>{{ trans('benefits.benefit-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.view-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($benefit_views as $benefit)
                                                                <tr>
                                                                    <td>{{ $benefit->id }}</td>
                                                                    <td>{{ $benefit->name }}</td>
                                                                    <td>{{ $benefit->category->name }}</td>
                                                                    <td>{{ $benefit->view_count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $benefit_views->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- most-favourite --}}
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics ">
                <div class="card-body">
                    <div class="panel-group1" id="accordion11">
                        <div class="panel panel-default mb-0">
                            <div class="panel-heading1  bg-primary">
                                <h4 class="panel-title1">
                                    <a class="accordion-toggle mb-0 collapsed" data-toggle="collapse"
                                        data-parent="#accordion11" href="#collapseFive3" aria-expanded="false">
                                        <i class="fe fe-arrow-left ml-2"></i>
                                        {{ trans('main_sidebar.more-favourite') }}</a>
                                </h4>
                            </div>
                            <div id="collapseFive3" class="panel-collapse collapse" role="tabpanel"
                                aria-expanded="false">
                                <div class="panel-body border">

                                    <div class="tab nav-border" style="position: relative;">
                                        <div class="d-block d-md-flex justify-content-between">
                                            <div class="d-block w-100">
                                                <h5 style="font-family: 'Cairo', sans-serif" class="card-title">
                                                </h5>
                                            </div>
                                            <div class="d-block d-md-flex nav-tabs-custom navCustom">
                                                <ul class="nav nav-tabs" id="myTab" role="tablist">

                                                    <li class="nav-item">
                                                        <a class="nav-link active show" id="lessons-tab"
                                                            data-toggle="tab" href="#lessons-fav" role="tab"
                                                            aria-controls="lessons" aria-selected="true">
                                                            {{ trans('main_sidebar.Lessons') }}</a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="lectures-tab" data-toggle="tab"
                                                            href="#lectures-fav" role="tab" aria-controls="lectures"
                                                            aria-selected="false">{{ trans('main_sidebar.lectures') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="articles-tab" data-toggle="tab"
                                                            href="#articles-fav" role="tab" aria-controls="articles"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.articles') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="speeches-tab" data-toggle="tab"
                                                            href="#speeches-fav" role="tab" aria-controls="speeches"
                                                            aria-selected="false">
                                                            {{ trans('main_sidebar.speeches') }}
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a class="nav-link" id="books-tab" data-toggle="tab"
                                                            href="#books-fav" role="tab" aria-controls="books"
                                                            aria-selected="false">{{ trans('main_sidebar.books') }}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="benefits-tab" data-toggle="tab"
                                                            href="#benefits-fav" role="tab" aria-controls="benefits"
                                                            aria-selected="false">{{ trans('main_sidebar.benefits') }}
                                                        </a>
                                                    </li>


                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content" id="myTabContent">


                                            <div class="tab-pane fade active show" id="lessons-fav" role="tabpanel"
                                                aria-labelledby="lessons-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('lessons.lesson-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $lessons = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Lesson')
                                                                ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                                ->groupBy('wishable_id')
                                                                ->orderBy('count', 'desc')
                                                                ->paginate(10);
                                                            //dd($lessons)
                                                            ?>
                                                            @forelse($lessons as $lesson)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $lesson->wishable->name }}</td>
                                                                    <td>{{ $lesson->wishable->category->name }}</td>
                                                                    <td>{{ $lesson->count }}</td>
                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }} </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $lessons->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="lectures-fav" role="tabpanel"
                                                aria-labelledby="lectures-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('lectures.lecture-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>

                                                        <?php
                                                        $lectures = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Lecture')
                                                            ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                            ->groupBy('wishable_id')
                                                            ->orderBy('count', 'desc')
                                                            ->paginate(10);
                                                        //dd($lectures)
                                                        ?>
                                                     <tbody>
                                                        @forelse($lectures as $lecture)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $lecture->wishable->name }}</td>
                                                                    <td>{{ $lecture->wishable->category->name }}</td>
                                                                    <td>{{ $lecture->count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                        @endforelse

                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="3">
                                                                        <div class="float-right">
                                                                            {!! $lectures->appends(request()->all())->links() !!}
                                                                        </div>

                                                                    </td>
                                                                </tr>
                                                            </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="articles-fav" role="tabpanel"
                                                aria-labelledby="articles-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('articles.article-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $articles = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Article')
                                                                ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                                ->groupBy('wishable_id')
                                                                ->orderBy('count', 'desc')
                                                                ->paginate(10);
                                                            //dd($articles)
                                                            ?>
                                                            @forelse($articles as $article)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $article->wishable->name }}</td>
                                                                    <td>{{ $article->wishable->category->name }}</td>
                                                                    <td>{{ $article->count }}</td>

                                                                @empty
                                                                    <td class="alert-danger" colspan="8">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $articles->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>


                                            <div class="tab-pane fade" id="speeches-fav" role="tabpanel"
                                                aria-labelledby="speeches-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('speeches.speech-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $speeches = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Speech')
                                                                ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                                ->groupBy('wishable_id')
                                                                ->orderBy('count', 'desc')
                                                                ->paginate(10);
                                                            //dd($lectures)
                                                            ?>
                                                            @forelse($speeches as $speech)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $speech->wishable->name }}</td>
                                                                    <td>{{ $speech->wishable->category->name }}</td>
                                                                    <td>{{ $speech->count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $speeches->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="books-fav" role="tabpanel"
                                                aria-labelledby="books-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('books.book-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $books = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Book')
                                                                ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                                ->groupBy('wishable_id')
                                                                ->orderBy('count', 'desc')
                                                                ->paginate(10);
                                                            //dd($lectures)
                                                            ?>
                                                            @forelse($books as $book)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $book->wishable->name }}</td>
                                                                    <td>{{ $book->wishable->category->name }}</td>
                                                                    <td>{{ $book->count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $books->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="benefits-fav" role="tabpanel"
                                                aria-labelledby="benefits-tab">
                                                <div class="table-responsive mt-15">
                                                    <table style="text-align: center"
                                                        class="table center-aligned-table table-hover mb-0">
                                                        <thead>
                                                            <tr class="table-info text-danger">
                                                                <th>#</th>
                                                                <th>{{ trans('benefits.benefit-name') }}</th>
                                                                <th>{{ trans('lessons.category-parent') }}</th>
                                                                <th>{{ trans('lessons.fav-count') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $benefits = App\Models\Wish::whereHasMorph('wishable', 'App\Models\Benefit')
                                                                ->select('wishes.*', DB::raw('COUNT(wishable_id) as count'))
                                                                ->groupBy('wishable_id')
                                                                ->orderBy('count', 'desc')
                                                                ->paginate(10);
                                                            //dd($lectures)
                                                            ?>
                                                            @forelse($benefits as $benefit)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $benefit->wishable->name }}</td>
                                                                    <td>{{ $benefit->wishable->category->name }}</td>
                                                                    <td>{{ $benefit->count }}</td>

                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td class="alert-danger" colspan="9">
                                                                        {{ trans('main_sidebar.no-data') }}</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="float-right">
                                                                        {!! $benefits->appends(request()->all())->links() !!}
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>











                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        // $(".printMoreReo").click(function(){
        //     $(".printMoreReo").remove();
        //     window.print($(".moreDownRepo"));

        // })
        $('a.printPage').click(function() {
            $('#report-summary').show();
            window.print();
            return false;
        });
    </script>
@endsection
