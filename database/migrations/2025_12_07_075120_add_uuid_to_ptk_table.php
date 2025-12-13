<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ptk', function (Blueprint $table) {
            // Tambahkan kolom UUID setelah ID
            $table->uuid('uuid')->unique()->after('id')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ptk', function (Blueprint $table) {
            //
        });
    }
};
