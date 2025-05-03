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
        Schema::create('keranjang_ku_dumies', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreignId('varian_id')->constrained('produk_varian_dumies')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('member_dumies')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_ku_dumies');
    }
};
