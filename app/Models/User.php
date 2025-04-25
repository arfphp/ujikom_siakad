<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'user_id');
    }

    const ROLE_DOSEN = 'dosen';
    const ROLE_MAHASISWA = 'mahasiswa';
    const ROLE_ADMIN = 'admin';
    const ROLE_DEFAULT = self::ROLE_MAHASISWA;

    const ROLES = [
        self::ROLE_DOSEN => 'dosen',
        self::ROLE_MAHASISWA => 'mahasiswa',
        self::ROLE_ADMIN => 'admin',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function isAdmin(){
        return $this->role === self::ROLE_ADMIN;
    }

    public function isDosen(){
        return $this->role === self::ROLE_DOSEN;
    }

    public function isDefault(){
        return $this->role === self::ROLE_MAHASISWA;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
