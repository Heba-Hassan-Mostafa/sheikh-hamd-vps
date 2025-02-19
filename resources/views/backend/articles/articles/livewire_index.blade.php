@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')


@endsection
@section('title')
    {{ trans('articles.articles') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('articles.articles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('articles.main') }} </span>
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
                    <h4 class="card-title mg-b-0">{{ trans('articles.article-list') }}</h4>


                </div>
            </div>
            
                <div class="card-body">

                    @livewire('article-reorder')

                    </div>


                </div>
            </div>

        </div>
        <!-- /row -->




@endsection
@section('js')

@include('backend.layouts.datatable-js')

@endsection
