<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('school_classes', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique(); // e.g., "7A", "8B"
      $table->string('slug')->unique(); // e.g., "7a", "8b"
      $table->string('angkatan')->nullable(); // e.g., "2025/2026"
      $table->foreignId('wali_kelas_id')->nullable()->constrained('ptk')->onDelete('set null');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('school_classes');
  }
};
