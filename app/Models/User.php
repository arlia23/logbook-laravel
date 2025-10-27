<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'tipe_user',
        'nip',
        'unit_fakultas',
        'jabatan',
        'lokasi_presensi',
        'contact_phone',
        'email_address',
        'tempat_lahir',
        'tanggal_lahir',
    ];

   
    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function rekapKehadirans()
    {
        return $this->hasMany(RekapKehadiran::class);
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
}
