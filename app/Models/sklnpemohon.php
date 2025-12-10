<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sklnpemohon extends Model
{
    protected $table = 'skln_pemohon';

    protected $fillable = [
        'skln_id',
        'nik',
        'nama',
        'alamat',
        'email',
        'telepon',
        'handphone',
        'file_ktp',
    ];

    public function skln()
    {
        return $this->belongsTo(Skln::class, 'skln_id');
    }
}
