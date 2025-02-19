<?php

namespace App\Http\Controllers\Backend\Clients;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Exports\ClientExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::get();
        return view('backend.clients.index',compact('clients'));
    }


    public function destroy($id)
    {
        Client::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.clients.index')->with($success);
    }

    public function change_status(Request $request)
    {

        $client = Client::findOrFail($request->id);
        $client->status = $request->status;

        $client->save();


        return response()->json(['success'=>'Status change successfully.']);



   }

   public function export()
   {
       return Excel::download(new ClientExport(), trans('clients.clients').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);

   }
}