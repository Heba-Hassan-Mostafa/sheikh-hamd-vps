@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('galleries.categories') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.categories') }}</h4>
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
                        <h4 class="card-title mg-b-0">{{ trans('galleries.category-list') }}</h4>


                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-end mb-4">

                        <a href="{{ route('admin.gallery-categories.create') }}" class="btn btn-success font-weight-bold"
                            role="button" aria-pressed="true"> <i class="fa fa-plus"></i>
                            {{ trans('btns.create-category') }} </a>

                        <a href="{{ route('admin.gallery-categories.sort_gallery-categories') }}" class="btn btn-warning font-weight-bold p-2"
                            role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
                            {{ trans('btns.change_order') }}</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('galleries.category-name') }}</th>
                                    <th class="wd-20p border-bottom-0">{{ trans('galleries.gallery-count') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('galleries.status') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('galleries.cat-image') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('galleries.creatred-at') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->galleries->count() }}</td>
                                            <td>{{ $category->status() }}</td>
                                            <td>
                                                <img src="{{ asset('Files/GalleryCategory/' . $category->image) }}"
                                                    style="width: 50px;">
                                            </td>
                                            <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('admin.gallery-categories.edit', $category->id) }}"
                                                        class="btn btn-info btn-sm" role="button" aria-pressed="true">
                                                        <i class="fa fa-edit"></i></a>


                                                    <form
                                                        action="{{ route('admin.gallery-categories.destroy', $category->id) }}"
                                                        method="POST" class="dnone">
                                                        @csrf
                                                        @method('Delete')
                                                        <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                            data-name="{{ $category->name }}" data-toggle="modal"
                                                            data-target="#Delete_Fee{{ $category->id }}"
                                                            title="{{ trans('btns.delete') }}">
                                                            <i class="fa fa-trash"></i></button>
                                                    </form>

                                                    {{-- <a href="{{ route('admin.lesson-categories.show', $category->id) }}"
                                        class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i
                                            class="far fa-eye"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>
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
@endsection
