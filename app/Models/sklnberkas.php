<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sklnberkas extends Model
{
    protected $table = 'skln_berkas';

    protected $fillable = [
        'skln_id',
        'jenis_berkas',
        'nama_berkas',
        'path_berkas',
    ];

    public function skln()
    {
        return $this->belongsTo(Skln::class, 'skln_id');
    }
}
