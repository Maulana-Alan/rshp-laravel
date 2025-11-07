<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori; // Kita butuh ini untuk dropdown
use App\Models\KategoriKlinis; // Kita butuh ini untuk dropdown
use Exception;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        $kodeTindakan = KodeTindakanTerapi::with('kategori', 'kategoriKlinis')->get();
        return view('admin.kode-tindakan.index', compact('kodeTindakan'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        // Ambil data untuk dikirim ke 2 dropdown
        $kategoris = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        
        return view('admin.kode-tindakan.create', compact('kategoris', 'kategoriKlinis'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateTindakan($request);
            $this->createTindakan($validatedData);

            return redirect()->route('admin.kode-tindakan.index')
                             ->with('success', 'Kode tindakan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validateTindakan(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan' 
                         : 'unique:kode_tindakan_terapi,kode';

        return $request->validate([
            'kode' => [
                'required',
                'string',
                'max:5',
                $uniqueRule
            ],
            'deskripsi_tindakan' => 'required|string|max:1000',
            'idkategori' => 'required|integer|exists:kategori,idkategori',
            'idkategori_klinis' => 'required|integer|exists:kategori_klinis,idkategori_klinis',
        ], [
            'kode.required' => 'Kode wajib diisi.',
            'kode.max' => 'Kode maksimal 5 karakter.',
            'kode.unique' => 'Kode ini sudah ada.',
            'deskripsi_tindakan.required' => 'Deskripsi wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
        ]);
    }

    /**
     * Helper: Simpan ke DB
     */
    protected function createTindakan(array $data)
    {
        try {
            return KodeTindakanTerapi::create([
                'kode' => $data['kode'],
                'deskripsi_tindakan' => $data['deskripsi_tindakan'],
                'idkategori' => $data['idkategori'],
                'idkategori_klinis' => $data['idkategori_klinis'],
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data tindakan: ' . $e->getMessage());
        }
    }
}