<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dokter;
use App\Models\Perawat;

class ProfileController extends Controller
{
    /**
     * Tampilkan Form Edit Profil
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Ambil data dokter/perawat jika sudah ada sebelumnya
        $dokterData = $user->dokterData;
        $perawatData = $user->perawatData;

        return view('profile.edit', compact('user', 'dokterData', 'perawatData'));
    }

    /**
     * Simpan Data Profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $role = $user->roles->first()->nama_role ?? ''; // Asumsi nama kolom di tabel role adalah 'nama_role'

        // 1. LOGIKA UNTUK DOKTER
        // Cek apakah role user mengandung kata 'dokter' (case insensitive)
        if (stripos($role, 'dokter') !== false) {
            
            $request->validate([
                'alamat' => 'required',
                'no_hp' => 'required',
                'bidang_dokter' => 'required',
                'jenis_kelamin' => 'required',
            ]);

            // Pakai updateOrCreate: Kalau ada diupdate, kalau belum ada dibuat baru
            Dokter::updateOrCreate(
                ['id_user' => $user->iduser], // Kunci pencarian
                [
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'bidang_dokter' => $request->bidang_dokter,
                    'jenis_kelamin' => $request->jenis_kelamin,
                ]
            );
        }

        // 2. LOGIKA UNTUK PERAWAT
        // Cek apakah role user mengandung kata 'perawat'
        elseif (stripos($role, 'perawat') !== false) {
            
            $request->validate([
                'alamat' => 'required',
                'no_hp' => 'required',
                'jenis_kelamin' => 'required',
                'pendidikan' => 'required',
            ]);

            Perawat::updateOrCreate(
                ['id_user' => $user->iduser], // Kunci pencarian
                [
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'pendidikan' => $request->pendidikan,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data profil berhasil disimpan!');
    }
}