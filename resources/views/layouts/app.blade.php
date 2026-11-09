<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiToko-032 - {{ $pageTitle ?? 'Toko Online Sederhana' }}</title>

    <!-- Bootstrap 5 CSS (Lokal & Offline Ready) -->
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons CSS (Lokal & Offline Ready) -->
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <!-- Custom Style Oranye #FB8C00 -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navbar SiToko-032 Warna Oranye (#FB8C00) -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-shop-window fs-4"></i>
                <span>SiToko-032</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsSiToko" aria-controls="navbarsSiToko" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsSiToko">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ ($activeMenu ?? '') === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>

                        <!-- Menu Produk -->
                        <li class="nav-item">
                            <a class="nav-link {{ ($activeMenu ?? '') === 'produk' ? 'active' : '' }}" href="{{ route('produk.index') }}">
                                <i class="bi bi-box-seam me-1"></i> {{ (Auth::user()->role->nama_role ?? '') === 'Pelanggan' ? 'Katalog Produk' : 'Kelola Produk' }}
                            </a>
                        </li>

                        <!-- Menu Kategori (Khusus Admin & Kasir) -->
                        @if(in_array(Auth::user()->role->nama_role ?? '', ['Admin', 'Kasir']))
                            <li class="nav-item">
                                <a class="nav-link {{ ($activeMenu ?? '') === 'kategori' ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                    <i class="bi bi-tags me-1"></i> Kategori
                                </a>
                            </li>
                        @endif

                        <!-- Menu Dokumentasi REST API -->
                        <li class="nav-item">
                            <a class="nav-link {{ ($activeMenu ?? '') === 'api' ? 'active' : '' }}" href="{{ route('api.doc') }}">
                                <i class="bi bi-hdd-network me-1"></i> REST API
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- User Dropdown & Login / Logout -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    @auth
                        @php
                            $user = Auth::user();
                            $photoPath = !empty($user->foto_profil) ? $user->foto_profil : 'uploads/profil/default.png';
                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <!-- Foto Profil Admin: Menggunakan asset(), rounded-circle Bootstrap, border halus, dan sejajar rapi -->
    <img src="{{ asset(!empty($user->foto_profil) ? $user->foto_profil : 'images/admin-profile.jpg') }}" 
         alt="Foto {{ $user->nama_lengkap }}" 
         class="rounded-circle user-avatar-nav me-2 border border-2 border-white" 
         style="width: 34px; height: 34px; object-fit: cover;" 
         onerror="this.src='{{ asset('uploads/profil/default.png') }}'">
    <span class="fw-semibold">{{ $user->nama_lengkap }}</span>
    <span class="badge ms-2 {{ ($user->role->nama_role ?? '') === 'Admin' ? 'badge-role-admin' : (($user->role->nama_role ?? '') === 'Kasir' ? 'badge-role-kasir' : 'badge-role-pelanggan') }}">
        {{ $user->role->nama_role ?? 'User' }}
    </span>
</a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li>
                                    <div class="dropdown-header text-muted">
                                        Masuk sebagai <strong>{{ $user->username }}</strong>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profil.index') }}">
                                        <i class="bi bi-person-circle me-2 text-warning"></i> Profil Saya & Upload Foto
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk (Login)
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="main-content">
        <div class="container">
            <!-- Flash Message Alert -->
            @foreach(['success', 'danger', 'warning', 'info'] as $msgType)
                @if(session($msgType))
                    <div class="alert alert-{{ $msgType }} alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi {{ $msgType === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }} me-2"></i>
                        {{ session($msgType) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            @yield('content')
        </div>
    </main>

    <!-- 2. Footer di Semua Halaman Web (Global) -->
    <footer class="app-footer">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-3">
            <!-- Foto Avatar Mahasiswa (Bulat & Berbingkai) -->
            <img src="{{ asset('uploads/profil/0032.jpg') }}" 
                 alt="Foto Berlynda Vanetta" 
                 class="footer-avatar rounded-circle" 
                 style="width: 36px; height: 36px; object-fit: cover;"
                 onerror="this.src='{{ asset('uploads/profil/default.png') }}'">
            <span class="fw-semibold text-secondary">
                &copy; 2026 Berlynda Vanetta 25.K1.0032
            </span>
        </div>
        <div class="text-muted small d-flex align-items-center gap-2">
            <!-- Foto Logo Toko / Gambar Pendukung (Responsif dengan img-fluid dan batasan tinggi max-height) -->
            <img src="{{ asset('images/logo.png') }}" 
                 alt="Logo Toko" 
                 class="img-fluid" 
                 style="max-height: 28px; object-fit: contain;" 
                 onerror="this.style.display='none'">
            <span class="badge bg-warning text-dark me-1">UTS Internet Programming</span>
            <span class="fw-bold" style="color: #FB8C00;">SiToko-032 (Laravel Edition)</span>
        </div>
    </div>
</footer>

    <!-- Bootstrap 5 Bundle JS (Lokal & Offline Ready) -->
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- Script Live Search & Interaktivitas -->
    <script>
        function setupLiveTableFilter(inputId, tableId) {
            const searchInput = document.getElementById(inputId);
            const table = document.getElementById(tableId);
            if (!searchInput || !table) return;

            searchInput.addEventListener('keyup', function () {
                const filter = searchInput.value.toLowerCase();
                const tbody = table.getElementsByTagName('tbody')[0];
                if (!tbody) return;
                const rows = tbody.getElementsByTagName('tr');

                for (let i = 0; i < rows.length; i++) {
                    const rowText = rows[i].textContent || rows[i].innerText;
                    if (rowText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
