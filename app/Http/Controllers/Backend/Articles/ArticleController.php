<?php

namespace App\Http\Controllers\Backend\Articles;

use Illuminate\Http\Request;
use App\Exports\ArticleExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use App\Http\Requests\Backend\Articles\ArticleRequest;
use App\Models\Article;
use App\Repository\Articles\ArticleRepositoryInterface;


class ArticleController extends Controller
{


    protected $article;

    public function __construct(ArticleRepositoryInterface $article)
    {
        $this->article = $article;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->article->getAllArticles();
       return view('backend.articles.articles.index',compact('articles'));
    }
    
    public function livewire_index()
    {
        $articles = $this->article->getLivewireArticles();
       return view('backend.articles.articles.livewire_index',compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->article->allArticleCategories();
        return view('backend.articles.articles.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request,Article $article)
    {
       return $this->article->storeArticles($request,$article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = $this->article->showArticles($id);
        $comments = $this->article->getCommentArticle($id);
        return view('backend.articles.articles.show',compact('article','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->article->allArticleCategories();
        $model = $this->article->editArticles($id);
        return view('backend.articles.articles.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request)
    {
        return $this->article->updateArticles($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->article->deleteArticles($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->article->remove_pdf($request);

    }


    public function remove_audio(Request $request)
    {

    return $this->article->remove_audio($request);

    }
    public function remove_video(Request $request)
    {

    return $this->article->remove_video($request);

    }


    public function remove_img(Request $request)
    {
        return $this->article->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->article->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new ArticleExport(), trans('articles.articles').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
    
     public function get_updates()
    {
        $articles = Activity::where('subject_type', 'App\Models\Article')->orderBy('id','desc')->get();

        return view('backend.articles.articles.get-updates',compact('articles'));


    }
}