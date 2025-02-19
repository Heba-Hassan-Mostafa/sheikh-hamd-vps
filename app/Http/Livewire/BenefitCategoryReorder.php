<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BenefitCategory;

class BenefitCategoryReorder extends Component
{


    public function render()
    {
        return view('livewire.benefit-category-reorder',[
            'categories' => BenefitCategory::withCount('benefits')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        BenefitCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}