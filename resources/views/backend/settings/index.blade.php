@extends('backend.layouts.master')
@section('css')
@endsection
@section('title')
    {{ trans('setting.title') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('setting.title') }}</h4>
                {{-- <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('se.create-category') }}</span> --}}
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="tab nav-border">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                    role="tab" aria-controls="home-02"
                                    aria-selected="true">{{ trans('setting.title') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02" role="tab"
                                    aria-controls="profile-02" aria-selected="false">{{ trans('setting.banners') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                aria-labelledby="home-02-tab">

                                <form enctype="multipart/form-data" method="POST"
                                    action="{{ route('admin.settings.update', $setting->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 border-right-2 border-right-blue-400">
                                            <div class="form-group">
                                                <label class="col-lg-2 col-form-label font-weight-semibold">
                                                    {{ trans('setting.site-name') }}</label>
                                                <div class="col-lg-9">
                                                    <input type="hidden" name="id" value="{{ $setting->id }}">
                                                    <input name="site_name" value="{{ $setting->site_name }}" type="text"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.site_right') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="site_right" value="{{ $setting->site_right }}"
                                                        type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.email') }}</label>
                                                <div class="col-lg-9">
                                                    <input name="email" value="{{ $setting->email }}" type="email"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-form-label font-weight-semibold">
                                                    {{ trans('setting.phone') }}</label>
                                                <div class="col-lg-9">
                                                    <input name="phone" value="{{ $setting->phone }}" type="text"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 col-form-label font-weight-semibold">
                                                    {{ trans('setting.woman_phone') }}</label>
                                                <div class="col-lg-9">
                                                    <input required name="women_phone" value="{{ $setting->women_phone }}"
                                                        type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.facebook') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="facebook" value="{{ $setting->facebook }}" type="url"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.twitter') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="twitter" value="{{ $setting->twitter }}" type="url"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.youtube') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="youtube" value="{{ $setting->youtube }}" type="url"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.instagram') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="instagram" value="{{ $setting->instagram }}"
                                                        type="url" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.telegram') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="telegram" value="{{ $setting->telegram }}"
                                                        type="url" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.logo') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <span class="d-block" style="color:red">يفضل ان يكون
                                                        عرض شعار الموقع (580px) والارتفاع (230px)</span>
                                                    <input name="logo" accept="image/*" type="file"
                                                        class="form-control" data-show-caption="false"
                                                        data-show-upload="false" data-fouc>
                                                    <div class="mb-3">
                                                        @if ($setting->logo)
                                                            <img style="width: 345px;
                                                            height: 125px;
                                                            margin: 15px;"
                                                                src="{{ asset('Files/settings/' . $setting->logo) }}"
                                                                alt="">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.icon') }}
                                                </label>
                                                <div class="col-lg-9">

                                                    <input name="icon" accept="image/*" type="file"
                                                        class="form-control" data-show-caption="false"
                                                        data-show-upload="false" data-fouc>
                                                    <div class="mb-3">
                                                        @if ($setting->icon)
                                                            <img style="width: 100px" height="100px"
                                                                src="{{ asset('Files/settings/' . $setting->icon) }}"
                                                                alt="">
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.about_sheikh') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <textarea name="about_sheikh" class="form-control" id='ckeditor'>{!! $setting->about_sheikh !!}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.status') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <select name="status" class="form-control">
                                                        <option value="1"
                                                            {{ old('status', $setting->status) == '1' ? 'selected' : null }}>
                                                            {{ trans('setting.open') }}</option>
                                                        <option value="0"
                                                            {{ old('status', $setting->status) == '0' ? 'selected' : null }}>
                                                            {{ trans('setting.close') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.message_maintenance') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <textarea name="message_maintenance" class="form-control">{!! $setting->message_maintenance !!}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.keywords') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <input name="keywords" value="{{ $setting->keywords }}"
                                                        type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-lg-2 col-form-label font-weight-semibold">{{ trans('setting.description') }}
                                                </label>
                                                <div class="col-lg-9">
                                                    <textarea name="description" class="form-control">{!! $setting->description !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>


                            </div>

                            <div class="tab-pane fade" id="profile-02" role="tabpanel" aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="academic_year">{{ trans('setting.banners') }}
                                                    : <span class="text-danger"></span></label>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.default-slider-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:green">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (435px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="slider_image" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="mb-3">
                                                                @if ($setting->slider_image)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->slider_image) }}"
                                                                        alt="">
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.lesson-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>
                                                        <div class="col-lg-9">

                                                            <input name="lesson_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="img{{ $setting->id }}">
                                                                @if ($setting->lesson_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->lesson_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteImg btn btn-danger"
                                                                        img_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.lecture-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>
                                                        <div class="col-lg-9">
                                                            <input name="lecture_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="lecture{{ $setting->id }}">
                                                                @if ($setting->lecture_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->lecture_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteLecture btn btn-danger"
                                                                        lecture_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.article-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="article_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="article{{ $setting->id }}">
                                                                @if ($setting->article_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->article_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteArticle btn btn-danger"
                                                                        article_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.book-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="book_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="book{{ $setting->id }}">
                                                                @if ($setting->book_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->book_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteBook btn btn-danger"
                                                                        book_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.speech-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="speech_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="speech{{ $setting->id }}">
                                                                @if ($setting->speech_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->speech_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteSpeech btn btn-danger"
                                                                        speech_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.benefit-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="benefit_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="benefit{{ $setting->id }}">
                                                                @if ($setting->benefit_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->benefit_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteBenefit btn btn-danger"
                                                                        benefit_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.gallery-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="gallery_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="gallery{{ $setting->id }}">
                                                                @if ($setting->gallery_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->gallery_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteGallery btn btn-danger"
                                                                        gallery_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.matwiaat-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="matwiaat_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="matwiaat{{ $setting->id }}">
                                                                @if ($setting->matwiaat_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->matwiaat_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteMatwiaat btn btn-danger"
                                                                    matwiaat_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.video-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="video_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="video{{ $setting->id }}">
                                                                @if ($setting->video_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->video_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteVideo btn btn-danger"
                                                                        video_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-lg-12 col-form-label font-weight-semibold">{{ trans('setting.sound-banner-image') }}
                                                        </label>
                                                        <span class="d-block text-center" style="color:red">يفضل ان يكون
                                                            عرض الصورة (1300px) والارتفاع (300px)</span>

                                                        <div class="col-lg-9">

                                                            <input name="audio_banner" accept="image/*" type="file"
                                                                class="form-control" data-show-caption="false"
                                                                data-show-upload="false" data-fouc>
                                                            <div class="audio{{ $setting->id }}">
                                                                @if ($setting->audio_banner)
                                                                    <img style="width: 500px;
                                                                    height: 200px;
                                                                    margin: 10px;"
                                                                        src="{{ asset('Files/settings/' . $setting->audio_banner) }}"
                                                                        alt="">
                                                                    <button class="deleteAudio btn btn-danger"
                                                                        audio_id="{{ $setting->id }}">{{ trans('btns.delete') }}</button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                    </div>
                                </div>

                            </div>
                            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right"
                                type="submit">{{ trans('btns.save') }}</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">


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

    <script>
        $(document).on('click', '.deleteImg', function(e) {
            e.preventDefault();
            var img_id = $(this).attr('img_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_lesson_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': img_id,
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
        $(document).on('click', '.deleteLecture', function(e) {
            e.preventDefault();
            var lecture_id = $(this).attr('lecture_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_lecture_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': lecture_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.lecture' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteArticle', function(e) {
            e.preventDefault();
            var article_id = $(this).attr('article_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_article_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': article_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.article' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteBook', function(e) {
            e.preventDefault();
            var book_id = $(this).attr('book_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_book_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': book_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.book' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteBenefit', function(e) {
            e.preventDefault();
            var benefit_id = $(this).attr('benefit_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_benefit_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': benefit_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.benefit' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>

    <script>
        $(document).on('click', '.deleteSpeech', function(e) {
            e.preventDefault();
            var speech_id = $(this).attr('speech_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_speech_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': speech_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.speech' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>
    <script>
        $(document).on('click', '.deleteGallery', function(e) {
            e.preventDefault();
            var gallery_id = $(this).attr('gallery_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_gallery_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': gallery_id,
                },
                success: function(data) {
                    if (data.status == true) {
                        $('#success_msg').show();
                    }
                    $('.gallery' + data.id).remove();
                },
                error: function(reject) {}
            });
        });
    </script>
  <script>
    $(document).on('click', '.deleteMatwiaat', function(e) {
        e.preventDefault();
        var matwiaat_id = $(this).attr('matwiaat_id');
        $.ajax({
            type: 'post',
            url: "{{ route('admin.settings.remove_matwiaat_banner') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': matwiaat_id,
            },
            success: function(data) {
                if (data.status == true) {
                    $('#success_msg').show();
                }
                $('.matwiaat' + data.id).remove();
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
                url: "{{ route('admin.settings.remove_video_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': video_id,
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
    <script>
        $(document).on('click', '.deleteAudio', function(e) {
            e.preventDefault();
            var audio_id = $(this).attr('audio_id');
            $.ajax({
                type: 'post',
                url: "{{ route('admin.settings.remove_audio_banner') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': audio_id,
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
