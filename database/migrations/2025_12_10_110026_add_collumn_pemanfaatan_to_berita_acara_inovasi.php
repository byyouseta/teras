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
        Schema::table('berita_acara_inovasis', function (Blueprint $table) {
            $table->boolean('pemanfaatan_perencanaan')->nullable()->after("keterangan_perencanaan");
            $table->text('keterangan_pemanfaatan_perencanaan')->nullable()->after('pemanfaatan_perencanaan');
            $table->boolean('pemanfaatan_pengukuran')->nullable()->after('keterangan_pengukuran');
            $table->text('keterangan_pemanfaatan_pengukuran')->nullable()->after('pemanfaatan_pengukuran');
            $table->boolean('pemanfaatan_pelaporan')->nullable()->after('keterangan_pelaporan');
            $table->text('keterangan_pemanfaatan_pelaporan')->nullable()->after('pemanfaatan_pelaporan');
            $table->boolean('pemanfaatan_evaluasi_akuntabilitas')->nullable()->after('keterangan_evaluasi_akuntabilitas');
            $table->text('keterangan_pemanfaatan_evaluasi_akuntabilitas')->nullable()->after('pemanfaatan_evaluasi_akuntabilitas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berita_acara_inovasis', function (Blueprint $table) {
            $table->dropColumn([
                'pemanfaatan_perencanaan',
                'keterangan_pemanfaatan_perencanaan',
                'pemanfaatan_pengukuran',
                'keterangan_pemanfaatan_pengukuran',
                'pemanfaatan_pelaporan',
                'keterangan_pemanfaatan_pelaporan',
                'pemanfaatan_evaluasi_akuntabilitas',
                'keterangan_pemanfaatan_evaluasi_akuntabilitas',
            ]);
        });
    }
};
