<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ptk;
use Carbon\Carbon;

class AdministrasiGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan PTK sudah ada
        $ptkId = Ptk::where('jabatan', 'Guru Matematika')->first()->id ?? Ptk::inRandomOrder()->first()->id;

        if ($ptkId) {
            DB::table('administrasi_guru')->insert([
                'ptk_id' => $ptkId,
                'judul' => 'RPP Matematika Kelas 8 Semester Ganjil',
                'tahun_ajaran' => '2025/2026',
                'kategori' => 'RPP',
                'file_path' => 'dummy/rpp_mat_8.pdf', // Path dummy
                'deskripsi' => 'Rencana Pelaksanaan Pembelajaran matematika.',
                'created_at' => now(),
            ]);
        }
    }
}