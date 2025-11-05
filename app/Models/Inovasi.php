<?php

namespace App\Models;

use App\Livewire\Inovasi\BeritaAcara;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Inovasi extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = ['pengusul_id', 'periode_pengusulan_id', 'judul', 'deskripsi', 'status', 'proposal_pdf', 'proposal_word', 'supporting_files'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('inovasi')
            ->logOnly(['judul', 'deskripsi', 'status'])
            ->setDescriptionForEvent(fn(string $eventName) => "Data inovasi {$eventName}")
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function pengusul()
    {
        return $this->belongsTo(User::class, 'pengusul_id');
    }

    public function periode()
    {
        return $this->belongsTo(PeriodePengusulan::class, 'periode_pengusulan_id');
    }

    public function anggota()
    {
        return $this->hasMany(InovasiAnggota::class, 'inovasi_id');
    }

    public function approvals()
    {
        return $this->hasMany(ApprovalInovasi::class, 'inovasi_id');
    }

    public function jadwalPresentasi()
    {
        return $this->hasOne(PresentasiInovasi::class);
    }

    public function beritaAcara()
    {
        return $this->hasOne(BeritaAcaraInovasi::class);
    }

    public function pengujis()
    {
        return $this->hasMany(PengujiInovasi::class);
    }

    public function monitoring()
    {
        return $this->hasMany(InovasiMonitoring::class, 'inovasi_id');
    }
}
