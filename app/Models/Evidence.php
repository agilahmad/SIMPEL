<?php

namespace App\Models;

use App\Enums\EvidenceStat;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    use Auditable, HasUlids;

    protected $table = 'evidences';

    protected $fillable = [
        'evidenceable_id',
        'evidenceable_type',
        'uploaded_by',
        'uploader_role',
        'file_path',
        'file_name',
        'status',
        'rejection_note',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'status'      => EvidenceStat::class,
            'approved_at' => 'datetime',
        ];
    }

    public function evidenceable()
    {
        return $this->morphTo();
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isPending(): bool  { return $this->status === EvidenceStat::Pending; }
    public function isApproved(): bool { return $this->status === EvidenceStat::Approved; }
    public function isRejected(): bool { return $this->status === EvidenceStat::Rejected; }
}
