<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;


class VideoReorder extends Component
{



    public function render()
    {

        return view('livewire.video-reorder' ,[
             'videos' => Video::orderBy('order_position')->get()

        ]);
    }

    public function updateVideoOrder($items)
    {
       //dd($items);

       foreach($items as $item)
       {

        Video::find($item['value'])->update(['order_position'=>$item['order']]);
       }
    }
}