@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('benefits.comments') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('benefits.comments') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('benefits.comments-list') }}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!--div-->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0"> {{ trans('benefits.comments-list') }}</h4>

                </div>

            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <button type="button" class="btn btn-danger btn-sm mb-4 font-weight-bold" id="btn_delete_all">
                                <i class="fa fa-trash"></i>{{ trans('btns.delete_checkbox') }}
                            </button>
                            <br>
                            <tr>
                                <th class="wd-15p border-bottom-0">
                                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                                </th>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.email') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('benefits.comment') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('benefits.comment-belongs-to') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('clients.created-at') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($comments)
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td><input type="checkbox" value="{{ $comment->id }}" class="box1"></td>
                                        <td>{{ $comment->id }}</td>
                                        <td>{{ $comment->client->full_name }}</td>
                                        <td>{{ $comment->client->email }}</td>

                                        <td>{{ \Illuminate\Support\Str::limit($comment->message, 40) }}</td>
                                        <td>{{ $comment->commentable != '' ? $comment->commentable->name : '----' }}</td>
                                        <td>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="{{ $comment->id }}" data-id="{{ $comment->id }}"
                                                    {{ $comment->status == true ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="{{ $comment->id }}"></label>
                                            </div>

                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($comment->created_at)->diffforhumans() }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <form action="{{ route('admin.benefit-comments.destroy', $comment->id) }}"
                                                    method="POST" class="dnone">
                                                    @csrf
                                                    @method('Delete')
                                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                        data-name="{{ $comment->name }}" data-toggle="modal"
                                                        data-target="#Delete_Fee{{ $comment->id }}"
                                                        title="{{ trans('btns.delete') }}">
                                                        <i class="fa fa-trash"></i></button>
                                                </form>


                                                <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modaldemo3-{{ $comment->id }}">
                                                    <i class="fa fa-eye"></i>
                                                    <span class="text"></span>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                    <div id="modaldemo3-{{ $comment->id }}" class="modal fade">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content tx-size-sm">
                                                <div class="modal-header pd-x-20">
                                                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">
                                                        {{ trans('benefits.show-comment') }}</h6>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body pd-20">
                                                    <div class="row">
                                                        <div class="col-10">
                                                            {{ $comment->message }}
                                                        </div>
                                                    </div>

                                                </div><!-- modal-body -->

                                            </div>
                                        </div><!-- modal-dialog -->
                                    </div><!-- modal -->
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
                                    {{ trans('btns.delete_comments') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{ route('admin.benefit-comments.delete_all') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    {{ trans('btns.warning-for-delete-all') }}
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id"
                                        value=''>
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

            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    <!--/div-->
@endsection
@section('js')
    @include('backend.layouts.datatable-js')

    <script>
        $(function() {

            $('.custom-control-input').on('change', function() {

                var status = $(this).prop('checked') == true ? 1 : 0;

                var id = $(this).data('id');
                console.log(status);

                $.ajax({

                    type: "GET",

                    dataType: "json",

                    url: '{{ route('admin.benefit-comments.change') }}',

                    data: {
                        'status': status,
                        'id': id
                    },

                    success: function(data) {

                        console.log(data.success)

                    }

                });

            });




            //model delete

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
