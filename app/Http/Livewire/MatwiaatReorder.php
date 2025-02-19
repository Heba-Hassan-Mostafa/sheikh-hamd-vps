<?php

namespace App\Http\Livewire;

use App\Models\Matwiaat;
use Livewire\Component;

class MatwiaatReorder extends Component
{
    public function render()
    {
        return view('livewire.matwiaat-reorder',[
            'matwiaats' => Matwiaat::orderBy('order_position')->get()

       ]);
    }


    public function updateMatwiaatOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

            Matwiaat::find($item['value'])->update(['order_position'=>$item['order']]);

       }

    }
}