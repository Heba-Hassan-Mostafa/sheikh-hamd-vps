@extends('backend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
@endsection
@section('title')
    {{ trans('users.profile') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('users.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('users.profile') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.users.update-profile') }}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.first-name') }}</label>
                                    <input type="text" name="first_name" value="{{ old('first_name' , Auth::user()->first_name) }}"
                                        class="form-control">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.last-name') }}</label>
                                    <input type="text" name="last_name" value="{{ old('last_name' , Auth::user()->last_name) }}"
                                        class="form-control">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">{{ trans('users.email') }}</label>
                                    <input type="email" name="email" value="{{ old('email' , Auth::user()->email) }}" class="form-control">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">{{ trans('users.phone') }}</label>
                                <input type="text" name="phone" value="{{ old('phone' , Auth::user()->phone) }}"
                                    class="form-control">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                        </div>
                        <div class="row">
                            <div class="col-6 mt-2">
                                <label for="image">{{ trans('users.img') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" name="image" class='form-control'>
                                </div>
                                <br>
                                @if(!empty(Auth::user()->image))
                                <img alt="user-img"  src="{{ asset('Files/users/'.Auth::user()->image) }}" width="50px" height="50px">
                                @else

                                @endif
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group pt-4">
                            <button type="submit" name="save" class="btn btn-primary">
                                {{ trans('btns.save') }}</button>

                        </div>


                    </form>


                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- Container closed -->
    </div>
@endsection
@section('js')
@endsection
