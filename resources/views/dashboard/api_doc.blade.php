@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-dark">
            <i class="bi bi-hdd-network text-orange" style="color: #FB8C00;"></i> Dokumentasi & Tester REST API SiToko-032
        </h3>
        <p class="text-muted mb-0">Arsitektur REST API Laravel dengan output JSON murni dan HTTP status code lengkap</p>
    </div>
    <div>
        <a href="{{ asset('postman_collection.json') }}" download class="btn btn-primary shadow-sm">
            <i class="bi bi-download me-1"></i> Unduh Postman Collection
        </a>
    </div>
</div>

<!-- Informasi Base Endpoint -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-7">
                <h6 class="fw-bold text-dark mb-1">Base URL Endpoint API:</h6>
                <div class="input-group">
                    <span class="input-group-text bg-light font-monospace">API URL</span>
                    <input type="text" class="form-control font-monospace bg-white" value="{{ $apiBaseUrl }}" readonly id="baseUrlInput">
                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('baseUrlInput')">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
            </div>
            <div class="col-md-5">
                <h6 class="fw-bold text-dark mb-1">Token Super Admin Siap Pakai:</h6>
                <div class="input-group">
                    <input type="text" class="form-control font-monospace bg-light small" value="sitoko032_admintoken_berlynda_2026" readonly id="adminTokenInput">
                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('adminTokenInput')">
                        <i class="bi bi-clipboard"></i> Salin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Spesifikasi 7 Endpoint REST API -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-table me-2 text-orange" style="color: #FB8C00;"></i> Tabel Spesifikasi Endpoint REST API
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-orange-header">
                <tr>
                    <th style="width: 80px;">Method</th>
                    <th>Endpoint</th>
                    <th>Hak Akses</th>
                    <th>Headers</th>
                    <th>Request Body</th>
                    <th>HTTP Status</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1. GET /api/identitas -->
                <tr>
                    <td><span class="badge bg-success">GET</span></td>
                    <td><code>/api/identitas</code></td>
                    <td><span class="badge bg-secondary">Publik / All</span></td>
                    <td><small class="text-muted">Content-Type: application/json</small></td>
                    <td><em>None</em></td>
                    <td><span class="badge bg-success">200 OK</span></td>
                    <td><strong>Endpoint Identitas Wajib:</strong> Mengembalikan JSON NIM, Nama, Foto, Aplikasi.</td>
                </tr>

                <!-- 2. POST /api/login -->
                <tr>
                    <td><span class="badge bg-primary">POST</span></td>
                    <td><code>/api/login</code></td>
                    <td><span class="badge bg-secondary">Publik / All</span></td>
                    <td><small class="text-muted">Content-Type: application/json</small></td>
                    <td><code>{"username": "...", "password": "..."}</code></td>
                    <td>
                        <span class="badge bg-success">200 OK</span><br>
                        <span class="badge bg-danger">400</span> <span class="badge bg-warning text-dark">401</span>
                    </td>
                    <td>Autentikasi akun untuk memperoleh <strong>Bearer Token</strong> di <code>t032_api_tokens</code>.</td>
                </tr>

                <!-- 3. GET /api/produk -->
                <tr>
                    <td><span class="badge bg-success">GET</span></td>
                    <td><code>/api/produk</code></td>
                    <td><span class="badge bg-info text-dark">Semua Role Bertoken</span></td>
                    <td><small class="text-muted">Authorization: Bearer &lt;token&gt;</small></td>
                    <td><em>Query Params:</em><br><code>search</code>, <code>kategori_id</code>, <code>page</code>, <code>limit</code></td>
                    <td>
                        <span class="badge bg-success">200 OK</span><br>
                        <span class="badge bg-warning text-dark">401</span>
                    </td>
                    <td>Mengambil daftar seluruh produk dengan pagination dan search filter.</td>
                </tr>

                <!-- 4. GET /api/produk/{id} -->
                <tr>
                    <td><span class="badge bg-success">GET</span></td>
                    <td><code>/api/produk/{id}</code></td>
                    <td><span class="badge bg-info text-dark">Semua Role Bertoken</span></td>
                    <td><small class="text-muted">Authorization: Bearer &lt;token&gt;</small></td>
                    <td><em>None</em></td>
                    <td>
                        <span class="badge bg-success">200 OK</span><br>
                        <span class="badge bg-secondary">404</span>
                    </td>
                    <td>Mengambil rincian detail 1 data produk berdasarkan ID.</td>
                </tr>

                <!-- 5. POST /api/produk -->
                <tr>
                    <td><span class="badge bg-primary">POST</span></td>
                    <td><code>/api/produk</code></td>
                    <td><span class="badge badge-role-admin">Admin</span> <span class="badge badge-role-kasir">Kasir</span></td>
                    <td><small class="text-muted">Authorization: Bearer &lt;token&gt;<br>Content-Type: application/json</small></td>
                    <td><code>{"kode_produk": "...", "nama_produk": "...", "id_kategori": 1, "harga": 150000, "stok": 10}</code></td>
                    <td>
                        <span class="badge bg-success">201 Created</span><br>
                        <span class="badge bg-danger">400</span> <span class="badge bg-warning text-dark">403</span>
                    </td>
                    <td>Menambah produk baru ke database. Dilengkapi validasi field & hak akses.</td>
                </tr>

                <!-- 6. PUT /api/produk/{id} -->
                <tr>
                    <td><span class="badge bg-warning text-dark">PUT</span></td>
                    <td><code>/api/produk/{id}</code></td>
                    <td><span class="badge badge-role-admin">Admin</span> <span class="badge badge-role-kasir">Kasir</span></td>
                    <td><small class="text-muted">Authorization: Bearer &lt;token&gt;<br>Content-Type: application/json</small></td>
                    <td><code>{"nama_produk": "...", "harga": 180000, ...}</code></td>
                    <td>
                        <span class="badge bg-success">200 OK</span><br>
                        <span class="badge bg-secondary">404</span> <span class="badge bg-warning text-dark">403</span>
                    </td>
                    <td>Mengubah informasi data produk berdasarkan ID.</td>
                </tr>

                <!-- 7. DELETE /api/produk/{id} -->
                <tr>
                    <td><span class="badge bg-danger">DELETE</span></td>
                    <td><code>/api/produk/{id}</code></td>
                    <td><span class="badge badge-role-admin">Admin Only</span></td>
                    <td><small class="text-muted">Authorization: Bearer &lt;token&gt;</small></td>
                    <td><em>None</em></td>
                    <td>
                        <span class="badge bg-success">200 OK</span><br>
                        <span class="badge bg-warning text-dark">403 Forbidden</span> <span class="badge bg-secondary">404</span>
                    </td>
                    <td>Menghapus data produk. <strong>Hak akses dibatasi ketat hanya untuk role Admin</strong>.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Interactive In-Browser API Tester Console -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-play-circle-fill me-2 text-warning"></i> Interactive REST API Tester (Uji Langsung di Browser)
        </h5>
        <span class="badge bg-success">Laravel 13 API Ready</span>
    </div>
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-2">
                <label class="form-label fw-bold">Method</label>
                <select id="testMethod" class="form-select font-monospace fw-bold" onchange="onMethodChange()">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="DELETE">DELETE</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Pilih Template Endpoint</label>
                <select class="form-select" id="endpointTemplate" onchange="selectEndpoint(this.value)">
                    <option value="identitas">1. GET /api/identitas (Identitas Mahasiswa)</option>
                    <option value="login">2. POST /api/login (Login & Dapatkan Token)</option>
                    <option value="produk">3. GET /api/produk (Daftar Seluruh Produk)</option>
                    <option value="produk/1">4. GET /api/produk/1 (Detail 1 Produk)</option>
                    <option value="tambah_produk">5. POST /api/produk (Tambah Produk Baru)</option>
                    <option value="ubah_produk">6. PUT /api/produk/1 (Ubah Data Produk)</option>
                    <option value="hapus_produk">7. DELETE /api/produk/12 (Hapus Produk - Admin)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Bearer Auth Token</label>
                <input type="text" id="testToken" class="form-control font-monospace small" value="sitoko032_admintoken_berlynda_2026" placeholder="Bearer Token...">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Full URL Request</label>
                <input type="text" id="testFullUrl" class="form-control font-monospace" value="{{ $apiBaseUrl }}/identitas">
            </div>

            <div class="col-12" id="requestBodyWrapper" style="display: none;">
                <label class="form-label fw-bold">JSON Request Body</label>
                <textarea id="testRequestBody" class="form-control font-monospace small" rows="5"></textarea>
            </div>

            <div class="col-12">
                <button type="button" class="btn btn-primary px-4 py-2" onclick="sendApiTest()">
                    <i class="bi bi-send-fill me-1"></i> Eksekusi Permintaan API
                </button>
            </div>
        </div>

        <!-- Output Response Console -->
        <div class="mt-4 pt-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">HTTP Response Console:</h6>
                <span id="responseStatusBadge" class="badge bg-secondary">Status: Menunggu Permintaan</span>
            </div>
            <pre id="responseJsonArea" class="p-3 bg-dark text-light rounded font-monospace small" style="max-height: 380px; overflow-y: auto;">Klik tombol "Eksekusi Permintaan API" untuk melihat respon JSON.</pre>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const baseApi = "{{ $apiBaseUrl }}";

