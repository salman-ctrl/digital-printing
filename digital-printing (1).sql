-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 17, 2026 at 09:55 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digital-printing`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-02-16 05:23:37', '2026-02-16 05:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_specification_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `design_option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upload',
  `design_difficulty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `design_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`, `parent_id`) VALUES
(8, 'Banner & Display', 'banner-display', 'categories/banner.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', NULL),
(9, 'Banner Indoor', 'banner-indoor', 'categories/banner-indoor.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 8),
(10, 'Banner Outdoor', 'banner-outdoor', 'categories/banner-outdoor.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 8),
(11, 'Roll Up Banner', 'roll-up-banner', 'categories/rollup.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 8),
(12, 'Stiker & Label', 'stiker-label', 'categories/stiker.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', NULL),
(13, 'Stiker Vinyl', 'stiker-vinyl', 'categories/stiker-vinyl.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 12),
(14, 'Stiker Chromo', 'stiker-chromo', 'categories/stiker-chromo.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 12),
(15, 'Label Makanan', 'label-makanan', 'categories/label.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 12),
(16, 'Promosi & Kantor', 'promosi-kantor', 'categories/promosi.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', NULL),
(17, 'Brosur', 'brosur', 'categories/brosur.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 16),
(18, 'Kartu Nama', 'kartu-nama', 'categories/kartunama.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 16),
(19, 'Sertifikat', 'sertifikat', 'categories/sertifikat.jpg', '2026-02-06 01:54:51', '2026-02-06 01:54:51', 16);

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE `criterias` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('benefit','cost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Harga', 'cost', '2026-02-03 20:56:20', '2026-02-03 20:56:20'),
(2, 'Kualitas Warna', 'benefit', '2026-02-03 20:56:20', '2026-02-03 20:56:20'),
(3, 'Daya Tahan', 'benefit', '2026-02-03 20:56:20', '2026-02-03 20:56:20'),
(4, 'Tekstur Bahan', 'benefit', '2026-02-03 20:56:20', '2026-02-03 20:56:20'),
(5, 'Ukuran Cetak', 'benefit', '2026-02-03 20:56:20', '2026-02-03 20:56:20');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_weights`
--

CREATE TABLE `criteria_weights` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `criteria_id` bigint UNSIGNED NOT NULL,
  `weight` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_12_16_171203_create_categories_table', 1),
(6, '2025_12_16_171306_create_products_table', 1),
(7, '2025_12_16_171336_create_product_specifications_table', 1),
(8, '2025_12_16_171401_create_criterias_table', 1),
(9, '2025_12_16_171425_create_criteria_weights_table', 1),
(10, '2025_12_16_171440_create_carts_table', 1),
(11, '2025_12_16_171458_create_cart_details_table', 1),
(12, '2025_12_16_171513_create_transactions_table', 1),
(13, '2025_12_16_171530_create_transaction_details_table', 1),
(14, '2025_12_16_171549_create_payments_table', 1),
(15, '2025_12_16_171615_create_topsis_result_table', 1),
(16, '2026_01_30_060156_add_owner_role_to_users_table', 1),
(17, '2026_02_03_034000_add_snap_token_to_transactions_table', 1),
(18, '2026_02_04_035327_add_image_and_parent_id_to_categories_table', 1),
(19, '2026_02_06_084018_add_parent_id_and_image_to_categories_table', 2),
(20, '2026_02_08_162842_create_product_photos_table', 3),
(21, '2026_02_16_120834_add_design_columns_to_cart_and_transaction_details', 3),
(22, '2026_02_16_121544_add_design_file_to_cart_and_transaction_details', 3),
(23, '2026_02_16_135928_add_image_primary_to_products_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_amount` decimal(12,2) NOT NULL,
  `midtrans_order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_json` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_primary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `image_primary`, `created_at`, `updated_at`) VALUES
