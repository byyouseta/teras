<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'unit_id',
        'password',
        'foto',
        'level',
        'is_active',
        'gender'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function pegawai()
    {
        return $this->hasOne('App\Models\Pegawai');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function agenda()
    {
        return $this->belongsToMany('App\Models\Agenda')->withPivot('id', 'urutan', 'presensi', 'presensi_at')->withTimestamps();
    }

    public function picagenda()
    {
        return $this->hasMany('App\Models\Agenda', 'id', 'pic');
    }

    public function picTimeline()
    {
        return $this->hasMany('App\Models\AgendaTimeline', 'id', 'pic');
    }
}
