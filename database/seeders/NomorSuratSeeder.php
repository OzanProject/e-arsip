<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NomorSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kode_klasifikasi' => '420', 'nama_klasifikasi' => 'Pendidikan', 'keterangan' => 'Urusan Pendidikan Sekolah', 'created_at' => Carbon::now()],
            ['kode_klasifikasi' => '421', 'nama_klasifikasi' => 'Kurikulum', 'keterangan' => 'Rencana Pelajaran, Silabus, RPP', 'created_at' => Carbon::now()],
            ['kode_klasifikasi' => '422', 'nama_klasifikasi' => 'Siswa/Murid', 'keterangan' => 'Penerimaan Siswa Baru, Kenaikan Kelas, Kelulusan', 'created_at' => Carbon::now()],
            ['kode_klasifikasi' => '800', 'nama_klasifikasi' => 'Kepegawaian', 'keterangan' => 'Mutasi, Cuti, Kenaikan Pangkat Guru/PTK', 'created_at' => Carbon::now()],
        ];

        DB::table('nomor_surat')->insert($data);
    }
}