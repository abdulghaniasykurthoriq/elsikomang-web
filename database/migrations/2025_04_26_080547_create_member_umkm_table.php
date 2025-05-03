<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberUmkmTable extends Migration
{
    public function up()
    {
        Schema::create('member_umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('foto_toko')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('member_umkm');
    }
};
