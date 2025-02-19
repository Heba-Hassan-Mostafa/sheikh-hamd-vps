<?php

namespace App\Http\Controllers\Frontend;


use App\Models\Audio;
use App\Models\Video;
use App\Models\Lesson;
use App\Models\Speech;
use App\Models\Article;
use App\Models\Lecture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AudioCategory;
use App\Models\VideoCategory;
use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Database\Eloquent\Builder;

class LibraryController extends Controller
{

     public function main()
     {
        return view('frontend.library.main');
     }

     public function video()
     {

        $videos = Video::whereHasMorph(
            'videoable','*',
            function (Builder $query) {
                $query->where('youtube_link', 'like' ,'https%')
                 ->orWhere('youtube_link', '!=' ,'')
               ->Active()->ActiveCategory();

            })->orderBy('order_position','desc')->paginate(12);



            return view('frontend.library.video',compact('videos'));
     }


     public function lesson_video()
     {

        $videos = Video::whereHasMorph(
            'videoable',[Lesson::class],
            function (Builder $query) {
                $query->where('youtube_link', 'like' ,'https%')
                 ->orWhere('youtube_link', '!=' ,' ')
                ->Active()->ActiveCategory();

            })->orderBy('order_position','desc')->paginate(12);



            return view('frontend.library.video',compact('videos'));
     }

    public function lecture_video()
    {

       $videos = Video::whereHasMorph(
           'videoable',[Lecture::class],
           function (Builder $query) {
               $query->where('youtube_link', 'like' ,'https%')
                ->orWhere('youtube_link', '!=' ,' ')
               ->Active()->ActiveCategory();

           })->orderBy('order_position','desc')->paginate(12);



           return view('frontend.library.video',compact('videos'));
    }

   public function article_video()
   {

      $videos = Video::whereHasMorph(
          'videoable',[Article::class],
          function (Builder $query) {
              $query->where('youtube_link', 'like' ,'https%')
               ->orWhere('youtube_link', '!=' ,' ')
              ->Active()->ActiveCategory();

          })->orderBy('order_position','desc')->paginate(12);



          return view('frontend.library.video',compact('videos'));
   }


  public function speech_video()
  {

     $videos = Video::whereHasMorph(
         'videoable',[Speech::class],
         function (Builder $query) {
             $query->where('youtube_link', 'like' ,'https%')
              ->orWhere('youtube_link', '!=' ,' ')
             ->Active()->ActiveCategory();

         })->orderBy('order_position','desc')->paginate(12);



         return view('frontend.library.video',compact('videos'));
  }

  public function benefit_video()
  {

     $videos = Video::whereHasMorph(
         'videoable',[Benefit::class],
         function (Builder $query) {
             $query->where('youtube_link', 'like' ,'https%')
              ->orWhere('youtube_link', '!=' ,' ')
             ->Active()->ActiveCategory();

         })->orderBy('order_position','desc')->paginate(12);



         return view('frontend.library.video',compact('videos'));
  }
  
  
   public function another_video()
  {

     $videos = Video::with(['category'])->where('videoable_type','App\Models\Video')->paginate(12);

      return view('frontend.library.another-videos',compact('videos'));

  }

  public function getVideoCategory($slug)
   {

       $category = VideoCategory::whereSlug($slug)->orWhere('id', $slug)->Active()->first();

       if ($category) {
           $videos = Video::with('category')
               ->whereVideoCategoryId($category->id)
               ->Active()
               ->Publish()
               ->orderBy('order_position', 'desc')
               ->paginate(9);
       }


       return view('frontend.library.another-videos',compact('videos'));

   }


   public function video_content(Request $request,$slug)
   {
       $video= Video::whereSlug($slug)->Active()->Publish()->orderBy('id','desc')->first();
        $video->increment('view_count') ;
//dd($video);

      if($request->ajax())
    {
      $video->increment('download_count') ;
      $video->save();

    }
      

       return view('frontend.library.video_content',compact('video'));
   }




   public function audio()
   {

    $audioes = Audio::whereHasMorph(
        'audioable','*',
        function (Builder $query) {
            $query->where('embed_link', '!=' ,'')
            ->orWhere('audio_file', '!=' , '')
            ->Active()->ActiveCategory()->Publish();

        })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



        return view('frontend.library.audio',compact('audioes'));
   }

