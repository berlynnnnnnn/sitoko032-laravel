<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * GET /api/produk
     * Mengambil seluruh data produk (mendukung query param pencarian, filter kategori, limit, & pagination)
     */
    public function index(Request $request): JsonResponse
    {
        $search     = $request->query('search') ?: $request->query('q');
        $kategoriId = $request->query('kategori_id');
        $limit      = min(100, max(1, (int)($request->query('limit', 10))));

        $query = Produk::with('kategori');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if (!empty($kategoriId)) {
            $query->where('id_kategori', $kategoriId);
        }

        $paginated = $query->orderBy('id_produk', 'desc')->paginate($limit);

        // Format data
        $items = collect($paginated->items())->map(function ($p) {
            return [
                'id_produk'     => $p->id_produk,
                'id_kategori'   => $p->id_kategori,
                'nama_kategori' => $p->kategori->nama_kategori ?? '-',
                'kode_produk'   => $p->kode_produk,
                'nama_produk'   => $p->nama_produk,
                'harga'         => (float)$p->harga,
                'stok'          => (int)$p->stok,
                'deskripsi'     => $p->deskripsi,
                'gambar_url'    => $p->gambar_url,
                'created_at'    => $p->created_at?->toDateTimeString(),
            ];
        });

        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Daftar produk berhasil diambil.',
            'data'    => [
                'total_data'       => $paginated->total(),
                'total_halaman'    => $paginated->lastPage(),
                'halaman_saat_ini' => $paginated->currentPage(),
                'limit'            => $paginated->perPage(),
                'produk'           => $items,
            ],
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * GET /api/produk/{id}
     * Mengambil detail 1 produk
     */
    public function show($id): JsonResponse
    {
        $produk = Produk::with('kategori')->find($id);

        if (!$produk) {
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan.",
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => "Detail produk ID {$id} berhasil diambil.",
            'data'    => [
                'id_produk'     => $produk->id_produk,
                'id_kategori'   => $produk->id_kategori,
                'nama_kategori' => $produk->kategori->nama_kategori ?? '-',
                'kode_produk'   => $produk->kode_produk,
                'nama_produk'   => $produk->nama_produk,
                'harga'         => (float)$produk->harga,
                'stok'          => (int)$produk->stok,
                'deskripsi'     => $produk->deskripsi,
                'gambar_url'    => $produk->gambar_url,
                'created_at'    => $produk->created_at?->toDateTimeString(),
                'updated_at'    => $produk->updated_at?->toDateTimeString(),
            ],
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * POST /api/produk
     * Menambah produk baru (Hak Akses: Admin, Kasir)
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required|exists:t032_kategori,id_kategori',
            'kode_produk' => 'required|string|max:50|unique:t032_produk,kode_produk',
            'nama_produk' => 'required|string|max:150',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|string',
        ], [
            'id_kategori.required' => 'Kategori produk wajib dipilih.',
            'id_kategori.exists'   => 'Kategori produk yang dipilih tidak valid.',
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.unique'   => 'Kode produk sudah terdaftar pada produk lain.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required'       => 'Harga produk wajib diisi.',
            'stok.required'        => 'Stok produk wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'code'    => 400,
                'message' => 'Validasi input produk gagal.',
                'errors'  => $validator->errors(),
            ], 400);
        }

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $request->gambar ?: 'uploads/produk/default.png',
        ]);

        $apiUser = $request->attributes->get('api_user');

        return response()->json([
            'status'  => 'success',
            'code'    => 201,
            'message' => 'Produk baru berhasil ditambahkan.',
            'data'    => [
                'id_produk'   => $produk->id_produk,
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'harga'       => (float)$produk->harga,
                'stok'        => (int)$produk->stok,
                'id_kategori' => $produk->id_kategori,
                'deskripsi'   => $produk->deskripsi,
                'gambar_url'  => $produk->gambar_url,
                'created_by'  => $apiUser ? ($apiUser->nama_lengkap . ' (' . ($apiUser->role->nama_role ?? '') . ')') : 'API User',
            ],
        ], 201, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * PUT /api/produk/{id}
     * Mengubah data produk (Hak Akses: Admin, Kasir)
     */
    public function update(Request $request, $id): JsonResponse
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan untuk diubah.",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'id_kategori' => 'sometimes|required|exists:t032_kategori,id_kategori',
            'kode_produk' => 'sometimes|required|string|max:50|unique:t032_produk,kode_produk,' . $id . ',id_produk',
            'nama_produk' => 'sometimes|required|string|max:150',
            'harga'       => 'sometimes|required|numeric|min:0',
            'stok'        => 'sometimes|required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'code'    => 400,
                'message' => 'Validasi pembaruan produk gagal.',
                'errors'  => $validator->errors(),
            ], 400);
        }

        $produk->update($request->only([
            'id_kategori', 'kode_produk', 'nama_produk', 'harga', 'stok', 'deskripsi', 'gambar'
        ]));

        $apiUser = $request->attributes->get('api_user');

        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => "Produk ID {$id} berhasil diperbarui.",
            'data'    => [
                'id_produk'   => $produk->id_produk,
                'kode_produk' => $produk->kode_produk,
                'nama_produk' => $produk->nama_produk,
                'harga'       => (float)$produk->harga,
                'stok'        => (int)$produk->stok,
                'id_kategori' => $produk->id_kategori,
                'deskripsi'   => $produk->deskripsi,
                'gambar_url'  => $produk->gambar_url,
                'updated_by'  => $apiUser ? ($apiUser->nama_lengkap . ' (' . ($apiUser->role->nama_role ?? '') . ')') : 'API User',
            ],
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * DELETE /api/produk/{id}
     * Menghapus produk (Hak Akses: HANYA Admin)
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => "Produk dengan ID {$id} tidak ditemukan untuk dihapus.",
            ], 404);
        }

        $namaProduk = $produk->nama_produk;
        $produk->delete();

        $apiUser = $request->attributes->get('api_user');

        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => "Produk ID {$id} ('{$namaProduk}') berhasil dihapus dari sistem.",
            'data'    => [
                'id_produk'   => (int)$id,
                'nama_produk' => $namaProduk,
                'deleted_by'  => $apiUser ? ($apiUser->nama_lengkap . ' (Admin)') : 'Admin',
            ],
        ], 200, ['Content-Type' => 'application/json'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
