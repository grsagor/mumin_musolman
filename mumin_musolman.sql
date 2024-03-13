-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 08:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mumin_musolman`
--

-- --------------------------------------------------------

--
-- Table structure for table `amol_videos`
--

CREATE TABLE `amol_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `embed_link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `channels`
--

CREATE TABLE `channels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `channels`
--

INSERT INTO `channels` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Single', NULL, NULL, NULL, NULL),
(2, 'Group', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `channel_subscribers`
--

CREATE TABLE `channel_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `channel_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `channel_subscribers`
--

INSERT INTO `channel_subscribers` (`id`, `user_id`, `channel_id`, `created_at`, `updated_at`) VALUES
(1, '1', '1', NULL, NULL),
(2, '2', '1', NULL, NULL),
(3, '2', '2', NULL, NULL),
(4, '4', '2', NULL, NULL),
(5, '1', '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `custom_ads`
--

CREATE TABLE `custom_ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ad_no` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_channels`
--

CREATE TABLE `live_channels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `embed_link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `channel_id` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `channel_id`, `message`, `user_id`, `created_at`, `updated_at`) VALUES
(106, '1', 'hi', '1', '2023-12-28 23:27:38', '2023-12-28 23:27:38'),
(107, '1', 'hi', '1', '2023-12-28 23:28:15', '2023-12-28 23:28:15'),
(108, '1', 'abc', '1', '2023-12-28 23:29:48', '2023-12-28 23:29:48'),
(109, '1', 'abc\nasdfasdf', '1', '2023-12-28 23:29:53', '2023-12-28 23:29:53'),
(110, '1', 'asfdas', '1', '2023-12-28 23:30:13', '2023-12-28 23:30:13'),
(111, '1', 'asdfasfd', '1', '2023-12-28 23:30:26', '2023-12-28 23:30:26'),
(112, '1', 'helllo', '1', '2023-12-28 23:31:25', '2023-12-28 23:31:25'),
(113, '1', 'hiiiiiii', '1', '2023-12-28 23:32:41', '2023-12-28 23:32:41'),
(114, '1', 'hello', '1', '2023-12-28 23:33:33', '2023-12-28 23:33:33'),
(115, '1', 'hello', '1', '2023-12-28 23:34:14', '2023-12-28 23:34:14'),
(116, '1', 'hiiiiiiiiiiiiiiiiiiiiiiii', '1', '2023-12-28 23:34:47', '2023-12-28 23:34:47'),
(117, '1', 'kigo', '2', '2023-12-28 23:44:28', '2023-12-28 23:44:28'),
(118, '1', 'baiya', '1', '2023-12-28 23:44:43', '2023-12-28 23:44:43'),
(119, '1', 'hillo', '1', '2023-12-28 23:45:34', '2023-12-28 23:45:34'),
(120, '1', 'bhaiyaaaaaaaaaaaaaa', '2', '2023-12-28 23:45:40', '2023-12-28 23:45:40'),
(121, '1', 'pilo pilo', '1', '2023-12-28 23:45:55', '2023-12-28 23:45:55'),
(122, '1', 'pakka pakka', '2', '2023-12-28 23:46:10', '2023-12-28 23:46:10'),
(123, '1', 'pide pide', '1', '2023-12-28 23:47:11', '2023-12-28 23:47:11'),
(124, '1', 'pidamu', '2', '2023-12-28 23:48:40', '2023-12-28 23:48:40'),
(125, '1', 'ustaaaaaaaaaaaad', '1', '2023-12-28 23:48:51', '2023-12-28 23:48:51'),
(126, '1', 'reza bhai', '1', '2023-12-28 23:59:09', '2023-12-28 23:59:09'),
(127, '1', 'bhalo?', '1', '2023-12-28 23:59:12', '2023-12-28 23:59:12'),
(128, '1', 'hae hae bhalo', '2', '2023-12-28 23:59:17', '2023-12-28 23:59:17'),
(129, '1', 'ki obostha?', '2', '2023-12-28 23:59:20', '2023-12-28 23:59:20'),
(130, '1', 'hi', '1', '2023-12-29 00:22:25', '2023-12-29 00:22:25'),
(131, '1', 'ajsdf;lakjsfdlasd', '2', '2023-12-29 00:23:10', '2023-12-29 00:23:10'),
(132, '1', 'hiiiiiiiiiiiiii', '1', '2023-12-29 00:24:13', '2023-12-29 00:24:13'),
(133, '1', 'bossssssssssss', '1', '2023-12-29 00:26:17', '2023-12-29 00:26:17'),
(134, '1', 'hiyo', '1', '2023-12-29 00:27:00', '2023-12-29 00:27:00'),
(135, '1', 'omago turu lav', '1', '2023-12-29 00:56:58', '2023-12-29 00:56:58'),
(136, '2', 'nice', '1', '2023-12-29 00:59:13', '2023-12-29 00:59:13'),
(137, '1', 'hello', '1', '2023-12-29 01:16:34', '2023-12-29 01:16:34'),
(138, '1', 'hi', '1', '2023-12-29 01:16:55', '2023-12-29 01:16:55'),
(139, '2', 'hello', '1', '2023-12-29 01:17:22', '2023-12-29 01:17:22'),
(140, '2', 'hello', '1', '2023-12-29 01:17:31', '2023-12-29 01:17:31'),
(141, '1', 'hello', '1', '2023-12-29 01:18:16', '2023-12-29 01:18:16'),
(142, '2', 'bye', '1', '2023-12-29 01:19:00', '2023-12-29 01:19:00'),
(143, '1', 'ki koro', '1', '2023-12-29 01:19:50', '2023-12-29 01:19:50'),
(144, '2', 'group re upore nao', '1', '2023-12-29 01:20:35', '2023-12-29 01:20:35'),
(145, '1', 'ebar single re upore nao', '1', '2023-12-29 01:20:52', '2023-12-29 01:20:52'),
(146, '2', 'group re duita thekei upore nao', '1', '2023-12-29 01:22:12', '2023-12-29 01:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `message_requests`
--

CREATE TABLE `message_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2023_12_29_080216_create_content_categories_table', 1),
(2, '2023_12_29_080244_create_contents_table', 2),
(3, '2024_01_03_081239_create_truck_types_table', 3),
(4, '2024_01_03_110619_create_truck_type_details_table', 4),
(5, '2024_01_05_061653_create_orders_table', 5),
(6, '2024_01_05_113511_create_driver_histories_table', 6),
(7, '2024_01_08_112959_create_deposits_table', 7),
(8, '2024_01_11_075613_create_ratings_table', 8),
(9, '2024_01_19_180739_create_regular_amol_videos_table', 9),
(10, '2024_01_19_181036_create_amol_videos_table', 10),
(11, '2024_01_19_181137_create_premium_amol_videos_table', 11),
(12, '2024_01_19_181221_create_premium_videos_table', 12),
(13, '2024_01_19_181259_create_live_channels_table', 13),
(14, '2024_01_19_181604_create_message_requests_table', 14),
(15, '2024_01_19_181910_create_transaction_histories_table', 15),
(16, '2024_01_19_182105_create_tafsirs_table', 16),
(17, '2024_01_19_182601_create_custom_ads_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `amount`, `address`, `status`, `transaction_id`, `currency`) VALUES
(6, 'Customer Name', 'customer@mail.com', '8801XXXXXXXXX', 10, 'Customer Address', 'Processing', '65aba97a2b7ae', 'BDT');

-- --------------------------------------------------------

--
-- Table structure for table `premium_amol_videos`
--

CREATE TABLE `premium_amol_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `embed_link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `premium_videos`
--

CREATE TABLE `premium_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `embed_link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regular_amol_videos`
--

CREATE TABLE `regular_amol_videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `embed_link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `right`
--

CREATE TABLE `right` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `module` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `right`
--

INSERT INTO `right` (`id`, `name`, `module`, `created_at`, `updated_at`) VALUES
(1, 'role.view', 'role', '2023-05-09 22:11:19', '2023-05-09 22:17:58'),
(2, 'role.create', 'role', '2023-05-09 22:11:44', '2023-05-09 22:17:58'),
(3, 'role.edit', 'role', '2023-05-09 22:11:44', '2023-05-09 22:17:58'),
(4, 'role.delete', 'role', '2023-05-09 22:11:44', '2023-05-09 22:17:58'),
(5, 'user.view', 'user', '2023-05-09 22:12:49', '2023-05-09 22:18:12'),
(6, 'user.create', 'user', '2023-05-09 22:12:49', '2023-05-09 22:18:12'),
(7, 'user.edit', 'user', '2023-05-09 22:12:49', '2023-05-09 22:18:12'),
(8, 'user.delete', 'user', '2023-05-09 22:12:49', '2023-05-09 22:18:12'),
(9, 'dashboard.view', 'dashboard', '2023-05-09 22:13:06', '2023-05-09 22:18:25'),
(10, 'dashboard.create', 'dashboard', '2023-05-09 22:13:06', '2023-05-09 22:18:25'),
(11, 'dashboard.edit', 'dashboard', '2023-05-09 22:13:06', '2023-05-09 22:18:25'),
(12, 'dashboard.delete', 'dashboard', '2023-05-09 22:13:06', '2023-05-09 22:18:25'),
(23, 'right.view', 'right', '2023-05-16 06:21:07', '2023-05-16 06:21:07'),
(24, 'right.create', 'right', '2023-05-16 06:21:20', '2023-05-16 06:21:20'),
(25, 'right.edit', 'right', '2023-05-16 06:21:28', '2023-05-16 06:21:28'),
(26, 'right.delete', 'right', '2023-05-16 06:21:36', '2023-05-16 06:21:36'),
(35, 'setting.view', 'setting', '2023-05-21 23:31:21', '2023-05-21 23:31:21'),
(37, 'setting.edit', 'setting', '2023-05-21 23:32:15', '2023-05-21 23:32:15'),
(38, 'setting.general', 'setting', '2023-05-21 23:32:50', '2023-05-21 23:32:50'),
(39, 'setting.static-content', 'setting', '2023-05-21 23:51:51', '2023-05-21 23:51:51'),
(76, 'setting.legal-content', 'setting', '2023-07-03 01:10:19', '2023-07-03 01:10:19'),
(89, 'truck_type.view', 'truck_type', '2024-01-03 07:33:29', '2024-01-03 07:34:21'),
(90, 'booking.view', 'booking', '2024-01-05 06:07:01', '2024-01-05 06:07:01'),
(91, 'report.view', 'report', '2024-01-12 06:49:07', '2024-01-12 06:49:07');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2023-05-07 11:16:21', '2023-05-07 11:16:21'),
(2, 'User', '2023-05-07 11:16:21', '2023-05-07 11:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `role_right`
--

CREATE TABLE `role_right` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_right`
--

INSERT INTO `role_right` (`id`, `role_id`, `right_id`, `permission`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(2, 1, 2, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(3, 1, 3, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(4, 1, 4, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(5, 1, 5, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(6, 1, 6, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(7, 1, 7, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(8, 1, 8, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(9, 1, 9, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(10, 1, 10, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(11, 1, 11, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(12, 1, 12, 1, '2023-05-09 23:55:04', '2023-05-16 04:15:06'),
(81, 1, 23, 1, '2023-05-16 22:28:46', '2023-05-16 22:28:46'),
(82, 1, 24, 1, '2023-05-16 22:28:46', '2023-05-16 22:28:46'),
(83, 1, 25, 1, '2023-05-16 22:28:46', '2023-05-16 22:28:46'),
(84, 1, 26, 1, '2023-05-16 22:28:46', '2023-05-16 22:28:46'),
(93, 1, 35, 1, '2023-05-21 23:33:20', '2023-05-21 23:33:20'),
(94, 1, 37, 1, '2023-05-21 23:33:20', '2023-05-21 23:33:20'),
(95, 1, 38, 1, '2023-05-21 23:33:20', '2023-05-21 23:33:20'),
(96, 1, 39, 0, '2023-05-21 23:55:53', '2023-12-21 06:12:41'),
(133, 1, 76, 1, '2023-07-03 01:10:38', '2024-01-11 23:02:42'),
(316, 1, 79, 1, '2023-08-11 07:32:54', '2023-08-11 07:32:54'),
(317, 1, 80, 1, '2023-08-11 07:32:54', '2023-08-11 07:32:54'),
(318, 1, 81, 1, '2023-08-11 07:32:54', '2023-08-11 07:32:54'),
(319, 1, 82, 1, '2023-08-11 07:32:54', '2023-08-11 07:32:54'),
(326, 1, 89, 1, '2024-01-03 07:34:39', '2024-01-03 07:34:39'),
(327, 1, 90, 1, '2024-01-05 06:07:14', '2024-01-05 06:07:14'),
(328, 2, 1, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(329, 2, 2, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(330, 2, 3, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(331, 2, 4, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(332, 2, 5, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(333, 2, 6, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(334, 2, 7, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(335, 2, 8, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(336, 2, 9, 1, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(337, 2, 10, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(338, 2, 11, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(339, 2, 12, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(340, 2, 23, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(341, 2, 24, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(342, 2, 25, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(343, 2, 26, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(344, 2, 35, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(345, 2, 37, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(346, 2, 38, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(347, 2, 39, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(348, 2, 76, 0, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(349, 2, 89, 1, '2024-01-11 04:02:17', '2024-01-15 06:51:17'),
(350, 2, 90, 1, '2024-01-11 04:02:17', '2024-01-11 04:02:17'),
(351, 1, 91, 1, '2024-01-12 06:49:18', '2024-01-12 06:49:18'),
(352, 2, 91, 0, '2024-01-15 06:51:17', '2024-01-15 06:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'application_name', 'Mumin Musolman', 1, '2023-05-21 22:34:50', '2024-01-15 10:45:01'),
(2, 'site_logo', '170533711865a5611ec2009unnamed.webp', 1, '2023-05-21 22:59:19', '2024-01-15 10:45:18'),
(3, 'site_favicon', '170533711865a5611ec2e47unnamed.webp', 1, '2023-05-21 23:09:36', '2024-01-15 10:45:18'),
(4, 'application_phone', '01*******76', 1, '2023-05-21 23:11:44', '2024-01-19 14:37:44'),
(5, 'application_email', 'info@muminmusolman.net', 1, '2023-05-21 23:12:29', '2024-01-15 10:45:51'),
(6, 'application_toll_free', '+88 017 89765678', 1, '2023-05-21 23:20:49', '2024-01-15 10:45:51'),
(7, 'application_fax', '+88 017 89765678', 1, '2023-05-21 23:20:49', '2024-01-15 10:45:51'),
(8, 'application_address', 'Dhaka', 1, '2023-05-21 23:20:49', '2024-01-15 10:45:51'),
(9, 'about_us', '<h1 style=\"font-size: 1.625em; margin: 0.2em 0px 0.5em; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; font-weight: bold; text-rendering: optimizelegibility; line-height: 1.4;\"><b style=\"font-weight: bold; line-height: inherit;\">Machine Tool Solutions –</b></h1><h1 style=\"font-size: 1.625em; margin: 0.2em 0px 0.5em; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; font-weight: bold; text-rendering: optimizelegibility; line-height: 1.4;\"><b style=\"font-weight: bold; line-height: inherit;\">Global distributor of reliable and competitively priced&nbsp;</b><b style=\"font-weight: bold; line-height: inherit;\">products: Ino-Grip Compact Chucks, Ino&nbsp;Flex Concentric Compensating Power Chuck, Lang Technik Clean Tec andAR Filtrazioni, Compact Fixtures, 5-axis Clamping Systems, InoGrip Stamping Technology, Vises for CNC Machining, Makro-Grip Applications, Precision Index Tables, and more machine tool solutions and services.&nbsp;</b><a rel=\"nofollow\" href=\"https://www.machinetoolsolutions.ca/lang-technovation-technik-gmbh-automation-quick-point-zero-clamping-tower-tombstone-plates-eco-compact-20-canada/\" style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; text-decoration: none; line-height: inherit;\">Contact</a><b style=\"font-weight: bold; line-height: inherit;\">&nbsp;Machine Tools Solutions today to learn more about what products we have in stock.</b></h1><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\"><strong style=\"font-weight: bold; line-height: inherit;\">Machine Tool Solutions Ltd.&nbsp;</strong>was established in 1989. For over 25 years, our mission at MTS has been to provide “intelligent workholding for improving productivity” to our customers by delivering high quality, value-minded tools inworkholding andmaterial handling through magnetic systems. Additionally, we provide solutions for non-ferrous materials through innovative fixture and zero-point clamping systems, permanent lifting magnets and Makro-grip profile clamping vices.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">With powerful and well-crafted components, Machine Tool Solutions Ltd. offers a wide product line to satisfy the needs of various industries including defense, medical, automotive, aerospace and more. Our mission further developed the company into gathering the finest products from world-class manufacturers and producers of effective mechanical and industrial components. We are a distributor of equipment from stamping technology, LANGTechnikgmBH, HWR SpanntechnikgmBH, SPD, AR Filtrazioni, Ok-Vise low profile clamps, 5-axis vises and stamping devices from LANG as well as many more.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">Machine Tool Solutions also provide expert repair, refurbishing and re-certification services, ensuring work safety through proper and thorough consultation of your workholding equipment. Our technical servicescertify your tools work best for you, offering consultations on product efficiency and component manufacturing optimization.</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">We welcome you to be our partner towards continuous success and expanding growth in manufacturing, workholding, automation, and material handling technology.&nbsp;<a rel=\"nofollow\" href=\"https://www.machinetoolsolutions.ca/lang-technovation-technik-gmbh-automation-quick-point-zero-clamping-tower-tombstone-plates-eco-compact-20-canada/\" style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; text-decoration: none; line-height: inherit;\">Contact</a>&nbsp;Machine Tools Solutions today to learn more about what products we have in stock.</p><p class=\"h-large\" style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; font-size: 32px; line-height: 32px; text-rendering: optimizelegibility;\">Social Responsibility</p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\"></p><p style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 0px; padding: 0px; direction: ltr; font-family: Lato, helvetica, arial, sans-serif; line-height: 1.6; text-rendering: optimizelegibility;\">Machine Tool Solutions Ltd. cares about the environment and its employees are encouraged to:</p><ul style=\"margin-right: 0px; margin-bottom: 1.25em; margin-left: 20px; padding: 0px; direction: ltr; line-height: 1.6; list-style-position: outside; font-family: Lato, helvetica, arial, sans-serif;\"><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Keep the work environment clean and safe.</li><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Reduce the company’s waste generation by recycling paper and packaging supplies.</li><li style=\"margin: 0px; padding: 0px; direction: ltr;\">Decrease energy and water consumption.</li></ul>', 1, '2023-05-22 01:14:20', '2023-07-28 05:38:47'),
(10, 'about_image_1', '1684754453646b501513684about-1.jpg', 1, '2023-05-22 05:20:53', '2023-05-22 05:20:53'),
(11, 'about_image_2', '1684754453646b501513bc3about-3.jpg', 1, '2023-05-22 05:20:53', '2023-05-22 05:20:53'),
(12, 'about_image_3', '1684754453646b501513e3dabout-2.jpg', 1, '2023-05-22 05:20:53', '2023-05-22 05:20:53'),
(13, 'terms_and_conditions', '<p class=\"MsoNormal\"><br></p>', 1, '2023-07-03 01:25:51', '2023-12-07 06:14:21'),
(14, 'privacy_policy', '<p class=\"MsoNormal\"><br></p>', 1, '2023-07-03 01:25:51', '2023-12-07 06:14:21'),
(15, 'return_policy', '<p class=\"MsoNormal\"><br></p>', 1, '2023-07-03 01:25:51', '2023-12-07 06:14:21'),
(16, 'facebook_link', 'https://www.facebook.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:55'),
(17, 'twitter_link', 'https://twitter.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(18, 'instagram_link', 'https://www.instagram.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(19, 'linkedin_link', 'https://www.linkedin.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(20, 'youtube_link', 'https://www.youtube.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(21, 'bkash_number', '01*******76', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(22, 'nagad_number', '01*******76', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(23, 'message_charge', '100', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(24, 'message_validity', '3', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(25, 'premium_charge', '500', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56'),
(26, 'premium_validity', '6', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `tafsirs`
--

CREATE TABLE `tafsirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `sura_no` varchar(255) NOT NULL,
  `ayat_no` varchar(255) NOT NULL,
  `jakariya_heading` varchar(255) NOT NULL,
  `jakariya_tafsir` longtext NOT NULL,
  `majid_heading` varchar(255) NOT NULL,
  `majid_tafsir` longtext NOT NULL,
  `ahsanul_heading` varchar(255) NOT NULL,
  `ahsanul_tafsir` longtext NOT NULL,
  `kasir_heading` varchar(255) NOT NULL,
  `kasir_tafsir` longtext NOT NULL,
  `other_heading` varchar(255) NOT NULL,
  `other_tafsir` longtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tafsirs`
--

INSERT INTO `tafsirs` (`id`, `created_at`, `sura_no`, `ayat_no`, `jakariya_heading`, `jakariya_tafsir`, `majid_heading`, `majid_tafsir`, `ahsanul_heading`, `ahsanul_tafsir`, `kasir_heading`, `kasir_tafsir`, `other_heading`, `other_tafsir`, `status`, `updated_at`) VALUES
(4, '2024-01-31 19:17:03', 'Distinctio Iure sed', 'Dicta pariatur Maio', 'Doloribus magnam eli', 'Ab ullamco voluptati', 'Amet qui ea fugiat', 'Aute omnis ipsam id', 'Quis aliquip labore', 'Consequuntur volupta', 'Ipsa dolor voluptat', 'Rerum quia anim enim', 'Facilis totam doloru', 'Facilis sequi in off', 1, '2024-01-31 19:17:03');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_histories`
--

CREATE TABLE `transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL,
  `cause` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_histories`
--

INSERT INTO `transaction_histories` (`id`, `user_id`, `transaction_id`, `amount`, `cause`, `created_at`, `updated_at`) VALUES
(1, '7276', NULL, '500', 'premium', '2024-02-24 16:30:08', '2024-02-24 16:30:08'),
(2, '7276', 'asdfa', '500', 'premium', '2024-02-24 16:30:33', '2024-02-24 16:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `truck_types`
--

CREATE TABLE `truck_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rent_type` varchar(255) DEFAULT NULL,
  `driver_charge` double(8,2) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_types`
--

INSERT INTO `truck_types` (`id`, `name`, `image`, `rent_type`, `driver_charge`, `status`, `created_at`, `updated_at`) VALUES
(10, 'T3', 'uploads/truck-images/1704805624659d44f8ca93bistockphoto-804452846-612x612.jpg', 'load', 13.00, '1', '2024-01-03 07:11:02', '2024-01-09 07:07:04'),
(11, 'T2', 'uploads/truck-images/1704805602659d44e2b3afbexteriorbig4.jpg', 'distance', 12.00, '1', '2024-01-03 07:11:23', '2024-01-09 07:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `truck_type_details`
--

CREATE TABLE `truck_type_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `truck_type_id` varchar(255) DEFAULT NULL,
  `load_type` varchar(255) DEFAULT NULL,
  `rent_amount` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck_type_details`
--

INSERT INTO `truck_type_details` (`id`, `truck_type_id`, `load_type`, `rent_amount`, `created_at`, `updated_at`) VALUES
(5, '10', 'A', 12.00, '2024-01-03 07:11:02', '2024-01-03 07:11:02'),
(6, '10', 'C', 78.00, '2024-01-03 07:11:02', '2024-01-04 01:16:16'),
(7, '11', NULL, 12.00, '2024-01-03 07:11:23', '2024-01-03 07:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(40) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `otp_expired_at` timestamp NULL DEFAULT NULL,
  `is_verified` int(11) DEFAULT NULL,
  `wallet` varchar(255) DEFAULT NULL,
  `chat_expiry_date` timestamp NULL DEFAULT NULL,
  `premium_expiry_date` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(60) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 2 COMMENT 'Admin = 1\r\nDispatcher = 2\r\nDriver = 3\r\nCustomer = 4',
  `password` text DEFAULT NULL,
  `visible_password` varchar(255) DEFAULT NULL,
  `profile_image` varchar(256) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `otp`, `otp_expired_at`, `is_verified`, `wallet`, `chat_expiry_date`, `premium_expiry_date`, `address`, `email`, `token`, `name`, `phone`, `role`, `password`, `visible_password`, `profile_image`, `dob`, `device_token`, `status`, `created_at`, `updated_at`) VALUES
('7865', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin@gmail.com', NULL, 'Jack Rose', '12345678', 1, '$2y$10$kJ5cYJxY51rQL5v4aOPUouMLfISAC4uTS6FDHyuo6rXxCKTG0gRs.', NULL, 'uploads/user-images/170533771565a56373f241bunnamed.webp', '1970-01-01', NULL, 1, '2023-05-07 11:15:50', '2024-01-15 10:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` varchar(40) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amol_videos`
--
ALTER TABLE `amol_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channel_subscribers`
--
ALTER TABLE `channel_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_ads`
--
ALTER TABLE `custom_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_channels`
--
ALTER TABLE `live_channels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_requests`
--
ALTER TABLE `message_requests`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_amol_videos`
--
ALTER TABLE `premium_amol_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `premium_videos`
--
ALTER TABLE `premium_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regular_amol_videos`
--
ALTER TABLE `regular_amol_videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `right`
--
ALTER TABLE `right`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_right`
--
ALTER TABLE `role_right`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`,`right_id`),
  ADD KEY `right_id` (`right_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tafsirs`
--
ALTER TABLE `tafsirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_types`
--
ALTER TABLE `truck_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `truck_type_details`
--
ALTER TABLE `truck_type_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amol_videos`
--
ALTER TABLE `amol_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `channels`
--
ALTER TABLE `channels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `channel_subscribers`
--
ALTER TABLE `channel_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `custom_ads`
--
ALTER TABLE `custom_ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_channels`
--
ALTER TABLE `live_channels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `message_requests`
--
ALTER TABLE `message_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `premium_amol_videos`
--
ALTER TABLE `premium_amol_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `premium_videos`
--
ALTER TABLE `premium_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `regular_amol_videos`
--
ALTER TABLE `regular_amol_videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `right`
--
ALTER TABLE `right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_right`
--
ALTER TABLE `role_right`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tafsirs`
--
ALTER TABLE `tafsirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `truck_types`
--
ALTER TABLE `truck_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `truck_type_details`
--
ALTER TABLE `truck_type_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
