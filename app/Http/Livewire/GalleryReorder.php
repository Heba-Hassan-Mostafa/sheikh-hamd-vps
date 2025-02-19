<?php

namespace App\Http\Livewire;

use App\Models\Gallery;
use Livewire\Component;

class GalleryReorder extends Component
{
    public function render()
    {
        return view('livewire.gallery-reorder',[
            'galleries' => Gallery::orderBy('order_position')->get()

       ]);
    }


    public function updateGalleryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            Gallery::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }
}