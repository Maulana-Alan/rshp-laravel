<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role; // <-- Panggil Model Role
use Illuminate\Support\Facades\Hash; // <-- Panggil Hash
use Illuminate\Support\Facades\DB; // <-- Panggil DB Transaction
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        // Ambil data Role untuk dikirim ke checkboxes
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Menyimpan data baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input (User & Roles)
        $validatedData = $this->validateUser($request);

        // 2. Mulai Transaksi Database
        DB::beginTransaction();
        try {
            
            // 3. Buat User baru dulu
            $user = User::create([
                'nama' => $this->formatNama($validatedData['nama']),
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // 4. Attach Roles ke User baru
            // Kita siapkan data 'status' = 1 untuk tabel pivot
            $rolesToSync = [];
            foreach ($validatedData['roles'] as $roleId) {
                $rolesToSync[$roleId] = ['status' => 1];
            }
            $user->roles()->sync($rolesToSync);

            // 5. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('admin.user.index')
                             ->with('success', 'User baru berhasil ditambahkan.');

        } catch (Exception $e) {
            // 6. Jika ada error, batalkan semua (rollback)
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Helper: Validasi
     */
    protected function validateUser(Request $request, $id = null)
    {
        return $request->validate([
            // Validasi User
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . $id . ',iduser',
            'password' => 'required|string|min:8|confirmed',
            // Validasi Roles
            'roles' => 'required|array|min:1',
            'roles.*' => 'integer|exists:role,idrole', // Cek setiap item di array roles
        ], [
            // Pesan error kustom
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required' => 'Minimal satu role wajib dipilih.',
            'roles.min' => 'Minimal satu role wajib dipilih.',
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