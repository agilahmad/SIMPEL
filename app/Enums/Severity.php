<?php
namespace App\Enums;

enum Severity: string{
    case Critical = 'critical';
    case High = 'high';
    case Medium = 'medium';
    case Low = 'low';
    case Info = 'informational';

    public function color(): string {
        return match($this){
            self::Critical => 'danger',
            self::High => 'warning',
            self::Medium => 'primary',
            self::Low => 'info',
            self::Info => 'secondary',
        };
    }
    public function label(): string {
        return match($this){
            self::Critical => 'Critical',
            self::High => 'High',
            self::Medium => 'Medium',
            self::Low => 'Low',
            self::Info => 'Informational',
        };
    }
}
