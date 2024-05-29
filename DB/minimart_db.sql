-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 06:35 AM
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
(50, 'Cuatres', 'Sta Maria', 'Naujan'),
(52, '', '', ''),
(53, 'Munting Paraiso', 'Sta Maria', 'Naujan'),
(54, 'Simbad', 'Sta Maria', 'Naujan');

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
(187, 'pending', 2, 15, 47, 0),
(188, 'pending', 5, 9, 47, 0),
(189, 'pending', 5, 8, 47, 0),
(190, 'pending', 3, 19, 47, 0),
(191, 'pending', 3, 6, 47, 0),
(192, 'pending', 3, 12, 31, 0),
(193, 'pending', 2, 3, 31, 0),
(194, 'pending', 3, 20, 31, 0),
(195, 'pending', 2, 36, 31, 0),
(196, 'pending', 1, 2, 31, 0),
(197, 'pending', 1, 8, 31, 0);

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
(5, 'Coffee'),
(6, 'Cigarettes'),
(7, 'Shampoo'),
(8, 'Conditioner'),
(9, 'Detergent'),
(10, 'Candies');

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
(3, '2024-05-22', 'ToReceive', 31, 22),
(4, '2024-05-27', '<?php\nrequire \'../DB/db_con.php\'; \n\ntry {\n    $sql', 46, 64);

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
(22, '2024-04-19 09:47:21', '800.00', 39, 31, 'ToReceive', 'pickup', '2024-04-19 15:47:21'),
(25, '2024-04-19 10:07:37', '1050.00', 34, 27, 'Completed', 'pickup', '2024-04-19 16:07:37'),
(26, '2024-04-19 16:01:25', '1011.00', 39, 31, 'Completed', 'delivery', '2024-04-19 22:01:25'),
(54, '2024-05-26 09:34:09', '1820.00', 52, 33, 'Completed', 'InStore', '2024-05-26 15:34:09'),
(55, '2024-05-26 09:58:20', '539.00', 52, 33, 'Completed', 'InStore', '2024-05-26 15:58:20'),
(56, '2024-05-26 10:28:33', '1212.00', 52, 33, 'Completed', 'InStore', '2024-05-26 16:28:33'),
(62, '2024-05-26 16:38:41', '960.00', 52, 33, 'Completed', 'InStore', '2024-05-26 22:38:41'),
(63, '2024-05-26 17:54:10', '3246.00', 50, 42, 'ToShip', 'delivery', '2024-05-26 23:54:10'),
(64, '2024-05-26 18:01:20', '1621.50', 53, 46, 'ToReceive', 'pickup', '2024-05-27 00:01:20'),
(65, '2024-05-27 04:14:59', '320.00', 52, 33, 'Completed', 'InStore', '2024-05-27 10:14:59'),
(66, '2024-05-27 05:44:16', '1560.00', 52, 33, 'Completed', 'InStore', '2024-05-27 11:44:16'),
(69, '2024-05-27 17:00:52', '1708.00', 39, 31, 'Pending', 'pickup', '2024-05-27 23:00:52'),
(70, '2024-05-27 17:08:15', '1081.00', 34, 27, 'Pending', 'delivery', '2024-05-27 23:08:15'),
(105, '2024-05-28 06:31:37', '1560.00', 52, 33, 'Completed', 'InStore', '2024-05-28 12:31:37');

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
(56, 2, 200, 54, 3),
(57, 2, 310, 54, 12),
(58, 2, 200, 54, 20),
(59, 2, 200, 54, 21),
(60, 2, 65, 55, 16),
(61, 3, 24, 55, 18),
(62, 3, 27, 55, 6),
(63, 3, 27, 55, 19),
(64, 1, 85, 55, 15),
(65, 2, 45, 55, 7),
(66, 10, 8.75, 56, 5),
(67, 10, 8.75, 56, 10),
(68, 10, 8.5, 56, 8),
(69, 10, 21.95, 56, 18),
(70, 12, 16.5, 56, 26),
(71, 3, 29.5, 56, 27),
(72, 12, 20.5, 56, 4),
(73, 5, 40, 56, 7),
(83, 3, 320, 62, 12),
(84, 3, 42, 63, 35),
(85, 3, 42, 63, 32),
(86, 2, 75.5, 63, 2),
(87, 10, 8.5, 63, 9),
(88, 10, 8.75, 63, 10),
(89, 10, 8.5, 63, 8),
(90, 10, 8.75, 63, 5),
(91, 4, 200, 63, 3),
(92, 2, 200, 63, 20),
(93, 1, 310, 63, 12),
(94, 1, 60, 63, 30),
(95, 16, 20.5, 63, 4),
(96, 3, 200, 63, 21),
(97, 6, 14, 64, 25),
(98, 5, 42, 64, 33),
(99, 10, 14, 64, 22),
(100, 10, 14, 64, 14),
(101, 10, 14, 64, 23),
(102, 6, 14, 64, 24),
(103, 3, 42, 64, 34),
(104, 5, 29.5, 64, 27),
(105, 6, 40, 64, 7),
(106, 1, 310, 64, 12),
(107, 2, 60, 65, 16),
(108, 1, 200, 65, 3),
(109, 2, 60, 66, 16),
(110, 4, 310, 66, 12),
(111, 1, 200, 66, 3),
(112, 6, 24.5, 69, 1),
(113, 10, 20.5, 69, 4),
(114, 1, 1356, 69, 36),
(115, 5, 47, 70, 32),
(116, 5, 47, 70, 35),
(117, 3, 85, 70, 2),
(118, 6, 17, 70, 23),
(119, 6, 17, 70, 24),
(120, 6, 17, 70, 22),
(121, 1, 1560, 105, 36);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `type_code` bigint(20) DEFAULT NULL,
  `prod_desc` varchar(255) DEFAULT NULL,
  `prod_name` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `type_code`, `prod_desc`, `prod_name`, `stock`, `photo`, `expiration_date`, `category_id`) VALUES
