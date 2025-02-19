<?php

namespace App\Http\Controllers\Backend\Books;

use App\Exports\BookExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Backend\Books\BookRequest;
use App\Models\Book;
use App\Repository\Books\BookRepositoryInterface;


class BookController extends Controller
{


    protected $book;

    public function __construct(BookRepositoryInterface $book)
    {
        $this->book = $book;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->book->getAllBooks();
       return view('backend.books.books.index',compact('books'));
    }
    
     public function livewire_index()
    {
        $books = $this->book->getLivewireBooks();
       return view('backend.books.books.livewire_index',compact('books'));
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->book->allBookCategories();
        return view('backend.books.books.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request,Book $book)
    {
       return $this->book->storeBooks($request, $book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = $this->book->showBooks($id);
        $comments = $this->book->getCommentBook($id);
        return view('backend.books.books.show',compact('book','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->book->allBookCategories();
        $model = $this->book->editBooks($id);
        return view('backend.books.books.edit',compact('categories','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request)
    {
        return $this->book->updateBooks($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->book->deleteBooks($request);
    }


    public function remove_pdf(Request $request)
    {

    return $this->book->remove_pdf($request);

    }

    public function remove_img(Request $request)
    {
        return $this->book->remove_img($request);

    }

    public function delete_all(Request $request)
    {
        //return $request;
         return $this->book->delete_all($request);

    }

     public function export()
    {
        return Excel::download(new BookExport(), trans('books.books').date('Y-m-d'), \Maatwebsite\Excel\Excel::XLSX);


    }
}