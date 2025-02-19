<?php

namespace App\Http\Livewire;

use App\Models\Image;
use Livewire\Component;

class GalleryCaptionReorder extends Component
{

    public $model ;
    public function render()
    {
        $items = $this->model->images()->orderBy('order_position')->get();
        return view('livewire.gallery-caption-reorder',compact('items'));
    }


    public function updateCaptionOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            Image::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }
}