<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pariwisatas', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            $table->string('alamat')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->enum('kategori', ['pantai', 'hutan', 'religi', 'budaya', 'kuliner', 'edukasi', 'buatan'])->default('pantai');

            $table->integer('harga_tiket');
            $table->decimal('rating', 3, 2)->default(0);

            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pariwisatas');
    }
};
