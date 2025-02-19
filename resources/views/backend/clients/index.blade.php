@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('clients.clients') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('clients.clients') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('clients.clients-list') }}</span>
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
                    <h4 class="card-title mg-b-0"> {{ trans('clients.clients-list') }}</h4>

                </div>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.clients.export') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"> <i
                            class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                </form>

                <div class="table-responsive">
                    <table class="table text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-15p border-bottom-0">#</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.email') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.phone') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('clients.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('clients.created-at') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($clients)
                            @foreach ($clients as $client )
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->full_name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>

                                    <div class="custom-control custom-switch">

                                        <input type="checkbox" class="custom-control-input" id="{{ $client->id }}"
                                            data-id="{{ $client->id }}"
                                            {{ $client->status == true ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="{{ $client->id }}"></label>


                                    </div>

                                </td>
                                <td>{{ $client->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group">
                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST"
                                        class="dnone">
                                        @csrf
                                        @method('Delete')
                                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                                            data-name="{{ $client->name }}" data-toggle="modal"
                                            data-target="#Delete_Fee{{ $client->id }}"
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

                url: '{{ route('admin.clients.change') }}',

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
