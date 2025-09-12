<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logbook;
use App\Models\User;

class LogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // ambil user pertama

        Logbook::create([
            'user_id' => $user->id,
            'tanggal' => now()->toDateString(),
            'kegiatan' => 'WFO',
            'catatan_pekerjaan' => 'Masih ada bug kecil di bagian update',
            'jam_masuk' => '08:00:00',
            'jam_pulang' => '16:00:00',
            'status' => 'Selesai',
        ]);

        Logbook::create([
            'user_id' => $user->id,
            'tanggal' => now()->subDay()->toDateString(),
            'kegiatan' => 'WFH',
            'catatan_pekerjaan' => null,
            'jam_masuk' => '09:00:00',
            'jam_pulang' => '15:30:00',
            'status' => 'Belum',
        ]);
    }
}
