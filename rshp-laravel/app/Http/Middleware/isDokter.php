<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Panggil helper Auth

class isDokter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role dari session
        $userRole = session('user_role');

        // 3. Cek apakah rolenya 2 (Dokter)
        if ($userRole == 2) {
            return $next($request); // Jika ya, izinkan lanjut
        }

        // 4. Jika bukan Dokter, tendang kembali
        return back()->with('error', 'Akses ditolak. Anda bukan Dokter.');
    }
}