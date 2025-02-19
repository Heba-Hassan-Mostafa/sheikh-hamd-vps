<?php

namespace App\Http\Controllers\Backend\Benefits;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class BenefitCommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with('client')->where('commentable_type','App\Models\Benefit')->get();
        return view('backend.benefits.comments.index',compact('comments'));
    }


    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.benefit-comments.index')->with($success);
    }


    public function change_status(Request $request)
    {

        $comment = Comment::findOrFail($request->id);
        $comment->status = $request->status;

        $comment->save();


        return response()->json(['success'=>'Status change successfully.']);

   }

    public function delete_all(Request $request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Comment::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->back()->with($success);

    }
}