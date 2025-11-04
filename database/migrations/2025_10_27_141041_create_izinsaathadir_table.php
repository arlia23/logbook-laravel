<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('izinsaathadir', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('jenis_izin');
        $table->date('tanggal'); // 🆕 tanggal pengajuan izin
        $table->time('jam_mulai'); // 🆕 jam mulai
        $table->time('jam_selesai'); // 🆕 jam selesai
        $table->text('alasan');
        $table->string('status')->default('pending');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izinsaathadir');
    }
};
