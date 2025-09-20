<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiPresensiSeeder extends Seeder
{
    public function run()
    {
        DB::table('lokasi_presensi')->insert([
            ['nama' => 'UPT Bahasa'],
            ['nama' => 'UPT Pustaka'],
            ['nama' => 'UPT TIK'],
            ['nama' => 'RSP'],
            ['nama' => 'Rektorat'],
        ]);
    }
}
