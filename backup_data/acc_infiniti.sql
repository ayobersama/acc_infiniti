-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2025 at 03:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acc_infiniti`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(60) DEFAULT NULL,
  `induk` int(11) DEFAULT NULL,
  `jenis` varchar(1) DEFAULT NULL,
  `kb` varchar(1) DEFAULT NULL,
  `header` varchar(1) DEFAULT NULL,
  `aktif` varchar(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `kode`, `nama`, `induk`, `jenis`, `kb`, `header`, `aktif`, `created_at`, `updated_at`) VALUES
(1, '100', 'Aktiva Lancar', NULL, 'A', NULL, 'Y', 'Y', NULL, NULL),
(2, '101', 'Kas', 1, 'A', NULL, 'Y', 'Y', NULL, '2024-11-20 05:18:27'),
(3, '101.01', 'Kas besar', 2, 'A', 'K', 'N', 'Y', NULL, '2024-11-20 05:18:03'),
(4, '101.02', 'Kas Kecil', 2, 'A', 'K', 'N', 'Y', NULL, '2024-11-20 05:18:17'),
(5, '102', 'Bank', 1, 'A', NULL, 'Y', 'Y', NULL, NULL),
(6, '102.01', 'Bank BCA', 5, 'A', 'B', 'N', 'Y', NULL, '2024-11-20 05:18:45'),
(7, '102.02', 'Bank Mandiri', 5, 'A', NULL, 'N', 'Y', NULL, NULL),
(8, '102.03', 'Bank BNI', 5, 'A', NULL, 'N', 'Y', NULL, NULL),
(9, '103', 'Piutang', 1, 'A', '', 'Y', 'Y', NULL, NULL),
(10, '103.01', 'Piutang Usaha', 9, 'A', NULL, 'N', 'Y', NULL, NULL),
(11, '104.01', 'Piutang Karyawan', 9, 'A', NULL, 'N', 'Y', NULL, NULL),
(12, '104.03', 'Piutang Lain Lain', 9, 'A', NULL, 'N', 'Y', NULL, NULL),
(13, '5.1.01', 'Biaya Listrik', 9, 'B', NULL, 'N', 'Y', '2025-03-27 13:21:50', '2025-03-27 13:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `foto` varchar(30) DEFAULT NULL,
  `aktif` varchar(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `nama`, `password`, `remember_token`, `foto`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '$2y$10$zLrPupqSlSll3L4MnaTiVeGmshurxFjTVLUMPl/HIs/ThtCIjJQ12', NULL, NULL, 'Y', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_akses`
--

