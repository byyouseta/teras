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
        Schema::create('periode_pengusulans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode'); // contoh: "Periode 2025"
            $table->year('tahun');
            $table->enum('status', ['open', 'close'])->default('open');
            $table->date('mulai')->nullable();
            $table->date('selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_pengusulans');
    }
};
