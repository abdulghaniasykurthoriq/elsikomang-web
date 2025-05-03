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
        Schema::create('produk_umkm', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('nama_produk');
            $table->string('kategori_id');
            $table->string('deskripsi');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('produk_umkm');
    }
};
