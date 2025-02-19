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
        Schema::create('audioes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
			$table->string('slug')->unique();
			$table->string('embed_link')->nullable();
			$table->string('audio_file')->nullable();
            $table->foreignId('audio_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('status')->default(1);
            $table->date('publish_date');
            $table->unsignedBigInteger('order_position')->default(0);
			$table->unsignedBigInteger('view_count')->default(0);
			$table->unsignedBigInteger('download_count')->default(0);
            $table->string('keywords');
            $table->longtext('description');
			$table->unsignedBigInteger('audioable_id')->nullable();
			$table->string('audioable_type');

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
        Schema::dropIfExists('audioes');
    }
};