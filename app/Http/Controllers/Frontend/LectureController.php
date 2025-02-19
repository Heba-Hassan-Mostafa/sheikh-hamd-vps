<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wish;
use App\Models\Comment;
use App\Models\Lecture;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LectureCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LectureController extends Controller
{
    // get all lectures
    public function all_lectures()
    {

        $lectures = Lecture::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.lectures.all_lectures',compact('lectures'));

    }

    //get all categories of lectures
    public function getLectureCategory($slug)
    {

        $category = LectureCategory::with('lectures')->whereSlug($slug)->orWhere('id', $slug)->Active()->first();

        if ($category) {
            $lectures = Lecture::with('category')
                ->whereLectureCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.lectures.all_lectures',compact('lectures'));

    }

    // add lesson to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
                ->where('wishable_type','App\Models\Lecture')
                ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Lecture'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Lecture')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.lecture-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.lecture-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of lecture
    public function lecture_content(Request $request,$slug)
    {
        $lecture= Lecture::with(['category','audioes','videos','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        if($request->ajax())
     {
        $lecture->increment('download_count') ;
        $lecture->save();

     }
        $lecture->increment('view_count') ;

        $randomLectures = Lecture::with('image')->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);
        return view('frontend.lectures.lecture_content',compact('lecture','randomLectures'));
    }

    //add comment io lecture
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
        $lecture= Lecture::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $lecture->id;
        $data['commentable_type']   = 'App\Models\Lecture';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //lecture search
    public function lecture_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $lectures = Lecture::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($lectures)
            {
                foreach($lectures as $lecture)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($lecture->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/Lectures/".$lecture->name.'/'.$lecture->image->file_name).'"
                          class="card-img-top" alt="'. $lecture->name.'" title="'. $lecture->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/lectures.png").'"
                        class="card-img-top" alt="'. $lecture->name.'" title="'. $lecture->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($lecture->name, 25).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $lecture->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                               <p>يقدم ا.د حمد بن محمد الهاجرى محاضرة بعنوان '
                               .Str::limit($lecture->name, 35) .'</p>
                               </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.lectures.lecture_content", $lecture->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $lecture->view_count .'</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>' .$lecture->download_count .'</span>
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