<?php

namespace App\Http\Controllers\Backend\Events;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Subscriber;
use App\Exports\EventExport;
use Illuminate\Http\Request;
use App\Exports\PastEventExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Jobs\SendEvents;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::where('start','>=',Carbon::now())->get();

        return view('backend.events.index',compact('events'));

    }



    public function store(Request $request)
    {
        try {
        $validation = Validator::make($request->all(), [

            'title'      =>'required|string|max:255',
            'place'      =>'required|string|max:255',
            'type'       =>'required|string|max:255',
            'photo'      =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg',
            'start'      =>'required|date',

        ]);

        $data['title']       = $request->title;
        $data['place']       = $request->place;
        $data['type']        = $request->type;
        $data['start']       = $request->start;

        $event = Event::create($data);

        if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Events/'.$event->title, $img , 'upload_attachments');

                    $event->photo = $img;

            }
            $event->save();
           
            

             $subscribers=Subscriber::chunk(10,function($data) use($event){
                    dispatch(new SendEvents($data,$event));

                });

             $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.events.index')->with($success);
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function show($id)
    {
    }

    public function update(Request $request)
    {

        try {
        $validation = Validator::make($request->all(), [

            'title'      =>'required|string|max:255',
            'place'      =>'required|string|max:255',
            'type'       =>'required|string|max:255',
            'start'      =>'required|date',
            'photo'      =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg',

        ]);

        $event = Event::findOrFail($request->id);

        $data['title']       = $request->title;
        $data['place']       = $request->place;
        $data['type']        = $request->type;
        $data['start']       = $request->start;


            $event->update($data);
            
           
             if($image= $request->file('photo'))
             {
                if (!empty($event->photo))
                {
                    if (File::exists('Files/image/Events/'.$event->title.'/'. $event->photo))
                    {
                    unlink('Files/image/Events/'.$event->title.'/'. $event->photo);
                    }
                }
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Events/'.$event->title, $img , 'upload_attachments');
                    $event->photo = $img;

            }
            $event->save();

             $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.events.index')->with($success);
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        if(!empty($event->photo))
        {
             if (File::exists('Files/image/Events/'.$event->title.'/'. $event->photo))
                {
                    unlink('Files/image/Events/'.$event->title.'/'. $event->photo);
                }

        }
        
        $event->delete();
        
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.events.index')->with($success);
   }


   public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Event::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.events.index')->with($success);

    }

 public function remove_img(Request $request)
    {
        $event = Event::findOrFail($request->id);

        if(File::exists('Files/image/Events/'.$event->title.'/'.$event->photo))
            {
                 unlink('Files/image/Events/'.$event->title.'/'.$event->photo);
            }
        if (!$event)
            return redirect()->back()->with(['error' => 'image not exist']);

        $event->update(['photo'=>null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);



    }



    public function past_events()
    {
        $events = Event::where('start','<',Carbon::now())->get();

        return view('backend.events.past-events',compact('events'));

    }


    public function export()
    {
        return Excel::download(new EventExport(), trans('events.events').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

    }

    public function past_export()
    {
        return Excel::download(new PastEventExport(), trans('events.old-events').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

    }
}
