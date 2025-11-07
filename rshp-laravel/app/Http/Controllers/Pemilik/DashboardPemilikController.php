<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik; // <-- Panggil Model Pemilik
use App\Models\Pet;     // <-- Panggil Model Pet

class DashboardPemilikController extends Controller
{
    public function index()
    {
        // 1. Dapatkan ID user yang sedang login dari session
        $iduser_login = session('user_id');

        // 2. Cari data 'pemilik' berdasarkan 'iduser' yang login
        $pemilik = Pemilik::where('iduser', $iduser_login)->first();

        $pets = []; // Buat array kosong by default

        // 3. Jika data pemilik ditemukan, cari semua pet miliknya
        if ($pemilik) {
            $pets = Pet::with('rasHewan') // Ambil juga relasi RasHewan
                       ->where('idpemilik', $pemilik->idpemilik)
                       ->get();
        }

        // 4. Kirim data 'pets' ke view
        return view('pemilik.dashboard-pemilik', compact('pets'));
    }
}