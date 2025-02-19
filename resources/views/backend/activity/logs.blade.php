@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('setting.activities') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('setting.activities') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('setting.main') }} </span>
            </div>
        </div>
    </div>
@endsection
@section('content')


<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">{{ trans('setting.activity-list') }}</h4>


                </div>
            </div>
                <div class="card-body">
                    {{-- <form action="" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"
                        >  <i class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                    </form> --}}

                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-striped" id="example1">

                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.time') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('setting.description') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.changes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($activities)
                                @foreach ($activities as $activity )
                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ $activity->causer->first_name ?? '' }} {{ $activity->causer->last_name ?? ''  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($activity->created_at)->diffforhumans()  }}</td>

                                    <td>{{ $activity->description  }} {{ $activity->subject ? $activity->subject->name : ' '  }}</td>
                                    <?php
                                    $properties = $activity->properties->toArray();
                                    if(isset($properties['attributes'])){
                                    $subArr['attributes'] = $properties['attributes'];
                                    }
                                    if(isset($properties['old'])){
                                            $subArr['old'] = $properties['old'];
                                        }
                                     // var_dump( $subArr)

                                    ?>
                                    <td>

                                        @if(isset($subArr['old']))
                                        @foreach ($subArr['old'] as $key => $value)
                                           {{ " $key : $value\n" }}

                                          @endforeach
                                          @endif
                                      <br>
                                      @if(isset($subArr['attributes']))
                                      @foreach ($subArr['attributes'] as $key => $value)
                                          {{ "$key : $value" }}

                                        @endforeach
                                        @endif

                                    </td>

                                </tr>
                                @endforeach
                                @endif

                            </tbody>
                        </table>


                    </div>

                    </div>


                </div>
            </div>

        </div>
        <!-- /row -->




@endsection
@section('js')

@include('backend.layouts.datatable-js')
@endsection
