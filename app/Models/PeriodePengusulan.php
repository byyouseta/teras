<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodePengusulan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['nama_periode', 'tahun', 'status', 'mulai', 'selesai'];

    public function inovasis()
    {
        return $this->hasMany(Inovasi::class, 'periode_id');
    }
}
