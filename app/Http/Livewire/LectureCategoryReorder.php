<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LectureCategory;

class LectureCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.lecture-category-reorder',[
            'categories' => LectureCategory::withCount('lectures')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            LectureCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}