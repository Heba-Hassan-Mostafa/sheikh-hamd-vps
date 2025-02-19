<?php

namespace App\Http\Controllers\Backend\Lectures;

use Illuminate\Http\Request;
use App\Exports\LectureExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Backend\Lectures\LectureRequest;
use App\Models\Lecture;
use App\Repository\Lectures\LectureRepositoryInterface;

class LectureController extends Controller
{


    protected $lecture;

    public function __construct(LectureRepositoryInterface $lecture)
    {
        $this->lecture = $lecture;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lectures = $this->lecture->getAllLectures();
       return view('backend.lectures.lectures.index',compact('lectures'));
    }

    public function livewire_index()
    {
         $lectures = $this->lecture->getLivewireLectures();
         return view('backend.lectures.lectures.livewire_index',compact('lectures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->lecture->allLectureCategories();
        return view('backend.lectures.lectures.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LectureRequest $request , Lecture $lecture)
    {
       return $this->lecture->storeLectures($request, $lecture);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lecture = $this->lecture->showLectures($id);
        $comments = $this->lecture->getCommentLecture($id);
        return view('backend.lectures.lectures.show',compact('lecture','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->lecture->allLectureCategories();
        $model = $this->lecture->editLectures($id);
        return view('backend.lectures.lectures.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LectureRequest $request)
    {
        return $this->lecture->updateLectures($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->lecture->deleteLectures($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->lecture->remove_pdf($request);

    }


    public function remove_audio(Request $request)
    {

    return $this->lecture->remove_audio($request);

    }
    
    public function remove_video(Request $request)
    {

    return $this->lecture->remove_video($request);

    }


    public function remove_img(Request $request)
    {
        return $this->lecture->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->lecture->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new LectureExport(), trans('lectures.lectures').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
}