function copyToClipboard(id) {
    const el = document.getElementById(id);
    el.select();
    navigator.clipboard.writeText(el.value);
    alert('Teks berhasil disalin ke clipboard!');
}

function selectEndpoint(key) {
    const methodSelect = document.getElementById('testMethod');
    const fullUrlInput = document.getElementById('testFullUrl');
    const bodyWrapper = document.getElementById('requestBodyWrapper');
    const bodyInput = document.getElementById('testRequestBody');

    if (key === 'identitas') {
        methodSelect.value = 'GET';
        fullUrlInput.value = baseApi + '/identitas';
        bodyWrapper.style.display = 'none';
    } else if (key === 'login') {
        methodSelect.value = 'POST';
        fullUrlInput.value = baseApi + '/login';
        bodyWrapper.style.display = 'block';
        bodyInput.value = JSON.stringify({
            username: "25.K1.0032",
            password: "admin123"
        }, null, 2);
    } else if (key === 'produk') {
        methodSelect.value = 'GET';
        fullUrlInput.value = baseApi + '/produk?limit=5';
        bodyWrapper.style.display = 'none';
    } else if (key === 'produk/1') {
        methodSelect.value = 'GET';
        fullUrlInput.value = baseApi + '/produk/1';
        bodyWrapper.style.display = 'none';
    } else if (key === 'tambah_produk') {
        methodSelect.value = 'POST';
        fullUrlInput.value = baseApi + '/produk';
        bodyWrapper.style.display = 'block';
        bodyInput.value = JSON.stringify({
            id_kategori: 1,
            kode_produk: "PRD-032-" + Math.floor(100 + Math.random() * 900),
            nama_produk: "SSD Portable NVMe 1TB High-Speed",
            harga: 1250000,
            stok: 15,
            deskripsi: "Penyimpanan eksternal ultra cepat USB-C 3.2 Gen 2 transfer 1050 MB/s."
        }, null, 2);
    } else if (key === 'ubah_produk') {
        methodSelect.value = 'PUT';
        fullUrlInput.value = baseApi + '/produk/1';
        bodyWrapper.style.display = 'block';
        bodyInput.value = JSON.stringify({
            nama_produk: "Laptop Ultrabook Pro 14 inch (Edisi Laravel 2026)",
            harga: 12900000,
            stok: 10
        }, null, 2);
    } else if (key === 'hapus_produk') {
        methodSelect.value = 'DELETE';
        fullUrlInput.value = baseApi + '/produk/12';
        bodyWrapper.style.display = 'none';
    }
}

