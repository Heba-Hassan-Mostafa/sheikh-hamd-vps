@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')


@endsection
@section('title')
    {{ trans('articles.articles') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('articles.articles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('articles.main') }} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')


<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ trans('articles.article-list') }}</h4>


                </div>
            </div>
           
                <div class="card-body">
                   <div class="d-flex align-items-end mb-4">

                        <a href="{{ route('admin.articles.create') }}" class="addNewCont btn btn-success font-weight-bold"
                            role="button" aria-pressed="true"> <i class="fa fa-plus"></i> {{ trans('btns.create-article') }}
                        </a>

                        <form style="margin-right: 30px;" action="{{ route('admin.articles.export') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info font-weight-bold"> <i
                                    class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                        </form>

                        <a href="{{ route('admin.articles.sort_articles') }}" class="btn btn-warning font-weight-bold p-2"
                            role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
                            {{ trans('btns.change_order') }}</a>

                        <button type="button" class="btn btn-danger btn-sm font-weight-bold" id="btn_delete_all">
                            <i class="fa fa-trash"></i> {{ trans('btns.delete_checkbox') }}
                        </button>
                          <a href="{{ route('admin.articles.get_updates') }}" class="btn btn-primary font-weight-bold p-2"
                        role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-edit"></i>
                        {{ trans('btns.get_updates') }}</a>

                    </div>

                    <div class="table-responsive">
                <table class="table text-md-nowrap table-striped" id="example1">

        <thead>
            <tr>
                <th class="wd-15p border-bottom-0">
                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                </th>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('articles.article-name') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('articles.article-category') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('articles.status') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('articles.comment-count') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('articles.publish-date') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('articles.download-count') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('articles.view-count') }}</th>

                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

            </tr>
        </thead>
        <tbody>
            @if ($articles)
                @foreach ($articles as $article)
                    <tr>
                        <td><input type="checkbox" value="{{ $article->id }}" class="box1"></td>
                        <td>{{ $article->id }}</td>
                        <td style="width: 200px">{{ $article->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->status() }}</td>
                        <td>{{ $article->comments->count() }}</td>
                        <td style="width : 70px">{{ $article->publish_date->format('Y-m-d') }}</td>
                        <td>{{ $article->download_count }}</td>
                        <td>{{ $article->view_count }}</td>
                        <td>
                            <div class="btn-group">

                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-info btn-sm"
                                    role="button" aria-pressed="true">
                                    <i class="fa fa-edit"></i></a>


                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                                    class="dnone">
                                    @csrf
                                    @method('Delete')
                                    <input type="hidden" name="id" value="{{ $article->id }}">
                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                        data-name="{{ $article->name }}" data-toggle="modal"
                                        data-target="#Delete_Fee{{ $article->id }}"
                                        title="{{ trans('btns.delete') }}">
                                        <i class="fa fa-trash"></i></button>
                                </form>

                                <a href="{{ route('admin.articles.show', $article->id) }}" class="btn btn-warning btn-sm"
                                    role="button" aria-pressed="true"><i class="far fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>


<div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('btns.delete_articles') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.articles.delete_all') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body">
                    {{ trans('btns.warning-for-delete-all') }}
                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ trans('btns.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('btns.delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


                    </div>


                </div>
            </div>

        </div>
        <!-- /row -->




@endsection
@section('js')

@include('backend.layouts.datatable-js')

<script type="text/javascript">
    $(function() {
        $("#btn_delete_all").click(function() {
            var selected = new Array();
            $("#example1 input[type=checkbox]:checked").each(function() {
                selected.push(this.value);
                // console.log(selected);
            });
            if (selected.length > 0) {
                $('#delete_all').modal('show')
                $('input[id="delete_all_id"]').val(selected);
            }
        });
    });
</script>




@endsection
