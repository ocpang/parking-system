-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2024 at 10:02 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `causer_type`, `causer_id`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'default', 'deleted', 'App\\Models\\Book', '1', 'App\\User', 1, '[]', '2022-02-15 07:58:20', '2022-02-15 07:58:20'),
(2, 'default', 'change password', 'App\\User', '1', 'App\\User', 1, '[]', '2022-02-17 03:14:34', '2022-02-17 03:14:34'),
(3, 'default', 'created', 'App\\Models\\Book', '1', 'App\\User', 1, '[]', '2022-02-17 04:13:34', '2022-02-17 04:13:34'),
(4, 'default', 'created', 'App\\Models\\Book', '2', 'App\\User', 1, '[]', '2022-02-17 04:14:00', '2022-02-17 04:14:00'),
(5, 'default', 'edited', 'App\\Models\\Book', '2', 'App\\User', 1, '[]', '2022-02-17 04:23:48', '2022-02-17 04:23:48'),
(6, 'default', 'edited', 'App\\Models\\Book', '1', 'App\\User', 1, '[]', '2022-02-17 04:24:10', '2022-02-17 04:24:10'),
(7, 'default', 'created', 'App\\Models\\Book', '3', 'App\\User', 1, '[]', '2022-02-17 04:27:09', '2022-02-17 04:27:09'),
(8, 'default', 'deleted', 'App\\Models\\Book', '3', 'App\\User', 1, '[]', '2022-02-17 04:27:15', '2022-02-17 04:27:15'),
(9, 'default', 'created', 'App\\Transaction', '1', 'App\\User', 1, '[]', '2022-08-04 07:47:41', '2022-08-04 07:47:41'),
(10, 'default', 'created', 'App\\User', '2', 'App\\User', 1, '[]', '2022-08-04 07:51:34', '2022-08-04 07:51:34'),
(11, 'default', 'created', 'App\\Transaction', '2', 'App\\User', 1, '[]', '2022-08-04 07:53:07', '2022-08-04 07:53:07'),
(12, 'default', 'created', 'App\\Transaction', '3', 'App\\User', 1, '[]', '2022-08-04 08:02:00', '2022-08-04 08:02:00'),
(13, 'default', 'created', 'App\\Transaction', '4', 'App\\User', 1, '[]', '2022-08-04 08:02:19', '2022-08-04 08:02:19'),
(14, 'default', 'created', 'App\\Transaction', '5', 'App\\User', 1, '[]', '2022-08-04 08:05:16', '2022-08-04 08:05:16'),
(15, 'default', 'created', 'App\\Transaction', '6', 'App\\User', 1, '[]', '2022-08-04 08:06:51', '2022-08-04 08:06:51'),
(16, 'default', 'created', 'App\\Transaction', '7', 'App\\User', 1, '[]', '2022-08-04 08:07:29', '2022-08-04 08:07:29'),
(17, 'default', 'created', 'App\\Transaction', '8', 'App\\User', 2, '[]', '2022-08-04 10:30:38', '2022-08-04 10:30:38'),
(18, 'default', 'created', 'App\\Transaction', '9', 'App\\User', 1, '[]', '2022-08-05 04:23:55', '2022-08-05 04:23:55'),
(19, 'default', 'created', 'App\\Transaction', '10', 'App\\User', 1, '[]', '2022-08-05 04:24:06', '2022-08-05 04:24:06'),
(20, 'default', 'edited', 'App\\Transaction', '7', 'App\\User', 1, '[]', '2022-08-05 04:42:02', '2022-08-05 04:42:02'),
(21, 'default', 'edited', 'App\\Transaction', '8', 'App\\User', 1, '[]', '2022-08-05 04:51:42', '2022-08-05 04:51:42'),
(22, 'default', 'edited', 'App\\Transaction', '9', 'App\\User', 1, '[]', '2022-08-05 04:52:30', '2022-08-05 04:52:30'),
(23, 'default', 'created', 'App\\Transaction', '11', 'App\\User', 1, '[]', '2022-08-05 04:55:04', '2022-08-05 04:55:04'),
(24, 'default', 'created', 'App\\Transaction', '12', 'App\\User', 1, '[]', '2022-08-05 04:56:05', '2022-08-05 04:56:05'),
(25, 'default', 'created', 'App\\Transaction', '13', 'App\\User', 1, '[]', '2022-08-05 04:56:17', '2022-08-05 04:56:17'),
(26, 'default', 'edited', 'App\\Transaction', '5', 'App\\User', 1, '[]', '2022-08-05 04:59:11', '2022-08-05 04:59:11'),
(27, 'default', 'edited', 'App\\Transaction', '10', 'App\\User', 1, '[]', '2022-08-05 05:00:03', '2022-08-05 05:00:03'),
(28, 'default', 'edited', 'App\\Transaction', '13', 'App\\User', 1, '[]', '2022-08-05 06:18:17', '2022-08-05 06:18:17'),
(29, 'default', 'edited', 'App\\Transaction', '12', 'App\\User', 1, '[]', '2022-08-05 06:21:21', '2022-08-05 06:21:21'),
(30, 'default', 'edited', 'App\\Transaction', '12', 'App\\User', 1, '[]', '2022-08-05 06:39:01', '2022-08-05 06:39:01'),
(31, 'default', 'edited', 'App\\Transaction', '13', 'App\\User', 1, '[]', '2022-08-05 06:39:23', '2022-08-05 06:39:23'),
(32, 'default', 'edited', 'App\\Transaction', '11', 'App\\User', 1, '[]', '2022-08-05 06:39:41', '2022-08-05 06:39:41'),
(33, 'default', 'edited', 'App\\Transaction', '7', 'App\\User', 1, '[]', '2022-08-05 06:40:07', '2022-08-05 06:40:07'),
(34, 'default', 'created', 'App\\Transaction', '14', 'App\\User', 1, '[]', '2022-08-05 06:48:56', '2022-08-05 06:48:56'),
(35, 'default', 'edited', 'App\\Transaction', '6', 'App\\User', 1, '[]', '2022-08-05 06:49:34', '2022-08-05 06:49:34'),
(36, 'default', 'created', 'App\\Models\\Transaction', '15', 'App\\User', 1, '[]', '2022-08-05 07:36:18', '2022-08-05 07:36:18'),
(37, 'default', 'edited', 'App\\Models\\Transaction', '15', 'App\\User', 1, '[]', '2022-08-05 07:36:40', '2022-08-05 07:36:40'),
(38, 'default', 'created', 'App\\Models\\Transaction', '16', 'App\\User', 2, '[]', '2022-08-05 07:40:09', '2022-08-05 07:40:09'),
(39, 'default', 'edited', 'App\\Models\\Transaction', '16', 'App\\User', 2, '[]', '2022-08-05 07:40:42', '2022-08-05 07:40:42'),
(40, 'default', 'created', 'App\\Models\\Transaction', '17', 'App\\User', 1, '[]', '2022-08-05 07:42:08', '2022-08-05 07:42:08'),
(41, 'default', 'created', 'App\\Models\\Transaction', '18', 'App\\User', 1, '[]', '2023-05-03 09:42:11', '2023-05-03 09:42:11'),
(42, 'default', 'edited', 'App\\Models\\Transaction', '18', 'App\\User', 1, '[]', '2023-05-03 09:44:51', '2023-05-03 09:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
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
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_21_090422_create_permission_tables', 2),
(5, '2020_12_21_094118_create_activity_log_table', 3),
(6, '2020_12_22_161541_add_column_to_users_table', 4),
(7, '2021_03_18_112806_add_column_role_id_to_users_table', 5),
(9, '2022_08_04_134325_create_transactions_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(2, 'App\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'read home', 'web', '2021-02-25 07:01:06', '2021-02-25 07:01:06'),
(2, 'read user', 'web', '2021-02-25 08:57:27', '2021-02-25 08:57:27'),
(3, 'create user', 'web', '2021-02-25 08:58:25', '2021-02-25 08:58:25'),
(4, 'update user', 'web', '2021-02-25 08:58:35', '2021-02-25 08:58:35'),
(5, 'delete user', 'web', '2021-02-25 08:58:42', '2021-02-25 08:58:42'),
(6, 'read permission', 'web', '2021-02-25 08:57:27', '2021-02-25 08:57:27'),
(7, 'create permission', 'web', '2021-02-25 08:58:25', '2021-02-25 08:58:25'),
(8, 'update permission', 'web', '2021-02-25 08:58:35', '2021-02-25 08:58:35'),
(9, 'delete permission', 'web', '2021-02-25 08:58:42', '2021-02-25 08:58:42'),
(10, 'read role', 'web', '2021-02-25 08:57:27', '2021-02-25 08:57:27'),
(11, 'create role', 'web', '2021-02-25 08:58:25', '2021-02-25 08:58:25'),
(12, 'update role', 'web', '2021-02-25 08:58:35', '2021-02-25 08:58:35'),
(13, 'delete role', 'web', '2021-02-25 08:58:42', '2021-02-25 08:58:42'),
(14, 'read transaction', 'web', '2021-02-25 08:57:27', '2021-02-25 08:57:27'),
(15, 'create transaction', 'web', '2021-02-25 08:58:25', '2021-02-25 08:58:25'),
(16, 'update transaction', 'web', '2021-02-25 08:58:35', '2021-02-25 08:58:35'),
(17, 'delete transaction', 'web', '2021-02-25 08:58:42', '2021-02-25 08:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2020-12-21 09:18:43', NULL),
(2, 'operator', 'web', '2022-08-04 07:49:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(1, 2),
(15, 2),
(16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vehicle_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `hours` int NOT NULL DEFAULT '0',
  `price` int NOT NULL DEFAULT '0',
  `total` int NOT NULL DEFAULT '0',
  `user_created` int NOT NULL DEFAULT '0',
  `user_updated` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `code`, `vehicle_no`, `check_in`, `check_out`, `hours`, `price`, `total`, `user_created`, `user_updated`, `created_at`, `updated_at`) VALUES
(1, '78436308', 'F 1234 EA', '2022-08-04 14:47:41', '2022-08-04 17:43:17', 0, 0, 0, 1, 0, '2022-08-04 07:47:41', '2022-08-04 07:47:41'),
(2, '495F9E7E', 'F 5678 AA', '2022-08-04 14:53:07', NULL, 0, 0, 0, 1, 0, '2022-08-04 07:53:07', '2022-08-04 07:53:07'),
(3, 'A536247D', 'B 1901 HU', '2022-08-04 15:02:00', NULL, 0, 0, 0, 1, 0, '2022-08-04 08:02:00', '2022-08-04 08:02:00'),
(4, '09DB05B9', 'H 8912 UQ', '2022-08-04 15:02:19', NULL, 0, 0, 0, 1, 0, '2022-08-04 08:02:19', '2022-08-04 08:02:19'),
(5, '71434301', 'AB 7819 AA', '2022-08-04 15:05:16', '2022-08-05 11:59:08', 21, 3000, 63000, 1, 1, '2022-08-04 08:05:16', '2022-08-05 04:59:11'),
(6, '485F9E7A', 'D 6157 A', '2022-08-04 15:06:51', '2022-08-05 13:49:30', 23, 3000, 69000, 1, 1, '2022-08-04 08:06:51', '2022-08-05 06:49:34'),
(7, 'B975E5E5', 'Z 7901 AA', '2022-08-04 15:07:29', '2022-08-05 13:40:05', 23, 3000, 69000, 1, 1, '2022-08-04 08:07:29', '2022-08-05 06:40:07'),
(8, '78926761', 'G 8908 FH', '2022-08-04 17:30:38', '2022-08-05 11:51:23', 18, 3000, 54000, 2, 1, '2022-08-04 10:30:38', '2022-08-05 04:51:42'),
(9, '00212713', 'F 5678 TU', '2022-08-05 11:23:55', '2022-08-05 11:52:10', 1, 3000, 3000, 1, 1, '2022-08-05 04:23:55', '2022-08-05 04:52:30'),
(10, '922F5780', 'F 6712 AA', '2022-08-05 11:24:06', '2022-08-05 12:00:00', 1, 3000, 3000, 1, 1, '2022-08-05 04:24:06', '2022-08-05 05:00:03'),
(11, 'E13D4A78', 'F 5678 AF', '2022-08-05 11:55:04', '2022-08-05 13:39:39', 2, 3000, 6000, 1, 1, '2022-08-05 04:55:04', '2022-08-05 06:39:41'),
(12, 'C83A4290', 'F 5678 AV', '2022-08-05 11:56:05', '2022-08-05 13:38:49', 2, 3000, 6000, 1, 1, '2022-08-05 04:56:05', '2022-08-05 06:39:01'),
(13, 'EE55A44F', 'F 5678 AK', '2022-08-05 11:56:17', '2022-08-05 13:39:21', 2, 3000, 6000, 1, 1, '2022-08-05 04:56:17', '2022-08-05 06:39:23'),
(14, 'DAD997CB', 'AB 7819 AA', '2022-08-05 13:48:56', NULL, 0, 0, 0, 1, 0, '2022-08-05 06:48:56', '2022-08-05 06:48:56'),
(15, '6AB0447E', 'B 7801 AA', '2022-08-05 14:36:18', '2022-08-05 14:36:38', 1, 3000, 3000, 1, 1, '2022-08-05 07:36:18', '2022-08-05 07:36:40'),
(16, '8AD70AAA', 'F 7777 A', '2022-08-05 14:40:09', '2022-08-05 14:40:40', 1, 3000, 3000, 2, 2, '2022-08-05 07:40:09', '2022-08-05 07:40:42'),
(17, 'B425D2FA', 'F 7777 A', '2022-08-05 14:42:08', NULL, 0, 0, 0, 1, 0, '2022-08-05 07:42:08', '2022-08-05 07:42:08'),
(18, '4C3324B6', 'F1110AA', '2023-05-03 16:42:11', '2023-05-03 16:44:36', 1, 3000, 3000, 1, 1, '2023-05-03 09:42:11', '2023-05-03 09:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int UNSIGNED DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint DEFAULT '1',
  `user_created` int UNSIGNED DEFAULT '0',
  `user_updated` int UNSIGNED DEFAULT '0',
  `user_deleted` int UNSIGNED DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role_id`, `email_verified_at`, `password`, `remember_token`, `email_token`, `status`, `user_created`, `user_updated`, `user_deleted`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 'admin@admin.com', 1, NULL, '$2y$10$jTl3SZvMX0QbSLxD5aVVwOluFO2CcItNqa7CqKRXlWsf4oIo4GSyG', NULL, '2efe140b', 1, 0, 1, 0, '2021-04-23 02:57:57', '2022-02-17 03:14:34', NULL),
(2, 'Operator Satu', 'operator_satu@admin.com', 2, NULL, '$2y$10$HUK/l0H33XDP6vGj4q.vYuIq.5pqEBeiDB1QXoFTJJ7KsMM14v8ti', NULL, NULL, 1, 1, 0, 0, '2022-08-04 07:51:34', '2022-08-04 07:51:34', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
