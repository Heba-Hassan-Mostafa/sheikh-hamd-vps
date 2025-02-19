<?php

namespace App\Http\Controllers\Backend\GalleryImages;

use App\Models\Matwiaat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\Backend\Galleries\MatwiaatRequest;

class MatwiaatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matwiaats = Matwiaat::orderBy('id','desc')->get();
        return view('backend.matwiaat.index',compact('matwiaats'));
    }

     public function livewire_index()
    {
        $matwiaats = Matwiaat::get();
        return view('backend.matwiaat.livewire_index',compact('matwiaats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.matwiaat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatwiaatRequest $request , Matwiaat $matwiaat)
    {
        try {
            $validated = $request->validated();
            $last = $matwiaat->max('order_position') + 1;

            $matwiaat = new Matwiaat;

            $matwiaat->title                  = $request->title;
            $matwiaat->status                 = $request->status;
            $matwiaat->order_position         = $last;

            if($request->hasFile('image'))
            {
                if($mat_image= $request->file('image'))
                {
                    $img = $mat_image->getClientOriginalName();
                    $mat_image->storeAs('Matwiaat/', $img , 'upload_attachments');

                }

                $matwiaat->image = $img;
            }

            if($request->hasFile('pdf_file'))
            {
                if($pdf= $request->file('pdf_file'))
                {
                    $file = $pdf->getClientOriginalName();
                    $pdf->storeAs('Matwiaat/PDF/', $file , 'upload_attachments');

                }

                $matwiaat->pdf_file = $file;
            }

       $matwiaat->save();

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.matwiaat.index')->with($success);

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
        $model = Matwiaat::findOrFail($id);
        return view('backend.matwiaat.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MatwiaatRequest $request, $id)
    {

        try {
            $request->validated();
            $model = Matwiaat::findOrFail($id);

            $input['title']      = $request->title;
            $input['status']     = $request->status;

            $model->update($input);


             //upload image
        if($request->hasFile('image'))
        {
             //delete old image
             if ($model->image != '')
             {
                if (File::exists('Files/Matwiaat/'.$model->image))
                {
                    unlink('Files/Matwiaat/'.$model->image);
                }
             }
            if($request->hasFile('image'))
            {
                if($mat_image= $request->file('image'))
                {
                    $img = $mat_image->getClientOriginalName();
                    $mat_image->storeAs('Matwiaat/', $img , 'upload_attachments');

                }

            $model->image = $img;
            }

        }
        if($request->hasFile('pdf_file'))
        {
             //delete old pdf_file
             if ($model->pdf_file != '')
             {
                if (File::exists('Files/Matwiaat/PDF/'.$model->pdf_file))
                {
                    unlink('Files/Matwiaat/PDF/'.$model->pdf_file);
                }
             }
             if($request->hasFile('pdf_file'))
            {
                if($pdf= $request->file('pdf_file'))
                {
                    $file = $pdf->getClientOriginalName();
                    $pdf->storeAs('Matwiaat/PDF/', $file , 'upload_attachments');

                }

                $model->pdf_file = $file;
            }

        }
        $model->save();

            $success=[
                'message'=>trans('btns.updated-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.matwiaat.index')->with($success);

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
    public function destroy(Matwiaat $matwiaat)
    {

        if ($matwiaat->image != '')
        {
                if(File::exists('Files/Matwiaat/'.$matwiaat->image))
                {
                     unlink('Files/Matwiaat/'.$matwiaat->image);
                }

        }
        if ($matwiaat->pdf_file != '')
        {
                if(File::exists('Files/Matwiaat/PDF/'.$matwiaat->pdf_file))
                {
                     unlink('Files/Matwiaat/PDF/'.$matwiaat->pdf_file);
                }

        }
        $matwiaat->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.matwiaat.index')->with($success);
    }



    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Matwiaat::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.matwiaat.index')->with($success);

    }


}
