<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadakuasapemohon extends Model
{
    protected $table = 'pilkadakuasapemohon';

    protected $fillable = [
        'is_advocat',
        'nik',
        'nama',
        'alamat',
        'email',
        'telepon',
        'handphone',
        'file_ktp',
        'tanggal_surat',
        'nomor_anggota',
        'nama_organisasi',
        'file_kta',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'is_advocat' => 'boolean',
    ];

    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'skln_id');
    }

}
