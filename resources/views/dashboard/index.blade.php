@extends('layouts.app')

@section('content')
<!-- Banner Identitas Mahasiswa & Aplikasi SiToko-032 -->
<div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%); border-left: 6px solid #FB8C00 !important;">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('uploads/profil/0032.jpg') }}" alt="Berlynda Vanetta" class="rounded-circle shadow-sm" style="width: 70px; height: 70px; object-fit: cover; border: 3px solid #FB8C00;" onerror="this.src='{{ asset('uploads/profil/default.png') }}'">
                <div>
                    <span class="badge bg-warning text-dark mb-1">Ujian Tengah Semester - Internet Programming (Laravel 13)</span>
                    <h3 class="fw-bold mb-1" style="color: #E65100;">SiToko-032</h3>
                    <p class="text-secondary mb-0">
                        Mahasiswa: <strong>Berlynda Vanetta</strong> | NIM: <strong>25.K1.0032</strong> | Digit Terakhir: <strong>2</strong> (Studi Kasus: SiToko)
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('api.doc') }}" class="btn btn-outline-primary bg-white shadow-sm">
                    <i class="bi bi-code-slash me-1"></i> Dokumentasi REST API
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3 text-white" style="background-color: #FB8C00;">
                    <i class="bi bi-box-seam fs-2"></i>
                </div>
                <div>
                    <h6 class="text-muted text-uppercase mb-1 small fw-bold">Total Produk</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalProduk) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3 text-white bg-primary">
                    <i class="bi bi-tags fs-2"></i>
                </div>
                <div>
                    <h6 class="text-muted text-uppercase mb-1 small fw-bold">Total Kategori</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalKategori) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3 text-white bg-success">
                    <i class="bi bi-people fs-2"></i>
                </div>
                <div>
                    <h6 class="text-muted text-uppercase mb-1 small fw-bold">Pengguna Sistem</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalUser) }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 p-3 me-3 text-white bg-info">
                    <i class="bi bi-receipt fs-2"></i>
                </div>
                <div>
                    <h6 class="text-muted text-uppercase mb-1 small fw-bold">Total Transaksi</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalPesanan) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Preview Produk Terbaru & Informasi Role Guard -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-clock-history me-1 text-orange" style="color: #FB8C00;"></i> 5 Produk Terbaru
                </h5>
                <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua Produk &raquo;
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-orange-header">
                        <tr>
                            <th style="width: 60px;">Foto</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestProducts as $p)
                            <tr>
                                <td>
                                    <img src="{{ $p->gambar_url }}" alt="{{ $p->nama_produk }}" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" onerror="this.src='{{ asset('uploads/produk/default.png') }}'">
                                </td>
                                <td><code>{{ $p->kode_produk }}</code></td>
                                <td class="fw-semibold">{{ $p->nama_produk }}</td>
                                <td><span class="badge bg-secondary">{{ $p->kategori->nama_kategori ?? '-' }}</span></td>
                                <td class="fw-bold text-success">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $p->stok > 5 ? 'bg-info' : 'bg-danger' }}">
                                        {{ $p->stok }} unit
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data produk tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Informasi Hak Akses & Status User -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white" style="background-color: #FB8C00;">
                <h6 class="fw-bold mb-0"><i class="bi bi-shield-check me-2"></i>Status Hak Akses Anda</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset($currentUser->foto_profil ?: 'uploads/profil/default.png') }}" alt="Avatar" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #FB8C00;" onerror="this.src='{{ asset('uploads/profil/default.png') }}'">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $currentUser->nama_lengkap }}</h6>
                        <small class="text-muted">{{ '@' . $currentUser->username }}</small>
                    </div>
                </div>
                <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span>Level Role:</span>
                        <strong class="text-orange" style="color: #FB8C00;">{{ $currentUser->role->nama_role ?? '-' }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span>Kelola Kategori:</span>
                        <span>{!! in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']) ? '<i class="bi bi-check-circle-fill text-success"> Diizinkan</i>' : '<i class="bi bi-x-circle-fill text-danger"> Ditolak (403)</i>' !!}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span>Tambah/Ubah Produk:</span>
                        <span>{!! in_array($currentUser->role->nama_role ?? '', ['Admin', 'Kasir']) ? '<i class="bi bi-check-circle-fill text-success"> Diizinkan</i>' : '<i class="bi bi-x-circle-fill text-danger"> Ditolak (403)</i>' !!}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span>Hapus Produk:</span>
                        <span>{!! ($currentUser->role->nama_role ?? '') === 'Admin' ? '<i class="bi bi-check-circle-fill text-success"> Diizinkan</i>' : '<i class="bi bi-x-circle-fill text-danger"> Khusus Admin</i>' !!}</span>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('profil.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-pencil-square me-1"></i> Perbarui Profil & Foto
                    </a>
                </div>
            </div>
        </div>

        <!-- Token API Pengujian Cepat -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h6 class="fw-bold mb-0"><i class="bi bi-key-fill me-2 text-warning"></i>Kunci Token API Siap Pakai</h6>
            </div>
            <div class="card-body small">
                <p class="text-muted mb-2">Token untuk pengujian endpoint REST API dengan hak akses:</p>
                <div class="bg-light p-2 rounded mb-2 font-monospace text-break small">
                    <strong>Admin Token:</strong><br>
                    <code>sitoko032_admintoken_berlynda_2026</code>
                </div>
                <a href="{{ route('api.doc') }}" class="btn btn-sm btn-dark w-100">
                    <i class="bi bi-journal-code me-1"></i> Lihat Dokumentasi REST API Lengkap
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
