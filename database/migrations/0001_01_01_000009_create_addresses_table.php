<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); 
            $table->string('recipient_name'); // nama penerima
            $table->string('phone'); // nomor telepon penerima
            
            $table->string('province_id'); // id provinsi ambil dari json
            $table->string('province'); // nama provinsi
            
            $table->string('city_id'); // id kota/kabupaten dari json
            $table->string('city'); // nama kota/kabupaten
            $table->string('city_type'); //  kategori Kota/Kabupaten
            
            $table->string('postal_code')->nullable();
            $table->text('address'); // alamat lengkap 
            
            $table->timestamps();

            // foreign key user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};