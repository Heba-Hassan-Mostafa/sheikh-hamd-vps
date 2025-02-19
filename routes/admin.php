<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Backend\Live\LiveController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Backend\Books\BookController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Fatwa\FatwaController;
use App\Http\Controllers\Backend\Events\EventController;
use App\Http\Controllers\Backend\Library\AudioController;
use App\Http\Controllers\Backend\Library\VideoController;
use App\Http\Controllers\Backend\Clients\ClientController;
use App\Http\Controllers\Backend\Lessons\LessonController;
use App\Http\Controllers\Backend\Clients\ContactController;
use App\Http\Controllers\Backend\Speeches\SpeechController;
use App\Http\Controllers\Backend\Articles\ArticleController;
use App\Http\Controllers\Backend\Benefits\BenefitController;
use App\Http\Controllers\Backend\Lectures\LectureController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Backend\Books\BookCommentController;
use App\Http\Controllers\Backend\Fatwa\FatwaAnswerController;
use App\Http\Controllers\Backend\Books\BookCategoryController;
use App\Http\Controllers\Backend\Clients\SubscriberController;
use App\Http\Controllers\Backend\GalleryImages\SliderController;
use App\Http\Controllers\Backend\GalleryImages\GalleryController;
use App\Http\Controllers\Backend\Lessons\LessonCommentController;
use App\Http\Controllers\Backend\Library\AudioCategoryController;
use App\Http\Controllers\Backend\Library\VideoCategoryController;
use App\Http\Controllers\Backend\GalleryImages\MatwiaatController;
use App\Http\Controllers\Backend\Lessons\LessonCategoryController;
use App\Http\Controllers\Backend\Speeches\SpeechCommentController;
use App\Http\Controllers\Backend\Articles\ArticleCommentController;
use App\Http\Controllers\Backend\Benefits\BenefitCommentController;
use App\Http\Controllers\Backend\Lectures\LectureCommentController;
use App\Http\Controllers\Backend\Speeches\SpeechCategoryController;
use App\Http\Controllers\Backend\Articles\ArticleCategoryController;
use App\Http\Controllers\Backend\Benefits\BenefitCategoryController;
use App\Http\Controllers\Backend\Lectures\LectureCategoryController;
use App\Http\Controllers\Backend\GalleryImages\GalleryCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes(['verify'=>true]);

//Authentcation

    //Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

   Route::get('admin/login/{type}',  [LoginController::class,'loginForm'])->middleware('guest')->name('admin.login.show');
   Route::post('admin/login',  [LoginController::class,'login'])->name('admin.login');
   //logout
  Route::get('admin/logout/{type}', [LoginController::class,'logout'])->name('admin.logout');
  Route::get('admin/password/reset',   [ForgotPasswordController::class,'showLinkRequestForm'])->name('admin.password.request');
  Route::post('admin/password/email',  [ForgotPasswordController::class,'sendResetLinkEmail'])->name('admin.password.email');
  Route::get('admin/password/reset/{token}',  [ResetPasswordController::class,'showResetForm'])->name('admin.password.reset');
  Route::post('admin/password/reset',    [ResetPasswordController::class,'reset'])->name('admin.password.update');
  Route::get('/email/verify',   [VerificationController::class,'show'])->name('verification.notice');
  Route::get('/email/verify/{id}/{hash}',  [VerificationController::class,'verify'])->name('verification.verify');
  Route::post('email/resend',  [VerificationController::class,'resend'])->name('verification.resend');

    //});

