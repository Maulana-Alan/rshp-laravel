<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;
use App\Models\JenisHewan; // Kita butuh ini untuk dropdown
use Exception;

class RasHewanController extends Controller
{
    public function index()
    {
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('admin.ras-hewan.index', compact('rasHewan'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        // Ambil data Jenis Hewan untuk dikirim ke dropdown
        $jenisHewans = JenisHewan::all(); 
        return view('admin.ras-hewan.create', compact('jenisHewans'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRasHewan($request);
            $this->createRasHewan($validatedData);

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validateRasHewan(Request $request, $id = null)
    {
        // Aturan validasi
        $rules = [
            'idjenis_hewan' => 'required|integer|exists:jenis_hewan,idjenis_hewan',
            'nama_ras' => [
                'required',
                'string',
                'max:100',
                'min:2',
                // Cek unique berdasarkan DUA kolom (nama_ras DAN idjenis_hewan)
                'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan,idjenis_hewan,' . $request->idjenis_hewan
            ],
        ];

        // Pesan error kustom
        $messages = [
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'nama_ras.min' => 'Nama ras minimal 2 karakter.',
            'nama_ras.unique' => 'Nama ras ini sudah ada untuk jenis hewan tersebut.',
        ];

        return $request->validate($rules, $messages);
    }

    /**
     * Helper: Simpan ke DB
     */
    protected function createRasHewan(array $data)
    {
        try {
            return RasHewan::create([
                'nama_ras' => $this->formatNama($data['nama_ras']),
                'idjenis_hewan' => $data['idjenis_hewan'],
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data ras hewan: ' . $e->getMessage());
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