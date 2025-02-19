<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\GalleryCategory;

class GalleryCategoryReorder extends Component
{
    public function render()
    {
        return view('livewire.gallery-category-reorder',[
            'categories' => GalleryCategory::orderBy('order_position')->get()

       ]);
    }

    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            GalleryCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }

}
