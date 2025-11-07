<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Exception;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateKategori($request);
            $this->createKategori($validatedData);

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validateKategori(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kategori,nama_kategori,' . $id . ',idkategori' 
                         : 'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'min:3',
                $uniqueRule
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.unique' => 'Nama kategori ini sudah ada.',
        ]);
    }

    /**
     * Helper: Simpan ke DB
     */
    protected function createKategori(array $data)
    {
        try {
            return Kategori::create([
                'nama_kategori' => $this->formatNama($data['nama_kategori']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data kategori: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Format Nama (Title Case)
     */
    protected function formatNama($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}