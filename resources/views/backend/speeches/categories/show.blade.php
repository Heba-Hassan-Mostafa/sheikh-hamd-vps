@extends('backend.layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
@section('title')
   {{ trans('speeches.category-subcategory') }}
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">{{ trans('speeches.categories') }}</h4>
            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('speeches.show') }}</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ trans('speeches.category-subcategory') }}</h4>
                        <a href="{{ route('admin.speech-categories.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('speeches.categories') }}</span>
                        </a>
                    </div>
                </div>



                <div class="row">

                    <!-- col -->
                    <div class="col-lg-4">
                        <ul id="treeview1">
                            <li><a href="#">{{ $model->name }}</a>
                                <ul>
                            </li>
                            @foreach($categories as $category)
                            <ul>
                                <li>
                                    {{ $category->name }}

                                </li>

                                    @include('backend.speeches.categories.subCategoryList', [
                                        'subcategories' => $category->subcategory,
                                    ])

                            </ul>


                            @endforeach

                            </li>

                        </ul>
                        </li>
                        </ul>
                    </div>
                </div>



    </div>
</div>


@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>

@endsection
