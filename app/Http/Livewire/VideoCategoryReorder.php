<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\VideoCategory;

class VideoCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.video-category-reorder',[
            'categories' => VideoCategory::withCount('videos')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        VideoCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}