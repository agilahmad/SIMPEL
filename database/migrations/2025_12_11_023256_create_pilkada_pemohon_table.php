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
        Schema::create('pilkada_pemohon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('jenis_pemilihan', ['gubernur', 'walikota', 'bupati']);
            $table->foreignId('id_provinsi');
            $table->foreignId('id_daerah')->nullable();
            $table->foreignId('no_urut');
            $table->string('pokok_permohonan')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilkada_pemohon');
    }
};
