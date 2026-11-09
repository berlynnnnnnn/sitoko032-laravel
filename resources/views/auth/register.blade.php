@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Daftar Akun Baru</h4>

                    <!-- Tampilkan pesan error validasi jika ada -->
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Anda" value="{{ old('name') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
                        </div>

                        <!-- Pilihan Role (User biasa atau Seller) -->
                        <div class="mb-3">
                            <label class="form-label">Daftar Sebagai</label>
                            <select name="role" class="form-select" required>
                                <option value="user">Pengunjung Biasa (User)</option>
                                <option value="seller">Penjual (Seller)</option>
                            </select>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-decoration-none">Masuk di sini</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection