<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_voucher')->unique(); // Contoh: DISKON10
            $table->string('nama_voucher');           // Nama yang bisa dibaca admin
            $table->enum('tipe_diskon', ['persen', 'nominal']); // Diskon dalam persen atau rupiah
            $table->decimal('nilai_diskon', 10, 2);   // Nilai diskonnya
            $table->decimal('minimum_transaksi', 12, 2)->default(0); // Minimal pembelian
            $table->decimal('maks_diskon', 12, 2)->nullable(); // Batas dmaksimal diskon jika persen
            $table->integer('kuota')->default(0);     // Berapa kali bisa dipakai
            $table->date('tanggal_mulai');            // Mulai berlaku
            $table->date('tanggal_berakhir');         // Berakhir
            $table->boolean('is_aktif')->default(true); // Status aktif / tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};