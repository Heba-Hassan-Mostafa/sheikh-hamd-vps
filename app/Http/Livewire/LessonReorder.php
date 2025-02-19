<?php

namespace App\Http\Livewire;

use App\Models\Lesson;
use Livewire\Component;


class LessonReorder extends Component
{



    public function render()
    {

        return view('livewire.lesson-reorder' ,[


             'lessons' => Lesson::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateLessonOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Lesson::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}