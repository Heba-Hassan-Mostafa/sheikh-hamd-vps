<?php

namespace App\Http\Controllers\Backend\GalleryImages;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Backend\Galleries\GalleryRequest;
use SebastianBergmann\Type\NullType;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::withCount('images')->orderBy('id', 'desc')->get();
        return view('backend.galleries.images.index', compact('galleries'));
    }

    public function livewire_index()
    {
        $galleries = Gallery::withCount('images')->get();
        return view('backend.galleries.images.livewire_index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = GalleryCategory::get(['id', 'name']);
        return view('backend.galleries.images.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request, Gallery $gallery)
    {

        $validated = $request->validated();
        $last = $gallery->max('order_position') + 1;

        $data['title']                = $request->title;
        $data['gallery_category_id']  = $request->gallery_category_id;
        $data['status']               = $request->status;
        $data['order_position']         = $last;


        $gallery = Gallery::create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $image) {
                $file_name = $gallery->title . '_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                // Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save('Files/gallery/' . $file_name, 100);

                $image->storeAs('gallery/', $file_name , 'upload_attachments');
                $gallery->images()->create([
                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,

                ]);

                $i++;
            }
        }



        $success = [
            'message' => trans('btns.added-successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.galleries.show', $gallery->id)->with($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Gallery::findOrFail($id);
        return view('backend.galleries.images.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Gallery::findOrFail($id);
        $categories = GalleryCategory::get(['id', 'name']);
        return view('backend.galleries.images.edit', compact('model', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, $id)
    {

        $validated = $request->validated();
        $gallery = Gallery::findOrFail($id);

        $data['title']                = $request->title;
        $data['gallery_category_id']  = $request->gallery_category_id;
        $data['status']               = $request->status;



        $gallery->update($data);

        if ($request->images && count($request->images) > 0) {
            $i = $gallery->images()->count() + 1;
            foreach ($request->images as $image) {
                $file_name = $gallery->title . '_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
                $file_size = $image->getSize();
                $file_type = $image->getMimeType();

                // Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // })->save('Files/gallery/' . $file_name, 100);

                $image->storeAs('gallery/', $file_name , 'upload_attachments');


                $gallery->images()->create([

                    'file_name' => $file_name,
                    'file_size' => $file_size,
                    'file_type' => $file_type,
                ]);

                $i++;
            }
        }


        $success = [
            'message' => trans('btns.updated-successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.galleries.index')->with($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {

        if ($gallery->images()->count() > 0) {
            foreach ($gallery->images as $image) {
                if (File::exists('Files/gallery/' . $image->file_name)) {
                    unlink('Files/gallery/' . $image->file_name);
                }
                $image->delete();
            }
        }
        $gallery->delete();

        $success = [
            'message' => trans('btns.deleted-successfully'),
            'alert-type' => 'error'
        ];

        return redirect()->route('admin.galleries.index')->with($success);
    }


    public function remove_image(Request $request)
    {

        //dd($request->all());
        $gallery = Gallery::findOrFail($request->gallery_id);

        $image = $gallery->images()->whereId($request->image_id)->first();
        if (File::exists('Files/gallery/' . $image->file_name)) {
            unlink('Files/gallery/' . $image->file_name);
        }
        $image->delete();
        return true;
    }

    public function caption(Request $request, $id)
    {

        // dd($request->update_all_id);
        $update_all_id = explode(',', $request->update_all_id);
        //dd($update_all_id);


        $gallery = Gallery::findOrFail($id);

        $images = \App\Models\Image::where('imageable_type', 'App\Models\Gallery')->where('imageable_id', $id)->get();

        foreach ($images as $key => $image) {
            //dd($update_all_id[$key]);
            if ($update_all_id[$key] != null) {
                $image->update(['description' => $update_all_id[$key]]);
            } else {
                $image->update(['description' => Null]);
            }
        }

        $success = [
            'message' => trans('btns.updated-successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.galleries.index')->with($success);
    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',', $request->delete_all_id);

        Gallery::whereIn('id', $delete_all_id)->delete();

        $success = [
            'message' => trans('btns.deleted-successfully'),
            'alert-type' => 'error'
        ];

        return redirect()->route('admin.galleries.index')->with($success);
    }
}