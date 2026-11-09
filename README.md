# Proyek Ujian Tengah Semester (UTS) - Internet Programming
## SiToko-032: Toko Online Sederhana (Laravel 13 & Integrated REST API)

---

### 1. IDENTITAS MAHASISWA & SISTEM
* **Nama Mahasiswa**: Berlynda Vanetta
* **NIM**: 25.K1.0032
* **Digit Terakhir NIM**: 2
* **Studi Kasus**: SiToko - Toko Online Sederhana
* **Nama Aplikasi**: **SiToko-032** *(Tampil pada Browser Tab Title, Header Navbar, Footer, dan Response API)*
* **Nama Database**: `uts_25k10032`
* **Prefix Tabel MySQL**: `t032_` (`t032_roles`, `t032_users`, `t032_kategori`, `t032_produk`, `t032_pesanan`, `t032_api_tokens`)
* **Tema Warna UI**: Oranye (`#FB8C00`) pada Navbar, Tombol Utama (Primary), dan Header Tabel (`thead`)
* **Footer Aplikasi**: `"© 2026 Berlynda Vanetta 25.K1.0032"` disertai thumbnail foto profil mahasiswa (`uploads/profil/0032.jpg`)
* **Akun Super Admin**:
  * **Username**: `25.K1.0032`
  * **Nama Lengkap**: `Berlynda Vanetta`
  * **Foto Profil**: `uploads/profil/0032.jpg` (path tersimpan di DB, bukan BLOB)
  * **Password Default**: `admin123` (di-hash menggunakan `Hash::make('admin123')`)

---

### 2. AKUN PENGGUNA AWAL (SEEDER)

| Level / Role | Username | Nama Lengkap | Path Foto Profil | Keterangan Hak Akses |
|---|---|---|---|---|
| **Admin** *(Super Admin)* | `25.K1.0032` | Berlynda Vanetta | `uploads/profil/0032.jpg` | Hak akses penuh (CRUD Produk, Kategori, Hapus Produk, Ganti Profil) |
| **Kasir** | `kasir032` | Siti Kasir 032 | `uploads/profil/default.png` | Kelola Produk & Kategori (Tambah/Edit). **Dilarang Hapus Produk (403)** |
| **Pelanggan** | `pelanggan032` | Budi Pelanggan 032 | `uploads/profil/default.png` | Lihat Katalog Produk & Profil Saya. **Akses ke CRUD Ditolak (403)** |

---

### 3. TOKEN API SEEDER SIAP PAKAI
* **Admin Bearer Token**: `sitoko032_admintoken_berlynda_2026`
* **Kasir Bearer Token**: `sitoko032_kasirtoken_demo_2026`
* **Pelanggan Bearer Token**: `sitoko032_pelanggantoken_demo_2026`

---

### 4. STRUKTUR DIREKTORI PROYEK LARAVEL

```text
sitoko032-laravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php       # GET /api/identitas & POST /api/login
│   │   │   │   └── ProdukController.php     # 5 Endpoint CRUD t032_produk
│   │   │   ├── AuthController.php           # Web Login & Logout
│   │   │   ├── DashboardController.php      # Dashboard & API Documentation
│   │   │   ├── KategoriController.php       # Web CRUD Kategori
│   │   │   ├── ProdukController.php         # Web CRUD Produk
│   │   │   └── ProfilController.php         # Web Profil & Upload Foto (Maks 2MB)
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php           # Web Role Checking Guard (403 Forbidden)
│   │       └── ApiTokenMiddleware.php       # Bearer Token Authentication & Role Guard
│   └── Models/
│       ├── ApiToken.php                     # Model t032_api_tokens
│       ├── Kategori.php                     # Model t032_kategori
│       ├── Pesanan.php                      # Model t032_pesanan
│       ├── Produk.php                       # Model t032_produk
│       ├── Role.php                         # Model t032_roles
│       └── User.php                         # Model t032_users
├── bootstrap/
│   └── app.php                              # Routing API, Middleware alias, & JSON Exceptions
├── database/
│   ├── migrations/                          # Migrasi DDL t032_*
│   ├── seeders/
│   │   └── DatabaseSeeder.php               # Seeder 12 produk dummy & 3 akun pengguna
│   └── uts_25k10032.sql                     # Berkas SQL mentah siap impor
├── public/
│   ├── css/
│   │   └── style.css                        # Kustomisasi tema Oranye (#FB8C00)
│   ├── uploads/                             # Folder penyimpanan berkas foto
│   │   ├── profil/                          # 0032.jpg, default.png
│   │   └── produk/                          # default.png
│   └── postman_collection.json              # Koleksi Postman v2.1
├── resources/
│   └── views/
│       ├── auth/login.blade.php             # Form Login dengan quick test buttons
│       ├── dashboard/
│       │   ├── index.blade.php              # Dashboard metrik & status role
│       │   └── api_doc.blade.php            # Dokumentasi & In-Browser Live Tester
│       ├── errors/403.blade.php             # Tampilan 403 Akses Ditolak
│       ├── kategori/                        # Blade views CRUD Kategori
│       ├── layouts/app.blade.php            # Master Layout (Navbar Oranye + Footer Ber-thumbnail)
│       ├── produk/                          # Blade views CRUD Produk
│       └── profil/index.blade.php           # Form Profil & Upload Foto 2MB
└── routes/
    ├── api.php                              # Rute REST API (/api/*)
    └── web.php                              # Rute Web Aplikasi
```

