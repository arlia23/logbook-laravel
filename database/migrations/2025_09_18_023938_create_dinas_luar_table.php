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
        Schema::create('dinas_luar', function (Blueprint $table) {
            $table->id();

            // relasi ke users (nullable karena di data lama ada NULL)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nama_pegawai');
            $table->string('nama_kegiatan');
            $table->string('lokasi_kegiatan');

            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();

            $table->string('no_surat_tugas')->nullable();
            $table->date('tgl_surat_tugas')->nullable();

            $table->string('jenis_tugas')->nullable();
            $table->string('file_surat_tugas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinas_luar');
    }
};
