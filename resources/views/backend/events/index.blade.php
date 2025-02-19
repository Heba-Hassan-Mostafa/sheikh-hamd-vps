@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')

@endsection
@section('title')
    {{ trans('events.events') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('events.events') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('events.main') }} </span>
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
                    <h4 class="card-title mg-b-0">{{ trans('events.main-title') }}</h4>


                </div>
            </div>
            <button type="button" class="addNewCont btn btn-success font-weight-bold" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-plus"></i> {{ trans('events.create-event') }}
            </button>


                <div class="card-body">
                    <form action="{{ route('admin.events.export') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"
                        >  <i class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-striped" id="example1">

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
                                    <th class="wd-15p border-bottom-0">{{ trans('events.title') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.place') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.type') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.image') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('events.start') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('events.time') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($events)
                                    @foreach ($events as $event)
                                        <tr>
                                            <td><input type="checkbox" value="{{ $event->id }}" class="box1"></td>
                                            <td>{{ $event->id }}</td>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->place }}</td>
                                            <td>{{ $event->type }}</td>
                                            <td>
                                                @if(!empty($event->photo))
                                                <img src="{{ asset('Files/image/Events/'.$event->title.'/'.$event->photo) }}">
                                                @else
                                                ------
                                                @endif
                                                </td>
                                            <td>{{ $event->start->format('Y-m-d') }}</td>
                                            <td>{{ date('g:ia', strtotime($event->start))}}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#edit{{ $event->id }}"><i class="fa fa-edit"></i></button>


                                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                                        class="dnone">
                                                        @csrf
                                                        @method('Delete')
                                                        <input type="hidden" name="id" value="{{ $event->id }}">
                                                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                            data-name="{{ $event->name }}" data-toggle="modal"
                                                            data-target="#Delete_Fee{{ $event->id }}"
                                                            title="{{ trans('btns.delete') }}">
                                                            <i class="fa fa-trash"></i></button>
                                                    </form>


                                                </div>
                                            </td>
                                        </tr>
                                        @include('backend.events.edit')

                                    @endforeach

                                @endif


                            </tbody>
                        </table>


                    </div>

            @include('backend.events.create')

                    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                        {{ trans('btns.delete_events') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="{{ route('admin.events.delete_all') }}" method="POST">
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

<script>
    $(document).on('click', '.deleteImg', function(e) {
        e.preventDefault();
        var img_id = $(this).attr('img_id');
        $.ajax({
            type: 'post',
            url: "{{ route('admin.events.remove_img') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': img_id,
                
            },
            success: function(data) {
                if (data.status == true) {
                    $('#success_msg').show();
                }
                $('.img' + data.id).remove();
            },
            error: function(reject) {}
        });
    });
</script>
@endsection
