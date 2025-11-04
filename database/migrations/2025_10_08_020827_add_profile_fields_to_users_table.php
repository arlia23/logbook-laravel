<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('tipe_user');
            $table->string('unit_fakultas')->nullable()->after('nip');
            $table->string('jabatan')->nullable()->after('unit_fakultas');
            $table->string('lokasi_presensi')->nullable()->after('jabatan');
            $table->string('contact_phone')->nullable()->after('lokasi_presensi');
            $table->string('tempat_lahir')->nullable()->after('contact_phone');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nip',
                'unit_fakultas',
                'jabatan',
                'lokasi_presensi',
                'tempat_lahir',
                'tanggal_lahir',
            ]);
        });
    }
}
