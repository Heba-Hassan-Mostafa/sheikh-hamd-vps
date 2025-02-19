<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AudioCategory;

class AudioCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.audio-category-reorder',[
            'categories' => AudioCategory::withCount('audioes')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        AudioCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}