<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sklnkuasa extends Model
{
    protected $table = 'skln_kuasa';

    protected $fillable = [
        'skln_id',
        'is_advokat',
        'nik',
        'nama',
        'alamat',
        'email',
        'telepon',
        'handphone',
        'tanggal_surat',
        'file_ktp',
        'nomor_anggota',
        'nama_organisasi',
        'file_kta',
    ];

    public function skln()
    {
        return $this->belongsTo(Skln::class, 'skln_id');
    }
}
