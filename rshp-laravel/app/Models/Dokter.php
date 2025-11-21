<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokters';
    protected $primaryKey = 'id_dokter'; // Wajib set ini karena custom ID
    
    // Kolom yang boleh diisi
    protected $fillable = [
        'alamat', 
        'no_hp', 
        'bidang_dokter', 
        'jenis_kelamin', 
        'id_user'
    ];

    // Relasi: Dokter milik satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}