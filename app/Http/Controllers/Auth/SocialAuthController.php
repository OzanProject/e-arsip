<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect pengguna ke halaman login provider.
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle callback dari provider.
     */
    public function callback($provider)
    {
        try {
            // Dapatkan user dari provider (Google/Facebook)
            $socialUser = Socialite::driver($provider)->user();
            
            // Cari user berdasarkan email
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Jika user ada, cek status approval
                if (!$user->is_approved) {
                    return redirect()->route('login')->withErrors(['email' => 'Akun Anda ditemukan tetapi belum disetujui Admin.']);
                }
                
                // Login jika approved
                Auth::login($user);
                return redirect()->intended('dashboard');
            
            } else {
                // Jika user belum ada, buat baru dengan status PENDING
                // Set role default (misal: ID role user/guru, kita ambil role terakhir atau spesifik)
                // Asumsi: Role 'Guru' atau 'Operator' ada. Kita ambil role dengan ID terbesar (biasanya user biasa) atau hardcode jika tahu.
                // Aman: Ambil role yang bukan admin.
                $defaultRole = Role::where('name', '!=', 'Admin')->first() ?? Role::first();

                $newUser = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Random password
                    'role_id' => $defaultRole->id,
                    'is_approved' => false, // Tetap butuh approval
                ]);

                // Redirect ke login dengan pesan sukses registrasi
                return redirect()->route('login')->with('status', 'Registrasi via ' . ucfirst($provider) . ' berhasil! Akun Anda menunggu persetujuan Admin.');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login dengan ' . ucfirst($provider) . '. Silakan coba lagi.']);
        }
    }
}
