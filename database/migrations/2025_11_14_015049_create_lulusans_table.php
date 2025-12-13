<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_lulusans_table.php

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
        Schema::create('lulusan', function (Blueprint $table) {
            $table->id();
            $table->string('nisn', 15)->unique(); // Nomor Induk Siswa Nasional
            $table->string('nama', 255);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('tahun_lulus', 4); // Misal: 2024
            $table->string('nomor_ijazah', 50)->nullable()->unique();
            $table->string('nomor_skhun', 50)->nullable()->unique();
            $table->text('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lulusan');
    }
};