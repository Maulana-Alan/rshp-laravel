<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // --- KONFIGURASI TABEL KHUSUS ---
    protected $table = 'user';      // Nama tabel di database (bukan 'users')
    protected $primaryKey = 'iduser'; // Primary key custom (bukan 'id')
    // --------------------------------

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
     */
    public function pemilik()
    {
        return $this->hasOne(Pemilik::class, 'iduser', 'iduser');
    }

    /**
     * Relasi: "User ini punya banyak data RoleUser"
     */
    public function roleUser()
    {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

    /**
     * Relasi: "User ini 'punya banyak' Role" (via tabel pivot role_user)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole')
                    ->wherePivot('status', 1);
    }

    /**
     * Relasi: User ini adalah seorang Dokter (One to One)
     * FK: id_user (di tabel dokters), LK: iduser (di tabel user)
     */
    public function dokterData()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'iduser');
    }

    /**
     * Relasi: User ini adalah seorang Perawat (One to One)
     * FK: id_user (di tabel perawats), LK: iduser (di tabel user)
     */
    public function perawatData()
    {
        return $this->hasOne(Perawat::class, 'id_user', 'iduser');
    }
}