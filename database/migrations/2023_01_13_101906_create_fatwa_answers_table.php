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
        Schema::create('fatwa_answers', function (Blueprint $table) {
            $table->id();
			$table->longText('answer')->nullable();
			$table->string('audio_file')->nullable();
            $table->string('youtube_link')->nullable();
			$table->date('publish_date');
            $table->foreignId('fatwa_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('fatwa_answers');
    }
};