<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap">
        <thead>
            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.title') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('galleries.image') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('galleries.creatred-at') }}</th>

            </tr>
        </thead>
        <tbody wire:sortable="updateSliderOrder">
            @if ($sliders)
                @foreach ($sliders as $slider)
                    <tr class="reOrder" wire:sortable.item="{{ $slider->id }}" wire:key="slider-{{ $slider->id }}"
                        wire:sortable.handle>
                        <td>{{ $slider->id }}</td>
                        <td>{{ $slider->title }}</td>
                        <td>
                     <img src="{{ asset('Files/slider/' . $slider->image) }}"
                            style="width: 50px; height:50px;">
                        </td>
                           
                        <td>{{ $slider->created_at->format('Y-m-d') }}</td>
                      
                    </tr>
                @endforeach
            @endif


        </tbody>
    </table>
</div>
