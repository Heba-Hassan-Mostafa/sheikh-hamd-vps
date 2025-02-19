<?php


namespace App\Repository\Benefits;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use App\Models\Benefit;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\BenefitCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendBenefits;


class BenefitRepository implements BenefitRepositoryInterface
{
    public function getAllBenefits()
    {
        return Benefit::with(['category'])->orderBy('id','desc')->get();
    }
    
    public function getLivewireBenefits()
    {
        return Benefit::with(['category'])->get();
    }

    public function allBenefitCategories()
    {
        return BenefitCategory::tree();
    }

    public function storeBenefits($request,$benefit)
    {
         DB::beginTransaction();

        try {
        $last =$benefit->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['benefit_category_id']  = $request->benefit_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $benefit = Benefit::create($data);


          //create pdf files of Benefit

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Benefits/'.$benefit->name, $pdf_name , 'upload_attachments');

                    $benefit->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //create lesson audio

            $audio = new Audio();

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$benefit->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            $benefit->audioes()->create([
                'name'         =>$benefit->name,
                'publish_date'=>$benefit->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $benefit->keywords,
                'description' => $benefit->description,
            ]);


            //create Benefit image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Benefits/'.$benefit->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $benefit->image()->create([
                'file_name'=>$photo->file_name,
            ]);

            //create Benefit video

            $video = new Video();

            if($video_file = $request->file('video_file'))
            {

            $video_name = $video_file->getClientOriginalName();
            $video_file->storeAs('videos/'.$benefit->name, $video_name , 'upload_attachments');
            $video->video_file = $video_name;

                }
            $benefit->videos()->create([
                'name'          =>$benefit->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();

       $subscribers=Subscriber::chunk(10,function($data) use($benefit){
                    dispatch(new SendBenefits($data,$benefit));

                });

        

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.benefits.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editBenefits($id)
    {
        return Benefit::findOrFail($id);
    }


    public function updateBenefits($request)
    {
        DB::beginTransaction();

        try {
            $benefit = Benefit::findorfail($request->id);

           $data['name']                = $request->name;
           $data['benefit_category_id']  = $request->benefit_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $benefit->update($data);


          //update pdf files of Benefit
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Benefits/'.$benefit->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Benefits/'.$benefit->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Benefits/'.$benefit->name, $pdf_name , 'upload_attachments');

                    $benefit->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //update lesson audio
            foreach ($benefit->audioes as $audio) {

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$benefit->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$benefit->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$benefit->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            }

            $benefit->audioes()->update([
                'name'         =>$benefit->name,
                'publish_date'=>$benefit->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $benefit->keywords,
                'description' => $benefit->description,
            ]);


             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($benefit->image->file_name)){

                    if(File::exists('Files/image/Benefits/'.$benefit->name.'/' . $benefit->image->file_name))
                    {
                    unlink('Files/image/Benefits/'.$benefit->name.'/' . $benefit->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Benefits/'.$benefit->name, $img , 'upload_attachments');

                    $benefit->image->file_name = $img;


                    $benefit->image()->update([
                        'file_name'=>$benefit->image->file_name,
                    ]);

                }



            //update lesson video
        foreach ($benefit->videos as $video) {

            if($video_file = $request->file('video_file'))
            {
                if(File::exists('Files/videos/'.$benefit->name.'/' . $video_file))
                    {
                    unlink('Files/videos/'.$benefit->name.'/' . $video_file);
                    }

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$benefit->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            }

            $benefit->videos()->update([
                'name'=>$benefit->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.benefits.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteBenefits($request)
    {
      $benefit = Benefit::findOrFail($request->id);
       $benefit->comments()->delete();

      if($benefit->attachments()->count() > 0)
      {
          foreach($benefit->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Benefits/'.$benefit->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Benefits/'.$benefit->name);
              }
              $file->delete();
          }
      }


      if($benefit->audioes())
      {
       foreach($benefit->audioes as $audio)
          {
              if(File::exists('Files/audioes/'.$benefit->name.'/'.$audio->audio_file))
              {
                File::deleteDirectory('Files/audioes/'.$benefit->name);
              }
              $audio->delete();
          }
        }
        $benefit->audioes()->delete();

    if($benefit->videos())
      {
       foreach($benefit->videos as $video)
          {
              if(File::exists('Files/videos/'.$benefit->name.'/'.$video->video_file))
              {
                File::deleteDirectory('Files/videos/'.$benefit->name);
              }
              $video->delete();
          }
        }
        $benefit->videos()->delete();


      if(!empty($benefit->image->file_name))
      {

        if(File::exists('Files/image/Benefits/'.$benefit->name.'/'.$benefit->image->file_name))
              {
                File::deleteDirectory('Files/image/Benefits/'.$benefit->name);
              }

      }

      $benefit->image()->delete();

      $benefit->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.benefits.index')->with($success);

    }

    public function getCommentBenefit($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Benefit',function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showBenefits($id)
    {
       return Benefit::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $benefit = Benefit::findOrFail($request->Benefit_id);
     if(File::exists('Files/Pdf-Files/Benefits/'.$benefit->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Benefits/'.$benefit->name.'/'.$pdf->file_name);
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
       $benefit = Benefit::findOrFail($request->Benefit_id);

        if(File::exists('Files/audioes/'.$benefit->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$benefit->name.'/'.$audio->audio_file);
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
       $benefit = Benefit::findOrFail($request->Benefit_id);

        if(File::exists('Files/videos/'.$benefit->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$benefit->name.'/'.$video->video_file);
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
        $benefit = Benefit::findOrFail($request->benefit_id);

        if(File::exists('Files/image/Benefits/'.$benefit->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Benefits/'.$benefit->name.'/'.$image->file_name);
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

        Benefit::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.benefits.index')->with($success);

    }

}
