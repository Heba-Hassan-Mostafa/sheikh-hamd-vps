<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    {{ trans('events.create-event') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('admin.events.store') }}" method="Post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="mr-sm-2">{{ trans('events.title') }}
                                :</label>
                            <input id="title" type="text" name="title" class="form-control"
                                value="{{ old('title')}}" >

                        </div>
                        <div class="col-12">
                            <label for="type" class="mr-sm-2">{{ trans('events.type') }}
                                :</label>
                            <input id="type" type="text" name="type" class="form-control"
                                value="{{ old('type') }}" >
                        </div>
                        <div class="col-12">
                            <label for="place" class="mr-sm-2">{{ trans('events.place') }}
                                :</label>
                            <input id="place" type="text" name="place" class="form-control"
                                value="{{ old('place') }}" >
                        </div>
                           <div class="col-12">
                                <label for="photo">{{ trans('events.image') }}</label>
                                <br>
                                    <span style="color:red"> مراعاة ان يكون عرض الصورة (420px) والارتفاع (420px)</span>
                                <br>
                                <div class="file-loading">
                                    <input type="file" accept="image/*" name="photo" class="form-control">
                                </div>
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        <div class="col-12">
                            <label for="start" class="mr-sm-2">{{ trans('events.start') }}
                                :</label>
                            <input  type="datetime-local" name="start" class="form-control"
                                value="{{ old('start') }}" >
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
