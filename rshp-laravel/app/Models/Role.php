<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'idrole';
    protected $fillable = ['nama_role'];
    public $timestamps = false;

    // Relasi: "Role ini 'dimiliki oleh banyak' User"
        public function users()
        {
            return $this->belongsToMany(User::class, 'role_user', 'idrole', 'iduser')
                        ->wherePivot('status', 1); // Hanya ambil user yang statusnya 1 (Aktif)
        }
}

