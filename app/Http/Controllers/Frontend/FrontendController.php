<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Live;
use App\Models\User;
use App\Models\Wish;
use App\Models\Fatwa;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Lecture;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\FatwaAnswer;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Benefit;
use App\Models\Speech;
use App\Notifications\ContactUsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ClientContactUsMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnswerQuestionForClientNotify;
use App\Rules\ReCaptcha;

class FrontendController extends Controller
{
   public function index()
   {

    return view('frontend.index');
   }

   public function about()
   {
    return view('frontend.about_sheikh.about');
   }


   //subscribers
   public  function subscribe(Request $request)
   {

       $validation = Validator::make($request->all(), [
           'email'   =>'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:subscribers',
         'g-recaptcha-response' => 'required|recaptchav3:contact_us,0.5',
       ]);

       if($validation->fails())
       {
           return redirect()->back()->withErrors($validation)->withInput();
       }

       $data['email']       = $request->email;


       Subscriber::create($data);

        toastr()->success(trans('btns.added-successfully'));

        return redirect()->back();


   }


    //fatwa
    public  function fatwa(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'name'       =>'required|string|max:255',
            'email'      =>'required|email',
            //'phone'      =>'required|numeric',
            'message'    =>'required|string|max:255',
        ]);

        if($validation->fails())
        {
            return response()->json(['error'=>$validation->errors()->all()]);
        }


        $client_id = Auth::guard('client')->id();

        $data['name']        = $request->name;
        $data['email']       = $request->email;
        //$data['phone']       = $request->phone;
        $data['message']     = $request->message;
        $data['client_id']   = $client_id;

        if(Auth::guard('client')->check())
        {
            $fatwa = Fatwa::create($data);

            User::whereStatus(1)->whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin']);
            })->each(function ($admin, $key) use ($fatwa) {
                $admin->notify(new AnswerQuestionForClientNotify($fatwa ,$admin ));
            });

            return response()->json(['success'=> trans('btns.ajax-add-fatwa')]);

        }else{
            return response()->json(['error'=>trans('btns.login-first')]);
        }

    }


     public function contact_us()
    {
        return view('frontend.contact-us.contact_us');
    }

    public function do_contact(Request $request)
    {
        $validation = Validator::make($request->all(), [

            'name'       =>'required|string|max:255',
            'email'      =>'required|email',
            'phone'      =>'required|numeric',
            'message'    =>'required|string|max:255',
            'g-recaptcha-response' => 'required|recaptchav3:contact_us,0.5'
        ]);

        if($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $data['name']        = $request->name;
        $data['email']       = $request->email;
        $data['phone']       = $request->phone;
        $data['message']     = $request->message;

        $contact =  Contact::create($data);


        $admin = User::whereStatus(1)->whereHas('roles', function ($query) {
            $query->whereIn('name', ['admin']);
        })->orderBy('id','desc')->first();

            Notification::route('mail' , $admin->email)
            ->notify(new ContactUsMail($contact,$admin));


            $reply = Contact::orderBy('id','desc')->first();
            Notification::route('mail' , $reply->email)
            ->notify(new ClientContactUsMail($reply));

        toastr()->success(trans('btns.added-successfully'));

        return redirect()->route('frontend.index');


    }


    public function fatwa_question()
    {
        $questions = Fatwa::HasAnswer()->Active()->orderBy('id','desc')->paginate(10);

        return view('frontend.fatwa.questions' , compact('questions'));
    }

    public function fatwa_answer($id)
    {
        $answer = FatwaAnswer::with('fatwa')->where('fatwa_id', $id )->Publish()->firstOrFail();

        if($answer)
        {
            return view('frontend.fatwa.answer' ,compact('answer'));
        }

        return redirect()->route('frontend.index');

    }



    //Live
    public function live()
    {

        return view('frontend.live.main');
    }
    public function live_sound()
    {

        return view('frontend.live.live-sound');
    }

    public function live_tube()
    {
        $live= Live::orderBy('id' , 'desc')->first();

        return view('frontend.live.live',compact('live'));
    }


    public function client()
    {
       $lists = Wish::whereHasMorph(
            'wishable','*',  function (Builder $query) {
                $query->Active()->ActiveCategory()->Publish();
            })->where('client_id',Auth::guard('client')->id())->orderBy('id','desc')->get();


       $comments = Comment::whereHasMorph(
            'commentable','*',  function (Builder $query) {
                $query->Active()->ActiveCategory()->Publish();
            })->where('client_id',Auth::guard('client')->id())->Active()->orderBy('id','desc')->get();

            $questions = Fatwa::HasAnswer()->where('client_id',Auth::guard('client')->id())->Active()->orderBy('id','desc')->paginate(10);

        return view('frontend.contact-us.client',compact('lists','comments','questions'));
    }



    public function search(Request $request)
    {
         $this->validate($request, [
        'search' => 'required',

      ]);

        $results = (new Search())
        ->registerModel(Lesson::class, 'name')
        ->registerModel(Lecture::class, 'name')
        ->registerModel(Book::class, 'name')
        ->registerModel(Speech::class, 'name')
        ->registerModel(Benefit::class, 'name')
        ->registerModel(Article::class, 'name')

        ->search(request('search'));

        return view('frontend.design.search',compact('results'));
    }

}