---

### 5. PANDUAN MENJALANKAN SISTEM LARAVEL

#### Langkah 1: Pastikan Database MySQL Menyala
1. Aktifkan MySQL di Laragon / XAMPP / Herd.
2. Buat database bernama `uts_25k10032`:
   ```sql
   CREATE DATABASE uts_25k10032;
   ```
   *(Atau impor langsung berkas `database/uts_25k10032.sql`)*

#### Langkah 2: Jalankan Migrasi & Seeder Database
Di terminal folder `sitoko032-laravel`:
```bash
php artisan migrate:fresh --seed
```
*Perintah di atas akan otomatis mengenerate seluruh tabel `t032_*` dan menyematkan 12 produk dummy serta akun Super Admin.*

#### Langkah 3: Jalankan Web Server Laravel
```bash
php artisan serve
```
Aplikasi dapat dibuka di browser:
* **Web Aplikasi**: [http://localhost:8000/](http://localhost:8000/)
* **Endpoint Identitas**: [http://localhost:8000/api/identitas](http://localhost:8000/api/identitas)
* **Dokumentasi & Tester API**: [http://localhost:8000/dashboard/api-doc](http://localhost:8000/dashboard/api-doc)

---

### 6. TABEL SPESIFIKASI REST API

| No | Method | Endpoint | Hak Akses | Headers | Body Request | Status Code | Deskripsi |
|---|---|---|---|---|---|---|---|
| **1** | `GET` | `/api/identitas` | Publik (All) | `Accept: application/json` | *None* | `200 OK` | Mengembalikan identitas wajib mahasiswa pembuat sistem |
| **2** | `POST` | `/api/login` | Publik (All) | `Content-Type: application/json` | JSON username & password | `200 OK`, `400 Bad Request`, `401 Unauthorized` | Login akun untuk memperoleh Bearer Token di `t032_api_tokens` |
| **3** | `GET` | `/api/produk` | Semua Role Bertoken | `Authorization: Bearer <token>` | Query params: `search`, `kategori_id`, `page`, `limit` | `200 OK`, `401 Unauthorized` | Mengambil seluruh daftar produk dengan pagination & live search |
| **4** | `GET` | `/api/produk/{id}` | Semua Role Bertoken | `Authorization: Bearer <token>` | *None* | `200 OK`, `404 Not Found` | Mengambil detail 1 produk berdasarkan ID |
| **5** | `POST` | `/api/produk` | Admin, Kasir | `Authorization: Bearer <token>`, `Content-Type: application/json` | JSON data produk baru | `201 Created`, `400 Bad Request`, `403 Forbidden` | Menambah data produk baru ke sistem |
| **6** | `PUT` | `/api/produk/{id}` | Admin, Kasir | `Authorization: Bearer <token>`, `Content-Type: application/json` | JSON data pembaruan produk | `200 OK`, `400 Bad Request`, `403 Forbidden`, `404 Not Found` | Mengubah informasi data produk |
| **7** | `DELETE` | `/api/produk/{id}` | **Khusus Admin** | `Authorization: Bearer <token>` | *None* | `200 OK`, `403 Forbidden`, `404 Not Found` | Menghapus data produk. **Role Kasir/Pelanggan ditolak 403 Forbidden** |

---

### 7. CONTOH cURL REST API PADA LARAVEL

#### 1. Uji Endpoint Identitas Mahasiswa (Wajib)
```bash
curl -X GET "http://localhost:8000/api/identitas" \
     -H "Accept: application/json"
```
**Respon JSON:**
```json
{
  "nim": "25.K1.0032",
  "nama": "Berlynda Vanetta",
  "foto": "http://localhost:8000/uploads/profil/0032.jpg",
  "aplikasi": "SiToko-032"
}
```

#### 2. Uji POST Login API
```bash
curl -X POST "http://localhost:8000/api/login" \
     -H "Content-Type: application/json" \
     -d '{"username": "25.K1.0032", "password": "admin123"}'
```

#### 3. Uji GET Daftar Produk (Search & Pagination)
```bash
curl -X GET "http://localhost:8000/api/produk?search=laptop&limit=5" \
     -H "Authorization: Bearer sitoko032_admintoken_berlynda_2026"
```

#### 4. Uji DELETE Hapus Produk (Berhasil - Admin)
```bash
curl -X DELETE "http://localhost:8000/api/produk/12" \
     -H "Authorization: Bearer sitoko032_admintoken_berlynda_2026"
```

#### 5. Uji DELETE Hapus Produk (403 Forbidden - Kasir Ditolak)
```bash
curl -X DELETE "http://localhost:8000/api/produk/1" \
     -H "Authorization: Bearer sitoko032_kasirtoken_demo_2026"
```
**Respon JSON 403 Forbidden:**
```json
{
  "status": "error",
  "code": 403,
  "message": "Akses ditolak. Level akun (Kasir) tidak memiliki izin untuk operasi ini."
}
```
