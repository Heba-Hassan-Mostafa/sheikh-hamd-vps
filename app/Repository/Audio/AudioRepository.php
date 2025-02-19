<?php


namespace App\Repository\Audio;

use App\Models\Audio;
use App\Models\Subscriber;
use App\Models\AudioCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Repository\Audio\AudioRepositoryInterface;
use App\Jobs\SendAudio;

class AudioRepository implements AudioRepositoryInterface
{
    public function getAllAudioes()
    {
        return Audio::with(['category'])->get();
    }

    public function allAudioCategories()
    {
        return AudioCategory::whereStatus(true)->get();
    }

    public function storeAudioes($request,$audio)
    {
         DB::beginTransaction();

        try {
            $last =$audio->max('order_position') + 1;
           $data['name']                = $request->name;
           $data['audio_category_id']   = $request->audio_category_id;
           $data['status']              = $request->status;
           $data['embed_link']          = $request->embed_link;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['audioable_type']      = 'App\Models\Audio';
           $data['audioable_id']        = null;
           $data['order_position']         = $last;


          $audio = Audio::create($data);

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$audio->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

            }
            $audio->save();



             DB::commit();

        $subscribers=Subscriber::chunk(10,function($data) use($audio){
                    dispatch(new SendAudio($data,$audio));

                });


             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.library-audio.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editAudioes($id)
    {
        return Audio::findOrFail($id);
    }


    public function updateAudioes($request)
    {
        DB::beginTransaction();

        try {
            $audio = Audio::findorfail($request->id);

           $data['name']                = $request->name;
           $data['audio_category_id']   = $request->audio_category_id;
           $data['status']              = $request->status;
           $data['embed_link']          = $request->embed_link;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['audioable_type']      = 'App\Models\Audio';
           $data['audioable_id']        = null;

          $audio->update($data);

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$audio->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$audio->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$audio->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

            }
            $audio->save();

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.library-audio.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteAudioes($request)
    {
      $audio = Audio::findOrFail($request->id);


    if(File::exists('Files/audioes/'.$audio->name.'/'.$audio->audio_file))
    {
        File::deleteDirectory('Files/audioes/'.$audio->name);
    }

    $audio->delete();


        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.library-audio.index')->with($success);

    }


    public function remove_audio($request)
    {

        $audio = Audio::findOrFail($request->id);

        if(File::exists('Files/audioes/'.$audio->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$audio->name.'/'.$audio->audio_file);
        }
        if (!$audio)
        return redirect()->back()->with(['error' => 'audio not exist']);

        $audio->update(['audio_file'=>null]);

        return response()->json([
        'status' => true,
        'msg' => trans('btns.deleted-successfully'),
        'id' =>  $request->id
        ]);
    }



}