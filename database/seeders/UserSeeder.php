<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data akun Admin default
        DB::table('users')->insert([
            'name' => 'Administrator E-Arsip',
            'email' => 'ardiansyahdzan@gmail.com', // Ganti dengan email Anda
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'), // Password: password
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        // Data akun operator
        DB::table('users')->insert([
            'name' => 'Operator Arsip',
            'email' => 'operator@earsip.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('operator123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}