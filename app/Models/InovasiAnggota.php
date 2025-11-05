<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InovasiAnggota extends Model
{
    protected $fillable = ['inovasi_id', 'user_id', 'peran'];

    public function periode()
    {
        return $this->belongsTo(Inovasi::class, 'inovasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
