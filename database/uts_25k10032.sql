-- ==============================================================
-- Proyek Ujian Tengah Semester (UTS) - Internet Programming
-- Studi Kasus: SiToko - Toko Online Sederhana (SiToko-032)
-- Nama Mahasiswa : Berlynda Vanetta
-- NIM            : 25.K1.0032
-- Nama Database  : uts_25k10032
-- Prefix Tabel   : t032_
-- ==============================================================

CREATE DATABASE IF NOT EXISTS `uts_25k10032` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `uts_25k10032`;

-- --------------------------------------------------------------
-- 1. Tabel: t032_roles
-- Level user: Admin, Kasir, Pelanggan
-- --------------------------------------------------------------
DROP TABLE IF EXISTS `t032_api_tokens`;
DROP TABLE IF EXISTS `t032_pesanan`;
DROP TABLE IF EXISTS `t032_produk`;
DROP TABLE IF EXISTS `t032_kategori`;
DROP TABLE IF EXISTS `t032_users`;
DROP TABLE IF EXISTS `t032_roles`;

CREATE TABLE `t032_roles` (
    `id_role` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_role` VARCHAR(50) NOT NULL UNIQUE,
    `keterangan` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------
-- 2. Tabel: t032_users
-- Akun pengguna sistem dengan relasi ke roles
-- --------------------------------------------------------------
CREATE TABLE `t032_users` (
    `id_user` INT AUTO_INCREMENT PRIMARY KEY,
    `id_role` INT NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NULL,
    `foto_profil` VARCHAR(255) NOT NULL DEFAULT 'uploads/profil/default.png',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) 
        REFERENCES `t032_roles` (`id_role`) 
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------
-- 3. Tabel: t032_kategori
-- Master data kategori produk
-- --------------------------------------------------------------
CREATE TABLE `t032_kategori` (
    `id_kategori` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_kategori` VARCHAR(100) NOT NULL UNIQUE,
    `deskripsi` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------
-- 4. Tabel: t032_produk
-- Entitas utama produk SiToko-032
-- --------------------------------------------------------------
CREATE TABLE `t032_produk` (
    `id_produk` INT AUTO_INCREMENT PRIMARY KEY,
    `id_kategori` INT NOT NULL,
    `kode_produk` VARCHAR(50) NOT NULL UNIQUE,
    `nama_produk` VARCHAR(150) NOT NULL,
    `harga` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `stok` INT NOT NULL DEFAULT 0,
    `deskripsi` TEXT NULL,
    `gambar` VARCHAR(255) NULL DEFAULT 'uploads/produk/default.png',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`id_kategori`) 
        REFERENCES `t032_kategori` (`id_kategori`) 
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------
-- 5. Tabel: t032_pesanan
-- Data transaksi pesanan pelanggan
-- --------------------------------------------------------------
CREATE TABLE `t032_pesanan` (
    `id_pesanan` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT NOT NULL,
    `nomor_pesanan` VARCHAR(50) NOT NULL UNIQUE,
    `total_harga` DECIMAL(12, 2) NOT NULL DEFAULT 0.00,
    `status` ENUM('Menunggu Pembayaran', 'Diproses', 'Selesai', 'Dibatalkan') DEFAULT 'Menunggu Pembayaran',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`id_user`) 
        REFERENCES `t032_users` (`id_user`) 
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------------
-- 6. Tabel: t032_api_tokens
-- Token Bearer API untuk autentikasi endpoint REST API
-- --------------------------------------------------------------
CREATE TABLE `t032_api_tokens` (
    `id_token` INT AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT NOT NULL,
    `token` VARCHAR(64) NOT NULL UNIQUE,
    `expires_at` DATETIME NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_token_user` FOREIGN KEY (`id_user`) 
        REFERENCES `t032_users` (`id_user`) 
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==============================================================
-- DML DATA SEEDER AWAL
-- ==============================================================

-- 1. Seeder Roles
INSERT INTO `t032_roles` (`id_role`, `nama_role`, `keterangan`) VALUES
(1, 'Admin', 'Super Administrator dengan hak akses penuh seluruh modul sistem'),
(2, 'Kasir', 'Petugas kasir pengelola data produk, kategori, dan transaksi'),
(3, 'Pelanggan', 'Pengguna terdaftar / pembeli di SiToko-032');

-- 2. Seeder Users (Password default: admin123 -> $2y$12$mgE94VaozMN.K3elo.BZ5OPup/nD7SYc.NIDF8Rt0Hh7IJMWYy4iK)
-- Super Admin: Username 25.K1.0032, Nama Berlynda Vanetta, Foto uploads/profil/0032.jpg
INSERT INTO `t032_users` (`id_user`, `id_role`, `username`, `password`, `nama_lengkap`, `email`, `foto_profil`) VALUES
(1, 1, '25.K1.0032', '$2y$12$mgE94VaozMN.K3elo.BZ5OPup/nD7SYc.NIDF8Rt0Hh7IJMWYy4iK', 'Berlynda Vanetta', '25.k1.0032@student.unika.ac.id', 'uploads/profil/0032.jpg'),
(2, 2, 'kasir032', '$2y$12$mgE94VaozMN.K3elo.BZ5OPup/nD7SYc.NIDF8Rt0Hh7IJMWYy4iK', 'Siti Kasir 032', 'kasir032@sitoko.local', 'uploads/profil/default.png'),
(3, 3, 'pelanggan032', '$2y$12$mgE94VaozMN.K3elo.BZ5OPup/nD7SYc.NIDF8Rt0Hh7IJMWYy4iK', 'Budi Pelanggan 032', 'budi032@gmail.com', 'uploads/profil/default.png');

-- 3. Seeder Token API Siap Pakai (Masa berlaku s/d 2030)
INSERT INTO `t032_api_tokens` (`id_token`, `id_user`, `token`, `expires_at`) VALUES
(1, 1, 'sitoko032_admintoken_berlynda_2026', '2030-12-31 23:59:59'),
(2, 2, 'sitoko032_kasirtoken_demo_2026', '2030-12-31 23:59:59'),
(3, 3, 'sitoko032_pelanggantoken_demo_2026', '2030-12-31 23:59:59');

-- 4. Seeder Kategori
INSERT INTO `t032_kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Elektronik & Gadget', 'Perangkat komputer, laptop, aksesoris, dan gadget modern'),
(2, 'Fashion & Busana', 'Pakaian pria dan wanita, jaket, kaos, dan celana'),
(3, 'Makanan & Minuman', 'Kopi asli nusantara, teh herbal, dan camilan pilihan'),
(4, 'Buku & Alat Tulis', 'Buku referensi teknologi, novel, dan perlengkapan tulis');

-- 5. Seeder Data Produk (Minimal 12 baris: 10 + digit terakhir NIM 2)
INSERT INTO `t032_produk` (`id_produk`, `id_kategori`, `kode_produk`, `nama_produk`, `harga`, `stok`, `deskripsi`, `gambar`) VALUES
(1, 1, 'PRD-032-001', 'Laptop Ultrabook Pro 14"', 12500000.00, 8, 'Laptop tipis performa tinggi Intel Core i7, RAM 16GB, SSD 512GB NVMe.', 'uploads/produk/default.png'),
(2, 1, 'PRD-032-002', 'Mouse Wireless Ergonomic', 150000.00, 25, 'Mouse nirkabel presisi tinggi dengan tombol silent click dan baterai awet.', 'uploads/produk/default.png'),
(3, 1, 'PRD-032-003', 'Keyboard Mechanical RGB', 450000.00, 14, 'Keyboard mekanikal dengan switch blue taktil dan efek pencahayaan RGB.', 'uploads/produk/default.png'),
(4, 1, 'PRD-032-004', 'Headset Gaming 7.1 Surround', 375000.00, 18, 'Audio spasial 7.1 dengan mikrofon fleksibel noise-cancelling untuk meeting & gaming.', 'uploads/produk/default.png'),
(5, 2, 'PRD-032-005', 'Kaos Polos Katun Combed 30s', 65000.00, 50, 'Kaos katun combed 30s premium berdaya serap tinggi dan sangat nyaman dipakai.', 'uploads/produk/default.png'),
(6, 2, 'PRD-032-006', 'Jaket Hoodie Fleece Unisex', 185000.00, 20, 'Hoodie tebal lembut berbahan fleece katun dengan kantong kanguru di bagian depan.', 'uploads/produk/default.png'),
(7, 2, 'PRD-032-007', 'Celana Chino Slim Fit', 140000.00, 30, 'Celana panjang chino slim fit katun twill stretch cocok untuk formal maupun kasual.', 'uploads/produk/default.png'),
(8, 3, 'PRD-032-008', 'Kopi Arabika Gayo 250gr', 75000.00, 40, 'Biji kopi pilihan roasted bean dari dataran tinggi Aceh Gayo beraroma rempah dan floral.', 'uploads/produk/default.png'),
(9, 3, 'PRD-032-009', 'Teh Hijau Melati Organik', 35000.00, 35, 'Teh hijau pucuk pilihan beraroma melati segar kaya antioksidan alami.', 'uploads/produk/default.png'),
(10, 3, 'PRD-032-010', 'Keripik Singkong Balado 200gr', 18000.00, 60, 'Keripik singkong renyah dengan taburan bumbu cabai balado pedas manis gurih.', 'uploads/produk/default.png'),
(11, 4, 'PRD-032-011', 'Buku Pemrograman Web Modern', 95000.00, 15, 'Buku panduan membangun aplikasi web terstruktur dengan PHP, MySQL, & REST API.', 'uploads/produk/default.png'),
(12, 4, 'PRD-032-012', 'Buku Catatan Jurnal Hardcover', 42000.00, 22, 'Buku catatan jilid hardcover tebal 100 lembar kertas dotted 100 gsm bebas rembes.', 'uploads/produk/default.png');

-- 6. Seeder Pesanan
INSERT INTO `t032_pesanan` (`id_pesanan`, `id_user`, `nomor_pesanan`, `total_harga`, `status`) VALUES
(1, 3, 'ORD-032-202610-001', 215000.00, 'Selesai'),
(2, 3, 'ORD-032-202610-002', 12500000.00, 'Diproses');
