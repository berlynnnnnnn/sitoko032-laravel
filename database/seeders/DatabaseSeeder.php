<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles
        DB::table('t032_roles')->insertOrIgnore([
            [
                'id_role'    => 1,
                'nama_role'  => 'Admin',
                'keterangan' => 'Super Administrator dengan hak akses penuh seluruh modul sistem',
            ],
            [
                'id_role'    => 2,
                'nama_role'  => 'Kasir',
                'keterangan' => 'Petugas kasir pengelola data produk, kategori, dan transaksi',
            ],
            [
                'id_role'    => 3,
                'nama_role'  => 'Pelanggan',
                'keterangan' => 'Pengguna terdaftar / pembeli di SiToko-032',
            ],
        ]);

        // 2. Seed Users (Password default: admin123)
        // Super Admin: Username 25.K1.0032, Nama: Berlynda Vanetta, Foto: uploads/profil/0032.jpg
        $passwordHash = Hash::make('admin123');

        DB::table('t032_users')->insertOrIgnore([
            [
                'id_user'      => 1,
                'id_role'      => 1,
                'username'     => '25.K1.0032',
                'password'     => $passwordHash,
                'nama_lengkap' => 'Berlynda Vanetta',
                'email'        => '25.k1.0032@student.unika.ac.id',
                'foto_profil'  => 'uploads/profil/0032.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_user'      => 2,
                'id_role'      => 2,
                'username'     => 'kasir032',
                'password'     => $passwordHash,
                'nama_lengkap' => 'Siti Kasir 032',
                'email'        => 'kasir032@sitoko.local',
                'foto_profil'  => 'uploads/profil/default.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id_user'      => 3,
                'id_role'      => 3,
                'username'     => 'pelanggan032',
                'password'     => $passwordHash,
                'nama_lengkap' => 'Budi Pelanggan 032',
                'email'        => 'budi032@gmail.com',
                'foto_profil'  => 'uploads/profil/default.png',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);

        // 3. Seed Token API Siap Pakai
        DB::table('t032_api_tokens')->insertOrIgnore([
            [
                'id_token'   => 1,
                'id_user'    => 1,
                'token'      => 'sitoko032_admintoken_berlynda_2026',
                'expires_at' => '2030-12-31 23:59:59',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_token'   => 2,
                'id_user'    => 2,
                'token'      => 'sitoko032_kasirtoken_demo_2026',
                'expires_at' => '2030-12-31 23:59:59',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_token'   => 3,
                'id_user'    => 3,
                'token'      => 'sitoko032_pelanggantoken_demo_2026',
                'expires_at' => '2030-12-31 23:59:59',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Seed Kategori
        DB::table('t032_kategori')->insertOrIgnore([
            [
                'id_kategori'   => 1,
                'nama_kategori' => 'Elektronik & Gadget',
                'deskripsi'     => 'Perangkat komputer, laptop, aksesoris, dan gadget modern',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_kategori'   => 2,
                'nama_kategori' => 'Fashion & Busana',
                'deskripsi'     => 'Pakaian pria dan wanita, jaket, kaos, dan celana',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_kategori'   => 3,
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi'     => 'Kopi asli nusantara, teh herbal, dan camilan pilihan',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_kategori'   => 4,
                'nama_kategori' => 'Buku & Alat Tulis',
                'deskripsi'     => 'Buku referensi teknologi, novel, dan perlengkapan tulis',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        // 5. Seed 12 Baris Produk Dummy (10 + digit terakhir NIM 2)
        DB::table('t032_produk')->insertOrIgnore([
            [
                'id_produk'   => 1,
                'id_kategori' => 1,
                'kode_produk' => 'PRD-032-001',
                'nama_produk' => 'Laptop Ultrabook Pro 14"',
                'harga'       => 12500000.00,
                'stok'        => 8,
                'deskripsi'   => 'Laptop tipis performa tinggi Intel Core i7, RAM 16GB, SSD 512GB NVMe.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 2,
                'id_kategori' => 1,
                'kode_produk' => 'PRD-032-002',
                'nama_produk' => 'Mouse Wireless Ergonomic',
                'harga'       => 150000.00,
                'stok'        => 25,
                'deskripsi'   => 'Mouse nirkabel presisi tinggi dengan tombol silent click dan baterai awet.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 3,
                'id_kategori' => 1,
                'kode_produk' => 'PRD-032-003',
                'nama_produk' => 'Keyboard Mechanical RGB',
                'harga'       => 450000.00,
                'stok'        => 14,
                'deskripsi'   => 'Keyboard mekanikal dengan switch blue taktil dan efek pencahayaan RGB.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 4,
                'id_kategori' => 1,
                'kode_produk' => 'PRD-032-004',
                'nama_produk' => 'Headset Gaming 7.1 Surround',
                'harga'       => 375000.00,
                'stok'        => 18,
                'deskripsi'   => 'Audio spasial 7.1 dengan mikrofon fleksibel noise-cancelling untuk meeting & gaming.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 5,
                'id_kategori' => 2,
                'kode_produk' => 'PRD-032-005',
                'nama_produk' => 'Kaos Polos Katun Combed 30s',
                'harga'       => 65000.00,
                'stok'        => 50,
                'deskripsi'   => 'Kaos katun combed 30s premium berdaya serap tinggi dan sangat nyaman dipakai.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 6,
                'id_kategori' => 2,
                'kode_produk' => 'PRD-032-006',
                'nama_produk' => 'Jaket Hoodie Fleece Unisex',
                'harga'       => 185000.00,
                'stok'        => 20,
                'deskripsi'   => 'Hoodie tebal lembut berbahan fleece katun dengan kantong kanguru di bagian depan.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 7,
                'id_kategori' => 2,
                'kode_produk' => 'PRD-032-007',
                'nama_produk' => 'Celana Chino Slim Fit',
                'harga'       => 140000.00,
                'stok'        => 30,
                'deskripsi'   => 'Celana panjang chino slim fit katun twill stretch cocok untuk formal maupun kasual.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 8,
                'id_kategori' => 3,
                'kode_produk' => 'PRD-032-008',
                'nama_produk' => 'Kopi Arabika Gayo 250gr',
                'harga'       => 75000.00,
                'stok'        => 40,
                'deskripsi'   => 'Biji kopi pilihan roasted bean dari dataran tinggi Aceh Gayo beraroma rempah dan floral.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 9,
                'id_kategori' => 3,
                'kode_produk' => 'PRD-032-009',
                'nama_produk' => 'Teh Hijau Melati Organik',
                'harga'       => 35000.00,
                'stok'        => 35,
                'deskripsi'   => 'Teh hijau pucuk pilihan beraroma melati segar kaya antioksidan alami.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 10,
                'id_kategori' => 3,
                'kode_produk' => 'PRD-032-010',
                'nama_produk' => 'Keripik Singkong Balado 200gr',
                'harga'       => 18000.00,
                'stok'        => 60,
                'deskripsi'   => 'Keripik singkong renyah dengan taburan bumbu cabai balado pedas manis gurih.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 11,
                'id_kategori' => 4,
                'kode_produk' => 'PRD-032-011',
                'nama_produk' => 'Buku Pemrograman Web Modern',
                'harga'       => 95000.00,
                'stok'        => 15,
                'deskripsi'   => 'Buku panduan membangun aplikasi web terstruktur dengan PHP, MySQL, & REST API.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_produk'   => 12,
                'id_kategori' => 4,
                'kode_produk' => 'PRD-032-012',
                'nama_produk' => 'Buku Catatan Jurnal Hardcover',
                'harga'       => 42000.00,
                'stok'        => 22,
                'deskripsi'   => 'Buku catatan jilid hardcover tebal 100 lembar kertas dotted 100 gsm bebas rembes.',
                'gambar'      => 'uploads/produk/default.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // 6. Seed Pesanan
        DB::table('t032_pesanan')->insertOrIgnore([
            [
                'id_pesanan'    => 1,
                'id_user'       => 3,
                'nomor_pesanan' => 'ORD-032-202610-001',
                'total_harga'   => 215000.00,
                'status'        => 'Selesai',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_pesanan'    => 2,
                'id_user'       => 3,
                'nomor_pesanan' => 'ORD-032-202610-002',
                'total_harga'   => 12500000.00,
                'status'        => 'Diproses',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
