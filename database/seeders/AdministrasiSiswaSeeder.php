<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use Carbon\Carbon;

class AdministrasiSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan Siswa sudah ada
        $siswaId = Siswa::where('kelas', '7A')->first()->id ?? Siswa::inRandomOrder()->first()->id;

        if ($siswaId) {
            DB::table('administrasi_siswa')->insert([
                'siswa_id' => $siswaId,
                'judul' => 'Leger Nilai Kelas 7A Semester Ganjil',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Ganjil',
                'kategori' => 'Leger',
                'file_path' => 'dummy/leger_7a.pdf', // Path dummy
                'deskripsi' => 'Rekap nilai seluruh mata pelajaran.',
                'created_at' => now(),
            ]);
        }
    }
}