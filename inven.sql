-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2024 at 05:55 AM
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
  `room` varchar(10) NOT NULL,
  `image` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original',
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`id`, `nama_furniture`, `merk`, `room`, `image`, `keterangan`, `kondisi`) VALUES
(1, 'Meja Belajar', 'IKEA', 'D203', 'meja_belajar.jpg', 'Original', 'Baik'),
(2, 'Kursi Kantor', 'Herman Miller', 'D203', 'kursi_kantor.jpg', 'Original', 'Sangat Baik'),
(3, 'Lemari Buku', 'Informa', 'D208', 'lemari_buku.jpg', 'Original', 'Baik'),
(4, 'Sofa', 'Ashley', 'Komputasi', 'sofa.jpg', 'Original', 'Baik'),
(5, 'Meja Tamu', 'IKEA', 'Komputasi', 'meja_tamu.jpg', 'Original', 'Baik'),
(6, 'Rak Sepatu', 'Olympic', 'D208', 'rak_sepatu.jpg', 'Original', 'Cukup Baik'),
(7, 'Tempat Tidur', 'Spring Air', 'D208', 'tempat_tidur.jpg', 'Original', 'Baik'),
(8, 'Cermin', 'HOMZ', 'D203', 'cermin.jpg', 'Original', 'Sangat Baik'),
(9, 'Lemari Pakaian', 'California', 'D203', 'lemari_pakaian.jpg', 'Original', 'Baik'),
(10, 'Meja Rias', 'Informa', 'Komputasi', 'meja_rias.jpg', 'Original', 'Baik');

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

-- --------------------------------------------------------

--
-- Table structure for table `laboran_kalab`
--

