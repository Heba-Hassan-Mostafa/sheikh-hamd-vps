<?php

namespace App\Http\Livewire;

use App\Models\Audio;
use Livewire\Component;


class AudioReorder extends Component
{



    public function render()
    {

        return view('livewire.audio-reorder' ,[
             'audioes' => Audio::orderBy('order_position')->get()

        ]);
    }

    public function updateAudioOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Audio::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}