<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isPemilik
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil role dari session
        $userRole = session('user_role');

        // 3. Cek apakah rolenya 5 (Pemilik)
        if ($userRole == 5) {
            return $next($request); // Izinkan lanjut
        }

        // 4. Jika bukan, tendang kembali
        return back()->with('error', 'Akses ditolak. Anda bukan Pemilik.');
    }
}