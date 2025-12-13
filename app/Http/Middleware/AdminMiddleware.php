<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login
        // 2. Cek apakah pengguna memiliki peran Admin menggunakan method isAdmin()
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Jika akses ditolak, redirect ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Akses Ditolak. Anda tidak memiliki izin Admin.');
    }
}