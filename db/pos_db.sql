-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 10:35 PM
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
-- Database: `pos_demo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_tbl`
--

CREATE TABLE IF NOT EXISTS `access_tbl` (
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `auth_key` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_tbl`
--

INSERT INTO `access_tbl` (`firstname`, `middlename`, `lastname`, `auth_key`) VALUES
('edoK', 'edaM', 'yzaE', '3Tf81kBk4Exy5NsL5MGxChhEWuDaqhQWvoDJRXGxTF34DyPMzy');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `status`, `created_at`) VALUES
(1, 'Drinks', 'active', '2023-12-07'),
(2, 'Noodles', 'active', '2023-12-07'),
(3, 'Wears', 'active', '2023-12-15'),
(4, 'Electronics', 'active', '2023-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
  `id` int(1) NOT NULL,
  `cms_code` varchar(255) NOT NULL,
  `cms_name` varchar(255) NOT NULL,
  `act_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `exp_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `cms_code`, `cms_name`, `act_date`, `exp_date`) VALUES
(1, 'WFZlNUwyODFodWsxaUZ2NDQ0Y2pUM2c3azdDa0hLM3NEU2dEUXM0ZjhpMD0=', 'Mko2c0ExOXArUlZ1S3c2a2xyWENIejhVUUxEM09hUHJxb1BESzV1Ty9Xbz0=', '2023-07-16 17:12:43', '2024-07-16 18:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_reports`
--

CREATE TABLE IF NOT EXISTS `delivery_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `shipped_from` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `signed_by` varchar(255) DEFAULT NULL,
  `note_number` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `invoice_no` (`invoice_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_loggers_tbl`
--

CREATE TABLE IF NOT EXISTS `demo_loggers_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `ip_address` (`ip_address`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) DEFAULT NULL,
  `item` varchar(255) DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `purchase_by` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `orderFrom` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `date` (`date`),
  KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `warehouse_id`, `item`, `amount`, `purchase_by`, `date`, `orderFrom`, `status`, `created_at`) VALUES
