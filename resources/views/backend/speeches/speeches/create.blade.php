@extends('backend.layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.date.css') }}">
    <style>
        .picker__select--month,
        .picker__select--year {
            padding: 0 !important;
        }
    </style>
@endsection
@section('title')
    {{ trans('speeches.speech-create') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('speeches.speeches') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('speeches.speech-create') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">


                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">


                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ trans('speeches.speech-create') }}</h4>
                        <a href="{{ route('admin.speeches.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('speeches.speeches') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.speeches.store') }}" method="Post" enctype="multipart/form-data">
                        @csrf
                        <div class="row HeadInput">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">{{ trans('speeches.speech-name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control count-limit">
                                    <div class="d-flex row m-0 mb-3">
                                        <p class="num-lim col-6 mt-2" style="color: #03aad7">
                                            <span class="counting">0</span>
                                            /
                                            <span class="limitVal"></span>
                                        </p>
                                        <p class="col-6 mt-2" style="color: #03aad7; text-align: left;">
                                            {{ trans('articles.title-count') }}
                                              <span style="color: red">40</span> {{ trans('articles.chars') }} </p>
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
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


                            <div class="col-6">
                                <div class="form-group">
                                    <label for="publish_date">{{ trans('speeches.publish-date') }}</label>
                                    <div class='input-group date'>
                                        <input type="text" id="publish_date" name="publish_date"
                                            value="{{ old('publish_date') }}" class="form-control">
                                    </div>
                                    @error('publish_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="row">

                            <div class="col-lg-12">
                                <ul id="treeview1">
                                    <h4 class="selectCatTo">{{ trans('speeches.choose-category') }}</h4>
                                    <li><a href="#">{{ trans('speeches.categories') }}</a>
                                        <ul class="row fristParent">
                                    </li>
                                    @foreach ($categories as $category)
                                        <ul class="col-4 parentCategory">

                                            <label style="font-size: 16px;">
                                                {{ Form::radio('speech_category_id', $category->id, false, ['class' => 'name']) }}
                                                {{ $category->name }}</label>

                                            @include('backend.speeches.speeches.subCategoryList', [
                                                'subcategories' => $category->subcategory,
                                            ])
                                        </ul>
                                    @endforeach
                                </ul>

                                @error('speech_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row contentTextEditor">
                            <div class="col-12">
                                <label for="content">{{ trans('speeches.content') }}</label>
                                <textarea name="content" rows="3" class="form-control" id='ckeditor'>{!! old('content') !!}</textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row inputContentUpload">
                            <div class="col-6">
                                <label for="pdf_file">{{ trans('speeches.pdf_file') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="application/pdf" name="pdf_files[]" class="form-control"
                                        multiple>
                                </div>
                                @error('pdf_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="photo">{{ trans('speeches.image') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="image/*" name="photo" class="form-control">
                                </div>
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="video_file">{{ trans('speeches.video-file') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="video/*" name="video_file" class="form-control">
                                </div>
                                @error('video_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="youtube_link">{{ trans('speeches.youtube-link') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="url" name="youtube_link" class="form-control">
                                </div>
                                @error('youtube_link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label for="audio_file">{{ trans('speeches.audio-file') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="audio/*" name="audio_file" class="form-control">
                                </div>
                                @error('audio_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-6">
                                <label for="embed_link">{{ trans('speeches.embed-link') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="url" name="embed_link" class="file-input-overview form-control">
                                </div>
                                @error('embed_link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                        </div>
                </div>

                <div class="row inputContentDescription">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="keywords">{{ trans('speeches.keywords') }}</label>
                            <input type="text" name="keywords" value="{{ old('name') }}" class="form-control">
                            @error('keywords')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="description">{{ trans('speeches.description') }}</label>
                        <textarea style="height : 200px" name="description" class="form-control">{!! old('description') !!}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="form-group pt-4 mr-4">
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
    <script src="{{ asset('assets/plugins/texteditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.config.language = 'ar';
        CKEDITOR.replace('ckeditor', {
            filebrowserImageBrowseUrl: '/file-manager/ckeditor',
             contentsCss: [
                'https://fonts.googleapis.com/css2?family=Cairo&family=Amiri&family=Almarai&family=Aref+Ruqaa&family=El+Messiri&family=Reem+Kufi&display=swap',
                'path/to/your/custom/styles.css' // If you have any custom styles
            ],
            font_names: 'Traditional Arabic/Traditional Arabic;' +
                'Cairo/Cairo;Amiri/Amiri;Almarai/Almarai;El Messiri/El Messiri;Reem Kufi/Reem Kufi;Aref Ruqaa/Aref Ruqaa;' +
                CKEDITOR.config.font_names
        });
    </script>

    <!-- datepicker -->
    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>

    <script src="{{ asset('assets/plugins/pickadate/picker.js') }}"></script>
    <script src="{{ asset('assets/plugins/pickadate/picker.date.js') }}"></script>
    <script>
        $('#publish_date').pickadate({
            format: 'yyyy-mm-dd',
            selectMonths: true, // Creates a dropdown to control month
            selectYears: true, // Creates a dropdown to control month
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: true // Close upon selecting a date,
        });
        var publishdate = $('#publish_date').pickadate('picker');


        $('#publish_date').change(function() {
            selected_ci_date = "";
            selected_ci_date = $('#publish_date').val();
            if (selected_ci_date != null) {
                var cidate = new Date(selected_ci_date);
                min_codate = "";
                min_codate = new Date();
                min_codate.setDate(cidate.getDate() + 1);

            }
        });
    </script>
@endsection
