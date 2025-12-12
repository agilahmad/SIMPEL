<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadadatapemohon extends Model
{
    protected $table = 'pilkadadatapemohon';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'email',
        'telepon',
        'handphone',
        'file_ktp',
    ];

    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'skln_id');
    }
}
