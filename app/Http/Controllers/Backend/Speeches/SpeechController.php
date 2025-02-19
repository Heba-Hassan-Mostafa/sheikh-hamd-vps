<?php

namespace App\Http\Controllers\Backend\Speeches;

use Illuminate\Http\Request;
use App\Exports\SpeechExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Backend\Speeches\SpeechRequest;
use App\Models\Speech;
use App\Repository\Speeches\SpeechRepositoryInterface;


class SpeechController extends Controller
{


    protected $speech;

    public function __construct(SpeechRepositoryInterface $speech)
    {
        $this->speech = $speech;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $speeches = $this->speech->getAllSpeeches();
       return view('backend.speeches.speeches.index',compact('speeches'));
    }
    
    public function livewire_index()
    {
        $speeches = $this->speech->getLivewireSpeeches();
       return view('backend.speeches.speeches.livewire_index',compact('speeches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->speech->allSpeechCategories();
        return view('backend.speeches.speeches.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpeechRequest $request , Speech $speech)
    {
       return $this->speech->storeSpeeches($request, $speech);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $speech = $this->speech->showSpeeches($id);
        $comments = $this->speech->getCommentSpeech($id);
        return view('backend.speeches.speeches.show',compact('speech','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->speech->allSpeechCategories();
        $model = $this->speech->editSpeeches($id);
        return view('backend.speeches.speeches.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SpeechRequest $request)
    {
        return $this->speech->updateSpeeches($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->speech->deleteSpeeches($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->speech->remove_pdf($request);

    }


    public function remove_audio(Request $request)
    {

    return $this->speech->remove_audio($request);

    }

    public function remove_video(Request $request)
    {

    return $this->speech->remove_video($request);

    }



    public function remove_img(Request $request)
    {
        return $this->speech->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->speech->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new SpeechExport(), trans('speeches.speeches').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
}