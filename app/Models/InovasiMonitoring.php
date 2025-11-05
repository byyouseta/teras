<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InovasiMonitoring extends Model
{
    protected $fillable = [
        'inovasi_id',
        'catatan',
        'dokumen',
        'tipe_input',
        'status',
        'tanggal_monitoring',
    ];

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class);
    }
}
