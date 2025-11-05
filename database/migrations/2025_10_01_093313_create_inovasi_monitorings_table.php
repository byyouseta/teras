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
        Schema::create('inovasi_monitorings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inovasi_id')->constrained('inovasis')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->text('dokumen'); // bisa path/URL
            $table->enum('tipe_input', ['file', 'link']); // tipe input: file upload atau link
            $table->enum('status', ['berjalan', 'selesai', 'gagal'])->default('berjalan');
            $table->date('tanggal_monitoring')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovasi_monitorings');
    }
};
