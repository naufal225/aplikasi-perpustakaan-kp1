<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PustakawanController;
use App\Http\Controllers\TransaksiKembaliController;
use App\Http\Controllers\TransaksiPinjamController;
use App\Models\Buku;
use App\Models\TransaksiKembali;
use App\Models\TransaksiPinjam;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function() {
    return view("login.index");
})->middleware("guest");

Route::post("/login", [LoginController::class, "authenticate"])->middleware("guest");

Route::get("/logout", [LoginController::class, "logout"])->middleware("auth");

Route::get('/home', [DashboardController::class, "index"])->middleware("auth");

Route::resource('/kelola-data-member', MemberController::class)->middleware("auth")->parameters(['members' => 'kode_member']);

Route::resource('/kelola-data-buku', BukuController::class)->middleware("auth");

Route::resource('/kelola-data-kategori', KategoriController::class)->middleware("auth");

Route::resource('/kelola-data-pustakawan', PustakawanController::class)->middleware("auth");

Route::resource('/transaksi/pinjam-buku', TransaksiPinjamController::class)->middleware("auth");

Route::get('/transaksi/tambah-transaksi-pinjam/simpan', [TransaksiPinjamController::class, "store"])->middleware("auth");

Route::resource('/transaksi/kembali-buku', TransaksiKembaliController::class)->middleware("auth");

Route::get('/transaksi/tambah-transaksi-pinjam', [TransaksiPinjamController::class, "tambahTransaksi"])->middleware("auth");

Route::get('/transaksi/tambah-transaksi-kembali/cari-transaksi-pinjam', [TransaksiKembaliController::class, "cariTransaksiPinjam"])->middleware("auth");

Route::post('/hapus-item/{kode_buku}', [TransaksiPinjamController::class, 'hapusItem'])->name('hapus.item');
// Route::get('/kelola-data-member/search', [MemberController::class, "search"])->middleware("auth");

