-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 02:26 PM
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
-- Database: `order_payments`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('order-payments-api-cache-ZBMKnYTD8KC0oUV4', 's:7:\"forever\";', 2085570923);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_03_141751_create_orders_table', 2),
(5, '2026_02_03_141752_create_order_items_table', 2),
(6, '2026_02_03_141753_create_payments_table', 2),
(7, '2026_02_04_150000_create_payment_gateways_table', 3),
(8, '2026_02_04_151000_make_payment_gateways_class_nullable', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `status`, `total`, `created_at`, `updated_at`) VALUES
(2, 2, 'Mohamed', 'm@example.com', 'confirmed', 35.00, '2026-02-04 06:53:54', '2026-02-04 06:56:12'),
(4, 4, 'Mohamed', 'm@example.com', 'pending', 25.00, '2026-02-04 07:28:55', '2026-02-04 07:28:55'),
(5, 4, 'Mohamed', 'm@example.com', 'confirmed', 105.00, '2026-02-04 07:29:04', '2026-02-04 07:30:07'),
(7, 5, 'Mohamed', 'm@example.com', 'confirmed', 25.00, '2026-02-04 09:48:51', '2026-02-04 09:48:59'),
(8, 5, 'Mohamed', 'm@example.com', 'confirmed', 25.00, '2026-02-04 10:44:42', '2026-02-04 10:44:52'),
(9, 5, 'Mohamed', 'm@example.com', 'confirmed', 25.00, '2026-02-04 11:14:42', '2026-02-04 11:15:14');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `line_total`, `created_at`, `updated_at`) VALUES
(3, 2, 'A', 2, 15.00, 30.00, '2026-02-04 06:53:54', '2026-02-04 06:53:54'),
(4, 2, 'B', 1, 5.00, 5.00, '2026-02-04 06:53:54', '2026-02-04 06:53:54'),
(7, 4, 'A', 2, 10.00, 20.00, '2026-02-04 07:28:55', '2026-02-04 07:28:55'),
(8, 4, 'B', 1, 5.00, 5.00, '2026-02-04 07:28:55', '2026-02-04 07:28:55'),
(9, 5, 'A', 2, 50.00, 100.00, '2026-02-04 07:29:04', '2026-02-04 07:29:04'),
(10, 5, 'B', 1, 5.00, 5.00, '2026-02-04 07:29:04', '2026-02-04 07:29:04'),
(13, 7, 'A', 2, 10.00, 20.00, '2026-02-04 09:48:51', '2026-02-04 09:48:51'),
(14, 7, 'B', 1, 5.00, 5.00, '2026-02-04 09:48:51', '2026-02-04 09:48:51'),
(15, 8, 'A', 2, 10.00, 20.00, '2026-02-04 10:44:42', '2026-02-04 10:44:42'),
(16, 8, 'B', 1, 5.00, 5.00, '2026-02-04 10:44:42', '2026-02-04 10:44:42'),
(17, 9, 'A', 2, 10.00, 20.00, '2026-02-04 11:14:42', '2026-02-04 11:14:42'),
(18, 9, 'B', 1, 5.00, 5.00, '2026-02-04 11:14:42', '2026-02-04 11:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `method` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `order_id`, `status`, `method`, `amount`, `meta`, `created_at`, `updated_at`) VALUES
(1, 'CREDIT_CARD-698309f2aaa3c', 2, 'successful', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698309f2aa98e\"}', '2026-02-04 06:57:22', '2026-02-04 06:57:22'),
(2, 'CREDIT_CARD-698309ffae39d', 2, 'failed', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698309ffae340\"}', '2026-02-04 06:57:35', '2026-02-04 06:57:35'),
(3, 'CREDIT_CARD-69830a02eda35', 2, 'failed', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a02ed9c2\"}', '2026-02-04 06:57:38', '2026-02-04 06:57:38'),
(4, 'CREDIT_CARD-69830a0458e93', 2, 'successful', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a0458e20\"}', '2026-02-04 06:57:40', '2026-02-04 06:57:40'),
(5, 'CREDIT_CARD-69830a08b3bb8', 2, 'failed', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a08b3b5f\"}', '2026-02-04 06:57:44', '2026-02-04 06:57:44'),
(6, 'CREDIT_CARD-69830a0a62525', 2, 'failed', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a0a624d1\"}', '2026-02-04 06:57:46', '2026-02-04 06:57:46'),
(7, 'CREDIT_CARD-69830a0d2d05a', 2, 'failed', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a0d2d004\"}', '2026-02-04 06:57:49', '2026-02-04 06:57:49'),
(8, 'CREDIT_CARD-69830a0e57be4', 2, 'successful', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830a0e57b8f\"}', '2026-02-04 06:57:50', '2026-02-04 06:57:50'),
(9, 'CREDIT_CARD-69830c55656a7', 2, 'successful', 'credit_card', 15.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830c5565592\"}', '2026-02-04 07:07:33', '2026-02-04 07:07:33'),
(10, 'CREDIT_CARD-69830c5982ade', 2, 'successful', 'credit_card', 15.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-69830c5982a7d\"}', '2026-02-04 07:07:37', '2026-02-04 07:07:37'),
(11, 'CREDIT_CARD-698311a6e6bd4', 5, 'failed', 'credit_card', 105.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698311a6e6b58\"}', '2026-02-04 07:30:14', '2026-02-04 07:30:14'),
(12, 'CREDIT_CARD-698311af4201e', 5, 'failed', 'credit_card', 105.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698311af41f7d\"}', '2026-02-04 07:30:23', '2026-02-04 07:30:23'),
(13, 'CREDIT_CARD-698311b1e7e5d', 5, 'failed', 'credit_card', 105.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698311b1e7e01\"}', '2026-02-04 07:30:25', '2026-02-04 07:30:25'),
(14, 'CREDIT_CARD-698311b63ad6b', 5, 'successful', 'credit_card', 100.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698311b63ad15\"}', '2026-02-04 07:30:30', '2026-02-04 07:30:30'),
(15, 'CREDIT_CARD-698311b833684', 5, 'successful', 'credit_card', 100.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-698311b83362c\"}', '2026-02-04 07:30:32', '2026-02-04 07:30:32'),
(16, 'CREDIT_CARD-6983360ec131e', 7, 'successful', 'credit_card', 10.00, '{\"provider\":\"credit_card_sim\",\"ref\":\"CC-6983360ec1258\"}', '2026-02-04 10:05:34', '2026-02-04 10:05:34'),
(18, 'TESTSS-698343f35352f', 7, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698343f35345e\"}', '2026-02-04 11:04:51', '2026-02-04 11:04:51'),
(19, 'TESTSS-698343fd7850c', 7, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698343fd7817c\"}', '2026-02-04 11:05:01', '2026-02-04 11:05:01'),
(20, 'TESTSS-69834418c017e', 7, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-69834418c0020\"}', '2026-02-04 11:05:28', '2026-02-04 11:05:28'),
(21, 'TEST-69834426e1a89', 7, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"test\",\"ref\":\"TEST-69834426e19e3\"}', '2026-02-04 11:05:42', '2026-02-04 11:05:42'),
(22, 'TEST-698344418c6a5', 7, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"test\",\"ref\":\"TEST-698344418c61f\"}', '2026-02-04 11:06:09', '2026-02-04 11:06:09'),
(23, 'TEST-698344792ea96', 7, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"test\",\"ref\":\"TEST-698344792e996\"}', '2026-02-04 11:07:05', '2026-02-04 11:07:05'),
(24, 'TESTSS-69834483eb385', 7, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-69834483eb2e4\"}', '2026-02-04 11:07:15', '2026-02-04 11:07:15'),
(25, 'TESTSS-69834496608fb', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-6983449660825\"}', '2026-02-04 11:07:34', '2026-02-04 11:07:34'),
(26, 'TESTSS-698344e529960', 8, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344e5298c1\"}', '2026-02-04 11:08:53', '2026-02-04 11:08:53'),
(27, 'TESTSS-698344e743499', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344e74340b\"}', '2026-02-04 11:08:55', '2026-02-04 11:08:55'),
(28, 'TESTSS-698344e8f1b9a', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344e8f1b33\"}', '2026-02-04 11:08:56', '2026-02-04 11:08:56'),
(29, 'TESTSS-698344eb2ab84', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344eb2aacd\"}', '2026-02-04 11:08:59', '2026-02-04 11:08:59'),
(30, 'TESTSS-698344ece9dff', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344ece9d97\"}', '2026-02-04 11:09:00', '2026-02-04 11:09:00'),
(31, 'TESTSS-698344ee2de62', 8, 'successful', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344ee2ddf8\"}', '2026-02-04 11:09:02', '2026-02-04 11:09:02'),
(32, 'TESTSS-698344f026c7f', 8, 'failed', '\"PayPal\"', 25.00, '{\"provider\":\"testss\",\"ref\":\"TESTSS-698344f026b78\"}', '2026-02-04 11:09:04', '2026-02-04 11:09:04'),
(33, 'STRIP-698345f7e24ab', 8, 'successful', '\"strip\"', 25.00, '{\"provider\":\"strip\",\"ref\":\"STRIP-698345f7e22e5\"}', '2026-02-04 11:13:27', '2026-02-04 11:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `key`, `class`, `enabled`, `config`, `created_at`, `updated_at`) VALUES
(8, 'PayPal', 'App\\Services\\Payment\\Gateways\\Gateways\\PayPalGateway', 1, '{\"api_key\":\"sk_2ive_xxxxx\"}', '2026-02-04 09:53:01', '2026-02-04 09:53:01'),
(9, 'credit_card', 'App\\Services\\Payment\\Gateways\\Gateways\\CreditCardGateway', 1, '{\"api_key\":\"sk_live_xxxxx\"}', '2026-02-04 10:05:26', '2026-02-04 10:05:26'),
(16, 'strip', 'App\\Services\\Payment\\Gateways\\Gateways\\StripGateway', 1, '{\"api_key\":\"sk_live_xxxxx\"}', '2026-02-04 11:13:18', '2026-02-04 11:13:18');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0BbAs94TXcEFfCXTyrdHnyxKhl7ZDXz5RAhzhcg1', NULL, '127.0.0.1', 'PostmanRuntime/7.51.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEFBZFg4VlVCY1lqWml3ME14S05KR0oxeXhLVjVhbjBiU21DbEdsTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770209798),
('XIWu9m8twocSifwahBu2OiYRpj59wX4x6SfZ1pMu', NULL, '127.0.0.1', 'PostmanRuntime/7.51.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUpMQ3dGZkhYR3RxekZXTndHYzd6b0Nrb05KRkh5bkhBNXVtM3poUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770206148);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mohamed', 'mohamed@test.com', NULL, '$2y$12$4Pl5tsM4Zvd3wbgFvOkz/OOr46EPBNHwXv0zJStphTzs.pk.8kGRW', NULL, '2026-02-03 12:50:10', '2026-02-03 12:50:10'),
(2, 'Test User', 'test@example.com', NULL, '$2y$12$0O4rfjXhwBJpHkmlFPtu4Os2V/W02Aaa9YvM.E2MOrCvlOubLJ2ru', NULL, '2026-02-04 06:51:40', '2026-02-04 06:51:40'),
(3, 'Test User', 'test1@example.com', NULL, '$2y$12$RLu85yPIDOU5AFbkqJr59uklmOsWvrNQWg/8Ob2NSLykZbPyXxc8G', NULL, '2026-02-04 07:03:58', '2026-02-04 07:03:58'),
(4, 'Test User', 'test2@example.com', NULL, '$2y$12$ThD4adHZlGUqySMpJpV6WOMXQYcRLNARxdo9K0qckohLUfFCDXrFO', NULL, '2026-02-04 07:28:30', '2026-02-04 07:28:30'),
(5, 'Test1 User', 'tests@example.com', NULL, '$2y$12$nwzY1E1Omdt618jf2eTvCe/cRa2VEAbK7y9cQtorQl2wgzfxAv8Iu', NULL, '2026-02-04 09:45:51', '2026-02-04 09:45:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_status_index` (`status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_index` (`order_id`);

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
  ADD UNIQUE KEY `payments_payment_id_unique` (`payment_id`),
  ADD KEY `payments_order_id_status_method_index` (`order_id`,`status`,`method`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_gateways_key_unique` (`key`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
