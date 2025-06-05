<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsImagesTable extends Migration
{
    public function up()
    {
        Schema::create('about_us_images', function (Blueprint $table) {
            $table->id();
            $table->string('header_image')->nullable();
            $table->string('series_image_1')->nullable();
            $table->string('series_image_2')->nullable();
            $table->string('series_image_3')->nullable();
            $table->string('series_image_4')->nullable();
            $table->string('why_image_1')->nullable();
            $table->string('why_image_2')->nullable();
            $table->string('why_image_3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('about_us_images');
    }
}
