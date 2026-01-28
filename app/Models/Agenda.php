<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Agenda extends Model
{
    //
    protected $table = "agenda";

    protected $fillable = [
        'nama_agenda',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'ruangan_id',
        'status',
        'pic',
        'notulen',
        'keterangan',
        'verifikator',
        'catatan',
        'daftar',
        'notulen_ol',
        'materi',
        'pengundang',
        'nip_pengundang',
        'jab_pengundang'
    ];

    public function user()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('id', 'urutan', 'presensi', 'presensi_at')->withTimestamps()->orderBy('urutan')->orderBy('name', 'asc');
    }

    public function userpic()
    {
        return $this->belongsTo('App\Models\User', 'pic', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo('App\Models\Ruangan');
    }

    public function tamu()
    {
        return $this->hasMany('App\Models\Tamu');
    }

    public function gambar()
    {
        return $this->hasMany('App\Models\Gambar');
    }

    public static function pesan()
    {
        $pesan = DB::table('agenda')
            ->join('agenda_user', 'agenda_user.agenda_id', '=', 'agenda.id')
            ->join('users', 'agenda.pic', '=', 'users.id')
            ->join('ruangan', 'agenda.ruangan_id', '=', 'ruangan.id')
            ->select(
                'agenda.*',
                'ruangan.nama as nama_ruangan',
                'users.name as pic_name',
                'agenda_user.presensi as presensi',
                'agenda_user.presensi_at as waktu_presensi'
            )
            ->where('agenda_user.user_id', '=', Auth::user()->id)
            ->where('agenda_user.presensi', '=', 'belum')
            ->orderBy('agenda.status', 'asc')
            ->orderBy('tanggal', 'desc')
            ->get();

        return $pesan;
    }
}
