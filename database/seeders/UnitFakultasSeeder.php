<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitFakultasSeeder extends Seeder
{
    public function run()
    {
        DB::table('unit_fakultas')->insert([
            ['nama' => 'BIRO AKADEMIS KEMAHASISWAAN'],
            ['nama' => 'BIRO PERENCANAAN DAN HUBUNGAN MASYARAKAT'],
            ['nama' => 'BIRO UMUM KEUANGAN'],
            ['nama' => 'Fakultas Ekonomi dan Bisnis'],
            ['nama' => 'Fakultas Hukum'],
            ['nama' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['nama' => 'Fakultas Kedokteran'],
            ['nama' => 'Fakultas Keguruan dan Ilmu Pendidikan'],
            ['nama' => 'Fakultas Keperawatan'],
            ['nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam'],
            ['nama' => 'Fakultas Perikanan dan Kelautan'],
            ['nama' => 'Fakultas Pertanian'],
            ['nama' => 'Fakultas Teknik'],
            ['nama' => 'KANTOR URUSAN INTERNASIONAL'],
            ['nama' => 'LPPM'],
            ['nama' => 'LPPMP'],
            ['nama' => 'P2K2'],
            ['nama' => 'PASCASARJANA'],
            ['nama' => 'Rektorat'],
            ['nama' => 'RSP'],
            ['nama' => 'Satuan Pengawas Internal'],
            ['nama' => 'Security'],
            ['nama' => 'UPA Bahasa'],
            ['nama' => 'UPA Bimbingan Konseling'],
            ['nama' => 'UPA Laboratorium Terpadu'],
            ['nama' => 'UPA Layanan Uji Kompetensi'],
            ['nama' => 'UPA Pengembangan Karir dan Kewirausahaan'],
            ['nama' => 'UPA Percetakan dan Penerbitan'],
            ['nama' => 'UPA Perpustakaan'],
            ['nama' => 'UPA Teknologi Informasi dan Komunikasi'],
        ]);
    }
}
