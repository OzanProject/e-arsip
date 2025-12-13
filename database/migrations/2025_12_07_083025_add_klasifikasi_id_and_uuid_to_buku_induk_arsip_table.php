<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku_induk_arsip', function (Blueprint $table) {
            
            // Kolom 'klasifikasi_id' mungkin tidak ada di skema dasar. Tambahkan jika belum ada.
            if (!Schema::hasColumn('buku_induk_arsip', 'klasifikasi_id')) {
                // Tambahkan kolom klasifikasi_id
                $table->unsignedBigInteger('klasifikasi_id')->nullable()->after('perihal');
            }
            
            // Hapus semua perintah dropForeign di sini!
            
            // Tambahkan Foreign Key
            $table->foreign('klasifikasi_id')->references('id')->on('nomor_surat');
        });
    }

    public function down(): void
    {
        Schema::table('buku_induk_arsip', function (Blueprint $table) {
            // Drop Foreign Key
            $table->dropForeign(['klasifikasi_id']);
            
            // Drop Kolom
            $table->dropColumn('klasifikasi_id');
        });
    }
};