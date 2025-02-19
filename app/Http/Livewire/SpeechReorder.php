<?php

namespace App\Http\Livewire;

use App\Models\Speech;
use Livewire\Component;


class SpeechReorder extends Component
{



    public function render()
    {

        return view('livewire.speech-reorder' ,[
             'speeches' => Speech::orderBy('order_position')->get()

        ]);
    }

    public function updateSpeechOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Speech::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}