<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $data = [];
        $kelas = ['7A', '7B', '8A', '8B', '9A', '9B'];
        $jk = ['Laki-laki', 'Perempuan'];

        // Tambahkan 40 data dummy
        for ($i = 1; $i <= 40; $i++) {
            $j = $faker->randomElement($jk);
            $namaAyah = 'Bapak ' . $faker->lastName();
            $namaIbu = 'Ibu ' . $faker->lastName();
            $nisn = '00' . $faker->unique()->randomNumber(8, true);
            
            $data[] = [
                'nisn' => $nisn,
                'nis' => '2024' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama' => $faker->name($j === 'Laki-laki' ? 'male' : 'female'),
                'jenis_kelamin' => $j,
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-15 years', '-12 years')->format('Y-m-d'),
                'kelas' => $faker->randomElement($kelas),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'alamat' => $faker->address(),
                'nama_ayah' => $namaAyah,
                'nama_ibu' => $namaIbu,
                'telepon' => $faker->optional()->phoneNumber(),
                'status' => 'Aktif', // Kolom status yang baru ditambahkan
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Hapus data lama dan masukkan data baru
        DB::table('siswa')->delete();
        DB::table('siswa')->insert($data);
    }
}