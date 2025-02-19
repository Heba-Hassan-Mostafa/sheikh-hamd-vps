@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('clients.subscribers') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('clients.subscribers') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('clients.subscribers-list') }}</span>
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
                    <h4 class="card-title mg-b-0"> {{ trans('clients.subscribers-list') }}</h4>

                </div>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.subscribers.export') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"> <i
                            class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                </form>

                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                              <button type="button" class="btn btn-danger btn-sm mb-4 font-weight-bold" id="btn_delete_all">
                                    <i class="fa fa-trash"></i> {{ trans('btns.delete_checkbox') }}
                                </button>
                    
                                <br>
                            <tr>
                                 <th class="wd-15p border-bottom-0">
                                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                                </th>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('clients.created-at') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($subscribers)
                            @foreach ($subscribers as $subscriber )
                            <tr>
                                <td><input type="checkbox" value="{{ $subscriber->id }}" class="box1"></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subscriber->email }}</td>

                                <td>{{ $subscriber->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                    <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST"
                                        class="dnone">
                                        @csrf
                                        @method('Delete')
                                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                                            data-name="{{ $subscriber->name }}" data-toggle="modal"
                                            data-target="#Delete_Fee{{ $subscriber->id }}"
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
                                            {{ trans('btns.delete_subscribers') }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                        
                                    <form action="{{ route('admin.subscribers.delete_all') }}" method="POST">
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

            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    <!--/div-->
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
