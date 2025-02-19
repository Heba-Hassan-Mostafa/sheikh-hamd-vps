<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ArticleCategory;

class ArticleCategoryReorder extends Component
{





    public function render()
    {
        return view('livewire.article-category-reorder',[
            'categories' => ArticleCategory::withCount('articles')->whereNULL('parent_id')->orderBy('order_position')->get()

       ]);
    }


    public function updateCategoryOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        ArticleCategory::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }


}