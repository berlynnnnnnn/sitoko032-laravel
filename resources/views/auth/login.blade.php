@extends('layouts.app')

@section('content')
<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white text-center py-4" style="background-color: #FB8C00;">
                <i class="bi bi-shop fs-1"></i>
                <h4 class="fw-bold mb-0 mt-2">SiToko-032</h4>
                <p class="small mb-0 opacity-75">Sistem Informasi Toko Online Sederhana (Laravel 13)</p>
            </div>
            <div class="card-body p-4">
                <h5 class="card-title fw-bold text-center mb-4 text-secondary">Silakan Masuk</h5>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
                    @csrf

                    <!-- Input Login: Sinkron dengan name="login" -->
                    <div class="mb-3">
                        <label for="login" class="form-label fw-semibold">Email atau Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" placeholder="Masukkan email atau username (NIM)" required autofocus>
                        </div>
                    </div>

                    <!-- Input Password: Sinkron dengan name="password" -->
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fs-6 shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection