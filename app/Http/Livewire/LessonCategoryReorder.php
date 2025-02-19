<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LessonCategory;

class LessonCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.lesson-category-reorder',[
            'categories' => LessonCategory::withCount('lessons')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            LessonCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}