<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laporan_pariwisatas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('periode', ['harian', 'bulanan', 'tahunan']);
            $table->string('nama_wisata');
            $table->unsignedInteger('jumlah_viewer');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pariwisatas');
    }
};
