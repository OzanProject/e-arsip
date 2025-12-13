<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LulusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $data = [];
        $jk = ['Laki-laki', 'Perempuan'];
        $tahunLulusList = [2022, 2023, 2024];

        // Tambahkan 30 data dummy
        for ($i = 1; $i <= 30; $i++) {
            $j = $faker->randomElement($jk);
            $tahunLulus = $faker->randomElement($tahunLulusList);
            $nisn = '99' . $faker->unique()->randomNumber(8, true);

            $data[] = [
                'nisn' => $nisn,
                'nama' => $faker->name($j === 'Laki-laki' ? 'male' : 'female'),
                'jenis_kelamin' => $j,
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-20 years', '-17 years')->format('Y-m-d'),
                'tahun_lulus' => $tahunLulus,
                'nomor_ijazah' => 'D-' . $faker->randomNumber(7, true),
                'nomor_skhun' => 'SH-' . $faker->randomNumber(5, true),
                'alamat' => $faker->address(),
                'telepon' => $faker->phoneNumber(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Hapus data lama dan masukkan data baru
        DB::table('lulusan')->delete();
        DB::table('lulusan')->insert($data);
    }
}