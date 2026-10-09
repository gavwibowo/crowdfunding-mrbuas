-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2026 at 08:22 PM
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
-- Database: `mr_buas`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `target_amount` bigint(20) NOT NULL,
  `current_amount` bigint(20) DEFAULT 0,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `category`, `target_amount`, `current_amount`, `description`, `image`, `created_at`) VALUES
(1, 'bantu devin beli hp ip 14 pro max 256 gb', 'lifestyle devin', 10000000, 4000000, 'Penggalangan dana untuk membantu devin membeli HP impian dia untuk sombong di story ig.', 'devin-hp.jpeg', '2026-10-08 01:45:39'),
(6, 'dsdsdsd', 'Tanggap Bencana', 44444, 0, 'sfdsdfd', 'hero-home.jpg', '2026-10-08 17:09:31');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `campaign_name` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `donor_name` varchar(150) DEFAULT 'Hamba Allah',
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `is_anonymous` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `name`, `email`, `phone`, `is_anonymous`, `created_at`, `updated_at`) VALUES
(2, 'Devin Maulana', 'devintest123@gmail.com', '081234567890', 1, '2026-10-09 09:22:31', '2026-10-09 09:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `type` enum('bank','ewallet') NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `owner_name` varchar(150) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `bank_name`, `type`, `account_number`, `owner_name`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BCA', 'bank', '1234567890', 'Yayasan MR. BUAS', NULL, 'aktif', '2026-10-09 07:49:12', '2026-10-09 07:49:12'),
(2, 'BRI', 'bank', '9876543210', 'Yayasan MR. BUAS', NULL, 'aktif', '2026-10-09 07:49:12', '2026-10-09 07:49:12'),
(3, 'Bank Mandiri', 'bank', '1122334455', 'Yayasan MR. BUAS', NULL, 'aktif', '2026-10-09 07:49:12', '2026-10-09 07:49:12'),
(4, 'DANA', 'ewallet', '081234567890', 'MR. BUAS', NULL, 'aktif', '2026-10-09 07:49:12', '2026-10-09 07:49:12'),
(5, 'BCA', 'bank', '240679802', 'GAVIN BOWO', NULL, 'aktif', '2026-10-09 09:20:11', '2026-10-09 09:20:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `fk_donations_campaigns` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_donations_payment_methods` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
