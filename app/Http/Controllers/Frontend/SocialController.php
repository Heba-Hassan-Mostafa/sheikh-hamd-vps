<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator,Redirect,Response,File;

class SocialController extends Controller
{
   public function redirect($provider)
{
    return Socialite::driver($provider)->redirect();
}

public function callback($provider)
{

    $getInfo = Socialite::driver($provider)->user();

    $user = $this->createUser($getInfo,$provider);

    auth()->guard('client')->login($user);

    toastr()->success(trans('btns.login-successfully'));
    return redirect()->to('/');

}
function createUser($getInfo,$provider){

   $user = Client::where('provider_id', $getInfo->id)->first();

 if (!$user) {
     $user = Client::create([
        'first_name'   => $getInfo->name,
        'last_name'    => ' ',
        'email'        => $getInfo->email ? $getInfo->email : $getInfo->name.'@facebook.com' ,
        'password'     => Hash::make($getInfo->name.'@'.$getInfo->id),
        'phone'        => $getInfo->phone ? $getInfo->phone : ' ',
        'provider'     => $provider,
        'provider_id'  => $getInfo->id
    ]);
  }
  return $user;
}
}



