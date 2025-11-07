<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran; // <-- Panggil Pendaftaran
use App\Models\RekamMedis;  // <-- Panggil RekamMedis

class DashboardDokterController extends Controller
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

        return view('dokter.dashboard-dokter', compact('pendaftarans', 'rekamMedis'));
    }
}