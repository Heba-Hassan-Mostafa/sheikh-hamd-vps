<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wish;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // get all articles
    public function all_articles()
    {

        $articles = Article::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.articles.all_articles',compact('articles'));

    }

    //get all categories of articles
    public function getArticleCategory($slug)
    {

        $category = ArticleCategory::with('articles')->whereSlug($slug)->orWhere('id', $slug)->Active()->first();

        if ($category) {
            $articles = Article::with('category')
                ->whereArticleCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.articles.all_articles',compact('articles'));

    }

    // add lesson to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
        ->where('wishable_type','App\Models\Article')
        ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Article'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Article')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.article-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.article-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of article
    public function article_content(Request $request,$slug)
    {
        $article= Article::with(['category','audioes','videos','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        if($request->ajax())
     {
        $article->increment('download_count') ;
        $article->save();

     }
        $article->increment('view_count') ;

        $randomArticles = Article::with('image')->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);
        return view('frontend.articles.article_content',compact('article','randomArticles'));
    }

    //add comment io article
     public function addComment(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [

            'message'    =>'required|string',
        ]);

        if($validation->fails())
        {
            return response()->json(['error'=>$validation->errors()->all()]);
        }

        $client_id = Auth::guard('client')->id();
        $article= Article::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $article->id;
        $data['commentable_type']   = 'App\Models\Article';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //article search
    public function article_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $articles = Article::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($articles)
            {
                foreach($articles as $article)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($article->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/articles/".$article->name.'/'.$article->image->file_name).'"
                          class="card-img-top" alt="'. $article->name.'" title="'. $article->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/art.png").'"
                        class="card-img-top" alt="'. $article->name.'" title="'. $article->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($article->name, 25).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $article->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                                <p>يقدم ا.د حمد بن محمد الهاجرى مقال بعنوان '
                                    .Str::limit($article->name, 35) .'</p>
                                  </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.articles.article_content", $article->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $article->view_count .'</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>' .$article->download_count .'</span>
                            </p>
                        </div>


                        </div>
                        </div>';

                }
                return response()->json($output);

            }

        }



    }

}