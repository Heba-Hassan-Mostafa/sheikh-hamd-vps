<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap">
        <thead>

            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.title') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('galleries.image') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.status') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('galleries.creatred-at') }}</th>

            </tr>
        </thead>
        <tbody  wire:sortable="updateMatwiaatOrder">
            @if ($matwiaats)
            @foreach ($matwiaats as $matwiaat )
            <tr class="reOrder" wire:sortable.item="{{ $matwiaat->id }}" wire:key="matwiaat-{{ $matwiaat->id }}"
                wire:sortable.handle>
                <td>{{ $matwiaat->id }}</td>
                <td style="width: 200px">{{ $matwiaat->title }}</td>
                <td>
                    @if (!empty($matwiaat->image))
                        <img src="{{ asset('Files/Matwiaat/' . $matwiaat->image) }}"
                            style="width:70px;height: 70px;">
                @endif
                </td>

                <td>{{ $matwiaat->status() }}</td>
                <td style="width : 70px">{{ $matwiaat->created_at->format('Y-m-d') }}</td>

            </tr>
            @endforeach
            @endif


        </tbody>
            </table>
        </div>

