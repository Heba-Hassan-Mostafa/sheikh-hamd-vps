<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped" id="example1">

        <thead>
            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('videos.video-name') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('videos.video-category') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('videos.status') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('videos.publish-date') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('videos.download-count') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('videos.view-count') }}</th>

                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

            </tr>
        </thead>

        <tbody wire:sortable="updateVideoOrder">
            @if ($videos)
                @foreach ($videos as $video)
                    <tr class="reOrder" wire:sortable.item="{{ $video->id }}" wire:key="video-{{ $video->id }}"
                        wire:sortable.handle>
                        <td>{{ $video->id }}</td>
                        <td style="width: 200px">{{ $video->name }}</td>
                        <td>{{ $video->category ? $video->category->name : $video->videoable?->category->name }}</td>
                        <td>{{ $video->status() }}</td>
                        <td style="width: 70px">{{ $video->publish_date->format('Y-m-d') }}</td>
                        <td>{{ $video->download_count }}</td>
                        <td>{{ $video->view_count }}</td>
                        <td>
                            <div class="btn-group">

                                @if ($video->videoable)

                                @else
                                <a href="{{ route('admin.library-video.edit', $video->id) }}" class="btn btn-info btn-sm"
                                    role="button" aria-pressed="true">
                                    <i class="fa fa-edit"></i></a>

                                <form action="{{ route('admin.library-video.destroy', $video->id) }}" method="POST"
                                    class="dnone">
                                    @csrf
                                    @method('Delete')
                                    <input type="hidden" name="id" value="{{ $video->id }}">
                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                        data-name="{{ $video->name }}" data-toggle="modal"
                                        data-target="#Delete_Fee{{ $video->id }}"
                                        title="{{ trans('btns.delete') }}">
                                        <i class="fa fa-trash"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
