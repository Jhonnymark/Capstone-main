-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2024 at 03:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `street` varchar(225) NOT NULL,
  `barangay` varchar(225) NOT NULL,
  `municipality` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `street`, `barangay`, `municipality`) VALUES
(1, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(2, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(3, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(4, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(5, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(7, 'Dike', 'Apitong', 'Naujan'),
(9, 'Dike', 'Apitong', 'Naujan'),
(10, 'cuatres', 'Sta Maria', 'Naujan'),
(11, 'cuatres', 'Sta Maria', 'Naujan'),
(13, 'Simbad', 'Sta Maria', 'Naujan'),
(15, 'Dike', 'Apitong', 'Naujan'),
(16, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(17, 'Dike', 'Sta Maria', 'Naujan'),
(18, 'Dike', 'Sta Maria', 'Naujan'),
(19, 'Dike', 'Sta Maria', 'Naujan'),
(20, 'Maibon', 'Sta Maria', 'Naujan'),
(21, 'Maibon', 'Sta Maria', 'Naujan'),
(22, 'Maibon', 'Sta Maria', 'Naujan'),
(23, 'Maibon', 'Sta Maria', 'Naujan'),
(24, 'Maibon', 'Sta Maria', 'Naujan'),
(25, 'Dike', 'Sta Maria', 'Naujan'),
(26, 'Dike', 'Sta Maria', 'Naujan'),
(27, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(28, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(29, 'Dike', 'Sta Maria', 'Naujan'),
(30, 'Dike', 'Sta Maria', 'Naujan'),
(31, 'cuatres', 'Sta Maria', 'Naujan'),
(33, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(34, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(36, 'cuatres', 'Sta Maria', 'Naujan'),
(37, 'Dike', 'Apitong', 'Naujan'),
(38, 'Dike', 'Apitong', 'Naujan'),
(39, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(40, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(41, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(47, 'San Isidro', 'Apitong', 'Naujan'),
(48, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(50, 'Cuatres', 'Sta Maria', 'Naujan');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `quantity` int(50) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `status`, `quantity`, `product_id`, `user_id`, `order_id`) VALUES
(155, 'pending', 4, 1, 31, 0),
(156, 'pending', 1, 4, 31, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Beverages'),
(2, 'Biscuits'),
(3, 'Canned Goods'),
(4, 'Noodles '),
(5, 'Coffee');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`delivery_id`, `delivery_date`, `status`, `user_id`, `order_id`) VALUES
(2, '2024-05-12', 'ToReceive', 31, 26);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `content` varchar(225) NOT NULL,
  `date_submitted` date NOT NULL,
  `ratings` varchar(225) NOT NULL,
  `user_id` int(11) NOT NULL,
  `orders_details_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `date_ordered` datetime NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_status` enum('Pending','ToShip','ToReceive','Completed') NOT NULL DEFAULT 'Pending',
  `delivery_option` varchar(10) DEFAULT NULL,
  `date_received` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `date_ordered`, `total_price`, `address_id`, `user_id`, `order_status`, `delivery_option`, `date_received`) VALUES
(22, '2024-04-19 09:47:21', '800.00', 39, 31, 'ToShip', 'pickup', '2024-04-19 15:47:21'),
(25, '2024-04-19 10:07:37', '1050.00', 34, 27, 'Completed', 'pickup', '2024-04-19 16:07:37'),
(26, '2024-04-19 16:01:25', '1011.00', 39, 31, 'Completed', 'delivery', '2024-04-19 22:01:25'),
(29, '2024-05-19 15:28:53', '60.00', 34, 27, 'Pending', NULL, '2024-05-19 21:28:53');

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `orders_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_details`
--

INSERT INTO `orders_details` (`orders_details_id`, `quantity`, `price`, `order_id`, `product_id`) VALUES
(38, 2, 200, 22, 20),
(39, 2, 200, 22, 21),
(44, 5, 210, 25, 20),
(45, 20, 24.5, 26, 1),
(46, 20, 8.75, 26, 5),
(47, 10, 24.5, 26, 6),
(48, 6, 8.5, 26, 9),
(51, 6, 10, 29, 8);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `type_code` bigint(20) DEFAULT NULL,
  `prod_desc` varchar(255) DEFAULT NULL,
  `prod_name` varchar(50) NOT NULL,
  `discounted_price` double(10,2) DEFAULT NULL,
  `retail_price` double(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `type_code`, `prod_desc`, `prod_name`, `discounted_price`, `retail_price`, `stock`, `photo`, `expiration_date`, `category_id`) VALUES
(1, 4800163000048, 'Ligo Sardines in Tomato with chilli 155g ', 'Ligo Red', 24.50, 27.00, 58, 'ligo-red.png', '2024-05-10', 3),
(2, 4809010626332, 'Lemon Square Cheese cake 10x30g', 'Cheese Cake', 75.50, 85.00, 0, 'cheese-cake.png', '2024-05-10', 2),
(3, 5449000256805, 'Coke Mismo', 'Coke Mismo', 200.00, 210.00, 0, 'coke_mismo.png', '2024-05-10', 1),
(4, 4800361339186, 'Nescafe Classic Instant Coffee 23g', 'Nescafe 23g', 20.50, 23.00, 88, 'nescafe_23g.png', '2024-05-10', 5),
(5, 4807770272202, 'Lucky me instant noodles Chicken 55g', 'LM Chicken', 8.75, 11.00, 77, 'LM_chicken.png', '2024-05-10', 4),
(6, 4806504710126, 'Mega Sardines in Tomato Sauce with Chili 155g,', 'Mega Red', 24.50, 27.00, 22, 'mega-red.png', '2024-05-10', 3),
(7, 4800361393645, 'Nescafe Classic Instant Coffee 46g', 'Nescafe 46g', 40.00, 45.00, 6, 'nescafe_46g.png', '2024-05-10', 5),
(8, 4800110026497, 'Homi Instant Mami Noodles Beef Brisket 55g', 'HoMi Beef', 8.50, 10.00, 4, 'Homi_Beef.png', '2024-05-10', 4),
(9, 4800110025995, 'Homi Instant Mami Noodles Chicken & Garlic 55g', 'HoMi Chicken', 8.50, 10.00, 10, 'Homi_Chicken.png', '2024-05-10', 4),
(10, 4807770270017, 'Lucky me instant noodles Beef 55g', 'LM Beef', 8.75, 11.00, 0, 'lucky_me_beef.png', '2024-05-10', 4),
(11, 4800010075526, 'Jack‘N Jill Cream-O Vanilla Cream-Filled Chocolate Sandwich Cookies 33gx10Packs', 'CreamO', 74.10, 80.00, 0, 'Cream-O.png', '2024-05-10', 2),
(12, 14800016057073, 'C2 Solo Green Tea Apple 230mlx24', 'C2 Apple', 310.00, 320.00, 0, 'c2_apple.png', '2024-05-10', 1),
(13, 4806022901884, 'Homi Instant Mami Chili Garlic Beef 55g', 'HoMi Hot Beef', 9.60, 10.00, 40, 'Homi_Hot.png', '2024-05-10', 4),
(14, 4807770272554, 'Lucky Me Pancit Canton Sweet&Spicy', 'Canton Sweet and Spicy', 14.00, 17.00, 5, 'P.C._sweet.png', '2024-05-10', 4),
(15, 4800361393683, 'Nescafe Classic Instant Coffee 92g', 'Nescafe 92g', 78.50, 85.00, 10, 'nescafe_92g.png', '2024-05-10', 5),
(16, 4800092110528, 'Rebisco Hansel Chocolate Sandwich 32gx10s', 'Hansel Choco', 60.00, 65.00, 10, 'hansel-choco.png', '2024-05-10', 2),
(17, 72810293583, 'Ligo Sardines in Tomato Sauce', 'Ligo Green', 24.50, 27.00, 1, 'ligo-green.png', '2024-05-10', 3),
(18, 748485801728, 'Lucky 7 Carne Norte 150g', 'Lucky7 150g', 21.95, 24.00, 15, 'lucky7-150g.png', '2024-05-10', 3),
(19, 857451000307, 'Mega Sardines in Tomato Sauce', 'Mega Green', 24.50, 27.00, 12, 'mega-green.png', '2024-05-10', 3),
(20, 4801981118519, 'Royal Mismo', 'Royal Mismo', 200.00, 210.00, 7, 'royal_mismo.png', '2024-05-10', 1),
(21, 4801981118588, 'Sprite Mismo', 'Sprite Mismo', 200.00, 210.00, 5, 'sprite_mismo.png', '2024-05-10', 1),
(22, 4807770271229, 'Lucky Me Pancit Cantoon Extra Hot', 'Cantoon Extra Hot', 14.00, 17.00, 20, 'P.C._extra_hot.png', '2024-05-10', 4),
(23, 4807770270291, 'Lucky Me Pancit Canton Chili Mansi', 'Canton Chili Mansi', 14.00, 17.00, 20, 'P.C._chilimansi.png', '2024-05-10', 4),
(24, 4807770270123, 'Lucky Me Pancit Canton Kalamansi', 'Canton Kalamansi', 14.00, 17.00, 20, 'P.C._kalamansi.png', '2024-05-10', 4),
(25, 4807770270055, 'Lucky Me Pancit Canton Original', 'Canton Original', 14.00, 17.00, 20, 'P.C._original.png', '2024-05-10', 4),
(26, 748485801469, 'Lucky7 Carne Norte 100g', 'Lucky7 100g', 16.50, 20.00, 15, 'Lucky7_small.png', '2024-05-10', 3),
(27, 748485803951, 'Lucky7 Carne Norte 210g', 'Lucky7 210g', 29.50, 35.00, 20, 'Lucky7_210g.png', '2024-05-10', 3),
(28, 4800092110528, 'Rebisco Hansel Creackers ', 'Hansel Cracker', 60.00, 65.00, 10, 'Hansel_cracker.png', '2024-05-10', 2),
(29, 4800092110511, 'Hansel Milk Sandwich 32gx10s', 'Hansel Milk', 60.00, 65.00, 10, 'Hansel_milk.png', '2024-05-10', 2),
(30, 4800092118777, 'Hansel Milky Strawberry Sandwich 32gx10s', 'Hansel Strawberry ', 60.00, 65.00, 10, 'Hansel_Pink.png', '2024-05-10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating_value` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `order_id`, `user_id`, `rating_value`, `feedback`, `created_at`) VALUES
(1, 25, 27, 3, 'nice and complete item\r\n', '2024-05-19 14:04:34'),
(2, 26, 31, 5, 'hdhaskhda', '2024-05-20 03:15:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_password` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL,
  `address_id` int(11) NOT NULL,
  `verification_code` varchar(20) DEFAULT NULL,
  `status` enum('not_verified','verified') NOT NULL DEFAULT 'not_verified',
  `reset_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `phone_number`, `username`, `email`, `password`, `confirm_password`, `role`, `address_id`, `verification_code`, `status`, `reset_code`) VALUES
(1, 'Marivic', 'Alulod', '9656518833', 'Mavic', 'admin@gmail.com', '$2y$10$H7PR9QOd8kRe7YdDG46w6.cxB8v5dKl205gvNMkD1Gi/oSmjgUhF.', '', 'Admin', 1, NULL, '', 0),
(27, 'Mara', 'Villanueva ', '9071152620', 'MARA', 'villanuevamara23@gmail.com', '$2y$10$VHECNpCi6sWDf/KT8L//7e2kDh0dS1...XgbgvxgRvy.PfN2QxDt2', '$2y$10$VHECNpCi6sWDf/KT8L//7e2kDh0dS1...XgbgvxgRvy.PfN2QxDt2', 'Retail_Customer', 34, '564841', 'verified', 0),
(31, 'Karla ', 'Villanueva ', '9071152620', 'KARLA', 'alulodkarlamae@gmail.com', '$2y$10$wH7wr2jeS5pZPnnrM8OkJei8nsvU/ukTvdkCcrH1tHNlKEc8oet0q', '$2y$10$wH7wr2jeS5pZPnnrM8OkJei8nsvU/ukTvdkCcrH1tHNlKEc8oet0q', 'Wholesale_Customer', 39, '124659', 'verified', 0),
(33, 'Mary Grace', 'Laygo', '9071152620', 'Grace', 'marygracesalor23@gmail.com', '$2y$10$SkkXx/IYO5wBtEf7pD6Qhek0EfPtPco1Xq3rYOEub1Oit9PU8Eawu', 'Grace#30', 'Staff', 41, '436539', 'verified', 0),
(39, 'Jerwin', 'Premacio', '9659669917', 'Wen', 'premaciojerwin@gmail.com', '$2y$10$3/NrCtVlWj74QJsjjomQ4O7oEwtsb3J4zEojAyZj3ZwAU8pcUP7By', 'Wen*0927', 'Delivery_personnel', 47, '204630', 'verified', 0),
(40, 'Admin', 'Admin', '9656518833', 'Admin', 'villanuevamara23+admin@gmail.com', '$2y$10$fCFlfBeYv295yhaju9oIxOwvDsvtRs7c58yTSByGhKg8qro0KOYFC', 'Admin*123', 'Admin', 48, '986795', 'verified', 0),
(42, 'Angelica', 'Alulod', '9656518833', 'Lyka', 'villanuevamara23+lyka@gmail.com', '$2y$10$OtVRVbV9vaVPbLmY.u3CXun4/W9/OgURypQ.c5gnO2Nl7USG1W2Ei', 'Lyka!123', 'Wholesale_Customer', 50, '966131', 'verified', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `delivery_ibfk_2` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `orders_details_id` (`orders_details_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`orders_details_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `ratings_ibfk_1` (`order_id`),
  ADD KEY `ratings_ibfk_2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_ibfk_1` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `orders_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`orders_details_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD CONSTRAINT `orders_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
