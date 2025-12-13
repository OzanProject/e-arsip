<?php
// File: database/migrations/YYYY_MM_DD_HHMMSS_create_settings_table.php

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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 255);
            $table->string('alamat_sekolah')->nullable();
            $table->string('kepala_sekolah', 255)->nullable();
            $table->string('logo_path')->nullable(); // Path untuk logo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};