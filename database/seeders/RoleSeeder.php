<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator Sistem dengan akses penuh.', 'created_at' => Carbon::now()],
            ['name' => 'Operator Arsip', 'description' => 'Petugas yang mengelola Buku Induk Arsip.', 'created_at' => Carbon::now()],
            ['name' => 'Guru', 'description' => 'Hanya melihat data siswa dan administrasi guru.', 'created_at' => Carbon::now()],
        ];

        DB::table('roles')->insert($roles);
    }
}