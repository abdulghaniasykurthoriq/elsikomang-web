<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_normalisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pariwisata_id')->constrained()->onDelete('cascade');
            $table->string('kriteria');
            $table->float('nilai_normalisasi');
            $table->string('rumus')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_normalisasis');
    }
};
