<?php

namespace App\Http\Controllers\Backend\Benefits;

use Exception;
use App\Models\Article;
use App\Models\BenefitCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Benefits\BenefitCategoryRequest;
use App\Models\Benefit;

class BenefitCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BenefitCategory::withCount('benefits')->whereNULL('parent_id')->get();
        $subCategories = BenefitCategory::withCount('benefits')->where('parent_id','!=',null)->get();

        return view('backend.benefits.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BenefitCategory::tree();
        return view('backend.benefits.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BenefitCategoryRequest $request,BenefitCategory $benefitCategory)
    {

        try {
            $validated = $request->validated();
            $last =$benefitCategory->max('order_position') + 1;

            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;

            BenefitCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.benefit-categories.index')->with($success);

        }  catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
        $model = BenefitCategory::findOrFail($id);
        $categories = BenefitCategory::tree();
     return view('backend.benefits.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = BenefitCategory::findOrFail($id);
        $parentCategories = BenefitCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.benefits.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BenefitCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = BenefitCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.benefit-categories.index')->with($success);

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
        $benefits = Benefit::where('benefit_category_id' , $id)->pluck('benefit_category_id');


        if($benefits->count() == 0 )
        {
            $category = BenefitCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.benefit-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-benefits'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.benefit-categories.index')->with($success);

        }

    }
}