//localization
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]

    ], function(){

        Route::group(['middleware'=>['auth','auto-check-permission'] ,'prefix' => 'admin', 'as' => 'admin.'], function () {


                //dashboard index
            Route::get('/index', [BackendController::class, 'index'])->name('index');

             //users
              Route::get('/users/profile', [UserController::class,'profile'])->name('users.profile');
             Route::post('/users/profile', [UserController::class,'update_profile'])->name('users.update-profile');
             Route::get('/users/change-password', [UserController::class,'change_password'])->name('users.change-password');
             Route::post('/users/change-password', [UserController::class,'update_password'])->name('users.update-password');
             Route::get('/users/change', [UserController::class,'change_status'])->name('users.change');
             Route::resource('/users', UserController::class);
            //roles
            Route::resource('/roles', RoleController::class);



            //LessonCategory
            Route::resource('/lesson-categories', LessonCategoryController::class);

            //lesson comments
            Route::post('comments/delete_all', [LessonCommentController::class,'delete_all'])->name('comments.delete_all');
            Route::get('/comments/change', [LessonCommentController::class,'change_status'])->name('comments.change');
            Route::resource('/comments', LessonCommentController::class);

            //Lessons
            Route::post('lessons/export', [LessonController::class,'export'])->name('lessons.export');
            Route::post('lessons/delete_all', [LessonController::class,'delete_all'])->name('lessons.delete_all');
            Route::post('lessons/remove_img', [LessonController::class,'remove_img'])->name('lessons.remove_img');
            Route::post('lessons/remove_video', [LessonController::class,'remove_video'])->name('lessons.remove_video');
            Route::post('lessons/remove_audio', [LessonController::class,'remove_audio'])->name('lessons.remove_audio');
            Route::post('lessons/remove_pdf', [LessonController::class,'remove_pdf'])->name('lessons.remove_pdf');
            Route::get('/lessons/sort_lessons', [LessonController::class,'livewire_index'])->name('lessons.sort_lessons');
            Route::resource('/lessons', LessonController::class);


              //lectureCategory
            Route::resource('/lecture-categories', LectureCategoryController::class);

                //lecture comments
            Route::post('/lecture-comments/delete_all', [LectureCommentController::class,'delete_all'])->name('lecture-comments.delete_all');
            Route::get('/lecture-comments/change', [LectureCommentController::class,'change_status'])->name('lecture-comments.change');
            Route::resource('/lecture-comments', LectureCommentController::class);

            //lectures
            Route::post('lectures/export', [LectureController::class,'export'])->name('lectures.export');
            Route::post('lectures/delete_all', [LectureController::class,'delete_all'])->name('lectures.delete_all');
            Route::post('lectures/remove_img', [LectureController::class,'remove_img'])->name('lectures.remove_img');
            Route::post('lectures/remove_video', [LectureController::class,'remove_video'])->name('lectures.remove_video');
            Route::post('lectures/remove_audio', [LectureController::class,'remove_audio'])->name('lectures.remove_audio');
            Route::post('lectures/remove_pdf', [LectureController::class,'remove_pdf'])->name('lectures.remove_pdf');
            Route::get('lectures/sort_lectures', [LectureController::class,'livewire_index'])->name('lectures.sort_lectures');
            Route::resource('/lectures', LectureController::class);



            //speechCategory
            Route::resource('/speech-categories', SpeechCategoryController::class);

             //speech comments
              Route::post('/speech-comments/delete_all', [SpeechCommentController::class,'delete_all'])->name('speech-comments.delete_all');
              Route::get('/speech-comments/change', [SpeechCommentController::class,'change_status'])->name('speech-comments.change');
              Route::resource('/speech-comments', SpeechCommentController::class);

            //speeches
            Route::post('speeches/export', [SpeechController::class,'export'])->name('speeches.export');
            Route::post('speeches/delete_all', [SpeechController::class,'delete_all'])->name('speeches.delete_all');
            Route::post('speeches/remove_img', [SpeechController::class,'remove_img'])->name('speeches.remove_img');
            Route::post('speeches/remove_video', [SpeechController::class,'remove_video'])->name('speeches.remove_video');
            Route::post('speeches/remove_audio', [SpeechController::class,'remove_audio'])->name('speeches.remove_audio');
            Route::post('speeches/remove_pdf', [SpeechController::class,'remove_pdf'])->name('speeches.remove_pdf');
            Route::get('speeches/sort_speeches', [SpeechController::class,'livewire_index'])->name('speeches.sort_speeches');
            Route::resource('/speeches', SpeechController::class);



             //articleCategory
            Route::resource('/article-categories', ArticleCategoryController::class);

             //article comments
             Route::post('/article-comments/delete_all', [ArticleCommentController::class,'delete_all'])->name('article-comments.delete_all');
             Route::get('/article-comments/change', [ArticleCommentController::class,'change_status'])->name('article-comments.change');
             Route::resource('/article-comments', ArticleCommentController::class);

            //articles
            Route::post('articles/export', [ArticleController::class,'export'])->name('articles.export');
            Route::post('articles/delete_all', [ArticleController::class,'delete_all'])->name('articles.delete_all');
            Route::post('articles/remove_img', [ArticleController::class,'remove_img'])->name('articles.remove_img');
            Route::post('articles/remove_video', [ArticleController::class,'remove_video'])->name('articles.remove_video');
            Route::post('articles/remove_audio', [ArticleController::class,'remove_audio'])->name('articles.remove_audio');
            Route::post('articles/remove_pdf', [ArticleController::class,'remove_pdf'])->name('articles.remove_pdf');
            Route::get('articles/sort_articles', [ArticleController::class,'livewire_index'])->name('articles.sort_articles');
            Route::get('articles/get_updates', [ArticleController::class,'get_updates'])->name('articles.get_updates');
            Route::resource('/articles', ArticleController::class);



            //bookCategory
            Route::resource('/book-categories', BookCategoryController::class);

            //book comments
            Route::post('/book-comments/delete_all', [BookCommentController::class,'delete_all'])->name('book-comments.delete_all');
            Route::get('/book-comments/change', [BookCommentController::class,'change_status'])->name('book-comments.change');
            Route::resource('/book-comments', BookCommentController::class);

            //books
            Route::post('books/export', [BookController::class,'export'])->name('books.export');
            Route::post('books/delete_all', [BookController::class,'delete_all'])->name('books.delete_all');
            Route::post('books/remove_img', [BookController::class,'remove_img'])->name('books.remove_img');
            Route::post('books/remove_pdf', [BookController::class,'remove_pdf'])->name('books.remove_pdf');
            Route::get('books/sort_books', [BookController::class,'livewire_index'])->name('books.sort_books');
            Route::resource('/books', BookController::class);


            //benefitCategory
            Route::resource('/benefit-categories', BenefitCategoryController::class);

            //benefit comments
            Route::post('benefit-comments/delete_all', [BenefitCommentController::class,'delete_all'])->name('benefit-comments.delete_all');
            Route::get('/benefit-comments/change', [BenefitCommentController::class,'change_status'])->name('benefit-comments.change');
            Route::resource('/benefit-comments', BenefitCommentController::class);

            //benefits
            Route::post('benefits/export', [BenefitController::class,'export'])->name('benefits.export');
            Route::post('benefits/delete_all', [BenefitController::class,'delete_all'])->name('benefits.delete_all');
            Route::post('benefits/remove_video', [BenefitController::class,'remove_video'])->name('benefits.remove_video');
            Route::post('benefits/remove_audio', [BenefitController::class,'remove_audio'])->name('benefits.remove_audio');
            Route::post('benefits/remove_pdf', [BenefitController::class,'remove_pdf'])->name('benefits.remove_pdf');
            Route::post('benefits/remove_img', [BenefitController::class,'remove_img'])->name('benefits.remove_img');
            Route::get('benefits/sort_benefits', [BenefitController::class,'livewire_index'])->name('benefits.sort_benefits');
            Route::resource('/benefits', BenefitController::class);


             //subscribers
             Route::post('subscribers/delete_all', [SubscriberController::class,'delete_all'])->name('subscribers.delete_all');
             Route::post('subscribers/export', [SubscriberController::class,'export'])->name('subscribers.export');
             Route::resource('/subscribers', SubscriberController::class);

             //clients
             Route::post('clients/export', [ClientController::class,'export'])->name('clients.export');
             Route::get('/clients/change', [ClientController::class,'change_status'])->name('clients.change');
             Route::resource('/clients', ClientController::class);


              //galleries
              Route::get('/gallery-categories/sort_gallery-categories', [GalleryCategoryController::class,'livewire_index'])->name('gallery-categories.sort_gallery-categories');
              Route::resource('/gallery-categories', GalleryCategoryController::class);
              Route::post('galleries/remove-image', [GalleryController::class,'remove_image'])->name('galleries.remove_image');
              Route::post('galleries/delete_all', [GalleryController::class,'delete_all'])->name('galleries.delete_all');
              Route::post('galleries/caption/{id}', [GalleryController::class,'caption'])->name('galleries.caption');
              Route::get('/galleries/sort_galleries', [GalleryController::class,'livewire_index'])->name('galleries.sort_galleries');
              Route::resource('/galleries', GalleryController::class);


              //matwiaat
              Route::post('matwiaat/delete_all', [MatwiaatController::class,'delete_all'])->name('matwiaat.delete_all');
              Route::get('/matwiaat/sort_matwiaat', [MatwiaatController::class,'livewire_index'])->name('matwiaat.sort_matwiaat');
              Route::resource('/matwiaat', MatwiaatController::class);

                 //events
            Route::get('/events/old_events', [EventController::class,'past_events'])->name('events.old_events');
            Route::post('events/export', [EventController::class,'export'])->name('events.export');
            Route::post('events/past-export', [EventController::class,'past_export'])->name('events.past-export');
            Route::post('events/remove_img', [EventController::class,'remove_img'])->name('events.remove_img');
            Route::post('events/delete_all', [EventController::class,'delete_all'])->name('events.delete_all');
            Route::resource('/events', EventController::class);



             //settings
             Route::post('settings/remove_lesson_banner', [SettingController::class,'remove_lesson_banner'])->name('settings.remove_lesson_banner');
             Route::post('settings/remove_lecture_banner', [SettingController::class,'remove_lecture_banner'])->name('settings.remove_lecture_banner');
             Route::post('settings/remove_article_banner', [SettingController::class,'remove_article_banner'])->name('settings.remove_article_banner');
             Route::post('settings/remove_speech_banner', [SettingController::class,'remove_speech_banner'])->name('settings.remove_speech_banner');
             Route::post('settings/remove_benefit_banner', [SettingController::class,'remove_benefit_banner'])->name('settings.remove_benefit_banner');
             Route::post('settings/remove_book_banner', [SettingController::class,'remove_book_banner'])->name('settings.remove_book_banner');
             Route::post('settings/remove_gallery_banner', [SettingController::class,'remove_gallery_banner'])->name('settings.remove_gallery_banner');
             Route::post('settings/remove_audio_banner', [SettingController::class,'remove_audio_banner'])->name('settings.remove_audio_banner');
             Route::post('settings/remove_video_banner', [SettingController::class,'remove_video_banner'])->name('settings.remove_video_banner');
             Route::post('settings/remove_matwiaat_banner', [SettingController::class,'remove_matwiaat_banner'])->name('settings.remove_matwiaat_banner');


             Route::get('/reports',     [SettingController::class,'report'])->name('reports');
             Route::resource('/settings', SettingController::class);


              //fatwa
              Route::post('fatwa/export', [FatwaController::class,'export'])->name('fatwa.export');
              Route::post('fatwa/delete_all', [FatwaController::class,'delete_all'])->name('fatwa.delete_all');
              Route::get('/fatwa/change', [FatwaController::class,'change_status'])->name('fatwa.change');
              Route::resource('/fatwa', FatwaController::class);

              Route::post('fatwa_answers/delete_all', [FatwaAnswerController::class,'delete_all'])->name('fatwa_answers.delete_all');
              Route::post('fatwa_answers/remove_audio', [FatwaAnswerController::class,'remove_audio'])->name('fatwa_answers.remove_audio');
              Route::resource('/fatwa_answers', FatwaAnswerController::class);


            //slider
            Route::post('slider/delete_all', [SliderController::class,'delete_all'])->name('slider.delete_all');
            Route::get('/slider/change', [SliderController::class,'change_status'])->name('slider.change');
            Route::get('/slider/sort_slider', [SliderController::class,'livewire_index'])->name('slider.sort_slider');
            Route::resource('/slider', SliderController::class);


            //live
            Route::resource('/live', LiveController::class);

             //Audio library
             Route::resource('/audio-categories', AudioCategoryController::class);
             Route::post('library-audio/remove_audio', [AudioController::class,'remove_audio'])->name('library-audio.remove_audio');
             Route::resource('/library-audio', AudioController::class);

               //Video library
             Route::resource('/video-categories', VideoCategoryController::class);
             Route::post('library-video/remove_video', [VideoController::class,'remove_video'])->name('library-video.remove_video');
             Route::resource('/library-video', VideoController::class);


             //contact-us
             Route::post('contacts/export', [ContactController::class,'export'])->name('contacts.export');
             Route::post('/contacts/delete_all', [ContactController::class,'delete_all'])->name('contacts.delete_all');
             Route::resource('/contacts', ContactController::class);


             Route::get('/activity-log', [BackendController::class , 'activity_log'])->name('activity-log');



        });
    });
