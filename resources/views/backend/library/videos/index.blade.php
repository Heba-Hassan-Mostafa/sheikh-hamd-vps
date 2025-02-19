@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')


@endsection
@section('title')
    {{ trans('videos.videos') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('videos.videos') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('videos.main') }} </span>
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
                    <h4 class="card-title mg-b-0">{{ trans('videos.video-list') }}</h4>


                </div>
            </div>
            <a href="{{ route('admin.library-video.create') }}" class="addNewCont btn btn-success font-weight-bold" role="button"
                aria-pressed="true"> <i class="fa fa-plus"></i> {{ trans('btns.create-video') }} </a>

                <div class="card-body">

                    @livewire('video-reorder')

                    </div>


                </div>
            </div>

        </div>
        <!-- /row -->




@endsection
@section('js')

@include('backend.layouts.datatable-js')
<script>
    $(document).ready(function(){
        $(".btn-group").css("pointer-events","auto");
        $("tbody").css("pointer-events","none");
        $( "select").click(function(){
            if($( "select option:selected" ).val() == 1000){
                $("tbody").css("pointer-events","auto");
            }else{
                $("tbody").css("pointer-events","none");
            }
        })
    })
</script>
@endsection
