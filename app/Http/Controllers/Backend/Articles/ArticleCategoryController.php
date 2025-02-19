<?php

namespace App\Http\Controllers\Backend\Articles;

use Exception;
use App\Models\SpeechCategory;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Articles\ArticleCategoryRequest;
use App\Models\Article;

class ArticleCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ArticleCategory::withCount('articles')->whereNULL('parent_id')->get();
        $subCategories = ArticleCategory::withCount('articles')->where('parent_id','!=',null)->get();

        return view('backend.articles.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::tree();
        return view('backend.articles.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleCategoryRequest $request , ArticleCategory $articleCategory)
    {

        try {
            $validated = $request->validated();

            $last =$articleCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;

            ArticleCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.article-categories.index')->with($success);

        }  catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = ArticleCategory::findOrFail($id);
        $categories = ArticleCategory::tree();
     return view('backend.articles.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = ArticleCategory::findOrFail($id);
        $parentCategories = ArticleCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.articles.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = ArticleCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.article-categories.index')->with($success);

    }
    catch
    (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articles = Article::where('article_category_id' , $id)->pluck('article_category_id');


        if($articles->count() == 0 )
        {
            $category = ArticleCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.article-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-articles'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.article-categories.index')->with($success);

        }

    }
}