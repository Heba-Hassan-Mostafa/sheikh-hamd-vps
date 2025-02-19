@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('users.roles') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{ trans('users.roles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('users.role-list') }}</span>
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
                    <h4 class="card-title mg-b-0"> {{ trans('users.role-list') }}</h4>

                </div>

            </div>
            <div class="card-body">

                <a href="{{ route('admin.roles.create') }}" class="btn btn-success" role="button" aria-pressed="true"> <i
                        class="fa fa-plus"></i> {{ trans('btns.create-role') }} </a><br><br>

                <div class="table-responsive">
                    <table class="table table-striped mg-b-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('users.user-role') }}</th>
                                <th>{{ trans('btns.actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @if ($roles)
                                    @forelse ($roles as $role)
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>

                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.roles.edit', $role->id) }}"
                                                    class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                    <i class="fa fa-edit"></i></a>

                                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST"
                                                    class="dnone">
                                                    @csrf
                                                    @method('Delete')
                                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                        data-name="{{ $role->name }}" data-toggle="modal"
                                                        data-target="#Delete_Fee{{ $role->id }}"
                                                        title="{{ trans('btns.delete') }}">
                                                        <i class="fa fa-trash"></i></button>
                                                </form>

                                                <a href="{{ route('admin.roles.show', $role->id) }}"
                                                    class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i
                                                        class="far fa-eye"></i></a>
                                            </div>
                                        </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center"> {{ trans('users.no-roles-found') }}</td>
                            </tr>
                            @endforelse
                            @endif


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <div class="float-right">
                                        {!! $roles->appends(request()->all())->links() !!}
                                    </div>

                                </td>
                            </tr>
                        </tfoot>

                    </table>
                </div><!-- bd -->
            </div><!-- bd -->
        </div><!-- bd -->
    </div>
    <!--/div-->
@endsection
@section('js')
@endsection
