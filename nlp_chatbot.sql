-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2025 at 11:41 AM
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
-- Database: `nlp_chatbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosas`
--

CREATE TABLE `diagnosas` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `usia` int NOT NULL,
  `suhu_tubuh` decimal(4,2) NOT NULL,
  `tekanan_darah` decimal(5,2) NOT NULL,
  `asam_urat` decimal(5,2) NOT NULL,
  `kadar_urine` decimal(6,2) NOT NULL,
  `warna_urine` enum('jernih','kuning','keruh') NOT NULL,
  `konsumsi_air_putih` int NOT NULL,
  `nyeri_pinggang` enum('Ya','Tidak') NOT NULL,
  `sering_berkemih` enum('Ya','Tidak') NOT NULL,
  `mudah_lelah` enum('Ya','Tidak') NOT NULL,
  `mual_muntah` enum('Ya','Tidak') NOT NULL,
  `riwayat_ginjal` enum('Ya','Tidak') NOT NULL,
  `riwayat_hipertensi` enum('Ya','Tidak') NOT NULL,
  `riwayat_diabetes` enum('Ya','Tidak') NOT NULL,
  `hasil_diagnosa` text,
  `skor` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diagnosas`
--

INSERT INTO `diagnosas` (`id`, `user_id`, `usia`, `suhu_tubuh`, `tekanan_darah`, `asam_urat`, `kadar_urine`, `warna_urine`, `konsumsi_air_putih`, `nyeri_pinggang`, `sering_berkemih`, `mudah_lelah`, `mual_muntah`, `riwayat_ginjal`, `riwayat_hipertensi`, `riwayat_diabetes`, `hasil_diagnosa`, `skor`, `created_at`, `updated_at`) VALUES
(1, 2, 30, '37.00', '90.00', '5.00', '300.00', 'jernih', 8, 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', NULL, '0.08', '2025-06-05 02:29:17', '2025-06-05 02:29:17'),
(2, 2, 30, '37.00', '90.00', '5.00', '300.00', 'jernih', 8, 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', NULL, '0.08', '2025-06-05 02:54:58', '2025-06-05 02:54:58'),
(3, 2, 30, '37.00', '90.00', '5.00', '300.00', 'jernih', 8, 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', NULL, '0.08', '2025-06-05 03:07:11', '2025-06-05 03:07:11'),
(4, 2, 30, '37.00', '90.00', '5.00', '300.00', 'jernih', 8, 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', 'Tidak', NULL, '0.08', '2025-06-05 03:07:55', '2025-06-05 03:07:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'agiel', '$2y$12$4Pbh4MU53Q/PBwD6DTrCvuBlASJhZ/2AzNh1KhbxHCiP4pjGCjBIC', '2025-05-25 02:18:46', '2025-05-25 02:18:46'),
(2, 'agielf', '$2y$12$SLssld2P04vkOzJ8gGd1E.nEsQvyo/ggvG35/2cXEVTCmVve0Aa3S', '2025-06-04 23:45:22', '2025-06-04 23:45:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosas`
--
ALTER TABLE `diagnosas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_diagnosa_user` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnosas`
--
ALTER TABLE `diagnosas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnosas`
--
ALTER TABLE `diagnosas`
  ADD CONSTRAINT `fk_diagnosa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
