<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes SiToko-032
|--------------------------------------------------------------------------
*/

// Guest Routes (Autentikasi)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Authenticated Routes (Harus Login Dulu)
Route::middleware('auth')->group(function () {
    // Root Redirect ke Dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Dashboard & Info API
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/api-doc', [DashboardController::class, 'apiDoc'])->name('api.doc');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Profil Saya & Upload Foto Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');

    // Katalog / Kelola Produk (Dapat dilihat semua pengguna)
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');

    // CRUD Produk & Kategori (Hanya Admin & Kasir)
    Route::middleware('role:Admin,Kasir')->group(function () {
        Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');

        // CRUD Kategori
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::get('/kategori/{id}/hapus', [KategoriController::class, 'destroy'])->name('kategori.hapus');
    });

    // Hapus Produk (KHUSUS Admin!)
    Route::middleware('role:Admin')->group(function () {
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
        Route::get('/produk/{id}/hapus', [ProdukController::class, 'destroy'])->name('produk.hapus');
    });
});