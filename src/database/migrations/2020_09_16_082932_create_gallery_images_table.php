<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->default(0);
            $table->string('item_type', 30)->nullable();
            $table->integer('item_id')->default(0);
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail_120')->nullable();
            $table->string('thumbnail_300')->nullable();
            $table->string('thumbnail_500')->nullable();
            $table->string('thumbnail_720')->nullable();
            $table->integer('image_width')->default(0);
            $table->integer('image_height')->default(0);
            $table->decimal('image_ratio', 5, 2)->default(0);

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
        Schema::dropIfExists('gallery_images');
    }
}
