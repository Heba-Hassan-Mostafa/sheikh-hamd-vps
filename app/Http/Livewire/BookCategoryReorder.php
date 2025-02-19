<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BookCategory;

class BookCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.book-category-reorder',[
            'categories' => BookCategory::withCount('books')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        BookCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}