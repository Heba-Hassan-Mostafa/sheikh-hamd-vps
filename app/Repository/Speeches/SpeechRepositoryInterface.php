<?php
namespace App\Repository\Speeches;

use App\Models\Speech;

interface SpeechRepositoryInterface
{
    //get All Speeches
    public function getAllSpeeches();
    
    //get All Speeches
    public function getLivewireSpeeches();

     //get All LessonCategories
     public function allSpeechCategories();

      //create Speeches
    public function storeSpeeches($request,Speech $speech);

    //edit Speeches
    public function editSpeeches($id);

     //update Speeches
     public function updateSpeeches($request);

      //delete Speeches
      public function deleteSpeeches($request);

      //get comments for Lesson
     public function getCommentSpeech($id);

       //show Speeches
     public function showSpeeches($id);

     // remove pdf
     public function remove_pdf($request);

     // remove audio
     public function remove_audio($request);

      // remove video
      public function remove_video($request);

     // remove image
     public function remove_img($request);

     // remove all Speeches
     public function delete_all($request);
}
