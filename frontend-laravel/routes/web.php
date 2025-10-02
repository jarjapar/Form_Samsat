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

Route::get('/', function () {
    return view('welcome');
});

use App\Services\ApiClient;

Route::get('/test-stats', function(ApiClient $api){
  return response()->json($api->get('stats')); // harus keluar JSON stats
});

use Illuminate\Support\Facades\Http;

Route::get('/test-stats', function () {
    $res = Http::acceptJson()->get(env('API_BASE').'/stats');
    return $res->successful()
        ? $res->json()
        : response()->json(['ok'=>false,'status'=>$res->status(),'body'=>$res->body()], $res->status());
});


Route::get('/', function () {
    return view('home');
})->name('landing');


