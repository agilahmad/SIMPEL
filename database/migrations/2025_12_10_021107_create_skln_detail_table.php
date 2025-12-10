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
        Schema::create('skln_pemohon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skln_id')->constrained('skln')->onDelete('cascade');
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->string('file_ktp');
            $table->timestamps();
        });
        Schema::create('skln_kuasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skln_id')->constrained('skln')->onDelete('cascade');
            $table->boolean('is_advokat')->default(false);
            $table->string('nik', 16);
            $table->string('nama');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon')->nullable();
            $table->string('handphone');
            $table->date('tanggal_surat');
            $table->string('file_ktp');
            $table->string('nomor_anggota')->nullable();
            $table->string('nama_organisasi')->nullable();
            $table->string('file_kta')->nullable();
            $table->timestamps();
        });
        Schema::create('skln_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skln_id')->constrained('skln')->onDelete('cascade');
            $table->text('jenis_berkas');
            $table->text('nama_berkas');
            $table->text('path_berkas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skln_pemohon');
        Schema::dropIfExists('skln_kuasa');
        Schema::dropIfExists('skln_berkas');
    }
};
