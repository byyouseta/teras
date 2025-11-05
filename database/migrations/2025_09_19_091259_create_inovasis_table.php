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
        Schema::create('inovasis', function (Blueprint $table) {
            $table->id();
            // relasi ke user (pengusul)
            $table->foreignId('pengusul_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('periode_pengusulan_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('proposal_pdf')->nullable();
            $table->string('proposal_word')->nullable();
            $table->json('supporting_files')->nullable();
            $table->enum('status', ['draft', 'diajukan', 'diterima', 'ditolak'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovasis');
    }
};
