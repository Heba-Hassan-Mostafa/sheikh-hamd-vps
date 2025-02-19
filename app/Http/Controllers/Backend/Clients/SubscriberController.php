<?php

namespace App\Http\Controllers\Backend\Clients;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Exports\SubscriberExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::get();
        return view('backend.clients.subscribe',compact('subscribers'));
    }


    public function destroy($id)
    {
       Subscriber::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.subscribers.index')->with($success);
    }
    
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Subscriber::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.subscribers.index')->with($success);

    }


    public function export()
    {
        return Excel::download(new SubscriberExport(), trans('clients.subscribers').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

    }
}