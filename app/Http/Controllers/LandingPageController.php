<?php

namespace App\Http\Controllers;

use App\Models\Ptk;
use App\Models\Siswa;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\BukuIndukArsip;
use Illuminate\Support\Str; // Import Str untuk pengecekan UUID

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman beranda (index).
     */
    public function index()
    {
        $globalSettings = Setting::first();
        
        // Data untuk Widget Arsip Terbaru (hanya yang masuk)
        $arsipTerbaru = BukuIndukArsip::with('klasifikasi')
                                        ->where('jenis_surat', 'Masuk')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(8)
                                        ->get();
                                        
        // Data untuk Widget PTK Terbaru (misalnya 4 PTK yang paling baru diupdate)
        $ptkTerbaru = Ptk::orderBy('updated_at', 'desc')->limit(4)->get();

        // Data untuk Widget Sorotan Siswa (misalnya 6 Siswa Aktif random)
        $siswaSorotan = Siswa::where('status', 'Aktif')->inRandomOrder()->limit(6)->get();

        return view('landing.index', compact(
            'globalSettings',
            'arsipTerbaru',
            'ptkTerbaru',
            'siswaSorotan'
        ));
    }

    // =======================================================
    // --- FITUR PENCARIAN GLOBAL (/cari) ---
    // =======================================================

    /**
     * Melakukan pencarian global di berbagai model (Arsip, PTK, Siswa).
     */
    public function globalSearch(Request $request)
    {
        $keyword = $request->input('search');
        $globalSettings = Setting::first();

        if (empty($keyword)) {
            // Jika keyword kosong, kembalikan ke halaman katalog arsip
            return redirect()->route('landing.arsip.index'); 
        }

        // --- 1. Cari Arsip (Buku Induk Arsip) ---
        $arsipResults = BukuIndukArsip::with('klasifikasi')
            ->where('jenis_surat', 'Masuk')
            ->where(function($query) use ($keyword) {
                $query->where('perihal', 'like', "%{$keyword}%")
                      ->orWhere('nomor_surat', 'like', "%{$keyword}%");
            })
            ->latest()
            ->limit(5)
            ->get();

        // --- 2. Cari PTK ---
        $ptkResults = Ptk::where('nama', 'like', "%{$keyword}%")
                         ->orWhere('jabatan', 'like', "%{$keyword}%")
                         ->orWhere('status_pegawai', 'like', "%{$keyword}%")
                         ->limit(5)
                         ->get();

        // --- 3. Cari Siswa ---
        $siswaResults = Siswa::where('status', 'Aktif')
                             ->where(function($query) use ($keyword) {
                                $query->where('nama', 'like', "%{$keyword}%")
                                      ->orWhere('nisn', 'like', "%{$keyword}%")
                                      ->orWhere('kelas', 'like', "%{$keyword}%");
                             })
                             ->limit(5)
                             ->get();
        
        return view('landing.search_results', compact(
            'keyword', 
            'arsipResults', 
            'ptkResults', 
            'siswaResults', 
            'globalSettings'
        ));
    }


    // =======================================================
    // --- KATALOG DAN DETAIL ARSIP ---
    // =======================================================

    /**
     * Menampilkan daftar semua arsip (Katalog Arsip).
     */
    public function indexArsip(Request $request)
    {
        $query = BukuIndukArsip::with('klasifikasi');
        
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('perihal', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%");
            });
        }
        
        $arsipList = $query->orderBy('tanggal_surat', 'desc')->paginate(15);
        $globalSettings = Setting::first();
        
        return view('landing.arsip.index', compact('arsipList', 'globalSettings'));
    }

    /**
     * Menampilkan detail arsip tunggal.
     * Menggunakan pencarian manual untuk mendukung ID dan UUID/Slug (identifier).
     */
    public function showArsip($identifier) // Menerima identifier (ID atau UUID)
    {
        // Cek apakah identifier adalah UUID yang valid
        if (Str::isUuid($identifier)) {
            // Cari berdasarkan UUID
            $arsip = BukuIndukArsip::with('klasifikasi')->where('uuid', $identifier)->firstOrFail();
        } else {
            // Cari berdasarkan ID numerik (fallback untuk link lama/transisi)
            $arsip = BukuIndukArsip::with('klasifikasi')->findOrFail($identifier);
        }
        
        $globalSettings = Setting::first();
        return view('landing.arsip.show', compact('arsip', 'globalSettings'));
    }
    
    /**
     * Menampilkan daftar arsip yang memiliki file (Katalog Unduhan).
     */
    public function indexDownloads()
    {
        $arsipList = BukuIndukArsip::with('klasifikasi')
                                    ->whereNotNull('file_arsip')
                                    ->latest()
                                    ->paginate(15);

        $globalSettings = Setting::first();
        
        return view('landing.arsip.download_index', compact('arsipList', 'globalSettings'));
    }


    // =======================================================
    // --- KATALOG DAN DETAIL PTK ---
    // =======================================================

    /**
     * Menampilkan daftar semua PTK untuk umum (PUBLIC INDEX).
     */
    public function indexPtk(Request $request)
    {
        $query = Ptk::query();
        
        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('status_pegawai', 'like', "%{$search}%");
            });
        }
        
        // Logika Filter Status
        if ($request->filled('status')) {
            $query->where('status_pegawai', $request->input('status'));
        }
        
        $ptkList = $query->orderBy('jabatan', 'asc')
                          ->orderBy('nama', 'asc')
                          ->paginate(18);
        
        $globalSettings = Setting::first();
        $statuses = Ptk::select('status_pegawai')->distinct()->pluck('status_pegawai');
        
        return view('landing.ptk.index', compact('ptkList', 'globalSettings', 'statuses'));
    }

    /**
     * Menampilkan profil detail PTK (Pegawai/Guru) secara publik.
     * Menggunakan Route Model Binding (PTK dicari otomatis berdasarkan UUID).
     */
    public function showPtk(Ptk $ptk) // Menerima Model Ptk (dicari berdasarkan UUID/Slug)
    {
        $globalSettings = Setting::first();
        return view('landing.ptk.show', compact('ptk', 'globalSettings'));
    }


    // =======================================================
    // --- KATALOG DATA SISWA ---
    // =======================================================

    /**
     * Menampilkan daftar Siswa Aktif untuk umum.
     */
    public function indexSiswa(Request $request)
    {
        $query = Siswa::where('status', 'Aktif');

        // Logika Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }
        
        $siswaList = $query->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->paginate(20);
        $globalSettings = Setting::first();

        return view('landing.siswa.index', compact('siswaList', 'globalSettings'));
    }
}