function onMethodChange() {
    const method = document.getElementById('testMethod').value;
    const bodyWrapper = document.getElementById('requestBodyWrapper');
    if (method === 'POST' || method === 'PUT') {
        bodyWrapper.style.display = 'block';
    } else {
        bodyWrapper.style.display = 'none';
    }
}

async function sendApiTest() {
    const method = document.getElementById('testMethod').value;
    const url = document.getElementById('testFullUrl').value;
    const token = document.getElementById('testToken').value.trim();
    const bodyInput = document.getElementById('testRequestBody').value.trim();
    const statusBadge = document.getElementById('responseStatusBadge');
    const responseArea = document.getElementById('responseJsonArea');

    statusBadge.className = 'badge bg-secondary';
    statusBadge.innerText = 'Mengirim Permintaan...';
    responseArea.innerText = 'Memproses request ke ' + url + '...';

    const headers = {
        'Accept': 'application/json'
    };

    if (token) {
        headers['Authorization'] = 'Bearer ' + token;
    }

    const options = {
        method: method,
        headers: headers
    };

    if ((method === 'POST' || method === 'PUT') && bodyInput) {
        headers['Content-Type'] = 'application/json';
        options.body = bodyInput;
    }

    try {
        const res = await fetch(url, options);
        const text = await res.text();

        statusBadge.className = res.ok ? 'badge bg-success' : 'badge bg-danger';
        statusBadge.innerText = `HTTP ${res.status} ${res.statusText}`;

        try {
            const json = JSON.parse(text);
            responseArea.innerText = JSON.stringify(json, null, 2);
        } catch (e) {
            responseArea.innerText = text;
        }

    } catch (err) {
        statusBadge.className = 'badge bg-danger';
        statusBadge.innerText = 'Network Error';
        responseArea.innerText = 'Gagal menghubungi server: ' + err.message;
    }
}
</script>
@endpush
