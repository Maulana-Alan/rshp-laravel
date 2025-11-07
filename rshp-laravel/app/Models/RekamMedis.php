<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';
    public $timestamps = false; // Karena 'created_at' adalah TIMESTAMP biasa

    // Relasi: Rekam medis ini milik 1 Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    // Relasi: Rekam medis ini diperiksa oleh 1 User (Dokter)
    public function dokterPemeriksa()
    {
        return $this->belongsTo(User::class, 'dokter_pemeriksa', 'iduser');
    }
}