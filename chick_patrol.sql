-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2023 at 12:45 PM
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
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`id`, `name`, `deleted_at`) VALUES
(106, 'barangay 1', NULL),
(107, 'barangay 5', NULL),
(108, 'barangay 4', NULL),
(109, 'barangay 3', NULL),
(110, 'Hashim King', NULL),
(112, 'Hashim Kingf', NULL);

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
(1, 'cat 1', NULL),
(2, 'cat 2', NULL),
(3, 'cat 3', NULL),
(4, 'cat 52', NULL),
(5, 'cat 4', NULL),
(6, 'cat 5', NULL);

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
(33, 'Hayes', 'Richard Hanson', 'Schneider', 11, '09111111111', 'arconleemar0726@gmail.com', 'Veritatis sint debi', '2021-11-25', 'Male', '$2y$10$v8e0dgHW0hLF1Q.wOJiTdeoJXLjCzcWVB6uH6lzubDk.9PY8vb4Ly', '2023-06-10 12:49:40', 1, 0),
(34, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(35, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(36, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(37, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(38, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(39, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(40, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(41, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(42, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(43, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(44, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(45, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(46, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(47, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(48, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(49, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(50, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(51, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(52, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(53, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(54, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(55, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(56, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(57, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0),
(58, 'first name', 'middle name', 'last name', 106, '09511177784', 'email@gmail.com', 'street 1', '1999-07-26', '', '87654321', '2023-06-01 08:58:28', 0, 0);

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
-- Indexes for table `email_codes`
--
ALTER TABLE `email_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_password_code`
--
ALTER TABLE `reset_password_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_codes`
--
ALTER TABLE `email_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `reset_password_code`
--
ALTER TABLE `reset_password_code`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
