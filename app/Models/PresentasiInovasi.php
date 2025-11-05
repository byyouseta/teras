<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresentasiInovasi extends Model
{
    protected $fillable = [
        'inovasi_id',
        'tanggal_presentasi',
        'tempat',
        'catatan',
    ];

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class);
    }
}
