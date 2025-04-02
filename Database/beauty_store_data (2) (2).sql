-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 10:30 AM
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
-- Database: `beauty_store_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(12, 'lotions', 'sdxfcghb', '2025-03-20 12:48:00', '2025-03-20 12:48:00'),
(29, 'Lipstick', 'sdfgh', '2025-03-24 07:52:09', '2025-03-24 07:52:09'),
(30, 'asd', 'asdg', '2025-03-24 08:39:22', '2025-03-24 08:39:22'),
(31, 'sdf', 'wdf', '2025-03-24 09:18:16', '2025-03-24 09:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_products`
--

CREATE TABLE `deleted_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `stocks` int(11) NOT NULL DEFAULT 0,
  `status` enum('instock','low-stock') NOT NULL DEFAULT 'instock',
  `image` varchar(255) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `profile_image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `action`, `status`, `contact`, `profile_image_url`) VALUES
(1, 'kak', 'kak@gmail.com', '333', 'Admin', '2025-03-21 02:03:15', '2025-03-21 02:03:15', NULL, 'Active', '903290', NULL),
(2, 'kaka', 'kaka@gmail.com', '12345', 'staff', '2025-03-25 07:45:39', '2025-03-25 07:45:39', NULL, 'active', '2434567', NULL),
(3, 'kaa', 'kaa@gmail.com', '333', 'Admin', '2025-03-25 07:47:02', '2025-03-25 07:47:02', NULL, 'Active', 'N/A', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stocks` int(11) NOT NULL DEFAULT 0,
  `status` enum('instock','low-stock') NOT NULL DEFAULT 'instock',
  `image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `original_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `profit_value` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `created_at`, `updated_at`, `stocks`, `status`, `image`, `start_date`, `expire_date`, `original_price`, `profit_value`) VALUES
(63, 'civina', 'fvdfght', 2.00, 29, '2025-03-24 07:52:43', '2025-03-24 13:25:04', 0, 'low-stock', 'uploads/celeb-or-rich-berry-red-runway-rogue-1_1200x1200.webp', '2025-03-25', '2025-04-05', 0.00, 0.00),
(64, 'nivea', 'adsfgh', 4.00, 12, '2025-03-24 07:56:09', '2025-03-29 04:54:37', 0, 'low-stock', 'uploads/Vaseline-Intensive-Care-Radiant-Non-Greasy-Body-Lotion-Cocoa-10-fl-oz_8fc448dd-1016-4d19-859b-5b78bce98fef.7e5cfbe72427047913a4223726aa6948.webp', '2025-03-28', '2025-03-30', 0.00, 0.00),
(65, 'vaseline', 'wqsadcv', 5.00, 12, '2025-03-24 07:57:24', '2025-03-24 08:49:46', 0, 'low-stock', 'uploads/6764dfde5a3f42f9bba32bfa98fc6196-web_1010x1180_transparent_png.webp', '2025-03-29', '2025-03-31', 0.00, 0.00),
(67, 'DR', 'wqedgbhn', 5.00, 29, '2025-03-24 07:58:32', '2025-03-24 16:17:50', 0, 'low-stock', 'uploads/8906121645514_1_445927e6-7cce-491d-8129-671afc243c08.webp', '2025-03-27', '2025-04-03', 0.00, 0.00),
(69, 'Jaime Sears', 'Animi dolore aut sa', 736.00, 12, '2025-03-27 02:35:18', '2025-03-30 08:23:11', 1, 'low-stock', 'uploads/default-image.jpg', '2012-10-05', '1997-11-30', 0.00, 0.00);

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `update_product_status_before_insert` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    IF NEW.stocks < 5 THEN
        SET NEW.status = 'low-stock';
    ELSE
        SET NEW.status = 'instock';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_product_status_before_update` BEFORE UPDATE ON `products` FOR EACH ROW BEGIN
    IF NEW.stocks < 5 THEN
        SET NEW.status = 'low-stock';
    ELSE
        SET NEW.status = 'instock';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product_expirations`
--

CREATE TABLE `product_expirations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `promotion_name` varchar(255) NOT NULL,
  `promotion_description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT 0.00,
  `promotion_code` varchar(50) DEFAULT NULL,
  `status` enum('active','inactive','completed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `promotion_name`, `promotion_description`, `start_date`, `end_date`, `discount_percentage`, `promotion_code`, `status`, `created_at`, `updated_at`) VALUES
(16, 'news', 'qwert ', '2025-03-22', '2025-03-13', 14.00, '44', 'inactive', '2025-03-16 09:30:11', '2025-03-27 02:35:00'),
(17, 'nnnn', 'nnnnnnnnnnnnnnnnn ', '2025-02-28', '2025-03-07', 24.00, '90', 'active', '2025-03-16 17:40:06', '2025-03-27 02:34:49'),
(19, 'khmer', 'qwerty ', '2025-03-19', '2025-03-26', 12.00, '77', 'active', '2025-03-18 02:36:23', '2025-03-27 02:34:40'),
(24, 'nwe', 'zxcvb ', '2025-03-27', '2025-04-03', 12.00, '85', 'completed', '2025-03-20 11:15:09', '2025-03-27 02:34:33'),
(27, 'kaka', 'asdfgh ', '2025-03-26', '2025-03-31', 12.00, '09', 'active', '2025-03-20 13:11:33', '2025-03-27 02:34:23');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `payment_status` enum('paid','unpaid','pending') DEFAULT 'pending',
  `sale_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `payment_status`, `sale_date`, `total_amount`) VALUES
