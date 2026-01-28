<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PelaporanEtik extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_no',
        'anonymous',
        'status',
        'nama',
        'phone',
        'email',
        'jabatan',
        'unit',
        'no_identitas',
        'lokasi',
        'tanggal',
        'waktu',
        'terlapor_nama',
        'terlapor_jabatan',
        'deskripsi',
        'orang_terlibat',
        'saksi',
        'file_pendukung',
        'agree',
        'resolved',
        'resolved_at',
    ];

    protected $casts = [
        'anonymous' => 'boolean',
        'agree' => 'boolean',
        'tanggal' => 'date',
        'resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    public function tindakLanjuts()
    {
        return $this->hasOne(TindakLanjutEtika::class);
    }
}
