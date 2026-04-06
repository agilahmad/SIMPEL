<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CommunityReportStaging extends Model
{
    use HasUlids;

    protected $fillable = [
        'ticket_code',
        'application_name',
        'vulnerability_name',
        'severity',
        'reporting_date',
        'reporter_name',
        'file_path',
        'file_name',
        'status',
        'saved_as_incident_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (CommunityReportStaging $staging) {
            if (empty($staging->ticket_code)) {
                $staging->ticket_code = 'PUB-' . strtoupper(substr(str_replace('-', '', Str::uuid()->toString()), 0, 12));
            }
        });
    }
    public function incident()
    {
        return $this->belongsTo(Incident::class, 'saved_as_incident_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
