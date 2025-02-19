@extends('backend.layouts.master')
@section('title')
    {{ trans('galleries.edit-matwiaat') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.matwiaat') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('galleries.edit-matwiaat') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('galleries.edit-matwiaat') }}</h4>
                        <a href="{{ route('admin.matwiaat.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('galleries.matwiaat') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.matwiaat.update', $model->id) }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="title">{{ trans('galleries.title') }}</label>
                                    <input type="text" name="title" value="{{ $model->title }}" class="form-control">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="status">{{ trans('galleries.status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="1"
                                            {{ old('status', $model->status) == '1' ? 'selected' : null }}>
                                            {{ trans('btns.active') }}</option>
                                        <option value="0"
                                            {{ old('status', $model->status) == '0' ? 'selected' : null }}>
                                            {{ trans('btns.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-8">
                                <label for="image">{{ trans('galleries.choose-image') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" name="image" id="gallery" class="form-control">
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if (!empty($model->image))
                                    <div class="img{{ $model->id }} m-2">
                                        <img src="{{ asset('Files/Matwiaat/' . $model->image) }}"
                                            style="width:100px;height: 100px;">
                                    </div>
                                @else
                                    <span style="cursor: context-menu;color: red;"> {{ trans('galleries.no-img-found') }}
                                    </span>
                                @endif
                            </div>

                            <div class="col-8">
                                <label for="pdf_file">{{ trans('galleries.choose-pdf_file') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" name="pdf_file" id="gallery" class="form-control">
                                </div>
                                @error('pdf_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if (!empty($model->pdf_file))
                                    <div class="img{{ $model->id }}">
                                        <li class="m-2 ">
                                            <i class="fas fa-file-pdf" style="color:#ce0000"></i>
                                        <a href="{{ asset('Files/Matwiaat/PDF/' . $model->pdf_file) }}">{{ $model->pdf_file }}</a>
                                        </li>
                                    </div>
                                @else
                                    <span style="cursor: context-menu;color: red;"> {{ trans('lectures.no-pdf-found') }}
                                    </span>
                                @endif
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

