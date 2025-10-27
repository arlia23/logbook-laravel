<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCuti
 */
class Cuti extends Model
{
    use HasFactory;

    protected $table = 'cuti'; // sesuaikan nama tabelmu
    protected $fillable = [
        'user_id',
        'nama_pegawai',
        'jenis_cuti',
        'keterangan',
        'tgl_mulai',
        'tgl_selesai',
        'no_surat_cuti',
        'tgl_surat_cuti',
    ];

    protected $dates = ['tgl_mulai','tgl_selesai','tgl_surat_cuti'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
