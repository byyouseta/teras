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
        Schema::create('penguji_inovasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inovasi_id');
            $table->unsignedBigInteger('user_id');

            // Kolom untuk setiap kriteria (Ya/Tidak -> bisa string atau boolean)
            $table->enum('orisinil_modifikasi', ['Ya', 'Tidak'])->nullable();
            $table->enum('memudahkan_pelayanan', ['Ya', 'Tidak'])->nullable();
            $table->enum('mempercepat_pelayanan', ['Ya', 'Tidak'])->nullable();
            $table->enum('solusi_masalah', ['Ya', 'Tidak'])->nullable();
            $table->enum('manfaat', ['Ya', 'Tidak'])->nullable();
            $table->enum('aplikasi_internal_eksternal', ['Ya', 'Tidak'])->nullable();

            // Simpulan akhir
            $table->enum('simpulan', ['Tidak Layak', 'Layak dengan Revisi', 'Layak'])->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();

            // Relasi sederhana (optional: bisa tambah foreign key constraint)
            $table->foreign('inovasi_id')->references('id')->on('inovasis')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['inovasi_id', 'user_id']); // biar 1 user nggak jadi penguji ganda di 1 inovasi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguji_inovasis');
    }
};
