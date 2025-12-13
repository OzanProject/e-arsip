<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ganti 'siswa' dengan nama tabel yang benar jika Anda menggunakan jamak (siswas)
        Schema::table('siswa', function (Blueprint $table) { 
            // Ini harus match dengan Controller: 'status' dan 'Aktif'
            $table->string('status', 20)->default('Aktif')->after('kelas'); 
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
