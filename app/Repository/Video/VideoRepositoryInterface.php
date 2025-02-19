<?php
namespace App\Repository\Video;

use App\Models\Video;

interface VideoRepositoryInterface
{
    //get All Videos
    public function getAllVideos();

     //get All VideoCategories
     public function allVideoCategories();

      //create Videos
    public function storeVideos($request , Video $video);

    //edit Videos
    public function editVideos($id);

     //update Videos
     public function updateVideos($request);

      //delete Videos
      public function deleteVideos($request);

     // remove Video
     public function remove_Video($request);


}