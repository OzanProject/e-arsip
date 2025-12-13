<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_buku_perpus_table.php

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
        Schema::create('buku_perpus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_eksemplar', 50)->unique(); // Kode unik per buku fisik
            $table->string('judul', 255);
            $table->string('penulis', 150);
            $table->string('penerbit', 150);
            $table->string('isbn', 50)->nullable();
            $table->integer('tahun_terbit')->nullable();
            $table->string('kategori', 100); // Contoh: Fiksi, Sains, Pelajaran Kelas 7
            $table->integer('jumlah_eksemplar'); // Total eksemplar yang dimiliki
            $table->integer('eksemplar_tersedia'); // Eksemplar yang sedang tidak dipinjam
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_perpus');
    }
};