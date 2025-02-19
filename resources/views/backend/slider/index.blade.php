@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('galleries.slider') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.slider') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('galleries.main') }} </span>
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
                    <h4 class="card-title mg-b-0">{{ trans('galleries.image-list') }}</h4>


                </div>
            </div>
            <div class="card-body">
               <div class="d-flex align-items-end mb-4">

                        <a href="{{ route('admin.slider.create') }}" class="addNewCont btn btn-success font-weight-bold"
                            role="button" aria-pressed="true"> <i class="fa fa-plus"></i> {{ trans('galleries.create-image') }}
                        </a>


                        <a href="{{ route('admin.slider.sort_slider') }}" class="btn btn-warning mr-2 ml-2 font-weight-bold p-2"
                            role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
                            {{ trans('btns.change_order') }}</a>

                        <button type="button" class="btn btn-danger btn-sm font-weight-bold" id="btn_delete_all">
                            <i class="fa fa-trash"></i> {{ trans('btns.delete_checkbox') }}
                        </button>

                    </div>
      <div class="table-responsive">
             <table class="table text-md-nowrap" id="example1">
                 <thead>
            <tr>
                <th class="wd-15p border-bottom-0">
                    <input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1',this)">
                </th>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.title') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('galleries.image') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.status') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('galleries.creatred-at') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

            </tr>
        </thead>
        <tbody>
            @if ($sliders)
                @foreach ($sliders as $slider)
                    <tr>
                        <td><input type="checkbox" value="{{ $slider->id }}" class="box1"></td>
                        <td>{{ $slider->id }}</td>
                        <td>{{ $slider->title }}</td>
                        <td>
                     <img src="{{ asset('Files/slider/' . $slider->image) }}"
                            style="width: 50px; height:50px;">
                        </td>

                        <td>

                            <div class="custom-control custom-switch">

                                <input type="checkbox" class="custom-control-input" id="{{ $slider->id }}"
                                    data-id="{{ $slider->id }}" {{ $slider->status == true ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $slider->id }}"></label>


                            </div>

                        </td>
                        <td>{{ $slider->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group">

                                <a href="{{ route('admin.slider.edit', $slider->id) }}" class="btn btn-info btn-sm"
                                    role="button" aria-pressed="true">
                                    <i class="fa fa-edit"></i></a>


                                <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST"
                                    class="dnone">
                                    @csrf
                                    @method('Delete')
                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                        data-name="{{ $slider->name }}" data-toggle="modal"
                                        data-target="#Delete_Fee{{ $slider->id }}"
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
                    {{ trans('btns.delete_images') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.slider.delete_all') }}" method="POST">
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
    </div>
    <!-- Container closed -->
</div>

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

                url: '{{ route('admin.slider.change') }}',

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
