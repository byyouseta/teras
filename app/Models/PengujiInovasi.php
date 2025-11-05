<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengujiInovasi extends Model
{
    protected $fillable = [
        'inovasi_id',
        'user_id',
    ];

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
