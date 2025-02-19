<?php


namespace App\Repository\Articles;

use App\Models\Audio;
use App\Models\Image;
use App\Models\Video;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\ArticleCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendArticles;


class ArticleRepository implements ArticleRepositoryInterface
{
    public function getAllArticles()
    {
        return Article::with(['category'])->orderBy('id','desc')->get();
    }
    
    public function getLivewireArticles()
    {
        return Article::with(['category'])->get();
    }

    public function allArticleCategories()
    {
        return ArticleCategory::tree();
    }

    public function storeArticles($request,$article)
    {
         DB::beginTransaction();

        try {
        $last =$article->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['article_category_id']  = $request->article_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $article = Article::create($data);


          //create pdf files of article

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Articles/'.$article->name, $pdf_name , 'upload_attachments');

                    $article->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //create lesson audio

            $audio = new Audio();

            if($audio_file = $request->file('audio_file'))
            {

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$article->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            $article->audioes()->create([
                'name'         =>$article->name,
                'publish_date'=>$article->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $article->keywords,
                'description' => $article->description,
            ]);


            //create article image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Articles/'.$article->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $article->image()->create([
                'file_name'=>$photo->file_name,
            ]);

            //create article video

            $video = new Video();

            if($video_file = $request->file('video_file'))
            {

            $video_name = $video_file->getClientOriginalName();
            $video_file->storeAs('videos/'.$article->name, $video_name , 'upload_attachments');
            $video->video_file = $video_name;

                }
            $article->videos()->create([
                'name'=>$article->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();

         $subscribers=Subscriber::chunk(10,function($data) use($article){
                    dispatch(new SendArticles($data,$article));

                });
    

       

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.articles.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editArticles($id)
    {
        return Article::findOrFail($id);
    }


    public function updateArticles($request)
    {
        DB::beginTransaction();

        try {
            $article = Article::findorfail($request->id);

           $data['name']                = $request->name;
           $data['article_category_id']  = $request->article_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $article->update($data);


          //update pdf files of article
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Articles/'.$article->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Articles/'.$article->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Articles/'.$article->name, $pdf_name , 'upload_attachments');

                    $article->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }

            //update lesson audio
            foreach ($article->audioes as $audio) {

            if($audio_file = $request->file('audio_file'))
            {
                if(File::exists('Files/audioes/'.$article->name.'/' . $audio_file))
                    {
                    unlink('Files/audioes/'.$article->name.'/' . $audio_file);
                    }

                    $audio_name = $audio_file->getClientOriginalName();
                    $audio_file->storeAs('audioes/'.$article->name, $audio_name , 'upload_attachments');
                    $audio->audio_file = $audio_name;

                }
            }

            $article->audioes()->update([
                'name'         =>$article->name,
                'publish_date'=>$article->publish_date,
                'audio_file'  => $audio->audio_file,
                'embed_link' => $request->embed_link,
                'keywords'   => $article->keywords,
                'description' => $article->description,
            ]);


             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($article->image->file_name)){

                    if(File::exists('Files/image/Articles/'.$article->name.'/' . $article->image->file_name))
                    {
                    unlink('Files/image/Articles/'.$article->name.'/' . $article->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Articles/'.$article->name, $img , 'upload_attachments');

                    $article->image->file_name = $img;


                    $article->image()->update([
                        'file_name'=>$article->image->file_name,
                    ]);

                }



            //update lesson video
        foreach ($article->videos as $video) {

            if($video_file = $request->file('video_file'))
            {
                if(File::exists('Files/videos/'.$article->name.'/' . $video_file))
                    {
                    unlink('Files/videos/'.$article->name.'/' . $video_file);
                    }

                    $video_name = $video_file->getClientOriginalName();
                    $video_file->storeAs('videos/'.$article->name, $video_name , 'upload_attachments');
                    $video->video_file = $video_name;

                }
            }

            $article->videos()->update([
                'name'=>$article->name,
                'youtube_link' => $request->youtube_link,
                'video_file'  => $video->video_file,
            ]);

             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.articles.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteArticles($request)
    {
      $article = Article::findOrFail($request->id);
       $article->comments()->delete();

      if($article->attachments()->count() > 0)
      {
          foreach($article->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Articles/'.$article->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Articles/'.$article->name);
              }
              $file->delete();
          }
      }


      if($article->audioes())
      {
       foreach($article->audioes as $audio)
          {
              if(File::exists('Files/audioes/'.$article->name.'/'.$audio->audio_file))
              {
                File::deleteDirectory('Files/audioes/'.$article->name);
              }
              $audio->delete();
          }
        }
        $article->audioes()->delete();

    if($article->videos())
      {
       foreach($article->videos as $video)
          {
              if(File::exists('Files/videos/'.$article->name.'/'.$video->video_file))
              {
                File::deleteDirectory('Files/videos/'.$article->name);
              }
              $video->delete();
          }
        }
        $article->videos()->delete();


      if(!empty($article->image->file_name))
      {

        if(File::exists('Files/image/Articles/'.$article->name.'/'.$article->image->file_name))
              {
                File::deleteDirectory('Files/image/Articles/'.$article->name);
              }

      }

      $article->image()->delete();

      $article->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.articles.index')->with($success);

    }

    public function getCommentArticle($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Article',function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showArticles($id)
    {
       return Article::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $article = Article::findOrFail($request->article_id);
     if(File::exists('Files/Pdf-Files/Articles/'.$article->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Articles/'.$article->name.'/'.$pdf->file_name);
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
       $article = Article::findOrFail($request->article_id);

        if(File::exists('Files/audioes/'.$article->name.'/'.$audio->audio_file))
        {
             unlink('Files/audioes/'.$article->name.'/'.$audio->audio_file);
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
       $article = Article::findOrFail($request->article_id);

        if(File::exists('Files/videos/'.$article->name.'/'.$video->video_file))
        {
             unlink('Files/videos/'.$article->name.'/'.$video->video_file);
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
        $article = Article::findOrFail($request->article_id);

        if(File::exists('Files/image/Articles/'.$article->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Articles/'.$article->name.'/'.$image->file_name);
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

        Article::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.articles.index')->with($success);

    }

}