@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@section('title')
    {{ trans('lessons.lesson-show') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('lessons.lessons') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('lessons.lesson-show') }}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">{{ trans('lessons.lesson-create') }}</h4>
                        <a href="{{ route('admin.lessons.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('lessons.lessons') }}</span>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab nav-border">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                    role="tab" aria-controls="home-02"
                                    aria-selected="true">{{ trans('lessons.details') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02" role="tab"
                                    aria-controls="profile-02" aria-selected="false">{{ trans('lessons.attachments') }}</a>
                            </li>
                              <li class="nav-item">
                                <a class="nav-link" id="profile-03-tab" data-toggle="tab" href="#profile-03" role="tab"
                                    aria-controls="profile-03" aria-selected="false">{{ trans('setting.logs') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                aria-labelledby="home-02-tab">
                                <table class="table table-striped table-hover" style="text-align:center">
                                    <tbody>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.lesson-name') }}</th>
                                            <td class="showContentTd">{{ $lesson->name }}</td>

                                        </tr>
                                          <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.lesson-link') }}</th>
                                            <td class="showContentTd">
                                                <a href="{{ route('frontend.lessons.lesson_content',$lesson->slug) }}">
                                                    https://hamadalhajri.net/lessons/{{ $lesson->slug }}
                                                </a></td>

                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.lesson-category') }}
                                            </th>
                                            <td class="showContentTd">{{ $lesson->category->name }}</td>
                                        </tr>
                                       
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.status') }}</th>
                                            <td class="showContentTd">{{ $lesson->status() }}</td>

                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.publish-date') }}
                                            </th>
                                            <td class="showContentTd">{{ $lesson->publish_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.content') }}</th>
                                            <td class="showContentTd">
                                                @if (!empty($lesson->content))
                                                    <p> {!! $lesson->content !!} </p>
                                                @else
                                                    <strong>{{ trans('lessons.no-content') }}</strong>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.keywords') }}</th>
                                            <td class="showContentTd">{{ $lesson->keywords }}</td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.description') }}
                                            </th>
                                            <td class="showContentTd">{{ $lesson->description }}</td>

                                        </tr>


                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.youtube-link') }}
                                            </th>
                                            <td class="showContentTd">
                                                @foreach ($lesson->videos as $video)
                                                    <div class="file-loading">
                                                        <input type="url" value="{{ $video->youtube_link }}"
                                                            name="youtube_link" class="form-control" readonly>
                                                    </div>
                                                    @php
                                                        $url = getYoutubeId($video->youtube_link);
                                                    @endphp
                                                    @if ($url)
                                                        <iframe width="320" height="200"
                                                            src="https://www.youtube.com/embed/{{ $url }}"
                                                            frameborder="0" allowfullscreen>
                                                        </iframe>
                                                    @else
                                                        <div style="cursor: context-menu;color: red;">
                                                            {{ trans('lessons.no-video') }}</div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('lessons.embed-link') }}</th>
                                            <td class="showContentTd">
                                                @foreach ($lesson->audioes as $audio)
                                                    <div class="file-loading">
                                                        <input type="url" value="{{ $audio->embed_link }}"
                                                            name="embed_link" class="form-control" readonly>
                                                    </div>
                                                    @php
                                                        $url = getYoutubeId($audio->embed_link);
                                                    @endphp
                                                    @if ($url)
                                                        <iframe width="320" height="200"
                                                            src="https://www.youtube.com/embed/{{ $url }}"
                                                            frameborder="0" allowfullscreen>
                                                        </iframe>
                                                    @else
                                                        <div style="cursor: context-menu;color: red;">
                                                            {{ trans('lessons.no-embed-found') }}</div>
                                                    @endif
                                                @endforeach
                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="profile-02" role="tabpanel" aria-labelledby="profile-02-tab">
                                <div class="card card-statistics">
                                    <div class="card-body">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="academic_year">{{ trans('lessons.attachments') }}
                                                    : <span class="text-danger"></span></label>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('lessons.pdf_files') }}:</label>
                                                        <br>
                                                        @if ($lesson->attachments()->count() > 0)
                                                            @forelse ($lesson->attachments as $file)
                                                                <li class="pdf{{ $file->id }}">
                                                                    <i class="fas fa-file-pdf" style="color:#ce0000"></i>
                                                                    <a
                                                                        href="{{ asset('Files/Pdf-Files/Lessons/' . $lesson->name . '/' . $file->file_name) }}">{{ $file->file_name }}</a>
                                                                </li>
                                                            @empty
                                                                <li style="cursor: context-menu;color: red;">
                                                                    {{ trans('lessons.no-pdf-found') }}</li>
                                                            @endforelse
                                                        @else
                                                            <li style="cursor: context-menu;color: red;">
                                                                {{ trans('lessons.no-pdf-found') }}</li>

                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('lessons.audio') }}:</label>
                                                        <br>
                                                        @foreach ($lesson->audioes as $audio)
                                                            @if (!empty($audio->audio_file))
                                                                <audio
                                                                    src="{{ asset('Files/audioes/' . $lesson->name . '/' . $audio->audio_file) }}"
                                                                    controls></audio>
                                                            @else
                                                                <span style="cursor: context-menu;color: red;">
                                                                    {{ trans('lessons.no-audio-found') }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('lessons.video') }}:</label>
                                                        <br>
                                                        @foreach ($lesson->videos as $video)
                                                            @if (!empty($video->video_file))
                                                                <video
                                                                    src="{{ asset('Files/videos/' . $lesson->name . '/' . $video->video_file) }}"
                                                                    controls></video>
                                                            @else
                                                                <span style="cursor: context-menu;color: red;">
                                                                    {{ trans('lessons.no-video-found') }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('lessons.image') }}:</label>
                                                        <br>
                                                        @if (!empty($lesson->image->file_name))
                                                            <img src="{{ asset('Files/image/Lessons/' . $lesson->name . '/' . $lesson->image->file_name) }}"
                                                                style="width:200px;height: 200px;">
                                                        @else
                                                            <span style="cursor: context-menu;color: red;">
                                                                {{ trans('lessons.no-img-found') }}
                                                            </span>
                                                        @endif

                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                            
                             <div class="tab-pane fade" id="profile-03" role="tabpanel" aria-labelledby="profile-02-tab">
                                <div class="card card-statistics displayLogCard">
                                    <div class="card-body">

                                        <?php
                                        $logs = Spatie\Activitylog\Models\Activity::where('subject_type', 'App\Models\Lesson', function ($q) {
                                            $q->where('subject_id', $lesson->id);
                                        })->get();


                                        ?>
                                        <div class="tab-pane fade active show" id="home-03" role="tabpanel"
                                            aria-labelledby="home-03-tab">
                                            <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                                aria-labelledby="home-02-tab">
                                                <table class="table table-striped table-hover" style="text-align:center">
                                                    
                                                        @forelse ($logs as $log)
                                                        @if ($log->subject_id == $lesson->id)
                                                    <tbody class="tbodyDisplayLog">
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.name') }}</th>
                                                            <td>{{ $log->subject ? $log->subject->name : '-----' }}</td>

                                                        </tr>
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.created_by') }}
                                                            </th>
                                                            <td>
                                                                {{ $log->causer ? $log->causer->first_name : '' }}
                                                                {{ $log->causer ? $log->causer->last_name : '' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.time') }}
                                                            </th>
                                                            <td>
                                                                {{ \Carbon\Carbon::parse($log->created_at)->diffforhumans() }}
                                                                 <br>
                                                            {{ $log->created_at->format('Y-m-d H:i:a') }}
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.description') }}
                                                            </th>
                                                            <td>{{ $log->description }}</td>
                                                        </tr>
                                                        
                                                        
                                                        <?php
                                                         $properties = $log->properties->toArray();
                                                            if(isset($properties['attributes'])){
                                                            $subArr['attributes'] = $properties['attributes'];
                                                            }
                                                            if(isset($properties['old'])){
                                                                    $subArr['old'] = $properties['old'];
                                                            }
                                                        ?>
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.changes') }}
                                                            </th>
                                                            <td style="direction: ltr;">

                                                                @if(isset($subArr['old']))
                                                                @foreach ($subArr['old'] as $key => $value)
                                                                    <p class="display_log">  <span>{{$key}} :</span> <span> {{$value}} </span> </p>
                                                                  @endforeach
                                                                  @endif
                                                              <br>
                                                              @if(isset($subArr['attributes']))
                                                              @foreach ($subArr['attributes'] as $key => $value)
                                                                    <p class="display_log">  <span>{{$key}} :</span> <span> {{$value}} </span> </p>

                                                                @endforeach
                                                                @endif

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                        @endif
                                                        @empty
                                                        <span>No Logs</span>
                                                        
                                                        
                                                        @endforelse
                                                    
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <br>

                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    @include('backend.lessons.lessons.show-comment')
@endsection
@section('js')
    @include('backend.layouts.datatable-js')

    <script>
        $(function() {

            $('.custom-control-input').on('change', function() {

                var status = $(this).prop('checked') == true ? 1 : 0;

                var id = $(this).data('id');
                console.log(status);

                $.ajax({

                    type: "GET",

                    dataType: "json",

                    url: '{{ route('admin.comments.change') }}',

                    data: {
                        'status': status,
                        'id': id
                    },

                    success: function(data) {

                        console.log(data.success)

                    }

                });

            })

        })
    </script>
@endsection
