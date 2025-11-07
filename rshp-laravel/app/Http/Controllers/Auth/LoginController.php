<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Menampilkan form login (sesuai modul).
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Meng-handle proses login (sesuai modul).
     */
public function login(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Cari user berdasarkan email
        $user = User::with(['roleUser' => function($query) {
            $query->where('status', 1);
        }, 'roleUser.role'])
        ->where('email', $request->input('email'))
        ->first();

        // 3. Cek apakah user ada
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput();
        }

        // 4. Cek password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        // 5. Cek jika user tidak punya role aktif
        if ($user->roleUser->isEmpty()) {
            return redirect()->back()
                ->withErrors(['email' => 'Akun Anda tidak memiliki role aktif.'])
                ->withInput();
        }
        
        // 6. Ambil role (sesuai logika modul)
        $activeRole = $user->roleUser[0];
        $namaRole = Role::where('idrole', $activeRole->idrole ?? null)->first();

        // 7. Login-kan user
        Auth::login($user);

        // 8. Simpan data custom ke session
        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $activeRole->idrole ?? 'user',
            'user_role_name' => $namaRole->nama_role ?? 'User',
            'user_status' => $activeRole->status ?? 'active'
        ]);

        // --- INI BAGIAN BARU (DARI HALAMAN 13) ---
        // 9. Cek role dan redirect
        $userRole = $activeRole->idrole ?? null;

        switch ($userRole) {
            case 1: // Admin
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
                case 2: // Dokter <-- TAMBAHKAN INI
                return redirect()->route('dokter.dashboard')->with('success', 'Login berhasil!');
                case 3: // Perawat <-- TAMBAHKAN INI
                return redirect()->route('perawat.dashboard')->with('success', 'Login berhasil!');
            case 4: // Resepsionis
                return redirect()->route('resepsionis.dashboard')->with('success', 'Login berhasil!');

                case 5: // Pemilik <-- TAMBAHKAN INI
                return redirect()->route('pemilik.dashboard')->with('success', 'Login berhasil!');
            

                
            default: // Role lain (misal Pemilik)
                // Kita arahkan ke /home default untuk sementara
                return redirect()->route('home')->with('success', 'Login berhasil!');
        }
        // ----------------------------------------
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}