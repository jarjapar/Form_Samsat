<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
| Catatan:
| - Halaman "berita" TIDAK lagi pakai Route::view, tapi controller (index & show).
| - Nama route untuk home tetap "landing" agar cocok dengan layout kamu.
*/

Route::view('/', 'home')->name('landing');          // halaman utama
Route::view('/pengaduan', 'pengaduan')->name('pengaduan');
Route::view('/staf', 'staf')->name('staf');
Route::view('/contact', 'contact')->name('contact');
Route::view('/sop', 'sop')->name('sop');

// ====== Berita publik (LIST & DETAIL) ======
use App\Http\Controllers\Site\BeritaController as SiteBerita;
Route::get('/berita', [SiteBerita::class, 'index'])->name('berita.index');     // daftar berita
Route::get('/berita/{slug}', [SiteBerita::class, 'show'])->name('berita.show'); // detail berita

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN PAGES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BeritaController;        // controller admin (CRUD berita, upload gambar)
use App\Http\Controllers\Admin\PengaduanController;

Route::middleware(['auth','admin'])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // ====== BERITA (CRUD) ======
        Route::resource('berita', BeritaController::class);
        Route::post('berita/{id}/gambar', [BeritaController::class, 'updateImage'])
            ->name('berita.updateImage');

        // ====== PENGADUAN (read-only + export) ======
        Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('pengaduan/export', [PengaduanController::class, 'export'])->name('pengaduan.export');
    });
