<?php


namespace App\Repository\Books;

use App\Models\Book;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Attachment;
use App\Models\Subscriber;
use App\Models\BookCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Jobs\SendBooks;


class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks()
    {
        return Book::with(['category'])->orderBy('id','desc')->get();
    }
    
    
    public function getLivewireBooks()
    {
        return Book::with(['category'])->get();
    }

    public function allBookCategories()
    {
        return BookCategory::tree();
    }

    public function storeBooks($request,$book)
    {
         DB::beginTransaction();

        try {
            $last =$book->max('order_position') + 1;

           $data['name']                = $request->name;
           $data['book_category_id']    = $request->book_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;
           $data['order_position']         = $last;

          $books = Book::create($data);


          //create pdf files of article

            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Books/'.$books->name, $pdf_name , 'upload_attachments');

                    $books->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }




            //create article image

            $photo = new Image();
            if($image= $request->file('photo'))
            {
                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Books/'.$books->name, $img , 'upload_attachments');

                    $photo->file_name = $img;

                }

            $books->image()->create([
                'file_name'=>$photo->file_name,
            ]);


             DB::commit();

         $subscribers=Subscriber::chunk(10,function($data) use($books){
                    dispatch(new SendBooks($data,$books));

                });

       

             $success=[
            'message'=>trans('btns.added-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.books.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editBooks($id)
    {
        return Book::findOrFail($id);
    }


    public function updateBooks($request)
    {
        DB::beginTransaction();

        try {
            $book = Book::findorfail($request->id);

           $data['name']                = $request->name;
           $data['book_category_id']    = $request->book_category_id;
           $data['content']             = $request->content;
           $data['status']              = $request->status;
           $data['publish_date']        = $request->publish_date;
           $data['keywords']            = $request->keywords;
           $data['description']         = $request->description;

          $book->update($data);


          //update pdf files of book
            if($request->file('pdf_files'))
            {
                foreach($request->file('pdf_files') as $file)
                {
                    if(File::exists('Files/Pdf-Files/Books/'.$book->name.'/' . $file))
                    {
                    unlink('Files/Pdf-Files/Books/'.$book->name.'/' . $file);
                    }
                    $pdf_name = $file->getClientOriginalName();
                    $file->storeAs('Pdf-Files/Books/'.$book->name, $pdf_name , 'upload_attachments');

                    $book->attachments()->create([
                        'file_name'=>$pdf_name,
                    ]);

                }

            }



             //update lesson image
            if($image= $request->file('photo'))
            {
                if(!empty($book->image->file_name)){

                    if(File::exists('Files/image/Books/'.$book->name.'/' . $book->image->file_name))
                    {
                    unlink('Files/image/Books/'.$book->name.'/' . $book->image->file_name);
                    }
                }

                    $img = $image->getClientOriginalName();
                    $image->storeAs('image/Books/'.$book->name, $img , 'upload_attachments');

                    $book->image->file_name = $img;


                    $book->image()->update([
                        'file_name'=>$book->image->file_name,
                    ]);

                }


             DB::commit();


             $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.books.index')->with($success);
        }
        catch (\Exception $e) {
              DB::rollback();
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }

    }


    public function deleteBooks($request)
    {
      $book = Book::findOrFail($request->id);
       $book->comments()->delete();

      if($book->attachments()->count() > 0)
      {
          foreach($book->attachments as $file)
          {
              if(File::exists('Files/Pdf-Files/Books/'.$book->name.'/'.$file->file_name))
              {
                File::deleteDirectory('Files/Pdf-Files/Books/'.$book->name);
              }
              $file->delete();
          }
      }




      if(!empty($book->image->file_name))
      {

        if(File::exists('Files/image/Books/'.$book->name.'/'.$book->image->file_name))
              {
                File::deleteDirectory('Files/image/Books/'.$book->name);
              }

      }

      $book->image()->delete();

      $book->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.books.index')->with($success);

    }

    public function getCommentBook($id)
    {
      return  Comment::with('client')->
        where('commentable_type','App\Models\Book',function($query) use($id){
            $query->where('commentable_id',$id);
        })->get();
    }

    public function showBooks($id)
    {
       return Book::findOrFail($id);

    }


    public function remove_pdf($request)
    {

        $pdf = Attachment::findOrFail($request->id);
       $book = Book::findOrFail($request->book_id);
     if(File::exists('Files/Pdf-Files/Books/'.$book->name.'/'.$pdf->file_name))
        {
             unlink('Files/Pdf-Files/Books/'.$book->name.'/'.$pdf->file_name);
        }
     if (!$pdf)
        return redirect()->back()->with(['error' => 'pdf not exist']);

     $pdf->delete();

     return response()->json([
        'status' => true,
        'message'=> trans('btns.deleted-successfully'),
        'id' =>  $request->id

        ]);
    }


    public function remove_img($request)
    {
        $image = Image::findOrFail($request->id);
        $book = Book::findOrFail($request->book_id);

        if(File::exists('Files/image/Books/'.$book->name.'/'.$image->file_name))
            {
                 unlink('Files/image/Books/'.$book->name.'/'.$image->file_name);
            }
        if (!$image)
            return redirect()->back()->with(['error' => 'image not exist']);

        $image->update(['file_name'=>null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);



    }


    public function delete_all($request)
    {
        $delete_all_id = explode(',' ,$request->delete_all_id);

        Book::whereIn('id',$delete_all_id)->delete();

        $success=[
            'message'=>trans('btns.deleted-successfully'),
            'alert-type'=>'error'
        ];

        return redirect()->route('admin.books.index')->with($success);

    }

}
