<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tourism_sites', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            $table->string('alamat')->nullable();

            $table->enum('kategori', ['pantai', 'religi', 'budaya', 'kuliner', 'edukasi', 'buatan'])->default('pantai');

            $table->integer('harga_tiket');
            $table->decimal('rating', 3, 2)->default(0);

            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tourism_sites');
    }
};