CREATE TABLE `admin_akses` (
  `userid` int(11) DEFAULT NULL,
  `menu` varchar(20) DEFAULT NULL,
  `baca` varchar(1) DEFAULT NULL,
  `tambah` varchar(1) DEFAULT NULL,
  `edit` varchar(1) DEFAULT NULL,
  `hapus` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_akses`
--

INSERT INTO `admin_akses` (`userid`, `menu`, `baca`, `tambah`, `edit`, `hapus`) VALUES
(1, 'SUPER', 'Y', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `bankk`
--

CREATE TABLE `bankk` (
  `bukti` varchar(10) NOT NULL,
  `tgl` date DEFAULT NULL,
  `bank` int(11) DEFAULT NULL,
  `relasi` int(11) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bankk`
--

INSERT INTO `bankk` (`bukti`, `tgl`, `bank`, `relasi`, `nilai`, `status`, `ket`, `created_at`, `updated_at`) VALUES
('BK25000001', '2025-03-28', 6, 1, '20000.00', '0', NULL, '2025-03-28 03:05:39', '2025-04-10 11:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `bankkd`
--

CREATE TABLE `bankkd` (
  `id` int(11) NOT NULL,
  `bukti` varchar(10) DEFAULT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bankkd`
--

INSERT INTO `bankkd` (`id`, `bukti`, `cha`, `dk`, `uraian`, `nilai`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'D', NULL, '0.00', '2025-03-28 03:05:39', '2025-03-28 03:05:39'),
(2, 'BK25000001', 4, 'D', 'sdsadasd sadsadas', '20000.00', '2025-04-10 11:29:36', '2025-04-10 11:29:36');

-- --------------------------------------------------------

--
-- Table structure for table `bankm`
--

CREATE TABLE `bankm` (
  `bukti` varchar(10) NOT NULL,
  `tgl` date DEFAULT NULL,
  `bank` int(11) DEFAULT NULL,
  `relasi` int(11) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bankm`
--

INSERT INTO `bankm` (`bukti`, `tgl`, `bank`, `relasi`, `nilai`, `status`, `ket`, `created_at`, `updated_at`) VALUES
('BM25000001', '2025-04-10', 6, 1, '20000.00', '0', 'dhfksdfhsd', '2025-04-10 11:28:19', '2025-04-10 11:31:17'),
('BM25000002', '2025-04-10', 6, 2, '50000.00', '0', 'asdsd asdsadsadasds', '2025-04-10 11:32:12', '2025-04-10 11:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `bankmd`
--

CREATE TABLE `bankmd` (
  `id` int(11) NOT NULL,
  `bukti` varchar(10) DEFAULT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bankmd`
--

INSERT INTO `bankmd` (`id`, `bukti`, `cha`, `dk`, `uraian`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 'BM25000001', 3, 'K', 'sad asdsadsad', '20000.00', '2025-04-10 11:31:17', '2025-04-10 11:31:17'),
(2, 'BM25000002', 4, 'K', 'jsadsad adsadasdasd ewerere', '50000.00', '2025-04-10 11:32:12', '2025-04-10 11:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `jurum`
--

CREATE TABLE `jurum` (
  `bukti` varchar(10) NOT NULL,
  `tgl` date DEFAULT NULL,
  `tdebet` decimal(18,2) DEFAULT NULL,
  `tkredit` decimal(18,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurum`
--

INSERT INTO `jurum` (`bukti`, `tgl`, `tdebet`, `tkredit`, `status`, `ket`, `created_at`, `updated_at`) VALUES
('JU25000008', '2025-04-07', NULL, NULL, '0', 'xcxzcx xzcxcxzc', '2025-04-07 12:45:31', '2025-04-07 12:45:31'),
('JU25000009', '2025-04-07', '200000.00', '10000.00', '0', 'wewqe qwewqeqew', '2025-04-07 12:57:38', '2025-04-07 14:32:11');

-- --------------------------------------------------------

--
-- Table structure for table `jurumd`
--

CREATE TABLE `jurumd` (
  `id` int(11) NOT NULL,
  `bukti` varchar(10) DEFAULT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurumd`
--

INSERT INTO `jurumd` (`id`, `bukti`, `cha`, `dk`, `uraian`, `nilai`, `created_at`, `updated_at`) VALUES
(8, 'JU25000008', 6, 'K', 'dfsdfdfsdfsd', '10000.00', '2025-04-07 12:45:31', '2025-04-07 12:45:31'),
(9, 'JU25000009', 7, 'K', 'ewerewr werewrewr werewrwer', '10000.00', '2025-04-07 12:57:38', '2025-04-07 14:32:11'),
(10, 'JU25000009', 11, 'D', 'sdasdsad sdasdasdas saddasd', '200000.00', '2025-04-07 14:10:58', '2025-04-07 14:10:58');

-- --------------------------------------------------------

--
-- Table structure for table `kask`
--

CREATE TABLE `kask` (
  `bukti` varchar(10) NOT NULL,
  `tgl` date DEFAULT NULL,
  `kas` int(11) DEFAULT NULL,
  `relasi` int(11) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kask`
--

INSERT INTO `kask` (`bukti`, `tgl`, `kas`, `relasi`, `nilai`, `status`, `ket`, `created_at`, `updated_at`) VALUES
('KK25000002', '2025-03-27', 4, 2, '350000.00', '0', 'Pembayaran Listrik Feb 2025', '2025-03-27 11:14:27', '2025-03-27 13:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `kaskd`
--

CREATE TABLE `kaskd` (
  `id` int(11) NOT NULL,
  `bukti` varchar(10) DEFAULT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kaskd`
--

INSERT INTO `kaskd` (`id`, `bukti`, `cha`, `dk`, `uraian`, `nilai`, `created_at`, `updated_at`) VALUES
(3, 'KK25000002', 13, 'D', 'Biaya Listrik Feb 2025', '350000.00', '2025-03-27 13:30:34', '2025-03-27 13:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `kasm`
--

CREATE TABLE `kasm` (
  `bukti` varchar(10) NOT NULL,
  `tgl` date DEFAULT NULL,
  `kas` int(11) DEFAULT NULL,
  `relasi` int(11) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `ket` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kasm`
--

INSERT INTO `kasm` (`bukti`, `tgl`, `kas`, `relasi`, `nilai`, `status`, `ket`, `created_at`, `updated_at`) VALUES
('KM25000002', '2025-03-27', 3, 1, '400000.00', '0', 'sadgasdjags dsaas', '2025-03-27 11:11:18', '2025-05-03 01:06:40'),
('KM25000005', '2025-03-28', 3, 1, '50000.00', '0', 'ewrwerwer', '2025-03-28 02:45:25', '2025-05-03 01:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `kasmd`
--

CREATE TABLE `kasmd` (
  `id` int(11) NOT NULL,
  `bukti` varchar(10) DEFAULT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `nilai` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kasmd`
--

INSERT INTO `kasmd` (`id`, `bukti`, `cha`, `dk`, `uraian`, `nilai`, `created_at`, `updated_at`) VALUES
(3, 'KM25000002', 13, 'K', 'Biaya Listrik', '400000.00', '2025-05-03 01:06:40', '2025-05-03 01:06:40'),
(4, 'KM25000005', 13, 'K', 'Biaya Listrik', '50000.00', '2025-05-03 01:07:42', '2025-05-03 01:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `no_urut`
--

CREATE TABLE `no_urut` (
  `id` int(11) NOT NULL,
  `tipe` varchar(2) DEFAULT NULL,
  `kode` varchar(2) DEFAULT NULL,
  `no_akhir` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `no_urut`
--

INSERT INTO `no_urut` (`id`, `tipe`, `kode`, `no_akhir`, `created_at`, `updated_at`) VALUES
(1, 'KM', 'KM', 7, NULL, '2025-03-26 12:50:02'),
(2, 'KK', 'KK', 2, NULL, '2025-03-26 12:50:14'),
(3, 'BM', 'BM', 2, NULL, '2025-03-26 12:50:26'),
(4, 'BK', 'BK', 1, NULL, NULL),
(5, 'JU', 'JU', 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `psys`
--

CREATE TABLE `psys` (
  `nama` varchar(60) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `telp` varchar(30) DEFAULT NULL,
  `thn` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `psys`
--

INSERT INTO `psys` (`nama`, `alamat`, `telp`, `thn`) VALUES
('Infiniti', NULL, NULL, 2025);

-- --------------------------------------------------------

--
-- Table structure for table `relasi`
--

CREATE TABLE `relasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `aktif` varchar(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `relasi`
--

INSERT INTO `relasi` (`id`, `nama`, `alamat`, `ket`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'UD Sejati', 'Jl. Pasar Kembang 89', 'toko peralatan plastik', 'Y', '2024-11-19 12:52:47', '2024-11-19 12:53:59'),
(2, 'PLN', 'PLN Cabang Rungkut', NULL, 'Y', '2025-03-27 13:18:18', '2025-03-27 13:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `saldo_awal`
--

CREATE TABLE `saldo_awal` (
  `id` int(11) NOT NULL,
  `cha` int(11) DEFAULT NULL,
  `dk` varchar(1) DEFAULT NULL,
  `nilai` decimal(16,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saldo_awal`
--

INSERT INTO `saldo_awal` (`id`, `cha`, `dk`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 3, 'D', '100000.00', NULL, '2025-05-02 05:38:49'),
(2, 8, 'K', '200000.00', NULL, '2025-05-02 05:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_temp` varchar(255) DEFAULT NULL,
  `foto` varchar(30) DEFAULT NULL,
  `aktif` varchar(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `password`, `password_temp`, `foto`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '$2y$10$zLrPupqSlSll3L4MnaTiVeGmshurxFjTVLUMPl/HIs/ThtCIjJQ12', '', NULL, 'Y', '2023-04-03 04:04:02', NULL),
(2, 'agus', 'Agustinus', '$2y$10$RZiA6WYbnw/Wq9Srqo3l0.Jsqji8t2doZ37WH0Ft8lj52boqZtNtq', NULL, '1682478956.png', 'Y', '2023-04-03 04:06:24', '2023-04-26 03:23:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankk`
--
ALTER TABLE `bankk`
  ADD PRIMARY KEY (`bukti`);

--
-- Indexes for table `bankkd`
--
ALTER TABLE `bankkd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankm`
--
ALTER TABLE `bankm`
  ADD PRIMARY KEY (`bukti`);

--
-- Indexes for table `bankmd`
--
ALTER TABLE `bankmd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurum`
--
ALTER TABLE `jurum`
  ADD PRIMARY KEY (`bukti`);

--
-- Indexes for table `jurumd`
--
ALTER TABLE `jurumd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kask`
--
ALTER TABLE `kask`
  ADD PRIMARY KEY (`bukti`);

--
-- Indexes for table `kaskd`
--
ALTER TABLE `kaskd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasm`
--
ALTER TABLE `kasm`
  ADD PRIMARY KEY (`bukti`);

--
-- Indexes for table `kasmd`
--
ALTER TABLE `kasmd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `no_urut`
--
ALTER TABLE `no_urut`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psys`
--
ALTER TABLE `psys`
  ADD PRIMARY KEY (`nama`);

--
-- Indexes for table `relasi`
--
ALTER TABLE `relasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankkd`
--
ALTER TABLE `bankkd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bankmd`
--
ALTER TABLE `bankmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurumd`
--
ALTER TABLE `jurumd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kaskd`
--
ALTER TABLE `kaskd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kasmd`
--
ALTER TABLE `kasmd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `relasi`
--
ALTER TABLE `relasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saldo_awal`
--
ALTER TABLE `saldo_awal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
