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
        Schema::create('berita_acara_inovasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inovasi_id')->constrained('inovasis')->onDelete('cascade');
            $table->boolean('kebijakan')->nullable();
            $table->text('keterangan_kebijakan')->nullable();
            $table->boolean('tek_kes')->nullable();
            $table->text('keterangan_tek_kes')->nullable();
            $table->boolean('tek_si')->nullable();
            $table->text('keterangan_tek_si')->nullable();
            $table->boolean('pelayanan_publik')->nullable();
            $table->text('keterangan_pelayanan_publik')->nullable();
            $table->boolean('budaya_kerja')->nullable();
            $table->text('keterangan_budaya_kerja')->nullable();
            $table->boolean('sop')->nullable();
            $table->text('keterangan_sop')->nullable();
            $table->boolean('mou')->nullable();
            $table->text('keterangan_mou')->nullable();
            $table->boolean('produk')->nullable();
            $table->text('keterangan_produk')->nullable();
            $table->boolean('pembaharuan')->nullable();
            $table->text('keterangan_pembaharuan')->nullable();
            $table->boolean('memudahkan')->nullable();
            $table->text('keterangan_memudahkan')->nullable();
            $table->boolean('mempercepat')->nullable();
            $table->text('keterangan_mempercepat')->nullable();
            $table->boolean('disebarluaskan')->nullable();
            $table->text('keterangan_disebarluaskan')->nullable();
            $table->boolean('bermanfaat')->nullable();
            $table->text('keterangan_bermanfaat')->nullable();
            $table->boolean('spesifik')->nullable();
            $table->text('keterangan_spesifik')->nullable();
            $table->boolean('berkelanjutan')->nullable();
            $table->text('keterangan_berkelanjutan')->nullable();
            $table->boolean('solusi')->nullable();
            $table->text('keterangan_solusi')->nullable();
            $table->boolean('dapat_diaplikasikan')->nullable();
            $table->text('keterangan_dapat_diaplikasikan')->nullable();
            $table->boolean('percontohan')->nullable();
            $table->text('keterangan_percontohan')->nullable();
            $table->boolean('perencanaan')->nullable();
            $table->text('keterangan_perencanaan')->nullable();
            $table->boolean('pengukuran')->nullable();
            $table->text('keterangan_pengukuran')->nullable();
            $table->boolean('pelaporan')->nullable();
            $table->text('keterangan_pelaporan')->nullable();
            $table->boolean('evaluasi_akuntabilitas')->nullable();
            $table->text('keterangan_evaluasi_akuntabilitas')->nullable();
            $table->string('tahun', 4)->nullable();
            $table->integer('jumlah_tahun')->nullable();
            $table->text('keterangan_tahun')->nullable();
            $table->integer('jumlah_sk')->nullable();
            $table->text('keterangan_sk')->nullable();
            $table->integer('jumlah_manual_book')->nullable();
            $table->text('keterangan_manual_book')->nullable();
            $table->integer('jumlah_laporan')->nullable();
            $table->text('keterangan_laporan')->nullable();
            $table->integer('jumlah_tangkap_layar')->nullable();
            $table->text('keterangan_tangkap_layar')->nullable();
            $table->integer('jumlah_matrik')->nullable();
            $table->text('keterangan_matrik')->nullable();
            $table->integer('jumlah_bukti_lainnya')->nullable();
            $table->text('keterangan_bukti_lainnya')->nullable();
            $table->integer('jumlah_hki')->nullable();
            $table->text('keterangan_hki')->nullable();
            $table->integer('jumlah_paten')->nullable();
            $table->text('keterangan_paten')->nullable();
            $table->integer('jumlah_pengakuan')->nullable();
            $table->text('keterangan_pengakuan')->nullable();
            $table->integer('jumlah_penghargaan')->nullable();
            $table->text('keterangan_penghargaan')->nullable();
            $table->integer('jumlah_dokumen_lainnya')->nullable();
            $table->text('keterangan_dokumen_lainnya')->nullable();
            $table->boolean('dihargai')->nullable();
            $table->text('keterangan_dihargai')->nullable();
            $table->boolean('diadopsi')->nullable();
            $table->text('keterangan_diadopsi')->nullable();
            $table->boolean('penilaian_percontohan')->nullable();
            $table->text('keterangan_penilaian_percontohan')->nullable();
            $table->boolean('tidak_inovasi')->nullable();
            $table->text('keterangan_tidak_inovasi')->nullable();
            $table->text('kesimpulan')->nullable();
            $table->date('tanggal_ba');
            $table->bigInteger('spi');
            $table->bigInteger('kepala_spi');
            $table->bigInteger('ppe_1');
            $table->bigInteger('ppe_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acara_inovasis');
    }
};
