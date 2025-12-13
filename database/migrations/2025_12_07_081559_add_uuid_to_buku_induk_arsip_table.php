<?php

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
        Schema::table('buku_induk_arsip', function (Blueprint $table) {
            // Tambahkan kolom UUID unik setelah ID
            $table->uuid('uuid')->unique()->after('id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('buku_induk_arsip', function (Blueprint $table) {
            // Hapus kolom UUID jika migrasi dirollback
            $table->dropColumn('uuid');
        });
    }
};
