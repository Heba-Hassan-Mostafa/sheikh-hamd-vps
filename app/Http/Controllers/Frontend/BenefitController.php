<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wish;
use App\Models\Benefit;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BenefitCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BenefitController extends Controller
{
    // get all benefits
    public function all_benefits()
    {

        $benefits = Benefit::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.benefits.all_benefits',compact('benefits'));

    }

    //get all categories of benefits
    public function getBenefitCategory($slug)
    {

        $category = BenefitCategory::with('benefits')->whereSlug($slug)->orWhere('id', $slug)->Active()->first();

        if ($category) {
            $benefits = Benefit::with('category')
                ->whereBenefitCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.benefits.all_benefits',compact('benefits'));

    }

    // add lesson to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
        ->where('wishable_type','App\Models\Benefit')
        ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Benefit'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Benefit')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.benefit-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.benefit-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of benefit
    public function benefit_content(Request $request,$slug)
    {
        $benefit= Benefit::with(['category','audioes','videos','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        $benefit->increment('view_count') ;

        $randomBenefits = Benefit::with('image')->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);
        return view('frontend.benefits.benefit_content',compact('benefit','randomBenefits'));
    }

    //add comment io article
     public function addComment(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [

            'message'    =>'required|string',
        ]);

        if($validation->fails())
        {
            return response()->json(['error'=>$validation->errors()->all()]);
        }

        $client_id = Auth::guard('client')->id();
        $benefit= Benefit::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $benefit->id;
        $data['commentable_type']   = 'App\Models\Benefit';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //benefit search
    public function benefit_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $benefits = Benefit::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($benefits)
            {
                foreach($benefits as $benefit)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($benefit->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/Benefits/".$benefit->name.'/'.$benefit->image->file_name).'"
                          class="card-img-top" alt="'. $benefit->name.'" title="'. $benefit->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/benfits.png").'"
                        class="card-img-top" alt="'. $benefit->name.'" title="'. $benefit->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($benefit->name, 25).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $benefit->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                                <p>يقدم ا.د حمد بن محمد الهاجرى مقال بعنوان '
                                    .Str::limit($benefit->name, 35) .'</p>
                                 </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.benefits.benefit_content", $benefit->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $benefit->view_count .'</span>
                            </p>
                            <p class="allDown">
                            <i class="fas fa-download"></i>
                            <span>' .$benefit->download_count .'</span>
                        </p>
                        </div>


                        </div>
                        </div>';

                }
                return response()->json($output);

            }

        }



    }

}