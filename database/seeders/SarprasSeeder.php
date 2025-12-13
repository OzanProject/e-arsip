<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SarprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_inventaris' => 'MEJA/KLS7A/001', 'nama_barang' => 'Meja Siswa', 'kategori' => 'Perabot', 
                'ruangan' => 'Kelas 7A', 'jumlah' => 30, 'satuan' => 'Unit', 'kondisi' => 'Baik', 
                'tahun_pengadaan' => 2020, 'keterangan' => 'Pengadaan Dana BOS', 'created_at' => Carbon::now()
            ],
            [
                'kode_inventaris' => 'KOMP/LAB/005', 'nama_barang' => 'Komputer PC', 'kategori' => 'Elektronik', 
                'ruangan' => 'Lab Komputer', 'jumlah' => 1, 'satuan' => 'Unit', 'kondisi' => 'Rusak Berat', 
                'tahun_pengadaan' => 2015, 'keterangan' => 'Monitor rusak total', 'created_at' => Carbon::now()
            ],
        ];

        DB::table('sarpras')->insert($data);
    }
}