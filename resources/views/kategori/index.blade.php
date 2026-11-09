@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-tags text-orange" style="color: #FB8C00;"></i> Data Kategori Produk
        </h3>
        <p class="text-muted mb-0">Manajemen pengelompokan produk SiToko-032</p>
    </div>
    <div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori Baru
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <!-- Live Search Bar -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <form action="{{ route('kategori.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="liveSearchInput" name="search" class="form-control" placeholder="Cari nama kategori / deskripsi..." value="{{ $search }}" autocomplete="off">
                    </div>
                    @if(!empty($search))
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary px-3">Cari</button>
                </form>
            </div>
            <div class="col-md-6 text-md-end text-muted small align-self-center">
                Menampilkan <strong>{{ $categories->count() }}</strong> dari <strong>{{ $categories->total() }}</strong> total kategori
            </div>
        </div>

        <!-- Tabel Kategori -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="kategoriTable">
                <thead class="table-orange-header">
                    <tr>
                        <th style="width: 60px;" class="text-center">No</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah Produk</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $kat)
                        <tr>
                            <td class="text-center fw-bold">{{ $categories->firstItem() + $index }}</td>
                            <td class="fw-bold text-dark">
                                <i class="bi bi-tag-fill me-1" style="color: #FB8C00;"></i>
                                {{ $kat->nama_kategori }}
                            </td>
                            <td class="text-muted small">{{ $kat->deskripsi ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                    {{ $kat->produk_count }} produk
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('kategori.edit', $kat->id_kategori) }}" class="btn btn-outline-primary" title="Ubah Kategori">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <form action="{{ route('kategori.destroy', $kat->id_kategori) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ addslashes($kat->nama_kategori) }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus Kategori">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Tidak ada data kategori yang cocok.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($categories->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
    setupLiveTableFilter('liveSearchInput', 'kategoriTable');
</script>
@endpush
