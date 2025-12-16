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
        Schema::create('pilkada_terkait_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_terkait_id')->constrained('pilkada_terkait')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->string('file_ktp');
            $table->timestamps();
        });

        Schema::create('pilkada_terkait_kuasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_terkait_id')->constrained('pilkada_terkait')->onDelete('cascade');
            $table->boolean('is_advokat')->default(true);
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->string('file_ktp');
            $table->date('tanggal_surat');
            $table->string('nomor_anggota')->nullable();
            $table->string('nama_organisasi')->nullable();
            $table->string('file_kta')->nullable();
            $table->timestamps();
        });

        Schema::create('pilkada_terkait_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_terkait_id')->constrained('pilkada_terkait')->onDelete('cascade');
            $table->string('nama_berkas');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilkada_terkait_data');
        Schema::dropIfExists('pilkada_terkait_kuasa');
        Schema::dropIfExists('pilkada_terkait_berkas');
    }
};
