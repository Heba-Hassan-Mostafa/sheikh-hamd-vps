<?php
namespace App\Repository\Lectures;

use App\Models\Lecture;

interface LectureRepositoryInterface
{
    //get All Lectures
    public function getAllLectures();

    //get All Lectures
    public function getLivewireLectures();

     //get All LessonCategories
     public function allLectureCategories();

      //create Lectures
    public function storeLectures($request,Lecture $lecture);

    //edit Lectures
    public function editLectures($id);

     //update Lectures
     public function updateLectures($request);

      //delete Lectures
      public function deleteLectures($request);

      //get comments for Lesson
     public function getCommentLecture($id);

       //show Lectures
     public function showLectures($id);

     // remove pdf
     public function remove_pdf($request);

     // remove audio
     public function remove_audio($request);

     // remove video
     public function remove_video($request);

     // remove image
     public function remove_img($request);

     // remove all Lectures
     public function delete_all($request);
}
