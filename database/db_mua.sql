-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2026 at 03:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mua`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `tanggal_booking` datetime DEFAULT current_timestamp(),
  `tgl_booking` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status_booking` enum('pending','dikonfirmasi','konfirmasi','selesai','dibatalkan') DEFAULT 'pending',
  `konfirmasi_akhir_token` varchar(64) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id_booking`, `id_user`, `id_jadwal`, `no_telp`, `tanggal_booking`, `tgl_booking`, `total_harga`, `status_booking`, `konfirmasi_akhir_token`, `bukti_pembayaran`, `tanggal_upload`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 11, 16, '08125678910', '2026-05-29 15:34:11', '2026-05-29 15:34:11', 160000.00, 'selesai', '9abd93a9f059449b8400c25a781c5678c51e746d66422a6a', 'bukti_6a19501d32c24_booking_1.jpg', '2026-05-29 15:36:45', 'jawa', '2026-05-29 08:34:11', '2026-05-29 08:37:28'),
(2, 11, 17, '08125678910', '2026-05-29 19:22:52', '2026-05-29 19:22:52', 11010000.00, 'selesai', 'a5703f0a09d19a10ce6f3f43cae941ded2460603dd032bf6', 'bukti_6a1985be0dc5a_booking_2.jpg', '2026-05-29 19:25:34', 'Jl. medan', '2026-05-29 12:22:52', '2026-05-29 12:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `id_booking_detail` bigint(20) UNSIGNED NOT NULL,
  `id_booking` bigint(20) UNSIGNED NOT NULL,
  `id_layanan` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `harga` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `catatan_item` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_detail`
--

