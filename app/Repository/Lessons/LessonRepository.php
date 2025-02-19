<?php


namespace App\Repository\Lessons;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\LessonCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendLessons;


class LessonRepository implements LessonRepositoryInterface
{
    public function getAllLessons()
    {
        return Lesson::with(['category'])->orderBy('id','desc')->get();
    }

    public function getLivewireLessons()
    {
        return Lesson::with(['category'])->get();
    }
    
    public function allLessonCategories()
    {
        return LessonCategory::tree();
    }

    public function storeLessons($request,Lesson $lesson)
    {
         DB::beginTransaction();

        try {
           $last =$lesson->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['lesson_category_id']  = $request->lesson_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $lesson = Lesson::create($data);




          //create pdf files of lesson

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Lessons/'.$lesson->name, $pdf_name , 'upload_attachments');

                    $lesson->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //create lesson audio

            $audio = new Audio();

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$lesson->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            $lesson->audioes()->create([
                'name'         =>$lesson->name,
                'publish_date'=>$lesson->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $lesson->keywords,
                'description' => $lesson->description,

            ]);


            //create lesson image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Lessons/'.$lesson->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $lesson->image()->create([
                'file_name'=>$photo->file_name,
            ]);

            //create lesson video

            $video = new Video();

            if($video_file = $request->file('video_file'))
            {

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$lesson->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            $lesson->videos()->create([
                'name'=>$lesson->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();

         $subscribers=Subscriber::chunk(10,function($data) use($lesson){
                    dispatch(new SendLessons($data,$lesson));

                });

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lessons.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editLessons($id)
    {
        return Lesson::findOrFail($id);
    }


    public function updateLessons($request)
    {
        DB::beginTransaction();

        try {
            $lesson = Lesson::findorfail($request->id);

           $data['name']                = $request->name;
           $data['lesson_category_id']  = $request->lesson_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $lesson->update($data);


          //update pdf files of lesson
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Lessons/'.$lesson->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Lessons/'.$lesson->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Lessons/'.$lesson->name, $pdf_name , 'upload_attachments');

                    $lesson->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //update lesson audio
            foreach ($lesson->audioes as $audio) {

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$lesson->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$lesson->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$lesson->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            }

            $lesson->audioes()->update([
                'name'         =>$lesson->name,
                'publish_date'=>$lesson->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $lesson->keywords,
                'description' => $lesson->description,
            ]);


             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($lesson->image->file_name)){

                    if(File::exists('Files/image/Lessons/'.$lesson->name.'/' . $lesson->image->file_name))
                    {
                    unlink('Files/image/Lessons/'.$lesson->name.'/' . $lesson->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Lessons/'.$lesson->name, $img , 'upload_attachments');

                    $lesson->image->file_name = $img;


                    $lesson->image()->update([
                        'file_name'=>$lesson->image->file_name,
                    ]);

                }



            //update lesson video
            foreach ($lesson->videos as $video) {

                if($video_file = $request->file('video_file'))
                {
                    if(File::exists('Files/videos/'.$lesson->name.'/' . $video_file))
                        {
                        unlink('Files/videos/'.$lesson->name.'/' . $video_file);
                        }

                        $video_name = $video_file->getClientOriginalName();
                        $video_file->storeAs('videos/'.$lesson->name, $video_name , 'upload_attachments');
                        $video->video_file = $video_name;

                    }
                }
            $lesson->videos()->update([
                'name'=>$lesson->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lessons.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteLessons($request)
    {
      $lesson = Lesson::findOrFail($request->id);
       $lesson->comments()->delete();

      if($lesson->attachments()->count() > 0)
      {
          foreach($lesson->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Lessons/'.$lesson->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Lessons/'.$lesson->name);
              }
              $file->delete();
          }
      }


      if($lesson->audioes())
      {
       foreach($lesson->audioes as $audio)
          {
              if(File::exists('Files/audioes/'.$lesson->name.'/'.$audio->audio_file))
              {
                File::deleteDirectory('Files/audioes/'.$lesson->name);
              }
              $audio->delete();
          }
        }
        $lesson->audioes()->delete();

        if($lesson->videos())
        {
         foreach($lesson->videos as $video)
            {
                if(File::exists('Files/videos/'.$lesson->name.'/'.$video->video_file))
                {
                  File::deleteDirectory('Files/videos/'.$lesson->name);
                }
                $video->delete();
            }
          }
          $lesson->videos()->delete();


      if(!empty($lesson->image->file_name))
      {

        if(File::exists('Files/image/Lessons/'.$lesson->name.'/'.$lesson->image->file_name))
              {
                File::deleteDirectory('Files/image/Lessons/'.$lesson->name);
              }

      }

      $lesson->image()->delete();

      $lesson->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.lessons.index')->with($success);

    }

    public function getCommentLesson($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Lesson' ,function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showLessons($id)
    {
       return Lesson::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $lesson = Lesson::findOrFail($request->lesson_id);
     if(File::exists('Files/Pdf-Files/Lessons/'.$lesson->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Lessons/'.$lesson->name.'/'.$pdf->file_name);
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
       $lesson = Lesson::findOrFail($request->lesson_id);

        if(File::exists('Files/audioes/'.$lesson->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$lesson->name.'/'.$audio->audio_file);
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
       $lesson = Lesson::findOrFail($request->lesson_id);

        if(File::exists('Files/videos/'.$lesson->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$lesson->name.'/'.$video->video_file);
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
        $lesson = Lesson::findOrFail($request->lesson_id);

        if(File::exists('Files/image/Lessons/'.$lesson->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Lessons/'.$lesson->name.'/'.$image->file_name);
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

        Lesson::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.lessons.index')->with($success);

    }

}