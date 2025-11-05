<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    //
    use SoftDeletes;
    protected $table = "pegawai";


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }



    protected $fillable = [
        'user_id',
        'alamat',
        'no_hp',
        'eselon',
        'jabatan',
    ];
}
