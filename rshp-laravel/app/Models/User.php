<?php
// File: app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // --- TAMBAHAN DARI MODUL ---
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    // -------------------------

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // ================================================
    // --- BAGIAN RELASI ---
    // ================================================

    /**
     * Relasi: "User ini 'punya satu' Pemilik"
     * (Dari Modul 9)
     */
    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    /**
     * Relasi: "User ini punya banyak data RoleUser"
     * (Dari Modul 10 - Untuk Login)
     */
    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    /**
     * Relasi: "User ini 'punya banyak' Role" (via tabel pivot)
     * (INI YANG KITA TAMBAHKAN KEMBALI - Untuk Halaman Admin)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->wherePivot('status', 1);
    }
}