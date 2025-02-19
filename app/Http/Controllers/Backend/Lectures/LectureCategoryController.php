<?php

namespace App\Http\Controllers\Backend\Lectures;

use Exception;
use App\Models\Lecture;
use App\Models\LectureCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Lectures\LectureCategoryRequest;

class LectureCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = LectureCategory::withCount('lectures')->whereNULL('parent_id')->get();
        $subCategories = LectureCategory::withCount('lectures')->where('parent_id','!=',null)->get();

        return view('backend.lectures.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = LectureCategory::tree();
        return view('backend.lectures.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureCategoryRequest $request, LectureCategory $lectureCategory)
    {

        try {
            $validated = $request->validated();
            $last =$lectureCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;

            LectureCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.lecture-categories.index')->with($success);

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
        $model = LectureCategory::findOrFail($id);
        $categories = LectureCategory::tree();
     return view('backend.lectures.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = LectureCategory::findOrFail($id);
        $parentCategories = LectureCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.lectures.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LectureCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = LectureCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lecture-categories.index')->with($success);

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
        $lectures = Lecture::where('lecture_category_id' , $id)->pluck('lecture_category_id');


        if($lectures->count() == 0 )
        {
            $category = LectureCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.lecture-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-lectures'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.lecture-categories.index')->with($success);

        }

    }
}