-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 04:34 PM
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
-- Database: `ship_ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_discounts`
--

CREATE TABLE `add_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_title` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `finishDate` datetime NOT NULL,
  `discount_percentage` int(11) NOT NULL,
  `discountImg` varchar(255) NOT NULL,
  `discount_status` enum('active','inactive','fixed') NOT NULL,
  `discount_description` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_discounts`
--

INSERT INTO `add_discounts` (`id`, `discount_title`, `coupon_code`, `startDate`, `finishDate`, `discount_percentage`, `discountImg`, `discount_status`, `discount_description`, `user_id`, `created_at`, `updated_at`) VALUES
(0, 'asdas', 'asd', '2025-01-10 00:00:00', '2025-01-31 00:00:00', 0, 'https://res.cloudinary.com/dkqipbji0/image/upload/v1736448258/jamie-fenn-PEVG_cqrIVo-unsplash.jpg.jpg', 'fixed', 'dfsfgsdf', 1, '2025-01-09 12:56:24', '2025-02-23 03:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `arrival_points`
--

CREATE TABLE `arrival_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `arrival_point` varchar(50) NOT NULL,
  `arrival_time` varchar(50) NOT NULL,
  `arrival_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `departurePoints_id` bigint(20) UNSIGNED NOT NULL,
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `arrival_points`
--

INSERT INTO `arrival_points` (`id`, `arrival_point`, `arrival_time`, `arrival_date`, `departurePoints_id`, `shipDetails_id`, `created_at`, `updated_at`) VALUES
(1, 'Comilla', '07:00', '2025-01-07 18:00:00', 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(2, 'Comilla', '07:00', '2025-01-08 18:00:00', 2, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(3, 'Comilla', '07:00', '2025-01-09 18:00:00', 3, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(4, 'Comilla', '07:00', '2025-01-10 18:00:00', 4, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(5, 'Comilla', '07:00', '2025-01-11 18:00:00', 5, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(6, 'Comilla', '07:00', '2025-01-12 18:00:00', 6, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(7, 'Comilla', '07:00', '2025-01-13 18:00:00', 7, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(8, 'Comilla', '07:00', '2025-01-14 18:00:00', 8, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(9, 'Comilla', '07:00', '2025-01-15 18:00:00', 9, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(10, 'Comilla', '07:00', '2025-01-16 18:00:00', 10, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(11, 'Barisal', '09:45', '2025-01-07 18:00:00', 1, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(12, 'Barisal', '09:45', '2025-01-08 18:00:00', 2, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(13, 'Barisal', '09:45', '2025-01-09 18:00:00', 3, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(14, 'Barisal', '09:45', '2025-01-10 18:00:00', 4, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(15, 'Barisal', '09:45', '2025-01-11 18:00:00', 5, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(16, 'Barisal', '09:45', '2025-01-12 18:00:00', 6, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(17, 'Barisal', '09:45', '2025-01-13 18:00:00', 7, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(18, 'Barisal', '09:45', '2025-01-14 18:00:00', 8, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(19, 'Barisal', '09:45', '2025-01-15 18:00:00', 9, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(20, 'Barisal', '09:45', '2025-01-16 18:00:00', 10, 1, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(21, 'Comilla', '09:23', '2025-02-24 18:00:00', 11, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(22, 'Comilla', '09:23', '2025-02-25 18:00:00', 12, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(23, 'Comilla', '09:23', '2025-02-26 18:00:00', 13, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(24, 'Comilla', '09:23', '2025-02-27 18:00:00', 14, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(25, 'Comilla', '09:23', '2025-02-28 18:00:00', 15, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(26, 'Comilla', '09:23', '2025-03-01 18:00:00', 16, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(27, 'Comilla', '09:23', '2025-03-02 18:00:00', 17, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(28, 'Comilla', '09:23', '2025-03-03 18:00:00', 18, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(29, 'Comilla', '09:23', '2025-03-04 18:00:00', 19, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(30, 'Comilla', '09:23', '2025-03-05 18:00:00', 20, 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `departure_points`
--

CREATE TABLE `departure_points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `departure_point` varchar(50) NOT NULL,
  `departure_time` varchar(50) NOT NULL,
  `departure_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departure_points`
--

