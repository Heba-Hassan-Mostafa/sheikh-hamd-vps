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
        Schema::create('videos', function (Blueprint $table) {
              $table->id();
            $table->string('name');
			$table->string('slug')->unique();
			$table->string('youtube_link')->nullable();
			$table->string('video_file')->nullable();
            $table->foreignId('video_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(1);
            $table->date('publish_date');
            $table->unsignedBigInteger('order_position')->default(0);
			$table->unsignedBigInteger('view_count')->default(0);
			$table->unsignedBigInteger('download_count')->default(0);
            $table->string('keywords');
            $table->longtext('description');
			$table->unsignedBigInteger('videoable_id')->nullable();
			$table->string('videoable_type');
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
        Schema::dropIfExists('videos');
    }
};