<?php
namespace App\Repository\Books;

use App\Models\Book;

interface BookRepositoryInterface
{
    //get All Books
    public function getAllBooks();
    
     //get All Books
    public function getLivewireBooks();


     //get All LessonCategories
     public function allBookCategories();

      //create Books
    public function storeBooks($request,Book $book);

    //edit Books
    public function editBooks($id);

     //update Books
     public function updateBooks($request);

      //delete Books
      public function deleteBooks($request);

      //get comments for Lesson
     public function getCommentBook($id);

       //show Books
     public function showBooks($id);

     // remove pdf
     public function remove_pdf($request);


     // remove image
     public function remove_img($request);

     // remove all Books
     public function delete_all($request);
}