   public function getAudioCategory($slug)
   {

       $category = AudioCategory::whereSlug($slug)->orWhere('id', $slug)->Active()->first();

      // if ($category) {
           $audioes = Audio::with('category')
               ->whereAudioCategoryId($category->id)
               ->Active()
               ->Publish()
               ->orderBy('order_position', 'desc')
               ->paginate(9);
       //}


       return view('frontend.library.audio',compact('audioes'));

   }

   public function lesson_audio()
   {
    $audioes = Audio::whereHasMorph(
        'audioable',
        [Lesson::class],
        function (Builder $query) {
            $query->where('embed_link', '!=' ,'')
            ->orWhere('audio_file', '!=' , '')
            ->Active()->ActiveCategory()->Publish();

        })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



        return view('frontend.library.audio',compact('audioes'));
   }


    public function lecture_audio()
    {

        $audioes = Audio::whereHasMorph(
            'audioable',
            [Lecture::class],
            function (Builder $query) {
                $query->where('embed_link', '!=' ,'')
                ->orWhere('audio_file', '!=' , '')
                ->Active()->ActiveCategory()->Publish();

            })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



            return view('frontend.library.audio',compact('audioes'));
    }

    public function article_audio()
    {

        $audioes = Audio::whereHasMorph(
            'audioable',
            [Article::class],
            function (Builder $query) {
                $query->where('embed_link', '!=' ,'')
                ->orWhere('audio_file', '!=' , '')
                ->Active()->ActiveCategory()->Publish();

            })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



            return view('frontend.library.audio',compact('audioes'));
    }

    public function speech_audio()
    {

     $audioes = Audio::whereHasMorph(
         'audioable',
         [Speech::class],
         function (Builder $query) {
             $query->where('embed_link', '!=' ,'')
             ->orWhere('audio_file', '!=' , '')
             ->Active()->ActiveCategory()->Publish();

         })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



         return view('frontend.library.audio',compact('audioes'));
    }

    public function benefit_audio()
    {

     $audioes = Audio::whereHasMorph(
         'audioable',
         [Benefit::class],
         function (Builder $query) {
             $query->where('embed_link', '!=' ,'')
             ->orWhere('audio_file', '!=' , '')
             ->Active()->ActiveCategory()->Publish();

         })->Active()->Publish()->orderBy('order_position','desc')->paginate(12);



         return view('frontend.library.audio',compact('audioes'));
    }

    public function library_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $audioes = Audio::where('name','LIKE','%'.$request->search.'%')
            ->whereHasMorph(
                'audioable','*',
                function (Builder $query) {
                    $query->where('embed_link', '!=' ,'')
                    ->orWhere('audio_file', '!=' , '')
                    ->Active()->ActiveCategory()->Publish();

                })->Active()->get();

            if($audioes)
            {
                foreach($audioes as $audio)
                {
                    $output .='
                    <div class="col-sm-6 col-md-4">
                    <div class="card h-100">
                      <img src="'. asset("frontend/img/hqdefault.png") .'" class="card-img-top" alt="..." />
                      <div class="card-body">
                        <div class="d-inline-flex">
                          <i class="fas fa-pen-square title-icon"></i>
                          <h6 class="card-title">'. Str::limit($audio->name, 25) .'</h6>
                        </div>
                        <div class="date-details">
                          <i class="fas fa-calendar-alt date-icon"></i>
                          <span>'. $audio->publish_date->format("Y-m-d") .'</span>
                        </div>
                        <div class="text-center mt-4">
                          <a href="'.route('frontend.library.audio.content',$audio->slug).'" class="btn-card-more">'. trans("frontend.listen") .'</a>
                        </div>
                      </div>
                    </div>
                  </div>';



                }
                return response()->json($output);

            }

        }



    }

    public function audio_content(Request $request,$slug)
    {
        $audio = Audio::whereHasMorph(
        'audioable','*',
        function (Builder $query) {
            $query->where('embed_link', '!=' ,'')
            ->orWhere('audio_file', '!=' , '')
            ->Active()->ActiveCategory()->Publish();

        })->Active()->Publish()->orderBy('order_position','desc')->first();

       // $audio= Audio::whereSlug($slug)->Active()->Publish()->orderBy('id','desc')->first();
        
        //dd($audio);
        $audio->increment('view_count') ;

        if($request->ajax())
     {
        $audio->increment('download_count') ;
        $audio->save();

     }
      

        return view('frontend.library.audio_content',compact('audio'));
    }


    public function another_audio()
    {

       $audioes = Audio::with(['category'])->where('audioable_type','App\Models\Audio')->paginate(12);

        return view('frontend.library.audio',compact('audioes'));

    }

}
