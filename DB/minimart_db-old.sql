-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 04:21 PM
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
(13, 'Simbad', 'Sta Maria', 'Naujan');

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
(7, 'pending', 2, 5, 6, 0),
(12, 'pending', 3, 1, 7, 0),
(23, 'pending', 10, 6, 8, 0),
(24, 'pending', 3, 2, 8, 0),
(25, 'pending', 15, 4, 8, 0),
(26, 'pending', 5, 17, 8, 0),
(52, 'pending', 4, 10, 3, 0),
(54, 'pending', 2, 3, 3, 0);

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

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `content` varchar(225) NOT NULL,
  `date_submitted` date NOT NULL,
  `ratings` varchar(225) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `date_ordered` date NOT NULL,
  `total_price` double NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_recieved` date NOT NULL,
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `date_ordered`, `total_price`, `status`, `date_recieved`, `address_id`, `user_id`) VALUES
(17, '2024-02-24', 0, 'Pending', '0000-00-00', 3, 3),
(18, '2024-02-24', 0, 'Pending', '0000-00-00', 3, 3),
(23, '2024-02-24', 0, 'Pending', '0000-00-00', 3, 3),
(28, '2024-02-24', 70.95, 'Pending', '0000-00-00', 3, 3),
(29, '2024-02-24', 943, 'Pending', '0000-00-00', 3, 3),
(30, '2024-02-24', 1000, 'Pending', '0000-00-00', 3, 3),
(31, '2024-02-24', 405, 'Pending', '0000-00-00', 3, 3),
(33, '2024-02-24', 746.35, 'Pending', '0000-00-00', 3, 3),
(34, '2024-02-24', 538, 'Pending', '0000-00-00', 3, 3),
(35, '2024-02-24', 1800, 'Pending', '0000-00-00', 3, 3),
(37, '2024-02-24', 462.9, 'Pending', '0000-00-00', 3, 3),
(38, '2024-02-24', 1800, 'Pending', '0000-00-00', 3, 3),
(39, '2024-02-25', 434, 'Pending', '0000-00-00', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders_details`
--

