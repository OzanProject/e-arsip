<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_absensi_kelas_table.php

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
        Schema::create('absensi_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kelas', 10);
            $table->string('bulan', 20); // Contoh: Januari
            $table->year('tahun'); // Contoh: 2024
            $table->timestamps();
            
            // Tambahkan constraint unik untuk menghindari duplikasi laporan
            $table->unique(['kelas', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_kelas');
    }
};