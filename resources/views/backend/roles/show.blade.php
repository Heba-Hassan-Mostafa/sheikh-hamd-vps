@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('users.role-show') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('users.roles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('users.role-show') }} </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ trans('users.role-show') }} --->{{ $role->name }}</h4>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('users.roles') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">


                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong
                                    style="font-weight: bold;
                                font-size: 22px;
                                color: #03aad7;">{{ trans('users.role-name') }}:</strong>
                                <span style="font-size: 20px ">{{ $role->name }}</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong
                                style="font-weight: bold;
                            font-size: 20px;
                            color: #03aad7;">{{ trans('users.permissions') }}:</strong>
                            <div class="form-group row">
                                @if (!empty($rolePermissions))
                                    @foreach ($rolePermissions as $v)
                                        <label class="label label-success col-md-4">{{ $v->name }} </label>
                                    @endforeach
                                @endif
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
@endsection
