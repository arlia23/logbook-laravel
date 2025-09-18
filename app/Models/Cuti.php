<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (karena bukan jamak)
    protected $table = 'cuti';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_pegawai',
        'jenis_cuti',
        'keterangan',
        'tgl_mulai',
        'tgl_selesai',
        'no_surat_cuti',
        'tgl_surat_cuti',
    ];
}
