-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2023 at 03:02 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uptlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `anggaran` double NOT NULL,
  `laboratorium` int(11) NOT NULL,
  `periode` year(4) NOT NULL,
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `anggaran`, `laboratorium`, `periode`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2000000000, 1, 2022, 'pagu1', '2022-12-28 07:07:24', '2022-12-28 07:08:22'),
(2, 2400000, 1, 2022, 'pagu 2', '2022-12-28 07:08:49', '2022-12-28 07:08:49'),
(3, 1000000000, 1, 2022, 'pagu3', '2022-12-28 07:29:29', '2022-12-28 07:29:29'),
(4, 300000, 1, 2023, 'pagu1', '2023-01-03 06:56:14', '2023-01-03 06:56:14'),
(5, 9000000, 1, 2023, 'pagu 2', '2023-01-03 06:56:28', '2023-01-03 06:56:28'),
(6, 1000000, 1, 2023, 'PAGU 4', '2023-01-09 08:34:38', '2023-01-09 08:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` double NOT NULL,
  `sumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `nama_barang`, `spesifikasi`, `satuan`, `harga_satuan`, `sumber`, `gambar`, `jenis_item`, `created_at`, `updated_at`) VALUES
(1, 'Laudantium delectus', 'Quis esse et earum', '2', 78, 'Iusto aliquam doloru', 'default.jpg', '3', '2022-12-17 21:15:55', '2022-12-17 21:23:26'),
(2, 'Repellendus Qui cup', 'Laborum aspernatur s', '6', 20, 'Et libero ex laborum', 'default.jpg', '2', '2022-12-17 22:00:15', '2022-12-17 22:00:15'),
(3, 'Sit dolores reprehen', 'Facere non omnis in', '1', 51, 'Odit doloremque qui', 'default.jpg', '2', '2022-12-17 22:00:22', '2022-12-17 22:00:22'),
(4, 'Qui fugit explicabo', 'Do in veniam id ali', '3', 24, 'Ullamco adipisicing', 'default.jpg', '4', '2022-12-17 22:00:28', '2022-12-17 22:00:28'),
(5, 'Acrylic Lembaran Transparan 3mm A2 42x60cm', '\'* Model: Acrylic Lembaran\r\n* Bahan: Acrylic Clear (Transparan)\r\n* Tebal : 3mm\r\n* Ukuran : A2 (42 x 60 cm)', '1', 60000, 'https://www.tokopedia.com/tiraihongxin/acrylic-lembaran-bening-3mm-a2-42x60cm', 'default.jpg', '5', '2022-12-18 22:55:31', '2022-12-18 22:55:31'),
(6, 'Kertas HVS Sidu A3 70Gram', 'Officia aut magna ex', '5', 60, 'Ea doloribus non qua', 'default.jpg', '2', '2022-12-18 22:56:01', '2022-12-18 22:56:01'),
(7, 'Plastik Mika A3', 'Tempor nulla iusto e', '5', 86, 'Quisquam fugiat ali', 'default.jpg', '6', '2022-12-18 22:56:14', '2022-12-18 22:56:14'),
(8, 'pembersih lantai', 'Dolore rerum eveniet', '3', 7, 'Laborum natus incidi', 'rcSfnPLglpFVERXoaSKPrkiiClCA5PEE5jjGnK0i.png', '3', '2022-12-18 22:56:26', '2022-12-20 06:22:48'),
(9, 'Karpet lantai Vinyl plastik Korea', 'Do dolorem laudantiu', '5', 62, 'Autem deserunt labor', 'default.jpg', '5', '2022-12-18 22:56:36', '2022-12-18 22:56:36'),
(10, 'Hand Soap/ Sabun Cuci Tangan', 'In odio placeat ess', '1', 5, 'Sed voluptatum anim', 'default.jpg', '2', '2022-12-18 22:56:46', '2022-12-18 22:56:46'),
(11, 'Masker', 'Rerum aut Nam quia e', '3', 46, 'Quia nostrum sed vol', 'default.jpg', '2', '2022-12-18 22:57:01', '2022-12-18 22:57:01'),
(12, 'Nitric Acid (HNO3)', 'Ullamco in ea magna', '1', 86, 'Quas laboriosam fug', 'default.jpg', '2', '2022-12-18 22:57:12', '2022-12-18 22:57:12'),
(13, 'Polyacrylonitriel (PAN)', 'Quas rerum sunt prae', '1', 54, 'Laudantium veritati', 'default.jpg', '2', '2022-12-18 22:57:34', '2022-12-18 22:57:34'),
(14, 'Copper II Nitrate Trihydrate', 'Quo qui autem quod m', '2', 58, 'Et aut alias sit re', 'default.jpg', '2', '2022-12-18 22:57:49', '2022-12-18 23:00:35'),
(15, 'Inventore et facilis', 'Irure quaerat et ist', '2', 84, 'Optio architecto ma', 'ue9iOewTptqiqKClsWYupfuBrr4TunGqZZ5cMWSz.jpg', '5', '2022-12-20 05:35:22', '2022-12-20 05:35:22'),
(16, 'Laptop', '-', '1', 123, 'toko', 'Vq1bltU5iY4l6fN3Y9IdCY7oeYsXChS7P1sHjR85.png', '3', '2022-12-20 07:50:03', '2022-12-20 07:50:03'),
(17, 'Barang 1', '-', '1', 2000, 'toko 1', 'avW7z9fp7QdFoxn2u3WjrCBHHBlm6emsUz3t2Eih.jpg', '2', '2022-12-21 01:31:40', '2022-12-21 01:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_item`
--

CREATE TABLE `jenis_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_item`
--

INSERT INTO `jenis_item` (`id`, `jenis`, `created_at`, `updated_at`) VALUES
(2, 'Bahan Kimia', '2022-12-17 20:51:14', '2022-12-17 20:51:14'),
(3, 'Bahan Elektrikal', '2022-12-17 20:51:20', '2022-12-18 22:51:31'),
(4, 'Bahan ATK', '2022-12-17 20:51:24', '2022-12-17 20:51:24'),
(5, 'Bahan Bangunan', '2022-12-17 20:51:28', '2022-12-17 20:51:28'),
(6, 'Bahan Rumah Tangga', '2022-12-18 22:51:04', '2022-12-18 22:51:04'),
(7, 'ATK dan Studio', '2022-12-18 22:51:15', '2022-12-18 22:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_rab`
--

CREATE TABLE `jenis_rab` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_rab`
--

INSERT INTO `jenis_rab` (`id`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'Barang Habis Pakai', '2022-12-17 20:55:16', '2022-12-17 20:55:16'),
(3, 'Barang Modal', '2022-12-18 01:39:53', '2022-12-18 01:39:53'),
(4, 'Barang 1', '2022-12-18 01:40:09', '2022-12-18 01:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `laboratorium`
--

CREATE TABLE `laboratorium` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratorium` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratorium`
--

INSERT INTO `laboratorium` (`id`, `laboratorium`, `created_at`, `updated_at`) VALUES
(1, 'Teknik Kimia', '2022-12-17 21:00:46', '2022-12-17 21:00:46'),
(2, 'Teknik Informatika', '2022-12-17 21:00:55', '2022-12-17 21:00:55'),
(3, 'Teknik Mesin', '2022-12-17 21:00:59', '2022-12-17 21:00:59'),
(5, 'TPB Kimia', '2022-12-18 22:52:12', '2022-12-18 22:52:12'),
(6, 'Farmasi', '2022-12-18 22:52:39', '2022-12-18 22:52:39'),
(7, 'Teknologi Pangan', '2022-12-18 22:53:02', '2022-12-18 22:53:02'),
(8, 'T. Geofisika', '2022-12-18 22:53:14', '2022-12-18 22:53:14'),
(9, 'TPB Multimedia', '2022-12-18 22:53:39', '2022-12-18 22:53:39'),
(10, 'Teknik Elektro', '2022-12-18 22:53:53', '2022-12-18 22:53:53'),
(11, 'Teknik Material', '2022-12-18 22:54:07', '2022-12-18 22:54:07'),
(12, 'TPB Fisika', '2022-12-18 22:54:26', '2022-12-18 22:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_08_23_020457_create_items_table', 1),
(6, '2022_08_23_020516_create_rabs_table', 1),
(7, '2022_08_23_020529_create_pakets_table', 1),
(8, '2022_12_11_192954_create_laboratorium_table', 1),
(9, '2022_12_11_193034_create_satuan_table', 1),
(10, '2022_12_12_145608_create_rabdetails_table', 1),
(11, '2022_12_13_174905_create_jenisrab_table', 1),
(12, '2022_12_18_033010_create_paket_rab_details_table', 1),
(13, '2022_12_18_033340_create_jenis_item_table', 1),
(14, '2022_12_25_014724_create_anggaran_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pakets`
--

CREATE TABLE `pakets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pengadaan` int(11) NOT NULL,
  `waktu_pelaksanaan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pakets`
--

INSERT INTO `pakets` (`id`, `title`, `nomor_akun`, `jenis_pengadaan`, `waktu_pelaksanaan`, `created_at`, `updated_at`) VALUES
(1, 'PENGADAAN 001', '2001', 1, '2023-01-03', '2023-01-03 06:27:00', '2023-01-03 07:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `paket_rab_details`
--

CREATE TABLE `paket_rab_details` (
  `id_paket` bigint(20) UNSIGNED NOT NULL,
  `id_rab` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paket_rab_details`
--

INSERT INTO `paket_rab_details` (`id_paket`, `id_rab`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rabdetails`
--

CREATE TABLE `rabdetails` (
  `rab_id_ref` bigint(20) UNSIGNED NOT NULL,
  `id_item` bigint(20) UNSIGNED NOT NULL,
  `jumlah_harga` double NOT NULL,
  `qty` int(11) NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rabdetails`
--

INSERT INTO `rabdetails` (`rab_id_ref`, `id_item`, `jumlah_harga`, `qty`, `satuan`, `created_at`, `updated_at`) VALUES
(1, 3, 51000, 1000, 'pcs', NULL, NULL),
(2, 3, 510, 10, 'pcs', NULL, NULL),
(2, 12, 86, 1, 'pcs', NULL, NULL),
(2, 13, 54, 1, 'pcs', NULL, NULL),
(2, 15, 84, 1, 'Kg', NULL, NULL),
(2, 5, 60000, 1, 'pcs', NULL, NULL),
(2, 7, 86, 1, 'gr', NULL, NULL),
(2, 11, 46, 1, 'liter', NULL, NULL),
(2, 9, 62, 1, 'gr', NULL, NULL),
(5, 1, 78, 1, 'Kg', NULL, NULL),
(6, 16, 12300, 100, 'pcs', NULL, NULL),
(6, 8, 14000, 2000, 'liter', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rabs`
--

CREATE TABLE `rabs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_rab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laboratorium` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected','update') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `waktu_pelaksanaan` date NOT NULL,
  `jumlah` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rabs`
--

INSERT INTO `rabs` (`id`, `title`, `jenis_rab`, `nomor_akun`, `laboratorium`, `status`, `waktu_pelaksanaan`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 'Velit est itaque rer', '1', '77', 1, 'accepted', '2022-12-28', 62271, '2022-12-28 07:26:02', '2022-12-28 09:29:42'),
(2, 'Sed qui modi est aut', '1', '64', 1, 'pending', '2023-01-03', 74393, '2023-01-03 06:56:49', '2023-01-03 07:13:54'),
(5, '', '', '', 1, 'pending', '2023-01-09', 95, '2023-01-09 08:52:33', '2023-01-09 08:52:33'),
(6, 'Test123', '1', '223', 1, 'pending', '2023-01-09', 32112, '2023-01-09 09:08:00', '2023-01-09 09:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id`, `satuan`, `created_at`, `updated_at`) VALUES
(1, 'pcs', '2022-12-17 20:40:10', '2022-12-17 20:40:10'),
(2, 'Kg', '2022-12-17 20:40:14', '2022-12-17 20:40:14'),
(3, 'liter', '2022-12-17 20:40:20', '2022-12-17 20:40:20'),
(5, 'gr', '2022-12-17 20:40:43', '2022-12-17 20:40:43'),
(6, 'box', '2022-12-17 20:40:48', '2022-12-17 20:40:48'),
(7, 'test', '2023-01-09 08:35:22', '2023-01-09 08:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `laboratorium` int(11) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `laboratorium`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin@gmail.com', 'super admin', NULL, NULL, '$2y$10$6CWFILPwDNr3a7mjsJ7h3uSD/rI.OKaQoqRsZaN5d/HALY8TMs5Qa', NULL, NULL, '2023-01-03 07:52:47'),
(5, 'fisika', 'fisika@gmail.com', 'admin', 12, NULL, '$2y$10$ZNMl.VZuvow7KycqQgARL.DvIU61ua91qWqbbWOVZyzqjIimmIo8i', NULL, '2022-12-19 08:41:53', '2022-12-19 08:41:53'),
(6, 'kimia', 'afifhibatullah59@gmail.com', 'admin', 1, NULL, '$2y$10$prKMxNv6lyNRQY/Hz.PqO.JKPGCw7EmZH7JCkUtLBgr4xQcskaB.C', NULL, '2022-12-20 07:55:03', '2022-12-20 07:55:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_item`
--
ALTER TABLE `jenis_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_rab`
--
ALTER TABLE `jenis_rab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratorium`
--
ALTER TABLE `laboratorium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pakets`
--
ALTER TABLE `pakets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket_rab_details`
--
ALTER TABLE `paket_rab_details`
  ADD KEY `paket_rab_details_id_paket_foreign` (`id_paket`),
  ADD KEY `paket_rab_details_id_rab_foreign` (`id_rab`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rabdetails`
--
ALTER TABLE `rabdetails`
  ADD KEY `rabdetails_rab_id_ref_foreign` (`rab_id_ref`),
  ADD KEY `rabdetails_id_item_foreign` (`id_item`);

--
-- Indexes for table `rabs`
--
ALTER TABLE `rabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jenis_item`
--
ALTER TABLE `jenis_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jenis_rab`
--
ALTER TABLE `jenis_rab`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laboratorium`
--
ALTER TABLE `laboratorium`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pakets`
--
ALTER TABLE `pakets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rabs`
--
ALTER TABLE `rabs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `paket_rab_details`
--
ALTER TABLE `paket_rab_details`
  ADD CONSTRAINT `paket_rab_details_id_paket_foreign` FOREIGN KEY (`id_paket`) REFERENCES `pakets` (`id`),
  ADD CONSTRAINT `paket_rab_details_id_rab_foreign` FOREIGN KEY (`id_rab`) REFERENCES `rabs` (`id`);

--
-- Constraints for table `rabdetails`
--
ALTER TABLE `rabdetails`
  ADD CONSTRAINT `rabdetails_id_item_foreign` FOREIGN KEY (`id_item`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `rabdetails_rab_id_ref_foreign` FOREIGN KEY (`rab_id_ref`) REFERENCES `rabs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
