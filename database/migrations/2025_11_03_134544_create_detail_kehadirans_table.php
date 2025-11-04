<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_kehadirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('status', ['H', 'DL', 'C', 'S', 'A'])->default('H'); 
            // H = Hadir, DL = Dinas Luar, C = Cuti, S = Sakit, A = Alpha
            $table->enum('kegiatan', ['WFO', 'WFH'])->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tanggal']); // agar tiap user hanya 1 data per hari
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_kehadirans');
    }
};
