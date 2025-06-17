<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukVariantsTable extends Migration
{
    public function up(): void
    {
        Schema::create('produk_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_umkm_id')->constrained('produk_umkm')->onDelete('cascade');
            $table->string('varian');
            $table->integer('berat')->default(0);
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_variants');
    }
}
