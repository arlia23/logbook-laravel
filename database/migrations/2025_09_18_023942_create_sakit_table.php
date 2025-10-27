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
        Schema::create('sakit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // relasi ke users
            $table->string('nama_pegawai');
            $table->text('keterangan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('no_surat_ket_sakit');
            $table->date('tgl_surat_ket_sakit');
            $table->timestamps();

            // kalau mau relasi foreign key ke users
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sakit');
    }
};
