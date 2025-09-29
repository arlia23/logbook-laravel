<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345'),
                'role' => 'admin',
                'tipe_user' => null, // Admin tidak punya tipe_user
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PNS User',
                'email' => 'pns@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345'),
                'role' => 'user',
                'tipe_user' => 'pns',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'P3K User',
                'email' => 'p3k@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345'),
                'role' => 'user',
                'tipe_user' => 'p3k',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Phl User',
                'email' => 'phl@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('12345'),
                'role' => 'user',
                'tipe_user' => 'phl',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
