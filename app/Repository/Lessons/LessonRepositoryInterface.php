<?php
namespace App\Repository\Lessons;

use App\Models\Lesson;

interface LessonRepositoryInterface
{
    //get All Lessons
    public function getAllLessons();
    
    //get Livewire Lessons
     public function getLivewireLessons();
     
     //get All LessonCategories
     public function allLessonCategories();

      //create Lessons
    public function storeLessons($request,Lesson $lesson);

    //edit Lessons
    public function editLessons($id);

     //update Lessons
     public function updateLessons($request);

      //delete Lessons
      public function deleteLessons($request);

      //get comments for Lesson
     public function getCommentLesson($id);

       //show Lessons
     public function showLessons($id);

     // remove pdf
     public function remove_pdf($request);

     // remove audio
     public function remove_audio($request);

     // remove video
     public function remove_video($request);


     // remove image
     public function remove_img($request);

     // remove all lessons
     public function delete_all($request);
}