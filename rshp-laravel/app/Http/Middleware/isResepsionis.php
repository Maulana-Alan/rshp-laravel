<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Panggil helper Auth

class isResepsionis
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
            return redirect()->route('login'); // Jika belum, lempar ke login
        }

        // 2. Ambil role dari session
        $userRole = session('user_role');

        // 3. Cek apakah rolenya 4 (Resepsionis)
        if ($userRole == 4) {
            return $next($request); // Jika ya, izinkan lanjut
        }

        // 4. Jika bukan Resepsionis, tendang kembali
        return back()->with('error', 'Akses ditolak. Anda bukan Resepsionis.');
    }
}