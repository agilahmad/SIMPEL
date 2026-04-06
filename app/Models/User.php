<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUlids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => Role::class,
            'email_verified_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool{
        return $this->role === Role::Admin;
    }
    public function isProgrammer(): bool{
        return $this->role === Role::Programmer;
    }
    public function isUser(): bool{
        return $this->role === Role::User;
    }

    public function applications(): HasMany{
        return $this->hasMany(Application::class);
    }

    public function pentestsCreated(): HasMany{
        return $this->hasMany(Pentest::class, 'created_by');
    }

    public function incidentsPic(): HasMany{
        return $this->hasMany(Incident::class, 'pic_id');
    }

    public function incidentsCreated(){
        return $this->hasMany(Incident::class, 'created_by');
    }

    public function incidentsReporter(): HasMany{
        return $this->hasMany(Incident::class, 'reporter_id');
    }
}
