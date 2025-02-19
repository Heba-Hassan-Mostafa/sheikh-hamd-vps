@extends('backend.layouts.master')
@section('css')
@include('backend.layouts.datatable-css')

@endsection
@section('title')
    {{ trans('events.old-events') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('events.old-events') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('events.main') }} </span>
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
                    <h4 class="card-title mg-b-0">{{ trans('events.old-main-title') }}</h4>


                </div>
            </div>

                <div class="card-body">
                    <form action="{{ route('admin.events.past-export') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-info mb-3 font-weight-bold"
                        >  <i class="fas fa-file-excel"></i> {{ trans('btns.export') }}</button>
                    </form>

                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-striped" id="example1">

                            <thead>

                                <br>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('events.title') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.place') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.type') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('events.image') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('events.start') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('events.time') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>


                                </tr>
                            </thead>
                            <tbody>
                                @if ($events)
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event->id }}</td>
                                            <td>{{ $event->title }}</td>
                                            <td>{{ $event->place }}</td>
                                            <td>{{ $event->type }}</td>
                                             <td>
                                                @if(!empty($event->photo))
                                                <img src="{{ asset('Files/image/Events/'.$event->title.'/'.$event->photo) }}">
                                                @else
                                                ------
                                                @endif
                                                </td>
                                            <td>{{ $event->start->format('Y-m-d') }}</td>
                                            <td> {{ date('g:ia', strtotime($event->start))}}</td>
                                                <td>
                                                <div class="btn-group">

                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#edit{{ $event->id }}"><i class="fa fa-edit"></i></button>

                                                </div>
                                            </td>
                                        </tr>

                                    @include('backend.events.edit')
                                    
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
