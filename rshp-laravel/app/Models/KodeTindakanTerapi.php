<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeTindakanTerapi extends Model
{
    use HasFactory;

    protected $table = 'kode_tindakan_terapi';
    protected $primaryKey = 'idkode_tindakan';
    protected $fillable = [
        'kode', 
        'deskripsi_tindakan', 
        'idkategori', 
        'idkategori_klinis'
    ];
    public $timestamps = false;

    // Relasi: "Tindakan ini 'milik' satu Kategori"
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'idkategori', 'idkategori');
    }

    // Relasi: "Tindakan ini 'milik' satu KategoriKlinis"
    public function kategoriKlinis()
    {
        return $this->belongsTo(KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
    }
}   