<?php
namespace App\Repository\Articles;

use App\Models\Article;



interface ArticleRepositoryInterface
{
    //get All Articles
    public function getAllArticles();
    
    //get Livewire Articles
    public function getLivewireArticles();

     //get All LessonCategories
     public function allArticleCategories();

      //create Articles
    public function storeArticles($request,Article $article);

    //edit Articles
    public function editArticles($id);

     //update Articles
     public function updateArticles($request);

      //delete Articles
      public function deleteArticles($request);

      //get comments for Lesson
     public function getCommentArticle($id);

       //show Articles
     public function showArticles($id);

     // remove pdf
     public function remove_pdf($request);

     // remove audio
     public function remove_audio($request);

     // remove video
     public function remove_video($request);

     // remove image
     public function remove_img($request);

     // remove all Articles
     public function delete_all($request);
}
