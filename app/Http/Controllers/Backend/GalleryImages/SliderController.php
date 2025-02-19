<?php

namespace App\Http\Controllers\Backend\GalleryImages;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\Backend\Galleries\SliderRequest;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id','desc')->get();
        return view('backend.slider.index',compact('sliders'));
    }
    
    public function livewire_index()
    {
        $sliders = Slider::get();
        return view('backend.slider.livewire_index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.slider.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request , Slider $slider)
    {

        $last =$slider->max('order_position') + 1;


        $slider = new Slider;
        $slider->title = $request->input('title');
        $slider->link = $request->input('link');
        $slider->status = $request->input('status');
        $slider->order_position = $last;
        
        //upload image
        if($request->hasFile('image'))
        {


            if($slider_image= $request->file('image'))
            {
                $img_slider = $slider_image->getClientOriginalName();
                $slider_image->storeAs('slider/', $img_slider , 'upload_attachments');


            }

            $slider->image = $img_slider;
        }

        $slider->save();

        $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
            ];

        return redirect()->route('admin.slider.index')->with($success);


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
        $model = Slider::findOrFail($id);
        return view('backend.slider.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, $id)
    {
        $validated = $request->validated();
        $slider = Slider::findOrFail($id);

        $data['title']                = $request->title;
        $data['link']                 = $request->link;
        $data['status']               = $request->status;


            $slider->update($data);

             //upload image
        if($request->hasFile('image'))
        {

             //delete old image
             if ($slider->image != '')
             {
                if (File::exists('Files/slider/' . $slider->image))
                {
                    unlink('Files/slider/' . $slider->image);
                }
             }
            if($request->hasFile('image'))
        {


            if($slider_image= $request->file('image'))
            {
                $img_slider = $slider_image->getClientOriginalName();
                $slider_image->storeAs('slider/', $img_slider , 'upload_attachments');


            }

            $slider->image = $img_slider;
        }

        }


        $slider->save();


            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.slider.index')->with($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        if(!empty($slider->image))
        {
            if(File::exists('Files/slider/'.$slider->image))
            {
                unlink('Files/slider/'.$slider->image);
            }

        }


        $slider->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.slider.index')->with($success);
    }

    public function change_status(Request $request)
    {

        $slider = Slider::findOrFail($request->id);
        $slider->status = $request->status;

        $slider->save();


        return response()->json(['success'=>'Status change successfully.']);



    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Slider::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.slider.index')->with($success);

    }
}