<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saw_kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // ex: 'harga_tiket'
            $table->string('label'); // ex: 'Harga Tiket'
            $table->enum('tipe', ['cost', 'benefit']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('saw_kriterias');
    }
};