(4, 10, 'Banner Flexi China 280gr', 'Banner outdoor standar untuk kebutuhan promosi jangka pendek.', 'products/wpOtUWHKVeX4jUzhe26j1dFRzr1eydrkynQs4ZtR.jpg', '2026-02-06 01:57:36', '2026-02-16 21:12:46'),
(5, 10, 'Banner Flexi Korea 440gr', 'Banner outdoor tebal dan kuat untuk promosi jangka panjang.', 'products/APD8BlrPbNUUzHoAgTHBW7LgUJWqMNQyhkAUAXJX.jpg', '2026-02-06 01:57:36', '2026-02-16 21:13:35'),
(6, 9, 'Banner Albatros', 'Media cetak indoor dengan permukaan halus dan hasil warna tajam.', 'products/56yKzZpCXOfhOFNm6R9zM9EnfmuwDJkZxMynFNhp.jpg', '2026-02-06 01:57:36', '2026-02-16 21:14:35'),
(7, 13, 'Stiker Vinyl Ritrama', 'Stiker outdoor berkualitas tinggi, tahan air dan sinar matahari.', 'products/Cmis1KaNYTfZmK4CEk9RjtkIbx5rEG9Ei5omYuVj.jpg', '2026-02-06 01:57:36', '2026-02-16 21:15:36'),
(8, 17, 'Brosur Art Paper 150gr', 'Cetak brosur full color dengan kertas glossy berkualitas.', 'products/ZwMO6YewJ0ZOfjb9UTCLHggHpxJ80hDmL8HNl8xa.jpg', '2026-02-06 01:57:36', '2026-02-16 21:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_specifications`
--

CREATE TABLE `product_specifications` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `material` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `finishing` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `kualitas_warna` int NOT NULL,
  `daya_tahan` int NOT NULL,
  `tekstur_bahan` int NOT NULL,
  `ukuran_cetak` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_specifications`
--

INSERT INTO `product_specifications` (`id`, `product_id`, `material`, `size`, `finishing`, `harga`, `kualitas_warna`, `daya_tahan`, `tekstur_bahan`, `ukuran_cetak`, `created_at`, `updated_at`) VALUES
(5, 4, 'Flexi China', 'Permeter', 'Mata Ayam', 15000, 3, 3, 2, 5, '2026-02-06 01:58:02', '2026-02-06 01:58:02'),
(6, 5, 'Flexi Korea', 'Permeter', 'Mata Ayam / Selongsong', 35000, 4, 5, 4, 5, '2026-02-06 01:58:02', '2026-02-06 01:58:02'),
(7, 6, 'Albatros', 'Permeter', 'Laminasi Glossy/Doff', 45000, 5, 3, 5, 4, '2026-02-06 01:58:02', '2026-02-06 01:58:02'),
(8, 7, 'Vinyl Ritrama', 'Permeter', 'Tanpa Cutting', 65000, 5, 5, 4, 4, '2026-02-06 01:58:02', '2026-02-06 01:58:02'),
(9, 8, 'Art Paper 150gr', 'A4', 'Potong Pas', 1500, 4, 3, 4, 2, '2026-02-06 01:58:02', '2026-02-06 01:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `topsis_results`
--

CREATE TABLE `topsis_results` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_specification_id` bigint UNSIGNED NOT NULL,
  `preference_value` double NOT NULL,
  `rank` int NOT NULL,
  `calculated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topsis_results`
--

INSERT INTO `topsis_results` (`id`, `user_id`, `product_specification_id`, `preference_value`, `rank`, `calculated_at`) VALUES
(3, 4, 7, 0, 1, '2026-02-17 02:52:28');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `status` enum('pending','paid','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `snap_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_code`, `total_price`, `status`, `snap_token`, `created_at`, `updated_at`) VALUES
(1, 4, 'TRX-434DB7C1-1771245116', '41500.00', 'pending', '4b1abfaf-43ed-4d89-a994-25385a3df934', '2026-02-16 05:31:56', '2026-02-16 05:31:57'),
(2, 4, 'TRX-B60F4DBC-1771245212', '65000.00', 'pending', '89354868-cc02-4e33-bb80-f3de3e360d1c', '2026-02-16 05:33:32', '2026-02-16 05:33:33'),
(3, 4, 'TRX-D74D1F24-1771245365', '65000.00', 'pending', 'd7f0cba2-449d-4a73-976b-25bdc2fb8a4b', '2026-02-16 05:36:05', '2026-02-16 05:36:06'),
(4, 4, 'TRX-7A7BC9AC-1771245488', '25000.00', 'failed', '85211a51-339c-4762-b813-640c0a1d9bdf', '2026-02-16 05:38:08', '2026-02-16 06:14:22'),
(5, 4, 'TRX-E0BD1D16-1771245693', '51500.00', 'paid', 'e8afcbb8-fac1-4a78-aafe-410bd4a77e8f', '2026-02-16 05:41:33', '2026-02-16 06:14:11'),
(6, 4, 'INV-177124582319', '25000.00', 'paid', '3df21eda-7ea0-4a6a-a127-78e78c053eb0', '2026-02-16 05:43:43', '2026-02-16 05:44:22'),
(7, 4, 'INV-177130262490', '55000.00', 'pending', '0ac68b6e-15d9-43dd-b92f-6954d269cb40', '2026-02-16 21:30:24', '2026-02-16 21:30:26'),
(8, 4, 'INV-177132195995', '70000.00', 'paid', 'ca8b45bb-769e-48fc-afbe-02dda97729b2', '2026-02-17 02:52:39', '2026-02-17 02:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` bigint UNSIGNED NOT NULL,
  `product_specification_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `design_option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upload',
  `design_difficulty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `design_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `design_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `product_specification_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`, `design_option`, `design_difficulty`, `design_cost`, `design_file`) VALUES
(1, 1, 9, 1, '1500.00', '1500.00', '2026-02-16 05:31:56', '2026-02-16 05:31:56', 'upload', 'Simpel', '0.00', 'designs/TNJE01p6rD4kqvAz7uIwF2styiYzMHt87l8dplrQ.png'),
(2, 1, 5, 1, '15000.00', '40000.00', '2026-02-16 05:31:56', '2026-02-16 05:31:56', 'tim_kami', 'Sedang', '25000.00', NULL),
(3, 2, 5, 1, '15000.00', '65000.00', '2026-02-16 05:33:32', '2026-02-16 05:33:32', 'tim_kami', 'Kompleks', '50000.00', NULL),
(4, 3, 5, 1, '15000.00', '65000.00', '2026-02-16 05:36:05', '2026-02-16 05:36:05', 'tim_kami', 'Kompleks', '50000.00', NULL),
(5, 4, 5, 1, '15000.00', '25000.00', '2026-02-16 05:38:08', '2026-02-16 05:38:08', 'tim_kami', 'Simpel', '10000.00', NULL),
(6, 5, 9, 1, '1500.00', '51500.00', '2026-02-16 05:41:33', '2026-02-16 05:41:33', 'tim_kami', 'Kompleks', '50000.00', NULL),
(7, 6, 5, 1, '15000.00', '25000.00', '2026-02-16 05:43:43', '2026-02-16 05:43:43', 'tim_kami', 'Simpel', '10000.00', NULL),
(8, 7, 5, 1, '15000.00', '15000.00', '2026-02-16 21:30:24', '2026-02-16 21:30:24', 'upload', 'Simpel', '0.00', 'designs/gVxQiSLo959D1IwN9uQv1QDKGweip8BzA0x3yPVd.jpg'),
(9, 7, 5, 1, '15000.00', '40000.00', '2026-02-16 21:30:24', '2026-02-16 21:30:24', 'tim_kami', 'Sedang', '25000.00', NULL),
(10, 8, 7, 1, '45000.00', '70000.00', '2026-02-17 02:52:39', '2026-02-17 02:52:39', 'tim_kami', 'Sedang', '25000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','owner','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'user',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$12$wTeFsBfyq.19CzfnVfpuiung1p4j2fUz2STpLKDFgkXtbrBwF6./q', 'admin', NULL, '2026-02-03 20:56:19', '2026-02-03 20:56:19'),
(2, 'Owner', 'owner@gmail.com', NULL, '$2y$12$jWJ6cmlvedY.6L7DeZmKa.q73USPLaO706/Yzt85l7Dqm6wgcnhjy', 'owner', NULL, '2026-02-03 20:56:20', '2026-02-03 20:56:20'),
(4, 'Anugrah Putra Al Fatih', 'anugrahputra270@gmail.com', NULL, '$2y$12$moGvSGIgNpX4h3Bi8LO9uudV../F04yTJ5hJeVsqw4tK1r7hhXZeC', 'user', NULL, '2026-02-06 01:34:25', '2026-02-06 01:34:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_details_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_details_product_specification_id_foreign` (`product_specification_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_weights`
--
ALTER TABLE `criteria_weights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_weights_user_id_foreign` (`user_id`),
  ADD KEY `criteria_weights_criteria_id_foreign` (`criteria_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_photos_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_specifications_product_id_foreign` (`product_id`);

--
-- Indexes for table `topsis_results`
--
ALTER TABLE `topsis_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topsis_results_user_id_foreign` (`user_id`),
  ADD KEY `topsis_results_product_specification_id_foreign` (`product_specification_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_order_code_unique` (`order_code`),
  ADD KEY `transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_details_transaction_id_foreign` (`transaction_id`),
  ADD KEY `transaction_details_product_specification_id_foreign` (`product_specification_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `criteria_weights`
--
ALTER TABLE `criteria_weights`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_specifications`
--
ALTER TABLE `product_specifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `topsis_results`
--
ALTER TABLE `topsis_results`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD CONSTRAINT `cart_details_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_details_product_specification_id_foreign` FOREIGN KEY (`product_specification_id`) REFERENCES `product_specifications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `criteria_weights`
--
ALTER TABLE `criteria_weights`
  ADD CONSTRAINT `criteria_weights_criteria_id_foreign` FOREIGN KEY (`criteria_id`) REFERENCES `criterias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `criteria_weights_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specifications`
--
ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topsis_results`
--
ALTER TABLE `topsis_results`
  ADD CONSTRAINT `topsis_results_product_specification_id_foreign` FOREIGN KEY (`product_specification_id`) REFERENCES `product_specifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `topsis_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_product_specification_id_foreign` FOREIGN KEY (`product_specification_id`) REFERENCES `product_specifications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_details_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
