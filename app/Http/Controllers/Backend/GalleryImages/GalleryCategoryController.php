<?php

namespace App\Http\Controllers\Backend\GalleryImages;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Backend\Galleries\GalleryCategoryRequest;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = GalleryCategory::withCount('galleries')->get();
        return view('backend.galleries.categories.index',compact('categories'));
    }

    public function livewire_index()
    {
        $categories = GalleryCategory::withCount('galleries')->get();
        return view('backend.galleries.categories.livewire_index', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.galleries.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryCategoryRequest $request , GalleryCategory $galleryCategory)
    {
        try {
            $validated = $request->validated();
            $last = $galleryCategory->max('order_position') + 1;

            $category = new GalleryCategory;

            $category->name                  = $request->name;
            $category->status                 = $request->status;
            $category->order_position         = $last;

            if($request->hasFile('image'))
            {
                if($cat_image= $request->file('image'))
                {
                    $img = $cat_image->getClientOriginalName();
                    $cat_image->storeAs('GalleryCategory/', $img , 'upload_attachments');

                }

                $category->image = $img;
            }

       $category->save();

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.gallery-categories.index')->with($success);

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
        $model = GalleryCategory::findOrFail($id);
     return view('backend.galleries.categories.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryCategoryRequest $request, $id)
    {
        try {
            $request->validated();
            $model = GalleryCategory::findOrFail($id);

            $input['name']      = $request->name;
            $input['slug']      = null;
            $input['status']    = $request->status;

            $model->update($input);


             //upload image
        if($request->hasFile('image'))
        {
             //delete old image
             if ($model->image != '')
             {
                if (File::exists('Files/GalleryCategory/'.$model->image))
                {
                    unlink('Files/GalleryCategory/'.$model->image);
                }
             }
            if($request->hasFile('image'))
            {
                if($cat_image= $request->file('image'))
                {
                    $img = $cat_image->getClientOriginalName();
                    $cat_image->storeAs('GalleryCategory/', $img , 'upload_attachments');

                }

            $model->image = $img;
            }

        }
        $model->save();

            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.gallery-categories.index')->with($success);

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
        $gallery = Gallery::where('gallery_category_id' , $id)->pluck('gallery_category_id');


        if($gallery->count() == 0 )
        {
            $category = GalleryCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.gallery-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-images'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.gallery-categories.index')->with($success);

        }



    }
}