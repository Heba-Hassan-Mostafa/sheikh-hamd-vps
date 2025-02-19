<?php

namespace App\Http\Livewire;

use App\Models\Lecture;
use Livewire\Component;


class LectureReorder extends Component
{



    public function render()
    {

        return view('livewire.lecture-reorder' ,[
             'lectures' => Lecture::orderBy('order_position')->get()

        ]);
    }

    public function updateLectureOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Lecture::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}