<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
            <tr>
                
                  <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('lectures.lecture-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('lectures.lecture-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('lectures.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('lectures.publish-date') }}</th>
            </tr>
        </thead>
        <tbody wire:sortable="updateLectureOrder">
            @if ($lectures)
                @foreach ($lectures as $lecture)
                    <tr class="reOrder" wire:sortable.item="{{ $lecture->id }}" wire:key="lecture-{{ $lecture->id }}"
                        wire:sortable.handle>
                        <td>{{ $lecture->id }}</td>
                        <td style="width: 200px">{{ $lecture->name }}</td>
                        <td>{{ $lecture->category->name }}</td>
                        <td>{{ $lecture->status() }}</td>
                        <td style="width : 70px">{{ $lecture->publish_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
