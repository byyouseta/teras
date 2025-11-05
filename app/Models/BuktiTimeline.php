<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiTimeline extends Model
{
    public function timeline()
    {
        return $this->belongsTo('App\Models\AgendaTimeline');
    }
}
