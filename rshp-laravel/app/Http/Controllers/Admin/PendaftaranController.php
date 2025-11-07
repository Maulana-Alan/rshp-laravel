<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftaran; // Panggil Model

class PendaftaranController extends Controller
{
    public function index()
    {
        // Ambil semua data pendaftaran
        $pendaftarans = Pendaftaran::with('pet', 'dokter', 'resepsionis')
                                    ->latest('waktu_daftar')
                                    ->get();

        // Arahkan ke view baru yang akan kita buat
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }
}