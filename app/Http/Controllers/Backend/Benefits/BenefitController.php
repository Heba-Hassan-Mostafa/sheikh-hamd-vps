<?php

namespace App\Http\Controllers\Backend\Benefits;

use Illuminate\Http\Request;
use App\Exports\BenefitExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Backend\Benefits\BenefitRequest;
use App\Models\Benefit;
use App\Repository\Benefits\BenefitRepositoryInterface;


class BenefitController extends Controller
{

    protected $benefit;

    public function __construct(BenefitRepositoryInterface $benefit)
    {
        $this->benefit = $benefit;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $benefits = $this->benefit->getAllBenefits();
       return view('backend.benefits.benefits.index',compact('benefits'));
    }
    
     public function livewire_index()
    {
        $benefits = $this->benefit->getLivewireBenefits();
       return view('backend.benefits.benefits.livewire_index',compact('benefits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->benefit->allBenefitCategories();
        return view('backend.benefits.benefits.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BenefitRequest $request,Benefit $benefit)
    {
       return $this->benefit->storeBenefits($request,$benefit);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $benefit = $this->benefit->showBenefits($id);
        $comments = $this->benefit->getCommentBenefit($id);
        return view('backend.benefits.benefits.show',compact('benefit','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->benefit->allBenefitCategories();
        $model = $this->benefit->editBenefits($id);
        return view('backend.benefits.benefits.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(benefitRequest $request)
    {
        return $this->benefit->updateBenefits($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->benefit->deleteBenefits($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->benefit->remove_pdf($request);

    }


    public function remove_audio(Request $request)
    {

    return $this->benefit->remove_audio($request);

    }
    public function remove_video(Request $request)
    {

    return $this->benefit->remove_video($request);

    }


    public function remove_img(Request $request)
    {
        return $this->benefit->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->benefit->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new BenefitExport(), trans('benefits.benefits').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
}