<?php

namespace App\Http\Controllers\Backend\Library;

use Illuminate\Http\Request;
use App\Models\AudioCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Audioes\AudioCategoryRequest;
use App\Models\Audio;

class AudioCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = AudioCategory::withCount('audioes')->get();
        return view('backend.library.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.library.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AudioCategoryRequest $request, AudioCategory $audioCategory)
    {
        try {
            $validated = $request->validated();
            $last =$audioCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['order_position']         = $last;

            AudioCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.audio-categories.index')->with($success);

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
        $model = AudioCategory::findOrFail($id);
     return view('backend.library.categories.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AudioCategoryRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $model = AudioCategory::findOrFail($id);

            $input['name']      = $request->name;
            $input['slug']      = null;
            $input['status']    = $request->status;

            $model->update($input);

            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.audio-categories.index')->with($success);

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
        $audio = Audio::where('audio_category_id' , $id)->pluck('audio_category_id');


        if($audio->count() == 0 )
        {
            $category = AudioCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.audio-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-audioes'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.audio-categories.index')->with($success);

        }



    }
}