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
        Schema::create('pelaporan_etiks', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no', 15)->unique();
            $table->boolean('anonymous')->default(true);
            $table->string('status')->nullable();
            $table->string('nama')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('unit')->nullable();
            $table->string('no_identitas', 30)->nullable();

            $table->string('lokasi')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('waktu')->nullable();

            $table->string('terlapor_nama')->nullable();
            $table->string('terlapor_jabatan')->nullable();

            $table->text('deskripsi');
            $table->text('orang_terlibat')->nullable();
            $table->text('saksi')->nullable();
            $table->string('file_pendukung')->nullable();
            $table->boolean('agree')->default(false);
            $table->boolean('resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporan_etiks');
    }
};
