<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izinsaathadir extends Model
{
    use HasFactory;

    protected $table = 'izinsaathadir';

    protected $fillable = [
        'user_id',
        'jenis_izin',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'alasan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function izinsaathadir()
{
    return $this->hasMany(Izinsaathadir::class, 'user_id');
}

}
