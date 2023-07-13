-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 13, 2023 at 06:11 AM
-- Server version: 8.0.32
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chick_patrol`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `delivery_fee` double NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `name`, `delivery_fee`, `updated_at`, `added_at`, `deleted_at`) VALUES
(119, 'Lumangbayan', 15, '2023-07-13 13:10:10', '2023-07-13 13:01:23', NULL),
(120, 'Calsapa', 20, '2023-07-13 13:10:22', '2023-07-13 13:04:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `deleted_at`) VALUES
(8, 'Dessert', NULL),
(9, 'Drinks', NULL),
(10, 'Main Dish', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_fee_history`
--

CREATE TABLE `delivery_fee_history` (
  `id` int NOT NULL,
  `barangay_id` int NOT NULL,
  `delivery_fee` double NOT NULL,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `delivery_fee_history`
--

INSERT INTO `delivery_fee_history` (`id`, `barangay_id`, `delivery_fee`, `added_at`) VALUES
(14, 119, 25, '2023-07-13 13:01:23'),
(15, 119, 15, '2023-07-13 13:07:31'),
(16, 119, 152, '2023-07-13 13:08:54'),
(17, 119, 150, '2023-07-13 13:09:59'),
(18, 120, 123, '2023-07-13 13:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `email_codes`
--

CREATE TABLE `email_codes` (
  `id` int NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `category` int NOT NULL,
  `description` varchar(800) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(300) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `description`, `available`, `image`, `updated_at`, `date_added`) VALUES
(27, 'Coca-cola', 21, 9, 'Malamig hehe', 1, '09c8d33176e1b5a285dcbec4e44b5603be21ab93.png', '2023-07-13 13:35:42', '2023-07-13 13:18:44'),
(28, 'Sprite Mismo', 17, 9, 'Malamig din hehe', 1, 'e1254133160a1d18de407e03a6585e20d17bc5f0.jpg', '2023-07-13 13:22:47', '2023-07-13 13:22:47'),
(29, 'Cupcake', 80, 8, 'Cupcake na pink', 1, '63adab1b4c720f03e655bbf9744466ebf47abef1.png', '2023-07-13 13:27:41', '2023-07-13 13:27:17'),
(30, 'Ice Cream', 25, 8, 'Masarap na ice cream', 1, 'ed665b1c4cb1ccd0d28b868b40dcdc380f0286cd.png', '2023-07-13 13:38:27', '2023-07-13 13:38:27'),
(31, 'Pancit Bihon', 189, 10, 'Pancit sa imong bahay', 1, '462840db64534d91a0a654b7a480b75f0c9fde4e.png', '2023-07-13 13:59:07', '2023-07-13 13:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `product_price_history`
--

CREATE TABLE `product_price_history` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` double NOT NULL,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_price_history`
--

INSERT INTO `product_price_history` (`id`, `product_id`, `price`, `added_at`) VALUES
(10, 29, 627, '2023-07-13 13:27:17'),
(11, 27, 18, '2023-07-13 13:18:44'),
(12, 27, 17, '2023-07-13 13:35:27'),
(13, 27, 19, '2023-07-13 13:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password_code`
--

CREATE TABLE `reset_password_code` (
  `id` int NOT NULL,
  `email` varchar(300) NOT NULL,
  `code` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `middle_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `barangay` int NOT NULL,
  `contact` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birth_date` date NOT NULL,
  `sex` varchar(6) NOT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `is_admin` tinyint NOT NULL DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `barangay`, `contact`, `email`, `street`, `birth_date`, `sex`, `password`, `verified_at`, `is_admin`, `is_banned`) VALUES
(141, 'Chick', NULL, 'Patrol', 120, '09111111111', 'chick.patrol.2023@gmail.com', 'Barangay Road', '1999-07-26', 'm', '$2y$10$4IzUsrGWL8H857.On4ySG.A9PSdml.PGXnnsJR9Ny.AhgiCcJKO9.', '2023-07-01 05:31:50', 1, 0),
(142, 'Maisie', 'Christian Brennan', 'Phillips', 120, '09111111111', 'user.test@gmail.com', 'Suha', '1998-06-06', 'Female', '$2y$10$4IzUsrGWL8H857.On4ySG.A9PSdml.PGXnnsJR9Ny.AhgiCcJKO9.', '2023-07-13 05:31:32', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_fee_history`
--
ALTER TABLE `delivery_fee_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `email_codes`
--
ALTER TABLE `email_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `product_price_history`
--
ALTER TABLE `product_price_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reset_password_code`
--
ALTER TABLE `reset_password_code`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay` (`barangay`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery_fee_history`
--
ALTER TABLE `delivery_fee_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `email_codes`
--
ALTER TABLE `email_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `product_price_history`
--
ALTER TABLE `product_price_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reset_password_code`
--
ALTER TABLE `reset_password_code`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email_codes`
--
ALTER TABLE `email_codes`
  ADD CONSTRAINT `email_codes_ibfk_1` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_price_history`
--
ALTER TABLE `product_price_history`
  ADD CONSTRAINT `product_price_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `reset_password_code`
--
ALTER TABLE `reset_password_code`
  ADD CONSTRAINT `reset_password_code_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`barangay`) REFERENCES `barangays` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
