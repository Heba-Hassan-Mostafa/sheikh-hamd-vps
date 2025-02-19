@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('galleries.add-caption') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.galleries') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('galleries.add-caption') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('galleries.add-caption') }}</h4>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('galleries.galleries') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.galleries.caption',$model->id) }}" method="Post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <br>
                               @livewire('gallery-caption-reorder',['model'=>$model])
                                <input class="text" type="hidden" id="update_all_id" name="update_all_id" value=''>
                            </div>
                        </div>
                        <div class="form-group pt-4">
                            <button type="submit" name="save" class="saveInputs btn btn-primary">
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
<script>
    let saveInputBtn = document.querySelector(".saveInputs");
    let callDiv = document.querySelectorAll(".pDiv");
    let selected = new Array();
    callDiv.forEach(e => {
        let newElement = document.createElement("textarea");
            });
            let callIn = document.querySelectorAll(".allInputs");
                saveInputBtn.onclick = function(){
                callIn.forEach((v)=> {
                        selected.push(v.value)
                    let inputId = document.querySelector("#update_all_id");
                    inputId.value = selected;
                })
            }
</script>
@endsection
