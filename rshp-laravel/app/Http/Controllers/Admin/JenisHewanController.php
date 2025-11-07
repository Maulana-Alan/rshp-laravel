<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisHewan;
use Exception; // Tambahkan ini untuk menangani error

class JenisHewanController extends Controller
{
    /**
     * Menampilkan daftar semua jenis hewan.
     */
    public function index()
    {
        $jenisHewan = JenisHewan::all();
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    /**
     * Menampilkan form untuk menambah data baru.
     * [cite_start][Sesuai Modul 11, Halaman 3] [cite: 97-99]
     */
    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    /**
     * Menyimpan data baru ke database.
     * [cite_start][Sesuai Modul 11, Halaman 3] [cite: 100-109]
     */
    public function store(Request $request)
    {
        try {
            // 1. Validasi input
            $validatedData = $this->validateJenisHewan($request);

            // 2. Simpan data menggunakan helper
            $this->createJenisHewan($validatedData);

            // 3. Redirect kembali ke index dengan pesan sukses
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil ditambahkan.');

        } catch (Exception $e) {
            // Jika terjadi error, kembali ke form dengan pesan error
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Bagian B: Validasi
     * [cite_start][Sesuai Modul 11, Halaman 4] [cite: 122-140]
     */
    protected function validateJenisHewan(Request $request, $id = null)
    {
        // Aturan 'unique' akan mengabaikan $id jika ada (untuk edit nanti)
        $uniqueRule = $id ? 'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan' 
                         : 'unique:jenis_hewan,nama_jenis_hewan';

        // Validasi data input
        return $request->validate([
            'nama_jenis_hewan' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ],
        ], [
            // Pesan error kustom
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.min' => 'Nama jenis hewan minimal 3 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan ini sudah ada.',
        ]);
    }

    /**
     * Bagian C: Helper untuk menyimpan data
     * [cite_start][Sesuai Modul 11, Halaman 4] [cite: 146-155]
     */
    protected function createJenisHewan(array $data)
    {
        try {
            return JenisHewan::create([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data jenis hewan: ' . $e->getMessage());
        }
    }

    /**
     * Bagian C: Helper untuk format nama (Title Case)
     * [cite_start][Sesuai Modul 11, Halaman 4] [cite: 157-160]
     */
    protected function formatNamaJenisHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}