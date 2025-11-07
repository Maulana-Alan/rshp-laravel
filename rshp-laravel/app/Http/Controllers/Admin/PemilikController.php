<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User; // <-- Panggil Model User
use App\Models\RoleUser; // <-- Panggil Model RoleUser
use Illuminate\Support\Facades\Hash; // <-- Panggil Hash
use Illuminate\Support\Facades\DB; // <-- Panggil DB Transaction
use Exception;

class PemilikController extends Controller
{
    public function index()
    {
        $pemilik = Pemilik::with('user')->get();
        return view('admin.pemilik.index', compact('pemilik'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        return view('admin.pemilik.create');
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input (User & Pemilik)
        $validatedData = $this->validatePemilik($request);

        // 2. Mulai Transaksi Database
        // Ini untuk memastikan jika salah satu gagal, semua dibatalkan
        DB::beginTransaction();
        try {
            
            // 3. Buat User baru dulu
            $user = User::create([
                'nama' => $this->formatNama($validatedData['nama']),
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // 4. Set Role untuk User baru (ID 5 = Pemilik)
            RoleUser::create([
                'iduser' => $user->iduser,
                'idrole' => 5, // ID 5 adalah Pemilik
                'status' => 1
            ]);

            // 5. Buat Pemilik baru dan hubungkan dengan User
            Pemilik::create([
                'iduser' => $user->iduser,
                'no_wa' => $validatedData['no_wa'],
                'alamat' => $validatedData['alamat'],
            ]);

            // 6. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('admin.pemilik.index')
                             ->with('success', 'Pemilik baru berhasil ditambahkan.');

        } catch (Exception $e) {
            // 7. Jika ada error, batalkan semua (rollback)
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validatePemilik(Request $request, $id = null)
    {
        $user_id = null;
        if($id){
            // Nanti untuk logic update
        }

        return $request->validate([
            // Validasi User
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $user_id . ',iduser',
            'password' => 'required|string|min:8|confirmed',
            // Validasi Pemilik
            'no_wa' => 'required|string|max:45|unique:pemilik,no_wa,' . $id . ',idpemilik',
            'alamat' => 'required|string|max:100',
        ], [
            // Pesan error kustom
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'no_wa.required' => 'No. WhatsApp wajib diisi.',
            'no_wa.unique' => 'No. WhatsApp ini sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);
    }

    /**
     * Helper: Format Nama (Title Case)
     */
    protected function formatNama($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}