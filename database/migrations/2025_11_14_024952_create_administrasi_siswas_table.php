<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_administrasi_siswas_table.php

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
        Schema::create('administrasi_siswa', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Modul 4: Siswa (Pemilik Administrasi)
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade'); 
            
            $table->string('judul', 255);
            $table->string('tahun_ajaran', 10); // Contoh: 2023/2024
            $table->string('semester', 20); // Contoh: Ganjil, Genap
            $table->string('kategori', 100); // Contoh: Leger Kelas 7, Raport Semester 1, BK
            $table->string('file_path'); // Path file arsip (PDF/Dokumen)
            $table->text('deskripsi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrasi_siswa');
    }
};