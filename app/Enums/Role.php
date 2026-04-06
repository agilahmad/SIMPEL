<?php

namespace App\Enums;

enum Role: string{
    case Admin = 'admin';
    case Programmer = 'programmer';
    case User = 'user';

    public function label(): string{
        return match($this){
            self::Admin => 'admin',
            self::Programmer => 'programmer',
            self::User => 'user',
        };
    }
}