(1, 1, 'Printing Paper', 250000, 'samson Jerry', '2023-12-15', 'Seller B', 'Approved', '2023-12-15 22:19:18'),
(2, 1, 'Printer Ink', 2500, 'samson Jerry', '2023-12-13', 'Printer Ink Seller', 'Approved', '2023-12-16 07:32:48'),
(3, 1, 'Ink', 2000, 'samson Jerry', '2023-12-13', 'Seller', 'Approved', '2023-12-19 13:57:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoiceNo` varchar(100) NOT NULL,
  `total` double(10,2) NOT NULL,
  `paid` double(10,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Paid',
  `customer` varchar(225) DEFAULT NULL,
  `trans_date` datetime NOT NULL DEFAULT current_timestamp(),
  `paymentType` varchar(50) DEFAULT NULL,
  `due` double NOT NULL,
  `cashier_name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `discount_price` float NOT NULL DEFAULT 0,
  `discount_percent` float NOT NULL DEFAULT 0,
  `store_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `invoiceNo`, `total`, `paid`, `notes`, `status`, `customer`, `trans_date`, `paymentType`, `due`, `cashier_name`, `phone`, `email`, `discount_price`, `discount_percent`, `store_id`) VALUES
(1, 'INV-0000001', 295300.00, 285000.00, NULL, 'Paid', 'Sam Jec', '2023-12-15 23:17:03', 'Cash', 5000, 'salesperson1', '0030303', 'jec@mail.com', 290000, 5300, 1),
(2, 'INV-0000002', 4500.00, 4050.00, NULL, 'Paid', 'Mr John Doe', '2023-12-16 08:30:54', 'Cash', 0, 'salesperson1', '', '', 4050, 450, 1),
(3, 'INV-0000003', 299300.00, 280000.00, NULL, 'Paid', 'Guest John', '2023-12-16 11:47:08', 'Cash', 19000, 'salesperson1', '04040404', 'john@mail.com', 299000, 300, 1),
(4, 'INV-0000004', 120300.00, 120300.00, NULL, 'Paid', 'Mr Godwin', '2023-12-17 20:20:51', 'Cash', 0, 'salesperson1', '', '', 120300, 5000, 1),
(5, 'INV-0000005', 299900.00, 290000.00, NULL, 'Paid', 'Buyer', '2023-12-19 14:56:28', 'Cash', 0, 'salesperson1', '', '', 290000, 9900, 1),
(6, 'INV-0000006', 8400.00, 8400.00, NULL, 'Paid', 'guest', '2023-12-29 17:25:30', 'Cash', 0, 'salesperson1', '0909876543', '', 8400, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `itemId` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `product` varchar(225) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `subtotal` double NOT NULL,
  `trans_date` date NOT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`itemId`, `invoice_id`, `product_id`, `product`, `qty`, `price`, `subtotal`, `trans_date`) VALUES
(1, 1, 1, 'Cocal-Cola Coke 75CL', 1, 300, 300, '2023-12-15'),
(2, 1, 6, 'Dell Latitude 110', 1, 120000, 120000, '2023-12-15'),
(3, 1, 5, 'HP 250', 1, 175000, 175000, '2023-12-15'),
(4, 2, 2, 'Golden Penny', 1, 4000, 4000, '2023-12-16'),
(5, 2, 4, 'Cocal-Cola Coke 50CL', 2, 250, 500, '2023-12-16'),
(6, 3, 6, 'Dell Latitude 110', 1, 120000, 120000, '2023-12-16'),
(7, 3, 1, 'Cocal-Cola Coke 75CL', 1, 300, 300, '2023-12-16'),
(8, 3, 2, 'Golden Penny', 1, 4000, 4000, '2023-12-16'),
(9, 3, 5, 'HP 250', 1, 175000, 175000, '2023-12-16'),
(10, 4, 6, 'Dell Latitude 110', 1, 120000, 120000, '2023-12-17'),
(11, 4, 1, 'Cocal-Cola Coke 75CL', 1, 300, 300, '2023-12-17'),
(12, 5, 1, 'Cocal-Cola Coke 75CL', 3, 300, 900, '2023-12-19'),
(13, 5, 6, 'Dell Latitude 110', 1, 120000, 120000, '2023-12-19'),
(14, 5, 2, 'Golden Penny', 1, 4000, 4000, '2023-12-19'),
(15, 5, 5, 'HP 250', 1, 175000, 175000, '2023-12-19'),
(16, 6, 1, 'Cocal-Cola Coke 75CL', 28, 300, 8400, '2023-12-29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `proId` bigint(11) NOT NULL AUTO_INCREMENT,
  `batch` varchar(50) DEFAULT NULL,
  `name` varchar(225) NOT NULL,
  `prod_desc` text NOT NULL,
  `cost_price` double(10,2) NOT NULL DEFAULT 0.00,
  `profit` double(10,2) NOT NULL DEFAULT 0.00,
  `selling_price` double(10,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 0,
  `barcode` varchar(100) NOT NULL,
  `supId` int(11) DEFAULT NULL,
  `image` varchar(225) DEFAULT NULL,
  `wareId` int(11) DEFAULT NULL,
  `mft_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `costTotal` float DEFAULT NULL,
  `salesTotal` float DEFAULT NULL,
  PRIMARY KEY (`proId`),
  UNIQUE KEY `barcode` (`barcode`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`proId`, `batch`, `name`, `prod_desc`, `cost_price`, `profit`, `selling_price`, `qty`, `barcode`, `supId`, `image`, `wareId`, `mft_date`, `expiry_date`, `category`, `created_at`, `costTotal`, `salesTotal`) VALUES
(1, 'DECEMBER', 'Cocal-Cola Coke 75CL', 'Cocal-Cola Coke 75CL', 250.00, 50.00, 300.00, 25, 'COK92446', 1, 'prod_1703911063.jpg', 1, '2023-07-06', '2024-09-14', 'Drinks', '2023-12-07', 6250, 7500),
(2, 'DECEMBER', 'Golden Penny', 'Golden Penny', 3500.00, 500.00, 4000.00, 6, 'GOL32602', 1, 'prod_1703964465.jpg', 1, '2023-07-06', '2025-06-20', 'Noodles', '2023-12-08', 21000, 24000),
(3, 'December Batch', 'Golden Penny', 'Golden Penny', 3500.00, 500.00, 4000.00, 20, '474326511', 1, 'prod_1703964380.jpg', 2, '2023-12-08', '2027-12-08', 'Noodles', '2023-12-08', 70000, 80000),
(4, 'December1 Batch', 'Cocal-Cola Coke 50CL', 'Cocal-Cola Coke 50CL', 200.00, 50.00, 250.00, 50, '1595597009', 1, 'prod_1703964436.jpg', 2, '2023-12-08', '2027-12-08', 'Drinks', '2023-12-08', 10000, 12500),
(5, 'DECEMBER 2023', 'HP 250', 'HP Laptop 250', 150000.00, 25000.00, 175000.00, 17, 'HP 16519', 1, 'prod_1703911943.jpeg', 1, '2023-12-07', '2026-07-04', 'Electronics', '2023-12-15', 2550000, 2975000),
(6, 'DECEMBER 2023', 'Dell Latitude 110', 'Dell Latitude 110', 100000.00, 20000.00, 120000.00, 6, 'DEL97636', 1, 'prod_1703964499.jpg', 1, '2023-08-15', '2028-09-15', 'Electronics', '2023-12-15', 600000, 720000);

-- --------------------------------------------------------

--
-- Table structure for table `promo_tbl`
--

CREATE TABLE IF NOT EXISTS `promo_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon` varchar(50) NOT NULL,
  `prodId` bigint(20) DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `promo_type` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 2 COMMENT '1=active,2=inactive,3=future plan',
  `coupon_limit` int(5) NOT NULL,
  `wareId` int(11) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setup_tbl`
--

CREATE TABLE IF NOT EXISTS `setup_tbl` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setup_tbl`
--

INSERT INTO `setup_tbl` (`id`, `company`, `email`, `phone`, `address`, `logo`, `created`) VALUES
(1, 'Oiza Home of Fashion', 'info@pos.com', '01010102', 'Office Address', 'logo_1689527030.png', '2023-07-16 18:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(225) DEFAULT NULL,
  `company` varchar(225) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fullname` (`fullname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `fullname`, `company`, `phone`, `email`, `address`, `status`, `created_at`) VALUES
(1, 'Flat ERP', 'Flat ERP Technologies', '122022111', 'flaterptech@gmail.com', 'Sample address', 1, '2023-12-07');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trNo` varchar(255) NOT NULL,
  `total` float NOT NULL,
  `from_store` int(11) NOT NULL,
  `to_store` int(11) NOT NULL,
  `note` text NOT NULL,
  `received_by` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `to_store` (`to_store`),
  KEY `note` (`note`(768)),
  KEY `received_by` (`received_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_order_items`
--

CREATE TABLE IF NOT EXISTS `transfer_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `subtotal` float NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userType` varchar(100) DEFAULT NULL,
  `full_name` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `username` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `login_datetime` datetime DEFAULT NULL,
  `logout_datetime` datetime DEFAULT NULL,
  `token` text DEFAULT NULL,
  `token_expire` timestamp NULL DEFAULT NULL,
  `avatar` varchar(225) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `store_id` int(11) DEFAULT NULL,
  `account_expire` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userType`, `full_name`, `email`, `username`, `password`, `active`, `status`, `login_datetime`, `logout_datetime`, `token`, `token_expire`, `avatar`, `created_at`, `store_id`, `account_expire`) VALUES
(1, 'Administrator', 'Admin Admin', 'demo@pos.com', 'admin', '$2y$10$gdWt9nc98zZU9UEGoPT98ueYcWjgTwrcJ5um4PELq/Q3MgYtP.v2W', 1, 0, '2023-12-30 22:31:25', '2023-12-30 07:02:13', NULL, NULL, NULL, '2023-07-16 18:04:27', NULL, NULL),
(10, 'Cashier', 'cashier', 'salesperson@pos.com', 'salesperson1', '$2y$10$nCa7jI5knFJGNiA5ZRqUUeNvbIuz1Icjeqi9JQQWRaUM9G7ESA2Li', 1, 0, '2023-12-30 21:57:38', '2023-12-30 06:24:30', NULL, NULL, NULL, '2023-10-13 00:00:00', 1, NULL),
(11, 'Cashier', 'demo cashier', 'cashier@pos.com', 'cashier', '$2y$10$nCa7jI5knFJGNiA5ZRqUUeNvbIuz1Icjeqi9JQQWRaUM9G7ESA2Li', 1, 0, '2023-12-08 05:59:05', '2023-12-08 06:03:14', NULL, NULL, NULL, '2023-12-08 00:00:00', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_token_tbl`
--

CREATE TABLE IF NOT EXISTS `user_token_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(225) NOT NULL,
  `token` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_token_tbl`
--

INSERT INTO `user_token_tbl` (`id`, `email`, `token`) VALUES
(1, 'demo@pos.com', 'IiQmSIgXfWsvqwPszWsSsrUwQg0XSvX2JK9OKCvfAhPrFhG94jmFRAQcBezkctolTlg0UFQriqG0mm6Vcw46y89FWprboRQjOMdNg');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(225) DEFAULT NULL,
  `manager` varchar(225) DEFAULT NULL,
  `store_location` text DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `store_name`, `manager`, `store_location`, `phone`, `status`, `created_at`) VALUES
(1, 'Store A', 'John Doe', 'Sample', '00101010', 'Open', '2023-12-07'),
(2, 'Store B', 'joe', 'somewhere', '90909', 'Open', '2023-12-08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
