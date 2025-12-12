<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\SklnPemohon;
use App\Models\SklnKuasa;
use App\Models\SklnBerkas;

class skln extends Model
{
    use HasFactory;

    protected $table = 'skln';

    protected $fillable = [
        'user_id',
        'nomor',
        'pokok_permohonan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function skln_pemohon()
    {
        return $this->hasMany(SklnPemohon::class, 'skln_id');
    }
    public function skln_kuasa()
    {
        return $this->hasMany(SklnKuasa::class, 'skln_id');
    }
    public function skln_berkas()
    {
        return $this->hasMany(SklnBerkas::class, 'skln_id');
    }
}
