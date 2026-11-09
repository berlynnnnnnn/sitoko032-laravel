<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = Kategori::withCount('produk');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('id_kategori', 'asc')->paginate(5)->withQueryString();

        return view('kategori.index', [
            'pageTitle'   => 'Kelola Kategori',
            'activeMenu'  => 'kategori',
            'categories'  => $categories,
            'search'      => $search,
        ]);
    }

    public function create(): View
    {
        return view('kategori.tambah', [
            'pageTitle'  => 'Tambah Kategori',
            'activeMenu' => 'kategori',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t032_kategori,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar.',
        ]);

        Kategori::create($validated);

        return redirect()->route('kategori.index')
            ->with('success', "Kategori '{$request->nama_kategori}' berhasil ditambahkan.");
    }

    public function edit($id): View
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', [
            'pageTitle'  => 'Edit Kategori',
            'activeMenu' => 'kategori',
            'kategori'   => $kategori,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:t032_kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar.',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', "Kategori '{$kategori->nama_kategori}' berhasil diperbarui.");
    }

    public function destroy($id): RedirectResponse
    {
        $kategori = Kategori::withCount('produk')->findOrFail($id);

        if ($kategori->produk_count > 0) {
            return redirect()->route('kategori.index')
                ->with('warning', "Kategori '{$kategori->nama_kategori}' tidak dapat dihapus karena masih digunakan oleh {$kategori->produk_count} produk.");
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', "Kategori '{$nama}' berhasil dihapus.");
    }
}
