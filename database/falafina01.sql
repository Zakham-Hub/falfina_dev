-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 16, 2025 at 12:44 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u466710613_falafina`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `type` enum('admin','supervisor') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `status`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mostafa', 'admin@app.com', NULL, '$2y$10$Y9SJhmciJVl9FyjlYMrI4u/M55YwBCWDs48SpAXUYqUS4Q/LeSf7C', NULL, 'active', 'admin', 'epNQKqzfvCOSEkMWwA29zvMuXKrzuL9ScAyEOWJTslBvgXi9SmqaUE5j0xkI', '2025-03-21 21:43:23', '2025-03-21 21:43:23'),
(2, 'Hesham', 'mm@app.com', NULL, '$2y$10$CLFMEIu2V2Jivaqi2lq2H.MUOLnUwBjXLflxxO/kVBNgBmL.qNa4W', NULL, 'active', 'admin', 'RrS0IgCKOg', '2025-03-21 21:43:29', '2025-04-10 13:37:37'),
(3, 'abdallah', 'abdallah@falafina.com', NULL, '$2y$10$QGsM4azSUf1kR7AyhGuYP.LCyKlp.RfqB0VnTu7hWJqGCKFV2iDuS', '01233445', 'active', 'supervisor', NULL, '2025-04-15 10:32:05', '2025-04-15 10:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `admin_profiles`
--

CREATE TABLE `admin_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `bio` text DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profiles`
--

INSERT INTO `admin_profiles` (`id`, `uuid`, `bio`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'ca77a4fb-b9dd-4618-be43-6b6b15f018d3', NULL, 1, '2025-03-21 21:43:24', '2025-03-21 21:43:24'),
(2, '43ec6e26-adb8-4245-b5aa-8462e579fb5f', NULL, 2, '2025-03-21 21:43:29', '2025-03-21 21:43:29'),
(3, '06c75e63-3a6c-4138-aacc-1d86315a5cb9', NULL, 3, '2025-04-15 10:32:05', '2025-04-15 10:32:05');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name`, `latitude`, `longitude`, `phone`, `status`, `created_at`, `updated_at`, `address`) VALUES
(7, 'فلافينا', 18.3000000, 42.7333330, NULL, 'active', '2025-03-23 21:12:01', '2025-03-23 21:12:01', 'خميس مشيط, محافظة خميس مشيط, منطقة عسير, 62411, السعودية'),
(8, 'فلافينا طريق الميه', 18.2393267, 42.6828016, NULL, 'active', '2025-03-23 21:28:54', '2025-03-23 21:28:54', 'طريق الأمير سلطان, خميس مشيط, محافظة خميس مشيط, منطقة عسير, 61321, السعودية'),
(9, 'فلافينا موجان بارك', 26.2908096, 50.1807264, NULL, 'active', '2025-03-23 21:31:45', '2025-03-23 21:31:45', 'al rashid mall, Feras Al-Nadher Street, الخبر, محافظة الخبر, المنطقة الشرقية, 34445, السعودية');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `description` text DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `status`, `description`, `short_description`, `created_at`, `updated_at`) VALUES
(8, 'البيتزا', NULL, 'active', 'البيتزا', 'البيتزا', '2025-03-29 18:07:42', '2025-03-29 18:07:42'),
(9, 'الفرن', NULL, 'active', 'الفرن', 'الفرن', '2025-03-29 18:08:56', '2025-03-29 18:08:56'),
(10, 'الفلافل', NULL, 'active', 'الفلافل', 'الفلافل', '2025-03-29 18:09:54', '2025-03-29 18:09:54'),
(11, 'الفطائر', NULL, 'active', 'الفطائر', 'الفطائر', '2025-03-29 18:11:28', '2025-03-29 18:11:28'),
(12, 'بوكسات', NULL, 'active', 'بوكسات', 'بوكسات', '2025-03-29 18:13:42', '2025-03-29 18:13:42'),
(13, 'كب يب', NULL, 'active', 'كب يب', 'كب يب', '2025-03-29 18:14:38', '2025-03-29 18:14:38'),
(14, 'الكوجك', NULL, 'active', 'الكوجك', 'الكوجك', '2025-03-29 18:15:29', '2025-03-29 18:15:29'),
(15, 'المكسيكى', NULL, 'active', 'المكسيكى', 'المكسيكى', '2025-03-29 18:16:36', '2025-03-29 18:16:36'),
(16, 'الكل', NULL, 'active', 'الكل', NULL, '2025-04-07 14:09:10', '2025-04-07 14:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `category_products`
--

CREATE TABLE `category_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_products`
--

INSERT INTO `category_products` (`id`, `category_id`, `product_id`, `created_at`, `updated_at`) VALUES
(4, 8, 5, NULL, NULL),
(5, 12, 6, NULL, NULL),
(6, 10, 7, NULL, NULL),
(7, 15, 7, NULL, NULL),
(8, 14, 8, NULL, NULL),
(9, 13, 9, NULL, NULL),
(10, 9, 10, NULL, NULL),
(11, 9, 11, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `percentage` varchar(255) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `type`, `percentage`, `from`, `to`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Howard Sharp', 'Autem earum et quis', 'Voluptate quibusdam', '2025-04-09', '2025-04-12', 'Est iusto non tempor', 'active', '2025-04-09 02:49:56', '2025-04-09 02:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(50) NOT NULL,
  `type` enum('sauce','addon') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`id`, `name`, `price`, `type`, `created_at`, `updated_at`) VALUES
(8, 'بطاطس', '6', 'addon', '2025-03-25 22:21:08', '2025-03-25 23:26:11'),
(10, 'صوص حار', '2', 'sauce', '2025-03-25 23:51:14', '2025-03-25 23:51:14'),
(11, 'مشروب غازى', '4', 'addon', '2025-03-29 02:32:12', '2025-03-29 02:32:12'),
(12, 'عصير الربيع', '3', 'addon', '2025-03-29 02:32:58', '2025-03-29 02:32:58'),
(13, 'حمص', '8', 'addon', '2025-03-29 02:33:44', '2025-03-29 02:33:44'),
(14, 'صوص عادى', '2', 'sauce', '2025-03-29 02:35:15', '2025-03-29 02:35:15'),
(15, 'طحينه', '1', 'sauce', '2025-03-29 02:35:49', '2025-03-29 02:35:49'),
(16, 'شطه شاميه', '1', 'sauce', '2025-03-29 02:36:26', '2025-03-29 02:36:26');

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
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `name`, `email`, `password`, `phone`, `status`, `branch_id`, `created_at`, `updated_at`) VALUES
(2, 'مصطفى', 'mm@moderator.com', '$2y$10$1pDDHYVTEMlRiW5jZAo0JOo8ABrUpll0JG3OYqYbD8MxzAIvR7KQK', '+1 (177) 649-7352', 'active', 9, '2025-03-30 20:06:41', '2025-04-09 14:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mediable_type` varchar(255) NOT NULL,
  `mediable_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `disk` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `mediable_type`, `mediable_id`, `collection_name`, `file_name`, `disk`, `created_at`, `updated_at`) VALUES
(7, 'App\\Models\\Item', 3, 'item', '67df6cbb6940d.png', 'direct_public', '2025-03-23 00:06:53', '2025-03-23 00:06:53'),
(10, 'App\\Models\\Item', 5, 'item', '67df760420e8f.png', 'direct_public', '2025-03-23 00:46:28', '2025-03-23 00:46:28'),
(27, 'App\\Models\\Setting', 1, 'favicon', 'b898257b05a612e790777f8dc0484127.png', 'root', '2025-03-25 00:56:02', '2025-03-25 00:56:02'),
(29, 'App\\Models\\Setting', 1, 'logo', '0bb899c0b402e6d6b6b358ea4212b39f.png', 'root', '2025-03-25 00:57:43', '2025-03-25 00:57:43'),
(31, 'App\\Models\\Slider', 4, 'slider', 'eb5ab20cd719ce1e6f2eed2b4b3359e6.webp', 'root', '2025-03-25 03:12:38', '2025-03-25 03:12:38'),
(32, 'App\\Models\\Slider', 5, 'slider', '9a13cd57faad13127906d1623b3c91d1.webp', 'root', '2025-03-25 03:13:08', '2025-03-25 03:13:08'),
(33, 'App\\Models\\Slider', 6, 'slider', 'b2abe06722ccd49e54e0048de2bd7d4e.webp', 'root', '2025-03-25 03:13:45', '2025-03-25 03:13:45'),
(43, 'App\\Models\\Category', 8, 'category', 'de742aa68ca9488cc4fa180c1daaa4db.webp', 'root', '2025-03-29 18:07:54', '2025-03-29 18:07:54'),
(44, 'App\\Models\\Category', 9, 'category', '8ae14266bbb53320244e8532be233250.webp', 'root', '2025-03-29 18:08:57', '2025-03-29 18:08:57'),
(45, 'App\\Models\\Category', 10, 'category', 'c91485a9f9a4f875ac2d2ba80147ac84.webp', 'root', '2025-03-29 18:09:55', '2025-03-29 18:09:55'),
(46, 'App\\Models\\Category', 11, 'category', '58381090a081043ea606c444fdeadc23.webp', 'root', '2025-03-29 18:11:31', '2025-03-29 18:11:31'),
(47, 'App\\Models\\Category', 12, 'category', 'e0b90a1e1d4216b1967eb7bb69d824ce.webp', 'root', '2025-03-29 18:13:43', '2025-03-29 18:13:43'),
(48, 'App\\Models\\Category', 13, 'category', '99480e4caa0572a069f62db99dfdab8f.webp', 'root', '2025-03-29 18:14:38', '2025-03-29 18:14:38'),
(49, 'App\\Models\\Category', 14, 'category', '6caced0cbbbe917c0b581fbcf8b57768.webp', 'root', '2025-03-29 18:15:31', '2025-03-29 18:15:31'),
(50, 'App\\Models\\Product', 5, 'product', 'c655d78503fc07b0ddd5639b1cda7058.webp', 'root', '2025-03-29 18:26:44', '2025-03-29 18:26:44'),
(51, 'App\\Models\\Product', 6, 'product', '8d7002a8d7b4c1efef1efe0ae05477fa.webp', 'root', '2025-03-29 18:31:43', '2025-03-29 18:31:43'),
(52, 'App\\Models\\Product', 7, 'product', '8df1c68b50413e9a35d80ec4ec6e7934.webp', 'root', '2025-03-29 18:34:41', '2025-03-29 18:34:41'),
(53, 'App\\Models\\Product', 8, 'product', 'f699adea39fccc08706d83833bc30b11.webp', 'root', '2025-03-29 18:41:08', '2025-03-29 18:41:08'),
(54, 'App\\Models\\Product', 9, 'product', 'e300c414ed129c3762cfd0f6321d7361.webp', 'root', '2025-03-29 18:44:07', '2025-03-29 18:44:07'),
(55, 'App\\Models\\Product', 10, 'product', 'ab94939d2669349ac33695110107e65d.webp', 'root', '2025-03-29 18:46:50', '2025-03-29 18:46:50'),
(57, 'App\\Models\\Extra', 16, 'extra', '42109a394847d4014e501fc9d38d1734.png', 'root', '2025-04-05 10:54:53', '2025-04-05 10:54:53'),
(58, 'App\\Models\\Extra', 15, 'extra', '7e2b4d59e5107961803787c94c00d528.png', 'root', '2025-04-05 10:55:07', '2025-04-05 10:55:07'),
(59, 'App\\Models\\Extra', 14, 'extra', 'ecb7fc9d09283bb05708935e77809f99.png', 'root', '2025-04-05 10:55:21', '2025-04-05 10:55:21'),
(60, 'App\\Models\\Extra', 10, 'extra', '10296fe761c7efa621120862cf5bf0cc.png', 'root', '2025-04-05 10:55:40', '2025-04-05 10:55:40'),
(64, 'App\\Models\\Product', 11, 'product', 'fad477a80125508ab39c3bbd5ae0e30e.png', 'root', '2025-04-15 14:00:26', '2025-04-15 14:00:26'),
(65, 'App\\Models\\Extra', 8, 'extra', '5f55cef533315836cd32c7539f0bf034.png', 'root', '2025-04-16 07:51:48', '2025-04-16 07:51:48'),
(66, 'App\\Models\\Extra', 13, 'extra', '5e6e64d708aa3223bbc696d183b37c03.png', 'root', '2025-04-16 07:51:55', '2025-04-16 07:51:55'),
(67, 'App\\Models\\Extra', 12, 'extra', '080bd5a48d135120c75ea755e5ec1599.png', 'root', '2025-04-16 07:52:02', '2025-04-16 07:52:02'),
(68, 'App\\Models\\Extra', 11, 'extra', '5a1a8f7ed7af5d3600c8ac0d24761a4c.png', 'root', '2025-04-16 07:52:09', '2025-04-16 07:52:09');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2024_08_06_103706_create_admins_table', 1),
(11, '2024_08_06_105145_create_admin_profiles_table', 1),
(12, '2024_08_06_105324_create_user_profiles_table', 1),
(13, '2025_03_12_205636_create_sessions_table', 1),
(15, '2025_03_16_105530_create_sizes_table', 1),
(16, '2025_03_16_120937_create_item_types_table', 1),
(19, '2025_03_18_145651_create_products_table', 1),
(20, '2025_03_18_151307_create_product_size_table', 1),
(21, '2025_03_18_151314_create_product_item_type_table', 1),
(22, '2025_03_18_151607_create_product_item_table', 1),
(23, '2025_03_16_173032_create_items_table', 2),
(24, '2025_03_16_211931_create_media_table', 2),
(25, '2025_03_23_180515_create_branches_table', 3),
(26, '2025_03_23_204903_add_columns_to_branch_table', 4),
(27, '2025_03_24_030623_add_address_fields_to_user_profiles', 5),
(28, '2025_03_24_033715_add_fields_to_users', 6),
(29, '2025_03_24_184151_create_settings_table', 7),
(30, '2025_03_25_041144_create_sliders_table', 8),
(31, '2025_03_25_204223_create_extras_table', 9),
(32, '2025_03_26_002709_add_currency_and_loyalty_points_to_settings_table', 10),
(33, '2025_03_26_030333_create_types_table', 11),
(34, '2025_03_26_035330_create_categories_table', 12),
(35, '2025_03_29_004907_create_category_products_table', 13),
(36, '2025_03_29_005710_create_product_size_table', 14),
(37, '2025_03_29_010844_create_product_type_table', 15),
(38, '2025_03_29_023941_create_product_extra_table', 16),
(39, '2025_03_29_233222_create_managers_table', 17),
(40, '2025_03_28_235022_create_product_type_table', 18),
(41, '2025_03_28_235029_create_product_size_table', 18),
(42, '2025_03_29_182255_create_packages_table', 18),
(43, '2025_03_29_182311_create_product_package_table', 18),
(44, '2025_04_06_004620_add_payment_to_orders_table', 18),
(45, '2025_04_08_214860_create_coupons_table', 19),
(46, '2025_04_14_105347_add_delivery_fees_settings_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `order_number` varchar(50) NOT NULL,
  `status` enum('pending','completed','canceled') NOT NULL DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_location` longtext DEFAULT NULL,
  `is_delivery` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `branch_id`, `payment_status`, `payment_type`, `order_number`, `status`, `total_price`, `order_location`, `is_delivery`, `created_at`, `updated_at`) VALUES
