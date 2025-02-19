<?php

namespace App\Http\Controllers\Backend\Lessons;

use Exception;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Models\LessonCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Lessons\LessonCategoryRequest;

class LessonCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = LessonCategory::withCount('lessons')->whereNULL('parent_id')->get();
        $subCategories = LessonCategory::withCount('lessons')->where('parent_id','!=',null)->get();

        return view('backend.lessons.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = LessonCategory::tree();
        return view('backend.lessons.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonCategoryRequest $request , LessonCategory $lessonCategory)
    {

        try {
            $validated = $request->validated();
            $last =$lessonCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;


            LessonCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.lesson-categories.index')->with($success);

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
        $model = LessonCategory::findOrFail($id);
        $categories = LessonCategory::tree();
     return view('backend.lessons.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = LessonCategory::findOrFail($id);
        $parentCategories = LessonCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.lessons.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = LessonCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.lesson-categories.index')->with($success);

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
        $lessons = Lesson::where('lesson_category_id' , $id)->pluck('lesson_category_id');


        if($lessons->count() == 0 )
        {
            $category = LessonCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.lesson-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-lessons'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.lesson-categories.index')->with($success);

        }

    }
}