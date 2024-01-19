-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2024 at 03:20 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truck_dispatch`
--

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ac_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ac_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1 = Pending, 2 = Accepted, 0 = Rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `driver_id`, `ac_holder`, `ac_no`, `transaction_id`, `amount`, `document`, `status`, `created_at`, `updated_at`) VALUES
(1, '7784', 'Driver 1', 'alsdfk234234', 'asdfasdfj23432', '123', 'uploads/deposit-images/1704714928659be2b0cb1e3c8075f25bd374f50813b55467b29db7f.jpg', 1, '2024-01-08 05:55:28', '2024-01-12 02:11:29'),
(2, '7784', 'Driver 1', 'alsdfk234234', 'asdfasdfj23432', '123', 'uploads/deposit-images/1704714928659be2b0cb1e3c8075f25bd374f50813b55467b29db7f.jpg', 2, '2024-01-08 05:55:28', '2024-01-12 03:30:23'),
(3, '7784', 'Driver 1', 'alsdfk234234', 'asdfasdfj23432', '123', 'uploads/deposit-images/1704714928659be2b0cb1e3c8075f25bd374f50813b55467b29db7f.jpg', 0, '2024-01-08 05:55:28', '2024-01-12 00:57:37');

-- --------------------------------------------------------

--
-- Table structure for table `driver_histories`
--

CREATE TABLE `driver_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=Assigned,\r\n2=Driver Declined,\r\n3=Driver Accept,\r\n4=Driver Start,\r\n5=Driver Completed,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_histories`
--

INSERT INTO `driver_histories` (`id`, `order_id`, `driver_id`, `status`, `created_at`, `updated_at`) VALUES
(14, 'RID251215', '7784', '1', '2024-01-15 05:22:12', '2024-01-15 07:05:25'),
(15, 'RID251215', '7785', '1', '2024-01-15 05:22:30', '2024-01-15 05:22:30');

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
(1, '2023_12_29_080216_create_content_categories_table', 1),
(2, '2023_12_29_080244_create_contents_table', 2),
(3, '2024_01_03_081239_create_truck_types_table', 3),
(4, '2024_01_03_110619_create_truck_type_details_table', 4),
(5, '2024_01_05_061653_create_orders_table', 5),
(6, '2024_01_05_113511_create_driver_histories_table', 6),
(7, '2024_01_08_112959_create_deposits_table', 7),
(8, '2024_01_11_075613_create_ratings_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `truck_type_details_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drop_lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drop_lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pickup_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drop_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_truck` int(11) DEFAULT NULL,
  `driver_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipment_item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` double(8,2) DEFAULT NULL,
  `fare` double(8,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1=Pending,\r\n2=Driver Assigned,\r\n3=User declined,\r\n4=Dispatcher Cancel,\r\n5=Driver Cancel,\r\n6=Driver Accept,',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `truck_type_details_id`, `pick_lat`, `pick_lng`, `drop_lat`, `drop_lng`, `pickup_location`, `drop_location`, `pick_date`, `pick_time`, `no_of_truck`, `driver_1`, `driver_2`, `shipment_item`, `note`, `payment_method`, `distance`, `fare`, `status`, `created_at`, `updated_at`) VALUES
('RID251215', '9177', '6', '23.7514376', '90.3808357', '23.804093', '90.4152376', '50 Lake Circus Rd, Dhaka 1205, Bangladesh', '9JF2+V45, Rajshahi, Bangladesh', '2024-01-11', '9:32 PM', 2, NULL, NULL, 'House', 'seld', NULL, 11.00, 78.00, '2', '2024-01-10 00:32:47', '2024-01-15 07:05:25'),
('RID321905', '9177', '7', '23.7514366', '90.3808286', '23.804093', '90.4152376', '50 Lake Circus Rd, Dhaka 1205, Bangladesh', '13/2 east madartak .Singapore road .basaboo, ঢাকা 1212, Bangladesh', '2024-01-17', '6:43 PM', 6, NULL, NULL, 'xjdh', 'xjdj', NULL, 10.00, 120.00, '3', '2024-01-15 04:44:08', '2024-01-15 04:52:04'),
('RID390014', '9177', '6', '23.7514321', '90.3808274', '23.804093', '90.4152376', '50 Lake Circus Rd, Dhaka 1205, Bangladesh', '13/2 east madartak .Singapore road .basaboo, ঢাকা 1212, Bangladesh', '2024-01-18', '8:53 PM', 6, NULL, NULL, NULL, 'jsjsj', NULL, 10.00, 12.00, '3', '2024-01-15 04:53:35', '2024-01-15 04:53:44'),
('RID513119', '9177', '7', '23.7514358', '90.3808295', '24.3746497', '88.60036649999999', '50 Lake Circus Rd, Dhaka 1205, Bangladesh', '9JF2+V45, Rajshahi, Bangladesh', '2024-01-11', '10:32 PM', 2, NULL, NULL, 'House', 'orfactor', NULL, 256.00, 3072.00, '1', '2024-01-10 00:32:24', '2024-01-11 07:18:18'),
('RID816653', '9177', '7', '24.3746497', '88.60036649999999', '23.804093', '90.4152376', '9JF2+V45, Rajshahi, Bangladesh', '50 Lake Circus Rd, Dhaka 1205, Bangladesh', '2024-01-11', '6:33 PM', 2, NULL, NULL, 'Items', 'self', NULL, 247.00, 2964.00, '3', '2024-01-10 00:33:17', '2024-01-15 04:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `driver_id`, `order_id`, `rating`, `feedback`, `created_at`, `updated_at`) VALUES
(1, '2250', '7784', NULL, '4', NULL, NULL, NULL),
(2, '2250', '7784', NULL, '5', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `right`
--

CREATE TABLE `right` (
  `id` int(11) NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2023-05-07 11:16:21', '2023-05-07 11:16:21'),
(2, 'Dispatcher', '2023-05-07 11:16:21', '2023-05-07 11:16:21'),
(3, 'Driver', '2023-05-16 04:15:06', '2023-05-16 04:15:06'),
(4, 'Customer', '2024-01-08 04:59:02', '2024-01-08 04:59:02');

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
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'application_name', 'Truck Ease', 1, '2023-05-21 22:34:50', '2024-01-01 05:51:51'),
(2, 'site_logo', '1704290814659569fe6aac31703857120658ecbe042912c397650ba24f8fd28ec1bc043b45315f.png', 1, '2023-05-21 22:59:19', '2024-01-03 08:06:54'),
(3, 'site_favicon', '1704290814659569fe6b63f1703857120658ecbe042912c397650ba24f8fd28ec1bc043b45315f.png', 1, '2023-05-21 23:09:36', '2024-01-03 08:06:54'),
(4, 'application_phone', '+1 (905) 790-8640', 1, '2023-05-21 23:11:44', '2023-05-21 23:12:29'),
(5, 'application_email', 'info@truck.ca', 1, '2023-05-21 23:12:29', '2024-01-01 02:46:16'),
(6, 'application_toll_free', '+1 (877) 687-7253', 1, '2023-05-21 23:20:49', '2023-05-21 23:20:49'),
(7, 'application_fax', '+1 (905) 790-3740', 1, '2023-05-21 23:20:49', '2023-05-21 23:20:49'),
(8, 'application_address', '8 Automatic Rd. Building C, Unit #6 Brampton, Ontario L6S 5N4, Canada', 1, '2023-05-21 23:20:49', '2023-05-21 23:20:49'),
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
(20, 'youtube_link', 'https://www.youtube.com/', 1, '2023-07-03 05:45:16', '2023-12-21 05:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `truck_types`
--

CREATE TABLE `truck_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rent_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_charge` double(8,2) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `truck_type_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `load_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_amount` float NOT NULL DEFAULT 0,
  `token` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 2 COMMENT 'Admin = 1\r\nDispatcher = 2\r\nDriver = 3\r\nCustomer = 4',
  `password` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 4,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expiry` timestamp NOT NULL DEFAULT current_timestamp(),
  `driving_experience` float DEFAULT NULL,
  `driving_license_front` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driving_license_back` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_truck_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `wallet_amount`, `token`, `name`, `user_name`, `gender`, `address`, `email`, `phone`, `role`, `password`, `visible_password`, `profile_image`, `date_of_birth`, `status`, `otp`, `otp_expiry`, `driving_experience`, `driving_license_front`, `driving_license_back`, `driver_truck_type`, `device_token`, `created_at`, `updated_at`) VALUES
