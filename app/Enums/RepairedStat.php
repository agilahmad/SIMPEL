<?php

namespace App\Enums;

enum RepairedStat: string{
    case Belum = 'belum_dilakukan';
    case Proses = 'dalam_proses';
    case Selesai = 'selesai';

    public function color(): string
    {
        return match($this) {
            self::Belum   => 'bg-soft-danger text-danger',
            self::Proses  => 'bg-soft-warning text-warning',
            self::Selesai => 'bg-soft-success text-success',
        };
    }

        public function label(): string
    {
        return match($this) {
            self::Belum   => 'Belum Dilakukan',
            self::Proses  => 'Dalam Proses',
            self::Selesai => 'Selesai',
        };
    }
}


