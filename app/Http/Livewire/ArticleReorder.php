<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;


class ArticleReorder extends Component
{



    public function render()
    {

        return view('livewire.article-reorder' ,[
             'articles' => Article::orderBy('order_position')->get()

        ]);
    }

    public function updateArticleOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Article::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}