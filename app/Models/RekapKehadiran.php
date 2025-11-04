<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRekapKehadiran
 */
class RekapKehadiran extends Model
{
    use HasFactory;

    protected $table = 'rekap_kehadirans'; // nama tabel

    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'jumlah_hadir',
        'jumlah_dinas_luar',
        'jumlah_cuti',
        'jumlah_sakit',
        'jumlah_alpha',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
