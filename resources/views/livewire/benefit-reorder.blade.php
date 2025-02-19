<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap table-striped">

        <thead>
            
            <tr>
                <th style="max-width: 2%" class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('benefits.benefit-name') }}</th>
                <th style="max-width: 6%" class="wd-20p border-bottom-0">{{ trans('benefits.benefit-category') }}</th>
                <th style="max-width: 6%" class="wd-10p border-bottom-0">{{ trans('benefits.status') }}</th>
                <th style="max-width: 6%" class="wd-15p border-bottom-0">{{ trans('benefits.publish-date') }}</th>

            </tr>
        </thead>
        <tbody wire:sortable="updateBenefitOrder">
            @if ($benefits)
                @foreach ($benefits as $benefit)
                    <tr class="reOrder" wire:sortable.item="{{ $benefit->id }}" wire:key="benefit-{{ $benefit->id }}"
                        wire:sortable.handle>
                        <td>{{ $benefit->id }}</td>
                        <td style="width: 200px">{{ $benefit->name }}</td>
                        <td>{{ $benefit->category->name }}</td>
                        <td>{{ $benefit->status() }}</td>
                        <td style="width : 70px">{{ $benefit->publish_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach

            @endif


        </tbody>
    </table>


</div>
