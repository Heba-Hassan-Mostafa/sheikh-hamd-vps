<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SpeechCategory;

class SpeechCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.speech-category-reorder',[
            'categories' => SpeechCategory::withCount('speeches')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            SpeechCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}