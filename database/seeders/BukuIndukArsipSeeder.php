<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NomorSurat; 
use App\Models\BukuIndukArsip; 
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str; // Import Str untuk UUID

class BukuIndukArsipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker dan Ambil Semua ID Klasifikasi
        $faker = Faker::create('id_ID');
        // Asumsi: Model NomorSurat bertindak sebagai tabel Klasifikasi
        $klasifikasiIds = NomorSurat::pluck('id')->toArray(); 
        $data = [];

        // Hapus data lama untuk seeding yang bersih
        // Catatan: Jika ada foreign key constraint, ini mungkin gagal
        DB::table('buku_induk_arsip')->delete(); 

        if (empty($klasifikasiIds)) {
            echo "Peringatan: Tidak ada data di tabel NomorSurat (klasifikasi). Silakan jalankan NomorSuratSeeder terlebih dahulu.\n";
            return;
        }

        // Buat 50 Data Arsip Dummy
        for ($i = 1; $i <= 50; $i++) {
            $jenis = $faker->randomElement(['Masuk', 'Keluar']);
            $tanggalSurat = $faker->dateTimeBetween('-1 year', 'now');
            $klasifikasiId = $faker->randomElement($klasifikasiIds);

            // Tentukan Asal/Tujuan dan Nomor Surat yang Sesuai
            // Format Nomor Surat: XXX/H/2024 (Hanya sebagai dummy)
            $nomorSurat = $faker->randomNumber(3, true) . '/' . $faker->randomLetter() . '/' . $tanggalSurat->format('Y');
            
            // Tentukan Asal/Tujuan
            $asalTujuan = $jenis === 'Masuk' ? $faker->company() : 'Kantor ' . $faker->lastName();

            // Tambahkan file path dummy untuk sekitar 10% data (untuk Katalog Unduhan)
            $filePath = $faker->optional(0.1)->passthrough('public/arsip_dummy/' . Str::random(10) . '.pdf');

            $data[] = [
                // UUID BARU: Sesuai implementasi Route Model Binding
                'uuid' => Str::uuid()->toString(), 

                'jenis_surat' => $jenis,
                'nomor_agenda' => 'AG-' . str_pad($i, 4, '0', STR_PAD_LEFT) . '/' . $tanggalSurat->format('y'),
                'nomor_surat' => $nomorSurat,
                'tanggal_surat' => $tanggalSurat->format('Y-m-d'),
                'perihal' => $faker->sentence(5),

                // PERBAIKAN: Menggunakan klasifikasi_id (sesuai Model Binding)
                'klasifikasi_id' => $klasifikasiId, 
                
                'asal_surat' => $jenis === 'Masuk' ? $asalTujuan : null,
                'tujuan_surat' => $jenis === 'Keluar' ? $asalTujuan : null,
                
                // PATH FILE DUMMY (Untuk Katalog Unduhan)
                'file_arsip' => $filePath, 
                
                'keterangan' => $faker->optional(0.7)->paragraph(1), 
                'created_at' => $tanggalSurat,
                'updated_at' => Carbon::now(),
            ];
        }

        // Lakukan insert sekaligus
        DB::table('buku_induk_arsip')->insert($data);
    }
}