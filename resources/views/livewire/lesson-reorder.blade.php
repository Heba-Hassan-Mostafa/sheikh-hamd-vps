<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
           
            <tr>
                  <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('lessons.lesson-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('lessons.lesson-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('lessons.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('lessons.publish-date') }}</th>
               

            </tr>
        </thead>
        <tbody wire:sortable="updateLessonOrder">
            @if ($lessons)
                @foreach ($lessons as $lesson)
                    <tr class="reOrder" wire:sortable.item="{{ $lesson->id }}" wire:key="lesson-{{ $lesson->id }}"
                        wire:sortable.handle>
                        <td>{{ $lesson->id }}</td>
                        <td style="width: 200px">{{ $lesson->name }}</td>
                        <td>{{ $lesson->category->name }}</td>
                        <td>{{ $lesson->status() }}</td>
                        <td style="width : 70px">{{ $lesson->publish_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
