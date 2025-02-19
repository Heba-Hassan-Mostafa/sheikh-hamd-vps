<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
            <tr>
               
                 <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('speeches.speech-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('speeches.speech-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('speeches.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('speeches.publish-date') }}</th>
            </tr>
        </thead>
        <tbody wire:sortable="updateSpeechOrder">
            @if ($speeches)
                @foreach ($speeches as $speech)
                    <tr class="reOrder" wire:sortable.item="{{ $speech->id }}" wire:key="speech-{{ $speech->id }}"
                        wire:sortable.handle>
                        <td>{{ $speech->id }}</td>
                        <td style="width: 200px">{{ $speech->name }}</td>
                        <td>{{ $speech->category->name }}</td>
                        <td>{{ $speech->status() }}</td>
                        <td style="width : 70px">{{ $speech->publish_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
