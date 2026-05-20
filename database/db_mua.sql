-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2026 at 05:28 AM
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
-- Table structure for table `add_on`
--

CREATE TABLE `add_on` (
  `id_addon` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `nama_addon` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_tambahan` decimal(12,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `tanggal_booking` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(12,2) NOT NULL,
  `status_booking` enum('pending','dibayar','dikonfirmasi','selesai','dibatalkan') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_detail`
--

CREATE TABLE `booking_detail` (
  `id_booking_detail` int(11) NOT NULL,
  `id_booking` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_addon` int(11) DEFAULT NULL,
  `harga_transaksi` decimal(12,2) NOT NULL,
  `catatan_item` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kerja`
--

CREATE TABLE `jadwal_kerja` (
  `id_jadwal` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kapasitas_max` int(11) NOT NULL DEFAULT 1,
  `status_slot` enum('tersedia','penuh','libur') DEFAULT 'tersedia',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jadwal_kerja`
--

INSERT INTO `jadwal_kerja` (`id_jadwal`, `tanggal`, `jam_mulai`, `jam_selesai`, `kapasitas_max`, `status_slot`, `created_at`, `updated_at`) VALUES
(1, '2026-05-12', '07:00:00', '10:00:00', 1, 'tersedia', '2026-05-15 21:37:07', '2026-05-15 21:37:07'),
(2, '2026-05-14', '15:00:00', '18:00:00', 1, 'tersedia', '2026-05-15 21:38:34', '2026-05-15 21:38:34'),
(3, '2026-05-22', '15:00:00', '18:00:00', 1, 'tersedia', '2026-05-15 21:40:17', '2026-05-15 21:40:17'),
(4, '2026-05-08', '15:00:00', '18:00:00', 1, 'tersedia', '2026-05-15 21:45:33', '2026-05-15 21:45:33'),
(5, '2026-05-21', '11:00:00', '13:00:00', 1, 'tersedia', '2026-05-15 21:52:44', '2026-05-15 21:52:44'),
(6, '2026-05-06', '07:00:00', '10:00:00', 1, 'tersedia', '2026-05-15 21:55:22', '2026-05-15 21:55:22'),
(7, '2026-05-07', '11:00:00', '13:00:00', 1, 'tersedia', '2026-05-15 21:57:13', '2026-05-15 21:57:13'),
(8, '2026-05-13', '07:00:00', '10:00:00', 1, 'tersedia', '2026-05-15 23:01:56', '2026-05-15 23:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_layanan` varchar(150) NOT NULL,
  `tipe_layanan` enum('makeup','dekor','kostum','paket') NOT NULL,
  `harga` int(11) NOT NULL,
  `kuantitas` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `nama_layanan`, `tipe_layanan`, `harga`, `kuantitas`, `created_at`, `updated_at`) VALUES
(11, 2, 'Makeup Wedding', 'makeup', 1500000, 1, '2026-05-15 04:16:11', '2026-05-15 04:16:11'),
(12, 2, 'Makeup Graduation', 'makeup', 800000, 1, '2026-05-15 04:16:14', '2026-05-15 04:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang_detail`
--

CREATE TABLE `keranjang_detail` (
  `id_keranjang_detail` int(11) NOT NULL,
  `id_keranjang` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL,
  `id_addon` int(11) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(12,2) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_dasar` decimal(12,2) NOT NULL,
  `foto_layanan` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `purpose` enum('register','reset_password') NOT NULL,
  `expired_at` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `hp` varchar(15) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_user`, `nama`, `hp`, `metode`, `alamat`, `bukti_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'lidya', '08125678910', 'Transfer Bank', 'assalamualaikum', 'bukti_6a05cd5294522_1.png', 'pending', '2026-05-14 13:25:38', '2026-05-14 13:25:38'),
(2, 1, 'lidya', '08125678910', 'Transfer Bank', 'asaaafdx', 'bukti_6a05cf2660db4_1.png', 'pending', '2026-05-14 13:33:26', '2026-05-14 13:33:26'),
(6, 1, 'Rafli', '08125678910', 'Transfer Bank', 'assalamualalikm', 'bukti_6a06c93a1bdd9_1.png', 'pending', '2026-05-15 07:20:26', '2026-05-15 07:20:26'),
(7, 1, 'lidya', '08125678910', 'Transfer Bank', 'kerjlkesd', 'bukti_6a06df8847967_1.png', 'pending', '2026-05-15 08:55:36', '2026-05-15 08:55:36'),
(8, 1, 'Rafli Aulia Al Giffari', '08125678910', 'COD', 'dsfdsf', 'bukti_6a07335cc8e41_1.png', 'pending', '2026-05-15 14:53:16', '2026-05-15 14:53:16'),
(9, 1, 'Rafli Aulia Al Giffari', '081256195884', 'Transfer Bank', 'jalan jalan', 'bukti_6a07340a18469_1.png', 'pending', '2026-05-15 14:56:10', '2026-05-15 14:56:10'),
(10, 1, 'Rafli Aulia Al Giffari', '08125678910', 'DANA', '878787987n m,', 'bukti_6a074544b3d81_1.png', 'pending', '2026-05-15 16:09:40', '2026-05-15 16:09:40'),
(11, 1, 'Rafli Aulia Al Giffari', '08125678910', 'DANA', 'n nm m', 'bukti_6a07460f07170_1.png', 'pending', '2026-05-15 16:13:03', '2026-05-15 16:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(20) DEFAULT 'client',
  `email` varchar(50) NOT NULL,
  `pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `full_name`, `username`, `role`, `email`, `pass`) VALUES
(1, 'Rafli Aulia Al Giffari', 'rfl.au', 'client', 'fliaulia28@gmail.com', '$2y$10$ErNru5oQ2KkJvpLSaibF4.u7yaMyW8TcXZlMNUpdFHDHt2poxQIaK'),
(2, 'tegar zain sagali', 'tegar', 'client', 'zaind377@gmail.com', '$2y$10$A6JDjEHYNwRjvxNYtKMTDOm.tbk0SSsPmoNlV7BfJMoRB54F7zLS.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_on`
--
ALTER TABLE `add_on`
  ADD PRIMARY KEY (`id_addon`),
  ADD KEY `fk_addon_layanan` (`id_layanan`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `fk_booking_user` (`id_user`),
  ADD KEY `fk_booking_layanan` (`id_layanan`),
  ADD KEY `fk_booking_jadwal` (`id_jadwal`);

--
-- Indexes for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD PRIMARY KEY (`id_booking_detail`),
  ADD KEY `fk_bd_booking` (`id_booking`),
  ADD KEY `fk_bd_layanan` (`id_layanan`),
  ADD KEY `fk_bd_addon` (`id_addon`);

--
-- Indexes for table `jadwal_kerja`
--
ALTER TABLE `jadwal_kerja`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  ADD PRIMARY KEY (`id_keranjang_detail`),
  ADD KEY `fk_kd_keranjang` (`id_keranjang`),
  ADD KEY `fk_kd_layanan` (`id_layanan`),
  ADD KEY `fk_kd_addon` (`id_addon`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_on`
--
ALTER TABLE `add_on`
  MODIFY `id_addon` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_detail`
--
ALTER TABLE `booking_detail`
  MODIFY `id_booking_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_kerja`
--
ALTER TABLE `jadwal_kerja`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  MODIFY `id_keranjang_detail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_on`
--
ALTER TABLE `add_on`
  ADD CONSTRAINT `fk_addon_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_kerja` (`id_jadwal`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `booking_detail`
--
ALTER TABLE `booking_detail`
  ADD CONSTRAINT `fk_bd_addon` FOREIGN KEY (`id_addon`) REFERENCES `add_on` (`id_addon`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bd_booking` FOREIGN KEY (`id_booking`) REFERENCES `booking` (`id_booking`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bd_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `keranjang_detail`
--
ALTER TABLE `keranjang_detail`
  ADD CONSTRAINT `fk_kd_addon` FOREIGN KEY (`id_addon`) REFERENCES `add_on` (`id_addon`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kd_keranjang` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kd_layanan` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
