<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    //
    protected $fillable = [
        'gambar',
        'agenda_id',
    ];

    public function agenda()
    {
        return $this->belongsTo('App\Agenda');
    }
}
