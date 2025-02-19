<div class="modal fade" id="edit{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('events.edit-event') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('admin.events.update', 'test') }}" method="post" enctype="multipart/form-data">
                    {{ method_field('patch') }}
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="mr-sm-2">{{ trans('events.title') }}
                                :</label>
                            <input id="title" type="text" name="title" class="form-control"
                                value="{{ $event->title }}" >
                            <input id="id" type="hidden" name="id" class="form-control"
                                value="{{ $event->id }}">
                        </div>
                        <div class="col-12">
                            <label for="type" class="mr-sm-2">{{ trans('events.type') }}
                                :</label>
                            <input id="type" type="text" name="type" class="form-control"
                                value="{{ $event->type }}" >
                        </div>
                        <div class="col-12">
                            <label for="place" class="mr-sm-2">{{ trans('events.place') }}
                                :</label>
                            <input id="place" type="text" name="place" class="form-control"
                                value="{{ $event->place }}" >
                        </div>
                            <div class="col-12">
                                <label for="photo">{{ trans('events.image') }}</label>
                                <br>

                                <div class="file-loading">
                                    <input type="file" accept="image/*" name="photo"
                                        class="file-input-overview form-control">
                                </div>
                                @if (!empty($event->photo))
                                    <div class="img{{ $event->id }}">
                                        <img src="{{ asset('/Files/image/Events/'. $event->title.'/'. $event->photo) }}"
                                            style="width:100px;height: 100px;">
                                        <button class="deleteImg btn btn-danger" img_id="{{ $event->id }}">{{ trans('btns.delete') }}</button>

                                    </div>
                                @else
                                    <span style="cursor: context-menu;color: red;"> {{ trans('events.no-img-found') }}
                                    </span>
                                @endif

                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        <div class="col-12">
                            <label for="start" class="mr-sm-2">{{ trans('events.start') }}
                                :</label>
                            <input  type="datetime-local" name="start" class="form-control"
                                value="{{ $event->start }}" >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('btns.close') }}</button>
                        <button type="submit" class="btn btn-success">{{ trans('btns.save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
