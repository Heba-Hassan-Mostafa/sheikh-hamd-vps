<?php

namespace App\Http\Controllers\Backend\Live;

use App\Models\Live;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendMails;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LiveBroadcastNotification;

class LiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Live $model)
    {
        if ($model->all()->count() > 0) {

            $model = Live::first();
        }

        return view('backend.live.index' ,compact('model'));
    }



    public function update(Request $request)
    {
        $this->validate($request,
        [
            'live_link' => 'url|nullable',
        ]);



        if (Live::all()->count() > 0) {
            Live::find(1)->update($request->all());
        } else {
            Live::create($request->all());
        }

        $live = Live::where('live_link', '!=' ,' ')->first();
            if($live)
            {
               $subscribers=Subscriber::chunk(10,function($data) use($live){
                    dispatch(new SendMails($data,$live));

                });
            }

            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->back()->with($success);


    }


}