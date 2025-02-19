<?php

namespace App\Http\Livewire;

use App\Models\Benefit;
use Livewire\Component;


class BenefitReorder extends Component
{



    public function render()
    {

        return view('livewire.benefit-reorder' ,[
             'benefits' => Benefit::orderBy('order_position')->get()

        ]);
    }

    public function updateBenefitOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Benefit::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}