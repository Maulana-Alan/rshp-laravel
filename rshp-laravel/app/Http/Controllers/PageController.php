<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; // Import class View

class PageController extends Controller
{
    // Fungsi untuk halaman Home
    public function showHome(): View
    {
        return view('pages.home');
    }

    // Fungsi untuk halaman Layanan
    public function showLayanan(): View
    {
        return view('pages.layanan');
    }

    // Fungsi untuk halaman visi misi
    public function showVisiMisi(): View
    {
        return view('pages.visimisi');
    }
    // Fungsi untuk halaman Struktur Organisasi
    public function showStruktur(): View
    {
        return view('pages.struktur');
    }

    // Fungsi untuk halaman Login
    public function showLogin(): View
    {
        return view('pages.login');
    }

    // fungsi cek koneksi
    public function cekKoneksi()
    {
        try {
            \DB::connection()->getPdo();
            return 'Koneksi BERHASIL bosque';
        }   catch (\Exception $e) {
            return 'koneksi GAGAL BOSSS:' . $e->getMessage();
        }

    }

}