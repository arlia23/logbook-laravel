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
use App\Http\Controllers\User\UserPresensiController;
use App\Http\Controllers\User\UserLogbookController;
use App\Http\Controllers\User\UserMonitoringController;
use App\Http\Controllers\User\UserSakitController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// ini route admin
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::controller(BaseController::class)->group(function () {
        Route::get('/home', 'index')->name('index.home');
        Route::get('/data-user', 'dataUser')->name('data.user');
        Route::get('/data-admin', 'dataAdmin')->name('data.admin');
        Route::delete('/data-user/delete', 'deleteUser')->name('data.user.delete');
        Route::delete('/data-admin/delete', 'deleteAdmin')->name('data.admin.delete');
        Route::post('/data-admin/create', [BaseController::class, 'createAdmin'])->name('create.admin');
        Route::post('/data-user/create', [BaseController::class, 'createUser'])->name('create.user');
        Route::post('/search', 'search')->name('user.search');
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
    Route::controller(RekapKehadiranController::class)->prefix('rekap')->name('admin.rekap.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/generate', 'generate')->name('generate');
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
    Route::controller(UserBaseController::class)->group(function () {
        Route::get('/home', 'index')->name('index.home');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('user.profile.index'); // tampilkan profil
        Route::get('/profile/edit', 'edit')->name('user.profile.edit'); // form edit
        Route::put('/profile', 'update')->name('user.profile.update'); // simpan perubahan
    });

    Route::controller(UserPresensiController::class)->group(function () {
        Route::get('/presensi',  [UserPresensiController::class, 'index'])->name('presensi.index');
        Route::post('/presensi/masuk', [UserPresensiController::class, 'masuk'])->name('presensi.masuk');
        Route::post('/presensi', 'store')->name('presensi.store');
    });

    // 📝 LOGBOOK
    Route::controller(UserLogbookController::class)->group(function () {
        Route::get('/logbook', [UserLogbookController::class, 'index'])->name('logbook.index');
        Route::post('/logbook', 'store')->name('logbook.store');
    });

    Route::get('/help', function () {
        return view('user.help');
    })->name('user.help');

    // 📍 DINAS LUAR
    Route::controller(UserDinasLuarController::class)->group(function () {
        Route::get('/dinas-luar', 'index')->name('user.dinas.index');
        Route::get('/dinas-luar/create', 'create')->name('user.dinas.create');
        Route::post('/dinas-luar', 'store')->name('user.dinas.store');
        Route::get('/dinas-luar/{id}', 'show')->name('user.dinas.show');
        Route::put('/dinas-luar/{dinasLuar}', 'update')->name('user.dinas.update');
        Route::get('/dinas-luar/{dinasLuar}/edit', 'edit')->name('user.dinas.edit');
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
        Route::get('/cuti/{cuti}/edit', [UserCutiController::class, 'edit'])->name('user.cuti.edit');
        Route::put('/cuti/{cuti}', [UserCutiController::class, 'update'])->name('user.cuti.update');
        Route::delete('/cuti/{cuti}', [UserCutiController::class, 'destroy'])->name('user.cuti.destroy');
    });
    Route::controller(UserMonitoringController::class)->group(function () {
        Route::get('/monitoring', 'index')->name('user.monitoring.index');
    });
});
