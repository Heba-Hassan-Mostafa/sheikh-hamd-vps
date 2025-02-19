<?php

namespace App\Http\Controllers\Backend\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\Audio\AudioRepositoryInterface;
use App\Http\Requests\Backend\Audioes\AudioRequest;
use App\Models\Audio;

class AudioController extends Controller
{
    protected $audio;

    public function __construct(AudioRepositoryInterface $audio)
    {
        $this->audio = $audio;

    }


    public function index()
    {
        $audioes = $this->audio->getAllAudioes();

       return view('backend.library.audioes.index',compact('audioes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->audio->allAudioCategories();
        return view('backend.library.audioes.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AudioRequest $request , Audio $audio)
    {
       return $this->audio->storeAudioes($request , $audio);
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $categories = $this->audio->allAudioCategories();
        $model = $this->audio->editAudioes($id);
        return view('backend.library.audioes.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AudioRequest $request)
    {
        return $this->audio->updateAudioes($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->audio->deleteAudioes($request);
    }



    public function remove_audio(Request $request)
    {

    return $this->audio->remove_audio($request);

    }



}