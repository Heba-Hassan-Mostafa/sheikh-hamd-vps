<?php


namespace App\Repository\Video;

use App\Models\Video;
use App\Models\Subscriber;
use App\Models\VideoCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendVideo;

use App\Repository\Video\VideoRepositoryInterface;

class VideoRepository implements VideoRepositoryInterface
{
    public function getAllVideos()
    {
        return Video::with(['category'])->get();
    }

    public function allVideoCategories()
    {
        return VideoCategory::whereStatus(true)->get();
    }

    public function storeVideos($request,$video)
    {
         DB::beginTransaction();

        try {
            $last =$video->max('order_position') + 1;
           $data['name']                = $request->name;
           $data['video_category_id']   = $request->video_category_id;
           $data['status']              = $request->status;
           $data['youtube_link']          = $request->youtube_link;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['videoable_type']      = 'App\Models\Video';
           $data['videoable_id']        = null;
           $data['order_position']       = $last;


          $video = Video::create($data);

            if($video_file = $request->file('video_file'))
            {

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$video->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

            }
            $video->save();



             DB::commit();

      $subscribers=Subscriber::chunk(10,function($data) use($video){
                    dispatch(new SendVideo($data,$video));

                });

       

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.library-video.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editVideos($id)
    {
        return Video::findOrFail($id);
    }


    public function updateVideos($request)
    {
        DB::beginTransaction();

        try {
            $video = Video::findorfail($request->id);

           $data['name']                = $request->name;
           $data['video_category_id']   = $request->video_category_id;
           $data['status']              = $request->status;
           $data['youtube_link']          = $request->youtube_link;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['videoable_type']      = 'App\Models\Video';
           $data['videoable_id']        = null;

          $video->update($data);

            if($video_file = $request->file('video_file'))
            {
                if(File::exists('Files/videos/'.$video->name.'/' . $video_file))
                    {
                    unlink('Files/videos/'.$video->name.'/' . $video_file);
                    }

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$video->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

            }
            $video->save();

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.library-video.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteVideos($request)
    {
      $video = Video::findOrFail($request->id);


    if(File::exists('Files/videos/'.$video->name.'/'.$video->video_file))
    {
        File::deleteDirectory('Files/videos/'.$video->name);
    }

    $video->delete();


        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.library-video.index')->with($success);

    }


    public function remove_video($request)
    {

        $video = Video::findOrFail($request->id);

        if(File::exists('Files/videos/'.$video->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$video->name.'/'.$video->video_file);
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



}