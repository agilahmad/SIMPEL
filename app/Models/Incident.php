<?php

namespace App\Models;

use App\Enums\IncidentType;
use App\Enums\RepairedStat;
use App\Enums\Severity;
use App\Models\Evidence;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Incident extends Model
{
    use HasFactory, Auditable, HasUlids;

    protected $fillable = [
        'ticket_code',
        'application_id',
        'application_name',
        'type',
        'reporter_name',
        'pic_id',
        'reporting_date',
        'vulnerability_name',
        'severity',
        'repaired_status',
        'repaired_date',
        'created_by',
    ];

    protected static function booted() {
        static::creating(function (Incident $incident) {
            if(empty($incident->ticket_code)){
                $incident->ticket_code = 'TIK-' . strtoupper(substr(str_replace('-', '', Str::uuid()->toString()), 0, 12));
            }
            if (!isset($incident->getRawOriginal()['created_by']) && auth()->check()) {
            $incident->created_by = auth()->id();
            }
            if (empty($incident->repaired_status)) {
                $incident->repaired_status = RepairedStat::Belum->value;
            }
        });
    }

    public function casts(): array {
        return [
            'type'              => IncidentType::class,
            'severity'          => Severity::class,
            'repaired_status'   => RepairedStat::class,
            'reporting_date'    => 'date',
            'repaired_date'    => 'date',
        ];
    }
    public function application(){
        return $this->belongsTo(Application::class);
    }

    public function pic(){
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function reporter() {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userEvidences(){
    return $this->morphMany(Evidence::class, 'evidenceable')
        ->where('uploader_role', 'user')->latest();
    }

    public function programmerEvidences(){
    return $this->morphMany(Evidence::class, 'evidenceable')
        ->where('uploader_role', 'programmer')->latest();
    }

    public function evidences()
    {
        return $this->morphMany(Evidence::class, 'evidenceable')->latest();
    }


}
