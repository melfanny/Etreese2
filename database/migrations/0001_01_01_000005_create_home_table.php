<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->string('upcoming_image_1')->nullable();
            $table->string('upcoming_image_2')->nullable();
            $table->string('upcoming_image_3')->nullable();
            $table->string('upcoming_image_4')->nullable();
            $table->string('what_image_1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home');
    }
};
