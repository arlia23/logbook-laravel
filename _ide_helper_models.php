<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nama_pegawai
 * @property string $jenis_cuti
 * @property string $keterangan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $no_surat_cuti
 * @property string $tgl_surat_cuti
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereJenisCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereNamaPegawai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereNoSuratCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereTglSuratCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cuti whereUserId($value)
 */
	class Cuti extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $tanggal
 * @property string $status
 * @property string|null $kegiatan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetailKehadiran whereUserId($value)
 */
	class DetailKehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nama_pegawai
 * @property string $nama_kegiatan
 * @property string $lokasi_kegiatan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $no_surat_tugas
 * @property string $tgl_surat_tugas
 * @property string $jenis_tugas
 * @property string|null $file_surat_tugas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereFileSuratTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereJenisTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereLokasiKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereNamaKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereNamaPegawai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereNoSuratTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereTglSuratTugas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DinasLuar whereUserId($value)
 */
	class DinasLuar extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Kehadiran query()
 */
	class Kehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $tanggal
 * @property string $kegiatan
 * @property string|null $catatan_pekerjaan
 * @property string|null $jam_masuk
 * @property string|null $jam_pulang
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereCatatanPekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereJamPulang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Logbook whereUserId($value)
 */
	class Logbook extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $minggu_mulai
 * @property string $minggu_selesai
 * @property string|null $catatan_supervisor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereCatatanSupervisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereMingguMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereMingguSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Monitoring whereUserId($value)
 */
	class Monitoring extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $tanggal
 * @property string|null $jam_masuk
 * @property string|null $jam_pulang
 * @property string $status_kehadiran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereJamPulang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereStatusKehadiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presensi whereUserId($value)
 */
	class Presensi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $bulan
 * @property int $tahun
 * @property int $jumlah_hadir
 * @property int $jumlah_dinas_luar
 * @property int $jumlah_cuti
 * @property int $jumlah_sakit
 * @property int $jumlah_alpha
 * @property int|null $jumlah_wfo
 * @property int|null $jumlah_wfh
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahAlpha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahDinasLuar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahHadir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahSakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahWfh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereJumlahWfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RekapKehadiran whereUserId($value)
 */
	class RekapKehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string $nama_pegawai
 * @property string $keterangan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $no_surat_ket_sakit
 * @property string $tgl_surat_ket_sakit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereNamaPegawai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereNoSuratKetSakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereTglMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereTglSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereTglSuratKetSakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sakit whereUserId($value)
 */
	class Sakit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $tipe_user
 * @property string|null $nip
 * @property string|null $unit_fakultas
 * @property string|null $jabatan
 * @property string|null $lokasi_presensi
 * @property string|null $contact_phone
 * @property string|null $email_address
 * @property string|null $tempat_lahir
 * @property string|null $tanggal_lahir
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Logbook> $logbooks
 * @property-read int|null $logbooks_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Presensi> $presensis
 * @property-read int|null $presensis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RekapKehadiran> $rekapKehadirans
 * @property-read int|null $rekap_kehadirans_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLokasiPresensi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTipeUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUnitFakultas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

