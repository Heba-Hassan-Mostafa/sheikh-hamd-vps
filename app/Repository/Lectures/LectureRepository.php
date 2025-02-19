<?php


namespace App\Repository\Lectures;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use App\Models\Comment;
use App\Models\Lecture;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\LectureCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendLectures;


class LectureRepository implements LectureRepositoryInterface
{
    public function getAllLectures()
    {
        return Lecture::with(['category'])->orderBy('id','desc')->get();
    }
    
     public function getLivewireLectures()
    {
        return Lecture::with(['category'])->get();
    }

    public function allLectureCategories()
    {
        return LectureCategory::tree();
    }

    public function storeLectures($request,$lecture)
    {
         DB::beginTransaction();

        try {
            $last =$lecture->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['lecture_category_id']  = $request->lecture_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $lecture = Lecture::create($data);


          //create pdf files of Lecture

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Lectures/'.$lecture->name, $pdf_name , 'upload_attachments');

                    $lecture->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //create lesson audio

            $audio = new Audio();

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$lecture->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            $lecture->audioes()->create([
                'name'         =>$lecture->name,
                'publish_date'=>$lecture->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $lecture->keywords,
                'description' => $lecture->description,
            ]);


            //create lecture image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Lectures/'.$lecture->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $lecture->image()->create([
                'file_name'=>$photo->file_name,
            ]);

            //create lecture video
             $video = new Video();
            if($video_file = $request->file('video_file'))
            {

            $video_name = $video_file->getClientOriginalName();
            $video_file->storeAs('videos/'.$lecture->name, $video_name , 'upload_attachments');
            $video->video_file = $video_name;

            }
            $lecture->videos()->create([
                'name'=>$lecture->name,
                'youtube_link' => $request->youtube_link,
               'video_file'  => $video->video_file,
            ]);

             DB::commit();

          $subscribers=Subscriber::chunk(10,function($data) use($lecture){
                    dispatch(new SendLectures($data,$lecture));

                });

        

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lectures.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editLectures($id)
    {
        return Lecture::findOrFail($id);
    }


    public function updateLectures($request)
    {
        DB::beginTransaction();

        try {
            $lecture = Lecture::findorfail($request->id);

           $data['name']                = $request->name;
           $data['lecture_category_id']  = $request->lecture_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $lecture->update($data);


          //update pdf files of Lecture
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Lectures/'.$lecture->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Lectures/'.$lecture->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Lectures/'.$lecture->name, $pdf_name , 'upload_attachments');

                    $lecture->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //update lesson audio
            foreach ($lecture->audioes as $audio) {

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$lecture->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$lecture->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$lecture->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            }

            $lecture->audioes()->update([
                'name'         =>$lecture->name,
                'publish_date'=>$lecture->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $lecture->keywords,
                'description' => $lecture->description,
            ]);


             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($lecture->image->file_name)){

                    if(File::exists('Files/image/Lectures/'.$lecture->name.'/' . $lecture->image->file_name))
                    {
                    unlink('Files/image/Lectures/'.$lecture->name.'/' . $lecture->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Lectures/'.$lecture->name, $img , 'upload_attachments');

                    $lecture->image->file_name = $img;


                    $lecture->image()->update([
                        'file_name'=>$lecture->image->file_name,
                    ]);

                }



            //update lesson video
        foreach ($lecture->videos as $video) {

            if($video_file = $request->file('video_file'))
            {
                if(File::exists('Files/videos/'.$lecture->name.'/' . $video_file))
                    {
                    unlink('Files/videos/'.$lecture->name.'/' . $video_file);
                    }

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$lecture->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            }


            $lecture->videos()->update([
                'name'=>$lecture->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lectures.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteLectures($request)
    {
      $lecture = Lecture::findOrFail($request->id);
      $lecture->videos()->delete();
       $lecture->comments()->delete();

      if($lecture->attachments()->count() > 0)
      {
          foreach($lecture->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Lectures/'.$lecture->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Lectures/'.$lecture->name);
              }
              $file->delete();
          }
      }


      if($lecture->audioes())
      {
       foreach($lecture->audioes as $audio)
          {
              if(File::exists('Files/audioes/'.$lecture->name.'/'.$audio->audio_file))
              {
                File::deleteDirectory('Files/audioes/'.$lecture->name);
              }
              $audio->delete();
          }
        }
        $lecture->audioes()->delete();

        if($lecture->audioes())
      {
       foreach($lecture->videos as $video)
          {
              if(File::exists('Files/videos/'.$lecture->name.'/'.$video->video_file))
              {
                File::deleteDirectory('Files/videos/'.$lecture->name);
              }
              $video->delete();
          }
        }
        $lecture->videos()->delete();


      if(!empty($lecture->image->file_name))
      {

        if(File::exists('Files/image/Lectures/'.$lecture->name.'/'.$lecture->image->file_name))
              {
                File::deleteDirectory('Files/image/Lectures/'.$lecture->name);
              }

      }

      $lecture->image()->delete();

      $lecture->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.lectures.index')->with($success);

    }

    public function getCommentLecture($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Lecture',function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showLectures($id)
    {
       return Lecture::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $lecture = Lecture::findOrFail($request->lecture_id);
     if(File::exists('Files/Pdf-Files/Lectures/'.$lecture->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Lectures/'.$lecture->name.'/'.$pdf->file_name);
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
       $lecture = Lecture::findOrFail($request->lecture_id);

        if(File::exists('Files/audioes/'.$lecture->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$lecture->name.'/'.$audio->audio_file);
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
       $lecture = Lecture::findOrFail($request->lecture_id);

        if(File::exists('Files/videos/'.$lecture->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$lecture->name.'/'.$video->video_file);
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
        $lecture = Lecture::findOrFail($request->lecture_id);

        if(File::exists('Files/image/Lectures/'.$lecture->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Lectures/'.$lecture->name.'/'.$image->file_name);
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

        Lecture::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.lectures.index')->with($success);

    }

}
