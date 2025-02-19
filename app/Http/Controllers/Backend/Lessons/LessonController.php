<?php

namespace App\Http\Controllers\Backend\Lessons;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Exports\LessonExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Backend\Lessons\LessonRequest;
use App\Models\Lesson;
use App\Repository\Lessons\LessonRepositoryInterface;

class LessonController extends Controller
{


    protected $lesson;

    public function __construct(LessonRepositoryInterface $lesson)
    {
        $this->lesson = $lesson;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessons = $this->lesson->getAllLessons();
       return view('backend.lessons.lessons.index',compact('lessons'));
    }
    
    public function livewire_index()
    {
        $lessons = $this->lesson->getLivewireLessons();
       return view('backend.lessons.lessons.livewire_index',compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->lesson->allLessonCategories();
        return view('backend.lessons.lessons.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request,Lesson $lesson)
    {
       return $this->lesson->storeLessons($request ,$lesson);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = $this->lesson->showLessons($id);
        $comments = $this->lesson->getCommentLesson($id);
        return view('backend.lessons.lessons.show',compact('lesson','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->lesson->allLessonCategories();
        $model = $this->lesson->editLessons($id);
        return view('backend.lessons.lessons.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request)
    {
        return $this->lesson->updateLessons($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->lesson->deleteLessons($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->lesson->remove_pdf($request);

    }


    public function remove_audio(Request $request)
    {

    return $this->lesson->remove_audio($request);

    }

    public function remove_video(Request $request)
    {

    return $this->lesson->remove_video($request);

    }


    public function remove_img(Request $request)
    {
        return $this->lesson->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->lesson->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new LessonExport(), trans('lessons.lessons').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
}