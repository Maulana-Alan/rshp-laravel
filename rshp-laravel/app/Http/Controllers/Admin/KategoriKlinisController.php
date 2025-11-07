<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKlinis;
use Exception;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.kategori-klinis.index', compact('kategoriKlinis'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        return view('admin.kategori-klinis.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateKategoriKlinis($request);
            $this->createKategoriKlinis($validatedData);

            return redirect()->route('admin.kategori-klinis.index')
                             ->with('success', 'Kategori klinis berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * [cite_start]Helper: Validasi [cite: 201-219]
     */
    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis' 
                         : 'unique:kategori_klinis,nama_kategori_klinis';

        return $request->validate([
            'nama_kategori_klinis' => [
                'required',
                'string',
                'max:50',
                'min:3',
                $uniqueRule
            ],
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.min' => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis ini sudah ada.',
        ]);
    }

    /**
     * [cite_start]Helper: Simpan ke DB [cite: 225-233]
     */
    protected function createKategoriKlinis(array $data)
    {
        try {
            return KategoriKlinis::create([
                'nama_kategori_klinis' => $this->formatNama($data['nama_kategori_klinis']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data kategori klinis: ' . $e->getMessage());
        }
    }

    /**
     * [cite_start]Helper: Format Nama (Title Case) [cite: 236-239]
     */
    protected function formatNama($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}