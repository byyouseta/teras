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
        Schema::create('presentasi_inovasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inovasi_id')->constrained()->cascadeOnDelete();
            $table->dateTime('tanggal_presentasi');
            $table->string('tempat')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presentasi_inovasis');
    }
};
