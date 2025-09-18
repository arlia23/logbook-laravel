<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DinasLuar extends Model
{
    use HasFactory;

    // Nama tabel (opsional kalau sesuai konvensi Laravel)
    protected $table = 'dinas_luar';

    // Kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'nama_pegawai',
        'nama_kegiatan',
        'lokasi_kegiatan',
        'tgl_mulai',
        'tgl_selesai',
        'no_surat_tugas',
        'tgl_surat_tugas',
        'jenis_tugas',
        'file_surat_tugas',
    ];
}
