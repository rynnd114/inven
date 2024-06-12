-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 12, 2024 at 05:24 AM
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
-- Database: `inven`
--

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
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `brand`, `model`, `serial_number`, `purchase_date`, `images`, `keterangan`) VALUES
(1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\"]', 'Original'),
(3, 'asus', 'ROG', '63653534', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (9).png\",\"Screenshot (8).png\",\"Screenshot (13).png\",\"Screenshot (12).png\",\"Screenshot (9).png\",\"Screenshot (8).png\"]', 'Original'),
(4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\"]', 'Original'),
(6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (11).png\"]', 'Original'),
(7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (7).png\"]', 'Ganti Serial Number'),
(8, 'samsung', 'Rog', '80808', '2024-06-12', 'Screenshot (12).png', 'Original');

-- --------------------------------------------------------

--
-- Table structure for table `update_history`
--

CREATE TABLE `update_history` (
  `id` int NOT NULL,
  `laptop_id` int NOT NULL,
  `old_brand` varchar(100) NOT NULL,
  `old_model` varchar(100) NOT NULL,
  `old_serial_number` varchar(100) NOT NULL,
  `old_purchase_date` date NOT NULL,
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `update_history`
--

INSERT INTO `update_history` (`id`, `laptop_id`, `old_brand`, `old_model`, `old_serial_number`, `old_purchase_date`, `images`, `keterangan`, `updated_at`) VALUES
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
(48, 4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 04:16:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`);

--
-- Indexes for table `update_history`
--
ALTER TABLE `update_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laptop_id` (`laptop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `update_history`
--
ALTER TABLE `update_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `update_history`
--
ALTER TABLE `update_history`
  ADD CONSTRAINT `update_history_ibfk_1` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
