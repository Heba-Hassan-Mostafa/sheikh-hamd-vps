<?php

namespace App\Http\Controllers\Backend\Speeches;

use Exception;
use App\Models\Speech;
use App\Models\Lecture;
use App\Models\SpeechCategory;
use App\Models\LectureCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Speeches\SpeechCategoryRequest;
use App\Http\Requests\Backend\Lectures\LectureCategoryRequest;

class SpeechCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = SpeechCategory::withCount('speeches')->whereNULL('parent_id')->get();
        $subCategories = SpeechCategory::withCount('speeches')->where('parent_id','!=',null)->get();

        return view('backend.speeches.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = SpeechCategory::tree();
        return view('backend.speeches.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpeechCategoryRequest $request , SpeechCategory $speechCategory)
    {

        try {
            $validated = $request->validated();
            $last =$speechCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;

            SpeechCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.speech-categories.index')->with($success);

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
        $model = SpeechCategory::findOrFail($id);
        $categories = SpeechCategory::tree();
     return view('backend.speeches.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = SpeechCategory::findOrFail($id);
        $parentCategories = SpeechCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.speeches.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpeechCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = SpeechCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.speech-categories.index')->with($success);

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
        $speeches = Speech::where('speech_category_id' , $id)->pluck('speech_category_id');


        if($speeches->count() == 0 )
        {
            $category = SpeechCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.speech-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-speeches'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.speech-categories.index')->with($success);

        }

    }
}