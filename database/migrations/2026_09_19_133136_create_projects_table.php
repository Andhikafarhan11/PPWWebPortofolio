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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('judul', 200);               // Judul project
        $table->string('kategori', 100)->nullable();  // Kategori / teknologi
        $table->mediumText('deskripsi');              // Deskripsi detail project
        $table->string('gambar')->nullable();         // File/URL foto project
        $table->string('tautan')->nullable();         // Link GitHub / Demo (opsional)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
