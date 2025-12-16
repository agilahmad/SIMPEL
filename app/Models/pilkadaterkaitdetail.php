<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pilkadaterkaitdetail extends Model
{
    protected $table = 'pilkadaterkaitdetail';
    protected $guarded = ['id'];
    
    public function pilkadaterkait()
    {
        return $this->belongsTo(PilkadaTerkait::class, 'pilkada_terkait_id');
    }
}
