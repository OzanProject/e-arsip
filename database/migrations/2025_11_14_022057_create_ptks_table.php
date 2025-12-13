<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_ptks_table.php

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
        Schema::create('ptk', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->nullable()->unique(); // Nomor Induk Pegawai (Jika PNS)
            $table->string('nuptk', 20)->nullable()->unique(); // Nomor Unik Pendidik dan Tenaga Kependidikan
            $table->string('nama', 255);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('jabatan', 100); // Contoh: Guru Matematika, Tata Usaha, Kepala Sekolah
            $table->string('status_pegawai', 50); // Contoh: PNS, PPPK, Guru Honor Sekolah
            $table->string('pendidikan_terakhir', 50);
            $table->text('alamat');
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ptk');
    }
};