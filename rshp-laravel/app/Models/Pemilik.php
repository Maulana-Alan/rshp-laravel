<?php
// File: app/Models/Pemilik.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    use HasFactory;

    protected $table = 'pemilik';

    protected $primaryKey = 'idpemilik';

    // Kolom yang boleh diisi
    protected $fillable = ['no_wa', 'alamat', 'iduser'];

    // Relasi: "Pemilik ini 'milik' satu User"
    public function user()
    {
        // 'iduser' adalah foreign key di tabel 'pemilik'
        // 'iduser' adalah primary key di tabel 'user'
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    public $timestamps = false;
}