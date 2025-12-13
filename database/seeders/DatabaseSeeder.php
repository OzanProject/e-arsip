<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// --- Import Semua Seeder yang Dibutuhkan ---
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\NomorSuratSeeder;
use Database\Seeders\PtkSeeder;
use Database\Seeders\SiswaSeeder;
use Database\Seeders\LulusanSeeder;
use Database\Seeders\SarprasSeeder;
use Database\Seeders\BukuPerpusSeeder;
use Database\Seeders\BukuIndukArsipSeeder;
use Database\Seeders\AdministrasiGuruSeeder;
use Database\Seeders\AdministrasiSiswaSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 1. CORE SYSTEM & ROLES ---
        $this->call([
            RoleSeeder::class,     
            UserSeeder::class,      
            SettingSeeder::class,   
        ]);

        // Mengaitkan role Admin ke user default
        $adminRole = DB::table('roles')->where('name', 'Admin')->first();
        if ($adminRole) {
            DB::table('users')->where('email', 'ardiansyahdzan@gmail.com')->update([
                'role_id' => $adminRole->id,
            ]);
        }
        
        // --- 2. DATA MASTER ---
        $this->call([
            NomorSuratSeeder::class, 
            PtkSeeder::class,        
            SiswaSeeder::class,      
            LulusanSeeder::class,    
        ]);

        // --- 3. DATA TRANSAKSI & INVENTARIS ---
        $this->call([
            BukuIndukArsipSeeder::class, 
            AdministrasiGuruSeeder::class, 
            AdministrasiSiswaSeeder::class, 
            SarprasSeeder::class,   
            BukuPerpusSeeder::class, 
        ]);
    }
}