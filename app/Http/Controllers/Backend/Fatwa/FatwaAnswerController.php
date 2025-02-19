<?php

namespace App\Http\Controllers\Backend\Fatwa;

use App\Http\Controllers\Controller;
use App\Models\FatwaAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FatwaAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $answers = FatwaAnswer::with('fatwa')->get();

       return view('backend.fatwa.answers.index',compact('answers'));
    }

    public function edit($id)
    {
        $model = FatwaAnswer::findOrFail($id);

       return view('backend.fatwa.answers.edit' , compact('model'));


    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'answer'               => 'sometimes|nullable',
            'publish_date'         =>'required',
            'audio_file'           =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            'youtube_link'         =>'url|sometimes|nullable',

        ]);

        $answer = FatwaAnswer::findOrFail($id);

        $data['answer']        = $request->answer;
        $data['publish_date']  = $request->publish_date;
        $data['youtube_link']  = $request->youtube_link;


       $answer->update($data);


       if($audio_file = $request->file('audio_file'))
       {

               $audio_name = $audio_file->getClientOriginalName();
               $audio_file->storeAs('fatwa/'.$answer->fatwa->name, $audio_name , 'upload_attachments');
               $answer->audio_file = $audio_name;

       }
       $answer->save();


        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.fatwa_answers.index')->with($success);
    }


    public function destroy($id)
    {
        FatwaAnswer::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.fatwa_answers.index')->with($success);
    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        FatwaAnswer::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.fatwa_answers.index')->with($success);

    }

    public function remove_audio(Request $request)
    {

        $answer = FatwaAnswer::findOrFail($request->id);

         if(File::exists('Files/fatwa/'.$answer->fatwa->name.'/'.$answer->audio_file))
         {
              unlink('Files/fatwa/'.$answer->fatwa->name.'/'.$answer->audio_file);
         }
         if (!$answer)
         return redirect()->back()->with(['error' => 'audio not exist']);

         $answer->update(['audio_file'=>null]);

         return response()->json([
         'status' => true,
         'msg' => 'تم الحذف بنجاح',
         'id' =>  $request->id
         ]);

    }
}