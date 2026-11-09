@extends('layouts.app')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-7 col-lg-6 text-center">
        <div class="card p-5 shadow-sm border-0">
            <div class="mb-4">
                <i class="bi bi-shield-lock-fill text-danger" style="font-size: 5rem;"></i>
            </div>
            <h1 class="display-6 fw-bold text-danger mb-2">403 - Akses Ditolak!</h1>
            <p class="lead text-muted mb-4">
                Maaf, level akun Anda tidak memiliki hak akses / izin (privilege) untuk membuka halaman atau melakukan aksi ini.
            </p>
            <div class="alert alert-warning text-start small mb-4">
                <i class="bi bi-info-circle-fill me-1"></i>
                Halaman ini dilindungi oleh <strong>Laravel RoleMiddleware Guard</strong> SiToko-032. Hubungi Super Administrator jika Anda memerlukan perubahan wewenang akun.
            </div>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
                </a>
                <a href="javascript:history.back()" class="btn btn-outline-secondary px-4 py-2">
                    <i class="bi bi-arrow-left me-1"></i> Halaman Sebelumnya
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
