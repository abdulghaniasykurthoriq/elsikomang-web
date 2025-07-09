<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saw_skors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pariwisata_id')->constrained()->onDelete('cascade');
            $table->float('skor_total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saw_skors');
    }
};
