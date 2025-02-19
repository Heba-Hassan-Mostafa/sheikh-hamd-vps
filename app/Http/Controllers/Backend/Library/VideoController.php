<?php

namespace App\Http\Controllers\Backend\Library;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Videos\VideoRequest;
use App\Repository\Video\VideoRepositoryInterface;

class VideoController extends Controller
{
    protected $video;

    public function __construct(VideoRepositoryInterface $video)
    {
        $this->video = $video;

    }


    public function index()
    {
        $videos = $this->video->getAllVideos();

       return view('backend.library.videos.index',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->video->allVideoCategories();
        return view('backend.library.videos.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request , Video $video)
    {
       return $this->video->storeVideos($request , $video);
    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $categories = $this->video->allVideoCategories();
        $model = $this->video->editVideos($id);
        return view('backend.library.videos.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request)
    {
        return $this->video->updateVideos($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->video->deleteVideos($request);
    }



    public function remove_video(Request $request)
    {

    return $this->video->remove_video($request);

    }



}