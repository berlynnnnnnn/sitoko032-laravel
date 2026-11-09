<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes SiToko-032
|--------------------------------------------------------------------------
| Seluruh rute diawali dengan prefix /api/ dan menghasilkan JSON murni
*/

// Default API Documentation Index
Route::get('/', function () {
    return response()->json([
        'aplikasi'   => 'SiToko-032',
        'developer'  => 'Berlynda Vanetta (25.K1.0032)',
        'status'     => 'Laravel REST API Online & Operasional',
        'endpoints'  => [
            'GET    /api/identitas'       => 'Mengambil identitas mahasiswa & nama aplikasi',
            'POST   /api/login'           => 'Login untuk mendapatkan auth_token (Bearer Token)',
            'GET    /api/produk'          => 'Mengambil daftar produk (query: search, kategori_id, page, limit)',
            'GET    /api/produk/{id}'     => 'Mengambil detail 1 produk berdasarkan ID',
            'POST   /api/produk'          => 'Menambah produk baru (Role: Admin, Kasir)',
            'PUT    /api/produk/{id}'     => 'Mengubah data produk (Role: Admin, Kasir)',
            'DELETE /api/produk/{id}'     => 'Menghapus produk (Role: Admin Only)',
        ],
    ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});

// 1. Endpoint Identitas (Wajib)
Route::get('/identitas', [AuthController::class, 'getIdentitas']);

// 2. Endpoint Autentikasi Token API
Route::post('/login', [AuthController::class, 'login']);

// 3. 5 Endpoint CRUD Produk Terproteksi Token & Role
Route::middleware('api.token')->group(function () {
    // Read: Semua role yang memiliki token aktif
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/produk/{id}', [ProdukController::class, 'show']);

    // Create & Update: Hanya Admin & Kasir
    Route::middleware('api.token:Admin,Kasir')->group(function () {
        Route::post('/produk', [ProdukController::class, 'store']);
        Route::put('/produk/{id}', [ProdukController::class, 'update']);
        Route::patch('/produk/{id}', [ProdukController::class, 'update']);
    });

    // Delete: HANYA Admin
    Route::middleware('api.token:Admin')->group(function () {
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
    });
});
