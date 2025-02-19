 <!--div-->
 <div class="col-xl-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <h4 class="card-title mg-b-0"> {{ trans('benefits.comments-list') }}</h4>

            </div>

        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table text-md-nowrap" id="example1">
                    <thead>
                        <tr>
                            <th class="wd-15p border-bottom-0">#</th>
                            <th class="wd-15p border-bottom-0">{{ trans('clients.name') }}</th>
                            <th class="wd-15p border-bottom-0">{{ trans('clients.email') }}</th>
                            <th class="wd-15p border-bottom-0">{{ trans('benefits.comment') }}</th>
                            <th class="wd-15p border-bottom-0">{{ trans('clients.status') }}</th>
                            <th class="wd-10p border-bottom-0">{{ trans('clients.created-at') }}</th>
                            <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($comments)
                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $comment->client->full_name }}</td>
                                    <td>{{ $comment->client->email }}</td>

                                    <td>{{ \Illuminate\Support\Str::limit($comment->message, 100) }}</td>
                                    <td>

                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                id="{{ $comment->id }}" data-id="{{ $comment->id }}"
                                                {{ $comment->status == true ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="{{ $comment->id }}"></label>
                                        </div>

                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($comment->created_at)->diffforhumans() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <form action="{{ route('admin.benefit-comments.destroy', $comment->id) }}"
                                                method="POST" class="dnone">
                                                @csrf
                                                @method('Delete')
                                                <button id="delete" type="button" class="btn btn-danger btn-sm"
                                                    data-name="{{ $comment->name }}" data-toggle="modal"
                                                    data-target="#Delete_Fee{{ $comment->id }}"
                                                    title="{{ trans('btns.delete') }}">
                                                    <i class="fa fa-trash"></i></button>
                                            </form>


                                            <a href="" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#modaldemo3-{{ $comment->id }}">
                                                <i class="fa fa-eye"></i>
                                                <span class="text"></span>
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                                <div id="modaldemo3-{{ $comment->id }}" class="modal fade">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content tx-size-sm">
                                            <div class="modal-header pd-x-20">
                                                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">
                                                    {{ trans('benefits.show-comment') }}</h6>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body pd-20">
                                                <div class="row">
                                                    <div class="col-10">
                                                        {{ $comment->message }}
                                                    </div>
                                                </div>

                                            </div><!-- modal-body -->

                                        </div>
                                    </div><!-- modal-dialog -->
                                </div><!-- modal -->
                            @endforeach
                        @endif


                    </tbody>
                </table>
            </div>
        </div><!-- bd -->
    </div><!-- bd -->
</div>
<!--/div-->
