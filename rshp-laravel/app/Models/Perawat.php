<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    use HasFactory;

    protected $table = 'perawats';
    protected $primaryKey = 'id_perawat'; // Wajib set ini
    
    // Kolom yang boleh diisi
    protected $fillable = [
        'alamat', 
        'no_hp', 
        'jenis_kelamin', 
        'pendidikan', 
        'id_user'
    ];

    // Relasi: Perawat milik satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}