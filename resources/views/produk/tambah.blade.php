@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-box-seam-fill text-orange" style="color: #FB8C00;"></i> Tambah Produk Baru
                </h5>
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-secondary">
                    &laquo; Kembali ke Daftar
                </a>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kode_produk" class="form-label fw-semibold">Kode Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" id="kode_produk" name="kode_produk" value="{{ old('kode_produk', $defaultCode) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_kategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_kategori" name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori }}" {{ old('id_kategori') == $cat->id_kategori ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="nama_produk" class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}" placeholder="Contoh: Mouse Wireless Ergonomic" required>
                        </div>

                        <div class="col-md-6">
                            <label for="harga" class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="harga" name="harga" min="0" step="1000" value="{{ old('harga') }}" placeholder="150000" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stok" name="stok" min="0" value="{{ old('stok', 10) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan spesifikasi, keunggulan, atau kelengkapan produk...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="gambar" class="form-label fw-semibold">Foto / Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg,image/png">
                            <div class="form-text">Maksimal ukuran 2 MB. Format diperbolehkan: JPG, JPEG, PNG. (Opsional, jika kosong menggunakan default).</div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
