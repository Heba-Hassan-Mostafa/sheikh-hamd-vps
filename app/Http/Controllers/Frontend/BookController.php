<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Book;
use App\Models\Wish;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // get all books
    public function all_books()
    {

        $books = Book::with(['category','image','wishes'])->Active()->ActiveCategory()->Publish()->orderBy('order_position','desc')->paginate(9);

        return view('frontend.books.all_books',compact('books'));

    }

    //get all categories of books
    public function getBookCategory($slug)
    {

        $category = BookCategory::with('books')->whereSlug($slug)->orWhere('id', $slug)->Active()->first();

        if ($category) {
            $books = Book::with('category')
                ->whereBookCategoryId($category->id)
                ->Active()
                ->Publish()
                ->orderBy('order_position', 'desc')
                ->paginate(9);
        }


        return view('frontend.books.all_books',compact('books'));

    }

    // add book to wishlist
    public function addWishList($id)
    {
        $client_id = Auth::guard('client')->id();

        $check = Wish::with('client')->where('client_id',$client_id)
        ->where('wishable_type','App\Models\Book')
        ->where('wishable_id',$id)->first();

        $data = [
            'client_id' => $client_id,
            'wishable_id' => $id,
            'wishable_type' => 'App\Models\Book'
        ];

        if(Auth::guard('client')->check())
        {
            if($check)
            {
             Wish::where('client_id',$client_id)->where('wishable_type','App\Models\Book')->where('wishable_id',$id)->delete();
             return response()->json(['error'=> trans('btns.book-ajax-removed')]);

            }else{

             Wish::create($data);

         return response()->json(['success'=> trans('btns.book-ajax-add')]);

           }
        }else{

     return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    // get content of book
    public function book_content(Request $request,$slug)
    {
        $book= Book::with(['category','image','comments','wishes','attachments'])
        ->whereSlug($slug)->ActiveCategory()->orderBy('id','desc')->firstOrFail();

        if($request->ajax())
     {
        $book->increment('download_count') ;
        $book->save();

     }
        $book->increment('view_count') ;

        $randomBooks = Book::with('image')->ActiveCategory()->Active()->Publish()->inRandomOrder()->paginate(3);
        return view('frontend.books.book_content',compact('book','randomBooks'));
    }

    //add comment io book
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
        $book= Book::whereId($id)->Active()->ActiveCategory()->Publish()->orderBy('id','desc')->first();

        $data['message']            = $request->message;
        $data['client_id']          = $client_id;
        $data['commentable_id']     = $book->id;
        $data['commentable_type']   = 'App\Models\Book';

        if(Auth::guard('client')->check())
        {
            Comment::create($data);

         return response()->json(['success'=> trans('btns.ajax-add-comment')]);

        }else{

            return response()->json(['error'=>trans('btns.login-first')]);
       }
    }

    //book search
    public function book_search(Request $request)
    {
        if($request->ajax())
        {
            $output ='';
            $books = Book::where('name','LIKE','%'.$request->search.'%')->
            Active()->ActiveCategory()->Publish()->get();

            if($books)
            {
                foreach($books as $book)
                {
                    $output .=

                    '<div class="col-sm-6 col-md-6 col-lg-4 categoriesCard">
                    <div class="card h-100">';

                    if(!empty($book->image->file_name))
                    {
                        $output .= '<img src = "'.asset("Files/image/Books/".$book->name.'/'.$book->image->file_name).'"
                          class="card-img-top" alt="'. $book->name.'" title="'. $book->name .'" />';
                    }else{
                        $output .= '<img src = "'.asset("frontend/img/books.png").'"
                        class="card-img-top" alt="'. $book->name.'" title="'. $book->name .'" />';
                    };
                    $output .='<div class="card-body">
                            <div class="d-inline-flex mt-3">
                                <i class="fas fa-pen-square title-icon"></i>
                                <h6 class="card-title mt-2">'.
                                Str::limit($book->name, 25).'</h6>
                            </div>

                            <div class="date-details">
                                <i class="fas fa-calendar-alt date-icon"></i>
                                <span>'. $book->publish_date->format('Y-m-d') .'</span>
                            </div>
                            <div class="card-text d-flex mt-2">
                                <i class="fas fa-book-open book-icon"></i>
                               <p>يقدم ا.د حمد بن محمد الهاجرى كتاب بعنوان '
                               .Str::limit($book->name, 35).'</p>
                               </div>
                                 <div class="text-center m-2">
                                <a href=" '.route("frontend.books.book_content", $book->slug).' "
                                    class="btn-card-more">'. trans('frontend.more') .'</a>
                            </div>
                            <p class="allWatch">
                                <i class="fas fa-eye"></i>
                                <span>'. $book->view_count .'</span>
                            </p>
                            <p class="allDown">
                                <i class="fas fa-download"></i>
                                <span>' .$book->download_count .'</span>
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