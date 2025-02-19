<?php
namespace App\Repository\Audio;

use App\Models\Audio;

interface AudioRepositoryInterface
{
    //get All Audioes
    public function getAllAudioes();

     //get All AudioCategories
     public function allAudioCategories();

      //create Audioes
    public function storeAudioes($request , Audio $audio);

    //edit Audioes
    public function editAudioes($id);

     //update Audioes
     public function updateAudioes($request);

      //delete Audioes
      public function deleteAudioes($request);

     // remove audio
     public function remove_audio($request);


}
