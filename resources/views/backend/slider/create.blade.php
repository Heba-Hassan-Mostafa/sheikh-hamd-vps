@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('galleries.create-image') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.slider') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('galleries.create-image') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('galleries.create-image') }}</h4>
                        <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('galleries.slider') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.slider.store') }}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="title">{{ trans('galleries.title') }}</label>
                                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="link">{{ trans('galleries.link') }}</label>
                                    <input type="url" name="link" value="{{ old('link') }}" class="form-control">
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">{{ trans('galleries.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : null }}>
                                            {{ trans('btns.active') }}</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : null }}>
                                            {{ trans('btns.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="image">{{ trans('galleries.choose-images') }}</label>
                                <br>
                                <div class="file-loading">

                                    <input type="file" accept="image/*" name="image" class="form-control">
                                    </div>
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
