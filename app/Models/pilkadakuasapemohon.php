<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadakuasapemohon extends Model
{
    protected $table = 'pilkadakuasapemohon';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_surat' => 'date',
        'is_advocat' => 'boolean',
    ];
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

    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'pilkada_pemohon_id');
    }

}
