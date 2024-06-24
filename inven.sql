-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2024 at 06:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inven`
--

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `id` int NOT NULL,
  `nama_furniture` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `room` varchar(10) NOT NULL,
  `image` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `nama_furniture`, `merk`, `jumlah`, `room`, `image`, `keterangan`) VALUES
(13, 'MEJA', 'INNOLA', 25, 'D203', '[\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Pinjam 10');

-- --------------------------------------------------------

--
-- Table structure for table `furniture_history`
--

CREATE TABLE `furniture_history` (
  `id` int NOT NULL,
  `furniture_id` int DEFAULT NULL,
  `nama_furniture` varchar(255) DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `image` text,
  `keterangan` text,
  `changed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `furniture_history`
--

INSERT INTO `furniture_history` (`id`, `furniture_id`, `nama_furniture`, `merk`, `jumlah`, `room`, `image`, `keterangan`, `changed_at`, `action`) VALUES
(1, 13, 'MEJA', 'INNOLA', 30, NULL, '2022_Acer_Commercial_Option_04_3840x2400.jpg', 'Original', '2024-06-24 03:08:38', NULL),
(2, 13, 'MEJA', 'INNOLA', 35, NULL, '[\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\"]', 'Tambah 5 Meja', '2024-06-24 03:10:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE `laptops` (
  `id` int NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `purchase_date` date NOT NULL,
  `images` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original',
  `room` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `brand`, `model`, `serial_number`, `purchase_date`, `images`, `keterangan`, `room`) VALUES
