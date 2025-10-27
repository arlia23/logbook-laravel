<?php

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\CutiController;
use App\Http\Controllers\Admin\DinasLuarController;
use App\Http\Controllers\Admin\LogbookController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\RekapKehadiranController;
use App\Http\Controllers\Admin\SakitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserBaseController;
use App\Http\Controllers\User\UserCutiController;
use App\Http\Controllers\User\UserDinasLuarController;
use App\Http\Controllers\User\UserKehadiranController;
use App\Http\Controllers\User\UserPresensiController;
use App\Http\Controllers\User\UserLogbookController;
use App\Http\Controllers\User\UserMonitoringController;
use App\Http\Controllers\User\UserRekapController;
use App\Http\Controllers\User\UserSakitController;
use App\Http\Controllers\ExcelController;



use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// ini route admin
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::controller(BaseController::class)->group(function () {
        Route::get('/home', 'index')->name('admin.home');

        // ✅ Tambahkan ini di sini ⬇️⬇️⬇️
        Route::get('/hadir-hari-ini', 'getHadirHariIni')->name('admin.hadirHariIni');

        // Data User & Admin
        Route::get('/data-user', 'dataUser')->name('data.user');
        Route::get('/data-admin', 'dataAdmin')->name('data.admin');

        // Tambah & Hapus
        Route::delete('/data-user/delete', 'deleteUser')->name('data.user.delete');
        Route::delete('/data-admin/delete', 'deleteAdmin')->name('data.admin.delete');
        Route::post('/data-admin/create', 'createAdmin')->name('create.admin');
        Route::post('/data-user/create', 'createUser')->name('create.user');

        // ✨ Edit & Update User Admin
        Route::get('/data-user/{id}/edit', 'editUser')->name('data.user.edit');
        Route::put('/data-user/{id}', 'updateUser')->name('data.user.update');

        Route::post('/search', 'search')->name('user.search');
        // 📊 Statistik Pegawai
        Route::get('/statistik-pegawai', 'statistikPegawai')->name('admin.statistik-pegawai');
    });

    Route::controller(LogbookController::class)->group(function () {
        Route::get('/logbook', 'index')->name('admin.logbook.index');
        Route::get('/logbook/{logbook}', 'show')->name('admin.logbook.show');
        Route::delete('/logbook/{logbook}', 'destroy')->name('admin.logbook.destroy');
    });

    Route::controller(PresensiController::class)->group(function () {
        Route::get('/presensi', 'index')->name('admin.presensi.index');
        Route::get('/presensi/{id}', 'show')->name('admin.presensi.show');
        Route::delete('/presensi/{id}', 'destroy')->name('admin.presensi.destroy');
    });

    // 📊 Rekap Kehadiran + Export
    Route::controller(RekapKehadiranController::class)->group(function () {
        Route::get('/rekap', 'index')->name('admin.rekap.index');
        Route::get('/rekap/export', 'export')->name('admin.rekap.export');
    });

    Route::controller(DinasLuarController::class)->group(function () {
        Route::get('/dinas-luar', 'index')->name('admin.dinas.index');
        Route::get('/dinas-luar/{id}', 'show')->name('admin.dinas.show');
        Route::put('/dinas-luar/{id}/approve', 'approve')->name('admin.dinas.approve');
        Route::put('/dinas-luar/{id}/reject', 'reject')->name('admin.dinas.reject');
        Route::delete('/dinas-luar/{id}', 'destroy')->name('admin.dinas.destroy');
    });

    // 🤒 SAKIT
    Route::controller(SakitController::class)->group(function () {
        Route::get('/sakit', 'index')->name('admin.sakit.index');
        Route::get('/sakit/{id}', 'show')->name('admin.sakit.show');
        Route::put('/sakit/{id}/approve', 'approve')->name('admin.sakit.approve');
        Route::put('/sakit/{id}/reject', 'reject')->name('admin.sakit.reject');
        Route::delete('/sakit/{id}', 'destroy')->name('admin.sakit.destroy');
    });

    // 🌴 CUTI
    Route::controller(CutiController::class)->group(function () {
        Route::get('/cuti', 'index')->name('admin.cuti.index');
        Route::get('/cuti/{id}', 'show')->name('admin.cuti.show');
        Route::put('/cuti/{id}/approve', 'approve')->name('admin.cuti.approve');
        Route::put('/cuti/{id}/reject', 'reject')->name('admin.cuti.reject');
        Route::delete('/cuti/{id}', 'destroy')->name('admin.cuti.destroy');
    });

    Route::controller(MonitoringController::class)->group(function () {
        Route::get('/monitoring', 'index')->name('admin.monitoring.index');
        Route::post('/monitoring/store', 'store')->name('admin.monitoring.store');
        Route::put('/monitoring/update', 'update')->name('admin.monitoring.update');
    });
});



