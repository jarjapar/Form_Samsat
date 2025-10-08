<?php

use Illuminate\Support\Facades\Route;

// Public
Route::view('/', 'home')->name('landing');
Route::view('/pengaduan', 'pengaduan')->name('pengaduan');
Route::view('/staf', 'staf')->name('staf');
Route::view('/berita', 'berita')->name('berita');
Route::view('/contact', 'contact')->name('contact');
Route::view('/sop', 'sop')->name('sop');

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PengaduanController;

Route::middleware(['auth','admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // BERITA (CRUD)
        Route::resource('berita', BeritaController::class);
        Route::post('berita/{id}/gambar', [BeritaController::class, 'updateImage'])
            ->name('berita.updateImage');

        // PENGADUAN (read-only + export)
        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/export', [PengaduanController::class, 'export'])->name('pengaduan.export');
    });

