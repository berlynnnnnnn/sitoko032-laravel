<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProduk   = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser     = User::count();
        $totalPesanan  = Pesanan::count();

        $latestProducts = Produk::with('kategori')
            ->orderBy('id_produk', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'pageTitle'      => 'Dashboard',
            'activeMenu'     => 'dashboard',
            'currentUser'    => Auth::user(),
            'totalProduk'    => $totalProduk,
            'totalKategori'  => $totalKategori,
            'totalUser'      => $totalUser,
            'totalPesanan'   => $totalPesanan,
            'latestProducts' => $latestProducts,
        ]);
    }

    public function apiDoc(): View
    {
        return view('dashboard.api_doc', [
            'pageTitle'   => 'Dokumentasi REST API',
            'activeMenu'  => 'api',
            'currentUser' => Auth::user(),
            'apiBaseUrl'  => url('api'),
        ]);
    }
}
