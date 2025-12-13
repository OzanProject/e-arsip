<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// WAJIB: Import Facade untuk View
use Illuminate\Support\Facades\View; 
// WAJIB: Import Facade untuk Schema (untuk cek tabel)
use Illuminate\Support\Facades\Schema;
// WAJIB: Import Model GlobalSetting Anda
use App\Models\Setting; // Asumsikan Model Anda bernama 'Setting' atau 'GlobalSetting'

// Catatan: Jika Model Anda benar-benar bernama GlobalSetting, ganti use App\Models\Setting menjadi use App\Models\GlobalSetting
// Saya akan menggunakan App\Models\Setting sebagai contoh, karena umum menggunakan 'Setting'

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan tabel ada sebelum mencoba mengaksesnya
        if (Schema::hasTable('settings')) { // Ganti 'settings' jika nama tabel Anda berbeda
            
            // Ambil pengaturan global hanya sekali
            $globalSettings = Setting::first(); // Ganti 'Setting' jika nama Model berbeda

            // Menggunakan View Composer untuk membagikan $globalSettings
            // ke semua views yang terkait dengan Landing Page dan Guest (Login/Register)
            View::composer(['landing.*', 'layouts.guest', 'auth.*'], function ($view) use ($globalSettings) {
                $view->with('globalSettings', $globalSettings);
            });

        } else {
            // Jika tabel belum ada (misalnya saat pertama kali migrasi), 
            // kita tetap membagikan variabel null agar tidak error.
            View::composer(['landing.*', 'layouts.guest', 'auth.*'], function ($view) {
                $view->with('globalSettings', null);
            });
        }
    }
}