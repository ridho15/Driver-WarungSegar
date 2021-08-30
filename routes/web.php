<?php

use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;

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

// Home Controller
Route::get('/', [HomeController::class, 'index'])->middleware('autentikasi');
Route::get('/home', [HomeController::class, 'index'])->middleware('autentikasi');

// Login Controller
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login/proses', [LoginController::class, 'loginPost']);

// Driver Controller
Route::get('/driver', [DriverController::class, 'index'])->middleware('autentikasi');
Route::get('/driver/detail', [DriverController::class, 'detail'])->middleware('autentikasi');
Route::post('/driver/simpan-driver', [DriverController::class, 'simpanDriver'])->middleware('autentikasi');

// Profile Controller
Route::get('/profile', [ProfileController::class, 'index'])->middleware('autentikasi');
Route::get('/profile/logout', [ProfileController::class, 'logout'])->middleware('autentikasi');
Route::get('/profile/rubah-nama', [ProfileController::class, 'rubahNama'])->middleware('autentikasi');
Route::post('/profile/rubah-nama/post', [ProfileController::class, 'rubahNamaPost'])->middleware('autentikasi');
Route::post('/profile/rubah-password/post', [ProfileController::class, 'rubahPasswordPost'])->middleware('autentikasi');
Route::post('/profile/upload-foto', [ProfileController::class, 'uploadImage'])->middleware('autentikasi');
Route::get('/profile/informasi', [ProfileController::class, 'informasi'])->middleware('autentikasi');

// PesananController
Route::get('/pesanan/detail', [PesananController::class, 'detailPesanan'])->middleware('autentikasi');
Route::get('/pesanan/kirim', [PesananController::class, 'kirimPesanan'])->middleware('autentikasi');
Route::get('/pesanan/batal-kirim', [PesananController::class, 'batalKirim'])->middleware('autentikasi');
Route::get('/pesanan/lihat-semua-lokasi', [PesananController::class, 'lihatSemuaLokasi'])->middleware('autentikasi');
Route::get('/pesanan/siap-dikirim', [PesananController::class, 'siapDikirim'])->middleware('autentikasi');
Route::get('/pesanan/sedang-dikirim', [PesananController::class, 'sedangDikirim'])->middleware('autentikasi');
Route::get('/pesanan/selesai', [PesananController::class, 'pesananSelesai'])->middleware('autentikasi');
Route::get('/pesanan/per-kecamatan', [PesananController::class, 'PerKecamatan'])->middleware('autentikasi');
Route::get('/pesanan/fetch/{pages}', [PesananController::class, 'fetchData'])->middleware('autentikasi');

// Lokasi Controller
Route::get('/lokasi/semua-lokasi', [LokasiController::class, 'semuaLokasi'])->middleware('autentikasi');
Route::get('/lokasi/pesanan', [LokasiController::class, 'lokasiPesanan'])->middleware('autentikasi');
Route::get('/lokasi/fetch/{pages}', [LokasiController::class, 'fetchData'])->middleware('autentikasi');
Route::get('/lokasi/per-kecamatan', [LokasiController::class, 'PerKecamatan'])->middleware('autentikasi');

// Riwayat Controller
Route::get('/riwayat', [RiwayatController::class, 'index'])->middleware('autentikasi');
Route::get('/riwayat/fetch/data-pengiriman', [RiwayatController::class, 'fetchDataPengiriman'])->middleware('autentikasi');
