-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2024 at 03:08 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsnp`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_email`, `product_id`, `order_date`) VALUES
(9, 'satish@gmail.com', 19, '2024-05-05 14:09:22'),
(10, 'satish@gmail.com', 22, '2024-05-05 14:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `img_path`, `created_at`, `updated_at`) VALUES
(16, 'nepal jersey', 1500.00, '../uploads/662cd7b6e4388.jpg', '2024-04-27 10:47:18', '2024-04-27 10:47:18'),
(17, 'football', 700.00, '../uploads/662cd7d19dcfb.jpg', '2024-04-27 10:47:45', '2024-04-27 10:47:45'),
(18, 'sport bag', 2000.00, '../uploads/662cd7e506547.jpg', '2024-04-27 10:48:05', '2024-04-27 10:48:05'),
(19, 'gloves', 1200.00, '../uploads/662cd7f88948d.jpg', '2024-04-27 10:48:24', '2024-04-27 10:48:24'),
(20, 'football boot', 2500.00, '../uploads/662cd8113fabc.jpg', '2024-04-27 10:48:49', '2024-04-27 10:48:49'),
(21, 'football socks', 500.00, '../uploads/662cd826aa49c.jpg', '2024-04-27 10:49:10', '2024-04-27 10:49:10'),
(22, 'badminton', 2000.00, '../uploads/662cda48c1db0.webp', '2024-04-27 10:58:16', '2024-04-27 10:58:16'),
(23, 'badminton cock', 100.00, '../uploads/662cda5fb080f.webp', '2024-04-27 10:58:39', '2024-04-27 10:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `password`, `is_admin`) VALUES
(1, 'satish', 'satish@gmail.com', 9811212121, '$2y$10$OrWkKA9uQuBDL0camB.TH.Xw9YjpJ.5NNWTK8bjgtIpMoBu0TeHku', NULL),
(3, 'sameer gurung', 'sameer@gmail.com', 9826666666, '$2y$10$l1qRoR9JE2p/aO64J8m.c.7uf4GTBfQvdDcVgwYz9pdKr028ytr/K', 1),
(4, 'bijay chalaune', 'bijay@gmail.com', 9856222222, '$2y$10$AYjpSvAMSclQUIdD1nVKBuRA7hv0xh5RarKjunllJdBOaCbVldaxm', NULL),
(5, 'srijan maharjan', 'srijan@gmail.com', 9856565656, '$2y$10$0KyVi6jCkorqrYAXfkJHkOMMFm5Y1WloquSogoHROg.D16Ty8oIrG', NULL),
(6, 'rayyan', 'rayyan@gmail.com', 9812345678, '$2y$10$OrWkKA9uQuBDL0camB.TH.Xw9YjpJ.5NNWTK8bjgtIpMoBu0TeHku', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