INSERT INTO `booking_detail` (`id_booking_detail`, `id_booking`, `id_layanan`, `qty`, `harga`, `subtotal`, `catatan_item`, `created_at`) VALUES
(1, 1, 25, 1, 150000.00, 150000.00, NULL, '2026-05-29 08:34:11'),
(2, 2, 32, 2, 5000000.00, 10000000.00, NULL, '2026-05-29 12:22:52'),
(3, 2, 30, 1, 1000000.00, 1000000.00, NULL, '2026-05-29 12:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` bigint(20) UNSIGNED NOT NULL,
  `kategori` enum('makeup','kostum','dekor') NOT NULL DEFAULT 'makeup',
  `judul` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kerja`
--

CREATE TABLE `jadwal_kerja` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kapasitas_max` int(11) NOT NULL DEFAULT 1,
  `status_slot` enum('tersedia','penuh','libur') DEFAULT 'tersedia',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_kerja`
--

INSERT INTO `jadwal_kerja` (`id_jadwal`, `tanggal`, `jam_mulai`, `jam_selesai`, `kapasitas_max`, `status_slot`, `created_at`) VALUES
(12, '2026-05-29', '19:42:00', '21:42:00', 1, 'tersedia', '2026-05-28 10:42:26'),
(13, '2026-05-12', '20:49:00', '22:49:00', 1, 'tersedia', '2026-05-28 10:50:00'),
(14, '2026-05-06', '21:37:00', '23:37:00', 1, 'tersedia', '2026-05-28 14:37:05'),
(15, '2026-05-06', '21:40:00', '23:40:00', 1, 'tersedia', '2026-05-28 14:39:51'),
(16, '2026-05-13', '15:33:00', '17:33:00', 1, 'penuh', '2026-05-29 08:34:00'),
(17, '2026-05-30', '19:23:00', '21:23:00', 1, 'penuh', '2026-05-29 12:22:14');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_tutup`
--

CREATE TABLE `jadwal_tutup` (
  `tanggal` date NOT NULL,
  `alasan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_layanan` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `tipe_layanan` enum('makeup','dekor','kostum','paket') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `kuantitas` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` bigint(20) UNSIGNED NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `kategori_layanan` enum('makeup','kostum','dekor','paket') NOT NULL DEFAULT 'makeup',
  `deskripsi` text DEFAULT NULL,
  `harga_dasar` decimal(12,2) NOT NULL,
  `foto_layanan` varchar(255) DEFAULT NULL,
  `variant_data` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `kategori_layanan`, `deskripsi`, `harga_dasar`, `foto_layanan`, `variant_data`, `is_active`, `created_at`, `updated_at`) VALUES
(22, '1 item terpilih', 'paket', 'Dibuat otomatis dari proses booking.', 150000.00, '../assets/fotomakeup_6.png', NULL, 0, '2026-05-28 10:43:30', '2026-05-28 11:33:59'),
(23, 'Makeup Graduation - Opsi 1', 'makeup', 'Dibuat otomatis dari proses booking.', 150000.00, '../assets/fotomakeup_6.png', NULL, 0, '2026-05-28 10:43:30', '2026-05-28 11:33:53'),
(24, 'Resepsi 1', 'kostum', 'Dibuat otomatis dari proses booking.', 4500000.00, '../assets/gallery_kostum/fotoresepsi.jpeg', NULL, 0, '2026-05-28 10:50:15', '2026-05-28 11:33:55'),
(25, 'Makeup Wisuda', 'makeup', 'jas\r\ntoga\r\nsepatu\r\nsuper', 150000.00, 'assets/layanan/layanan_6a1828666eb08.jpg', NULL, 0, '2026-05-28 11:35:02', '2026-05-29 08:21:59'),
(26, 'Makeup Akad - Opsi 1', 'makeup', 'Dibuat otomatis dari proses booking.', 6000000.00, '../assets/fotomakeup_1.jpeg', NULL, 0, '2026-05-28 14:40:22', '2026-05-29 08:21:56'),
(27, 'paket hilam', 'paket', 'spidol hitam', 12000.00, 'assets/layanan/layanan_6a19485403c94.jpg', NULL, 0, '2026-05-29 08:03:32', '2026-05-29 08:04:38'),
(28, 'Makeup Wisuda', 'makeup', 'jas\r\nsepatu\r\ncelana', 150000.00, 'assets/layanan/layanan_6a194e23e9aa7.jpg', NULL, 1, '2026-05-29 08:28:19', '2026-05-29 08:28:19'),
(29, 'kostum adat jawa', 'kostum', 'sepatu\r\njas hujan', 150000.00, 'assets/layanan/layanan_6a194e5090a4b.jpg', NULL, 1, '2026-05-29 08:29:04', '2026-05-29 08:29:04'),
(30, 'Indor', 'dekor', 'atap\r\ntiang\r\nkebun', 1000000.00, 'assets/layanan/layanan_6a194eafa8e62.png', NULL, 1, '2026-05-29 08:30:39', '2026-05-29 08:30:39'),
(31, '2 item terpilih', 'paket', 'Dibuat otomatis dari proses booking.', 11000000.00, '../assets/silver.jpeg', NULL, 1, '2026-05-29 12:22:52', '2026-05-29 12:22:52'),
(32, 'Paket Silver', 'paket', 'Dibuat otomatis dari proses booking.', 5000000.00, '../assets/silver.jpeg', NULL, 1, '2026-05-29 12:22:52', '2026-05-29 12:22:52');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` bigint(20) UNSIGNED NOT NULL,
  `id_booking` bigint(20) UNSIGNED NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `metode_bayar` enum('transfer','cash','ewallet') DEFAULT 'transfer',
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tgl_upload` datetime DEFAULT current_timestamp(),
  `status_verifikasi` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_booking`, `no_telp`, `jumlah_bayar`, `metode_bayar`, `bukti_transfer`, `tgl_upload`, `status_verifikasi`, `created_at`) VALUES
(1, 1, NULL, 160000.00, 'transfer', 'bukti_6a19501d32c24_booking_1.jpg', '2026-05-29 15:36:45', 'diterima', '2026-05-29 08:36:45'),
(2, 2, NULL, 11010000.00, 'transfer', 'bukti_6a1985be0dc5a_booking_2.jpg', '2026-05-29 19:25:34', 'diterima', '2026-05-29 12:25:34');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `full_name`, `email`, `no_telp`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(10, 'rafli_admin', 'Rafli Aulia Al Giffari', 'rafligifa123@gmail.com', '081256195884', '$2y$10$ne5rTgdeQvfJ1zAp.incv.xM2UA0AtG9HT7.wTnq2XlXhT66jETFS', 'admin', '2026-05-28 10:45:56', '2026-05-28 10:45:56'),
(11, 'rfl.au', 'Rafli Aulia Al Giffari', 'fliaulia28@gmail.com', NULL, '$2y$10$uQpzj3LnH.2FHcrLP0tjderJRDuH4DWJumCQHPJL2cdbCO7wN4dBq', 'client', '2026-05-29 08:32:48', '2026-05-29 08:32:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `idx_booking_user` (`id_user`),
  ADD KEY `idx_booking_jadwal` (`id_jadwal`);

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`id_booking_detail`),
  ADD KEY `idx_bookingdetail_booking` (`id_booking`),
  ADD KEY `idx_bookingdetail_layanan` (`id_layanan`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Indexes for table `jadwal_kerja`
--
ALTER TABLE `jadwal_kerja`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `jadwal_tutup`
--
ALTER TABLE `jadwal_tutup`
  ADD PRIMARY KEY (`tanggal`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `idx_keranjang_user` (`id_user`),
  ADD KEY `idx_keranjang_layanan` (`id_layanan`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `idx_pembayaran_booking` (`id_booking`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_detail`
--
ALTER TABLE `booking_detail`
  MODIFY `id_booking_detail` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jadwal_kerja`
--
ALTER TABLE `jadwal_kerja`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_kerja` (`id_jadwal`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD CONSTRAINT `fk_bd_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bd_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
