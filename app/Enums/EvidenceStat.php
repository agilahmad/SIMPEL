<?php

namespace App\Enums;

enum EvidenceStat: string{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function color(): string
    {
        return match($this) {
            self::Pending   => 'bg-soft-danger text-danger',
            self::Approved  => 'bg-soft-success text-success',
            self::Rejected => 'bg-soft-warning text-warning',
        };
    }

        public function label(): string
    {
        return match($this) {
            self::Pending   => 'Pending',
            self::Approved  => 'Approved',
            self::Rejected => 'Rejected',
        };
    }
}
