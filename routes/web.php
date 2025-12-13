<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PtkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LulusanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuPerpusController;
use App\Http\Controllers\NomorSuratController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AbsensiKelasController;
use App\Http\Controllers\BukuIndukArsipController;
use App\Http\Controllers\AdministrasiGuruController;
use App\Http\Controllers\AdministrasiSiswaController;


// =======================================================
// --- PERBAIKAN BUG REDIRECT 404 (PRIORITAS TERTINGGI) ---
// =======================================================

// Mencegat URL lama /arsip/{id}?query=... dan mengalihkannya ke Global Search.
Route::get('/arsip/{id}', function ($id) {
    if (request()->has('query') || request()->has('search')) {
        $search = request('query') ?? request('search');
        return redirect()->route('landing.search', ['search' => $search]);
    }
    // Jika tidak ada query, arahkan ke rute detail arsip yang benar (arsip-detail/{id})
    return redirect()->route('landing.arsip.show', $id);
})->where('id', '[0-9]+');

// Mencegat URL lama /arsip/1 yang sering muncul di cache
Route::get('/arsip/1', function () {
    if (request()->has('query') || request()->has('search')) {
        $search = request('query') ?? request('search');
        return redirect()->route('landing.search', ['search' => $search]);
    }
    return redirect()->route('landing.arsip.show', 1);
});


// =======================================================
// --- ROUTE ADMIN (DILINDUNGI OLEH 'auth') ---
// =======================================================

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Modul 1: Nomor Surat
    Route::get('nomor-surat/export/excel', [NomorSuratController::class, 'exportExcel'])->name('nomor-surat.export.excel');
    Route::get('nomor-surat/export/pdf', [NomorSuratController::class, 'exportPdf'])->name('nomor-surat.export.pdf');
    Route::resource('nomor-surat', NomorSuratController::class);

    // Modul 2: Buku Induk Arsip
    Route::resource('buku-induk-arsip', BukuIndukArsipController::class);

    // Modul 3: Lulusan
    Route::post('lulusan/import/excel', [LulusanController::class, 'importExcel'])->name('lulusan.import.excel');
    Route::get('lulusan/export/excel', [LulusanController::class, 'exportExcel'])->name('lulusan.export.excel');
    Route::get('lulusan/export/pdf', [LulusanController::class, 'exportPdf'])->name('lulusan.export.pdf');
    Route::delete('lulusan/bulk-destroy', [LulusanController::class, 'bulkDestroy'])->name('lulusan.bulk.destroy');
    Route::resource('lulusan', LulusanController::class);

    // Modul 4: Data Siswa (Aktif)
    Route::post('siswa/import/excel', [SiswaController::class, 'importExcel'])->name('siswa.import.excel');
    Route::get('siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export.excel');
    Route::get('siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.export.pdf');
    Route::delete('siswa/bulk-destroy', [SiswaController::class, 'bulkDestroy'])->name('siswa.bulk.destroy');
    Route::resource('siswa', SiswaController::class);

    // Modul 5: Data PTK (ADMIN PATH)
    Route::resource('data-ptk', PtkController::class)
        ->names('ptk')
        ->parameters(['data-ptk' => 'ptk']);

    // Modul 6: Administrasi Guru
    Route::resource('administrasi-guru', AdministrasiGuruController::class);

    // Modul 7: Administrasi Siswa
    Route::resource('administrasi-siswa', AdministrasiSiswaController::class);

    // Modul 8: Daftar Hadir
    Route::get('daftar-hadir', [AbsensiKelasController::class, 'index'])->name('daftar-hadir.index');
    Route::get('daftar-hadir/generate', [AbsensiKelasController::class, 'generatePdf'])->name('daftar-hadir.generate');

    // Modul 9: Database Sarpras
    Route::resource('sarpras', SarprasController::class); 

    // Modul 10: Database Perpus
    Route::resource('buku-perpus', BukuPerpusController::class);

    // Modul Panduan Aplikasi
    Route::get('panduan/generate', [App\Http\Controllers\PanduanController::class, 'generate'])->name('panduan.generate');

    // Modul 11 & Pengaturan Umum (Membutuhkan Hak Akses Admin)
    Route::middleware('admin')->group(function () {
        
        // Modul 11: Manajemen User
        Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::resource('users', UserController::class); 

        // Modul Pengaturan Umum (Singleton Edit/Update)
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});

// =======================================================
// --- ROUTE PUBLIK / LANDING PAGE (DI LUAR 'auth') ---
// =======================================================

// Homepage
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// GLOBAL SEARCH (Untuk Hero Section)
Route::get('/cari', [LandingPageController::class, 'globalSearch'])->name('landing.search'); 

// DAFTAR PUBLIK INDEX
Route::get('/arsip-list', [LandingPageController::class, 'indexArsip'])->name('landing.arsip.index');
Route::get('/siswa-list', [LandingPageController::class, 'indexSiswa'])->name('landing.siswa.index');
Route::get('/ptk-list', [LandingPageController::class, 'indexPtk'])->name('landing.ptk.index'); 
Route::get('/katalog-unduhan', [LandingPageController::class, 'indexDownloads'])->name('landing.arsip.download_index'); 

// DETAIL PUBLIK 
// PTK DETAIL: Menggunakan Model Binding (UUID/Slug)
Route::get('/ptk/{ptk}', [LandingPageController::class, 'showPtk'])->name('landing.ptk.show'); 
// ARSIP DETAIL: Menggunakan identifier (ID atau UUID)
Route::get('/arsip-detail/{identifier}', [LandingPageController::class, 'showArsip'])->name('landing.arsip.show'); 

require __DIR__.'/auth.php';