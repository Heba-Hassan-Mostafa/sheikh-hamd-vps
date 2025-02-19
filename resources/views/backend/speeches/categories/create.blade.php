@extends('backend.layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('title')
    {{ trans('speeches.category-create') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('speeches.categories') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('speeches.category-create') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('speeches.category-create') }}</h4>
                        <a href="{{ route('admin.speech-categories.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('speeches.categories') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.speech-categories.store') }}" method="Post">
                        @csrf
                        <div class="row">

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">{{ trans('speeches.category-name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="status">{{ trans('speeches.status') }}</label>
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

                        </div>

                        <div class="row">

                            <!-- col -->
                            <div class="col-lg-12">
                                <ul id="treeview1">
                                    <h4 class="selectCatTo"> {{ trans('articles.choose-category') }}</h4>
                                    <li><a href="#">{{ trans('speeches.categories') }}</a>
                                        <ul class="row fristParent">
                                    </li>
                                    @foreach ($categories as $category)
                                        <ul class="col-4 parentCategory">
                                            <label
                                                style="font-size: 16px;">{{ Form::radio('parent_id', $category->id, false, ['class' => 'name']) }}
                                                {{ $category->name }}</label>

                                            @include('backend.speeches.categories.subCategoryList', [
                                                'subcategories' => $category->subcategory,
                                            ])

                                        </ul>
                                    @endforeach
                                </ul>
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
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>
@endsection
