-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 11, 2024 at 08:19 AM
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
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `brand`, `model`, `serial_number`, `purchase_date`, `images`) VALUES
(1, 'ace', 'zenn', '5535233', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\"]'),
(3, 'asus', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\"]'),
(4, 'lenovo', '8088064643', '80808', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]');

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
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `update_history`
--

INSERT INTO `update_history` (`id`, `laptop_id`, `old_brand`, `old_model`, `old_serial_number`, `old_purchase_date`, `updated_at`) VALUES
(1, 3, 'tgerwtyer', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '2024-06-11 07:39:06'),
(2, 4, 'lenovo', '8088064643', '80808', '2024-06-11', '2024-06-11 08:15:51');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `update_history`
--
ALTER TABLE `update_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
