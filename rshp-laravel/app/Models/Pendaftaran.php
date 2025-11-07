<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'idpendaftaran';
    // Kita matikan timestamp default Laravel (created_at, updated_at)
    public $timestamps = false; 

    // Relasi: Pendaftaran ini milik 1 Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    // Relasi: Pendaftaran ini ditangani 1 User (Dokter)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'iduser_dokter', 'iduser');
    }

    // Relasi: Pendaftaran ini dibuat oleh 1 User (Resepsionis)
    public function resepsionis()
    {
        return $this->belongsTo(User::class, 'iduser_resepsionis', 'iduser');
    }
}