//ini untuk user
Route::prefix('user')->middleware(['auth', 'isUser'])->group(function () {
    // 🏠 DASHBOARD
    Route::controller(UserBaseController::class)->group(function () {
        Route::get('/home', 'index')->name('user.home');
    });

    // 👤 PROFILE
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('user.profile.index');
        Route::get('/profile/edit', 'edit')->name('user.profile.edit');
        Route::put('/profile', 'update')->name('user.profile.update');
    });

    // ⏰ Presensi
    Route::controller(UserPresensiController::class)->group(function () {
        Route::get('/presensi', 'index')->name('user.presensi.index');
        Route::post('/presensi/masuk', 'masuk')->name('user.presensi.masuk');
        Route::post('/presensi/pulang', 'pulang')->name('user.presensi.pulang');
    });



    // 📝 LOGBOOK
    Route::controller(UserLogbookController::class)->group(function () {
        Route::get('/logbook', 'index')->name('logbook.index');
        Route::post('/logbook', 'store')->name('logbook.store');
        Route::get('/user/logbook/cetak/{jenis}', 'cetak')->name('logbook.cetak');
    });

    // 📖 HELP
    Route::get('/help', function () {
        return view('user.help');
    })->name('user.help');

    // 📍 DINAS LUAR
    Route::controller(UserDinasLuarController::class)->group(function () {
        Route::get('/dinas-luar', 'index')->name('user.dinas.index');
        Route::get('/dinas-luar/create', 'create')->name('user.dinas.create');
        Route::post('/dinas-luar', 'store')->name('user.dinas.store');
        Route::get('/dinas-luar/{id}', 'show')->name('user.dinas.show');
        Route::get('/dinas-luar/{dinasLuar}/edit', 'edit')->name('user.dinas.edit');
        Route::put('/dinas-luar/{dinasLuar}', 'update')->name('user.dinas.update');
        Route::delete('/dinas-luar/{dinasLuar}', 'destroy')->name('user.dinas.destroy');
    });

    // 🤒 SAKIT
    Route::controller(UserSakitController::class)->group(function () {
        Route::get('/sakit', 'index')->name('user.sakit.index');
        Route::get('/sakit/create', 'create')->name('user.sakit.create');
        Route::post('/sakit', 'store')->name('user.sakit.store');
        Route::get('/sakit/{id}', 'show')->name('user.sakit.show');
        Route::get('/sakit/{id}/edit', 'edit')->name('user.sakit.edit');
        Route::put('/sakit/{id}', 'update')->name('user.sakit.update');
        Route::delete('/sakit/{id}', 'destroy')->name('user.sakit.destroy');
    });

    // 🌴 CUTI
    Route::controller(UserCutiController::class)->group(function () {
        Route::get('/cuti', 'index')->name('user.cuti.index');
        Route::get('/cuti/create', 'create')->name('user.cuti.create');
        Route::post('/cuti', 'store')->name('user.cuti.store');
        Route::get('/cuti/{id}', 'show')->name('user.cuti.show');
        Route::get('/cuti/{cuti}/edit', 'edit')->name('user.cuti.edit');
        Route::put('/cuti/{cuti}', 'update')->name('user.cuti.update');
        Route::delete('/cuti/{cuti}', 'destroy')->name('user.cuti.destroy');

         // 🧾 Tambahkan di dalam grup ini
    Route::get('/cuti/{id}/download', 'downloadSurat')->name('user.cuti.download');
    });

    
    // 📊 MONITORING
    Route::controller(UserMonitoringController::class)->group(function () {
        Route::get('/monitoring', 'index')->name('user.monitoring.index');
    });

    // 📌 KEHADIRAN
    Route::controller(UserKehadiranController::class)->group(function () {
        Route::get('/kehadiran', 'index')->name('user.kehadiran.index');
    });

   // 📊 REKAP KEHADIRAN


Route::controller(UserRekapController::class)->group(function () {
    Route::get('/rekap', 'index')->name('user.rekap.index');
});

// Route export dipisah ke controller Excel
Route::get('/user/rekap/export', [ExcelController::class, 'exportUsers'])
    ->name('user.rekap.export');

});


Route::get('/export-users', [ExcelController::class, 'exportUsers'])->name('export.users');
