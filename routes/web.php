<?php

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Admin\LogbookController;
use App\Http\Controllers\Admin\PresensiController;
use App\Http\Controllers\Admin\RekapKehadiranController;
use App\Http\Controllers\Admin\TidakHadirController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ProfileController;


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
    Route::controller(TidakHadirController::class)->group(function () {
        Route::get('/tidak-hadir', 'index')->name('admin.tidak_hadir.index');
        Route::get('/tidak-hadir/{id}', 'show')->name('admin.tidak_hadir.show');
        Route::delete('/tidak-hadir/{id}', 'destroy')->name('admin.tidak_hadir.destroy');
    });
    Route::controller(RekapKehadiranController::class)->prefix('rekap')->name('admin.rekap.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/generate', 'generate')->name('generate'); 
    });
});



Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