(1, 'pending', '2025-03-23 23:15:01', 0.00),
(2, 'pending', '2025-03-29 00:00:00', 8.00),
(3, 'pending', '2025-03-29 00:00:00', 8.00),
(4, 'pending', '2025-03-29 00:00:00', 8.00),
(5, 'pending', '2025-03-29 00:00:00', 4.00),
(6, 'pending', '2025-03-29 00:00:00', 8.00),
(7, 'pending', '2025-03-29 00:00:00', 8.00),
(8, 'pending', '2025-03-29 00:00:00', 8.00),
(9, 'pending', '2025-03-29 00:00:00', 8.00),
(10, 'pending', '2025-03-29 00:00:00', 1472.00),
(11, 'pending', '2025-03-29 00:00:00', 1472.00),
(12, 'pending', '2025-03-29 00:00:00', 736.00),
(13, 'pending', '2025-03-29 00:00:00', 736.00),
(14, 'pending', '2025-03-29 00:00:00', 736.00),
(15, 'pending', '2025-03-29 00:00:00', 736.00),
(16, 'pending', '2025-03-29 00:00:00', 736.00),
(17, 'pending', '2025-03-29 00:00:00', 736.00),
(18, 'pending', '2025-03-29 00:00:00', 736.00),
(19, 'pending', '2025-03-29 00:00:00', 736.00),
(20, 'pending', '2025-03-29 00:00:00', 1472.00),
(21, 'pending', '2025-03-29 00:00:00', 1472.00),
(22, 'pending', '2025-03-29 00:00:00', 736.00),
(23, 'pending', '2025-03-29 00:00:00', 736.00),
(24, 'pending', '2025-03-29 00:00:00', 736.00),
(25, 'pending', '2025-03-29 00:00:00', 736.00),
(26, 'pending', '2025-03-29 00:00:00', 736.00),
(27, 'pending', '2025-03-30 00:00:00', 736.00),
(28, 'pending', '2025-03-30 00:00:00', 736.00),
(29, 'pending', '2025-03-30 00:00:00', 736.00),
(30, 'pending', '2025-03-30 00:00:00', 736.00),
(31, 'pending', '2025-03-30 00:00:00', 736.00),
(32, 'pending', '2025-03-30 00:00:00', 736.00),
(33, 'pending', '2025-03-30 00:00:00', 736.00),
(34, 'pending', '2025-03-30 00:00:00', 736.00),
(35, 'pending', '2025-03-30 00:00:00', 736.00),
(36, 'pending', '2025-03-30 00:00:00', 736.00),
(37, 'pending', '2025-03-30 00:00:00', 736.00),
(38, 'pending', '2025-03-30 00:00:00', 736.00),
(39, 'pending', '2025-03-30 00:00:00', 736.00),
(40, 'pending', '2025-03-30 00:00:00', 736.00),
(41, 'pending', '2025-03-30 00:00:00', 736.00),
(42, 'pending', '2025-03-30 00:00:00', 736.00),
(43, 'pending', '2025-03-30 00:00:00', 736.00),
(44, 'pending', '2025-03-30 00:00:00', 736.00),
(45, 'pending', '2025-03-30 00:00:00', 736.00),
(46, 'pending', '2025-03-30 00:00:00', 736.00),
(47, 'pending', '2025-03-30 00:00:00', 736.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`) VALUES
(39, 1, 64, 70, 280.00),
(40, 1, 64, 10, 40.00),
(41, 1, 67, 20, 100.00),
(42, 1, 63, 5, 10.00),
(43, 1, 63, 2, 4.00),
(44, 1, 65, 2, 10.00),
(45, 1, 65, 3, 15.00),
(46, 1, 63, 2, 4.00),
(47, 1, 63, 1, 2.00),
(48, 1, 63, 2, 4.00),
(49, 1, 63, 1, 2.00),
(50, 1, 63, 2, 4.00),
(51, 1, 64, 5, 20.00),
(52, 1, 64, 1, 4.00),
(53, 1, 64, 1, 4.00),
(54, 1, 67, 5, 25.00),
(55, 1, 64, 2, 8.00),
(56, 1, 67, 5, 25.00),
(57, 1, 64, 1, 4.00),
(58, 1, 64, 1, 4.00),
(59, 1, 64, 1, 4.00),
(60, 1, 64, 1, 4.00),
(61, 1, 64, 2, 8.00),
(62, 1, 64, 2, 8.00),
(63, 1, 64, 3, 12.00),
(64, 1, 64, 4, 16.00),
(65, 1, 64, 6, 24.00),
(66, 1, 64, 2, 8.00),
(67, 1, 64, 2, 8.00),
(68, 1, 64, 20, 80.00),
(69, 2, 64, 2, 8.00),
(70, 3, 64, 2, 8.00),
(71, 4, 64, 2, 8.00),
(72, 1, 64, 2, 8.00),
(73, 5, 64, 1, 4.00),
(74, 6, 64, 2, 8.00),
(75, 7, 64, 2, 8.00),
(76, 8, 64, 2, 8.00),
(77, 9, 64, 2, 8.00),
(78, 10, 69, 2, 1472.00),
(79, 11, 69, 2, 1472.00),
(80, 12, 69, 1, 736.00),
(81, 13, 69, 1, 736.00),
(82, 14, 69, 1, 736.00),
(83, 15, 69, 1, 736.00),
(84, 16, 69, 1, 736.00),
(85, 17, 69, 1, 736.00),
(86, 18, 69, 1, 736.00),
(87, 19, 69, 1, 736.00),
(88, 20, 69, 2, 1472.00),
(89, 21, 69, 2, 1472.00),
(90, 22, 69, 1, 736.00),
(91, 23, 69, 1, 736.00),
(92, 24, 69, 1, 736.00),
(93, 25, 69, 1, 736.00),
(94, 26, 69, 1, 736.00),
(95, 27, 69, 1, 736.00),
(96, 28, 69, 1, 736.00),
(97, 29, 69, 1, 736.00),
(98, 30, 69, 1, 736.00),
(99, 31, 69, 1, 736.00),
(100, 32, 69, 1, 736.00),
(101, 33, 69, 1, 736.00),
(102, 34, 69, 1, 736.00),
(103, 35, 69, 1, 736.00),
(104, 36, 69, 1, 736.00),
(105, 37, 69, 1, 736.00),
(106, 38, 69, 1, 736.00),
(107, 39, 69, 1, 736.00),
(108, 40, 69, 1, 736.00),
(109, 41, 69, 1, 736.00),
(110, 42, 69, 1, 736.00),
(111, 43, 69, 1, 736.00),
(112, 44, 69, 1, 736.00),
(113, 45, 69, 1, 736.00),
(114, 46, 69, 1, 736.00),
(115, 47, 69, 1, 736.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_quantity`
--

CREATE TABLE `stock_quantity` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_notifications`
--

CREATE TABLE `store_notifications` (
  `id` int(11) NOT NULL,
  `notification_title` varchar(255) NOT NULL,
  `notification_message` text NOT NULL,
  `notification_type` enum('promotion','event','announcement','update') NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('sent','scheduled','draft') DEFAULT 'scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_notifications`
--

INSERT INTO `store_notifications` (`id`, `notification_title`, `notification_message`, `notification_type`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(3, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:30', '2025-03-25 08:02:30'),
(4, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:30', '2025-03-25 08:02:30'),
(5, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(6, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(7, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(8, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(9, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(10, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(11, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(12, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(13, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(14, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(15, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(16, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(17, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(18, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(19, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(20, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(21, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(22, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(23, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(24, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(25, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(26, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(27, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(28, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_info` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_history`
--

CREATE TABLE `system_history` (
  `id` int(11) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `changed_by` int(11) NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telegram_promotions`
--

CREATE TABLE `telegram_promotions` (
  `id` int(11) NOT NULL,
  `name_telegram` varchar(255) NOT NULL,
  `type` enum('user','group','channel') NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `telegram_chat_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `telegram_promotions`
--

INSERT INTO `telegram_promotions` (`id`, `name_telegram`, `type`, `phone_number`, `telegram_chat_id`, `created_at`, `updated_at`) VALUES
(1, '', 'user', '09045678', NULL, '2025-03-23 06:27:23', '2025-03-23 06:27:23'),
(2, 'un_mean', 'user', '+855 97 920 1500', '1126297297', '2025-03-23 18:56:33', '2025-03-24 00:12:09'),
(3, 'promotion_group', 'group', NULL, '-4685114650', '2025-03-23 23:59:37', '2025-03-24 00:12:09'),
(4, 'Beauty Store', 'group', NULL, '-1002524734718', '2025-03-27 02:43:19', '2025-03-27 02:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`, `action`, `image`) VALUES
(20, 'sreyka', 'honsreyka6@gmail.com', '$2y$10$5j6.ZrBUxbNR278RLGR6VebiUoK.ybLdUlPoRNoprtb5hTzIXKDd2', 'admin', '2025-03-07 13:32:06', '2025-03-07 13:32:06', NULL, NULL),
(51, 'kaka', 'sreyka.hon@student.passerellesnumeriques.org', '$2y$10$06ib8EAJ7vEZsiaYCCkAZucmqPe5JAYBjRWtkOrV6PnS/d1ANAH9a', 'user', '2025-03-21 05:18:17', '2025-03-21 05:18:17', NULL, NULL),
(52, 'kaaa', 'kaaa@gmail.com', '$2y$10$kE25E8Ap62dkxMv8cCqO2eRAJ4i8optNUk/xZI005KmkVZLPbKMq2', 'Admin', '2025-03-30 08:28:20', '2025-03-30 08:28:20', NULL, '/uploads/67e900a445373.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_details` text DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waste`
--

CREATE TABLE `waste` (
  `waste_id` int(11) NOT NULL,
  `type` enum('product','category') NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `deletion_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`);

--
-- Indexes for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `deleted_by` (`deleted_by`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Indexes for table `product_expirations`
--
ALTER TABLE `product_expirations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batch_number` (`batch_number`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotion_code` (`promotion_code`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_quantity`
--
ALTER TABLE `stock_quantity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `store_notifications`
--
ALTER TABLE `store_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_history`
--
ALTER TABLE `system_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telegram_promotions`
--
ALTER TABLE `telegram_promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `waste`
--
ALTER TABLE `waste`
  ADD PRIMARY KEY (`waste_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `deleted_products`
--
ALTER TABLE `deleted_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `product_expirations`
--
ALTER TABLE `product_expirations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_quantity`
--
ALTER TABLE `stock_quantity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_notifications`
--
ALTER TABLE `store_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_history`
--
ALTER TABLE `system_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telegram_promotions`
--
ALTER TABLE `telegram_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_history`
--
ALTER TABLE `user_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_history`
--
ALTER TABLE `user_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waste`
--
ALTER TABLE `waste`
  MODIFY `waste_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD CONSTRAINT `deleted_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `deleted_products_ibfk_2` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `payment_history_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_expirations`
--
ALTER TABLE `product_expirations`
  ADD CONSTRAINT `product_expirations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD CONSTRAINT `stock_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_quantity`
--
ALTER TABLE `stock_quantity`
  ADD CONSTRAINT `stock_quantity_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_login_history`
--
ALTER TABLE `user_login_history`
  ADD CONSTRAINT `user_login_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
