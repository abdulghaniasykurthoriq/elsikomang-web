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
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provinsi_id')->nullable();;
            $table->unsignedBigInteger('kota_id')->nullable();;
            $table->unsignedBigInteger('kecamatan_id')->nullable(); 
            $table->foreignId('desa_id')->constrained()->onDelete('cascade');
            $table->string('kode_pos')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->text('detail')->nullable(); // Alamat lengkap: jalan, RT, RW, dsb.
            $table->string('kota')->nullable(); // Nama kota/kabupaten
            $table->string('kecamatan')->nullable(); // Nama kecamatan
            $table->boolean('default')->default(false); // Apakah alamat utama
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
