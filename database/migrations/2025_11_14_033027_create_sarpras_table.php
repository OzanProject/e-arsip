<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_sarpras_table.php

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
        Schema::create('sarpras', function (Blueprint $table) {
            $table->id();
            $table->string('kode_inventaris', 50)->unique();
            $table->string('nama_barang', 255);
            $table->string('kategori', 100); // Contoh: Meja, Kursi, Komputer, Bangunan
            $table->string('ruangan', 100); // Lokasi barang berada (Kelas 7A, Lab Komputer, Gudang)
            $table->integer('jumlah');
            $table->enum('satuan', ['Unit', 'Pcs', 'Buah', 'Set', 'Meter']);
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->year('tahun_pengadaan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sarpras');
    }
};