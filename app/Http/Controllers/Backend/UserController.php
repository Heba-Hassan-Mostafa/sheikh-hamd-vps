<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id','desc')->get();
        return view('backend.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get(['id','name']);

        return view('backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name'    => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|max:255|unique:users',
            'phone'         => 'required|numeric|unique:users',
            'password'      => 'required|confirmed',
            'image'         => 'nullable|image|max:20000,mimes:jpeg,jpg,png'

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $input['first_name']                = $request->first_name;
        $input['last_name']                 = $request->last_name;
        $input['email']                     = $request->email;
        $input['phone']                     = $request->phone;
        $input['password']                  = bcrypt($request->password);

        if( $image = $request->file('image'))
        {
            $file_name = Str::slug($request->first_name).".".$image->getClientOriginalExtension();
            Image::make($image->getRealPath())->resize(500 , null, function($constraint){
                $constraint->aspectRatio();

            })->save('Files/users/'.$file_name,100);

            $input['image'] = $file_name;
        }

       $user = User::create($input);
       $user->markEmailAsVerified();  //to make email_verified_at
       $user->assignRole($request->input('roles'));


        $success=[
            'message'=>'Customer Added Successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.users.index')->with($success);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('backend.users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get(['id','name']);
        $userRole = $user->roles->pluck('id','name')->toArray();
        return view('backend.users.edit' , compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'first_name'         => 'required',
            'last_name'         => 'required',
            'email'         => 'required|email|max:255|unique:users,email,'.$id,
            'phone'        => 'required|numeric',
            'password'      => 'nullable|min:8',
            'image'         => 'nullable|image|max:20000,mimes:jpeg,jpg,png'

        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);

        if ($user) {
            $data['first_name']     = $request->first_name;
            $data['last_name']      = $request->last_name;
            $data['email']          = $request->email;
            $data['phone']         = $request->phone;
            if (trim($request->password) != '') {
                $data['password'] = bcrypt($request->password);
            }

            if ($image = $request->file('image')) {
                if ($user->image != '') {
                    if (File::exists('Files/users/' . $user->image)) {
                        unlink('Files/users/' . $user->image);
                    }
                }
                $file_name = Str::slug($request->first_name).'.'.$image->getClientOriginalExtension();

                Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('Files/users/'.$file_name, 100);

                $data['image']  = $file_name;
            }
        }
       $user->update($data);

       DB::table('model_has_roles')->where('model_id',$id)->delete();
       $user->assignRole($request->input('roles'));

       $success=[
        'message'=>trans('btns.updated-successfully'),
        'alert-type'=>'success'
    ];

    return redirect()->route('admin.users.index')->with($success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.users.index')->with($success);

    }


    public function change_status(Request $request)
    {

        $user = User::findOrFail($request->id);
        $user->status = $request->status;

        $user->save();


        return response()->json(['success'=>'Status change successfully.']);

   }

   public function change_password()
   {
       return view('backend.users.change-password' );
   }

   public function update_password(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'old_password'          => 'required',
           'new_password'          => 'required|confirmed'
       ]);

       if($validator->fails()) {

           return redirect()->back()->withErrors($validator)->withInput();
       }

       if(!Hash::check($request->old_password, auth()->user()->password)){
        return back()->with("error", trans('btns.password-not-match'));
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

           $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.index')->with($success);

   }

   public function profile()
   {
       return view('backend.users.profile');
   }



   public function update_profile(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'first_name'      => 'required',
           'last_name'       => 'required',
           'email'           => 'required|email',
           'phone'           => 'required|numeric',
           'image'           => 'nullable|image|max:20000,mimes:jpeg,jpg,png'
       ]);
       if($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
       }

       $data['first_name']       = $request->first_name;
       $data['last_name']        = $request->last_name;
       $data['email']            = $request->email;
       $data['phone']            = $request->phone;

       if ($image = $request->file('image')) {
           if (auth()->user()->image != ''){
               if (File::exists('Files/users/' .auth()->user()->image)){
                   unlink('Files/users/' .auth()->user()->image);
               }
           }
           $file_name = Str::slug(auth()->user()->name).'.'.$image->getClientOriginalExtension();
           Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
               $constraint->aspectRatio();
           })->save('Files/users/'.$file_name, 100);

           $data['image'] = $file_name;
       }

       $update = Auth::user()->update($data);

       if ($update) {
        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.index')->with($success);
       }
   }
}