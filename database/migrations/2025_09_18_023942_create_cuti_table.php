<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();

            // 🔗 relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nama_pegawai');
            $table->enum('jenis_cuti', [
                'Cuti Tahunan',
                'Cuti Alasan Penting',
                'Cuti Melahirkan',
                'Cuti Sakit'
            ]);
            $table->text('keterangan')->nullable();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('no_surat_cuti')->nullable();
            $table->date('tgl_surat_cuti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
