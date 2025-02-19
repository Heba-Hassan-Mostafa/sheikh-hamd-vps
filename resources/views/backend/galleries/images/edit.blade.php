@extends('backend.layouts.master')
@section('css')
    <link href="{{ asset('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
@endsection
@section('title')
    {{ trans('galleries.edit-gallery') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('galleries.galleries') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('galleries.edit-gallery') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('galleries.edit-gallery') }}</h4>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('galleries.galleries') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.galleries.update', $model->id) }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
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
                                    <label for="gallery_category_id">{{ trans('galleries.categories') }}</label>
                                    <select name="gallery_category_id" class="form-control">
                                        <option value="">{{ trans('galleries.select-category') }}</option>
                                        @forelse ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('gallery_category_id', $model->gallery_category_id) == $category->id ? 'selected' : null }}>
                                                {{ $category->name }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @error('gallery_category_id')
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

                            <div class="col-12">
                                <label for="images">{{ trans('galleries.choose-images') }}</label>
                                <br>
                                <div class="file-loading">

                                    <input type="file" name="images[]" id="gallery" class="file-input-overview"
                                        multiple>
                                </div>
                                @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group pt-4">
                            <button type="submit" name="save" class="btn btn-primary">
                                {{ trans('btns.save') }}</button>

                            <a href="{{ route('admin.galleries.show', $model->id) }}"
                                class="btn btn-success btn-sm font-weight-bold" role="button" aria-pressed="true">
                                Add captions</a>

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
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>

    <script>
        $(function() {

            $("#gallery").fileinput({
                theme: "fas",
                maxFileCount: 20,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($model->images()->count() > 0)
                        @foreach ($model->images as $image)
                            "{{ asset('Files/gallery/' . $image->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [
                    @if ($model->images()->count() > 0)
                        @foreach ($model->images as $image)
                            {
                                caption: '{{ $image->file_name }}',
                                size: '{{ $image->file_size }}',
                                width: "120px",
                                url: "{{ route('admin.galleries.remove_image', ['image_id' => $image->id, 'gallery_id' => $model->id, '_token' => csrf_token()]) }}",
                                key: {{ $image->id }},
                                description: `<span>{{ $image->description }}</span>`,
                            },
                        @endforeach
                    @endif
                ]
            });


        });
    </script>
@endsection
