<?php
namespace App\Repository\Benefits;

use App\Models\Benefit;

interface BenefitRepositoryInterface
{
      //get All Benefits
      public function getAllBenefits();
      
       //get All Benefits
      public function getLivewireBenefits();

      //get All LessonCategories
      public function allBenefitCategories();

       //create Benefits
     public function storeBenefits($request,Benefit $benefit);

     //edit Benefits
     public function editBenefits($id);

      //update Benefits
      public function updateBenefits($request);

       //delete Benefits
       public function deleteBenefits($request);

       //get comments for Lesson
      public function getCommentBenefit($id);

        //show Benefits
      public function showBenefits($id);

      // remove pdf
      public function remove_pdf($request);

      // remove audio
      public function remove_audio($request);

      // remove video
      public function remove_video($request);

      // remove image
      public function remove_img($request);

      // remove all Benefits
      public function delete_all($request);
}