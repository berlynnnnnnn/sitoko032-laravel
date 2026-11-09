@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-pencil-square text-orange" style="color: #FB8C00;"></i> Ubah Data Produk
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

                <form action="{{ route('produk.update', $product->id_produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kode_produk" class="form-label fw-semibold">Kode Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" id="kode_produk" name="kode_produk" value="{{ old('kode_produk', $product->kode_produk) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="id_kategori" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="id_kategori" name="id_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id_kategori }}" {{ old('id_kategori', $product->id_kategori) == $cat->id_kategori ? 'selected' : '' }}>
                                        {{ $cat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="nama_produk" class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="harga" class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="harga" name="harga" min="0" step="1000" value="{{ old('harga', (int)$product->harga) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label fw-semibold">Stok Saat Ini <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stok" name="stok" min="0" value="{{ old('stok', $product->stok) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Gambar Produk Saat Ini</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <img src="{{ $product->gambar_url }}" alt="Foto Produk" class="rounded border p-1" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.src='{{ asset('uploads/produk/default.png') }}'">
                                <div class="small text-muted">
                                    Path tersimpan: <code>{{ $product->gambar }}</code><br>
                                    Unggah berkas di bawah jika ingin mengganti gambar.
                                </div>
                            </div>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/jpeg,image/png">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG/PNG, Maksimal 2 MB.</div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-1"></i> Perbarui Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
