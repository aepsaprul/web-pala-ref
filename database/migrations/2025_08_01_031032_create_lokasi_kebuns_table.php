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
        Schema::create('lokasi_kebuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_user_id')->constrained('users');
            $table->string('nama_lokasi');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_kebuns');
    }
};
