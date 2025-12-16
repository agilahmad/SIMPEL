<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kandidat extends Model
{
    protected $table = 'kandidats';
    protected $guarded = ['id'];

    public function paslon()
    {
        return $this->belongsTo(Paslon::class, 'paslon_id');
    }
}
