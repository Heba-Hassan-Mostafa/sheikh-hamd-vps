<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wish;
use App\Models\Speech;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SpeechCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpeechController extends Controller
{
    // get all speeches
    public function all_speeches()
    {

        $speeches = Speech::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.speeches.all_speeches',compact('speeches'));

    }

    //get all categories of speeches
    public function getSpeechCategory($slug)
    {

        $category = SpeechCategory::with('speeches')->whereSlug($slug)->orWhere('id', $slug)->Active()->first();

        if ($category) {
            $speeches = Speech::with('category')
                ->whereSpeechCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.speeches.all_speeches',compact('speeches'));

    }

    // add lesson to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
        ->where('wishable_type','App\Models\Speech')
        ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Speech'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Speech')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.speech-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.speech-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of speech
    public function speech_content(Request $request,$slug)
    {
        $speech= Speech::with(['category','audioes','videos','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        if($request->ajax())
     {
        $speech->increment('download_count') ;
        $speech->save();

     }
        $speech->increment('view_count') ;

        $randomSpeeches = Speech::with('image')->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);
        return view('frontend.speeches.speech_content',compact('speech','randomSpeeches'));
    }

    //add comment io speech
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
        $speech= Speech::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $speech->id;
        $data['commentable_type']   = 'App\Models\Speech';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //speech search
    public function speech_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $speeches = Speech::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($speeches)
            {
                foreach($speeches as $speech)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($speech->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/speeches/".$speech->name.'/'.$speech->image->file_name).'"
                          class="card-img-top" alt="'. $speech->name.'" title="'. $speech->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/spee.png").'"
                        class="card-img-top" alt="'. $speech->name.'" title="'. $speech->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($speech->name, 25).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $speech->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                              <p>يقدم ا.د حمد بن محمد الهاجرى خطبة بعنوان '.
                              Str::limit($speech->name, 35) .'</p>
                                </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.speeches.speech_content", $speech->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $speech->view_count .'</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>' .$speech->download_count .'</span>
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