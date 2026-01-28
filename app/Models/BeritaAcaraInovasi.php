<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaAcaraInovasi extends Model
{
    protected $guarded = [];

    protected $casts = [
        'kebijakan' => 'boolean',
        'tek_kes' => 'boolean',
        'tek_si' => 'boolean',
        'pelayanan_publik' => 'boolean',
        'budaya_kerja' => 'boolean',
        'sop' => 'boolean',
        'mou' => 'boolean',
        'produk' => 'boolean',
        'pembaharuan' => 'boolean',
        'memudahkan' => 'boolean',
        'mempercepat' => 'boolean',
        'disebarluaskan' => 'boolean',
        'bermanfaat' => 'boolean',
        'spesifik' => 'boolean',
        'berkelanjutan' => 'boolean',
        'solusi' => 'boolean',
        'dapat_diaplikasikan' => 'boolean',
        'percontohan' => 'boolean',
        'perencanaan' => 'boolean',
        'pengukuran' => 'boolean',
        'pelaporan' => 'boolean',
        'evaluasi_akuntabilitas' => 'boolean',
        'pemanfaatan_perencanaan' => 'boolean',
        'pemanfaatan_pengukuran' => 'boolean',
        'pemanfaatan_pelaporan' => 'boolean',
        'pemanfaatan_evaluasi_akuntabilitas' => 'boolean',
        'dihargai' => 'boolean',
        'diadopsi' => 'boolean',
        'penilaian_percontohan' => 'boolean',
        'tidak_inovasi' => 'boolean',
    ];


    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class, 'inovasi_id');
    }

    public function anggotaSPI()
    {
        return $this->belongsTo(User::class, 'spi');
    }

    public function petugasPPE1()
    {
        return $this->belongsTo(User::class, 'ppe_1');
    }

    public function petugasPPE2()
    {
        return $this->belongsTo(User::class, 'ppe_2');
    }

    public function kepalaSPI()
    {
        return $this->belongsTo(User::class, 'kepala_spi');
    }
}