('2250', 0, NULL, 'cybyp@mailinator.com', NULL, 'male', NULL, 'vuka@mailinator.com', 'tazynax@mailinator.com', 3, NULL, NULL, 'uploads/user-images/1704883345659e749107ca5294525.jpeg', NULL, 1, NULL, '2024-01-10 10:09:55', 12, 'uploads/user-images/1704883333659e7485de7863.jpg', 'uploads/user-images/1704883326659e747e34371294525.jpeg', '6', NULL, '2024-01-10 04:09:55', '2024-01-10 04:42:25'),
('4653', 0, '2Dy6MhuZKLR7irPnTYxVGBFTE3L7BhrAR7VjCRFP0bucEPxTU3IjAQlJBPYm', 'John Bhai', NULL, 'male', '2464 Royal Ln. Mesa, New Jersey 45463', 'asdfasd', '1234', 4, NULL, NULL, 'uploads/user-images/1704959627659f9e8b299141.png', NULL, 0, NULL, '2024-01-01 08:28:01', NULL, NULL, NULL, NULL, 'asfasdfasdfasdfasdfsa', '2024-01-01 02:28:01', '2024-01-11 02:25:27'),
('5139', 0, 'HzS9R8LdgyeCHDiefcbewsWMrZiMoRzComrvBJopL9GJzJRKYv4Xft5V8PkL', 'Dispatcher 1', NULL, NULL, NULL, 'dispatcher1@gmail.com', '123456', 2, '$2y$10$3/UEOkmms7I2pwOV7iB5qObJnrfxGRyzvPiiZNKj27YDUmuLVv//q', 'password1', 'uploads/user-images/1704966338659fb8c2d83061.png', NULL, 1, NULL, '2024-01-10 14:20:30', NULL, NULL, NULL, NULL, NULL, '2024-01-10 08:20:30', '2024-01-11 03:45:38'),
('7784', 123, '2cQjwpIcwFDN0hrE6zSlzja0XGqp8iT2yZ95blsRCHAcWPJclb6WfZw82DjK', 'Driver 1', NULL, 'male', 'asfasd', 'driver1@gmail.com', '123451', 3, NULL, NULL, 'uploads/user-images/1704691603659b8793ed5ba1.png', NULL, 1, NULL, '2024-01-08 05:26:43', 1, 'uploads/user-images/1704691603659b8793f116d1.png', 'uploads/user-images/1704691603659b8793f15ed1.png', '7', NULL, '2024-01-07 23:26:43', '2024-01-12 03:30:23'),
('7785', 0, 'izCJiBXU3bsspqYShq9CBFdNvExSyeuEtr9DaLjRO50cXT0owLMDj9jGn8Zh', 'Driver 2', NULL, 'male', 'asfasd', 'driver2@gmail.com', '123452', 3, NULL, NULL, 'uploads/user-images/1704691603659b8793ed5ba1.png', NULL, 1, NULL, '2024-01-08 05:26:43', 1, 'uploads/user-images/1704691603659b8793f116d1.png', 'uploads/user-images/1704691603659b8793f15ed1.png', '6', NULL, '2024-01-07 23:26:43', '2024-01-07 23:26:44'),
('7865', 0, NULL, 'Jack Rose', 'admin', 'male', '2464 Royal Ln. Mesa, New Jersey 45463', 'admin@gmail.com', '12345678', 1, '$2y$10$kJ5cYJxY51rQL5v4aOPUouMLfISAC4uTS6FDHyuo6rXxCKTG0gRs.', NULL, 'uploads/user-images/17042905916595691fc3bee3.jpg', '1970-01-01', 1, '', '2024-01-01 06:13:30', NULL, NULL, NULL, NULL, NULL, '2023-05-07 11:15:50', '2024-01-03 08:04:28'),
('8980', 0, 'vNQUWlQBLGetoUjuZ6wb2bi5hXKPuwGovQTqVZxjnpdtR6L97l4qLz29P1J7', 'Razwanul Hasan', NULL, 'Male', 'hshddh', 'jsshshs@gmail.com', '+88001580398087', 4, NULL, NULL, 'uploads/user-images/1704804767659d419f833a31000009258.jpg', NULL, 1, NULL, '2024-01-09 12:52:47', NULL, NULL, NULL, NULL, NULL, '2024-01-09 06:52:47', '2024-01-09 06:52:47'),
('9177', 0, '4V8IjPmmZyDZPE4y2ujHMbbrKXOS6Q5QCg3887NfONhquB1csdap9dDNawC9', 'Razwanul Hasan', NULL, 'Male', 'orfactor', 'razwanulhasan@gmail.com', '+8801580398087', 4, NULL, NULL, 'uploads/user-images/1704784098659cf0e2862a6599d52c2-0044-4dd1-8c03-5d41b9863cda1390881553702976246.jpg', NULL, 1, NULL, '2024-01-09 07:08:18', NULL, NULL, NULL, NULL, NULL, '2024-01-09 01:08:18', '2024-01-10 00:45:27'),
('9646', 0, '5akkgc7A5tATmLf91SzmvzK23je4VpxxUyecAZuhV654NJWPnMWekK79XnAl', 'Driver 1', NULL, 'male', 'asfasd', 'asdfasdfasdfasdfsadfasd@gmail.com', '2345234523452345', 4, NULL, NULL, 'uploads/user-images/1704783595659ceeeb4ffdfc8075f25bd374f50813b55467b29db7f.jpg', NULL, 1, NULL, '2024-01-09 06:59:55', 1, NULL, NULL, '7', NULL, '2024-01-09 00:59:55', '2024-01-09 00:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_histories`
--
ALTER TABLE `driver_histories`
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
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
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
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `driver_histories`
--
ALTER TABLE `driver_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
