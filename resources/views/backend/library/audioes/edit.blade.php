@extends('backend.layouts.master')
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{ URL::asset('assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!--Internal  treeview -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.date.css') }}">
    <style>
        .picker__select--month, .picker__select--year {
            padding: 0 !important;
        }
    </style>
@endsection
@section('title')
    {{ trans('audioes.audio-edit') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('audioes.audioes') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('audioes.audio-edit') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('audioes.audio-edit') }}</h4>
                        <a href="{{ route('admin.library-audio.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('audioes.audioes') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.library-audio.update', $model->id) }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row HeadInput">

                            <div class="col-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $model->id }}">
                                    <label for="name">{{ trans('audioes.audio-name') }}</label>
                                    <input type="text" name="name" value="{{ $model->name }}" class="form-control count-limit">
                                    <div class="d-flex row m-0 mb-3">
                                        <p class="num-lim col-6 mt-2" style="color: #03aad7">
                                            <span class="counting">0</span>
                                            /
                                            <span class="limitVal"></span>
                                        </p>
                                        <p class="col-6 mt-2" style="color: #03aad7; text-align: left;"> مراعاة الحد الاقصى لارشفة العنوان <span style="color: red">40</span> حرف </p>
                                    </div>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="status">{{ trans('audioes.status') }}</label>
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
                                    <label for="publish_date">{{ trans('audioes.publish-date') }}</label>
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

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="audio_category_id">{{ trans('audioes.categories') }}</label>
                                    <select name="audio_category_id" class="form-control">
                                        <option value="">{{ trans('audioes.select-category') }}</option>
                                        @forelse ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('audio_category_id', $model->audio_category_id) == $category->id ? 'selected' : null }}>
                                            {{ $category->name }}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                    @error('audio_category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>


                        <div class="row inputContentUpload">
                            <div class="col-6">
                                <label for="audio_file">{{ trans('audioes.audio-file') }}</label>
                                <br>

                                    <div class="file-loading">
                                        <input type="file" accept="audio/*" name="audio_file"
                                            class="file-input-overview form-control">
                                    </div>
                                    @if (!empty($model->audio_file))
                                        <div class="audio{{ $model->id }} d-flex">
                                            <audio
                                                src="{{ asset('Files/audioes/' . $model->name . '/' . $model->audio_file) }}"
                                                controls></audio>
                                            <button class="deleteAudio btn btn-danger" audio_id="{{ $model->id }}">Delete</button>

                                        </div>
                                    @else
                                        <span style="cursor: context-menu;color: red;">
                                            {{ trans('audioes.no-audio-found') }}
                                        </span>
                                    @endif
                                @error('audio_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="embed_link">{{ trans('audioes.embed-link') }}</label>
                                <br>
                                    <div class="file-loading">
                                        <input type="url" value="{{ $model->embed_link }}" name="embed_link"
                                            class="file-input-overview form-control">
                                    </div>
                                    <br>
                                    @php
                                        $url = getYoutubeId($model->embed_link);
                                    @endphp
                                    @if ($url)
                                        <iframe width="320" height="200"
                                            src="https://www.youtube.com/embed/{{ $url }}" frameborder="0"
                                            allowfullscreen>
                                        </iframe>
                                    @endif
                                @error('embed_link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row inputContentDescription">

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="keywords">{{ trans('audioes.keywords') }}</label>
                                    <input type="text" name="keywords" value="{{ $model->keywords }}"
                                        class="form-control">
                                    @error('keywords')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="description">{{ trans('audioes.description') }}</label>
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



    <script>
        $(document).on('click', '.deleteAudio', function(e) {
            e.preventDefault();
            var audio_id = $(this).attr('audio_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.library-audio.remove_audio') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': audio_id,
                    'audio_id': {{ $model->id }}
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

@endsection
