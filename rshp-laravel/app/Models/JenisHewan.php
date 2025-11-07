<?php
// File: app/Models/JenisHewan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHewan extends Model
{
    use HasFactory;

    // Beri tahu Laravel nama tabelnya
    protected $table = 'jenis_hewan';

    // Beri tahu Laravel apa primary key-nya
    protected $primaryKey = 'idjenis_hewan';

    // Kolom yang boleh diisi
    protected $fillable = ['nama_jenis_hewan'];

    // Kita tidak pakai timestamp (created_at, updated_at) di tabel ini
    public $timestamps = false;
}