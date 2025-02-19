<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

   // use AuthenticatesUsers;

   use AuthTrait;


   public function __construct()
   {
       $this->middleware('guest:client')->except('logout');
   }

     public function loginForm($type)
     {

        return view('frontend.auth.login',compact('type'));
     }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:9'
        ]);

        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password, 'status'=> 1])) {
           return $this->redirect($request);
        }else{
            //toastr()->error(trans('btns.user-not-active'));
            return redirect()->back();
        }

    }


    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('frontend.index');
    }





}