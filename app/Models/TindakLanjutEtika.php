<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjutEtika extends Model
{
    protected $fillable = [
        'pelaporan_etik_id',
        'status_laporan',
        'tindak_lanjut',
        'ditindak_lanjuti_oleh',
        'tanggal_tindak_lanjut',
        'catatan',
        'file_tindak_lanjut',
        'diselesaikan_oleh',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_tindak_lanjut' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pelaporanEtik()
    {
        return $this->belongsTo(PelaporanEtik::class, 'pelaporan_etik_id');
    }
}
