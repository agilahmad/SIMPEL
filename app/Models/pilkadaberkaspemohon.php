<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadaberkaspemohon extends Model
{
    protected $table = 'pilkadaberkaspemohon';

    protected $fillable = [
        'pemohon_id',
        'nama_berkas',
        'file_berkas',
        'tipe_berkas',
        'is_custom',
    ];

    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'skln_id');
    }
}
