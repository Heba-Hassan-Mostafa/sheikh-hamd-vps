<div  wire:ignore>
    <div class="row captionBoxDesign" wire:sortable="updateCaptionOrder">

        @if ($items->count() > 0)
        @foreach ($items as $image)
        <div class="file-loading pDiv col-5" wire:sortable.item="{{ $image->id }}" wire:key="image-{{ $image->id }}"
            wire:sortable.handle>
            <input type="hidden" name="image_id" value="{{ $image->id }}">
            <img src="{{ asset('Files/gallery/'.$image->file_name) }}">
            <textarea type="text" name="description" class="allInputs" value="" placeholder="اضف وصف الصورة">{{ $image->description }}</textarea>
        </div>

        @endforeach
        @endif
        </div>
</div>
