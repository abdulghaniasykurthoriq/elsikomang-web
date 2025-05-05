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
        Schema::create('keranjang_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keranjang_id')->constrained()->onDelete('cascade');
            $table->foreignId('produk_umkm_id')->constrained('produk_umkm')->onDelete('cascade');
            $table->foreignId('produk_variant_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_details');
    }
};
