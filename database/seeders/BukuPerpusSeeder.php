<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BukuPerpusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_eksemplar' => 'B001-K7-A', 'judul' => 'IPA Terpadu Kelas 7', 'penulis' => 'Tim Sains Nasional', 
                'penerbit' => 'Erlangga', 'isbn' => '978-602-299-100-1', 'tahun_terbit' => 2023, 
                'kategori' => 'Pelajaran Kelas 7', 'jumlah_eksemplar' => 100, 'eksemplar_tersedia' => 95, 
                'kondisi' => 'Baik', 'deskripsi' => 'Buku paket kurikulum terbaru.', 'created_at' => Carbon::now()
            ],
            [
                'kode_eksemplar' => 'B002-FK-B', 'judul' => 'Laskar Pelangi', 'penulis' => 'Andrea Hirata', 
                'penerbit' => 'Bentang Pustaka', 'isbn' => '978-979-3062-79-1', 'tahun_terbit' => 2005, 
                'kategori' => 'Fiksi', 'jumlah_eksemplar' => 15, 'eksemplar_tersedia' => 2, 
                'kondisi' => 'Rusak Ringan', 'deskripsi' => 'Novel legendaris tentang pendidikan.', 'created_at' => Carbon::now()
            ],
        ];

        DB::table('buku_perpus')->insert($data);
    }
}