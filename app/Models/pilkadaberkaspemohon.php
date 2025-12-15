<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadaberkaspemohon extends Model
{
    protected $table = 'pilkadaberkaspemohon';
    protected $guarded = ['id'];
    protected $fillable = [
        'pemohon_id',
        'nama_berkas',
        'file_berkas',
        'tipe_berkas',
        'ukuran_berkas',
    ];

    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'pilkada_pemohon_id');
    }
}
