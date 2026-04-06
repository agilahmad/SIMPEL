<?php

namespace App\Models;

use App\Enums\TypeTest;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory, Auditable, HasUlids;
    protected $guarded = ['id'];

    protected $fillable = [
        'application_name',
        'programmer_id',
    ];

    public function programmer(): BelongsTo{
        return $this->belongsTo(User::class, 'programmer_id');
    }

    public function pentests(): HasMany{
        return $this->hasMany(Pentest::class);
    }

    public function incidents(): HasMany{
        return $this->hasMany(Incident::class);
    }

    public function vas()
    {
        return $this->hasMany(Pentest::class)->where('type', TypeTest::VA->value);
    }
}
