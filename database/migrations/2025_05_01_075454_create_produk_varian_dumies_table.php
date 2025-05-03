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
        Schema::create('produk_varian_dumies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_varian');
            $table->unsignedBigInteger('harga');
            $table->string('stok');
            $table->foreignId('produk_id')->constrained('produk_dumies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_varian_dumies');
    }
};
