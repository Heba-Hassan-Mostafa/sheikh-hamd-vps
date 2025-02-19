@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('galleries.matwiaat') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">{{ trans('galleries.main') }} </span>
                <h4 class="content-title mb-0 my-auto">/{{ trans('galleries.matwiaat') }}</h4>

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
                    <h4 class="card-title mg-b-0">{{ trans('galleries.matwiaat-list') }}</h4>


                </div>
            </div>
            <div class="card-body">

               @livewire('matwiaat-reorder')

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
