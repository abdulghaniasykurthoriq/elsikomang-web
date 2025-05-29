<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_pariwisata', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pariwisata_id');
            $table->unsignedBigInteger('fasilitas_id');

            $table->timestamps();

            // Foreign key
            $table->foreign('pariwisata_id')->references('id')->on('pariwisatas')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_pariwisata');
    }
};
