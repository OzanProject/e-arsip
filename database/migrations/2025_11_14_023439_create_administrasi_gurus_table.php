<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_administrasi_gurus_table.php

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
        Schema::create('administrasi_guru', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Modul 5: PTK (Pemilik Administrasi)
            $table->foreignId('ptk_id')->constrained('ptk')->onDelete('cascade'); 
            
            $table->string('judul', 255);
            $table->string('tahun_ajaran', 10); // Contoh: 2023/2024
            $table->string('kategori', 100); // Contoh: RPP, Silabus, Prota, Promes, Absensi
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
        Schema::dropIfExists('administrasi_guru');
    }
};