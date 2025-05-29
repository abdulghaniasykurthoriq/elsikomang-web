<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pariwisata_ratings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pariwisata_id');
            $table->decimal('rating', 2, 1); // misal: 4.5, 3.0, dst.

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pariwisata_id')->references('id')->on('pariwisatas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pariwisata_ratings');
    }
};