INSERT INTO `departure_points` (`id`, `departure_point`, `departure_time`, `departure_date`, `status`, `shipDetails_id`, `created_at`, `updated_at`) VALUES
(1, 'Dhaka', '05:00', '2025-01-07 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(2, 'Dhaka', '05:00', '2025-01-08 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(3, 'Dhaka', '05:00', '2025-01-09 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(4, 'Dhaka', '05:00', '2025-01-10 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(5, 'Dhaka', '05:00', '2025-01-11 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(6, 'Dhaka', '05:00', '2025-01-12 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(7, 'Dhaka', '05:00', '2025-01-13 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(8, 'Dhaka', '05:00', '2025-01-14 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(9, 'Dhaka', '05:00', '2025-01-15 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(10, 'Dhaka', '05:00', '2025-01-16 18:00:00', 'active', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(11, 'dhaka', '05:23', '2025-02-24 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(12, 'dhaka', '05:23', '2025-02-25 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(13, 'dhaka', '05:23', '2025-02-26 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(14, 'dhaka', '05:23', '2025-02-27 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(15, 'dhaka', '05:23', '2025-02-28 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(16, 'dhaka', '05:23', '2025-03-01 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(17, 'dhaka', '05:23', '2025-03-02 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(18, 'dhaka', '05:23', '2025-03-03 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(19, 'dhaka', '05:23', '2025-03-04 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(20, 'dhaka', '05:23', '2025-03-05 18:00:00', 'active', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total` varchar(50) NOT NULL,
  `payable` varchar(50) NOT NULL,
  `cus_details` varchar(500) NOT NULL,
  `tran_id` varchar(100) NOT NULL,
  `val_id` varchar(100) NOT NULL DEFAULT '0',
  `payment_status` varchar(255) NOT NULL,
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED NOT NULL,
  `departure_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `total`, `payable`, `cus_details`, `tran_id`, `val_id`, `payment_status`, `shipDetails_id`, `discount_id`, `departure_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, '333', '333', 'Name: KHAN AWSAFUR RAHMAN, Address: , City: , Phone: 01401453394', '67bcc831339f8', '0', 'Success', 2, 0, 11, 3, '2025-02-24 13:27:45', '2025-02-24 13:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_seats`
--

CREATE TABLE `invoice_seats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seat_tag` varchar(50) NOT NULL,
  `seat_price` varchar(50) NOT NULL,
  `discount_price` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `seatMap_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_seats`
--

INSERT INTO `invoice_seats` (`id`, `seat_tag`, `seat_price`, `discount_price`, `user_id`, `seatMap_id`, `invoice_id`, `created_at`, `updated_at`) VALUES
(1, '333-3', '333', '333', 3, 101, 3, '2025-02-24 13:27:45', '2025-02-24 13:27:45');

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
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_11_27_102704_create_users', 1),
(3, '2024_12_09_121155_create_shipDetails', 1),
(4, '2024_12_10_021737_create_refundPolicies', 1),
(5, '2024_12_10_033903_create_departurePoints', 1),
(6, '2024_12_10_033910_create_arrivalPoints', 1),
(7, '2024_12_10_033923_create_seatMaps', 1),
(8, '2024_12_27_050108_create_add_discounts_table', 1),
(9, '2024_12_29_084853_create_sslcommerz_accounts', 1),
(10, '2024_12_29_084933_create_invoices', 1),
(11, '2024_12_29_093707_create_invoice_seats', 1),
(12, '2025_01_02_231418_create_refund_histories', 1);

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
-- Table structure for table `refund_histories`
--

CREATE TABLE `refund_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(200) NOT NULL,
  `Refund_amount` varchar(255) NOT NULL DEFAULT '0',
  `Refund_status` varchar(50) NOT NULL,
  `invoices_id` bigint(20) UNSIGNED NOT NULL,
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `departure_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `refund_policy_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_policies`
--

CREATE TABLE `refund_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refund_category` varchar(255) NOT NULL,
  `refund_time` varchar(255) NOT NULL,
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refund_policies`
--

INSERT INTO `refund_policies` (`id`, `refund_category`, `refund_time`, `shipDetails_id`, `created_at`, `updated_at`) VALUES
(1, 'Full', '4', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(2, 'Half', '1', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(3, 'Full', '3', 2, '2025-02-24 13:23:53', '2025-02-24 13:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `seat_maps`
--

CREATE TABLE `seat_maps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(50) NOT NULL,
  `seat_in_rows` int(11) NOT NULL,
  `seat_in_columns` int(11) NOT NULL,
  `seat_tag` varchar(50) NOT NULL,
  `available_seats` int(11) NOT NULL,
  `seat_price` int(11) NOT NULL,
  `shipDetails_id` bigint(20) UNSIGNED NOT NULL,
  `arrivalPoints_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seat_maps`
--

INSERT INTO `seat_maps` (`id`, `category`, `seat_in_rows`, `seat_in_columns`, `seat_tag`, `available_seats`, `seat_price`, `shipDetails_id`, `arrivalPoints_id`, `created_at`, `updated_at`) VALUES
(1, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(2, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(3, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(4, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(5, 'Deck', 20, 5, 'dec', 100, 200, 1, 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(6, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 2, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(7, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 2, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(8, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 2, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(9, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 2, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(10, 'Deck', 20, 5, 'dec', 100, 200, 1, 2, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(11, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 3, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(12, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 3, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(13, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 3, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(14, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 3, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(15, 'Deck', 20, 5, 'dec', 100, 200, 1, 3, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(16, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 4, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(17, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 4, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(18, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 4, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(19, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 4, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(20, 'Deck', 20, 5, 'dec', 100, 200, 1, 4, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(21, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 5, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(22, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 5, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(23, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 5, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(24, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 5, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(25, 'Deck', 20, 5, 'dec', 100, 200, 1, 5, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(26, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 6, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(27, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 6, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(28, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 6, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(29, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 6, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(30, 'Deck', 20, 5, 'dec', 100, 200, 1, 6, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(31, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 7, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(32, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 7, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(33, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 7, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(34, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 7, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(35, 'Deck', 20, 5, 'dec', 100, 200, 1, 7, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(36, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 8, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(37, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 8, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(38, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 8, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(39, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 8, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(40, 'Deck', 20, 5, 'dec', 100, 200, 1, 8, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(41, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 9, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(42, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 9, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(43, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 9, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(44, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 9, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(45, 'Deck', 20, 5, 'dec', 100, 200, 1, 9, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(46, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 400, 1, 10, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(47, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 800, 1, 10, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(48, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 500, 1, 10, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(49, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1200, 1, 10, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(50, 'Deck', 20, 5, 'dec', 100, 200, 1, 10, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(51, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 11, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(52, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 11, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(53, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 11, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(54, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 11, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(55, 'Deck', 20, 5, 'dec', 100, 300, 1, 11, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(56, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 12, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(57, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 12, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(58, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 12, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(59, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 12, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(60, 'Deck', 20, 5, 'dec', 100, 300, 1, 12, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(61, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 13, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(62, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 13, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(63, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 13, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(64, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 13, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(65, 'Deck', 20, 5, 'dec', 100, 300, 1, 13, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(66, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 14, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(67, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 14, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(68, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 14, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(69, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 14, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(70, 'Deck', 20, 5, 'dec', 100, 300, 1, 14, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(71, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 15, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(72, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 15, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(73, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 15, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(74, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 15, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(75, 'Deck', 20, 5, 'dec', 100, 300, 1, 15, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(76, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 16, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(77, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 16, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(78, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 16, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(79, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 16, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(80, 'Deck', 20, 5, 'dec', 100, 300, 1, 16, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(81, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 17, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(82, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 17, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(83, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 17, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(84, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 17, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(85, 'Deck', 20, 5, 'dec', 100, 300, 1, 17, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(86, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 18, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(87, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 18, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(88, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 18, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(89, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 18, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(90, 'Deck', 20, 5, 'dec', 100, 300, 1, 18, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(91, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 19, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(92, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 19, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(93, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 19, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(94, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 19, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(95, 'Deck', 20, 5, 'dec', 100, 300, 1, 19, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(96, 'Economy (1st Floor)', 10, 4, 'eco1', 40, 600, 1, 20, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(97, 'Deluxe (1st Floor)', 6, 2, 'dex1', 12, 1000, 1, 20, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(98, 'Economy (2nd Floor)', 8, 4, 'eco2', 32, 650, 1, 20, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(99, 'Cabin (2nd Floor)', 4, 2, 'cab', 8, 1500, 1, 20, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(100, 'Deck', 20, 5, 'dec', 100, 300, 1, 20, '2025-01-07 12:02:26', '2025-01-07 12:02:26'),
(101, '333', 3, 3, '333', 8, 333, 2, 21, '2025-02-24 13:23:53', '2025-02-24 13:28:05'),
(102, '333', 3, 3, '333', 9, 333, 2, 22, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(103, '333', 3, 3, '333', 9, 333, 2, 23, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(104, '333', 3, 3, '333', 9, 333, 2, 24, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(105, '333', 3, 3, '333', 9, 333, 2, 25, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(106, '333', 3, 3, '333', 9, 333, 2, 26, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(107, '333', 3, 3, '333', 9, 333, 2, 27, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(108, '333', 3, 3, '333', 9, 333, 2, 28, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(109, '333', 3, 3, '333', 9, 333, 2, 29, '2025-02-24 13:23:53', '2025-02-24 13:23:53'),
(110, '333', 3, 3, '333', 9, 333, 2, 30, '2025-02-24 13:23:53', '2025-02-24 13:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `ship_details`
--

CREATE TABLE `ship_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ship_name` varchar(50) NOT NULL,
  `couch_no` varchar(50) NOT NULL,
  `ship_register_no` varchar(50) NOT NULL,
  `ship_manager_name` varchar(50) NOT NULL,
  `ship_manager_number` varchar(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ship_details`
--

INSERT INTO `ship_details` (`id`, `ship_name`, `couch_no`, `ship_register_no`, `ship_manager_name`, `ship_manager_number`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Adventure 10', 'AV-11556', 'Dha-65482', 'Jamal Uddin', '01711115162', 1, '2025-01-07 12:02:25', '2025-01-07 12:02:25'),
(2, 'asdas', 'asdasd', 'asdasd', 'asdasd', '333333', 1, '2025-02-24 13:23:53', '2025-02-24 13:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `sslcommerz_accounts`
--

CREATE TABLE `sslcommerz_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` varchar(255) NOT NULL,
  `store_passwd` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `success_url` varchar(255) NOT NULL,
  `fail_url` varchar(255) NOT NULL,
  `cancel_url` varchar(255) NOT NULL,
  `ipn_url` varchar(255) NOT NULL,
  `init_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sslcommerz_accounts`
--

INSERT INTO `sslcommerz_accounts` (`id`, `store_id`, `store_passwd`, `currency`, `success_url`, `fail_url`, `cancel_url`, `ipn_url`, `init_url`, `created_at`, `updated_at`) VALUES
(1, 'hello66a552364cdd9', 'hello66a552364cdd9@ssl', 'BDT', 'http://127.0.0.1:8000/PaymentSuccess', 'http://127.0.0.1:8000/PaymentFail', 'http://127.0.0.1:8000/PaymentCancel', 'http://127.0.0.1:8000/api/PaymentIPN', 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image_Url` varchar(255) NOT NULL,
  `delete_id` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email_verified` varchar(10) NOT NULL,
  `manager_verified` varchar(10) NOT NULL,
  `manager_status` enum('active','inactive','ban','pending') NOT NULL,
  `admin_verified` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `phone`, `role`, `address`, `image_Url`, `delete_id`, `gender`, `password`, `email_verified`, `manager_verified`, `manager_status`, `admin_verified`, `city`, `country`, `otp`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 'Admin', '01401453394', 'admin', '', '', '', '', '$2y$12$ONbDSh8MzUXvB6EaprR0ZOCSrEDAmsB/6NTiCcyRwvcKP/IdYgttC', 'true', '', 'ban', 'true', '', '', '0', '2025-01-07 08:54:14', '2025-01-07 14:56:47'),
(2, 'manager@gmai.com', 'Manager', '01401453394', 'manager', '', '', '', '', '$2y$12$B9pVyFNtYtw1iAC.gXI70ugaX1HnhSM0GVmtpM.4FotSh6clSIpMW', 'true', 'true', 'active', '', '', '', '0', '2025-01-07 09:01:22', '2025-01-07 15:02:57'),
(3, 'suhridkhan446@gmail.com', 'KHAN AWSAFUR RAHMAN', '01401453394', 'user', '', '', '', '', '$2y$12$vKKs/OP2lp2VmtcWTSGZ.uMYr7OknrLu3DDW4s0/1g9f421EQL4ES', 'true', '', 'inactive', '', '', '', '0', '2025-02-24 13:24:43', '2025-02-24 13:25:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_discounts`
--
ALTER TABLE `add_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_discounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `arrival_points`
--
ALTER TABLE `arrival_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arrival_points_departurepoints_id_foreign` (`departurePoints_id`),
  ADD KEY `arrival_points_shipdetails_id_foreign` (`shipDetails_id`);

--
-- Indexes for table `departure_points`
--
ALTER TABLE `departure_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departure_points_shipdetails_id_foreign` (`shipDetails_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_shipdetails_id_foreign` (`shipDetails_id`),
  ADD KEY `invoices_discount_id_foreign` (`discount_id`),
  ADD KEY `invoices_departure_id_foreign` (`departure_id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`);

--
-- Indexes for table `invoice_seats`
--
ALTER TABLE `invoice_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_seats_user_id_foreign` (`user_id`),
  ADD KEY `invoice_seats_seatmap_id_foreign` (`seatMap_id`),
  ADD KEY `invoice_seats_invoice_id_foreign` (`invoice_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `refund_histories`
--
ALTER TABLE `refund_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_histories_invoices_id_foreign` (`invoices_id`),
  ADD KEY `refund_histories_shipdetails_id_foreign` (`shipDetails_id`),
  ADD KEY `refund_histories_departure_id_foreign` (`departure_id`),
  ADD KEY `refund_histories_user_id_foreign` (`user_id`),
  ADD KEY `refund_histories_refund_policy_id_foreign` (`refund_policy_id`);

--
-- Indexes for table `refund_policies`
--
ALTER TABLE `refund_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_policies_shipdetails_id_foreign` (`shipDetails_id`);

--
-- Indexes for table `seat_maps`
--
ALTER TABLE `seat_maps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seat_maps_shipdetails_id_foreign` (`shipDetails_id`),
  ADD KEY `seat_maps_arrivalpoints_id_foreign` (`arrivalPoints_id`);

--
-- Indexes for table `ship_details`
--
ALTER TABLE `ship_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ship_details_user_id_foreign` (`user_id`);

--
-- Indexes for table `sslcommerz_accounts`
--
ALTER TABLE `sslcommerz_accounts`
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
-- AUTO_INCREMENT for table `add_discounts`
--
ALTER TABLE `add_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `arrival_points`
--
ALTER TABLE `arrival_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `departure_points`
--
ALTER TABLE `departure_points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_seats`
--
ALTER TABLE `invoice_seats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_histories`
--
ALTER TABLE `refund_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_policies`
--
ALTER TABLE `refund_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `seat_maps`
--
ALTER TABLE `seat_maps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `ship_details`
--
ALTER TABLE `ship_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sslcommerz_accounts`
--
ALTER TABLE `sslcommerz_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_discounts`
--
ALTER TABLE `add_discounts`
  ADD CONSTRAINT `add_discounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `arrival_points`
--
ALTER TABLE `arrival_points`
  ADD CONSTRAINT `arrival_points_departurepoints_id_foreign` FOREIGN KEY (`departurePoints_id`) REFERENCES `departure_points` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `arrival_points_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `departure_points`
--
ALTER TABLE `departure_points`
  ADD CONSTRAINT `departure_points_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_departure_id_foreign` FOREIGN KEY (`departure_id`) REFERENCES `departure_points` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `add_discounts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `invoice_seats`
--
ALTER TABLE `invoice_seats`
  ADD CONSTRAINT `invoice_seats_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_seats_seatmap_id_foreign` FOREIGN KEY (`seatMap_id`) REFERENCES `seat_maps` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_seats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `refund_histories`
--
ALTER TABLE `refund_histories`
  ADD CONSTRAINT `refund_histories_departure_id_foreign` FOREIGN KEY (`departure_id`) REFERENCES `departure_points` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_histories_invoices_id_foreign` FOREIGN KEY (`invoices_id`) REFERENCES `invoices` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_histories_refund_policy_id_foreign` FOREIGN KEY (`refund_policy_id`) REFERENCES `refund_policies` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_histories_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `refund_policies`
--
ALTER TABLE `refund_policies`
  ADD CONSTRAINT `refund_policies_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `seat_maps`
--
ALTER TABLE `seat_maps`
  ADD CONSTRAINT `seat_maps_arrivalpoints_id_foreign` FOREIGN KEY (`arrivalPoints_id`) REFERENCES `arrival_points` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seat_maps_shipdetails_id_foreign` FOREIGN KEY (`shipDetails_id`) REFERENCES `ship_details` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `ship_details`
--
ALTER TABLE `ship_details`
  ADD CONSTRAINT `ship_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
