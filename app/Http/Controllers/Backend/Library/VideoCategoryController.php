<?php

namespace App\Http\Controllers\Backend\Library;

use Illuminate\Http\Request;
use App\Models\VideoCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Videos\VideoCategoryRequest;
use App\Models\Video;

class VideoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = VideoCategory::withCount('videos')->get();
        return view('backend.library.video-categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.library.video-categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoCategoryRequest $request, VideoCategory $videoCategory)
    {
        try {
            $validated = $request->validated();
            $last =$videoCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['order_position']         = $last;

            VideoCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.video-categories.index')->with($success);

        }  catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = VideoCategory::findOrFail($id);
     return view('backend.library.video-categories.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VideoCategoryRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $model = VideoCategory::findOrFail($id);

            $input['name']      = $request->name;
            $input['slug']      = null;
            $input['status']    = $request->status;

            $model->update($input);

            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.video-categories.index')->with($success);

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
        $video = Video::where('video_category_id' , $id)->pluck('video_category_id');


        if($video->count() == 0 )
        {
            $category = VideoCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.video-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-videos'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.video-categories.index')->with($success);

        }



    }
}