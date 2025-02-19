@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')

@endsection
@section('title')
    {{ trans('users.users') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('users.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('users.user-list') }}</span>
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
                    <h4 class="card-title mg-b-0"> {{ trans('users.user-list') }}</h4>

                </div>

            </div>
            <div class="card-body">

                <a href="{{ route('admin.users.create') }}" class="btn btn-success font-weight-bold" role="button"
                    aria-pressed="true"> <i class="fa fa-plus"></i> {{ trans('btns.create-user') }} </a><br><br>

                <div class="table-responsive">
                    <table class="table table-striped mg-b-0 text-md-nowrap" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('users.name') }}</th>
                                <th>{{ trans('users.email') }}</th>
                                <th>{{ trans('users.user-role') }}</th>
                                <th>{{ trans('users.status') }}</th>
                                <th>{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if ($users)
                                 @forelse  ($users as $user)
                                    <td>{{ $user->id }}</td>
                                    <td style="width:100px">{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center" style="width: 200px">
                                        @if (!empty($user->getRoleNames()))
                                            @foreach ($user->getRoleNames() as $v)
                                                <label class="btn btn-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>

                                        <div class="custom-control custom-switch">

                                            <input type="checkbox" class="custom-control-input" id="{{ $user->id }}"
                                                data-id="{{ $user->id }}"
                                                {{ $user->status == true ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="{{ $user->id }}"></label>


                                        </div>

                                    </td>
                                     <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                    <i class="fa fa-edit"></i></a>

                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    class="dnone">
                                                    @csrf
                                                    @method('Delete')
                                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                        data-name="{{ $user->name }}" data-toggle="modal"
                                                        data-target="#Delete_Fee{{ $user->id }}"
                                                        title="{{ trans('btns.delete') }}">
                                                        <i class="fa fa-trash"></i></button>
                                                </form>

                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i
                                                        class="far fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center"> {{ trans('users.no-users-found') }}</td>
                                    </tr>
                                @endforelse

                                @endif



                        </tbody>

                    </table>
                </div><!-- bd -->
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

                    url: '{{ route('admin.users.change') }}',

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
