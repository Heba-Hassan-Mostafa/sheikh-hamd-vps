@extends('backend.layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/pickadate/themes/classic.date.css') }}">
<style>
    .picker__select--month, .picker__select--year {
        padding: 0 !important;
    }
    #report-summary {

    }
    @page { size:  auto; margin: 25mm 25mm 25mm 25mm; }
    @media print {
    .printPage{
        display: none !important;
    }
    }
</style>
@endsection
@section('title')
    {{ trans('clients.fatwa') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('clients.fatwa') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('clients.fatwa-answer') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('clients.fatwa-answer') }}</h4>
                        <a href="{{ route('admin.fatwa.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('clients.fatwa') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.fatwa.update', $model->id) }}" method="Post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row fatwaAns" id="report-summary">
                            <div class="col-6">
                                <div class="printbtn printPage btn btn-info-gradient font-weight-bold m-3 ">
                                    <a class="printPage text-white" href="#">طباعة السؤال</a>
                                  </div>
                                <div  class="form-group">
                                    <label for="name">{{ trans('clients.name') }}</label>
                                    <input type="text" name="name" value="{{ $model->name }}" class="form-control" readonly>
                                </div>
                            </div>





                            <div class="col-12 ">
                                <label for="message">{{ trans('clients.message') }}</label>
                                <textarea name="message" rows="3" class="form-control" readonly>{!! $model->message !!}</textarea>
                            </div>

                            </div>


                            <div class="row printPage ">

                                <div class="col-12 fatwaAns">
                                    <label for="answer">{{ trans('clients.answer') }}</label>
                                    <textarea name="answer" rows="3" class="form-control" id="ckeditor"></textarea>
                                </div>

                                <div class="col-6 fatwaAns">
                                    <div class="form-group">
                                        <label for="publish_date">{{ trans('lessons.publish-date') }}</label>
                                        <div class='input-group date'>
                                            <input type="text" id="publish_date" name="publish_date" value="{{ old('publish_date') }}"  class="form-control">

                                        </div>
                                        @error('publish_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-8 fatwaAns">
                                    <label for="audio_file">{{ trans('lessons.audio-file') }}</label>
                                    <br>
                                    <div class="file-loading">
                                        <input type="file" accept="audio/*" name="audio_file" class="form-control">
                                    </div>
                                </div>

                                <div class="col-8 fatwaAns">
                                    <label for="youtube_link">{{ trans('lectures.youtube-link') }}</label>
                                    <br>
                                    <div class="file-loading">
                                        <input type="url" name="youtube_link" class="form-control">
                                    </div>
                                    @error('youtube_link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                            </div>







                        <div class="form-group pt-4 mr-4 printPage ">
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
        selected_ci_date = $('#start_date').val();
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

        $('a.printPage').click(function(){
          $('#report-summary').show();
             window.print();
             return false;
        });
    </script>

@endsection
