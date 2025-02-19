<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Wish;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LessonCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    // get all lessons
    public function all_lessons()
    {

        $lessons = Lesson::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.lessons.all_lessons',compact('lessons'));

    }

    //get all categories of lessons
    public function getLessonCategory($slug)
    {

        $category = LessonCategory::with('lessons')->whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first();

        if ($category) {
            $lessons = Lesson::with(['category','image','wishes'])
                ->whereLessonCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.lessons.all_lessons',compact('lessons'));

    }

    // add lesson to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
        ->where('wishable_type','App\Models\Lesson')
        ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Lesson'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Lesson')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.lesson-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.lesson-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of lesson
    public function lesson_content(Request $request,$slug)
    {
        $lesson= Lesson::with(['category','audioes','videos','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        if($request->ajax())
     {
        $lesson->increment('download_count') ;
        $lesson->save();

     }
        $lesson->increment('view_count') ;


            $randomLessons = Lesson::with('image')
            ->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);


        return view('frontend.lessons.lesson_content',compact('lesson','randomLessons'));
    }

    //add comment io lesson
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
        $lesson= Lesson::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $lesson->id;
        $data['commentable_type']   = 'App\Models\Lesson';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //lesson search
    public function lesson_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $lessons = Lesson::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($lessons)
            {
                foreach($lessons as $lesson)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($lesson->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/Lessons/".$lesson->name.'/'.$lesson->image->file_name).'"
                          class="card-img-top" alt="'. $lesson->name.'" title="'. $lesson->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/lessons.png").'"
                        class="card-img-top" alt="'. $lesson->name.'" title="'. $lesson->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($lesson->name, 35).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $lesson->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                               <p>يقدم ا.د حمد بن محمد الهاجرى درس بعنوان '
                               .Str::limit($lesson->name, 35) .'</p>
                               </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.lessons.lesson_content", $lesson->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $lesson->view_count .'</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>' .$lesson->download_count .'</span>
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