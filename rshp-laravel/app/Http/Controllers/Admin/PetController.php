<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Pemilik; // Kita butuh ini untuk dropdown
use App\Models\RasHewan; // Kita butuh ini untuk dropdown
use Exception;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('pemilik.user', 'rasHewan')->get();
        return view('admin.pet.index', compact('pets'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        // Ambil data untuk dikirim ke 2 dropdown
        $pemiliks = Pemilik::with('user')->get();
        $rasHewans = RasHewan::with('jenisHewan')->get();
        
        return view('admin.pet.create', compact('pemiliks', 'rasHewans'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validatePet($request);
            $this->createPet($validatedData);

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Pet berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validatePet(Request $request, $id = null)
    {
        return $request->validate([
            'idpemilik' => 'required|integer|exists:pemilik,idpemilik',
            'idras_hewan' => 'required|integer|exists:ras_hewan,idras_hewan',
            'nama' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|string|in:J,B', // Hanya boleh J atau B
            'warna_tanda' => 'nullable|string|max:45',
        ], [
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
            'nama.required' => 'Nama pet wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh di masa depan.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);
    }

    /**
     * Helper: Simpan ke DB
     */
    protected function createPet(array $data)
    {
        try {
            return Pet::create([
                'idpemilik' => $data['idpemilik'],
                'idras_hewan' => $data['idras_hewan'],
                'nama' => $this->formatNama($data['nama']),
                'tanggal_lahir' => $data['tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'warna_tanda' => $data['warna_tanda'] ?? null,
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data pet: ' . $e->getMessage());
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