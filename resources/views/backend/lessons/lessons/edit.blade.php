@extends('backend.layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{ URL::asset('assets/plugins/treeview/treeview-rtl.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.date.css') }}">
    <style>
        .picker__select--month, .picker__select--year {
            padding: 0 !important;
        }
    </style>
@endsection
@section('title')
    {{ trans('lessons.lesson-edit') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lessons.lessons') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('lessons.lesson-edit') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="alert alert-success" id="success_msg" style="display: none;">
    {{  trans('btns.deleted-successfully')}}
    </div>
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
                        <h4 class="card-title mg-b-0">{{ trans('lessons.lesson-edit') }}</h4>
                        <a href="{{ route('admin.lessons.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('lessons.lessons') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.lessons.update', $model->id) }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row HeadInput">

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $model->id }}">
                                    <label for="name">{{ trans('lessons.lesson-name') }}</label>
                                    <input type="text" name="name" value="{{ $model->name }}" class="form-control count-limit">
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
                                    <label for="status">{{ trans('lessons.status') }}</label>
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


                            <div class="col-6">
                                <div class="form-group">
                                    <label for="publish_date">{{ trans('lessons.publish-date') }}</label>
                                    <div class='input-group date'>
                                        <input type="text" id="publish_date" name="publish_date" value="{{ $model->publish_date->format('Y-m-d') }}"  class="form-control">

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
                                    <h4 class="selectCatTo">{{ trans('lessons.choose-category') }}</h4>
                                    <li><a href="#">{{ trans('lessons.categories') }}</a>
                                        <ul class="row fristParent">
                                    </li>
                                    @foreach ($categories as $category)
                                        <ul class="col-4 parentCategory">
                                            <label style="font-size: 16px;">
                                                <input type="radio" name="lesson_category_id"
                                                    value="{{ $category->id }}"
                                                    {{ old('lesson_category_id', $model->lesson_category_id) == $category->id ? 'checked' : '' }}>
                                                {{ $category->name }}</label>

                                            @include('backend.lessons.lessons.subCategoryListEdit', [
                                                'subcategories' => $category->subcategory,
                                            ])
                                        </ul>
                                    @endforeach
                                </ul>
                                @error('lesson_category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row contentTextEditor">
                            <div class="col-12">
                                <label for="content">{{ trans('lessons.content') }}</label>
                                <textarea name="content" rows="3" class="form-control" id='ckeditor'>
                                  {!! $model->content !!}
                              </textarea>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row inputContentUpload">
                            <div class="col-6">
                                <label for="pdf_file">{{ trans('lessons.pdf_file') }}</label>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="application/pdf" name="pdf_files[]"
                                        class="file-input-overview form-control" multiple>
                                </div>
                                <ul style="list-style: none ; padding:0">
                                    @if ($model->attachments()->count() > 0)
                                        @foreach ($model->attachments as $file)
                                            <li class="pdf{{ $file->id }} m-2 ">
                                                <i class="fas fa-file-pdf" style="color:#ce0000"></i>
                                                <a
                                                    href="{{ asset('Files/Pdf-Files/Lessons/' . $model->name . '/' . $file->file_name) }}">{{ $file->file_name }}</a>

                                                <button class="deleteRecord btn btn-danger mr-2" pdf_id="{{ $file->id }}">{{ trans('btns.delete') }}</button>
                                            </li>
                                        @endforeach
                                    @else
                                        <li style="cursor: context-menu;color: red;"> {{ trans('lessons.no-pdf-found') }}
                                        </li>
                                    @endif
                                </ul>
                                @error('pdf_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="photo">{{ trans('lessons.image') }}</label>
                                <br>

                                <div class="file-loading">
                                    <input type="file" accept="image/*" name="photo"
                                        class="file-input-overview form-control">
                                </div>
                                @if (!empty($model->image->file_name))
                                    <div class="img{{ $model->image->id }}">
                                        <img src="{{ asset('Files/image/Lessons/' . $model->name . '/' . $model->image->file_name) }}"
                                            style="width:100px;height: 100px;">
                                        <button class="deleteImg btn btn-danger" img_id="{{ $model->image->id }}">{{ trans('btns.delete') }}</button>

                                    </div>
                                @else
                                    <span style="cursor: context-menu;color: red;"> {{ trans('lessons.no-img-found') }}
                                    </span>
                                @endif

                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="video_file">{{ trans('lessons.video-file') }}</label>
                                <br>
                                @foreach ($model->videos as $video)
                                    <div class="file-loading">
                                        <input type="file" accept="video/*" name="video_file"
                                            class="file-input-overview form-control">
                                    </div>
                                    @if (!empty($video->video_file))
                                        <div class="video{{ $video->id }} d-flex">
                                            <video style="width: 300px; height:300px;"
                                                src="{{ asset('Files/videos/' . $model->name . '/' . $video->video_file) }}"
                                                controls></video>
                                            <button style="width: 90px; height:90px;" class="deleteVideo btn btn-danger" video_id="{{ $video->id }}"> {{ trans('btns.delete') }}</button>

                                        </div>
                                    @else
                                        <span style="cursor: context-menu;color: red;">
                                            {{ trans('lessons.no-video-found') }}
                                        </span>
                                    @endif
                                @endforeach
                                @error('audio_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="youtube_link">{{ trans('lessons.youtube-link') }}</label>
                                <br>
                                @foreach ($model->videos as $video)
                                    <div class="file-loading">
                                        <input type="url" name="youtube_link" value="{{ $video->youtube_link }}"
                                            class="file-input-overview form-control">
                                    </div>
                                    <br>
                                    @php
                                        $url = getYoutubeId($video->youtube_link);
                                    @endphp
                                    @if ($url)
                                        <iframe width="320" height="200"
                                            src="https://www.youtube.com/embed/{{ $url }}" frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                @endforeach
                                @error('youtube_link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="audio_file">{{ trans('lessons.audio-file') }}</label>
                                <br>
                                @foreach ($model->audioes as $audio)
                                    <div class="file-loading">
                                        <input type="file" accept="audio/*" name="audio_file"
                                            class="file-input-overview form-control">
                                    </div>
                                    @if (!empty($audio->audio_file))
                                        <div class="audio{{ $audio->id }} d-flex">
                                            <audio
                                                src="{{ asset('Files/audioes/' . $model->name . '/' . $audio->audio_file) }}"
                                                controls></audio>
                                            <button class="deleteAudio btn btn-danger" audio_id="{{ $audio->id }}">{{ trans('btns.delete') }}</button>

                                        </div>
                                    @else
                                        <span style="cursor: context-menu;color: red;">
                                            {{ trans('lessons.no-audio-found') }}
                                        </span>
                                    @endif
                                @endforeach
                                @error('audio_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="embed_link">{{ trans('lessons.embed-link') }}</label>
                                <br>
                                @foreach ($model->audioes as $audio)
                                    <div class="file-loading">
                                        <input type="url" value="{{ $audio->embed_link }}" name="embed_link"
                                            class="file-input-overview form-control">
                                    </div>
                                    <br>
                                    @php
                                        $url = getYoutubeId($audio->embed_link);
                                    @endphp
                                    @if ($url)
                                        <iframe width="320" height="200"
                                            src="https://www.youtube.com/embed/{{ $url }}" frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                @endforeach
                                @error('embed_link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>



                        <div class="row inputContentDescription">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keywords">{{ trans('lessons.keywords') }}</label>
                                    <input type="text" name="keywords" value="{{ $model->keywords }}"
                                        class="form-control">
                                    @error('keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="description">{{ trans('lessons.description') }}</label>
                                <textarea name="description" rows="3" class="form-control summernote">{!! $model->description !!}</textarea>
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
        selected_ci_date ="";
        selected_ci_date = $('#publish_date').val();
        if (selected_ci_date != null)   {
            var cidate = new Date(selected_ci_date);
            min_codate = "";
            min_codate = new Date();
            min_codate.setDate(cidate.getDate()+1);

        }
    });



   </script>
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


    <script src="{{ URL::asset('assets/plugins/treeview/treeview.js') }}"></script>


    <script>
        $(document).on('click', '.deleteRecord', function(e) {
            e.preventDefault();
            var pdf_id = $(this).attr('pdf_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.lessons.remove_pdf') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': pdf_id,
                    'lesson_id': {{ $model->id }}
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.pdf' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteAudio', function(e) {
            e.preventDefault();
            var audio_id = $(this).attr('audio_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.lessons.remove_audio') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': audio_id,
                    'lesson_id': {{ $model->id }}
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.audio' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>


    <script>
        $(document).on('click', '.deleteImg', function(e) {
            e.preventDefault();
            var img_id = $(this).attr('img_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.lessons.remove_img') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': img_id,
                    'lesson_id': {{ $model->id }}
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.img' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

<script>
    $(document).on('click', '.deleteVideo', function(e) {
        e.preventDefault();
        var video_id = $(this).attr('video_id');
        $.ajax({
            type: 'post',
            url: "{{ route('admin.lessons.remove_video') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': video_id,
                'lesson_id': {{ $model->id }}
            },
            success: function(data) {
                if (data.status == true) {
                    $('#success_msg').show();
                }
                $('.video' + data.id).remove();
            },
            error: function(reject) {}
        });
    });
</script>
@endsection
