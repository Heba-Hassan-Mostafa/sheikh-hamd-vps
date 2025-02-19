<?php


namespace App\Repository\Speeches;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Speech;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\SpeechCategory;
use App\Models\Video;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendSpeeches;

class SpeechRepository implements SpeechRepositoryInterface
{
    public function getAllSpeeches()
    {
        return Speech::with(['category'])->orderBy('id','desc')->get();
    }
    
     public function getLivewireSpeeches()
    {
        return Speech::with(['category'])->get();
    }


    public function allSpeechCategories()
    {
        return SpeechCategory::tree();
    }

    public function storeSpeeches($request,$speech)
    {
         DB::beginTransaction();

        try {
            $last =$speech->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['speech_category_id']  = $request->speech_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $speech = Speech::create($data);


          //create pdf files of speech

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Speeches/'.$speech->name, $pdf_name , 'upload_attachments');

                    $speech->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //create lesson audio

            $audio = new Audio();

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$speech->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            $speech->audioes()->create([
                'name'         =>$speech->name,
                'publish_date'=>$speech->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $speech->keywords,
                'description' => $speech->description,
            ]);


            //create speech image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Speeches/'.$speech->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $speech->image()->create([
                'file_name'=>$photo->file_name,
            ]);

            //create speech video
            $video = new Video();

            if($video_file = $request->file('video_file'))
            {

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$speech->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            $speech->videos()->create([
                'name'=>$speech->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();

        $subscribers=Subscriber::chunk(10,function($data) use($speech){
                    dispatch(new SendSpeeches($data,$speech));

                });

       

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.speeches.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editSpeeches($id)
    {
        return Speech::findOrFail($id);
    }


    public function updateSpeeches($request)
    {
        DB::beginTransaction();

        try {
            $speech = Speech::findorfail($request->id);

           $data['name']                = $request->name;
           $data['speech_category_id']  = $request->speech_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $speech->update($data);


          //update pdf files of speech
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Speeches/'.$speech->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Speeches/'.$speech->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Speeches/'.$speech->name, $pdf_name , 'upload_attachments');

                    $speech->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //update lesson audio
            foreach ($speech->audioes as $audio) {

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$speech->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$speech->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$speech->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            }

            $speech->audioes()->update([
                'name'         =>$speech->name,
                'publish_date'=>$speech->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $speech->keywords,
                'description' => $speech->description,
            ]);


             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($speech->image->file_name)){

                    if(File::exists('Files/image/Speeches/'.$speech->name.'/' . $speech->image->file_name))
                    {
                    unlink('Files/image/Speeches/'.$speech->name.'/' . $speech->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Speeches/'.$speech->name, $img , 'upload_attachments');

                    $speech->image->file_name = $img;


                    $speech->image()->update([
                        'file_name'=>$speech->image->file_name,
                    ]);

                }



            //update lesson video
            foreach ($speech->videos as $video) {

            if($video_file = $request->file('video_file'))
            {
                if(File::exists('Files/videos/'.$speech->name.'/' . $video_file))
                    {
                    unlink('Files/videos/'.$speech->name.'/' . $video_file);
                    }

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$speech->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            }
            $speech->videos()->update([
                'name'=>$speech->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.speeches.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteSpeeches($request)
    {
      $speech = Speech::findOrFail($request->id);
      $speech->videos()->delete();
       $speech->comments()->delete();

      if($speech->attachments()->count() > 0)
      {
          foreach($speech->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Speeches/'.$speech->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Speeches/'.$speech->name);
              }
              $file->delete();
          }
      }


      if($speech->audioes())
      {
       foreach($speech->audioes as $audio)
          {
              if(File::exists('Files/audioes/'.$speech->name.'/'.$audio->audio_file))
              {
                File::deleteDirectory('Files/audioes/'.$speech->name);
              }
              $audio->delete();
          }
        }
        $speech->audioes()->delete();

        if($speech->videos())
        {
         foreach($speech->videos as $video)
            {
                if(File::exists('Files/videos/'.$speech->name.'/'.$video->video_file))
                {
                  File::deleteDirectory('Files/videos/'.$speech->name);
                }
                $video->delete();
            }
          }
          $speech->videos()->delete();


      if(!empty($speech->image->file_name))
      {

        if(File::exists('Files/image/Speeches/'.$speech->name.'/'.$speech->image->file_name))
              {
                File::deleteDirectory('Files/image/Speeches/'.$speech->name);
              }

      }

      $speech->image()->delete();

      $speech->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.speeches.index')->with($success);

    }

    public function getCommentSpeech($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Speech',function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showSpeeches($id)
    {
       return Speech::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $speech = Speech::findOrFail($request->speech_id);
     if(File::exists('Files/Pdf-Files/Speeches/'.$speech->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Speeches/'.$speech->name.'/'.$pdf->file_name);
        }
     if (!$pdf)
        return redirect()->back()->with(['error' => 'pdf not exist']);

     $pdf->delete();

     return response()->json([
        'status' => true,
        'message'=> trans('btns.deleted-successfully'),
        'id' =>  $request->id

        ]);
    }

    public function remove_audio($request)
    {

        $audio = Audio::findOrFail($request->id);
       $speech = Speech::findOrFail($request->speech_id);

        if(File::exists('Files/audioes/'.$speech->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$speech->name.'/'.$audio->audio_file);
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

    public function remove_video($request)
    {

        $video = Video::findOrFail($request->id);
       $speech = Speech::findOrFail($request->speech_id);

        if(File::exists('Files/videos/'.$speech->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$speech->name.'/'.$video->video_file);
        }
        if (!$video)
        return redirect()->back()->with(['error' => 'video not exist']);

        $video->update(['video_file'=>null]);

        return response()->json([
        'status' => true,
        'msg' => trans('btns.deleted-successfully'),
        'id' =>  $request->id
        ]);
    }

    public function remove_img($request)
    {
        $image = Image::findOrFail($request->id);
        $speech = Speech::findOrFail($request->speech_id);

        if(File::exists('Files/image/Speeches/'.$speech->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Speeches/'.$speech->name.'/'.$image->file_name);
            }
        if (!$image)
            return redirect()->back()->with(['error' => 'image not exist']);

        $image->update(['file_name'=>null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);



    }


    public function delete_all($request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Speech::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.speeches.index')->with($success);

    }

}