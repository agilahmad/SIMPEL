<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paslon extends Model
{
    protected $table = 'paslons';
    protected $guarded = ['id'];

    public function kandidat()
    {
        return $this->hasMany(Kandidat::class, 'paslon_id');
    }
}