(22, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-03-31 04:07:52', '2025-03-31 04:07:52'),
(27, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
(28, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
(29, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 21:40:31', '2025-04-04 21:40:31'),
(30, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 21:44:26', '2025-04-04 21:44:26'),
(31, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 21:47:19', '2025-04-04 21:47:19'),
(32, 9, 7, NULL, NULL, '', 'pending', 83.00, NULL, 0, '2025-04-04 23:26:05', '2025-04-04 23:26:05'),
(36, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(38, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(39, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(40, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(41, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(42, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(43, 9, 7, NULL, NULL, '', 'pending', 56.00, NULL, 0, '2025-04-05 21:50:33', '2025-04-05 21:50:33'),
(44, 9, 7, NULL, NULL, '', 'pending', 56.00, NULL, 0, '2025-04-05 21:53:01', '2025-04-05 21:53:01'),
(45, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(46, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(47, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(48, 9, 7, NULL, NULL, '', 'pending', 166.00, NULL, 0, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(49, 13, 9, NULL, NULL, '', 'pending', 223.00, NULL, 0, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(50, 14, 7, NULL, NULL, '', 'pending', 34.00, NULL, 0, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(51, 14, 7, NULL, NULL, '', 'pending', 34.00, NULL, 0, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(52, 14, 7, NULL, NULL, '', 'pending', 34.00, NULL, 0, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(53, 14, 7, NULL, NULL, '', 'pending', 34.00, NULL, 0, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(54, 14, 7, NULL, NULL, '', 'pending', 34.00, NULL, 0, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(65, 9, 7, NULL, NULL, '4098', 'pending', 166.00, NULL, 0, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(66, 9, 7, NULL, NULL, '3628', 'pending', 166.00, NULL, 0, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(67, 9, 7, NULL, NULL, '3500', 'pending', 166.00, NULL, 0, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(68, 9, 7, NULL, NULL, '3202', 'pending', 166.00, NULL, 0, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(69, 9, 7, NULL, NULL, '4099', 'pending', 166.00, NULL, 0, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(70, 9, 7, NULL, NULL, '4100', 'pending', 166.00, NULL, 0, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(71, 9, 7, NULL, NULL, '4101', 'pending', 166.00, NULL, 0, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(72, 9, 7, NULL, NULL, '6695', 'pending', 83.00, NULL, 0, '2025-04-07 22:44:49', '2025-04-07 22:44:49'),
(73, 21, 7, NULL, NULL, '5957', 'pending', 38.00, NULL, 0, '2025-04-07 22:47:04', '2025-04-07 22:47:04'),
(74, 21, 8, NULL, NULL, '7606', 'pending', 111.00, NULL, 0, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(75, 21, 7, NULL, NULL, '7011', 'pending', 166.00, NULL, 0, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(76, 1, 7, NULL, NULL, '2850', 'pending', 83.00, NULL, 0, '2025-04-09 22:07:30', '2025-04-09 22:07:30'),
(77, 24, 9, NULL, NULL, '7504', 'pending', 38.00, NULL, 0, '2025-04-10 00:11:38', '2025-04-10 00:11:38'),
(78, 24, 9, NULL, NULL, '5471', 'pending', 19.00, NULL, 0, '2025-04-10 01:29:36', '2025-04-10 01:29:36'),
(79, 24, 9, NULL, NULL, '2532', 'pending', 19.00, NULL, 0, '2025-04-10 01:30:00', '2025-04-10 01:30:00'),
(80, 24, 9, NULL, NULL, '1472', 'pending', 19.00, NULL, 0, '2025-04-10 01:30:06', '2025-04-10 01:30:06'),
(81, 1, 7, NULL, NULL, '9662', 'pending', 83.00, NULL, 0, '2025-04-10 01:54:26', '2025-04-10 01:54:26'),
(82, 1, 8, NULL, NULL, '3750', 'pending', 45.00, NULL, 1, '2025-04-10 03:05:54', '2025-04-10 03:05:54'),
(83, 1, 8, NULL, NULL, '4410', 'pending', 45.00, NULL, 1, '2025-04-10 03:06:44', '2025-04-10 03:06:44'),
(84, 1, 8, NULL, NULL, '3949', 'pending', 45.00, NULL, 1, '2025-04-10 03:07:29', '2025-04-10 03:07:29'),
(85, 1, 9, NULL, NULL, '2957', 'pending', 53.00, NULL, 0, '2025-04-10 03:12:50', '2025-04-10 03:12:50'),
(86, 1, 9, NULL, NULL, '3466', 'pending', 53.00, NULL, 1, '2025-04-10 03:14:06', '2025-04-10 03:14:06'),
(87, 1, 9, NULL, NULL, '9932', 'pending', 53.00, NULL, 1, '2025-04-10 03:18:19', '2025-04-10 03:18:19'),
(88, 1, 9, NULL, NULL, '5992', 'pending', 47.00, NULL, 1, '2025-04-10 03:19:29', '2025-04-10 03:19:29'),
(89, 1, 9, NULL, NULL, '2361', 'pending', 47.00, NULL, 1, '2025-04-10 03:20:03', '2025-04-10 03:20:03'),
(90, 1, 9, NULL, NULL, '9928', 'pending', 0.00, NULL, 1, '2025-04-10 03:20:13', '2025-04-10 03:20:13'),
(91, 1, 8, NULL, NULL, '3845', 'pending', 39.00, NULL, 0, '2025-04-10 03:27:37', '2025-04-10 03:27:37'),
(92, 1, 8, NULL, NULL, '5593', 'pending', 39.00, NULL, 0, '2025-04-10 03:28:22', '2025-04-10 03:28:22'),
(93, 1, 8, NULL, NULL, '1533', 'pending', 59.00, NULL, 1, '2025-04-10 03:37:32', '2025-04-10 03:37:32'),
(94, 1, 8, NULL, NULL, '1594', 'pending', 40.00, NULL, 1, '2025-04-10 03:37:45', '2025-04-10 03:37:45'),
(95, 31, 9, NULL, NULL, '8427', 'pending', 40.00, NULL, 1, '2025-04-10 15:21:40', '2025-04-10 15:21:40'),
(96, 1, 9, NULL, NULL, '2143', 'pending', 97.00, NULL, 0, '2025-04-10 23:53:57', '2025-04-10 23:53:57'),
(97, 1, 9, NULL, NULL, '5629', 'pending', 471.00, NULL, 1, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(98, 1, 9, NULL, NULL, '5801', 'pending', 380.00, NULL, 1, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(99, 1, 8, NULL, NULL, '6708', 'pending', 139.00, NULL, 0, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(100, 1, 8, NULL, NULL, '7585', 'pending', 199.00, NULL, 0, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(101, 1, 8, NULL, NULL, '9068', 'pending', 139.00, NULL, 0, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(102, 1, 8, NULL, NULL, '3432', 'pending', 139.00, NULL, 0, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(103, 1, 7, NULL, NULL, '1327', 'completed', 132.00, 'ewew', 0, '2025-04-14 13:33:57', '2025-04-14 14:43:58'),
(104, 33, 9, NULL, NULL, '3054', 'pending', 38.00, NULL, 0, '2025-04-14 14:42:45', '2025-04-14 14:42:45'),
(105, 1, 9, NULL, NULL, '3993', 'pending', 108.00, NULL, 0, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(106, 1, 9, NULL, NULL, '4716', 'pending', 108.00, NULL, 1, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(107, 1, 9, NULL, NULL, '5387', 'pending', 108.00, NULL, 1, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(108, 1, 9, NULL, NULL, '3803', 'pending', 108.00, NULL, 1, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(109, 1, 9, NULL, NULL, '5611', 'pending', 88.00, NULL, 1, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(110, 1, 9, NULL, NULL, '4647', 'pending', 88.00, NULL, 1, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(111, 35, 9, NULL, NULL, '5148', 'pending', 134.00, NULL, 0, '2025-04-15 03:16:12', '2025-04-15 03:16:12'),
(112, 35, 9, NULL, NULL, '7411', 'pending', 134.00, NULL, 0, '2025-04-15 03:16:18', '2025-04-15 03:16:18'),
(113, 35, 9, NULL, NULL, '1753', 'pending', 38.00, NULL, 0, '2025-04-15 03:29:00', '2025-04-15 03:29:00'),
(114, 10, 8, NULL, NULL, '8614', 'pending', 68.00, NULL, 1, '2025-04-15 08:32:11', '2025-04-15 08:32:11'),
(115, 10, 8, NULL, NULL, '6650', 'pending', 68.00, NULL, 1, '2025-04-15 08:34:15', '2025-04-15 08:34:15'),
(116, 10, 9, NULL, NULL, '7605', 'pending', 0.00, NULL, 1, '2025-04-15 08:50:03', '2025-04-15 08:50:03'),
(117, 37, 9, NULL, NULL, '5652', 'pending', 56.00, NULL, 0, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(118, 35, 7, NULL, NULL, '3612', 'pending', 83.00, NULL, 0, '2025-04-15 11:34:27', '2025-04-15 11:34:27'),
(119, 10, 7, NULL, NULL, '9468', 'pending', 0.00, NULL, 0, '2025-04-15 15:29:30', '2025-04-15 15:29:30'),
(120, 10, 7, NULL, NULL, '3823', 'pending', 32.00, NULL, 0, '2025-04-16 07:50:30', '2025-04-16 07:50:30'),
(121, 10, 8, NULL, NULL, '7637', 'pending', 76.00, NULL, 0, '2025-04-16 07:58:05', '2025-04-16 07:58:05'),
(122, 10, 7, NULL, NULL, '1550', 'pending', 53.00, NULL, 0, '2025-04-16 09:03:55', '2025-04-16 09:03:55'),
(123, 10, 9, NULL, NULL, '8420', 'pending', 126.00, NULL, 0, '2025-04-16 12:06:55', '2025-04-16 12:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(22, 22, 5, 2, 38.00, NULL, NULL),
(23, 27, 5, 2, 38.00, NULL, NULL),
(24, 28, 5, 2, 38.00, NULL, NULL),
(25, 29, 5, 2, 38.00, NULL, NULL),
(26, 30, 5, 2, 38.00, NULL, NULL),
(27, 31, 5, 2, 38.00, NULL, NULL),
(28, 32, 5, 2, 38.00, NULL, NULL),
(29, 36, 5, 2, 38.00, NULL, NULL),
(30, 36, 5, 2, 38.00, NULL, NULL),
(31, 38, 5, 2, 38.00, NULL, NULL),
(32, 38, 5, 2, 38.00, NULL, NULL),
(33, 39, 5, 2, 38.00, NULL, NULL),
(34, 39, 5, 2, 38.00, NULL, NULL),
(35, 40, 5, 2, 38.00, NULL, NULL),
(36, 40, 5, 2, 38.00, NULL, NULL),
(37, 41, 5, 2, 38.00, NULL, NULL),
(38, 41, 5, 2, 38.00, NULL, NULL),
(39, 42, 5, 2, 38.00, NULL, NULL),
(40, 42, 5, 2, 38.00, NULL, NULL),
(41, 43, 6, 1, 56.00, NULL, NULL),
(42, 44, 6, 1, 56.00, NULL, NULL),
(43, 45, 5, 2, 38.00, NULL, NULL),
(44, 45, 5, 2, 38.00, NULL, NULL),
(45, 46, 5, 2, 38.00, NULL, NULL),
(46, 46, 5, 2, 38.00, NULL, NULL),
(47, 47, 5, 2, 38.00, NULL, NULL),
(48, 47, 5, 2, 38.00, NULL, NULL),
(49, 48, 5, 2, 38.00, NULL, NULL),
(50, 48, 5, 2, 38.00, NULL, NULL),
(51, 49, 5, 1, 19.00, NULL, NULL),
(52, 49, 5, 1, 19.00, NULL, NULL),
(53, 49, 6, 1, 56.00, NULL, NULL),
(54, 49, 9, 1, 45.00, NULL, NULL),
(55, 50, 7, 1, 20.00, NULL, NULL),
(56, 51, 7, 1, 20.00, NULL, NULL),
(57, 52, 7, 1, 20.00, NULL, NULL),
(58, 53, 7, 1, 20.00, NULL, NULL),
(59, 54, 7, 1, 20.00, NULL, NULL),
(73, 65, 5, 2, 38.00, NULL, NULL),
(74, 65, 5, 2, 38.00, NULL, NULL),
(75, 66, 5, 2, 38.00, NULL, NULL),
(76, 66, 5, 2, 38.00, NULL, NULL),
(77, 67, 5, 2, 38.00, NULL, NULL),
(78, 67, 5, 2, 38.00, NULL, NULL),
(79, 68, 5, 2, 38.00, NULL, NULL),
(80, 68, 5, 2, 38.00, NULL, NULL),
(81, 69, 5, 2, 38.00, NULL, NULL),
(82, 69, 5, 2, 38.00, NULL, NULL),
(83, 70, 5, 2, 38.00, NULL, NULL),
(84, 70, 5, 2, 38.00, NULL, NULL),
(85, 71, 5, 2, 38.00, NULL, NULL),
(86, 71, 5, 2, 38.00, NULL, NULL),
(87, 72, 5, 2, 38.00, NULL, NULL),
(88, 73, 5, 1, 19.00, NULL, NULL),
(89, 74, 5, 1, 19.00, NULL, NULL),
(90, 74, 6, 1, 56.00, NULL, NULL),
(91, 75, 5, 2, 38.00, NULL, NULL),
(92, 75, 5, 2, 38.00, NULL, NULL),
(93, 76, 5, 2, 38.00, NULL, NULL),
(94, 77, 5, 1, 19.00, NULL, NULL),
(95, 78, 5, 1, 19.00, NULL, NULL),
(96, 79, 5, 1, 19.00, NULL, NULL),
(97, 80, 5, 1, 19.00, NULL, NULL),
(98, 81, 5, 2, 38.00, NULL, NULL),
(99, 82, 9, 1, 45.00, NULL, NULL),
(100, 83, 9, 1, 45.00, NULL, NULL),
(101, 84, 9, 1, 45.00, NULL, NULL),
(102, 85, 9, 1, 45.00, NULL, NULL),
(103, 86, 9, 1, 45.00, NULL, NULL),
(104, 87, 9, 1, 45.00, NULL, NULL),
(105, 88, 9, 1, 45.00, NULL, NULL),
(106, 89, 9, 1, 45.00, NULL, NULL),
(107, 91, 5, 1, 19.00, NULL, NULL),
(108, 92, 5, 1, 19.00, NULL, NULL),
(109, 93, 5, 1, 19.00, NULL, NULL),
(110, 93, 5, 1, 19.00, NULL, NULL),
(111, 94, 5, 1, 19.00, NULL, NULL),
(112, 95, 7, 1, 20.00, NULL, NULL),
(113, 95, 7, 1, 20.00, NULL, NULL),
(114, 96, 6, 1, 56.00, NULL, NULL),
(115, 96, 10, 1, 21.00, NULL, NULL),
(116, 97, 5, 1, 19.00, NULL, NULL),
(117, 97, 6, 1, 56.00, NULL, NULL),
(118, 97, 5, 4, 76.00, NULL, NULL),
(119, 97, 6, 2, 112.00, NULL, NULL),
(120, 97, 11, 1, 45.00, NULL, NULL),
(121, 98, 5, 1, 19.00, NULL, NULL),
(122, 98, 6, 1, 56.00, NULL, NULL),
(123, 98, 5, 4, 76.00, NULL, NULL),
(124, 98, 6, 2, 112.00, NULL, NULL),
(125, 99, 5, 1, 19.00, NULL, NULL),
(126, 99, 5, 2, 38.00, NULL, NULL),
(127, 100, 5, 2, 38.00, NULL, NULL),
(128, 100, 5, 1, 19.00, NULL, NULL),
(129, 100, 6, 1, 56.00, NULL, NULL),
(130, 101, 5, 1, 19.00, NULL, NULL),
(131, 101, 5, 2, 38.00, NULL, NULL),
(132, 102, 5, 1, 19.00, NULL, NULL),
(133, 102, 5, 2, 38.00, NULL, NULL),
(135, 104, 5, 1, 19.00, NULL, NULL),
(138, 103, 5, 2, 38.00, NULL, NULL),
(139, 103, 6, 1, 56.00, NULL, NULL),
(140, 105, 5, 1, 19.00, NULL, NULL),
(141, 105, 5, 1, 19.00, NULL, NULL),
(142, 105, 7, 1, 20.00, NULL, NULL),
(143, 106, 5, 1, 19.00, NULL, NULL),
(144, 106, 5, 1, 19.00, NULL, NULL),
(145, 106, 7, 1, 20.00, NULL, NULL),
(146, 107, 5, 1, 19.00, NULL, NULL),
(147, 107, 5, 1, 19.00, NULL, NULL),
(148, 107, 7, 1, 20.00, NULL, NULL),
(149, 108, 5, 1, 19.00, NULL, NULL),
(150, 108, 5, 1, 19.00, NULL, NULL),
(151, 108, 7, 1, 20.00, NULL, NULL),
(152, 109, 5, 1, 19.00, NULL, NULL),
(153, 109, 5, 1, 19.00, NULL, NULL),
(154, 110, 5, 1, 19.00, NULL, NULL),
(155, 110, 5, 1, 19.00, NULL, NULL),
(156, 111, 5, 1, 19.00, NULL, NULL),
(157, 111, 6, 1, 56.00, NULL, NULL),
(158, 111, 5, 1, 19.00, NULL, NULL),
(159, 112, 5, 1, 19.00, NULL, NULL),
(160, 112, 6, 1, 56.00, NULL, NULL),
(161, 112, 5, 1, 19.00, NULL, NULL),
(162, 113, 5, 1, 19.00, NULL, NULL),
(163, 114, 5, 1, 19.00, NULL, NULL),
(164, 114, 7, 1, 20.00, NULL, NULL),
(165, 115, 5, 1, 19.00, NULL, NULL),
(166, 115, 7, 1, 20.00, NULL, NULL),
(167, 117, 5, 1, 19.00, NULL, NULL),
(168, 118, 5, 2, 38.00, NULL, NULL),
(169, 120, 11, 1, 8.00, NULL, NULL),
(170, 120, 11, 1, 8.00, NULL, NULL),
(171, 121, 5, 1, 19.00, NULL, NULL),
(172, 121, 5, 1, 19.00, NULL, NULL),
(173, 122, 11, 3, 24.00, NULL, NULL),
(174, 123, 7, 1, 20.00, NULL, NULL),
(175, 123, 11, 2, 16.00, NULL, NULL),
(176, 123, 5, 1, 19.00, NULL, NULL),
(177, 123, 7, 1, 20.00, NULL, NULL),
(178, 123, 7, 1, 20.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_product_details`
--

CREATE TABLE `order_product_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_price` decimal(10,2) DEFAULT NULL,
  `type_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product_details`
--

INSERT INTO `order_product_details` (`id`, `order_id`, `product_id`, `order_product_id`, `size_id`, `type_id`, `size_price`, `type_price`, `created_at`, `updated_at`) VALUES
(18, 22, 5, 22, 5, 2, 15.50, 0.00, '2025-03-31 04:07:52', '2025-03-31 04:07:52'),
(19, 27, 5, 23, 5, 2, 15.50, 0.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
(20, 28, 5, 24, 5, 2, 15.50, 0.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
(21, 29, 5, 25, 5, 2, 15.50, 0.00, '2025-04-04 21:40:31', '2025-04-04 21:40:31'),
(22, 30, 5, 26, 5, 2, 15.50, 0.00, '2025-04-04 21:44:26', '2025-04-04 21:44:26'),
(23, 31, 5, 27, 5, 2, 15.50, 0.00, '2025-04-04 21:47:19', '2025-04-04 21:47:19'),
(24, 32, 5, 28, 5, 2, 15.50, 0.00, '2025-04-04 23:26:05', '2025-04-04 23:26:05'),
(25, 36, 5, 29, 5, 2, 15.50, 0.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(26, 36, 5, 29, 5, 2, 15.50, 0.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(27, 38, 5, 31, 5, 2, 15.50, 0.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(28, 38, 5, 31, 5, 2, 15.50, 0.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(29, 39, 5, 33, 5, 2, 15.50, 0.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(30, 39, 5, 33, 5, 2, 15.50, 0.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(31, 40, 5, 35, 5, 2, 15.50, 0.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(32, 40, 5, 35, 5, 2, 15.50, 0.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(33, 41, 5, 37, 5, 2, 15.50, 0.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(34, 41, 5, 37, 5, 2, 15.50, 0.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(35, 42, 5, 39, 5, 2, 15.50, 0.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(36, 42, 5, 39, 5, 2, 15.50, 0.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(37, 43, 6, 41, NULL, NULL, 0.00, 0.00, '2025-04-05 21:50:33', '2025-04-05 21:50:33'),
(38, 44, 6, 42, NULL, NULL, 0.00, 0.00, '2025-04-05 21:53:01', '2025-04-05 21:53:01'),
(39, 45, 5, 43, 5, 2, 15.50, 0.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(40, 45, 5, 43, 5, 2, 15.50, 0.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(41, 46, 5, 45, 5, 2, 15.50, 0.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(42, 46, 5, 45, 5, 2, 15.50, 0.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(43, 47, 5, 47, 5, 2, 15.50, 0.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(44, 47, 5, 47, 5, 2, 15.50, 0.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(45, 48, 5, 49, 5, 2, 15.50, 0.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(46, 48, 5, 49, 5, 2, 15.50, 0.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(47, 49, 5, 51, 6, NULL, 19.00, 0.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(48, 49, 5, 51, 8, NULL, 25.00, 0.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(49, 49, 6, 53, NULL, NULL, 0.00, 0.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(50, 49, 9, 54, NULL, NULL, 0.00, 0.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(51, 50, 7, 55, NULL, NULL, 0.00, 0.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(52, 51, 7, 56, NULL, NULL, 0.00, 0.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(53, 52, 7, 57, NULL, NULL, 0.00, 0.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(54, 53, 7, 58, NULL, NULL, 0.00, 0.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(55, 54, 7, 59, NULL, NULL, 0.00, 0.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(69, 65, 5, 73, 5, 2, 15.50, 0.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(70, 65, 5, 73, 5, 2, 15.50, 0.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(71, 66, 5, 75, 5, 2, 15.50, 0.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(72, 66, 5, 75, 5, 2, 15.50, 0.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(73, 67, 5, 77, 5, 2, 15.50, 0.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(74, 67, 5, 77, 5, 2, 15.50, 0.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(75, 68, 5, 79, 5, 2, 15.50, 0.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(76, 68, 5, 79, 5, 2, 15.50, 0.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(77, 69, 5, 81, 5, 2, 15.50, 0.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(78, 69, 5, 81, 5, 2, 15.50, 0.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(79, 70, 5, 83, 5, 2, 15.50, 0.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(80, 70, 5, 83, 5, 2, 15.50, 0.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(81, 71, 5, 85, 5, 2, 15.50, 0.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(82, 71, 5, 85, 5, 2, 15.50, 0.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(83, 72, 5, 87, 5, 2, 15.50, 0.00, '2025-04-07 22:44:49', '2025-04-07 22:44:49'),
(84, 73, 5, 88, 6, NULL, 19.00, 0.00, '2025-04-07 22:47:04', '2025-04-07 22:47:04'),
(85, 74, 5, 89, 6, NULL, 19.00, 0.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(86, 74, 6, 90, NULL, NULL, 0.00, 0.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(87, 75, 5, 91, 5, 2, 15.50, 0.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(88, 75, 5, 91, 5, 2, 15.50, 0.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(89, 76, 5, 93, 5, 2, 15.50, 0.00, '2025-04-09 22:07:30', '2025-04-09 22:07:30'),
(90, 77, 5, 94, 6, NULL, 19.00, 0.00, '2025-04-10 00:11:38', '2025-04-10 00:11:38'),
(91, 78, 5, 95, NULL, NULL, 0.00, 0.00, '2025-04-10 01:29:36', '2025-04-10 01:29:36'),
(92, 79, 5, 96, NULL, NULL, 0.00, 0.00, '2025-04-10 01:30:00', '2025-04-10 01:30:00'),
(93, 80, 5, 97, NULL, NULL, 0.00, 0.00, '2025-04-10 01:30:06', '2025-04-10 01:30:06'),
(94, 81, 5, 98, 5, 2, 15.50, 0.00, '2025-04-10 01:54:26', '2025-04-10 01:54:26'),
(95, 82, 9, 99, NULL, NULL, 0.00, 0.00, '2025-04-10 03:05:54', '2025-04-10 03:05:54'),
(96, 83, 9, 100, NULL, NULL, 0.00, 0.00, '2025-04-10 03:06:44', '2025-04-10 03:06:44'),
(97, 84, 9, 101, NULL, NULL, 0.00, 0.00, '2025-04-10 03:07:29', '2025-04-10 03:07:29'),
(98, 85, 9, 102, NULL, NULL, 0.00, 0.00, '2025-04-10 03:12:50', '2025-04-10 03:12:50'),
(99, 86, 9, 103, NULL, NULL, 0.00, 0.00, '2025-04-10 03:14:06', '2025-04-10 03:14:06'),
(100, 87, 9, 104, NULL, NULL, 0.00, 0.00, '2025-04-10 03:18:19', '2025-04-10 03:18:19'),
(101, 88, 9, 105, NULL, NULL, 0.00, 0.00, '2025-04-10 03:19:29', '2025-04-10 03:19:29'),
(102, 89, 9, 106, NULL, NULL, 0.00, 0.00, '2025-04-10 03:20:03', '2025-04-10 03:20:03'),
(103, 91, 5, 107, 6, NULL, 19.00, 0.00, '2025-04-10 03:27:37', '2025-04-10 03:27:37'),
(104, 92, 5, 108, 6, NULL, 19.00, 0.00, '2025-04-10 03:28:22', '2025-04-10 03:28:22'),
(105, 93, 5, 109, 6, NULL, 19.00, 0.00, '2025-04-10 03:37:32', '2025-04-10 03:37:32'),
(106, 93, 5, 109, NULL, NULL, 0.00, 0.00, '2025-04-10 03:37:32', '2025-04-10 03:37:32'),
(107, 94, 5, 111, 6, NULL, 19.00, 0.00, '2025-04-10 03:37:45', '2025-04-10 03:37:45'),
(108, 95, 7, 112, NULL, NULL, 0.00, 0.00, '2025-04-10 15:21:40', '2025-04-10 15:21:40'),
(109, 95, 7, 112, NULL, NULL, 0.00, 0.00, '2025-04-10 15:21:40', '2025-04-10 15:21:40'),
(110, 96, 6, 114, NULL, NULL, 0.00, 0.00, '2025-04-10 23:53:57', '2025-04-10 23:53:57'),
(111, 96, 10, 115, 2, NULL, 20.00, 0.00, '2025-04-10 23:53:57', '2025-04-10 23:53:57'),
(112, 97, 5, 116, 6, NULL, 19.00, 0.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(113, 97, 6, 117, NULL, NULL, 0.00, 0.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(114, 97, 5, 116, 6, NULL, 19.00, 0.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(115, 97, 6, 117, NULL, NULL, 0.00, 0.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(116, 97, 11, 120, 7, NULL, 44.00, 0.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(117, 98, 5, 121, 6, NULL, 19.00, 0.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(118, 98, 6, 122, NULL, NULL, 0.00, 0.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(119, 98, 5, 121, 6, NULL, 19.00, 0.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(120, 98, 6, 122, NULL, NULL, 0.00, 0.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(121, 99, 5, 125, 6, NULL, 19.00, 0.00, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(122, 99, 5, 125, 8, NULL, 25.00, 0.00, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(123, 100, 5, 127, 6, NULL, 19.00, 0.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(124, 100, 5, 127, 8, NULL, 25.00, 0.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(125, 100, 6, 129, NULL, NULL, 0.00, 0.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(126, 101, 5, 130, 6, NULL, 19.00, 0.00, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(127, 101, 5, 130, 8, NULL, 25.00, 0.00, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(128, 102, 5, 132, 6, NULL, 19.00, 0.00, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(129, 102, 5, 132, 8, NULL, 25.00, 0.00, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(131, 104, 5, 135, 6, NULL, 19.00, 0.00, '2025-04-14 14:42:45', '2025-04-14 14:42:45'),
(132, 105, 5, 140, 6, NULL, 19.00, 0.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(133, 105, 5, 140, 8, NULL, 25.00, 0.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(134, 105, 7, 142, NULL, NULL, 0.00, 0.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(135, 106, 5, 143, 6, NULL, 19.00, 0.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(136, 106, 5, 143, 8, NULL, 25.00, 0.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(137, 106, 7, 145, NULL, NULL, 0.00, 0.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(138, 107, 5, 146, 6, NULL, 19.00, 0.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(139, 107, 5, 146, 8, NULL, 25.00, 0.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(140, 107, 7, 148, NULL, NULL, 0.00, 0.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(141, 108, 5, 149, 6, NULL, 19.00, 0.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(142, 108, 5, 149, 8, NULL, 25.00, 0.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(143, 108, 7, 151, NULL, NULL, 0.00, 0.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(144, 109, 5, 152, 6, NULL, 19.00, 0.00, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(145, 109, 5, 152, 8, NULL, 25.00, 0.00, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(146, 110, 5, 154, 6, NULL, 19.00, 0.00, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(147, 110, 5, 154, 8, NULL, 25.00, 0.00, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(148, 111, 5, 156, 6, NULL, 19.00, 0.00, '2025-04-15 03:16:12', '2025-04-15 03:16:12'),
(149, 111, 6, 157, NULL, NULL, 0.00, 0.00, '2025-04-15 03:16:12', '2025-04-15 03:16:12'),
(150, 111, 5, 156, 6, NULL, 19.00, 0.00, '2025-04-15 03:16:12', '2025-04-15 03:16:12'),
(151, 112, 5, 159, 6, NULL, 19.00, 0.00, '2025-04-15 03:16:18', '2025-04-15 03:16:18'),
(152, 112, 6, 160, NULL, NULL, 0.00, 0.00, '2025-04-15 03:16:18', '2025-04-15 03:16:18'),
(153, 112, 5, 159, 6, NULL, 19.00, 0.00, '2025-04-15 03:16:18', '2025-04-15 03:16:18'),
(154, 113, 5, 162, 6, NULL, 19.00, 0.00, '2025-04-15 03:29:00', '2025-04-15 03:29:00'),
(155, 114, 5, 163, 8, NULL, 25.00, 0.00, '2025-04-15 08:32:11', '2025-04-15 08:32:11'),
(156, 114, 7, 164, NULL, NULL, 0.00, 0.00, '2025-04-15 08:32:11', '2025-04-15 08:32:11'),
(157, 115, 5, 165, 8, NULL, 25.00, 0.00, '2025-04-15 08:34:15', '2025-04-15 08:34:15'),
(158, 115, 7, 166, NULL, NULL, 0.00, 0.00, '2025-04-15 08:34:15', '2025-04-15 08:34:15'),
(159, 117, 5, 167, 8, NULL, 25.00, 0.00, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(160, 118, 5, 168, 5, 2, 15.50, 0.00, '2025-04-15 11:34:27', '2025-04-15 11:34:27'),
(161, 120, 11, 169, 2, NULL, 8.00, 0.00, '2025-04-16 07:50:30', '2025-04-16 07:50:30'),
(162, 120, 11, 169, 2, NULL, 8.00, 0.00, '2025-04-16 07:50:30', '2025-04-16 07:50:30'),
(163, 121, 5, 171, 6, NULL, 19.00, 0.00, '2025-04-16 07:58:05', '2025-04-16 07:58:05'),
(164, 121, 5, 171, 6, NULL, 19.00, 0.00, '2025-04-16 07:58:05', '2025-04-16 07:58:05'),
(165, 122, 11, 173, 2, NULL, 8.00, 0.00, '2025-04-16 09:03:55', '2025-04-16 09:03:55'),
(166, 123, 7, 174, NULL, NULL, 0.00, 0.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(167, 123, 11, 175, 2, NULL, 8.00, 0.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(168, 123, 5, 176, NULL, NULL, 0.00, 0.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(169, 123, 7, 174, NULL, NULL, 0.00, 0.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(170, 123, 7, 174, NULL, NULL, 0.00, 0.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_product_extras`
--

CREATE TABLE `order_product_extras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `extra_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product_extras`
--

INSERT INTO `order_product_extras` (`id`, `order_product_id`, `extra_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(29, 22, 8, 2, 6.00, '2025-03-31 04:07:52', '2025-03-31 04:07:52'),
(30, 22, 10, 1, 2.00, '2025-03-31 04:07:52', '2025-03-31 04:07:52'),
(31, 23, 8, 2, 6.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
(32, 23, 10, 1, 2.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
(33, 24, 8, 2, 6.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
(34, 24, 10, 1, 2.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
(35, 25, 8, 2, 6.00, '2025-04-04 21:40:31', '2025-04-04 21:40:31'),
(36, 25, 10, 1, 2.00, '2025-04-04 21:40:31', '2025-04-04 21:40:31'),
(37, 26, 8, 2, 6.00, '2025-04-04 21:44:26', '2025-04-04 21:44:26'),
(38, 26, 10, 1, 2.00, '2025-04-04 21:44:26', '2025-04-04 21:44:26'),
(39, 27, 8, 2, 6.00, '2025-04-04 21:47:19', '2025-04-04 21:47:19'),
(40, 27, 10, 1, 2.00, '2025-04-04 21:47:19', '2025-04-04 21:47:19'),
(41, 28, 8, 2, 6.00, '2025-04-04 23:26:05', '2025-04-04 23:26:05'),
(42, 28, 10, 1, 2.00, '2025-04-04 23:26:05', '2025-04-04 23:26:05'),
(43, 29, 8, 2, 6.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(44, 29, 10, 1, 2.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(45, 29, 8, 2, 6.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(46, 29, 10, 1, 2.00, '2025-04-04 23:28:35', '2025-04-04 23:28:35'),
(47, 31, 8, 2, 6.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(48, 31, 10, 1, 2.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(49, 31, 8, 2, 6.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(50, 31, 10, 1, 2.00, '2025-04-05 10:14:33', '2025-04-05 10:14:33'),
(51, 33, 8, 2, 6.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(52, 33, 10, 1, 2.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(53, 33, 8, 2, 6.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(54, 33, 10, 1, 2.00, '2025-04-05 12:35:00', '2025-04-05 12:35:00'),
(55, 35, 8, 2, 6.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(56, 35, 10, 1, 2.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(57, 35, 8, 2, 6.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(58, 35, 10, 1, 2.00, '2025-04-05 13:08:52', '2025-04-05 13:08:52'),
(59, 37, 8, 2, 6.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(60, 37, 10, 1, 2.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(61, 37, 8, 2, 6.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(62, 37, 10, 1, 2.00, '2025-04-05 20:55:48', '2025-04-05 20:55:48'),
(63, 39, 8, 2, 6.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(64, 39, 10, 1, 2.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(65, 39, 8, 2, 6.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(66, 39, 10, 1, 2.00, '2025-04-05 21:39:41', '2025-04-05 21:39:41'),
(67, 43, 8, 2, 6.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(68, 43, 10, 1, 2.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(69, 43, 8, 2, 6.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(70, 43, 10, 1, 2.00, '2025-04-05 21:55:43', '2025-04-05 21:55:43'),
(71, 45, 8, 2, 6.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(72, 45, 10, 1, 2.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(73, 45, 8, 2, 6.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(74, 45, 10, 1, 2.00, '2025-04-06 15:52:32', '2025-04-06 15:52:32'),
(75, 47, 8, 2, 6.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(76, 47, 10, 1, 2.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(77, 47, 8, 2, 6.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(78, 47, 10, 1, 2.00, '2025-04-06 15:56:16', '2025-04-06 15:56:16'),
(79, 49, 8, 2, 6.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(80, 49, 10, 1, 2.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(81, 49, 8, 2, 6.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(82, 49, 10, 1, 2.00, '2025-04-06 15:56:57', '2025-04-06 15:56:57'),
(83, 51, 10, 1, 2.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(84, 51, 14, 1, 2.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(85, 51, 15, 1, 1.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(86, 51, 8, 1, 6.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(87, 51, 11, 1, 4.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(88, 51, 10, 1, 2.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(89, 51, 13, 1, 8.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(90, 51, 8, 1, 6.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(91, 51, 16, 1, 1.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(92, 53, 10, 1, 2.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(93, 54, 11, 1, 4.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(94, 54, 10, 1, 2.00, '2025-04-06 23:59:16', '2025-04-06 23:59:16'),
(95, 55, 10, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(96, 55, 14, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(97, 55, 8, 1, 6.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(98, 55, 11, 1, 4.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(99, 56, 10, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(100, 56, 14, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(101, 56, 8, 1, 6.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(102, 56, 11, 1, 4.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(103, 57, 10, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(104, 57, 14, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(105, 57, 8, 1, 6.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(106, 57, 11, 1, 4.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(107, 58, 10, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(108, 58, 14, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(109, 58, 8, 1, 6.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(110, 58, 11, 1, 4.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(111, 59, 10, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(112, 59, 14, 1, 2.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(113, 59, 8, 1, 6.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(114, 59, 11, 1, 4.00, '2025-04-07 00:50:21', '2025-04-07 00:50:21'),
(149, 73, 8, 2, 6.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(150, 73, 10, 1, 2.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(151, 73, 8, 2, 6.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(152, 73, 10, 1, 2.00, '2025-04-07 10:21:09', '2025-04-07 10:21:09'),
(153, 75, 8, 2, 6.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(154, 75, 10, 1, 2.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(155, 75, 8, 2, 6.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(156, 75, 10, 1, 2.00, '2025-04-07 10:22:40', '2025-04-07 10:22:40'),
(157, 77, 8, 2, 6.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(158, 77, 10, 1, 2.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(159, 77, 8, 2, 6.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(160, 77, 10, 1, 2.00, '2025-04-07 10:22:53', '2025-04-07 10:22:53'),
(161, 79, 8, 2, 6.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(162, 79, 10, 1, 2.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(163, 79, 8, 2, 6.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(164, 79, 10, 1, 2.00, '2025-04-07 10:23:02', '2025-04-07 10:23:02'),
(165, 81, 8, 2, 6.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(166, 81, 10, 1, 2.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(167, 81, 8, 2, 6.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(168, 81, 10, 1, 2.00, '2025-04-07 10:35:18', '2025-04-07 10:35:18'),
(169, 83, 8, 2, 6.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(170, 83, 10, 1, 2.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(171, 83, 8, 2, 6.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(172, 83, 10, 1, 2.00, '2025-04-07 10:35:23', '2025-04-07 10:35:23'),
(173, 85, 8, 2, 6.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(174, 85, 10, 1, 2.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(175, 85, 8, 2, 6.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(176, 85, 10, 1, 2.00, '2025-04-07 10:35:26', '2025-04-07 10:35:26'),
(177, 87, 8, 2, 6.00, '2025-04-07 22:44:49', '2025-04-07 22:44:49'),
(178, 87, 10, 1, 2.00, '2025-04-07 22:44:49', '2025-04-07 22:44:49'),
(179, 89, 10, 1, 2.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(180, 89, 8, 1, 6.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(181, 90, 15, 1, 1.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(182, 90, 13, 1, 8.00, '2025-04-07 22:55:14', '2025-04-07 22:55:14'),
(183, 91, 8, 2, 6.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(184, 91, 10, 1, 2.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(185, 91, 8, 2, 6.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(186, 91, 10, 1, 2.00, '2025-04-08 16:38:42', '2025-04-08 16:38:42'),
(187, 93, 8, 2, 6.00, '2025-04-09 22:07:30', '2025-04-09 22:07:30'),
(188, 93, 10, 1, 2.00, '2025-04-09 22:07:30', '2025-04-09 22:07:30'),
(189, 98, 8, 2, 6.00, '2025-04-10 01:54:26', '2025-04-10 01:54:26'),
(190, 98, 10, 1, 2.00, '2025-04-10 01:54:26', '2025-04-10 01:54:26'),
(191, 102, 10, 1, 2.00, '2025-04-10 03:12:50', '2025-04-10 03:12:50'),
(192, 102, 8, 1, 6.00, '2025-04-10 03:12:50', '2025-04-10 03:12:50'),
(193, 103, 10, 1, 2.00, '2025-04-10 03:14:06', '2025-04-10 03:14:06'),
(194, 103, 8, 1, 6.00, '2025-04-10 03:14:06', '2025-04-10 03:14:06'),
(195, 104, 10, 1, 2.00, '2025-04-10 03:18:19', '2025-04-10 03:18:19'),
(196, 104, 8, 1, 6.00, '2025-04-10 03:18:19', '2025-04-10 03:18:19'),
(197, 105, 10, 1, 2.00, '2025-04-10 03:19:29', '2025-04-10 03:19:29'),
(198, 106, 10, 1, 2.00, '2025-04-10 03:20:03', '2025-04-10 03:20:03'),
(199, 107, 15, 1, 1.00, '2025-04-10 03:27:37', '2025-04-10 03:27:37'),
(200, 108, 15, 1, 1.00, '2025-04-10 03:28:22', '2025-04-10 03:28:22'),
(201, 109, 10, 1, 2.00, '2025-04-10 03:37:32', '2025-04-10 03:37:32'),
(202, 111, 10, 1, 2.00, '2025-04-10 03:37:45', '2025-04-10 03:37:45'),
(203, 116, 10, 1, 2.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(204, 116, 14, 1, 2.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(205, 116, 8, 1, 6.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(206, 116, 11, 1, 4.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(207, 117, 14, 1, 2.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(208, 117, 8, 1, 6.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(209, 120, 10, 1, 2.00, '2025-04-10 23:58:40', '2025-04-10 23:58:40'),
(210, 121, 10, 1, 2.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(211, 121, 14, 1, 2.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(212, 121, 8, 1, 6.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(213, 121, 11, 1, 4.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(214, 122, 14, 1, 2.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(215, 122, 8, 1, 6.00, '2025-04-10 23:58:49', '2025-04-10 23:58:49'),
(216, 125, 10, 1, 2.00, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(217, 125, 12, 1, 3.00, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(218, 125, 13, 1, 8.00, '2025-04-10 23:59:36', '2025-04-10 23:59:36'),
(219, 127, 10, 1, 2.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(220, 127, 13, 1, 8.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(221, 127, 12, 1, 3.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(222, 127, 10, 1, 2.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(223, 127, 13, 1, 8.00, '2025-04-11 00:01:53', '2025-04-11 00:01:53'),
(224, 130, 10, 1, 2.00, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(225, 130, 12, 1, 3.00, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(226, 130, 13, 1, 8.00, '2025-04-11 00:02:11', '2025-04-11 00:02:11'),
(227, 132, 10, 1, 2.00, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(228, 132, 12, 1, 3.00, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(229, 132, 13, 1, 8.00, '2025-04-11 00:03:48', '2025-04-11 00:03:48'),
(232, 140, 15, 1, 1.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(233, 140, 11, 1, 4.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(234, 140, 15, 1, 1.00, '2025-04-14 23:28:49', '2025-04-14 23:28:49'),
(235, 143, 15, 1, 1.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(236, 143, 11, 1, 4.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(237, 143, 15, 1, 1.00, '2025-04-14 23:33:35', '2025-04-14 23:33:35'),
(238, 146, 15, 1, 1.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(239, 146, 11, 1, 4.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(240, 146, 15, 1, 1.00, '2025-04-14 23:35:21', '2025-04-14 23:35:21'),
(241, 149, 15, 1, 1.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(242, 149, 11, 1, 4.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(243, 149, 15, 1, 1.00, '2025-04-14 23:36:36', '2025-04-14 23:36:36'),
(244, 152, 15, 1, 1.00, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(245, 152, 11, 1, 4.00, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(246, 152, 15, 1, 1.00, '2025-04-14 23:39:49', '2025-04-14 23:39:49'),
(247, 154, 15, 1, 1.00, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(248, 154, 11, 1, 4.00, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(249, 154, 15, 1, 1.00, '2025-04-14 23:43:03', '2025-04-14 23:43:03'),
(250, 156, 10, 1, 2.00, '2025-04-15 03:16:12', '2025-04-15 03:16:12'),
(251, 159, 10, 1, 2.00, '2025-04-15 03:16:18', '2025-04-15 03:16:18'),
(252, 163, 10, 1, 2.00, '2025-04-15 08:32:11', '2025-04-15 08:32:11'),
(253, 163, 14, 1, 2.00, '2025-04-15 08:32:11', '2025-04-15 08:32:11'),
(254, 165, 10, 1, 2.00, '2025-04-15 08:34:15', '2025-04-15 08:34:15'),
(255, 165, 14, 1, 2.00, '2025-04-15 08:34:15', '2025-04-15 08:34:15'),
(256, 167, 10, 1, 2.00, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(257, 167, 15, 1, 1.00, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(258, 167, 8, 1, 6.00, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(259, 167, 12, 1, 3.00, '2025-04-15 11:31:45', '2025-04-15 11:31:45'),
(260, 168, 8, 2, 6.00, '2025-04-15 11:34:27', '2025-04-15 11:34:27'),
(261, 168, 10, 1, 2.00, '2025-04-15 11:34:27', '2025-04-15 11:34:27'),
(262, 173, 10, 1, 2.00, '2025-04-16 09:03:55', '2025-04-16 09:03:55'),
(263, 173, 12, 1, 3.00, '2025-04-16 09:03:55', '2025-04-16 09:03:55'),
(264, 174, 10, 1, 2.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(265, 174, 12, 1, 3.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(266, 175, 13, 1, 8.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55'),
(267, 175, 10, 1, 2.00, '2025-04-16 12:06:55', '2025-04-16 12:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('islam@test.com', '$2y$10$Fy6l4hbaXU0i1nmUC/PekOjQWlqfHH1bOTvWo/WRSwx7FcJF.xFne', '2025-04-09 01:21:06'),
('mostafa0alii@gmail.com', '$2y$10$vpy3q9sSTuk2VGw4YOh6l.l0k.g3cz.stwMkL8EIGlJcMkMhsXVr2', '2025-04-09 01:12:45'),
('new@app.com', '$2y$10$XtzYylNkf4OHPlG5xW1QeOzOja5RXWK6bnMUZSIcOKHi3/qfZdJTC', '2025-04-15 01:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alt_name` varchar(255) DEFAULT NULL,
  `loyalty_points` varchar(255) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `short_description`, `price`, `created_at`, `updated_at`, `alt_name`, `loyalty_points`) VALUES
(5, 'بيتزا الجبن', 'تجربة لا تُقاوم لعشاق الجبن مع بيتزا الجبن الكلاسيكية التي تجمع بين قوام العجينة الخفيف والهش وطعم الجبن الذائب والغني. يتم إعداد بيتزا الجبن باستخدام مزيج فاخر من أنواع الجبن مثل جبنة الموزاريلا وجبنة الشيدر، مما يمنحك تجربة ذوقية لا مثيل لها في كل قضمة', 'تجربة لا تُقاوم لعشاق الجبن مع بيتزا الجبن الكلاسيكية التي تجمع بين قوام العجينة الخفيف والهش وطعم الجبن الذائب والغني. يتم إعداد بيتزا الجبن باستخدام مزيج فاخر من أنواع الجبن مثل جبنة الموزاريلا وجبنة الشيدر، مما يمنحك تجربة ذوقية لا مثيل لها في كل قضمة', 19.00, '2025-03-29 18:26:43', '2025-04-15 13:55:13', NULL, '5000'),
(6, 'بوكس العائلة', 'بوكس العائلة', 'بوكس العائلة', 56.00, '2025-03-29 18:31:43', '2025-03-29 18:31:43', NULL, NULL),
(7, 'صحن فلافل', 'استمتع بتجربة فريدة مع صحن الفلافل الذي يقدم لك مجموعة من كرات الفلافل المقرمشة والمحضرة يدويًا من الحمص الطازج والتوابل الخاصة. يتم تقديم صحن الفلافل مع تشكيلة من الخضروات الطازجة مثل الطماطم، الخيار، والخس، بالإضافة إلى صلصة الطحينة الكريمية والخبز العربي الطازج. هذا الصحن مثالي كوجبة رئيسية أو جانبية لمحبي الأطباق النباتية الصحية والمشبعة.\r\n\r\nصحن الفلافل يوفر لك مزيجًا غنيًا بالنكهات الشرقية التقليدية مع لمسة عصرية، ليصبح خيارك الأمثل في أي وقت. اطلبه الآن واستمتع بوجبة لذيذة مع خدمة التوصيل السريع إلى باب منزلك.', NULL, 20.00, '2025-03-29 18:34:34', '2025-03-29 18:34:34', NULL, '2000'),
(8, 'كوجك (فلافل – دجاج)', 'تذوق طعم شهي ومتنوع مع وجبات كوجك التي تمنحك الخيار بين فلافل نباتية مقرمشة أو قطع دجاج طري متبل بعناية. هذه الوجبات الصغيرة مثالية للاستمتاع بها في أي وقت، سواء كوجبة خفيفة أو سريعة. يتم تقديم كل وجبة مع الخضروات الطازجة وصلصات لذيذة لإضافة نكهة غنية لكل قضمة.\r\n\r\nاختر بين الفلافل الكلاسيكية المقرمشة أو الدجاج الطري المتبل، واستمتع بوجبة مشبعة ولذيذة، مع خدمة التوصيل السريعة إلى باب منزلك.', NULL, 21.00, '2025-03-29 18:41:07', '2025-03-29 18:41:07', NULL, NULL),
(9, 'كب يب 12 قطعة', 'استمتع بوجبة “كب يب 12 قطعة” الشهية من فلافينا، التي تجمع بين الطعم الرائع والجودة المتميزة. هذه الوجبة مثالية لمشاركتها مع العائلة أو الأصدقاء، حيث تقدم لك مجموعة متنوعة من الخيارات التي تناسب كل الأذواق. اختر بين فلافل مقرمشة ولذيذة، دجاج مشوي على الطريقة المثالية، أو المزيج المميز من فلافل ودجاج. يتم تحضير جميع الخيارات بأجود المكونات الطازجة لتضمن لك أفضل تجربة طعام.', NULL, 45.00, '2025-03-29 18:44:00', '2025-03-29 18:44:00', NULL, NULL),
(10, '(فلافل – دجاج ) فرن', 'استمتع بوجبة صحية ولذيذة مع خيارات فرن (فلافل / دجاج) التي تقدم لك طعامًا مخبوزًا في الفرن، مما يضمن لك النكهة الرائعة مع القوام المقرمش دون الحاجة للقلي. اختر بين فلافل مخبوزة لذيذة ومشبعة أو دجاج طري متبل مطهو في الفرن. هذه الوجبات ليست فقط لذيذة، بل تُعد خيارًا مثاليًا لمن يبحث عن وجبة خفيفة وصحية.\r\n\r\nكل وجبة تُقدم مع الخضروات الطازجة والصلصات التي تضيف لمسة من التميز إلى وجبتك. اختر الفرن الفلافل أو الدجاج واستمتع بنكهة مميزة تصل إلى باب منزلك.', NULL, 21.00, '2025-03-29 18:46:38', '2025-04-15 15:57:06', NULL, '10'),
(11, 'بريوش فلافل', 'استمتع بنكهات الفلافل الشهية في ساندوتش بريوش فلافل الذي يجمع بين خبز البريوش الطري وكرات الفلافل المقرمشة. يتم تقديم الساندوتش مع تشكيلة من الخضروات الطازجة مثل الخيار والطماطم، مضافًا إليها صلصة الطحينة الكريمية التي تضفي نكهة لذيذة.', 'استمتع بنكهات الفلافل الشهية في ساندوتش بريوش فلافل الذي يجمع بين خبز البريوش الطري وكرات الفلافل المقرمشة. يتم تقديم الساندوتش مع تشكيلة من الخضروات الطازجة مثل الخيار والطماطم، مضافًا إليها صلصة الطحينة الكريمية التي تضفي نكهة لذيذة.', 8.00, '2025-04-10 18:49:27', '2025-04-15 08:43:44', NULL, '4000');

-- --------------------------------------------------------

--
-- Table structure for table `product_extra`
--

CREATE TABLE `product_extra` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `extra_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_extra`
--

INSERT INTO `product_extra` (`id`, `product_id`, `extra_id`, `created_at`, `updated_at`) VALUES
(12, 5, 8, NULL, NULL),
(13, 5, 10, NULL, NULL),
(14, 5, 11, NULL, NULL),
(15, 5, 12, NULL, NULL),
(16, 5, 13, NULL, NULL),
(17, 5, 14, NULL, NULL),
(18, 5, 15, NULL, NULL),
(19, 5, 16, NULL, NULL),
(20, 6, 8, NULL, NULL),
(21, 6, 10, NULL, NULL),
(22, 6, 11, NULL, NULL),
(23, 6, 12, NULL, NULL),
(24, 6, 13, NULL, NULL),
(25, 6, 14, NULL, NULL),
(26, 6, 15, NULL, NULL),
(27, 7, 8, NULL, NULL),
(28, 7, 10, NULL, NULL),
(29, 7, 11, NULL, NULL),
(30, 7, 12, NULL, NULL),
(31, 7, 13, NULL, NULL),
(32, 7, 14, NULL, NULL),
(33, 8, 8, NULL, NULL),
(34, 8, 10, NULL, NULL),
(35, 8, 11, NULL, NULL),
(36, 8, 12, NULL, NULL),
(37, 8, 13, NULL, NULL),
(38, 8, 14, NULL, NULL),
(39, 9, 8, NULL, NULL),
(40, 9, 10, NULL, NULL),
(41, 9, 11, NULL, NULL),
(42, 9, 12, NULL, NULL),
(43, 9, 13, NULL, NULL),
(44, 9, 14, NULL, NULL),
(45, 10, 8, NULL, NULL),
(46, 10, 10, NULL, NULL),
(47, 10, 11, NULL, NULL),
(48, 10, 12, NULL, NULL),
(49, 10, 13, NULL, NULL),
(50, 10, 14, NULL, NULL),
(51, 11, 10, NULL, NULL),
(52, 11, 14, NULL, NULL),
(53, 11, 12, NULL, NULL),
(54, 11, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_package`
--

CREATE TABLE `product_package` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `product_id`, `size_id`, `price`, `created_at`, `updated_at`) VALUES
(5, 5, 6, 19.00, NULL, NULL),
(6, 5, 8, 25.00, NULL, NULL),
(7, 10, 2, 20.00, NULL, NULL),
(10, 11, 2, 8.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `product_id`, `type_id`, `created_at`, `updated_at`) VALUES
(3, 6, 1, NULL, NULL),
(4, 6, 2, NULL, NULL),
(5, 6, 4, NULL, NULL),
(6, 8, 1, NULL, NULL),
(7, 8, 2, NULL, NULL),
(8, 9, 1, NULL, NULL),
(9, 9, 2, NULL, NULL),
(10, 9, 4, NULL, NULL),
(11, 10, 1, NULL, NULL),
(12, 10, 2, NULL, NULL),
(13, 11, 2, NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','maintenance_mode') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `loyalty_points` int(11) NOT NULL DEFAULT 0,
  `delivery_fees` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `email`, `description`, `phone`, `address`, `status`, `created_at`, `updated_at`, `currency`, `loyalty_points`, `delivery_fees`) VALUES
(1, 'فلافينا', 'admin@falafina.com', 'فلافينا', '+966 53 576 9000', 'ابها ، خميس مشيط', 'active', '2025-03-24 17:28:02', '2025-04-14 11:22:45', 'ر.س', 10, '12');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `gram` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `gram`, `created_at`, `updated_at`) VALUES
(2, 'عادي', NULL, NULL, NULL),
(3, 'دوبل ', NULL, NULL, NULL),
(4, 'جامبو ', NULL, NULL, NULL),
(5, 'ميجا ', NULL, NULL, NULL),
(6, 'صغير ', NULL, NULL, NULL),
(7, 'وسط ', NULL, NULL, NULL),
(8, 'كبير ', NULL, NULL, NULL),
(9, 'عائلية ', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(4, '1', '1', '2025-03-25 03:12:37', '2025-03-25 03:12:37'),
(5, '2', '2', '2025-03-25 03:13:06', '2025-03-25 03:13:06'),
(6, '3', '3', '2025-03-25 03:13:45', '2025-03-25 03:13:45');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'فلافل', '2025-03-26 01:39:17', '2025-03-26 01:43:55'),
(2, 'دجاج', '2025-03-26 01:45:44', '2025-03-26 01:45:44'),
(4, 'ميكس', '2025-03-29 18:30:03', '2025-03-29 18:30:03');

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
  `phone` varchar(20) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`) VALUES
(1, 'User', 'new@app.com', '2025-03-21 21:43:05', '$2y$10$RcXjp1QG4NTi12WR9bg/uexCI/HriMNST553oYS9ltCqLSW4.N4.2', '11111111', 'active', 'dMesWwHxW2', '2025-03-21 21:43:05', '2025-03-21 21:43:05', NULL, NULL),
(2, 'Tara Greenfelder', 'turner.orval@example.com', '2025-03-21 21:43:07', '$2y$10$.oPmfryfJ0DZwYSXfn81fO3XzGp7UnR7dE82sX7S0B6gmT4qqa3xW', NULL, 'active', 'mYegp6ddjv', '2025-03-21 21:43:15', '2025-03-21 21:43:15', NULL, NULL),
(3, 'Karl Turner', 'uschuppe@example.com', '2025-03-21 21:43:07', '$2y$10$.oPmfryfJ0DZwYSXfn81fO3XzGp7UnR7dE82sX7S0B6gmT4qqa3xW', NULL, 'active', 'a7RSVosull', '2025-03-21 21:43:16', '2025-03-21 21:43:16', NULL, NULL),
(4, 'Stephany Miller PhD', 'dangelo86@example.com', '2025-03-21 21:43:15', '$2y$10$.oPmfryfJ0DZwYSXfn81fO3XzGp7UnR7dE82sX7S0B6gmT4qqa3xW', NULL, 'active', 'jsTB03sth2', '2025-03-21 21:43:18', '2025-03-21 21:43:18', NULL, NULL),
(5, 'Deron Halvorson', 'destiny15@example.net', '2025-03-21 21:43:15', '$2y$10$.oPmfryfJ0DZwYSXfn81fO3XzGp7UnR7dE82sX7S0B6gmT4qqa3xW', NULL, 'active', 'ytbl1R5xSg', '2025-03-21 21:43:19', '2025-03-21 21:43:19', NULL, NULL),
(6, 'Alycia Bayer MD', 'nicolette.herzog@example.org', '2025-03-21 21:43:15', '$2y$10$.oPmfryfJ0DZwYSXfn81fO3XzGp7UnR7dE82sX7S0B6gmT4qqa3xW', NULL, 'active', 'TfQKKaKiBI', '2025-03-21 21:43:21', '2025-03-21 21:43:21', NULL, NULL),
(9, 'New Name', 'new@email.com', NULL, '$2y$10$Ge6yUOA565w75wl5n.KCIuWr3wrlcgjWi6RJHFVXbK1NxTbEkelFi', '123456789', 'active', NULL, '2025-03-24 02:07:50', '2025-04-09 00:16:03', 'New First', 'New Last'),
(10, 'nameController.text', 'taherrashadtaher@gmail.com', NULL, '$2y$10$NHsFuRVUCn0VvBUdEF8Q5eGeJO/piSCUUOnhfi.u7VsKqaGI6JfpC', '050943794', 'active', NULL, '2025-04-06 13:05:23', '2025-04-06 13:05:23', 'taher', 'rashad'),
(11, 'nameController.text', 'dhdjdjdjkd@gmail.com', NULL, '$2y$10$QJ61NXSrwH2IkvfL/ViOrOUHMB3vQLm4QywsInOxQXdtW2fx97onq', '54548464', 'active', NULL, '2025-04-06 13:11:21', '2025-04-06 13:11:21', 'gaher', 'shdhdjrh'),
(12, 'nameController.text', 'fjgj@gmail.com', NULL, '$2y$10$85I7CYkd4aXH/WdjwcixQeKFl.SH87fO/fQFUZ6Bf.df.N4lbSbmu', '01000453780', 'active', NULL, '2025-04-06 20:27:47', '2025-04-06 20:27:47', 'لل', 'بب'),
(13, 'nameController.text', 'diab@gmail.com', NULL, '$2y$10$Lrqw6.SrojItOQcgnIDb7ea8prg0syrgmKj4sk6gEBEwhFx/K3Z1u', '01033088190', 'active', NULL, '2025-04-06 23:56:26', '2025-04-06 23:56:26', 'اسلام', 'دياب'),
(14, 'nameController.text', 'rainlover2021@gmail.com', NULL, '$2y$10$5jjsujb0iyK2bhWXS2jshO/pYL3FDsNQvkkDAsMR.Qzv9rqjorxB.', '01004537802', 'active', NULL, '2025-04-07 00:19:17', '2025-04-07 00:19:17', 'abdallah', 'soliman'),
(15, 'nameController.text', 'hshdhhd@gmail.com', NULL, '$2y$10$1BgCozW1hTY0moj.oCHkwexSplsB4ZlRVFzdSsCxKgTgXlnqfv4m.', '0570943794', 'active', NULL, '2025-04-07 05:46:34', '2025-04-07 05:46:34', 'Taher', 'Rashad'),
(16, 'nameController.text', 'hsjdjdjdjd@gmail.com', NULL, '$2y$10$Q.Ts4n8rP/bAcX9urFP52O68YVn/4krs2s6tZXJ8C9e4xsFi4z.1m', '846767989494', 'active', NULL, '2025-04-07 05:48:31', '2025-04-07 05:48:31', 'jdjdjdjj', 'ndjdjfjfj'),
(17, 'nameController.text', 'hshdofofjek@gmail.com', NULL, '$2y$10$NA/Mtz5c1juSgiLenbVK8eqkrMb0ATxuuosy.uz.YlwbNsBrsD0pG', '8497679794', 'active', NULL, '2025-04-07 05:51:51', '2025-04-07 05:51:51', 'hsjehdje', 'hdhdjdjrj'),
(18, 'nameController.text', 'bdjdjdkdjjdj@gmail.com', NULL, '$2y$10$uLnUVJ3g4qIjydQdmNAjwOS2/XFt6d.6yzEV2eWPX5OVI8VUwEYMG', '519498949494', 'active', NULL, '2025-04-07 06:19:14', '2025-04-07 06:19:14', 'gsjdjdj', 'dbdhdjdjf'),
(19, 'nameController.text', 'ggvyjnnnh@gmail.com', NULL, '$2y$10$mdnEW9gRsyrbVyJy6.zlU.csNn7S4aOoClAXFKArC6NZ/jKUsKoou', '570943794', 'active', NULL, '2025-04-07 07:39:48', '2025-04-07 07:39:48', 'hgujjbh', 'hhfgiikj'),
(20, 'nameController.text', 'mostafa0alii@gmail.com', NULL, '$2y$10$y9in5C3y/wbVZZgg7djSXumOTCxlBbO1U2hnmys/ZED/PHKhXgbyu', '01015558628', 'active', NULL, '2025-04-07 08:55:57', '2025-04-09 01:13:21', 'Mostafa', 'ali'),
(21, 'nameController.text', 'islam@test.com', NULL, '$2y$10$7X2VCYHXFDNtptx2n0/WTuPa5lnzQfhu.YN27KAy1NjvkO.AQaieq', '01036888187', 'active', NULL, '2025-04-07 22:22:46', '2025-04-07 22:22:46', 'اسلام', 'اسلام'),
(22, 'nameController.text', 'bdjdyehdhdhjdjrj@gmail.com', NULL, '$2y$10$iH8w8nFNn.J3rhzyORWXAO1cevzV/QHVwTcx9pbd94bFMPM6f0xy.', '8784946887', 'active', NULL, '2025-04-09 07:10:31', '2025-04-09 07:10:31', 'hshdjdjdh', 'djdjdjfb'),
(23, 'nameController.text', 'nsjdjhvfukbvggh@gmail.com', NULL, '$2y$10$SCTO4IpRsofYcGeVCbGCiuO4n8UogX1iNXxbkksD4pCqzuZlMfZoy', '976595959', 'active', NULL, '2025-04-09 07:35:37', '2025-04-09 07:35:37', 'dhdjdjdjj', 'djdjdjdjdj'),
(24, 'nameController.text', 'test@test.com', NULL, '$2y$10$yMkBMMgE0Y9WD0tm3.XLKODBTjM2Q6RqRESWu7zktIvw50ifhMzJu', '010000000000', 'active', NULL, '2025-04-10 00:05:25', '2025-04-10 00:05:25', 'te', 'st'),
(25, 'nameController.text', 'hshdjdbdhehehr@gmail.com', NULL, '$2y$10$QlG.PlsiIXClVIo1Oep3y.ut1D/KegK7Fo/lxr6EAjU1F0KpVJA1G', '057094646463794', 'active', NULL, '2025-04-10 13:26:32', '2025-04-10 13:26:32', 'Taher', 'Rashad'),
(26, 'nameController.text', 'hzhdjdjfj@gmail.com', NULL, '$2y$10$Li8MEljggJCbGOPk0yuwgOeF97/LS2KlxWD929aufMNEpbN5IZaaa', '946495949468', 'active', NULL, '2025-04-10 13:27:21', '2025-04-10 13:27:21', 'ehehddhh', 'dbdjfbdb'),
(27, 'nameController.text', 'taher.rashads@gmail.com', NULL, '$2y$10$V.XamfVsPamgIRdr8eNsLOgGg9T/lComFl0ZRSi1m3YPmJa4jknIi', '0509896661', 'active', NULL, '2025-04-10 13:29:47', '2025-04-10 13:29:47', 'Taher', 'Rashad'),
(28, 'nameController.text', 'bdbdjdjfjfjfjfjdjdjdhbdainsb@gmail.com', NULL, '$2y$10$gho0QBTadFJS56chTepcSuXIdVIVhrYrboTsV40jb2/VelUepVqkq', '49494946898', 'active', NULL, '2025-04-10 13:32:07', '2025-04-10 13:32:07', 'shdhdjdb', 'dbdbjdbd'),
(29, 'nameController.text', 'esraasalamasalama28@gmail.com', NULL, '$2y$10$wZnCFW36d8/qe1Ccco49EuLcrGNnpz9x8NJ1SHFgwJV9bDz4Hi4Ra', '05709437594', 'active', NULL, '2025-04-10 13:35:15', '2025-04-10 13:35:15', 'esraa', 'salama'),
(30, 'nameController.text', 'dbdbjdbdbdndbdbdbdbbdvjwkansb@gmail.com', NULL, '$2y$10$IFEP6NfZnNutU9qMRBn6SOgAaCnpXLG3Pr1dSdDjrmw5PGIpAOke.', '057994846484', 'active', NULL, '2025-04-10 15:08:06', '2025-04-10 15:08:06', 'dhdjdjdb', 'dbdjdbdbd'),
(31, 'nameController.text', 'bsjmshajb@gmail.com', NULL, '$2y$10$mF5oBLnqXuAGv1Q2sdmt9eWC9zx3YrJ4T7nwX7QTvVmcd1ktc9Vfy', '578049464', 'active', NULL, '2025-04-10 15:09:18', '2025-04-10 15:09:18', 'hshdbdb', 'sbbdhdjw'),
(33, 'nameController.text', 'a@g.com', NULL, '$2y$10$czLadrhw/m3wLJSivchLHuxc3EDWEf7xUXybG0wGkpPTJgZHi62uC', '01010001818', 'active', NULL, '2025-04-14 13:51:03', '2025-04-14 13:51:03', 'قعقع', 'نبنبن'),
(34, 'nameController.text', 'mhmedkhaater@maill.com', NULL, '$2y$10$CmHTwJKGuV/N.vic3NK7E.RfFvKRkuqHZBcqj2ooRpvZSPIihqKLa', '0123456789', 'active', NULL, '2025-04-14 14:16:02', '2025-04-14 14:16:02', 'mohamed', 'khater'),
(35, 'nameController.text', 'is@gmail.com', NULL, '$2y$10$w.YIfw1B5NKr8fdvzYQkKufWi9UaAHrTdeDgmc2qA7x0sm5pb7Ax.', '0000000000', 'active', NULL, '2025-04-15 03:14:43', '2025-04-15 03:14:43', 'ال', 'ال'),
(36, 'nameController.text', 'd@d.com', NULL, '$2y$10$I2hVjcEocXA4qZ8jQkY1suzFOD8H/6if3IpuHQ2FZGOPcH5GknN6e', '123321', 'active', NULL, '2025-04-15 08:44:18', '2025-04-15 08:44:18', 'd', 'd'),
(37, 'nameController.text', 'Taherjeeuehjej@gmail.com', NULL, '$2y$10$4N6XAX2uD0AHzl3s8c49M.QoQKFER/alFzKsWrjt3Ca6E6GuzOP5G', '0579484646', 'active', NULL, '2025-04-15 10:41:15', '2025-04-15 10:41:15', 'Taher', 'Rashad');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `uuid` char(36) NOT NULL,
  `bio` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `phone`, `address`, `uuid`, `bio`, `user_id`, `created_at`, `updated_at`, `street`, `city`, `area`) VALUES
(1, NULL, NULL, 'f1f85b02-9499-4562-9d9e-b612d0224a62', NULL, 1, '2025-03-21 21:43:06', '2025-03-21 21:43:06', NULL, NULL, NULL),
(2, NULL, NULL, '87669d4a-4e65-41de-b3cd-8b552ac9a338', NULL, 2, '2025-03-21 21:43:15', '2025-03-21 21:43:15', NULL, NULL, NULL),
(3, NULL, NULL, '371c9529-76bd-44f5-a2e7-a05afdb06dc0', NULL, 3, '2025-03-21 21:43:17', '2025-03-21 21:43:17', NULL, NULL, NULL),
(4, NULL, NULL, '0917bdd4-27e0-4c24-9ae8-88c11afe088e', NULL, 4, '2025-03-21 21:43:19', '2025-03-21 21:43:19', NULL, NULL, NULL),
(5, NULL, NULL, '82957f90-a658-4b53-a71e-36fd3bd17b93', NULL, 5, '2025-03-21 21:43:20', '2025-03-21 21:43:20', NULL, NULL, NULL),
(6, NULL, NULL, 'c27da787-51be-4fe8-9b7e-39f05817ce3e', NULL, 6, '2025-03-21 21:43:22', '2025-03-21 21:43:22', NULL, NULL, NULL),
(10, NULL, 'New Address', 'e5da43af-2ebd-49f3-b829-4cbdabeb8d53', 'New bio text', 9, '2025-03-24 02:07:50', '2025-04-09 00:10:44', 'New Street', 'New City', 'New Area'),
(11, NULL, '56', '0943dc51-7156-422d-ae14-af9a0924758a', NULL, 10, '2025-04-06 13:05:23', '2025-04-06 13:05:23', NULL, 'خميس مشيط', 'عسير'),
(12, NULL, '56', 'b1fc10e1-3228-41e1-be3e-d762c4d45517', NULL, 11, '2025-04-06 13:11:21', '2025-04-06 13:11:21', NULL, 'jdbdjdj', 'hehridjd'),
(13, NULL, '8', '82439d8e-5ca7-4085-81d2-907df55db6df', NULL, 12, '2025-04-06 20:27:47', '2025-04-06 20:27:47', '0', 'الرياض', 'الحس الاول'),
(14, NULL, 'رقم', 'd89fc1b6-f6ad-4cd3-a21e-3269e573f18f', NULL, 13, '2025-04-06 23:56:26', '2025-04-06 23:56:26', 'رقم', 'مدينة', 'منطقة'),
(15, NULL, 'hh', 'b6350b76-078d-4009-aefc-61f29379f8e2', NULL, 14, '2025-04-07 00:19:17', '2025-04-07 00:19:17', 'hh', 'hh', 'hh'),
(16, NULL, '45', '0036d4b5-1524-4981-b5e8-4c69575cb63f', NULL, 15, '2025-04-07 05:46:34', '2025-04-07 05:46:34', NULL, 'khakis', 'asser'),
(17, NULL, 'hehdjd', 'fead4989-c54d-4465-be42-d01d41645ca0', NULL, 16, '2025-04-07 05:48:31', '2025-04-07 05:48:31', 'ehdjdjf', 'udjdjdhd', 'dhhdjfndnd'),
(18, NULL, 'hdjdjdhd', 'b6204743-bc97-41b5-8144-401ad328c135', NULL, 17, '2025-04-07 05:51:51', '2025-04-07 05:51:51', 'dbdbdbdn', 'hdjdhdndn', 'hdjdjdjfj'),
(19, NULL, 'dhdbd', '9f050972-08fc-4f54-a937-1ee9414e8004', NULL, 18, '2025-04-07 06:19:14', '2025-04-07 06:19:14', NULL, 'bxjdjd', 'hdhehejdh'),
(20, NULL, 'hvgjjb', '55fd1dc6-5f02-4c12-94a5-85f58a9212f9', NULL, 19, '2025-04-07 07:39:48', '2025-04-07 07:39:48', NULL, 'bvukbvv', 'vchijbv'),
(21, NULL, 'ssssss', '118147f3-4339-4faa-a0c7-669ba6cc5ded', NULL, 20, '2025-04-07 08:55:57', '2025-04-07 08:55:57', 'ssssss', 'ggggggg', 'eeeeeeeer'),
(22, NULL, 'ggg', '0fee337b-13a0-4374-b57a-08de6bf0556a', NULL, 21, '2025-04-07 22:22:46', '2025-04-07 22:22:46', 'ggv', 'vvvvv', 'vvvvv'),
(23, NULL, 'hsjdhddbdbb', '356f88a0-ce54-4a88-9846-9a941c9cc3b8', NULL, 22, '2025-04-09 07:10:31', '2025-04-09 07:10:31', NULL, 'djdjdnfbrb', 'hdjdjdnfb'),
(24, NULL, 'hdjdjdhd', '21bd6e3e-9e00-4bab-9b76-08445cce2a1d', NULL, 23, '2025-04-09 07:35:37', '2025-04-09 07:35:37', 'dhdudjdn', 'dhrjdnndnd', 'dhdididjdj'),
(25, NULL, 'bbb', 'bfeb1847-1204-42c0-b5e5-ed087af69857', NULL, 24, '2025-04-10 00:05:25', '2025-04-10 00:05:25', 'bb', 'bbbb', 'nbbb'),
(26, NULL, 'gsjdjd', '27004159-71d5-46ba-850a-e445f0e2d054', NULL, 25, '2025-04-10 13:26:32', '2025-04-10 13:26:32', 'dbdbfbdbd', 'dbdbfbd', 'bdjdjfjf'),
(27, NULL, 'hshdbdbd', '351f8ad9-73f6-45a5-b0fa-94186904a19c', NULL, 26, '2025-04-10 13:27:21', '2025-04-10 13:27:21', 'hdbdbdbdhd', 'dbdbfjfndbf', 'dhdbfbdbdb'),
(28, NULL, 'khamis', '3064e280-e204-4d96-8efa-cb7917345c0c', NULL, 27, '2025-04-10 13:29:47', '2025-04-10 13:29:47', 'hehehe', 'ejdjfjdbd', 'jrjejenrn'),
(29, NULL, 'hehdbdbd', 'f9588690-92c1-4df8-9cc1-970be9776124', NULL, 28, '2025-04-10 13:32:08', '2025-04-10 13:32:08', 'bdbdbdbdh', 'dbbddbbdhdb', 'dbdbdidndbdb'),
(30, NULL, '56', 'b8c07c42-297e-4d33-a865-292a496d4b1b', NULL, 29, '2025-04-10 13:35:15', '2025-04-10 13:35:15', NULL, 'khamis', 'aseer'),
(31, NULL, 'hsbdbdbd', '99fbee69-a8a9-4f16-983a-7cca8fc95c30', NULL, 30, '2025-04-10 15:08:06', '2025-04-10 15:08:06', 'dhdbdbdjd', 'bdbdkskbb', 'hsjdieko'),
(32, NULL, 'hsjdbd', '77e083e9-48e5-4fde-b115-cbb6f706cb54', NULL, 31, '2025-04-10 15:09:18', '2025-04-10 15:09:18', 'bsbdbd', 'dbshbdbd', 'bdjdjdnd'),
(34, NULL, 'تبت', 'fd5ba829-e4d3-4ceb-8c2a-1c583be38a81', NULL, 33, '2025-04-14 13:51:03', '2025-04-14 13:51:03', 'نلمل', 'نفنفن', 'ققققو'),
(35, NULL, 'vhbdf', 'a9dde1fb-25af-4241-9963-c517191f0545', NULL, 34, '2025-04-14 14:16:02', '2025-04-14 14:16:02', 'vfh', 'ch', 'vf'),
(36, NULL, 'ننننن', '2992af2b-3498-4341-bb70-1bade6c61a21', NULL, 35, '2025-04-15 03:14:43', '2025-04-15 03:14:43', 'مننمم', 'نننن', 'ممنمم'),
(37, NULL, 'd', '285c0972-2dda-42f7-b040-222c90fb6b78', NULL, 36, '2025-04-15 08:44:18', '2025-04-15 08:44:18', 'd', 'd', 'd'),
(38, NULL, 'hwhs', 'd0681e5b-9dfc-466a-b09d-8cc69d331e39', NULL, 37, '2025-04-15 10:41:15', '2025-04-15 10:41:15', NULL, 'hehehe', 'euejeje');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_profiles_uuid_unique` (`uuid`),
  ADD KEY `admin_profiles_admin_id_index` (`admin_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `category_products`
--
ALTER TABLE `category_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_products_category_id_foreign` (`category_id`),
  ADD KEY `category_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `extras_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `managers_email_unique` (`email`),
  ADD UNIQUE KEY `managers_phone_unique` (`phone`),
  ADD KEY `managers_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_mediable_type_mediable_id_index` (`mediable_type`,`mediable_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_product_details`
--
ALTER TABLE `order_product_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_details_order_id_foreign` (`order_id`),
  ADD KEY `order_product_details_product_id_foreign` (`product_id`),
  ADD KEY `order_product_details_order_product_id_foreign` (`order_product_id`),
  ADD KEY `order_product_details_size_id_foreign` (`size_id`),
  ADD KEY `order_product_details_type_id_foreign` (`type_id`);

--
-- Indexes for table `order_product_extras`
--
ALTER TABLE `order_product_extras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_extras_order_product_id_foreign` (`order_product_id`),
  ADD KEY `order_product_extras_extra_id_foreign` (`extra_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_extra`
--
ALTER TABLE `product_extra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_extra_product_id_foreign` (`product_id`),
  ADD KEY `product_extra_extra_id_foreign` (`extra_id`);

--
-- Indexes for table `product_package`
--
ALTER TABLE `product_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_package_product_id_foreign` (`product_id`),
  ADD KEY `product_package_package_id_foreign` (`package_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_size_product_id_foreign` (`product_id`),
  ADD KEY `product_size_size_id_foreign` (`size_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_type_product_id_foreign` (`product_id`),
  ADD KEY `product_type_type_id_foreign` (`type_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_email_unique` (`email`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `types_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_uuid_unique` (`uuid`),
  ADD KEY `user_profiles_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `category_products`
--
ALTER TABLE `category_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `order_product_details`
--
ALTER TABLE `order_product_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `order_product_extras`
--
ALTER TABLE `order_product_extras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_extra`
--
ALTER TABLE `product_extra`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_package`
--
ALTER TABLE `product_package`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_profiles`
--
ALTER TABLE `admin_profiles`
  ADD CONSTRAINT `admin_profiles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `category_products`
--
ALTER TABLE `category_products`
  ADD CONSTRAINT `category_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `managers`
--
ALTER TABLE `managers`
  ADD CONSTRAINT `managers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_product_details`
--
ALTER TABLE `order_product_details`
  ADD CONSTRAINT `order_product_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_details_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_details_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_product_details_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_product_extras`
--
ALTER TABLE `order_product_extras`
  ADD CONSTRAINT `order_product_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_extras_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_extra`
--
ALTER TABLE `product_extra`
  ADD CONSTRAINT `product_extra_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_extra_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_package`
--
ALTER TABLE `product_package`
  ADD CONSTRAINT `product_package_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_package_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_type`
--
ALTER TABLE `product_type`
  ADD CONSTRAINT `product_type_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_type_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
