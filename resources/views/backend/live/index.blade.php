@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('setting.live') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('setting.live') }}</h4>
                {{-- <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('se.create-category') }}</span> --}}
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

                    <form enctype="multipart/form-data" method="post" action="{{ route('admin.live.update',$model->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 border-right-2 border-right-blue-400">
                                <div class="form-group">
                                    <label class="col-lg-2 col-form-label font-weight-semibold">
                                        {{ trans('setting.live-link') }}</label>
                                    <div class="col-lg-9">
                                        <input name="live_link" value="{{ $model->live_link }}" type="url" class="form-control">

                                    </div>
                                    <br>
                                    @php
                                    $url = getYoutubeId($model->live_link)

                                    @endphp
                                    @if($url)

                                    <iframe width="320" height="200"  src="https://www.youtube.com/embed/{{ $url }}" frameborder="0"  allowfullscreen>
                                    </iframe>

                                    @endif
                                </div>



                            </div>
                        </div>
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right"
                            type="submit">{{ trans('btns.save') }}</button>
                    </form>

                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- Container closed -->
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/texteditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.config.language = 'ar';
        CKEDITOR.replace('ckeditor', {
            filebrowserImageBrowseUrl: '/file-manager/ckeditor'
        });
    </script>
@endsection
