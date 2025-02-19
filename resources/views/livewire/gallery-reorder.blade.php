<div class="table-responsive" wire:ignore>
    <table class="table text-md-nowrap">
        <thead>

            <tr>
                <th class="wd-15p border-bottom-0">#</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.title') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.category-name') }}</th>
                <th class="wd-20p border-bottom-0">{{ trans('galleries.image-count') }}</th>
                <th class="wd-15p border-bottom-0">{{ trans('galleries.status') }}</th>
                <th class="wd-10p border-bottom-0">{{ trans('galleries.creatred-at') }}</th>

            </tr>
        </thead>
        <tbody  wire:sortable="updateGalleryOrder">
            @if ($galleries)
            @foreach ($galleries as $gallery )
            <tr class="reOrder" wire:sortable.item="{{ $gallery->id }}" wire:key="gallery-{{ $gallery->id }}"
                wire:sortable.handle>
                <td>{{ $gallery->id }}</td>
                <td style="width: 200px">{{ $gallery->title }}</td>
                <td>{{ $gallery->galleryCategory->name }}</td>
                <td>{{ $gallery->images->count() }}</td>

                <td>{{ $gallery->status() }}</td>
                <td style="width : 70px">{{ $gallery->created_at->format('Y-m-d') }}</td>
               
            </tr>
            @endforeach
            @endif


        </tbody>
            </table>
        </div>

