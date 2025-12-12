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
            $table->foreignId('pilkada_id')->constrained('pilkada_id')->onDelete('cascade');
            $table->string('jenis_pemilihan');
            $table->string('nama_provinsi');
            $table->string('nama_daerah');
            $table->string('no_urut');
            $table->string('pokok_permohonan')->nullable();
            $table->string('status')->default('draft');
            $table->string('no_regis')->nullable();
            $table->date('tanggal_pengajuan')->nullable();
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
