@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('clients.fatwa') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('clients.fatwa') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('clients.fatwa-list') }}</span>
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
                    <h4 class="card-title mg-b-0"> {{ trans('clients.fatwa-list') }}</h4>

                </div>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.fatwa.export') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"> <i
                            class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                </form>

                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <button type="button" class="btn btn-danger btn-sm mb-4 font-weight-bold" id="btn_delete_all">
                                <i class="fa fa-trash"></i>{{ trans('btns.delete_checkbox') }}
                            </button>
                            <br>
                            <tr>
                                <th class="wd-15p border-bottom-0">
                                    <input type="checkbox" name="select_all" id="example-select-all"
                                        onclick="CheckAll('box1',this)">
                                </th>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.email') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.message') }}</th>
                                <!--<th class="wd-15p border-bottom-0">{{ trans('clients.phone') }}</th>-->
                                <th class="wd-15p border-bottom-0">{{ trans('clients.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('clients.created-at') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('clients.answer') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($fatwa)
                                @foreach ($fatwa as $question)
                                    <tr>
                                        <td><input type="checkbox" value="{{ $question->id }}" class="box1"></td>
                                        <td>{{ $question->id }}</td>
                                        <td style="width: 100px;">{{ $question->name }}</td>
                                        <td>{{ $question->email }}</td>
                                        <td style="width: 200px;">{{ \Illuminate\Support\Str::limit($question->message, 60) }}</td>
                                        <!--<td>{{ $question->phone }}</td>-->
                                        <td>

                                            <div class="custom-control custom-switch">

                                                <input type="checkbox" class="custom-control-input"
                                                    id="{{ $question->id }}" data-id="{{ $question->id }}"
                                                    {{ $question->status == true ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="{{ $question->id }}"></label>


                                            </div>

                                        </td>
                                        <td>{{ $question->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <?php
                                            $answer = $question
                                                ->fatwa_answer()
                                                ->where('fatwa_id', $question->id)
                                                ->first();
                                            ?>
                                            @if ($answer)
                                                <div class="btn btn-success-gradient">{{ trans('clients.reply-done') }}
                                                </div>
                                            @else
                                                <a href="{{ route('admin.fatwa.edit', $question->id) }}"
                                                    class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                    {{ trans('clients.reply') }}</a>
                                            @endif

                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <form action="{{ route('admin.fatwa.destroy', $question->id) }}"
                                                    method="POST" class="dnone">
                                                    @csrf
                                                    @method('Delete')
                                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                        data-name="{{ $question->name }}" data-toggle="modal"
                                                        data-target="#Delete_Fee{{ $question->id }}"
                                                        title="{{ trans('btns.delete') }}">
                                                        <i class="fa fa-trash"></i></button>
                                                </form>

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
                                    {{ trans('btns.delete_questions') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{ route('admin.fatwa.delete_all') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    {{ trans('btns.warning-for-delete-all') }}
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id"
                                        value=''>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{ trans('btns.close') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ trans('btns.save') }}</button>
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

    <script>
        $(function() {

            $('.custom-control-input').on('change', function() {

                var status = $(this).prop('checked') == true ? 1 : 0;

                var id = $(this).data('id');
                console.log(status);

                $.ajax({

                    type: "GET",

                    dataType: "json",

                    url: '{{ route('admin.fatwa.change') }}',

                    data: {
                        'status': status,
                        'id': id
                    },

                    success: function(data) {

                        console.log(data.success)

                    }

                });

            })

        })
    </script>


@endsection
