<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Tambah kolom alamat terpisah setelah kolom 'agama'
            $table->string('kampung', 100)->nullable()->after('agama');
            $table->string('rt', 5)->nullable()->after('kampung');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('desa', 100)->nullable()->after('rw');
            $table->string('kota', 100)->nullable()->after('desa');
            $table->string('provinsi', 100)->nullable()->after('kota');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropColumn(['kampung', 'rt', 'rw', 'desa', 'kota', 'provinsi']);
        });
    }
};
