<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped" id="example1">

        <thead>
            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('audioes.audio-name') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('audioes.audio-category') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('audioes.status') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('audioes.publish-date') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('audioes.download-count') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('audioes.view-count') }}</th>

                <th class="wd-10p border-bottom-0">{{ trans('btns.actions') }}</th>

            </tr>
        </thead>

        <tbody wire:sortable="updateAudioOrder">
            @if ($audioes)
                @foreach ($audioes as $audio)
                    <tr class="reOrder" wire:sortable.item="{{ $audio->id }}" wire:key="audio-{{ $audio->id }}"
                        wire:sortable.handle>
                        <td>{{ $audio->id }}</td>
                        <td style="width: 200px">{{ $audio->name }}</td>
                        <td>{{ $audio->category ? $audio->category->name : $audio->audioable?->category->name }}</td>
                        <td>{{ $audio->status() }}</td>
                        <td style="width: 70px">{{ $audio->publish_date->format('Y-m-d') }}</td>
                        <td>{{ $audio->download_count }}</td>
                        <td>{{ $audio->view_count }}</td>
                        <td>
                            <div class="btn-group">

                                @if ($audio->audioable)

                                @else
                                <a href="{{ route('admin.library-audio.edit', $audio->id) }}" class="btn btn-info btn-sm"
                                    role="button" aria-pressed="true">
                                    <i class="fa fa-edit"></i></a>

                                <form action="{{ route('admin.library-audio.destroy', $audio->id) }}" method="POST"
                                    class="dnone">
                                    @csrf
                                    @method('Delete')
                                    <input type="hidden" name="id" value="{{ $audio->id }}">
                                    <button id="delete" type="button" class="btn btn-danger btn-sm"
                                        data-name="{{ $audio->name }}" data-toggle="modal"
                                        data-target="#Delete_Fee{{ $audio->id }}"
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
