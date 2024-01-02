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


Route::get('/', function(){
    return redirect("login");
});

Route::middleware(['auth'])->group(function () {
    Route::get("home", "HomeController@index")->name("home");
    
    Route::resource('list', "listC");
    Route::get("pesanan", "pesananC@index");
    Route::get("pesanan/cari", "pesananC@cari")->name("cari.menu");
    Route::post("pesanan", "pesananC@tambah")->name("tambah.pesanan");
    Route::post("jumlah/{idpesanan}/pesanan", "pesananC@jumlah")->name("ubah.jumlah");
    Route::delete("pesanan/{idpesanan}/hapus", "pesananC@hapus")->name("hapus.pesanan");
    
    Route::post("lunas", "pesananC@lunas")->name("bayar.pesanan");
    Route::post("lunasSatuan", "pesananC@lunasSatuan")->name("bayarsatuan.pesanan");
    
    Route::get("meja", "pesananC@meja");
    Route::post("meja", "pesananC@tambahmeja")->name("tambah.meja");
    Route::delete("meja/{idmeja}/hapus", "pesananC@hapusmeja")->name("hapus.meja");
    
    Route::get("laporan", "laporanC@index");
    Route::get("laporan/cetak", "laporanC@cetak")->name("cetak");
    
    
    
    // Route::get('pdf', 'startController@pdf');
    
    Route::get('siswa/export/', 'startController@export');
    
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
