<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable();
			$table->string('logo')->nullable();
			$table->string('icon')->nullable();
			$table->string('phone')->nullable();
            $table->string('women_phone')->nullable();
			$table->string('email')->nullable();
			$table->string('facebook')->nullable();
			$table->string('youtube')->nullable();
			$table->string('twitter')->nullable();
			$table->string('instagram')->nullable();
			$table->string('telegram')->nullable();
			$table->string('site_right')->nullable();
			$table->longtext('about_sheikh')->nullable();
			$table->string('keywords')->nullable();
			$table->longtext('description')->nullable();
            $table->boolean('status')->default(1);
            $table->longtext('message_maintenance')->nullable();
            $table->string('slider_image')->nullable();
            $table->string('lesson_banner')->nullable();
            $table->string('lecture_banner')->nullable();
            $table->string('article_banner')->nullable();
            $table->string('book_banner')->nullable();
            $table->string('speech_banner')->nullable();
            $table->string('benefit_banner')->nullable();
            $table->string('gallery_banner')->nullable();
            $table->string('video_banner')->nullable();
            $table->string('audio_banner')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};