<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;


class BookReorder extends Component
{



    public function render()
    {

        return view('livewire.book-reorder' ,[
             'books' => Book::orderBy('order_position')->get()

        ]);
    }

    public function updateBookOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Book::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}