<?php

namespace App\Http\Controllers\Backend\Clients;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Exports\ContactExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Contact::OrderBy('id','desc')->get();
        return view('backend.clients.contact',compact('clients'));
    }


    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.contacts.index')->with($success);
    }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Contact::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.contacts.index')->with($success);

    }

   public function export()
   {
       return Excel::download(new ContactExport(), trans('clients.contact-us').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

   }
}