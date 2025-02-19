@extends('backend.layouts.master')
@section('css')
    @include('backend.layouts.datatable-css')
@endsection
@section('title')
    {{ trans('articles.articles') }}
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('articles.articles') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{ trans('articles.main') }} </span>
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
                        <h4 class="card-title mg-b-0">{{ trans('articles.article-list') }}</h4>


                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-striped" id="example1">

                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.time') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('setting.event') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('setting.changes') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($articles)
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $article->causer->first_name }} {{ $article->causer->last_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($article->created_at)->diffforhumans() }}</td>

                                            <td>{{ __('btns.'.$article->event) }}</td>
                                            <td>
                                                <?php
                                                $exists = App\Models\Article::where('id', $article->subject_id)->exists();
                                                $properties = $article->properties->toArray();
                                                if (isset($properties['attributes'])) {
                                                    $subArr['attributes'] = $properties['attributes'];
                                                }
                                                if (isset($properties['old'])) {
                                                    $subArr['old'] = $properties['old'];
                                                }
                                                // var_dump( $subArr)
                                                ?>
                                                <div class="btn-group">
                                                 @if($exists)

                                                 <a href="{{ route('admin.articles.show', $article->subject_id) }}"
                                                    class="btn btn-warning btn-sm" role="button"
                                                    aria-pressed="true"><i class="far fa-eye"></i></a>
                                                    @else

                                                        @if (isset($subArr['old']['name']))
                                                            {{ __('articles.article-name') . ' : '.$subArr['old']['name'] }}
                                                        @endif

                                                @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                            </tbody>
                        </table>


                    </div>


                    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        {{ trans('btns.delete_articles') }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="{{ route('admin.articles.delete_all') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        {{ trans('btns.warning-for-delete-all') }}
                                        <input class="text" type="hidden" id="delete_all_id" name="delete_all_id"
                                            value=''>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">{{ trans('btns.close') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ trans('btns.delete') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>


            </div>
        </div>

    </div>
    <!-- /row -->




@endsection
@section('js')
    @include('backend.layouts.datatable-js')

    <script type="text/javascript">
        $(function() {
            $("#btn_delete_all").click(function() {
                var selected = new Array();
                $("#example1 input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                    // console.log(selected);
                });
                if (selected.length > 0) {
                    $('#delete_all').modal('show')
                    $('input[id="delete_all_id"]').val(selected);
                }
            });
        });
    </script>
@endsection