(1, 'ace', 'zenn', '553', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', 'D208'),
(3, 'asus', 'ROG', '63653534', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (9).png\",\"Screenshot (8).png\",\"Screenshot (13).png\",\"Screenshot (12).png\",\"Screenshot (9).png\",\"Screenshot (8).png\"]', 'Original', 'D208'),
(4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\"]', 'Original', 'D208'),
(5, 'tes', 'asd', '111', '2024-06-14', NULL, 'Original', 'D208'),
(6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (11).png\"]', 'Original', 'D208'),
(7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (7).png\"]', 'Ganti Serial Number', 'D208'),
(12, 'lenonnnn', 'rrrr', '64564', '2024-06-14', NULL, 'Original', 'D203'),
(13, 'toshiba', 'think', '00', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Ori', 'D203'),
(15, 'g', 'gfgsd', '634', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_03_3840x2400.jpg\"]', 'Ganti Model', 'D203'),
(16, 'asus', 'zenn', '5535233', '2024-06-20', 'Screenshot (8).png', 'Original', 'D203');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_history`
--

CREATE TABLE `laptop_history` (
  `id` int NOT NULL,
  `laptop_id` int NOT NULL,
  `old_brand` varchar(100) NOT NULL,
  `old_model` varchar(100) NOT NULL,
  `old_serial_number` varchar(100) NOT NULL,
  `old_purchase_date` date NOT NULL,
  `images` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laptop_history`
--

INSERT INTO `laptop_history` (`id`, `laptop_id`, `old_brand`, `old_model`, `old_serial_number`, `old_purchase_date`, `images`, `keterangan`, `updated_at`) VALUES
(1, 3, 'tgerwtyer', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '', 'Original', '2024-06-11 07:39:06'),
(2, 4, 'lenovo', '8088064643', '80808', '2024-06-11', '', 'Original', '2024-06-11 08:15:51'),
(3, 4, 'lenovo', '8088064', '808', '2024-06-11', '', 'Original', '2024-06-12 01:35:05'),
(4, 4, 'lenovo', '8088064', '8', '2024-06-11', '', 'Original', '2024-06-12 01:35:17'),
(5, 4, 'lenovo', '8088064', '86464', '2024-06-11', '', 'Original', '2024-06-12 01:38:52'),
(6, 3, 'asus', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '', 'Original', '2024-06-12 02:03:47'),
(7, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:04:44'),
(8, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:05:20'),
(9, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:36:31'),
(10, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:36:40'),
(11, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:38:12'),
(12, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:38:21'),
(13, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:40:04'),
(14, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:40:14'),
(15, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', '2024-06-12 02:48:14'),
(16, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\"]', 'Original', '2024-06-12 02:55:22'),
(17, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\"]', 'Original', '2024-06-12 02:57:21'),
(18, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 02:57:30'),
(19, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 02:58:03'),
(20, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 02:58:11'),
(21, 4, 'leno', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 02:58:22'),
(22, 6, 'samsung', 'T1', '80', '2024-06-12', 'Screenshot (7).png', 'Original', '2024-06-12 03:09:50'),
(23, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\"]', 'Original', '2024-06-12 03:10:21'),
(24, 7, 'leno', 'zenn', '5535233', '2024-06-12', 'Screenshot (10).png', 'Original', '2024-06-12 03:21:37'),
(25, 7, 'leno', 'zenn', '64643', '2024-06-12', '[\"Screenshot (8).png\"]', 'Ganti Serial Number', '2024-06-12 03:22:07'),
(26, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\"]', 'Ganti Model ', '2024-06-12 03:26:39'),
(27, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\"]', 'Ganti Model ', '2024-06-12 03:35:47'),
(28, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\"]', 'Ganti Model ', '2024-06-12 03:36:46'),
(29, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Model ', '2024-06-12 03:37:09'),
(30, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:37:17'),
(31, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:39:41'),
(32, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:47:09'),
(33, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:48:52'),
(34, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:49:21'),
(35, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:49:33'),
(36, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\"]', 'Ganti Serial Number', '2024-06-12 03:52:51'),
(37, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\"]', 'Ganti Serial Number', '2024-06-12 03:53:00'),
(38, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:53:08'),
(39, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\"]', 'Ganti Serial Number', '2024-06-12 04:13:57'),
(40, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (11).png\"]', 'Ganti Serial Number', '2024-06-12 04:14:04'),
(41, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:14:57'),
(42, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:15:03'),
(43, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:15:13'),
(44, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Original', '2024-06-12 04:15:30'),
(45, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:15:40'),
(46, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (11).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:15:50'),
(47, 4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:16:19'),
(48, 4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 04:16:26'),
(49, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\"]', 'Original', '2024-06-13 07:52:10'),
(50, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', '2024-06-14 03:42:24'),
(51, 13, 'toshiba', 'think', '0009', '2024-06-14', '2022_Acer_Commercial_Option_03_3840x2400.jpg', 'Original', '2024-06-14 03:45:26'),
(52, 13, 'toshiba', 'think', '00', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Original', '2024-06-14 03:45:38'),
(53, 15, 'gsgs', 'gfgsd', '634634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Original', '2024-06-20 05:26:48'),
(54, 15, 'gsgs', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Serial Number', '2024-06-20 05:27:18'),
(55, 15, 'gs', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Brand', '2024-06-20 05:27:39'),
(56, 15, 'g', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Model', '2024-06-20 05:28:49'),
(57, 15, 'g', 'gfgsd', '634', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Ganti Model', '2024-06-20 05:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$7nJGR7G3LGs8r2CMu6L1tOGU0J.nG41g6ly5s70Hdh4KtKGoob0j.', '2024-06-24 05:29:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `furniture_history`
--
ALTER TABLE `furniture_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `furniture_id` (`furniture_id`);

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indexes for table `laptop_history`
--
ALTER TABLE `laptop_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `furniture_history`
--
ALTER TABLE `furniture_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `laptop_history`
--
ALTER TABLE `laptop_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `furniture_history`
--
ALTER TABLE `furniture_history`
  ADD CONSTRAINT `furniture_history_ibfk_1` FOREIGN KEY (`furniture_id`) REFERENCES `furniture` (`id`);

--
-- Constraints for table `laptop_history`
--
ALTER TABLE `laptop_history`
  ADD CONSTRAINT `laptop_history_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
