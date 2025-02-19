<?php

use Spatie\Feed\Http\FeedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\BookController;
use App\Http\Controllers\Frontend\LessonController;
use App\Http\Controllers\Frontend\SocialController;
use App\Http\Controllers\Frontend\SpeechController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\BenefitController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\LectureController;
use App\Http\Controllers\Frontend\LibraryController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Frontend\Auth\VerificationController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('maintenance', function () {

    if (setting()->status == 1) {
        return redirect('/');
    }

    return view('frontend.design.maintenance');
});


Route::group(['middleware' => 'Maintenance'], function () {

    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        ],
        function () {

            //auth
            Route::get('/login/{type}',             [LoginController::class, 'loginForm'])->middleware('guest:client')->name('login.show');
            Route::post('/login',                   [LoginController::class, 'login'])->name('login');
            Route::post('/register',                [RegisterController::class, 'register'])->name('register');
            //logout
            Route::get('/logout/{type}',             [LoginController::class, 'logout'])->name('logout');
            Route::get('password/reset',             [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
            Route::post('password/email',            [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
            Route::get('password/reset/{token}',     [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
            Route::post('password/reset',            [ResetPasswordController::class, 'reset'])->name('password.update');
            Route::get('email/verify',               [VerificationController::class, 'show'])->name('verification.notice');
            Route::get('/email/verify/{id}/{hash}',  [VerificationController::class, 'verify'])->name('verification.verify');
            Route::post('email/resend',              [VerificationController::class, 'resend'])->name('verification.resend');

            Route::get('/redirect/{provider}',                  [SocialController::class, 'redirect']);
            Route::get('/callback/{provider}',                  [SocialController::class, 'callback']);



            Route::group(['as' => 'frontend.'], function () {

                //index
                Route::get('/',                     [FrontendController::class, 'index'])->name('index');
                //about skeikh
                Route::get('/about-sheikh',         [FrontendController::class, 'about'])->name('about');
                //add-subscribers
                Route::post('/subscribe',           [FrontendController::class, 'subscribe'])->name('subscribe');
                //add-fatwa
                Route::post('/fatwa',               [FrontendController::class, 'fatwa'])->name('fatwa');

                //live
                Route::get('/live',                    [FrontendController::class, 'live'])->name('live');
                Route::get('/live-tube',               [FrontendController::class, 'live_tube'])->name('live-tube');
                Route::get('/live-sound',              [FrontendController::class, 'live_sound'])->name('live-sound');

                Route::get('/client',                   [FrontendController::class, 'client'])->middleware('auth:client')->name('client');

                Route::get('/search',                   [FrontendController::class, 'search'])->name('search');

                //lessons
                Route::group(['prefix' => 'lessons', 'as' => 'lessons.'], function () {

                    Route::get('/category/{slug}/lesson',         [LessonController::class, 'getLessonCategory'])->name('category.lessons');
                    Route::get('/all-lessons',                    [LessonController::class, 'all_lessons'])->name('all-lessons');
                    Route::get('/{lesson}',                       [LessonController::class, 'lesson_content'])->name('lesson_content');
                    Route::get('add/wishlist/{id}',              [LessonController::class, 'addWishList']);
                    Route::post('add/comment/{id}',              [LessonController::class, 'addComment'])->name('add.comment');
                    Route::get('/lesson/search',                 [LessonController::class, 'lesson_search'])->name('lesson.search');
                });

                //lectures
                Route::group(['prefix' => 'lectures', 'as' => 'lectures.'], function () {

                    Route::get('/category/{slug}/lecture',         [LectureController::class, 'getLectureCategory'])->name('category.lectures');
                    Route::get('/all-lectures',                    [LectureController::class, 'all_lectures'])->name('all-lectures');
                    Route::get('/{lecture}',                       [LectureController::class, 'lecture_content'])->name('lecture_content');
                    Route::get('add/wishlist/{id}',               [LectureController::class, 'addWishList']);
                    Route::post('add/comment/{id}',               [LectureController::class, 'addComment'])->name('add.comment');
                    Route::get('/lectures/search',                [LectureController::class, 'lecture_search'])->name('lecture.search');
                });

                //articles
                Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {

                    Route::get('/category/{slug}/article',         [ArticleController::class, 'getArticleCategory'])->name('category.articles');
                    Route::get('/all-articles',                    [ArticleController::class, 'all_articles'])->name('all-articles');
                    Route::get('/{article}',                       [ArticleController::class, 'article_content'])->name('article_content');
                    Route::get('add/wishlist/{id}',               [ArticleController::class, 'addWishList']);
                    Route::post('add/comment/{id}',               [ArticleController::class, 'addComment'])->name('add.comment');
                    Route::get('/articles/search',                [ArticleController::class, 'article_search'])->name('article.search');
                });

                //speeches
                Route::group(['prefix' => 'speeches', 'as' => 'speeches.'], function () {

                    Route::get('/category/{slug}/speech',          [SpeechController::class, 'getSpeechCategory'])->name('category.speeches');
                    Route::get('/all-speeches',                    [SpeechController::class, 'all_speeches'])->name('all-speeches');
                    Route::get('/{speech}',                        [SpeechController::class, 'speech_content'])->name('speech_content');
                    Route::get('add/wishlist/{id}',               [SpeechController::class, 'addWishList']);
                    Route::post('add/comment/{id}',               [SpeechController::class, 'addComment'])->name('add.comment');
                    Route::get('/speeches/search',                [SpeechController::class, 'speech_search'])->name('speech.search');
                });

                //books
                Route::group(['prefix' => 'books', 'as' => 'books.'], function () {

                    Route::get('/category/{slug}/book',             [BookController::class, 'getBookCategory'])->name('category.books');
                    Route::get('/all-books',                        [BookController::class, 'all_books'])->name('all-books');
                    Route::get('/{book}',                           [BookController::class, 'book_content'])->name('book_content');
                    Route::get('add/wishlist/{id}',                 [BookController::class, 'addWishList']);
                    Route::post('add/comment/{id}',                 [BookController::class, 'addComment'])->name('add.comment');
                    Route::get('/books/search',                     [BookController::class, 'book_search'])->name('book.search');
                });


                //benefits
                Route::group(['prefix' => 'benefits', 'as' => 'benefits.'], function () {

                    Route::get('/category/{slug}/benefit',             [BenefitController::class, 'getBenefitCategory'])->name('category.benefits');
                    Route::get('/all-benefits',                        [BenefitController::class, 'all_benefits'])->name('all-benefits');
                    Route::get('/{benefit}',                           [BenefitController::class, 'benefit_content'])->name('benefit_content');
                    Route::get('add/wishlist/{id}',                   [BenefitController::class, 'addWishList']);
                    Route::post('add/comment/{id}',                   [BenefitController::class, 'addComment'])->name('add.comment');
                    Route::get('/benefits/search',                    [BenefitController::class, 'benefit_search'])->name('benefit.search');
                });

                //add-contact-us
                Route::get('/contact-us',            [FrontendController::class, 'contact_us']);
                Route::post('/contact-us',           [FrontendController::class, 'do_contact'])->name('contact.us');


                //fatwa-pages
                Route::group(['prefix' => 'fatwa', 'as' => 'fatwa.'], function () {

                    Route::get('/questions',                    [FrontendController::class, 'fatwa_question'])->name('questions');
                    Route::get('/answer/{id}',                  [FrontendController::class, 'fatwa_answer'])->name('answers');
                });


                //gallery-page
                Route::group(['prefix' => 'gallery', 'as' => 'gallery.'], function () {
                    Route::get('/category/{slug}',             [GalleryController::class, 'getGalleryCategory'])->name('category');
                    Route::get('/images',                      [GalleryController::class, 'gallery'])->name('images');
                    Route::get('/matwiaat',                    [GalleryController::class, 'matwiaat'])->name('matwiaat');
                });

                //library-page
                Route::group(['prefix' => 'library', 'as' => 'library.'], function () {
                    Route::get('/main',                            [LibraryController::class, 'main'])->name('main');

                    Route::get('/videos',                          [LibraryController::class, 'video'])->name('videos');
                    Route::get('/lesson/videos',                   [LibraryController::class, 'lesson_video'])->name('lesson.videos');
                    Route::get('/lecture/videos',                  [LibraryController::class, 'lecture_video'])->name('lecture.videos');
                    Route::get('/article/videos',                  [LibraryController::class, 'article_video'])->name('article.videos');
                    Route::get('/speech/videos',                   [LibraryController::class, 'speech_video'])->name('speech.videos');
                    Route::get('/another/video',                   [LibraryController::class, 'another_video'])->name('another.video');

                    Route::get('/video-category/{slug}',           [LibraryController::class, 'getVideoCategory'])->name('video.category');
                    Route::get('/{video}',                        [LibraryController::class, 'video_content'])->name('videos.content');

                    Route::get('/library/search',                 [LibraryController::class, 'library_search'])->name('library.search');
                });

                Route::group(['prefix' => 'audio-library', 'as' => 'audio-library.'], function () {
                Route::get('/audio',                           [LibraryController::class, 'audio'])->name('audio');
                Route::get('/lesson/audio',                    [LibraryController::class, 'lesson_audio'])->name('lesson.audio');
                Route::get('/lecture/audio',                   [LibraryController::class, 'lecture_audio'])->name('lecture.audio');
                Route::get('/article/audio',                   [LibraryController::class, 'article_audio'])->name('article.audio');
                Route::get('/speech/audio',                    [LibraryController::class, 'speech_audio'])->name('speech.audio');
                Route::get('/benefit/audio',                   [LibraryController::class, 'benefit_audio'])->name('benefit.audio');
                Route::get('/category/{slug}',                 [LibraryController::class, 'getAudioCategory'])->name('category');
                Route::get('/another/audio',                   [LibraryController::class, 'another_audio'])->name('another.audio');
                Route::get('/{audio}',                        [LibraryController::class, 'audio_content'])->name('audio.content');

                });
            });
            Route::get('/feed', FeedController::class)->name("feeds.main");
        }
    );
});
