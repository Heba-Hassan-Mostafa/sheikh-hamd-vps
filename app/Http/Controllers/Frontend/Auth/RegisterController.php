<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::CLIENT;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:client');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        =>'required|email|unique:clients',
            'phone'        => 'required|unique:clients',
            'password'     => 'required|string|confirmed|min:9',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $input['first_name']                = $request->first_name;
        $input['last_name']                 = $request->last_name;
        $input['email']                     = $request->email;
        $input['phone']                     = $_REQUEST['phone']['full'];
        $input['password']                  = bcrypt($request->password);


        $client = Client::create($input);
        $client->markEmailAsVerified();

        toastr()->success(trans('btns.register-successfully'));
        return redirect()->route('frontend.index');

    }



}