CREATE TABLE `laboran_kalab` (
  `id` int NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('laboran','kalab') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laboran_kalab`
--

INSERT INTO `laboran_kalab` (`id`, `nip`, `password`, `name`, `role`) VALUES
(1, '456789123', '$2y$10$W4O6F8J5H1wBsJkXgMzdeuxqltGij32F0lv8JHtiQYVxhH4Mj3uZm', 'Laboran 1', 'laboran'),
(2, '654321987', '$2y$10$cG2j0B/wnB9hxV0bTgD9P.i/L3I9mBp0YdT5iwIwvDe/u/RGSEMuq', 'Kalab 1', 'kalab'),
(3, '789123456', '$2y$10$0.M3mDUp7ZP8FWKx7s7iV.KFGQieHhzVIK4WJDbTfhpmXK4DgRb2K', 'Laboran 2', 'laboran'),
(4, '64020418', '$2y$10$n.rB07Bk6w4nihOAyFd9a.NCnDxa6HAr8b1URZYpwZ48nXAtjMZpu', 'Arya', 'kalab'),
(5, '64020419', '$2y$10$pHUVO/I2qHX3e1G775cVZe5606bed/RDJ0CW41E4gOtGYxUE4UtqW', 'nanda', 'laboran');

-- --------------------------------------------------------

--
-- Table structure for table `lab_bookings`
--

CREATE TABLE `lab_bookings` (
  `id` int NOT NULL,
  `nim` int NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `hari_tanggal_mulai` date NOT NULL,
  `hari_tanggal_selesai` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `jumlah_peserta` int NOT NULL,
  `periode_peminjaman` int NOT NULL,
  `jenis_ruangan` varchar(255) NOT NULL,
  `fasilitas` text NOT NULL,
  `tanggal_pengambilan` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL,
  `jenis_peminjaman` enum('berturut-turut','berulang') NOT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Sedang Diperiksa Oleh Laboran',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_bookings`
--

INSERT INTO `lab_bookings` (`id`, `nim`, `nama_kegiatan`, `hari_tanggal_mulai`, `hari_tanggal_selesai`, `waktu_mulai`, `waktu_selesai`, `jumlah_peserta`, `periode_peminjaman`, `jenis_ruangan`, `fasilitas`, `tanggal_pengambilan`, `tanggal_pengembalian`, `jenis_peminjaman`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(9, 2009106114, 'Kelas Desain UI UX', '2024-09-05', '2024-09-12', '15:00:00', '17:00:00', 50, 8, 'D203', 'Array', '2024-09-05', '2024-09-12', 'berulang', 'Disetujui', 'Peminjaman Lab Disetujui', '2024-09-09 04:21:34', '2024-09-09 04:26:39'),
(10, 2009106114, '8yfv8', '2024-09-09', '2024-09-16', '13:33:00', '16:33:00', 69, 8, 'Lab Komputasi', 'Array', '2024-09-09', '2024-09-16', 'berulang', 'Menunggu Persetujuan Laboran', 'Sedang Diperiksa Oleh Laboran', '2024-09-09 04:34:01', '2024-09-09 04:34:01'),
(11, 2009106114, 'uvgcj', '2024-09-16', '2024-10-07', '13:36:00', '17:36:00', 69, 22, 'Lab Komputasi', 'Array', '2024-09-09', '2024-09-30', 'berulang', 'Menunggu Persetujuan Laboran', 'Sedang Diperiksa Oleh Laboran', '2024-09-09 04:36:59', '2024-09-09 04:36:59'),
(12, 2009106114, '76dtcm ', '2024-09-10', '2024-09-24', '12:41:00', '13:41:00', 68, 29, 'D203', 'Array', '2024-09-09', '2024-09-16', 'berulang', 'Menunggu Persetujuan Laboran', 'Sedang Diperiksa Oleh Laboran', '2024-09-09 04:41:31', '2024-09-09 04:43:49');

-- --------------------------------------------------------

--
-- Table structure for table `lab_booking_days`
--

CREATE TABLE `lab_booking_days` (
  `id` int NOT NULL,
  `lab_booking_id` int NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab_booking_days`
--

INSERT INTO `lab_booking_days` (`id`, `lab_booking_id`, `day_of_week`) VALUES
(6, 9, 'Thursday'),
(7, 10, 'Wednesday'),
(8, 11, 'Monday'),
(9, 12, 'Tuesday');

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
  `room` varchar(50) DEFAULT NULL,
  `ram` varchar(50) NOT NULL,
  `memori` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `processor` varchar(100) NOT NULL,
  `layar` varchar(100) NOT NULL,
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `brand`, `model`, `serial_number`, `purchase_date`, `images`, `keterangan`, `room`, `ram`, `memori`, `os`, `processor`, `layar`, `kondisi`) VALUES
(1, 'ace', 'zenn', '553', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', 'D208', '', '', '', '', '', ''),
(3, 'asus', 'ROG', '63653534', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (9).png\",\"Screenshot (8).png\",\"Screenshot (13).png\",\"Screenshot (12).png\",\"Screenshot (9).png\",\"Screenshot (8).png\"]', 'Original', 'D208', '', '', '', '', '', ''),
(4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\",\"Screenshot (11).png\"]', 'Original', 'D208', '', '', '', '', '', ''),
(5, 'tes', 'asd', '111', '2024-06-14', NULL, 'Original', 'D208', '', '', '', '', '', ''),
(6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (11).png\"]', 'Original', 'D208', '', '', '', '', '', ''),
(7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (11).png\",\"Screenshot (7).png\"]', 'Ganti Serial Number', 'D208', '', '', '', '', '', ''),
(13, 'toshiba', 'think', '00', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Ori', 'D203', '', '', '', '', '', ''),
(16, 'asus', 'zenn', '5535233', '2024-06-20', 'Screenshot (8).png', 'Original', 'D203', '', '', '', '', '', ''),
(18, 'dellll', 'ffr', '00999', '2024-07-08', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\"]', 'Ganti model', 'D203', '', '', '', '', '', ''),
(19, 'for', 'e', '900', '2024-07-08', '2022_Acer_Commercial_Option_02_3840x2400.jpg', 'Original', 'D203', '', '', '', '', '', ''),
(20, 'for', 'e', '999', '2024-07-08', '2022_Acer_Commercial_Option_04_3840x2400.jpg', 'Original', 'D208', '', '', '', '', '', ''),
(21, 'te', 'mmm', '099', '2024-07-10', '[\"Universitas Persada Indonesia YAI.png\"]', 'Original', 'Komputasi', '', '', '', '', '', ''),
(22, 'Dell', 'Inspiron 15', 'SN12345', '2023-01-15', 'image1.jpg', 'Original', 'D203', '8GB', '512GB SSD', 'Windows 10', 'Intel Core i5', '15.6\"', 'Baik'),
(23, 'HP', 'Pavilion', 'SN67890', '2022-03-22', 'image2.jpg', 'Upgrade SSD', 'D203', '32 GB', '1TB HDD', 'Windows 11', 'Intel Core i7', '14\"', 'Baik'),
(24, 'Lenovo', 'ThinkPad', 'SN54321', '2021-07-30', '[\"2022_Acer_Commercial_Option_02_3840x2400.jpg\"]', 'Upgrade Ram', 'D203', '16 GB', '256GB SSD', 'Linux', 'AMD Ryzen 5', '13.3\"', 'Cukup Baik'),
(25, 'Acer', 'Aspire 5', 'SN09876', '2022-11-10', 'image4.jpg', 'Original', 'D208', '4GB', '128GB SSD', 'Windows 10', 'Intel Core i3', '15.6\"', 'Baik'),
(26, 'Apple', 'MacBook Air', 'SN11223', '2020-12-05', 'image5.jpg', 'Original', 'D208', '8GB', '512GB SSD', 'macOS', 'Apple M1', '13.3\"', 'Baik'),
(27, 'dfgwefsd', 'ffwefwevew', '5354', '2024-07-19', '[\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\"]', 'Tambah Memori', 'D203', '32 GB', '2 TB SSD', 'Windows 10', 'mnio', '098', 'Baik'),
(28, 'ledd', '4k35k3k', '5344342', '2024-07-24', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\"]', 'Tambah Memori', 'D203', '32 GB', '2 TB SSD', 'Windows 10', 'mnio', '098', 'Baik'),
(29, 'Dell', 'Inspiron 15', 'SN123456789', '2020-01-15', 'image1.jpg', 'Ganti model', 'Komputasi', '8GB', '256GB SSD', 'Windows 10', 'Intel Core i5', '15.6\" FHD', 'Baik'),
(30, 'HP', 'Pavilion x360', 'SN987654321', '2019-05-20', 'image2.jpg', 'Original', 'Komputasi', '16GB', '512GB SSD', 'Windows 10', 'Intel Core i7', '14\" FHD', 'Baik'),
(31, 'Lenovo', 'ThinkPad X1 Carbon', 'SN456789123', '2021-03-10', 'image3.jpg', 'Original', 'Komputasi', '16GB', '1TB SSD', 'Windows 11', 'Intel Core i7', '14\" FHD', 'Cukup Baik'),
(32, 'Apple', 'MacBook Pro', 'SN321654987', '2022-07-05', 'image4.jpg', 'Original', 'Komputasi', '8GB', '512GB SSD', 'macOS', 'Apple M1', '13.3\" Retina', 'Baik'),
(33, 'Asus', 'ZenBook 13', 'SN654987321', '2018-11-25', 'image5.jpg', 'Original', 'Komputasi', '8GB', '256GB SSD', 'Windows 10', 'Intel Core i5', '13.3\" FHD', 'Baik'),
(34, 'flflf', 'wwpwp', '44242', '2024-07-24', '[\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', 'Komputasi', '16 GB', '1 TB SSD', 'Windows 10', 'mnio', '098', 'Baik');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_history`
--

CREATE TABLE `laptop_history` (
  `id` int NOT NULL,
  `laptop_id` int NOT NULL,
  `brand` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `model` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `serial_number` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `images` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `keterangan` varchar(255) NOT NULL DEFAULT 'Original',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ram` varchar(50) NOT NULL,
  `memori` varchar(50) NOT NULL,
  `os` varchar(50) NOT NULL,
  `processor` varchar(100) NOT NULL,
  `layar` varchar(100) NOT NULL,
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laptop_history`
--

INSERT INTO `laptop_history` (`id`, `laptop_id`, `brand`, `model`, `serial_number`, `purchase_date`, `images`, `keterangan`, `updated_at`, `ram`, `memori`, `os`, `processor`, `layar`, `kondisi`) VALUES
(1, 3, 'tgerwtyer', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '', 'Original', '2024-06-11 07:39:06', '', '', '', '', '', ''),
(2, 4, 'lenovo', '8088064643', '80808', '2024-06-11', '', 'Original', '2024-06-11 08:15:51', '', '', '', '', '', ''),
(3, 4, 'lenovo', '8088064', '808', '2024-06-11', '', 'Original', '2024-06-12 01:35:05', '', '', '', '', '', ''),
(4, 4, 'lenovo', '8088064', '8', '2024-06-11', '', 'Original', '2024-06-12 01:35:17', '', '', '', '', '', ''),
(5, 4, 'lenovo', '8088064', '86464', '2024-06-11', '', 'Original', '2024-06-12 01:38:52', '', '', '', '', '', ''),
(6, 3, 'asus', 'oknfsdfnk', 'pZzocnSA', '2024-06-11', '', 'Original', '2024-06-12 02:03:47', '', '', '', '', '', ''),
(7, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:04:44', '', '', '', '', '', ''),
(8, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:05:20', '', '', '', '', '', ''),
(9, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:36:31', '', '', '', '', '', ''),
(10, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:36:40', '', '', '', '', '', ''),
(11, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:38:12', '', '', '', '', '', ''),
(12, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:38:21', '', '', '', '', '', ''),
(13, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:40:04', '', '', '', '', '', ''),
(14, 3, 'asus', 'ROG', '63653534', '2024-06-11', '', 'Original', '2024-06-12 02:40:14', '', '', '', '', '', ''),
(15, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', '2024-06-12 02:48:14', '', '', '', '', '', ''),
(16, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\"]', 'Original', '2024-06-12 02:55:22', '', '', '', '', '', ''),
(17, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\"]', 'Original', '2024-06-12 02:57:21', '', '', '', '', '', ''),
(18, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 02:57:30', '', '', '', '', '', ''),
(19, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 02:58:03', '', '', '', '', '', ''),
(20, 4, 'lenovo', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 02:58:11', '', '', '', '', '', ''),
(21, 4, 'leno', '12333', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 02:58:22', '', '', '', '', '', ''),
(22, 6, 'samsung', 'T1', '80', '2024-06-12', 'Screenshot (7).png', 'Original', '2024-06-12 03:09:50', '', '', '', '', '', ''),
(23, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\"]', 'Original', '2024-06-12 03:10:21', '', '', '', '', '', ''),
(24, 7, 'leno', 'zenn', '5535233', '2024-06-12', 'Screenshot (10).png', 'Original', '2024-06-12 03:21:37', '', '', '', '', '', ''),
(25, 7, 'leno', 'zenn', '64643', '2024-06-12', '[\"Screenshot (8).png\"]', 'Ganti Serial Number', '2024-06-12 03:22:07', '', '', '', '', '', ''),
(26, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\"]', 'Ganti Model ', '2024-06-12 03:26:39', '', '', '', '', '', ''),
(27, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\"]', 'Ganti Model ', '2024-06-12 03:35:47', '', '', '', '', '', ''),
(28, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\"]', 'Ganti Model ', '2024-06-12 03:36:46', '', '', '', '', '', ''),
(29, 7, 'leno', 'weddd', '64643', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Model ', '2024-06-12 03:37:09', '', '', '', '', '', ''),
(30, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:37:17', '', '', '', '', '', ''),
(31, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:39:41', '', '', '', '', '', ''),
(32, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:47:09', '', '', '', '', '', ''),
(33, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:48:52', '', '', '', '', '', ''),
(34, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:49:21', '', '', '', '', '', ''),
(35, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\"]', 'Ganti Serial Number', '2024-06-12 03:49:33', '', '', '', '', '', ''),
(36, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\"]', 'Ganti Serial Number', '2024-06-12 03:52:51', '', '', '', '', '', ''),
(37, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\"]', 'Ganti Serial Number', '2024-06-12 03:53:00', '', '', '', '', '', ''),
(38, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Ganti Serial Number', '2024-06-12 03:53:08', '', '', '', '', '', ''),
(39, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\"]', 'Ganti Serial Number', '2024-06-12 04:13:57', '', '', '', '', '', ''),
(40, 7, 'leno', 'weddd', '646', '2024-06-12', '[\"Screenshot (8).png\",\"Screenshot (7).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (9).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (11).png\"]', 'Ganti Serial Number', '2024-06-12 04:14:04', '', '', '', '', '', ''),
(41, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:14:57', '', '', '', '', '', ''),
(42, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:15:03', '', '', '', '', '', ''),
(43, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:15:13', '', '', '', '', '', ''),
(44, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\"]', 'Original', '2024-06-12 04:15:30', '', '', '', '', '', ''),
(45, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\"]', 'Original', '2024-06-12 04:15:40', '', '', '', '', '', ''),
(46, 6, 'samsung', 'T1', '80', '2024-06-12', '[\"Screenshot (12).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (11).png\",\"Screenshot (12).png\",\"Screenshot (13).png\",\"Screenshot (11).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (11).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:15:50', '', '', '', '', '', ''),
(47, 4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\"]', 'Original', '2024-06-12 04:16:19', '', '', '', '', '', ''),
(48, 4, 'leno', '123', '86464', '2024-06-11', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\",\"Screenshot (13).png\",\"Screenshot (10).png\",\"Screenshot (12).png\",\"Screenshot (7).png\",\"Screenshot (8).png\",\"Screenshot (9).png\",\"Screenshot (10).png\"]', 'Original', '2024-06-12 04:16:26', '', '', '', '', '', ''),
(49, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\"]', 'Original', '2024-06-13 07:52:10', '', '', '', '', '', ''),
(50, 1, 'ace', 'zenn', '55352', '2024-06-11', '[\"Universitas Persada Indonesia YAI.png\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg\",\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\",\"2022_Acer_Commercial_Option_02_3840x2400.jpg\",\"Screenshot (10).png\",\"Screenshot (8).png\",\"2022_Acer_Commercial_Option_04_3840x2400.jpg\"]', 'Original', '2024-06-14 03:42:24', '', '', '', '', '', ''),
(51, 13, 'toshiba', 'think', '0009', '2024-06-14', '2022_Acer_Commercial_Option_03_3840x2400.jpg', 'Original', '2024-06-14 03:45:26', '', '', '', '', '', ''),
(52, 13, 'toshiba', 'think', '00', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Original', '2024-06-14 03:45:38', '', '', '', '', '', ''),
(53, 15, 'gsgs', 'gfgsd', '634634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Original', '2024-06-20 05:26:48', '', '', '', '', '', ''),
(54, 15, 'gsgs', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Serial Number', '2024-06-20 05:27:18', '', '', '', '', '', ''),
(55, 15, 'gs', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Brand', '2024-06-20 05:27:39', '', '', '', '', '', ''),
(56, 15, 'g', 'gfgsd', '634', '2024-06-14', '2022_Acer_Commercial_Option_01_3840x2400.jpg', 'Ganti Model', '2024-06-20 05:28:49', '', '', '', '', '', ''),
(57, 15, 'g', 'gfgsd', '634', '2024-06-14', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\",\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Ganti Model', '2024-06-20 05:29:03', '', '', '', '', '', ''),
(58, 18, 'dellll', 'ffr', '00999', '2024-07-08', 'MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg', 'Original', '2024-07-08 07:19:49', '', '', '', '', '', ''),
(59, 18, 'dellll', 'ffr', '00999', '2024-07-08', 'MDlFRDU0MDEtRDM3OC00RjEwLUJGRDMtMTNGNTg3MDc0RTUz.jpg', 'Ganti model', '2024-07-08 07:20:02', '', '', '', '', '', ''),
(60, 18, 'dellll', 'ffr', '00999', '2024-07-08', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\"]', 'Ganti model', '2024-07-08 07:20:14', '', '', '', '', '', ''),
(61, 21, 'tech', 'm', '099', '2024-07-10', '2022_Acer_Commercial_Option_04_3840x2400.jpg', 'Original', '2024-07-10 03:23:12', '', '', '', '', '', ''),
(62, 23, 'HP', 'Pavilion', 'SN67890', '2022-03-22', 'image2.jpg', 'Original', '2024-07-19 03:54:53', '16GB', '1TB HDD', 'Windows 11', 'Intel Core i7', '14\"', 'Baik'),
(63, 27, 'dfgwefsd', 'ffwefwevew', '5354', '2024-07-19', '[\"2022_Acer_Commercial_Option_01_3840x2400.jpg\"]', 'Original', '2024-07-19 05:18:34', '32 GB', '1 TB SSD', 'Windows 10', 'mnio', '098', 'Baik'),
(64, 24, 'Lenovo', 'ThinkPad', 'SN54321', '2021-07-30', 'image3.jpg', 'Original', '2024-07-24 02:37:47', '8GB', '256GB SSD', 'Linux', 'AMD Ryzen 5', '13.3\"', 'Cukup Baik'),
(65, 28, 'ledd', '4k35k3k', '5344342', '2024-07-24', '[\"2022_Acer_Commercial_Default_3840x2400.jpg\"]', 'Original', '2024-07-24 02:42:58', '32 GB', '1 TB SSD', 'Windows 10', 'mnio', '098', 'Baik'),
(66, 29, 'Dell', 'Inspiron 15', 'SN123456789', '2020-01-15', 'image1.jpg', 'Original', '2024-07-24 03:06:12', '8GB', '256GB SSD', 'Windows 10', 'Intel Core i5', '15.6\" FHD', 'Baik');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `prodi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nim`, `password`, `name`, `prodi`, `alamat`, `telp`) VALUES
(5, '2009106114', '$2y$10$v52N1ATpE1JxX4SCVvyhzOC4TuInjIul4TJ3UTUqkvtPyGjQcT1OK', 'Arya Nanda', 'Informatika', 'jalan teluk bayur', '082350680650'),
(7, '20091061144', '$2y$10$8TW5gQp1nJ2528bxInD6Uuo2ejNB5bVyTPq8TnBMj/cFQgB8HJs/K', 'Arya Nanda', 'Informatika', 'Jalan teluk bayur depan gg. 10 samping sdn 010 no.43 kel. Mangkupalas kec.Samarinda seberang', '082350680650');

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
-- Indexes for table `laboran_kalab`
--
ALTER TABLE `laboran_kalab`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `lab_bookings`
--
ALTER TABLE `lab_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_booking_days`
--
ALTER TABLE `lab_booking_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_booking_id` (`lab_booking_id`);

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
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `furniture_history`
--
ALTER TABLE `furniture_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laboran_kalab`
--
ALTER TABLE `laboran_kalab`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lab_bookings`
--
ALTER TABLE `lab_bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lab_booking_days`
--
ALTER TABLE `lab_booking_days`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `laptop_history`
--
ALTER TABLE `laptop_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `furniture_history`
--
ALTER TABLE `furniture_history`
  ADD CONSTRAINT `furniture_history_ibfk_1` FOREIGN KEY (`furniture_id`) REFERENCES `furniture` (`id`);

--
-- Constraints for table `lab_booking_days`
--
ALTER TABLE `lab_booking_days`
  ADD CONSTRAINT `lab_booking_days_ibfk_1` FOREIGN KEY (`lab_booking_id`) REFERENCES `lab_bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