CREATE TABLE `orders_details` (
  `orders_details_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `type_code` bigint(20) DEFAULT NULL,
  `prod_desc` varchar(255) DEFAULT NULL,
  `prod_name` varchar(50) NOT NULL,
  `prod_price` double(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `type_code`, `prod_desc`, `prod_name`, `prod_price`, `stock`, `photo`, `category_id`) VALUES
(1, 4800163000048, 'Ligo Sardines in Tomato with chilli 155g ', 'Ligo Red', 24.50, 100, 'ligo-red.png', 3),
(2, 4809010626332, 'Lemon Square Cheese cake 10x30g', 'Cheese Cake', 75.50, 20, 'cheese-cake.png', 2),
(3, 5449000256805, 'Coke Mismo', 'Coke Mismo', 200.00, 20, 'coke_mismo.png', 1),
(4, 4800361339186, 'Nescafe Classic Instant Coffee 23g', 'Nescafe', 20.50, 100, 'nescafe_23g.png', 5),
(5, 4807770272202, 'Lucky me instant noodles Chicken 55g', 'LM Chicken', 8.75, 100, 'LM_chicken.png', 4),
(6, 4806504710126, 'Mega Sardines in Tomato Sauce with Chili 155g,', 'Mega Red', 24.50, 34, 'mega-red.png', 3),
(7, 4800361393645, 'Nescafe Classic Instant Coffee 46g', 'Nescafe', 40.00, 10, 'nescafe_46g.png', 5),
(8, 4800110026497, 'Homi Instant Mami Noodles Beef Brisket 55g', 'HoMi Beef', 8.50, 10, 'Homi_Beef.png', 4),
(9, 4800110025995, 'Homi Instant Mami Noodles Chicken & Garlic 55g', 'HoMi Chicken', 8.50, 16, 'Homi_Chicken.png', 4),
(10, 4807770270017, 'Lucky me instant noodles Beef 55g', 'LM Beef', 8.75, 10, 'lucky_me_beef.png', 4),
(11, 4800010075526, 'Jack‘N Jill Cream-O Vanilla Cream-Filled Chocolate Sandwich Cookies 33gx10Packs', 'CreamO', 74.10, 0, 'Cream-O.png', 2),
(12, 14800016057073, 'C2 Solo Green Tea Apple 230mlx24', 'C2 Apple', 310.00, 5, 'c2_apple.png', 1),
(13, 4806022901884, 'Homi Instant Mami Chili Garlic Beef 55g', 'HoMi Hot Beef', 9.60, 40, 'Homi_Hot.png', 4),
(14, 4807770272554, 'Lucky Me Pancit Canton Sweet&Spicy', 'Canton Sweet and Spicy', 14.00, 10, 'P.C._sweet.png', 4),
(15, 4800361393683, 'Nescafe Classic Instant Coffee 92g', 'Nescafe 92g', 78.50, 10, 'nescafe_92g.png', 5),
(16, 4800092110528, 'Rebisco Hansel Chocolate Sandwich 32gx10s', 'Hansel Choco', 60.15, 20, 'hansel-choco.png', 2),
(17, 72810293583, 'Ligo Sardines in Tomato Sauce', 'Ligo Green', 24.50, 2, 'ligo-green.png', 3),
(18, 748485801728, 'Lucky 7 Carne Norte 150g', 'Lucky7 150g', 21.95, 20, 'lucky7-150g.png', 3),
(19, 857451000307, 'Mega Sardines in Tomato Sauce', 'Mega Green', 24.50, 12, 'mega-green.png', 3),
(20, 4801981118519, 'Royal Mismo', 'Royal Mismo', 200.00, 18, 'royal_mismo.png', 1),
(21, 4801981118588, 'Sprite Mismo', 'Sprite Mismo', 200.00, 10, 'sprite_mismo.png', 1);

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
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `phone_number`, `username`, `email`, `password`, `confirm_password`, `role`, `address_id`) VALUES
(1, 'Marivic', 'Alulod', '9656518833', 'Mavic', 'admin@gmail.com', '$2y$10$H7PR9QOd8kRe7YdDG46w6.cxB8v5dKl205gvNMkD1Gi/oSmjgUhF.', '', 'Admin', 1),
(2, 'Grace', 'Laygo', '09072345678', 'Grace', 'Grace@gmail.com', '$2y$10$6k7Mgj./iyTwMI71ss6KdeRa8evJjtAY69nwq02RtLav00YhAbmd2', '', 'Staff', 2),
(3, 'Karla Mae', 'Alulod', '9656518833', 'Karla Mae', 'karlamaealulod@gmail.com', '$2y$10$FqTrlznXH82jJcb8k6521uXLK0hY.kXICjrBk2z/nYOYJl7OyCYYW', '', 'Customer', 3),
(4, 'Linobes', 'Pahibo', '9076596573', 'Lino', 'lino@gmail.com', '$2y$10$a2gug2nm/xZ1fDxhMVo8Du02dRaJuypI7ShwQpbCmcVkoHbd6aHSm', 'Pahibo*1', 'Delivery_personnel', 7),
(6, 'Chyra', 'Ilagan', '9271587419', 'Chy', 'chyrailagan@gmail.com', '$2y$10$fyg5cca6/GfWgPSay61obey0hzELP16vwTDyC7QLYYf82I4mVEzFm', 'chyra#19', 'Customer', 10),
(7, 'May ', 'Vertucio', '9875674632', 'May', 'mayvertucio@gmail.com', '$2y$10$6HSUlKDOTWKebAoVBYPr5uArqTTF/2tWcimH0AvoUDEHIGfTTk6Se', 'mayglene#10', 'Customer', 11),
(8, 'Mark Jhon', 'Cordero', '9105411822', 'Mark', 'markjhon@gmail.com', '$2y$10$ah0fi6I6xBvWFx/vghCmgu2isnhC7CVblJc6d.vsALUAfV5X.U93m', 'Mark#0321', 'Customer', 13);

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
  ADD KEY `delivery_ibfk_1` (`order_id`),
  ADD KEY `delivery_ibfk_2` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `product_id` (`product_id`),
  ADD KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `orders_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `orders_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_details_ibfk_3` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
