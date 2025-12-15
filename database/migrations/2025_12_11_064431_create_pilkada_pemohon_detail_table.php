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
        Schema::table('pilkada_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_pemohon_id')->constrained('pilkada_pemohon')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->string('file_ktp');
            $table->timestamps();
        });

        Schema::table('pilkada_kuasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_pemohon_id')->constrained('pilkada_pemohon')->onDelete('cascade');
            $table->boolean('is_advokat')->default(false);
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->string('file_ktp');
            $table->date('tanggal_surat');
            $table->date('tanggal_kuasa');
            $table->string('nomor_anggota')->nullable();
            $table->string('nama_organisasi')->nullable();
            $table->string('file_kta')->nullable();
            $table->timestamps();
        });

        Schema::create('pilkada_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilkada_pemohon_id')->constrained('pilkada_pemohon')->onDelete('cascade');
            $table->string('nama_berkas');
            $table->string('file_path');
            $table->string('tipe_file')->nullable();
            $table->string('ukuran_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilkada_data');
        Schema::dropIfExists('pilkada_kuasa');
        Schema::dropIfExists('pilkada_berkas');
    }
};
