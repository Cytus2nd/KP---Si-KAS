-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 02, 2024 at 12:56 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_kas`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_organisasi`
--

CREATE TABLE `data_organisasi` (
  `id_organisasi` int NOT NULL,
  `nama_organisasi` varchar(200) NOT NULL,
  `ketua_organisasi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pembina_organisasi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user_bendahara` int DEFAULT NULL,
  `last_edit_by` int DEFAULT NULL,
  `last_edit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_organisasi`
--

INSERT INTO `data_organisasi` (`id_organisasi`, `nama_organisasi`, `ketua_organisasi`, `pembina_organisasi`, `id_user_bendahara`, `last_edit_by`, `last_edit`) VALUES
(1, 'OSIS', 'Hendri', 'Pak Dunandszjs', 16, 2, '2024-07-30 10:44:05'),
(2, 'Pramuka', 'Hendra', 'Pak Denands', 2, 2, '2024-07-30 10:44:35'),
(3, 'PMR', 'Kasirun', 'Dio Brando', 2, 2, '2024-07-30 10:44:35'),
(4, 'KKR', 'Unknown', 'Unknown', 2, 2, '2024-07-30 10:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int NOT NULL,
  `kode_jabatan` int NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `kode_jabatan`, `nama_jabatan`, `created_at`) VALUES
(1, 1, 'Kepala Sekolah', '2024-07-27 12:04:44'),
(2, 2, 'Waka Kesiswaan', '2024-07-27 12:05:20'),
(3, 3, 'Bendahara OSIS', '2024-07-27 12:05:33'),
(4, 4, 'Bendahara Pramuka', '2024-07-27 12:06:01'),
(5, 5, 'Bendahara PMR', '2024-07-27 12:06:27'),
(6, 6, 'Bendahara KKR', '2024-07-27 12:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `kas_kkr`
--

CREATE TABLE `kas_kkr` (
  `id_kas_kkr` int NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `tipe_kas` enum('pemasukan','pengeluaran') NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_osis`
--

CREATE TABLE `kas_osis` (
  `id_kas_osis` int NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `tipe_kas` enum('pemasukan','pengeluaran') NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_pmr`
--

CREATE TABLE `kas_pmr` (
  `id_kas_pmr` int NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `tipe_kas` enum('pemasukan','pengeluaran') NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_pramuka`
--

CREATE TABLE `kas_pramuka` (
  `id_kas_pramuka` int NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(150) NOT NULL,
  `tipe_kas` enum('pemasukan','pengeluaran') NOT NULL,
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `jabatan` int NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `no_telp` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `is_banned` enum('0','1') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `jabatan`, `jenis_kelamin`, `no_telp`, `is_banned`, `created_at`) VALUES
(2, 'Hendri', 'hendri1', '$2y$10$6RAzhNxyxERHG3SQuTFQEepaCPOZrMYRCIewsYXUCugWHOx73dbnm', 1, 'laki-laki', '088899990001', '0', '2024-07-27 15:43:38'),
(16, 'Hendra', 'hendri2', '$2y$10$UyGDgsdqW1ciFFo7.a0Uo.eh62UcQcS/dgBBlcojv0u37YYjcJeiO', 3, 'laki-laki', '081213141517', '0', '2024-08-02 12:48:42'),
(17, 'Hendri', 'hendri4', '$2y$10$sfdajPRqCbE3Bqhj3dKFReMTJfQbSWG5UIuRsGSCCDscRJF5i2Gnm', 4, 'laki-laki', '081213141518', '0', '2024-08-02 14:21:56'),
(18, 'Hendri', 'hendri5', '$2y$10$clYcvoukorq1Uq5W9Ed9AeIBfUqiToQUgoaxpKAR7El98qJG38M12', 5, 'laki-laki', '081213141519', '0', '2024-08-02 14:22:33'),
(19, 'Hendri', 'hendri6', '$2y$10$kp0lad.2p4.8B1j0mcMXTO6.3LfojQFl9N0OWpNX3fUv07bkTwTS.', 6, 'laki-laki', '081213141520', '0', '2024-08-02 14:23:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_organisasi`
--
ALTER TABLE `data_organisasi`
  ADD PRIMARY KEY (`id_organisasi`),
  ADD KEY `id_user_bendahara` (`id_user_bendahara`),
  ADD KEY `last_edit_by` (`last_edit_by`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD KEY `kode_jabatan` (`kode_jabatan`);

--
-- Indexes for table `kas_kkr`
--
ALTER TABLE `kas_kkr`
  ADD PRIMARY KEY (`id_kas_kkr`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `kas_osis`
--
ALTER TABLE `kas_osis`
  ADD PRIMARY KEY (`id_kas_osis`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `kas_pmr`
--
ALTER TABLE `kas_pmr`
  ADD PRIMARY KEY (`id_kas_pmr`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `kas_pramuka`
--
ALTER TABLE `kas_pramuka`
  ADD PRIMARY KEY (`id_kas_pramuka`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `jabatan` (`jabatan`),
  ADD KEY `no_telp` (`no_telp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_organisasi`
--
ALTER TABLE `data_organisasi`
  MODIFY `id_organisasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kas_kkr`
--
ALTER TABLE `kas_kkr`
  MODIFY `id_kas_kkr` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_osis`
--
ALTER TABLE `kas_osis`
  MODIFY `id_kas_osis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_pmr`
--
ALTER TABLE `kas_pmr`
  MODIFY `id_kas_pmr` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_pramuka`
--
ALTER TABLE `kas_pramuka`
  MODIFY `id_kas_pramuka` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_organisasi`
--
ALTER TABLE `data_organisasi`
  ADD CONSTRAINT `data_organisasi_ibfk_1` FOREIGN KEY (`id_user_bendahara`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `data_organisasi_ibfk_2` FOREIGN KEY (`last_edit_by`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kas_kkr`
--
ALTER TABLE `kas_kkr`
  ADD CONSTRAINT `kas_kkr_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kas_osis`
--
ALTER TABLE `kas_osis`
  ADD CONSTRAINT `kas_osis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kas_pmr`
--
ALTER TABLE `kas_pmr`
  ADD CONSTRAINT `kas_pmr_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kas_pramuka`
--
ALTER TABLE `kas_pramuka`
  ADD CONSTRAINT `kas_pramuka_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`jabatan`) REFERENCES `jabatan` (`kode_jabatan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;