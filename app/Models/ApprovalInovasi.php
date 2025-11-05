<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalInovasi extends Model
{
    protected $fillable = ['inovasi_id', 'user_id', 'status', 'catatan'];

    public function inovasi()
    {
        return $this->belongsTo(Inovasi::class, 'inovasi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
