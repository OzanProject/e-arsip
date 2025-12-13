<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom-kolom baru ke tabel 'ptk'.
     */
    public function up(): void
    {
        Schema::table('ptk', function (Blueprint $table) {
            // Kolom Wajib untuk Routing Slug
            // Ditambahkan setelah kolom 'nama'
            if (!Schema::hasColumn('ptk', 'slug')) {
                $table->string('slug', 255)->nullable()->unique()->after('nama'); 
            }
            
            // Kolom Wajib untuk Detail UI (ptk_show.blade.php)
            if (!Schema::hasColumn('ptk', 'tmt_kerja')) {
                $table->date('tmt_kerja')->nullable()->after('pendidikan_terakhir');
            }
            if (!Schema::hasColumn('ptk', 'tugas_tambahan')) {
                $table->string('tugas_tambahan', 100)->nullable()->after('tmt_kerja');
            }
            if (!Schema::hasColumn('ptk', 'bidang_studi')) {
                $table->string('bidang_studi', 100)->nullable()->after('tugas_tambahan');
            }
            if (!Schema::hasColumn('ptk', 'status_aktif')) {
                $table->string('status_aktif', 50)->default('Aktif')->after('bidang_studi');
            }
            if (!Schema::hasColumn('ptk', 'foto_path')) {
                $table->string('foto_path')->nullable()->after('telepon');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kembali kolom-kolom yang telah ditambahkan.
     */
    public function down(): void
    {
        Schema::table('ptk', function (Blueprint $table) {
            // Kolom slug
            if (Schema::hasColumn('ptk', 'slug')) {
                $table->dropColumn('slug');
            }

            // Kolom Detail UI
            if (Schema::hasColumn('ptk', 'tmt_kerja')) {
                $table->dropColumn('tmt_kerja');
            }
            if (Schema::hasColumn('ptk', 'tugas_tambahan')) {
                $table->dropColumn('tugas_tambahan');
            }
            if (Schema::hasColumn('ptk', 'bidang_studi')) {
                $table->dropColumn('bidang_studi');
            }
            if (Schema::hasColumn('ptk', 'status_aktif')) {
                $table->dropColumn('status_aktif');
            }
            if (Schema::hasColumn('ptk', 'foto_path')) {
                $table->dropColumn('foto_path');
            }
        });
    }
};