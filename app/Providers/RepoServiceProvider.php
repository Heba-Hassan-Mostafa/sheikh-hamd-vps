<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind(
        'App\Repository\Lessons\LessonRepositoryInterface',
        'App\Repository\Lessons\LessonRepository',

       );

       $this->app->bind(
        'App\Repository\Lectures\LectureRepositoryInterface',
        'App\Repository\Lectures\LectureRepository'
       );

       $this->app->bind(
        'App\Repository\Speeches\SpeechRepositoryInterface',
        'App\Repository\Speeches\SpeechRepository'
       );

       $this->app->bind(
        'App\Repository\Articles\ArticleRepositoryInterface',
        'App\Repository\Articles\ArticleRepository'
       );

       $this->app->bind(
        'App\Repository\Books\BookRepositoryInterface',
        'App\Repository\Books\BookRepository'
       );

       $this->app->bind(
        'App\Repository\Audio\AudioRepositoryInterface',
        'App\Repository\Audio\AudioRepository'
       );
        $this->app->bind(
        'App\Repository\Video\VideoRepositoryInterface',
        'App\Repository\Video\VideoRepository'
       );

       $this->app->bind(
        'App\Repository\Benefits\BenefitRepositoryInterface',
        'App\Repository\Benefits\BenefitRepository'
       );


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}