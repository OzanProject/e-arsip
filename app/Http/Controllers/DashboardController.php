<?php

namespace App\Http\Controllers;

// Import semua Model yang digunakan untuk statistik
use App\Models\BukuIndukArsip; 
use App\Models\Siswa; 
use App\Models\Ptk;
use App\Models\Lulusan;
use App\Models\Sarpras; // <-- DITAMBAH
use App\Models\BukuPerpus; // <-- DITAMBAH
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Statistik Utama
        $stats = [
            'total_arsip' => BukuIndukArsip::count(), 
            'total_siswa' => Siswa::where('status', 'Aktif')->count(), 
            'total_ptk' => Ptk::count(), 
            
            // Statistik Baru
            'total_lulusan' => Lulusan::count(), 
            'total_sarpras' => Sarpras::count(), 
            'total_buku' => BukuPerpus::sum('jumlah_eksemplar'), // Menggunakan SUM
            
            'total_users' => User::count(),
        ];

        // 2. Ambil Arsip Terbaru
        $latest_archives = BukuIndukArsip::orderBy('created_at', 'desc')->take(5)->get();

        // 3. Ambil Pengaturan Global
        $globalSettings = Setting::first() ?? (object)['nama_sekolah' => 'E-Arsip SMP Default'];
        
        // Teruskan semua data statistik ke view
        return view('dashboard.index', compact('stats', 'latest_archives', 'globalSettings'));
    }
}