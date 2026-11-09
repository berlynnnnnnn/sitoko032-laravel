@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-person-bounding-box text-orange" style="color: #FB8C00;"></i> Profil Pengguna & Unggah Foto
                </h5>
                <span class="badge {{ ($user->role->nama_role ?? '') === 'Admin' ? 'badge-role-admin' : (($user->role->nama_role ?? '') === 'Kasir' ? 'badge-role-kasir' : 'badge-role-pelanggan') }} px-3 py-2">
                    {{ $user->role->nama_role ?? 'User' }}
                </span>
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

                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Preview Foto Profil -->
                    <div class="d-flex flex-column flex-sm-row align-items-center gap-4 mb-4 pb-4 border-bottom">
                        <div>
                            <img src="{{ asset($user->foto_profil ?: 'uploads/profil/default.png') }}?t={{ time() }}" 
                                 alt="{{ $user->nama_lengkap }}" 
                                 class="rounded-circle shadow" 
                                 style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #FB8C00;" 
                                 onerror="this.src='{{ asset('uploads/profil/default.png') }}'">
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $user->nama_lengkap }}</h5>
                            <p class="text-muted small mb-1">
                                Username: <strong>{{ '@' . $user->username }}</strong>
                            </p>
                            <p class="text-muted small mb-2">
                                Path Foto di Database: <code>{{ $user->foto_profil }}</code>
                            </p>
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-calendar-event me-1"></i> Terdaftar sejak: {{ $user->created_at?->format('d M Y') ?? '2026' }}
                            </span>
                        </div>
                    </div>

                    <!-- Input Form Profil & Foto -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username / NIM</label>
                            <input type="text" class="form-control bg-light" id="username" value="{{ $user->username }}" readonly>
                            <div class="form-text">Username akun bersifat permanen.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="nama@domain.com">
                        </div>

                        <div class="col-md-6">
                            <label for="password_baru" class="form-label fw-semibold">Ganti Password</label>
                            <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Biarkan kosong jika tidak diganti">
                        </div>

                        <!-- Upload Foto Profil Validasi 2 MB & JPG/PNG -->
                        <div class="col-12 mt-3">
                            <div class="p-3 bg-light rounded-3 border">
                                <label for="foto_profil" class="form-label fw-bold text-dark">
                                    <i class="bi bi-cloud-arrow-up-fill me-1 text-orange" style="color: #FB8C00;"></i> Unggah Foto Profil Baru
                                </label>
                                <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/jpeg,image/png">
                                <div class="form-text mt-2 text-muted">
                                    <strong>Ketentuan Berkas:</strong>
                                    <ul class="mb-0 ps-3">
                                        <li>Format yang diterima: <strong>JPG, JPEG, PNG</strong>.</li>
                                        <li>Batas maksimal ukuran berkas: <strong>2 MB</strong>.</li>
                                        <li>Path berkas disimpan di database (bukan tipe BLOB).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-check-circle me-1"></i> Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
