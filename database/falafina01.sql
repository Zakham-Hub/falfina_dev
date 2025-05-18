-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table falafina01.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_password_status` tinyint(1) NOT NULL DEFAULT '0',
  `link_password_protection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('admin','supervisor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.admins: ~5 rows (approximately)
INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `link_password_status`, `link_password_protection`, `phone`, `status`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Mostafa', 'admin@app.com', NULL, '$2y$10$Y9SJhmciJVl9FyjlYMrI4u/M55YwBCWDs48SpAXUYqUS4Q/LeSf7C', 1, '$2y$10$Y9SJhmciJVl9FyjlYMrI4u/M55YwBCWDs48SpAXUYqUS4Q/LeSf7C', NULL, 'active', 'admin', 'jg2lhxRN8HvIIS2f471yuqk0h73u2GWrgw2aLMBJESYxKuE2ffXezGB6bZLf', '2025-03-21 21:43:23', '2025-03-21 21:43:23'),
	(2, 'Hesham', 'mm@app.com', NULL, '$2y$10$CLFMEIu2V2Jivaqi2lq2H.MUOLnUwBjXLflxxO/kVBNgBmL.qNa4W', 0, NULL, NULL, 'active', 'supervisor', 'RrS0IgCKOg', '2025-03-21 21:43:29', '2025-04-10 13:37:37'),
	(3, 'abdallah', 'abdallah@falafina.com', NULL, '$2y$10$QGsM4azSUf1kR7AyhGuYP.LCyKlp.RfqB0VnTu7hWJqGCKFV2iDuS', 0, NULL, '01233445', 'active', 'supervisor', NULL, '2025-04-15 10:32:05', '2025-04-15 10:32:05'),
	(4, 'qqqq', 'support@gmail.com', NULL, '$2y$10$5CYc2tSEHGVvkbFxAFUCle0h2gEC98RxDu1BqjegB4K6YhWcN/nja', 1, '123123', '11111111111111111', 'active', 'admin', NULL, '2025-04-18 20:27:42', '2025-04-18 20:27:42'),
	(5, '2qqqqqqqq', 'admin@admin.com', NULL, '$2y$10$h/bfoheLFOOLaStwm1mOwOAXJ5NeFmw.GxziKp6/GwXexXQaxUasm', 1, '$2y$10$F6n4kr79Wy/Uq7BEZg27dusf9DA8XZSMEwBf.MAGFr3mIW/.tsQOy', '11111111111111111', 'active', 'admin', NULL, '2025-04-18 20:29:50', '2025-04-18 20:29:50');

-- Dumping structure for table falafina01.admin_profiles
CREATE TABLE IF NOT EXISTS `admin_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_profiles_uuid_unique` (`uuid`),
  KEY `admin_profiles_admin_id_index` (`admin_id`),
  CONSTRAINT `admin_profiles_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.admin_profiles: ~5 rows (approximately)
INSERT INTO `admin_profiles` (`id`, `uuid`, `bio`, `admin_id`, `created_at`, `updated_at`) VALUES
	(1, 'ca77a4fb-b9dd-4618-be43-6b6b15f018d3', NULL, 1, '2025-03-21 21:43:24', '2025-03-21 21:43:24'),
	(2, '43ec6e26-adb8-4245-b5aa-8462e579fb5f', NULL, 2, '2025-03-21 21:43:29', '2025-03-21 21:43:29'),
	(3, '06c75e63-3a6c-4138-aacc-1d86315a5cb9', NULL, 3, '2025-04-15 10:32:05', '2025-04-15 10:32:05'),
	(4, '5cb6fdc2-60c5-4f96-b9b7-1feb82b37550', NULL, 4, '2025-04-18 20:27:43', '2025-04-18 20:27:43'),
	(5, '707c9791-7aaa-46f3-82fc-db45c9b13a3d', NULL, 5, '2025-04-18 20:29:50', '2025-04-18 20:29:50');

-- Dumping structure for table falafina01.branches
CREATE TABLE IF NOT EXISTS `branches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.branches: ~3 rows (approximately)
INSERT INTO `branches` (`id`, `name`, `latitude`, `longitude`, `phone`, `status`, `created_at`, `updated_at`, `address`) VALUES
	(7, 'فلافينا', 18.3000000, 42.7333330, NULL, 'active', '2025-03-23 21:12:01', '2025-03-23 21:12:01', 'خميس مشيط, محافظة خميس مشيط, منطقة عسير, 62411, السعودية'),
	(8, 'فلافينا طريق الميه', 18.2393267, 42.6828016, NULL, 'active', '2025-03-23 21:28:54', '2025-03-23 21:28:54', 'طريق الأمير سلطان, خميس مشيط, محافظة خميس مشيط, منطقة عسير, 61321, السعودية'),
	(9, 'فلافينا موجان بارك', 26.2948117, 50.1858119, '55555555', 'active', '2025-03-23 21:31:45', '2025-04-20 16:33:31', 'EKJA2588، 2588 الشارع الثاني والعشرون، 7349، العقربية، الخبر 34445، السعودية');

-- Dumping structure for table falafina01.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.categories: ~9 rows (approximately)
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

-- Dumping structure for table falafina01.category_products
CREATE TABLE IF NOT EXISTS `category_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_products_category_id_foreign` (`category_id`),
  KEY `category_products_product_id_foreign` (`product_id`),
  CONSTRAINT `category_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.category_products: ~8 rows (approximately)
INSERT INTO `category_products` (`id`, `category_id`, `product_id`, `created_at`, `updated_at`) VALUES
	(4, 8, 5, NULL, NULL),
	(5, 12, 6, NULL, NULL),
	(6, 10, 7, NULL, NULL),
	(7, 15, 7, NULL, NULL),
	(8, 14, 8, NULL, NULL),
	(9, 13, 9, NULL, NULL),
	(10, 9, 10, NULL, NULL),
	(11, 9, 11, NULL, NULL);

-- Dumping structure for table falafina01.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.coupons: ~1 rows (approximately)
INSERT INTO `coupons` (`id`, `name`, `type`, `percentage`, `from`, `to`, `amount`, `status`, `created_at`, `updated_at`) VALUES
	(4, 'Howard Sharp', 'Autem earum et quis', 'Voluptate quibusdam', '2025-04-09', '2025-04-12', 'Est iusto non tempor', 'active', '2025-04-09 02:49:56', '2025-04-09 02:49:56');

-- Dumping structure for table falafina01.extras
CREATE TABLE IF NOT EXISTS `extras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('sauce','addon') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extras_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.extras: ~8 rows (approximately)
INSERT INTO `extras` (`id`, `name`, `price`, `type`, `created_at`, `updated_at`) VALUES
	(8, 'بطاطس', '6', 'addon', '2025-03-25 22:21:08', '2025-03-25 23:26:11'),
	(10, 'صوص حار', '2', 'sauce', '2025-03-25 23:51:14', '2025-03-25 23:51:14'),
	(11, 'مشروب غازى', '4', 'addon', '2025-03-29 02:32:12', '2025-03-29 02:32:12'),
	(12, 'عصير الربيع', '3', 'addon', '2025-03-29 02:32:58', '2025-03-29 02:32:58'),
	(13, 'حمص', '8', 'addon', '2025-03-29 02:33:44', '2025-03-29 02:33:44'),
	(14, 'صوص عادى', '2', 'sauce', '2025-03-29 02:35:15', '2025-03-29 02:35:15'),
	(15, 'طحينه', '1', 'sauce', '2025-03-29 02:35:49', '2025-03-29 02:35:49'),
	(16, 'شطه شاميه1', '2', 'addon', '2025-03-29 02:36:26', '2025-04-20 18:15:39');

-- Dumping structure for table falafina01.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table falafina01.histories
CREATE TABLE IF NOT EXISTS `histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `historyable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `historyable_id` bigint unsigned NOT NULL,
  `changed_column` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `change_value_from` text COLLATE utf8mb4_unicode_ci,
  `change_value_to` text COLLATE utf8mb4_unicode_ci,
  `admin_id` bigint unsigned DEFAULT NULL,
  `manager_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `histories_historyable_type_historyable_id_index` (`historyable_type`,`historyable_id`),
  KEY `histories_admin_id_foreign` (`admin_id`),
  KEY `histories_manager_id_foreign` (`manager_id`),
  KEY `histories_user_id_foreign` (`user_id`),
  CONSTRAINT `histories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  CONSTRAINT `histories_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.histories: ~12 rows (approximately)
INSERT INTO `histories` (`id`, `historyable_type`, `historyable_id`, `changed_column`, `change_value_from`, `change_value_to`, `admin_id`, `manager_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\Order', 205, 'status', 'completed', 'canceled', 1, NULL, NULL, '2025-04-20 13:25:41', '2025-04-20 13:25:41'),
	(2, 'App\\Models\\Order', 205, 'status', 'canceled', 'completed', 1, NULL, NULL, '2025-04-20 13:27:03', '2025-04-20 13:27:03'),
	(3, 'App\\Models\\Order', 205, 'status', 'completed', 'canceled', NULL, 2, NULL, '2025-04-20 14:33:47', '2025-04-20 14:33:47'),
	(4, 'App\\Models\\Order', 203, 'status', 'pending', 'canceled', NULL, 2, NULL, '2025-04-20 14:39:30', '2025-04-20 14:39:30'),
	(5, 'App\\Models\\Extra', 16, 'name', 'شطه شاميه', 'شطه شاميه1', 1, NULL, NULL, '2025-04-20 14:44:20', '2025-04-20 14:44:20'),
	(6, 'App\\Models\\Extra', 16, 'price', '1', '2', 1, NULL, NULL, '2025-04-20 14:44:20', '2025-04-20 14:44:20'),
	(7, 'App\\Models\\Order', 206, 'total_price', '0', '134', NULL, NULL, 2, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(8, 'App\\Models\\Order', 207, 'total_price', '0', '134', NULL, NULL, 2, '2025-04-20 16:42:10', '2025-04-20 16:42:10'),
	(9, 'App\\Models\\Order', 207, 'status', 'pending', 'completed', 1, NULL, NULL, '2025-04-20 17:14:47', '2025-04-20 17:14:47'),
	(10, 'App\\Models\\Order', 206, 'status', 'pending', 'completed', 1, NULL, NULL, '2025-04-20 18:14:39', '2025-04-20 18:14:39'),
	(11, 'App\\Models\\Order', 205, 'status', 'canceled', 'delivered', 1, NULL, NULL, '2025-04-20 18:14:55', '2025-04-20 18:14:55'),
	(12, 'App\\Models\\Extra', 16, 'type', 'sauce', 'addon', 1, NULL, NULL, '2025-04-20 18:15:39', '2025-04-20 18:15:39');

-- Dumping structure for table falafina01.managers
CREATE TABLE IF NOT EXISTS `managers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `branch_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `managers_email_unique` (`email`),
  UNIQUE KEY `managers_phone_unique` (`phone`),
  KEY `managers_branch_id_foreign` (`branch_id`),
  CONSTRAINT `managers_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.managers: ~3 rows (approximately)
INSERT INTO `managers` (`id`, `name`, `email`, `password`, `phone`, `status`, `branch_id`, `created_at`, `updated_at`) VALUES
	(2, 'مصطفى', 'mm@moderator.com', '$2y$10$Y9SJhmciJVl9FyjlYMrI4u/M55YwBCWDs48SpAXUYqUS4Q/LeSf7C', '+1 (177) 649-7352', 'active', 7, '2025-03-30 20:06:41', '2025-04-09 14:24:36'),
	(3, 'Doris Benjamin', 'rymuzotoz@mailinator.com', '$2y$10$APi0SaRevLRMBteFR1yXzeQ6jfQeBEgS4HWjjXD0.PYf/37dS2bGS', '+1 (855) 518-8782', 'active', 9, '2025-04-16 11:22:14', '2025-04-16 11:22:14'),
	(4, 'Yardley Shepard', 'zyfa@mailinator.com', '$10$Y9SJhmciJVl9FyjlYMrI4u/M55YwBCWDs48SpAXUYqUS4Q/LeSf7C', '+1 (916) 708-2849', 'active', 8, '2025-04-16 11:22:45', '2025-04-16 11:22:45');

-- Dumping structure for table falafina01.media
CREATE TABLE IF NOT EXISTS `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mediable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediable_id` bigint unsigned NOT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_mediable_type_mediable_id_index` (`mediable_type`,`mediable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.media: ~30 rows (approximately)
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
	(68, 'App\\Models\\Extra', 11, 'extra', '5a1a8f7ed7af5d3600c8ac0d24761a4c.png', 'root', '2025-04-16 07:52:09', '2025-04-16 07:52:09'),
	(69, 'App\\Models\\Setting', 1, 'alarm_audio', '68cd878285b97292add03805e2639e2e.wav', 'root', '2025-04-17 01:47:18', '2025-04-17 01:47:18');

-- Dumping structure for table falafina01.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.migrations: ~47 rows (approximately)
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
	(46, '2025_04_14_105347_add_delivery_fees_settings_table', 20),
	(47, '2025_04_17_232404_add_version_to_settings_table', 21),
	(48, '2025_04_18_133757_add_desc_to_packages_table', 21),
	(49, '2025_04_18_220733_add_link_password_protection_to_admins_table', 21),
	(50, '2025_04_20_151215_create_histories_table', 22);

-- Dumping structure for table falafina01.oauth_access_tokens
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.oauth_access_tokens: ~0 rows (approximately)

-- Dumping structure for table falafina01.oauth_auth_codes
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.oauth_auth_codes: ~0 rows (approximately)

-- Dumping structure for table falafina01.oauth_clients
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.oauth_clients: ~0 rows (approximately)

-- Dumping structure for table falafina01.oauth_personal_access_clients
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.oauth_personal_access_clients: ~0 rows (approximately)

-- Dumping structure for table falafina01.oauth_refresh_tokens
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.oauth_refresh_tokens: ~0 rows (approximately)

-- Dumping structure for table falafina01.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `branch_id` bigint unsigned DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','canceled','preparing','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `order_location` longtext COLLATE utf8mb4_unicode_ci,
  `is_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_branch_id_foreign` (`branch_id`),
  CONSTRAINT `orders_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.orders: ~30 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `branch_id`, `payment_status`, `payment_type`, `order_number`, `status`, `total_price`, `order_location`, `is_delivery`, `created_at`, `updated_at`) VALUES
	(22, 9, 7, NULL, NULL, '', 'delivered', 76.00, 'aaaaaaaa', 0, '2025-03-31 04:07:52', '2025-04-18 18:22:18'),
	(27, 9, 8, NULL, NULL, '', 'completed', 83.00, NULL, 0, '2025-04-04 21:38:56', '2025-04-18 18:22:04'),
	(28, 9, 9, NULL, NULL, '', 'canceled', 83.00, NULL, 0, '2025-04-04 21:39:33', '2025-04-18 17:55:32'),
	(181, 2, 7, 'unpaid', 'loyalty_point_with_payment', '2958', 'preparing', 20.00, 'xxxxxxxxxxxxx', 0, '2025-04-18 18:06:36', '2025-04-18 18:21:24'),
	(182, 1, 7, NULL, NULL, '5006', 'pending', 134.00, NULL, 0, '2025-04-19 04:29:05', '2025-04-19 04:29:06'),
	(183, 1, 7, NULL, NULL, '1228', 'pending', 134.00, NULL, 0, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(184, 1, 7, NULL, NULL, '1449', 'pending', 134.00, NULL, 0, '2025-04-20 08:24:44', '2025-04-20 08:24:45'),
	(185, 1, 7, NULL, NULL, '9309', 'pending', 134.00, NULL, 0, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(186, 1, 7, NULL, NULL, '7336', 'pending', 134.00, NULL, 0, '2025-04-20 09:34:11', '2025-04-20 09:34:12'),
	(187, 1, 7, NULL, NULL, '1959', 'pending', 134.00, NULL, 0, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(188, 1, 7, NULL, NULL, '6927', 'pending', 134.00, NULL, 0, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(189, 1, 7, NULL, NULL, '5984', 'pending', 134.00, NULL, 0, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(190, 1, 7, NULL, NULL, '1884', 'pending', 134.00, NULL, 0, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(191, 1, 7, NULL, NULL, '6987', 'pending', 134.00, NULL, 0, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(192, 1, 7, NULL, NULL, '8645', 'pending', 134.00, NULL, 0, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(193, 1, 7, NULL, NULL, '5255', 'pending', 134.00, NULL, 0, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(194, 2, 7, NULL, NULL, '1614', 'pending', 134.00, NULL, 0, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(195, 2, 7, NULL, NULL, '6605', 'pending', 134.00, NULL, 0, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(196, 2, 7, NULL, NULL, '3906', 'pending', 134.00, NULL, 0, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(197, 2, 7, NULL, NULL, '4867', 'pending', 134.00, NULL, 0, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(198, 2, 7, NULL, NULL, '5756', 'pending', 134.00, NULL, 0, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(199, 2, 7, NULL, NULL, '2197', 'pending', 134.00, NULL, 0, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(200, 2, 7, NULL, NULL, '7655', 'pending', 134.00, NULL, 0, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(201, 2, 7, NULL, NULL, '3890', 'pending', 134.00, NULL, 0, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(202, 2, 7, NULL, NULL, '3073', 'pending', 134.00, NULL, 0, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(203, 2, 7, NULL, NULL, '7671', 'canceled', 134.00, NULL, 0, '2025-04-20 10:21:06', '2025-04-20 14:39:30'),
	(204, 2, 7, NULL, NULL, '3171', 'pending', 134.00, NULL, 0, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(205, 2, 7, NULL, NULL, '1273', 'delivered', 134.00, NULL, 0, '2025-04-20 13:01:25', '2025-04-20 18:14:55'),
	(206, 2, 7, NULL, NULL, '1469', 'completed', 134.00, NULL, 0, '2025-04-20 16:35:59', '2025-04-20 18:14:39'),
	(207, 2, 7, NULL, 'loyalty_point_with_payment', '3934', 'completed', 134.00, 'https://www.google.pl/maps/place/%D8%A7%D9%8A%D8%AA%D9%88%D8%A7%D9%84+%D9%81%D8%B1%D8%B9+%D9%81%D9%8A%D8%B5%D9%84%E2%80%AD/@29.9958272,31.1918592,14z/data=!4m6!3m5!1s0x1458471235da753b:0xdee0260283c6e416!8m2!3d30.0112605!4d31.1926974!16s%2Fg%2F11h8fnqn5b?entry=ttu&g_ep=EgoyMDI1MDQxNi4xIKXMDSoJLDEwMjExNDUzSAFQAw%3D%3D', 1, '2025-04-20 16:42:10', '2025-04-20 18:11:04');

-- Dumping structure for table falafina01.order_product
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_order_id_foreign` (`order_id`),
  KEY `order_product_product_id_foreign` (`product_id`),
  CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.order_product: ~56 rows (approximately)
INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(23, 27, 5, 2, 38.00, NULL, NULL),
	(24, 28, 5, 2, 38.00, NULL, NULL),
	(292, 22, 5, 2, 38.00, NULL, NULL),
	(299, 181, 7, 1, 20.00, NULL, NULL),
	(300, 182, 5, 1, 19.00, NULL, NULL),
	(301, 182, 6, 1, 56.00, NULL, NULL),
	(302, 183, 5, 1, 19.00, NULL, NULL),
	(303, 183, 6, 1, 56.00, NULL, NULL),
	(304, 184, 5, 1, 19.00, NULL, NULL),
	(305, 184, 6, 1, 56.00, NULL, NULL),
	(306, 185, 5, 1, 19.00, NULL, NULL),
	(307, 185, 6, 1, 56.00, NULL, NULL),
	(308, 186, 5, 1, 19.00, NULL, NULL),
	(309, 186, 6, 1, 56.00, NULL, NULL),
	(310, 187, 5, 1, 19.00, NULL, NULL),
	(311, 187, 6, 1, 56.00, NULL, NULL),
	(312, 188, 5, 1, 19.00, NULL, NULL),
	(313, 188, 6, 1, 56.00, NULL, NULL),
	(314, 189, 5, 1, 19.00, NULL, NULL),
	(315, 189, 6, 1, 56.00, NULL, NULL),
	(316, 190, 5, 1, 19.00, NULL, NULL),
	(317, 190, 6, 1, 56.00, NULL, NULL),
	(318, 191, 5, 1, 19.00, NULL, NULL),
	(319, 191, 6, 1, 56.00, NULL, NULL),
	(320, 192, 5, 1, 19.00, NULL, NULL),
	(321, 192, 6, 1, 56.00, NULL, NULL),
	(322, 193, 5, 1, 19.00, NULL, NULL),
	(323, 193, 6, 1, 56.00, NULL, NULL),
	(324, 194, 5, 1, 19.00, NULL, NULL),
	(325, 194, 6, 1, 56.00, NULL, NULL),
	(326, 195, 5, 1, 19.00, NULL, NULL),
	(327, 195, 6, 1, 56.00, NULL, NULL),
	(328, 196, 5, 1, 19.00, NULL, NULL),
	(329, 196, 6, 1, 56.00, NULL, NULL),
	(330, 197, 5, 1, 19.00, NULL, NULL),
	(331, 197, 6, 1, 56.00, NULL, NULL),
	(332, 198, 5, 1, 19.00, NULL, NULL),
	(333, 198, 6, 1, 56.00, NULL, NULL),
	(334, 199, 5, 1, 19.00, NULL, NULL),
	(335, 199, 6, 1, 56.00, NULL, NULL),
	(336, 200, 5, 1, 19.00, NULL, NULL),
	(337, 200, 6, 1, 56.00, NULL, NULL),
	(338, 201, 5, 1, 19.00, NULL, NULL),
	(339, 201, 6, 1, 56.00, NULL, NULL),
	(340, 202, 5, 1, 19.00, NULL, NULL),
	(341, 202, 6, 1, 56.00, NULL, NULL),
	(342, 203, 5, 1, 19.00, NULL, NULL),
	(343, 203, 6, 1, 56.00, NULL, NULL),
	(344, 204, 5, 1, 19.00, NULL, NULL),
	(345, 204, 6, 1, 56.00, NULL, NULL),
	(346, 205, 5, 1, 19.00, NULL, NULL),
	(347, 205, 6, 1, 56.00, NULL, NULL),
	(348, 206, 5, 1, 19.00, NULL, NULL),
	(349, 206, 6, 1, 56.00, NULL, NULL),
	(350, 207, 5, 1, 19.00, NULL, NULL),
	(351, 207, 6, 1, 56.00, NULL, NULL);

-- Dumping structure for table falafina01.order_product_details
CREATE TABLE IF NOT EXISTS `order_product_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `order_product_id` bigint unsigned DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `type_id` bigint unsigned DEFAULT NULL,
  `size_price` decimal(10,2) DEFAULT NULL,
  `type_price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_details_order_id_foreign` (`order_id`),
  KEY `order_product_details_product_id_foreign` (`product_id`),
  KEY `order_product_details_order_product_id_foreign` (`order_product_id`),
  KEY `order_product_details_size_id_foreign` (`size_id`),
  KEY `order_product_details_type_id_foreign` (`type_id`),
  CONSTRAINT `order_product_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_details_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_details_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_product_details_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.order_product_details: ~55 rows (approximately)
INSERT INTO `order_product_details` (`id`, `order_id`, `product_id`, `order_product_id`, `size_id`, `type_id`, `size_price`, `type_price`, `created_at`, `updated_at`) VALUES
	(19, 27, 5, 23, 5, 2, 15.50, 4.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
	(20, 28, 5, 24, 5, 2, 15.50, 2.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
	(285, 181, 7, 299, 6, 2, 4.00, 3.00, '2025-04-18 18:06:36', '2025-04-18 18:06:36'),
	(286, 182, 5, 300, 5, 2, 15.50, 0.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(287, 182, 6, 301, 5, 2, 15.50, 0.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(288, 183, 5, 302, 5, 2, 15.50, 0.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(289, 183, 6, 303, 5, 2, 15.50, 0.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(290, 184, 5, 304, 5, 2, 15.50, 0.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(291, 184, 6, 305, 5, 2, 15.50, 0.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(292, 185, 5, 306, 5, 2, 15.50, 0.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(293, 185, 6, 307, 5, 2, 15.50, 0.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(294, 186, 5, 308, 5, 2, 15.50, 0.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(295, 186, 6, 309, 5, 2, 15.50, 0.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(296, 187, 5, 310, 5, 2, 15.50, 0.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(297, 187, 6, 311, 5, 2, 15.50, 0.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(298, 188, 5, 312, 5, 2, 15.50, 0.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(299, 188, 6, 313, 5, 2, 15.50, 0.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(300, 189, 5, 314, 5, 2, 15.50, 0.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(301, 189, 6, 315, 5, 2, 15.50, 0.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(302, 190, 5, 316, 5, 2, 15.50, 0.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(303, 190, 6, 317, 5, 2, 15.50, 0.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(304, 191, 5, 318, 5, 2, 15.50, 0.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(305, 191, 6, 319, 5, 2, 15.50, 0.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(306, 192, 5, 320, 5, 2, 15.50, 0.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(307, 192, 6, 321, 5, 2, 15.50, 0.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(308, 193, 5, 322, 5, 2, 15.50, 0.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(309, 193, 6, 323, 5, 2, 15.50, 0.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(310, 194, 5, 324, 5, 2, 15.50, 0.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(311, 194, 6, 325, 5, 2, 15.50, 0.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(312, 195, 5, 326, 5, 2, 15.50, 0.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(313, 195, 6, 327, 5, 2, 15.50, 0.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(314, 196, 5, 328, 5, 2, 15.50, 0.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(315, 196, 6, 329, 5, 2, 15.50, 0.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(316, 197, 5, 330, 5, 2, 15.50, 0.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(317, 197, 6, 331, 5, 2, 15.50, 0.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(318, 198, 5, 332, 5, 2, 15.50, 0.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(319, 198, 6, 333, 5, 2, 15.50, 0.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(320, 199, 5, 334, 5, 2, 15.50, 0.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(321, 199, 6, 335, 5, 2, 15.50, 0.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(322, 200, 5, 336, 5, 2, 15.50, 0.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(323, 200, 6, 337, 5, 2, 15.50, 0.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(324, 201, 5, 338, 5, 2, 15.50, 0.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(325, 201, 6, 339, 5, 2, 15.50, 0.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(326, 202, 5, 340, 5, 2, 15.50, 0.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(327, 202, 6, 341, 5, 2, 15.50, 0.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(328, 203, 5, 342, 5, 2, 15.50, 0.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(329, 203, 6, 343, 5, 2, 15.50, 0.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(330, 204, 5, 344, 5, 2, 15.50, 0.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(331, 204, 6, 345, 5, 2, 15.50, 0.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(332, 205, 5, 346, 5, 2, 15.50, 0.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(333, 205, 6, 347, 5, 2, 15.50, 0.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(334, 206, 5, 348, 5, 2, 15.50, 0.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(335, 206, 6, 349, 5, 2, 15.50, 0.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(336, 207, 5, 350, 5, 2, 15.50, 0.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10'),
	(337, 207, 6, 351, 5, 2, 15.50, 0.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10');

-- Dumping structure for table falafina01.order_product_extras
CREATE TABLE IF NOT EXISTS `order_product_extras` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_product_id` bigint unsigned DEFAULT NULL,
  `extra_id` bigint unsigned DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_extras_order_product_id_foreign` (`order_product_id`),
  KEY `order_product_extras_extra_id_foreign` (`extra_id`),
  CONSTRAINT `order_product_extras_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_extras_order_product_id_foreign` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.order_product_extras: ~109 rows (approximately)
INSERT INTO `order_product_extras` (`id`, `order_product_id`, `extra_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
	(31, 23, 8, 2, 6.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
	(32, 23, 10, 1, 2.00, '2025-04-04 21:38:56', '2025-04-04 21:38:56'),
	(33, 24, 8, 2, 6.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
	(34, 24, 10, 1, 2.00, '2025-04-04 21:39:33', '2025-04-04 21:39:33'),
	(496, 299, 16, 1, 7.00, NULL, NULL),
	(497, 300, 8, 2, 6.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(498, 300, 10, 1, 2.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(499, 301, 8, 2, 6.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(500, 301, 10, 1, 2.00, '2025-04-19 04:29:06', '2025-04-19 04:29:06'),
	(501, 302, 8, 2, 6.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(502, 302, 10, 1, 2.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(503, 303, 8, 2, 6.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(504, 303, 10, 1, 2.00, '2025-04-19 04:29:13', '2025-04-19 04:29:13'),
	(505, 304, 8, 2, 6.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(506, 304, 10, 1, 2.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(507, 305, 8, 2, 6.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(508, 305, 10, 1, 2.00, '2025-04-20 08:24:45', '2025-04-20 08:24:45'),
	(509, 306, 8, 2, 6.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(510, 306, 10, 1, 2.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(511, 307, 8, 2, 6.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(512, 307, 10, 1, 2.00, '2025-04-20 08:26:17', '2025-04-20 08:26:17'),
	(513, 308, 8, 2, 6.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(514, 308, 10, 1, 2.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(515, 309, 8, 2, 6.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(516, 309, 10, 1, 2.00, '2025-04-20 09:34:12', '2025-04-20 09:34:12'),
	(517, 310, 8, 2, 6.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(518, 310, 10, 1, 2.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(519, 311, 8, 2, 6.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(520, 311, 10, 1, 2.00, '2025-04-20 09:35:09', '2025-04-20 09:35:09'),
	(521, 312, 8, 2, 6.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(522, 312, 10, 1, 2.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(523, 313, 8, 2, 6.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(524, 313, 10, 1, 2.00, '2025-04-20 09:35:35', '2025-04-20 09:35:35'),
	(525, 314, 8, 2, 6.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(526, 314, 10, 1, 2.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(527, 315, 8, 2, 6.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(528, 315, 10, 1, 2.00, '2025-04-20 09:36:54', '2025-04-20 09:36:54'),
	(529, 316, 8, 2, 6.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(530, 316, 10, 1, 2.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(531, 317, 8, 2, 6.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(532, 317, 10, 1, 2.00, '2025-04-20 09:37:16', '2025-04-20 09:37:16'),
	(533, 318, 8, 2, 6.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(534, 318, 10, 1, 2.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(535, 319, 8, 2, 6.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(536, 319, 10, 1, 2.00, '2025-04-20 09:37:23', '2025-04-20 09:37:23'),
	(537, 320, 8, 2, 6.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(538, 320, 10, 1, 2.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(539, 321, 8, 2, 6.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(540, 321, 10, 1, 2.00, '2025-04-20 09:37:54', '2025-04-20 09:37:54'),
	(541, 322, 8, 2, 6.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(542, 322, 10, 1, 2.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(543, 323, 8, 2, 6.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(544, 323, 10, 1, 2.00, '2025-04-20 09:38:10', '2025-04-20 09:38:10'),
	(545, 324, 8, 2, 6.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(546, 324, 10, 1, 2.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(547, 325, 8, 2, 6.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(548, 325, 10, 1, 2.00, '2025-04-20 09:39:52', '2025-04-20 09:39:52'),
	(549, 326, 8, 2, 6.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(550, 326, 10, 1, 2.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(551, 327, 8, 2, 6.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(552, 327, 10, 1, 2.00, '2025-04-20 10:02:40', '2025-04-20 10:02:40'),
	(553, 328, 8, 2, 6.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(554, 328, 10, 1, 2.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(555, 329, 8, 2, 6.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(556, 329, 10, 1, 2.00, '2025-04-20 10:03:27', '2025-04-20 10:03:27'),
	(557, 330, 8, 2, 6.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(558, 330, 10, 1, 2.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(559, 331, 8, 2, 6.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(560, 331, 10, 1, 2.00, '2025-04-20 10:05:19', '2025-04-20 10:05:19'),
	(561, 332, 8, 2, 6.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(562, 332, 10, 1, 2.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(563, 333, 8, 2, 6.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(564, 333, 10, 1, 2.00, '2025-04-20 10:06:37', '2025-04-20 10:06:37'),
	(565, 334, 8, 2, 6.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(566, 334, 10, 1, 2.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(567, 335, 8, 2, 6.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(568, 335, 10, 1, 2.00, '2025-04-20 10:13:56', '2025-04-20 10:13:56'),
	(569, 336, 8, 2, 6.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(570, 336, 10, 1, 2.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(571, 337, 8, 2, 6.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(572, 337, 10, 1, 2.00, '2025-04-20 10:16:22', '2025-04-20 10:16:22'),
	(573, 338, 8, 2, 6.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(574, 338, 10, 1, 2.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(575, 339, 8, 2, 6.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(576, 339, 10, 1, 2.00, '2025-04-20 10:16:54', '2025-04-20 10:16:54'),
	(577, 340, 8, 2, 6.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(578, 340, 10, 1, 2.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(579, 341, 8, 2, 6.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(580, 341, 10, 1, 2.00, '2025-04-20 10:18:43', '2025-04-20 10:18:43'),
	(581, 342, 8, 2, 6.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(582, 342, 10, 1, 2.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(583, 343, 8, 2, 6.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(584, 343, 10, 1, 2.00, '2025-04-20 10:21:06', '2025-04-20 10:21:06'),
	(585, 344, 8, 2, 6.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(586, 344, 10, 1, 2.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(587, 345, 8, 2, 6.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(588, 345, 10, 1, 2.00, '2025-04-20 13:00:44', '2025-04-20 13:00:44'),
	(589, 346, 8, 2, 6.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(590, 346, 10, 1, 2.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(591, 347, 8, 2, 6.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(592, 347, 10, 1, 2.00, '2025-04-20 13:01:25', '2025-04-20 13:01:25'),
	(593, 348, 8, 2, 6.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(594, 348, 10, 1, 2.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(595, 349, 8, 2, 6.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(596, 349, 10, 1, 2.00, '2025-04-20 16:35:59', '2025-04-20 16:35:59'),
	(597, 350, 8, 2, 6.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10'),
	(598, 350, 10, 1, 2.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10'),
	(599, 351, 8, 2, 6.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10'),
	(600, 351, 10, 1, 2.00, '2025-04-20 16:42:10', '2025-04-20 16:42:10');

-- Dumping structure for table falafina01.packages
CREATE TABLE IF NOT EXISTS `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.packages: ~2 rows (approximately)
INSERT INTO `packages` (`id`, `name`, `price`, `created_at`, `updated_at`, `desc`) VALUES
	(2, 'Noah Leblanc', '118', '2025-04-20 17:03:06', '2025-04-20 17:03:06', 'Tenetur unde sit re'),
	(3, 'ccccccc', '55', '2025-04-20 17:09:40', '2025-04-20 17:09:40', 'hhhhhhhh');

-- Dumping structure for table falafina01.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.password_reset_tokens: ~3 rows (approximately)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('islam@test.com', '$2y$10$Fy6l4hbaXU0i1nmUC/PekOjQWlqfHH1bOTvWo/WRSwx7FcJF.xFne', '2025-04-09 01:21:06'),
	('mostafa0alii@gmail.com', '$2y$10$vpy3q9sSTuk2VGw4YOh6l.l0k.g3cz.stwMkL8EIGlJcMkMhsXVr2', '2025-04-09 01:12:45'),
	('new@app.com', '$2y$10$XtzYylNkf4OHPlG5xW1QeOzOja5RXWK6bnMUZSIcOKHi3/qfZdJTC', '2025-04-15 01:53:59');

-- Dumping structure for table falafina01.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table falafina01.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alt_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loyalty_points` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.products: ~7 rows (approximately)
INSERT INTO `products` (`id`, `name`, `description`, `short_description`, `price`, `created_at`, `updated_at`, `alt_name`, `loyalty_points`) VALUES
	(5, 'بيتزا الجبن', 'تجربة لا تُقاوم لعشاق الجبن مع بيتزا الجبن الكلاسيكية التي تجمع بين قوام العجينة الخفيف والهش وطعم الجبن الذائب والغني. يتم إعداد بيتزا الجبن باستخدام مزيج فاخر من أنواع الجبن مثل جبنة الموزاريلا وجبنة الشيدر، مما يمنحك تجربة ذوقية لا مثيل لها في كل قضمة', 'تجربة لا تُقاوم لعشاق الجبن مع بيتزا الجبن الكلاسيكية التي تجمع بين قوام العجينة الخفيف والهش وطعم الجبن الذائب والغني. يتم إعداد بيتزا الجبن باستخدام مزيج فاخر من أنواع الجبن مثل جبنة الموزاريلا وجبنة الشيدر، مما يمنحك تجربة ذوقية لا مثيل لها في كل قضمة', 19.00, '2025-03-29 18:26:43', '2025-04-15 13:55:13', NULL, '5000'),
	(6, 'بوكس العائلة', 'بوكس العائلة', 'بوكس العائلة', 56.00, '2025-03-29 18:31:43', '2025-03-29 18:31:43', NULL, NULL),
	(7, 'صحن فلافل', 'استمتع بتجربة فريدة مع صحن الفلافل الذي يقدم لك مجموعة من كرات الفلافل المقرمشة والمحضرة يدويًا من الحمص الطازج والتوابل الخاصة. يتم تقديم صحن الفلافل مع تشكيلة من الخضروات الطازجة مثل الطماطم، الخيار، والخس، بالإضافة إلى صلصة الطحينة الكريمية والخبز العربي الطازج. هذا الصحن مثالي كوجبة رئيسية أو جانبية لمحبي الأطباق النباتية الصحية والمشبعة.\r\n\r\nصحن الفلافل يوفر لك مزيجًا غنيًا بالنكهات الشرقية التقليدية مع لمسة عصرية، ليصبح خيارك الأمثل في أي وقت. اطلبه الآن واستمتع بوجبة لذيذة مع خدمة التوصيل السريع إلى باب منزلك.', NULL, 20.00, '2025-03-29 18:34:34', '2025-03-29 18:34:34', NULL, '2000'),
	(8, 'كوجك (فلافل – دجاج)', 'تذوق طعم شهي ومتنوع مع وجبات كوجك التي تمنحك الخيار بين فلافل نباتية مقرمشة أو قطع دجاج طري متبل بعناية. هذه الوجبات الصغيرة مثالية للاستمتاع بها في أي وقت، سواء كوجبة خفيفة أو سريعة. يتم تقديم كل وجبة مع الخضروات الطازجة وصلصات لذيذة لإضافة نكهة غنية لكل قضمة.\r\n\r\nاختر بين الفلافل الكلاسيكية المقرمشة أو الدجاج الطري المتبل، واستمتع بوجبة مشبعة ولذيذة، مع خدمة التوصيل السريعة إلى باب منزلك.', NULL, 21.00, '2025-03-29 18:41:07', '2025-03-29 18:41:07', NULL, NULL),
	(9, 'كب يب 12 قطعة', 'استمتع بوجبة “كب يب 12 قطعة” الشهية من فلافينا، التي تجمع بين الطعم الرائع والجودة المتميزة. هذه الوجبة مثالية لمشاركتها مع العائلة أو الأصدقاء، حيث تقدم لك مجموعة متنوعة من الخيارات التي تناسب كل الأذواق. اختر بين فلافل مقرمشة ولذيذة، دجاج مشوي على الطريقة المثالية، أو المزيج المميز من فلافل ودجاج. يتم تحضير جميع الخيارات بأجود المكونات الطازجة لتضمن لك أفضل تجربة طعام.', NULL, 45.00, '2025-03-29 18:44:00', '2025-03-29 18:44:00', NULL, NULL),
	(10, '(فلافل – دجاج ) فرن', 'استمتع بوجبة صحية ولذيذة مع خيارات فرن (فلافل / دجاج) التي تقدم لك طعامًا مخبوزًا في الفرن، مما يضمن لك النكهة الرائعة مع القوام المقرمش دون الحاجة للقلي. اختر بين فلافل مخبوزة لذيذة ومشبعة أو دجاج طري متبل مطهو في الفرن. هذه الوجبات ليست فقط لذيذة، بل تُعد خيارًا مثاليًا لمن يبحث عن وجبة خفيفة وصحية.\r\n\r\nكل وجبة تُقدم مع الخضروات الطازجة والصلصات التي تضيف لمسة من التميز إلى وجبتك. اختر الفرن الفلافل أو الدجاج واستمتع بنكهة مميزة تصل إلى باب منزلك.', NULL, 21.00, '2025-03-29 18:46:38', '2025-04-15 15:57:06', NULL, '10'),
	(11, 'بريوش فلافل', 'استمتع بنكهات الفلافل الشهية في ساندوتش بريوش فلافل الذي يجمع بين خبز البريوش الطري وكرات الفلافل المقرمشة. يتم تقديم الساندوتش مع تشكيلة من الخضروات الطازجة مثل الخيار والطماطم، مضافًا إليها صلصة الطحينة الكريمية التي تضفي نكهة لذيذة.', 'استمتع بنكهات الفلافل الشهية في ساندوتش بريوش فلافل الذي يجمع بين خبز البريوش الطري وكرات الفلافل المقرمشة. يتم تقديم الساندوتش مع تشكيلة من الخضروات الطازجة مثل الخيار والطماطم، مضافًا إليها صلصة الطحينة الكريمية التي تضفي نكهة لذيذة.', 8.00, '2025-04-10 18:49:27', '2025-04-15 08:43:44', NULL, '4000');

-- Dumping structure for table falafina01.product_extra
CREATE TABLE IF NOT EXISTS `product_extra` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `extra_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_extra_product_id_foreign` (`product_id`),
  KEY `product_extra_extra_id_foreign` (`extra_id`),
  CONSTRAINT `product_extra_extra_id_foreign` FOREIGN KEY (`extra_id`) REFERENCES `extras` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_extra_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.product_extra: ~43 rows (approximately)
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

-- Dumping structure for table falafina01.product_package
CREATE TABLE IF NOT EXISTS `product_package` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `package_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_package_product_id_foreign` (`product_id`),
  KEY `product_package_package_id_foreign` (`package_id`),
  CONSTRAINT `product_package_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_package_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.product_package: ~3 rows (approximately)
INSERT INTO `product_package` (`id`, `product_id`, `package_id`, `created_at`, `updated_at`) VALUES
	(3, 7, 2, NULL, NULL),
	(4, 6, 3, NULL, NULL),
	(5, 10, 2, NULL, NULL);

-- Dumping structure for table falafina01.product_size
CREATE TABLE IF NOT EXISTS `product_size` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `size_id` bigint unsigned DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_size_product_id_foreign` (`product_id`),
  KEY `product_size_size_id_foreign` (`size_id`),
  CONSTRAINT `product_size_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_size_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.product_size: ~4 rows (approximately)
INSERT INTO `product_size` (`id`, `product_id`, `size_id`, `price`, `created_at`, `updated_at`) VALUES
	(5, 5, 6, 19.00, NULL, NULL),
	(6, 5, 8, 25.00, NULL, NULL),
	(7, 10, 2, 20.00, NULL, NULL),
	(10, 11, 2, 8.00, NULL, NULL);

-- Dumping structure for table falafina01.product_type
CREATE TABLE IF NOT EXISTS `product_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned DEFAULT NULL,
  `type_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_type_product_id_foreign` (`product_id`),
  KEY `product_type_type_id_foreign` (`type_id`),
  CONSTRAINT `product_type_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_type_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.product_type: ~11 rows (approximately)
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

-- Dumping structure for table falafina01.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.sessions: ~0 rows (approximately)

-- Dumping structure for table falafina01.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','maintenance_mode') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loyalty_points` int NOT NULL DEFAULT '0',
  `delivery_fees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.settings: ~1 rows (approximately)
INSERT INTO `settings` (`id`, `name`, `email`, `description`, `phone`, `address`, `status`, `created_at`, `updated_at`, `currency`, `loyalty_points`, `delivery_fees`, `version`) VALUES
	(1, 'فلافينا', 'admin@falafina.com', 'فلافينا', '+966 53 576 9000', 'ابها ، خميس مشيط', 'active', '2025-03-24 17:28:02', '2025-04-14 11:22:45', 'ر.س', 10, '12', NULL);

-- Dumping structure for table falafina01.sizes
CREATE TABLE IF NOT EXISTS `sizes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gram` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.sizes: ~8 rows (approximately)
INSERT INTO `sizes` (`id`, `name`, `gram`, `created_at`, `updated_at`) VALUES
	(2, 'عادي', NULL, NULL, NULL),
	(3, 'دوبل ', NULL, NULL, NULL),
	(4, 'جامبو ', NULL, NULL, NULL),
	(5, 'ميجا ', NULL, NULL, NULL),
	(6, 'صغير ', NULL, NULL, NULL),
	(7, 'وسط ', NULL, NULL, NULL),
	(8, 'كبير ', NULL, NULL, NULL),
	(9, 'عائلية ', NULL, NULL, NULL);

-- Dumping structure for table falafina01.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.sliders: ~3 rows (approximately)
INSERT INTO `sliders` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(4, '1', '1', '2025-03-25 03:12:37', '2025-03-25 03:12:37'),
	(5, '2', '2', '2025-03-25 03:13:06', '2025-03-25 03:13:06'),
	(6, '3', '3', '2025-03-25 03:13:45', '2025-03-25 03:13:45');

-- Dumping structure for table falafina01.types
CREATE TABLE IF NOT EXISTS `types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `types_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.types: ~3 rows (approximately)
INSERT INTO `types` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'فلافل', '2025-03-26 01:39:17', '2025-03-26 01:43:55'),
	(2, 'دجاج', '2025-03-26 01:45:44', '2025-03-26 01:45:44'),
	(4, 'ميكس', '2025-03-29 18:30:03', '2025-03-29 18:30:03');

-- Dumping structure for table falafina01.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.users: ~34 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `status`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`) VALUES
	(1, 'User', 'new@app.com', '2025-03-21 21:43:05', '$2y$10$RcXjp1QG4NTi12WR9bg/uexCI/HriMNST553oYS9ltCqLSW4.N4.2', '11111111', 'active', 'dMesWwHxW2', '2025-03-21 21:43:05', '2025-03-21 21:43:05', NULL, NULL),
	(2, 'Tara Greenfelder', 'turner.orval@example.com', '2025-03-21 21:43:07', '$2y$10$RcXjp1QG4NTi12WR9bg/uexCI/HriMNST553oYS9ltCqLSW4.N4.2', '5555555555', 'active', 'mYegp6ddjv', '2025-03-21 21:43:15', '2025-03-21 21:43:15', NULL, NULL),
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

-- Dumping structure for table falafina01.user_profiles
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_profiles_uuid_unique` (`uuid`),
  KEY `user_profiles_user_id_index` (`user_id`),
  CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table falafina01.user_profiles: ~34 rows (approximately)
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

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
