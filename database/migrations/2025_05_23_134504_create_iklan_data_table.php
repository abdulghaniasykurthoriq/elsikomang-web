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
        Schema::create('advertisement_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iklan_id')->constrained('iklans')->onDelete('cascade');
            $table->string('gambar');
            $table->string('link');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('created_by')->nullable();
            $table->date('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_data');
    }
};
