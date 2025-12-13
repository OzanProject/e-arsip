<?php
// File: database/migrations/*_create_buku_induk_arsip_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_induk_arsip', function (Blueprint $table) {
            $table->id();
            
            $table->enum('jenis_surat', ['Masuk', 'Keluar']);
            $table->string('nomor_agenda')->unique(); 
            $table->string('nomor_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            
            // Relasi ke Nomor Surat (Modul 1)
            $table->foreignId('nomor_surat_id')->nullable()->constrained('nomor_surat')->onDelete('set null');
            
            $table->string('asal_surat')->nullable(); // Khusus Masuk
            $table->string('tujuan_surat')->nullable(); // Khusus Keluar
            
            $table->string('file_arsip')->nullable(); // Path file PDF/Gambar
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_induk_arsip');
    }
};