@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@section('title')
    {{ trans('speeches.speech-show') }}
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('speeches.speeches') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('speeches.speech-show') }}</span>
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
                        <h4 class="card-title mg-b-0">{{ trans('speeches.speech-edit') }}</h4>
                        <a href="{{ route('admin.speeches.index') }}" class="btn btn-primary">
                            <i class="fa fa-home"></i>
                            <span class="text">{{ trans('speeches.speeches') }}</span>
                        </a>
                    </div>
                </div>


                <div class="card-body">
                    <div class="tab nav-border">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="home-02-tab" data-toggle="tab" href="#home-02"
                                    role="tab" aria-controls="home-02"
                                    aria-selected="true">{{ trans('speeches.details') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-02-tab" data-toggle="tab" href="#profile-02" role="tab"
                                    aria-controls="profile-02" aria-selected="false">{{ trans('speeches.attachments') }}</a>
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
                                            <th class="showContentTh" scope="row">{{ trans('speeches.speech-name') }}</th>
                                            <td class="showContentTd">{{ $speech->name }}</td>

                                        </tr>
                                         <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.speech-link') }}</th>
                                            <td class="showContentTd">
                                                <a href="{{ route('frontend.speeches.speech_content',$speech->slug) }}">
                                                    https://hamadalhajri.net/speeches/{{ $speech->slug }}
                                                </a></td>

                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.speech-category') }}
                                            </th>
                                            <td class="showContentTd">{{ $speech->category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.status') }}</th>
                                            <td class="showContentTd">{{ $speech->status() }}</td>

                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.publish-date') }}
                                            </th>
                                            <td class="showContentTd">{{ $speech->publish_date->format('Y-m-d') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.content') }}</th>
                                            <td class="showContentTd">
                                                @if (!empty($speech->content))
                                                    <p> {!! $speech->content !!} </p>
                                                @else
                                                    <strong>{{ trans('speeches.no-content') }}</strong>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.keywords') }}</th>
                                            <td class="showContentTd">{{ $speech->keywords }}</td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.description') }}
                                            </th>
                                            <td class="showContentTd">{{ $speech->description }}</td>

                                        </tr>


                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.youtube-link') }}
                                            </th>
                                            <td class="showContentTd">
                                                @foreach ($speech->videos as $video)
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
                                                            {{ trans('speeches.no-video') }}</div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="showContentTh" scope="row">{{ trans('speeches.embed-link') }}</th>
                                            <td class="showContentTd">
                                                @foreach ($speech->audioes as $audio)
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
                                                            {{ trans('speeches.no-embed-found') }}</div>
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
                                                <label for="academic_year">{{ trans('speeches.attachments') }}
                                                    : <span class="text-danger"></span></label>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('speeches.pdf_files') }}:</label>
                                                        <br>
                                                        @if ($speech->attachments()->count() > 0)
                                                            @forelse ($speech->attachments as $file)
                                                                <li class="pdf{{ $file->id }}">
                                                                    <i class="fas fa-file-pdf" style="color:#ce0000"></i>
                                                                    <a
                                                                        href="{{ asset('Files/Pdf-Files/Speeches/' . $speech->name . '/' . $file->file_name) }}">{{ $file->file_name }}</a>
                                                                </li>
                                                            @empty
                                                                <li style="cursor: context-menu;color: red;">
                                                                    {{ trans('speeches.no-pdf-found') }}</li>
                                                            @endforelse
                                                        @else
                                                            <li style="cursor: context-menu;color: red;">
                                                                {{ trans('speeches.no-pdf-found') }}</li>

                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('speeches.audio') }}:</label>
                                                        <br>
                                                        @foreach ($speech->audioes as $audio)
                                                            @if (!empty($audio->audio_file))
                                                                <audio
                                                                    src="{{ asset('Files/audioes/' . $speech->name . '/' . $audio->audio_file) }}"
                                                                    controls></audio>
                                                            @else
                                                                <span style="cursor: context-menu;color: red;">
                                                                    {{ trans('speeches.no-audio-found') }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('speeches.video') }}:</label>
                                                        <br>
                                                        @foreach ($speech->videos as $video)
                                                            @if (!empty($video->video_file))
                                                                <video
                                                                    src="{{ asset('Files/videos/' . $speech->name . '/' . $video->video_file) }}"
                                                                    controls></video>
                                                            @else
                                                                <span style="cursor: context-menu;color: red;">
                                                                    {{ trans('speeches.no-video-found') }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-control-label">{{ trans('speeches.image') }}:</label>
                                                        <br>
                                                        @if (!empty($speech->image->file_name))
                                                            <img src="{{ asset('Files/image/Speeches/' . $speech->name . '/' . $speech->image->file_name) }}"
                                                                style="width:200px;height: 200px;">
                                                        @else
                                                            <span style="cursor: context-menu;color: red;">
                                                                {{ trans('speeches.no-img-found') }}
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
                                        $logs = Spatie\Activitylog\Models\Activity::where('subject_type', 'App\Models\Speech', function ($q) {
                                            $q->where('subject_id', $speech->id);
                                        })->get();


                                        ?>
                                        <div class="tab-pane fade active show" id="home-03" role="tabpanel"
                                            aria-labelledby="home-03-tab">
                                            <div class="tab-pane fade active show" id="home-02" role="tabpanel"
                                                aria-labelledby="home-02-tab">
                                                <table class="table table-striped table-hover" style="text-align:center">
                                                      @forelse ($logs as $log)
                                                        @if ($log->subject_id == $speech->id)
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
                                                            <td>{{ $log->causer ? $log->causer->first_name : '' }}
                                                                {{ $log->causer ? $log->causer->last_name : '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="showContentTh" scope="row">
                                                                {{ trans('setting.time') }}</th>
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


    @include('backend.speeches.speeches.show-comment')
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
