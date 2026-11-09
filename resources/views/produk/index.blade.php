@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-box-seam text-orange" style="color: #FB8C00;"></i> 
            {{ ($currentUser->role->nama_role ?? '') === 'Pelanggan' ? 'Katalog Belanja SiToko-032' : 'Manajemen Data Produk' }}
        </h3>
        <p class="text-muted mb-0">Total terdata: <strong>{{ $products->total() }}</strong> produk</p>
    </div>

    <!-- Tombol Tambah Produk (Hanya Admin & Kasir) -->
    @if(in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']))
        <div>
            <a href="{{ route('produk.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Produk Baru
            </a>
        </div>
    @endif
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        
        <!-- Filter Bar & Live Search -->
        <form action="{{ route('produk.index') }}" method="GET" class="row g-2 mb-4 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="liveSearchInput" name="search" class="form-control" placeholder="Ketik kata kunci produk / kode..." value="{{ $search }}" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4">
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="0">-- Semua Kategori Produk --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id_kategori }}" {{ ($kategoriId == $cat->id_kategori) ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                @if(!empty($search) || $kategoriId > 0)
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel Data Produk -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="produkTable">
                <thead class="table-orange-header">
                    <tr>
                        <th style="width: 50px;" class="text-center">No</th>
                        <th style="width: 70px;">Gambar</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th class="text-center">Stok</th>
                        @if(in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']))
                            <th class="text-center" style="width: 170px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $index => $p)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $products->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ $p->gambar_url }}" alt="{{ $p->nama_produk }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.src='{{ asset('uploads/produk/default.png') }}'">
                            </td>
                            <td><span class="badge bg-light text-dark border font-monospace">{{ $p->kode_produk }}</span></td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->nama_produk }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($p->deskripsi, 45) }}</small>
                            </td>
                            <td><span class="badge bg-secondary">{{ $p->kategori->nama_kategori ?? '-' }}</span></td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($p->stok > 10)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                        {{ $p->stok }} unit
                                    </span>
                                @elseif ($p->stok > 0)
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                        {{ $p->stok }} unit
                                    </span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>

                            @if(in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']))
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('produk.edit', $p->id_produk) }}" class="btn btn-outline-primary" title="Ubah Data Produk">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>

                                        @if(($currentUser->role->nama_role ?? '') === 'Admin')
                                            <form action="{{ route('produk.destroy', $p->id_produk) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk \'{{ addslashes($p->nama_produk) }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Hapus Produk">
                                                    <i class="bi bi-trash-fill"></i> Hapus
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary disabled" title="Hanya Admin yang berhak menghapus">
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']) ? 8 : 7 }}" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-2 d-block mb-2"></i>
                                Tidak ada data produk yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    setupLiveTableFilter('liveSearchInput', 'produkTable');
</script>
@endpush
