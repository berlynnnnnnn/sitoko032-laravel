<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProdukController extends Controller
{
    public function index(Request $request): View
    {
        $search     = $request->query('search');
        $kategoriId = $request->query('kategori');

        $query = Produk::with('kategori');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (!empty($kategoriId) && $kategoriId > 0) {
            $query->where('id_kategori', $kategoriId);
        }

        $products = $query->orderBy('id_produk', 'desc')->paginate(6)->withQueryString();
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();

        $currentUser = Auth::user();

        return view('produk.index', [
            'pageTitle'   => ($currentUser->role->nama_role === 'Pelanggan') ? 'Katalog Produk' : 'Kelola Produk',
            'activeMenu'  => 'produk',
            'products'    => $products,
            'categories'  => $categories,
            'search'      => $search,
            'kategoriId'  => $kategoriId,
            'currentUser' => $currentUser,
        ]);
    }

    public function create(): View
    {
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();
        $randomCode = 'PRD-032-' . str_pad((string)rand(100, 999), 3, '0', STR_PAD_LEFT);

        return view('produk.tambah', [
            'pageTitle'   => 'Tambah Produk',
            'activeMenu'  => 'produk',
            'categories'  => $categories,
            'defaultCode' => $randomCode,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_kategori' => 'required|exists:t032_kategori,id_kategori',
            'kode_produk' => 'required|string|max:50|unique:t032_produk,kode_produk',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Maksimal 2 MB
        ], [
            'id_kategori.required' => 'Kategori produk wajib dipilih.',
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.unique'   => 'Kode produk sudah terdaftar.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required'       => 'Harga jual wajib diisi.',
            'stok.required'        => 'Stok produk wajib diisi.',
            'gambar.image'         => 'Berkas harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max'           => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $gambarPath = 'uploads/produk/default.png';

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = 'prd_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $fileName);
            $gambarPath = 'uploads/produk/' . $fileName;
        }

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('produk.index')
            ->with('success', "Produk '{$produk->nama_produk}' ({$produk->kode_produk}) berhasil ditambahkan.");
    }

    public function edit($id): View
    {
        $produk = Produk::findOrFail($id);
        $categories = Kategori::orderBy('nama_kategori', 'asc')->get();

        return view('produk.edit', [
            'pageTitle'  => 'Edit Produk',
            'activeMenu' => 'produk',
            'product'    => $produk,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:t032_kategori,id_kategori',
            'kode_produk' => 'required|string|max:50|unique:t032_produk,kode_produk,' . $id . ',id_produk',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Maksimal 2 MB
        ], [
            'id_kategori.required' => 'Kategori produk wajib dipilih.',
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.unique'   => 'Kode produk sudah terdaftar.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required'       => 'Harga jual wajib diisi.',
            'stok.required'        => 'Stok produk wajib diisi.',
            'gambar.image'         => 'Berkas harus berupa gambar.',
            'gambar.mimes'         => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar.max'           => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $gambarPath = $produk->gambar;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = 'prd_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/produk'), $fileName);
            $gambarPath = 'uploads/produk/' . $fileName;
        }

        $produk->update([
            'id_kategori' => $request->id_kategori,
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('produk.index')
            ->with('success', "Data produk '{$produk->nama_produk}' berhasil diperbarui.");
    }

    public function destroy($id): RedirectResponse
    {
        // Proteksi Role: Hanya Admin yang berhak menghapus produk!
        $currentUser = Auth::user();
        if ($currentUser->role->nama_role !== 'Admin') {
            abort(403, 'Akses ditolak. Hanya Admin yang berhak menghapus produk.');
        }

        $produk = Produk::findOrFail($id);
        $namaProduk = $produk->nama_produk;

        if ($produk->gambar && strpos($produk->gambar, 'default') === false) {
            $fullPath = public_path($produk->gambar);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', "Produk '{$namaProduk}' berhasil dihapus dari sistem.");
    }
}
