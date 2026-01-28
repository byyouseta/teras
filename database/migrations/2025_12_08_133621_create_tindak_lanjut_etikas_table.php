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
        Schema::create('tindak_lanjut_etikas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaporan_etik_id')->constrained('pelaporan_etiks')->onDelete('cascade');
            $table->string('status_laporan')->default('Pending');
            $table->text('tindak_lanjut')->nullable();
            $table->string('ditindak_lanjuti_oleh')->nullable();
            $table->date('tanggal_tindak_lanjut')->nullable();
            $table->text('catatan')->nullable();
            $table->string('file_tindak_lanjut')->nullable();
            $table->string('diselesaikan_oleh')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut_etikas');
    }
};
