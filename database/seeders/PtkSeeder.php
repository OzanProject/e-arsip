<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nip' => '197001012000011001', 
                'nuptk' => '8822991177110001', 
                'nama' => 'Dr. Budi Santoso, M.Pd.', 
                'jenis_kelamin' => 'Laki-laki', 
                'tempat_lahir' => 'Surabaya', 
                'tanggal_lahir' => '1970-01-01', 
                'jabatan' => 'Kepala Sekolah', 
                'status_pegawai' => 'PNS', 
                'pendidikan_terakhir' => 'S3', 
                'alamat' => 'Jl. Pendidikan No. 10', 
                'telepon' => '081234567890', 
                'created_at' => Carbon::now()
            ],
            [
                'nip' => '198505152010022005', 
                'nuptk' => '7733882266220005', 
                'nama' => 'Dewi Indah Sari, S.Pd.', 
                'jenis_kelamin' => 'Perempuan', 
                'tempat_lahir' => 'Bandung', 
                'tanggal_lahir' => '1985-05-15', 
                'jabatan' => 'Guru Matematika', 
                'status_pegawai' => 'PNS', 
                'pendidikan_terakhir' => 'S1', 
                'alamat' => 'Jl. Pelajar No. 5', 
                'telepon' => '087654321098', 
                'created_at' => Carbon::now()
            ],
        ];

        DB::table('ptk')->insert($data);
    }
}