<?php

namespace App\Http\Controllers\Backend\Books;

use Exception;
use App\Models\BookCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Books\BookCategoryRequest;
use App\Models\Book;

class BookCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BookCategory::withCount('books')->whereNULL('parent_id')->get();
        $subCategories = BookCategory::withCount('books')->where('parent_id','!=',null)->get();

        return view('backend.books.categories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BookCategory::tree();
        return view('backend.books.categories.create',compact('categories'));


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCategoryRequest $request,BookCategory $bookCategory)
    {

        try {
            $validated = $request->validated();

             $last =$bookCategory->max('order_position') + 1;
            $input['name']      = $request->name;
            $input['status']    = $request->status;
            $input['parent_id'] = $request->parent_id;
            $input['order_position']         = $last;

            BookCategory::create($input);

            $success=[
                'message'=>trans('btns.added-successfully'),
                'alert-type'=>'success'
            ];

            return redirect()->route('admin.book-categories.index')->with($success);

        }  catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = BookCategory::findOrFail($id);
        $categories = BookCategory::tree();
     return view('backend.books.categories.show',compact('model','categories'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = BookCategory::findOrFail($id);
        $parentCategories = BookCategory::whereNULL('parent_id')->get(['id','name']);

         return view('backend.books.categories.edit',compact('model','parentCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookCategoryRequest $request, $id)
    {

        try {
        $validated = $request->validated();
        $model = BookCategory::findOrFail($id);

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;

        $model->update($input);

        $success=[
            'message'=>trans('btns.updated-successfully'),
            'alert-type'=>'success'
        ];

        return redirect()->route('admin.book-categories.index')->with($success);

    }
    catch
    (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $books = Book::where('book_category_id' , $id)->pluck('book_category_id');


        if($books->count() == 0 )
        {
            $category = BookCategory::findOrFail($id);
            $category->delete();

            $success=[
                'message'=>trans('btns.deleted-successfully'),
                'alert-type'=>'error'
            ];

            return redirect()->route('admin.book-categories.index')->with($success);


        }else{

            $success=[
                'message'=>trans('btns.there-are-books'),
                'alert-type'=>'error'
            ];

             return redirect()->route('admin.book-categories.index')->with($success);

        }

    }
}