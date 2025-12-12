<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pilkadapemohon extends Model
{
    use HasFactory;

    protected $table = 'pilkada_pemohon';

    protected $fillable = [
        'user_id',
        'jenis_pemilihan',
        'nama_provinsi',
        'nama_daerah',
        'no_urut',
        'pokok_permohonan',
        'status',
        'no_regis',
        'tanggal_pengajuan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pilkadadatapemohon()
    {
        return $this->hasMany(PilkadaDatapemohon::class);
    }
    public function pilkadakuasapemohon()
    {
        return $this->hasMany(PilkadaKuasaPemohon::class);
    }

    public function pilkadaberkaspemohon()
    {
        return $this->hasMany(PilkadaBerkasPemohon::class);
    }

}
