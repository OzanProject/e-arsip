<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_siswas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 15)->unique(); // Nomor Induk Siswa Nasional
            $table->string('nis', 10)->unique();  // Nomor Induk Siswa (Lokal)
            $table->string('nama', 255);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('kelas', 10); // Contoh: 7A, 8B, 9C
            $table->string('agama', 50);
            $table->text('alamat');
            $table->string('nama_ayah', 255);
            $table->string('nama_ibu', 255);
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};