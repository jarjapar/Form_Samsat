<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Http;
use App\Services\ApiClient;

// Landing page
Route::get('/', function () {
    return view('home');   // jangan pakai ".home"
})->name('landing');

// Test stats (pilih salah satu, contoh langsung Http)
Route::get('/test-stats', function () {
    $res = Http::acceptJson()->get(env('API_BASE').'/stats');
    return $res->successful()
        ? $res->json()
        : response()->json(['ok'=>false,'status'=>$res->status(),'body'=>$res->body()], $res->status());
});

Route::get('/', fn () => view('home'))->name('landing');

// Pengaduan page
Route::get('/pengaduan', fn () => view('pengaduan'))->name('pengaduan');
