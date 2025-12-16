<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadaterkait extends Model
{
    protected $table = 'pilkadaterkait';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pilkadapemohon()
    {
        return $this->belongsTo(PilkadaPemohon::class, 'pilkada_pemohon_id');
    }
    public function pilkadaterkaitdetail()
    {
        return $this->hasMany(PilkadaTerkaitDetail::class, 'pilkada_terkait_id');
    }
    public function paslon()
    {
        return $this->belongsTo(Paslon::class, 'paslon_id');
    }
    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class, 'kandidat_id');
    }
    public function pilkadaterkaitberkas()
    {
        return $this->hasMany(PilkadaTerkaitBerkas::class, 'pilkada_terkait_id');
    }
    public function pilkadaterkaitkuasa()
    {
        return $this->hasMany(PilkadaTerkaitKuasa::class, 'pilkada_terkait_id');
    }
}
