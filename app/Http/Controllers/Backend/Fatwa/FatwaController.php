<?php

namespace App\Http\Controllers\Backend\Fatwa;

use App\Models\Fatwa;
use App\Exports\FatwaExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FatwaAnswer;
use Maatwebsite\Excel\Facades\Excel;

class FatwaController extends Controller
{

    public function index()
    {
        $fatwa = Fatwa::with('client')->orderBy('id','desc')->get();

        return view('backend.fatwa.index',compact('fatwa'));

    }


    public function edit($id)
    {
        $model = Fatwa::findOrFail($id);
        return view('backend.fatwa.edit',compact('model'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'answer'               => 'sometimes|nullable',
            'publish_date'         =>'required',
            'audio_file'           =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'youtube_link'         =>'url|sometimes|nullable',

        ]);
        $fatwa = Fatwa::findOrFail($id);

        $answer = new FatwaAnswer();

        if($audio_file = $request->file('audio_file'))
        {

                $audio_name = $audio_file->getClientOriginalName();
                $audio_file->storeAs('fatwa/'.$fatwa->name,$audio_name , 'upload_attachments');
                $answer->audio_file = $audio_name;

        }

            $fatwa->fatwa_answer()->create([
                'answer'        =>$request->answer ,
                'publish_date'  =>$request->publish_date ,
                'youtube_link'  =>$request->youtube_link ,
                'fatwa_id'      =>$fatwa->id ,
                'audio_file'    =>$answer->audio_file

            ]);

            $success=[
                'message'=>trans('btns.answered-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.fatwa.index')->with($success);
        }


    public function destroy($id)
    {
        Fatwa::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.fatwa.index')->with($success);
    }

    public function change_status(Request $request)
    {

        $fatwa = Fatwa::findOrFail($request->id);
        $fatwa->status = $request->status;

        $fatwa->save();


        return response()->json(['success'=>'Status change successfully.']);

   }

   public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Fatwa::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.fatwa.index')->with($success);

    }

    public function export()
    {
        return Excel::download(new FatwaExport(), trans('clients.fatwa').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

    }
}