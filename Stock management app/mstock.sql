-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Sep 09, 2021 at 05:05 PM
-- Server version: 5.7.28
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mstock`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `supplier_id`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Imzouren Al hoceima 32000', NULL, NULL),
(2, NULL, 1, 'Tinghir 84500', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Category A', '2021-02-21 15:47:09', '2021-02-21 15:47:09'),
(2, 'Category B', '2021-02-21 15:47:09', '2021-02-21 15:47:09'),
(3, 'Category C', '2021-02-21 15:47:09', '2021-02-21 15:47:09');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `finalized` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `date`, `supplier_id`, `amount`, `finalized`, `created_at`, `updated_at`) VALUES
(1000, '2021-03-29 12:16:03', 1, '1500.00', 1, '2021-09-09 17:02:34', '2021-09-09 17:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `buying_cost` decimal(8,2) NOT NULL,
  `selling_cost` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `label`, `description`, `category_id`, `quantity`, `supplier_id`, `buying_cost`, `selling_cost`, `created_at`, `updated_at`) VALUES
(1, 'Product A', 'Lorem ipsum dolor sit amet, \r\nconsectetur adipiscing elit.', 1, 1510, 1, '120.00', '150.00', '2021-02-21 15:47:09', '2021-03-31 19:33:12'),
(2, 'Product B', 'Lorem ipsum dolor sit amet, \r\nconsectetur adipiscing elit.', 2, 2900, 1, '120.00', '150.00', '2021-02-21 15:47:09', '2021-03-31 19:40:25'),
(3, 'Product C', 'Lorem ipsum.', 1, 400, 1, '120.00', '150.00', '2021-02-21 15:47:09', '2021-03-26 10:25:55'),
(4, 'Product E', 'Lorem ipsum', 1, 300, 1, '120.00', '150.00', '2021-03-05 12:12:34', '2021-03-05 12:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(300) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2021-09-09 16:22:21', '2021-09-09 16:22:21'),
(2, 'Employee', '2021-09-09 16:22:21', '2021-09-09 16:22:21');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
CREATE TABLE IF NOT EXISTS `shipments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `shipment_type_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `finalized` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shipment_type_id` (`shipment_type_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1018 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `date`, `shipment_type_id`, `quantity`, `product_id`, `total_price`, `finalized`, `created_at`, `updated_at`) VALUES
(1000, '2021-03-10', 1, 400, 1, '500.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1002, '2021-03-30', 1, 300, 1, '1300.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1007, '2021-03-31', 1, 300, 4, '1300.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1008, '2020-10-13', 1, 200, 3, '3245.00', 1, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1009, '2021-02-16', 2, 211, 4, '31650.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1010, '2021-01-01', 2, 400, 1, '60000.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1011, '2021-02-16', 2, 500, 2, '75000.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1012, '2021-04-13', 2, 200, 2, '30000.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1013, '2021-03-29', 2, 70, 2, '10500.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1014, '2021-05-12', 2, 30, 1, '4500.00', 0, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1015, '2021-07-08', 2, 100, 2, '15000.00', 1, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1016, '2021-08-10', 1, 10, 1, '1500.00', 1, '2021-09-09 16:57:34', '2021-09-09 16:57:34'),
(1017, '2021-09-28', 2, 30, 1, '4500.00', 1, '2021-09-09 16:57:34', '2021-09-09 16:57:34');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_types`
--

DROP TABLE IF EXISTS `shipment_types`;
CREATE TABLE IF NOT EXISTS `shipment_types` (
  `id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shipment_types`
--

INSERT INTO `shipment_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Incoming', '2021-09-09 16:46:16', '2021-09-09 16:46:16'),
(2, 'Outgoing', '2021-09-09 16:46:16', '2021-09-09 16:46:16');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'Mohamed', 'Mohamed', 'mohamed@gmail.com', '12345678', '2021-02-21 15:47:09', '2021-02-21 15:47:09'),
(2, 'Ali', 'Ali', 'Ali@gmail.com', '123456789', '2021-02-21 15:47:09', '2021-03-22 13:21:01'),
(3, 'Jamal', 'Jamal', 'jamal@gmail.com', '12345678', '2021-02-21 15:47:09', '2021-02-21 15:47:09'),
(4, 'Mohcine', 'BAADI', 'baadimohsin@gmail.com', '123456789', '2021-03-05 12:59:39', '2021-03-05 12:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mohcine', 'BAADI', '12345678', 1, 'admin@gmail.com', NULL, '$2y$10$V2gIR1ECLM6Y6QmeBLUhHeqPfI8.mRteLlmvrCTDj2ZqKQMu6k48q', 'kTueOnMfLLpyUW1aJH6UOeZNswA76WoHokdIxajMLqe9l6IMEEiVykC375eR', '2021-02-21 15:47:09', '2021-03-25 19:54:36'),
(2, 'someone', 'BAADI', '1234234523', 2, 'ba3di1999@gmail.com', NULL, '$2y$10$b95l/xYKX1AHokBIvCLxT.lM2P/Hl3itcEQqCMdfHXbW4.kJfnKsO', NULL, '2021-03-22 15:12:55', '2021-03-22 15:42:52'),
(4, 'employee', 'employee', '123456789', 2, 'employee@gmail.com', NULL, '$2y$10$cwRGidyUBs3QYGTQz8TxmuHMIiXGtY1CpfJbeqyY6eb0Irf.K5q6i', NULL, '2021-03-23 11:47:46', '2021-03-30 10:02:55');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `addresses_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `shipments_ibfk_1` FOREIGN KEY (`shipment_type_id`) REFERENCES `shipment_types` (`id`),
  ADD CONSTRAINT `shipments_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
