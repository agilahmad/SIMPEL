<?php

namespace App\Enums;

enum TypeTest: string
{
    case Pentest = 'pentest';
    case VA      = 'vulnerability_assessment';

    public function label(): string
    {
        return match($this) {
            self::Pentest => 'Pentest',
            self::VA      => 'Vulnerability Assessment',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Pentest => 'bg-soft-primary text-primary',
            self::VA      => 'bg-soft-purple text-purple',
        };
    }
}