(1, 4800163000048, 'Ligo Sardines in Tomato with chilli 155g ', 'Ligo Red', 52, 'ligo-red.png', '2024-05-10', 3),
(2, 4809010626332, 'Lemon Square Cheese cake 10x30g', 'Cheese Cake', 20, 'cheese-cake.png', '2024-05-10', 2),
(3, 5449000256805, 'Coke Mismo', 'Coke Mismo', 42, 'coke_mismo.png', '2024-05-10', 1),
(4, 4800361339186, 'Nescafe Classic Instant Coffee 23g', 'Nescafe 23g', 50, 'nescafe_23g.png', '2024-05-10', 5),
(5, 4807770272202, 'Lucky me instant noodles Chicken 55g', 'LM Chicken', 57, 'LM_chicken.png', '2024-05-10', 4),
(6, 4806504710126, 'Mega Sardines in Tomato Sauce with Chili 155g,', 'Mega Red', 19, 'mega-red.png', '2024-05-10', 3),
(7, 4800361393645, 'Nescafe Classic Instant Coffee 46g', 'Nescafe 46g', 33, 'nescafe_46g.png', '2024-05-10', 5),
(8, 4800110026497, 'Homi Instant Mami Noodles Beef Brisket 55g', 'HoMi Beef', 24, 'Homi_Beef.png', '2024-05-10', 4),
(9, 4800110025995, 'Homi Instant Mami Noodles Chicken & Garlic 55g', 'HoMi Chicken', 40, 'Homi_Chicken.png', '2024-05-10', 4),
(10, 4807770270017, 'Lucky me instant noodles Beef 55g', 'LM Beef', 40, 'lucky_me_beef.png', '2024-05-10', 4),
(11, 4800010075526, 'Jack‘N Jill Cream-O Vanilla Cream-Filled Chocolate Sandwich Cookies 33gx10Packs', 'CreamO', 0, 'Cream-O.png', '2024-05-10', 2),
(12, 14800016057073, 'C2 Solo Green Tea Apple 230mlx24', 'C2 Apple', 8, 'c2_apple.png', '2024-05-10', 1),
(13, 4806022901884, 'Homi Instant Mami Chili Garlic Beef 55g', 'HoMi Hot Beef', 40, 'Homi_Hot.png', '2024-05-10', 4),
(14, 4807770272554, 'Lucky Me Pancit Canton Sweet&Spicy', 'Canton Sweet and Spicy', 25, 'P.C._sweet.png', '2024-05-10', 4),
(15, 4800361393683, 'Nescafe Classic Instant Coffee 92g', 'Nescafe 92g', 9, 'nescafe_92g.png', '2024-05-10', 5),
(16, 4800092110528, 'Rebisco Hansel Chocolate Sandwich 32gx10s', 'Hansel Choco', 4, 'hansel-choco.png', '2024-05-10', 2),
(17, 72810293583, 'Ligo Sardines in Tomato Sauce', 'Ligo Green', 30, 'ligo-green.png', '2024-05-10', 3),
(18, 748485801728, 'Lucky 7 Carne Norte 150g', 'Lucky7 150g', 2, 'lucky7-150g.png', '2024-05-10', 3),
(19, 857451000307, 'Mega Sardines in Tomato Sauce', 'Mega Green', 27, 'mega-green.png', '2024-05-10', 3),
(20, 4801981118519, 'Royal Mismo', 'Royal Mismo', 23, 'royal_mismo.png', '2024-05-10', 1),
(21, 4801981118588, 'Sprite Mismo', 'Sprite Mismo', 20, 'sprite_mismo.png', '2024-05-10', 1),
(22, 4807770271229, 'Lucky Me Pancit Cantoon Extra Hot', 'Cantoon Extra Hot', 44, 'P.C._extra_hot.png', '2024-05-10', 4),
(23, 4807770270291, 'Lucky Me Pancit Canton Chili Mansi', 'Canton Chili Mansi', 44, 'P.C._chilimansi.png', '2024-05-10', 4),
(24, 4807770270123, 'Lucky Me Pancit Canton Kalamansi', 'Canton Kalamansi', 48, 'P.C._kalamansi.png', '2024-05-10', 4),
(25, 4807770270055, 'Lucky Me Pancit Canton Original', 'Canton Original', 54, 'P.C._original.png', '2024-05-10', 4),
(26, 748485801469, 'Lucky7 Carne Norte 100g', 'Lucky7 100g', 3, 'Lucky7_small.png', '2024-05-10', 3),
(27, 748485803951, 'Lucky7 Carne Norte 210g', 'Lucky7 210g', 12, 'Lucky7_210g.png', '2024-05-10', 3),
(28, 4800092110528, 'Rebisco Hansel Creackers ', 'Hansel Cracker', 8, 'Hansel_cracker.png', '2024-05-10', 2),
(29, 4800092110511, 'Hansel Milk Sandwich 32gx10s', 'Hansel Milk', 8, 'Hansel_milk.png', '2024-05-10', 2),
(30, 4800092118777, 'Hansel Milky Strawberry Sandwich 32gx10s', 'Hansel Strawberry ', 8, 'Hansel_Pink.png', '2024-05-10', 2),
(31, 4800016304019, 'Maxx Cherry Menthol Candy 50\'s', 'Maxx Red', 28, 'Maxx_Red.png', '2025-05-12', 10),
(32, 4800016306013, 'Maxx Candy Honey Lemon 50\'s', 'Maxx Yellow', 20, 'maxx yellow.png', '2025-05-12', 10),
(33, 4800016306016, 'Axx Candy Honeymansi 50\'s ', 'Maxx Green', 25, 'maxx green.png', '2025-05-12', 10),
(34, 4800016303159, 'Maxx Extra Strength Menthol Candy 50\'s', 'Maxx Blue', 27, 'Maxx_Blue.png', '2025-05-12', 10),
(35, 4800016303081, 'Maxx Candy Dalandan Orange 50\'s', 'Maxx Orange', 20, 'maxx orange.png', '2025-05-12', 10),
(36, 4800130100016, 'Gsm Frasquito 350ml', 'Frasquito ', 48, 'Frasquito.png', '2026-08-20', 1),
(37, 4800130100016, 'Gsm Frasquito 350ml', 'Frasquito ', 50, 'Frasquito.png', '2026-08-20', 1),
(38, 4800130100016, 'Gsm Frasquito 350ml', 'Frasquito ', 300, 'Frasquito.png', '2026-08-20', 1),
(39, 4800130100016, 'Gsm Frasco 700ml ', 'Frasco', 50, 'Frasco.png', '2026-06-10', 1),
(40, 4800130100016, 'Gsm Frasco 700ml', 'Frasco', 30, 'Frasco.png', '2026-06-10', 1),
(41, 4800130100016, 'Gsm Frasco 700ml', 'Frasco', 100, 'Frasco.png', '2016-06-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

CREATE TABLE `product_variations` (
  `variation_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `variation_type` varchar(50) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`variation_id`, `product_id`, `variation_type`, `discounted_price`, `retail_price`) VALUES
(1, 1, 'per pcs', '24.50', '27.00'),
(2, 2, 'per pack', '75.00', '85.00'),
(3, 3, 'per case', '200.00', '210.00'),
(4, 4, 'per pcs', '20.50', '23.00'),
(5, 5, 'per pcs', '8.75', '11.00'),
(6, 6, 'per pcs', '24.50', '27.00'),
(7, 7, 'per pcs', '40.00', '45.00'),
(8, 8, 'per pcs', '8.50', '10.00'),
(9, 9, 'per pcs', '8.50', '10.00'),
(10, 10, 'per pcs', '8.75', '11.00'),
(11, 11, 'per pack', '74.00', '80.00'),
(12, 12, 'per case', '310.00', '320.00'),
(13, 13, 'per pcs', '9.60', '10.00'),
(14, 14, 'per pcs', '14.00', '17.00'),
(15, 15, 'per pcs', '78.50', '85.00'),
(16, 16, 'per pack', '60.00', '65.00'),
(17, 17, 'per pcs', '24.50', '27.00'),
(18, 18, 'per pcs', '21.95', '24.00'),
(19, 19, 'per pcs', '24.50', '27.00'),
(20, 20, 'per case', '200.00', '210.00'),
(21, 21, 'per case', '200.00', '210.00'),
(22, 22, 'per pcs', '14.00', '17.00'),
(23, 23, 'per pcs', '14.00', '17.00'),
(24, 24, 'per pcs', '14.00', '17.00'),
(25, 25, 'per pcs', '14.00', '17.00'),
(26, 26, 'per pcs', '16.50', '21.00'),
(27, 27, 'per pcs', '29.50', '35.00'),
(28, 28, 'per pack', '60.00', '65.00'),
(29, 29, 'per pack', '60.00', '65.00'),
(30, 30, 'per pack', '60.00', '65.00'),
(31, 31, 'per pack', '42.00', '47.00'),
(32, 32, 'per pack', '42.00', '47.00'),
(33, 33, 'per pack', '42.00', '47.00'),
(34, 34, 'per pack', '42.00', '47.00'),
(35, 35, 'per pack', '42.00', '47.00'),
(36, 36, 'per case', '1356.00', '1560.00'),
(37, 37, 'half case', '770.00', '816.00'),
(48, 38, 'per pcs', '65.00', '70.00'),
(49, 39, 'per case', '1467.00', '1560.00'),
(50, 40, 'half case', '732.00', '792.00'),
(51, 41, 'per pcs', '123.00', '135.00');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `promo_id` int(11) NOT NULL,
  `minimum_spend` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`promo_id`, `minimum_spend`, `discount_percentage`, `start_date`, `end_date`) VALUES
(1, '3000.00', '3.00', '2024-05-27', '2024-05-31'),
(2, '2000.00', '1.00', '2024-05-25', '2024-05-31');

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
(1, 25, 27, 3, 'nice and complete item, good din ang condition ng mga item\n', '2024-05-19 14:04:34'),
(2, 26, 31, 5, 'Nice ayos naman ang item pag dating saka yung pag kaka-pack ng item and upon checking complete naman lahat ng items ', '2024-05-20 03:15:19');

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
(42, 'Angelica', 'Alulod', '9656518833', 'Lyka', 'villanuevamara23+lyka@gmail.com', '$2y$10$OtVRVbV9vaVPbLmY.u3CXun4/W9/OgURypQ.c5gnO2Nl7USG1W2Ei', 'Lyka!123', 'Wholesale_Customer', 50, '966131', 'verified', 0),
(46, 'Marina', 'Andal', '9656518833', 'Marina', 'villanuevamara23+marina@gmail.com', '$2y$10$/7qwCILsq37tfOQlIVTFaO2ElxOIxzayqJ20nTRba8SLgl2kbbqSq', 'Marina!123', 'Wholesale_Customer', 53, '806005', 'verified', 0),
(47, 'Mely', 'Dalawampu', '9071152620', 'Mely', 'villanuevamara23+mely@gmail.com', '$2y$10$406x9SiRk3DBAr7Xa2uSC.CeZr.b4H1MZcrkaLwB0GJB1Dq6YI.jK', 'Mely@123', 'Retail_Customer', 54, '792728', 'verified', 0);

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
-- Indexes for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`promo_id`);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `orders_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `variation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

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
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

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
