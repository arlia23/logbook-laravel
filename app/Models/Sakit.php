<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sakit extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit (karena bukan jamak)
    protected $table = 'sakit';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_pegawai',
        'keterangan',
        'tgl_mulai',
        'tgl_selesai',
        'no_surat_ket_sakit',
        'tgl_surat_ket_sakit',
    ];
}
