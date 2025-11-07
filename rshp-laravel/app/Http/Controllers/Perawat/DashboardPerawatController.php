<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran; // <-- Panggil Pendaftaran
use App\Models\RekamMedis;  // <-- Panggil RekamMedis

class DashboardPerawatController extends Controller
{
    public function index()
    {
        // Ambil semua data pendaftaran
        $pendaftarans = Pendaftaran::with('pet', 'dokter', 'resepsionis')
                                    ->latest('waktu_daftar')
                                    ->get();
                                    
        // Ambil semua data rekam medis
        $rekamMedis = RekamMedis::with('pet', 'dokterPemeriksa')
                                    ->latest('created_at')
                                    ->get();

        // Kirim kedua data ke view
        return view('perawat.dashboard-perawat', compact('pendaftarans', 'rekamMedis'));
    }
}