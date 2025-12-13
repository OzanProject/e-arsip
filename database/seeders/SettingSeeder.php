<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'nama_sekolah' => 'SMPN 4 Kdp',
            'alamat_sekolah' => 'Jl. Pendidikan No. 4, Kodepos 40292',
            'kepala_sekolah' => 'Dr. Budi Santoso, M.Pd.',
            // logo_path akan NULL secara default
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}