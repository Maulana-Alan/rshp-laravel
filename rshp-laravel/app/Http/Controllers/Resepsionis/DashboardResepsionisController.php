<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran; // <-- Panggil Model Pendaftaran

class DashboardResepsionisController extends Controller
{
    public function index()
    {
        // Ambil data Pendaftaran, urutkan dari yang terbaru
        // Ambil juga relasi: pet, dokter, dan resepsionis
        $pendaftarans = Pendaftaran::with('pet', 'dokter', 'resepsionis')
                                    ->latest('waktu_daftar') // Urutkan dari terbaru
                                    ->get();

        return view('resepsionis.dashboard-resepsionis', compact('pendaftarans'));
    }
}