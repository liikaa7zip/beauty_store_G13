-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 01:01 PM
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
(31, 'sdf', 'wdf', '2025-03-24 09:18:16', '2025-03-24 09:18:16'),
(32, 'Yvette Black', 'Voluptate reiciendis', '2025-04-04 11:57:39', '2025-04-04 11:57:39'),
(33, 'Lawrence Sharpe', 'Dolor aliquid neque', '2025-04-07 02:15:14', '2025-04-07 02:15:14'),
(34, 'Emery Barnett', 'Est ad quo sapiente', '2025-04-07 02:21:21', '2025-04-07 02:21:21'),
(35, 'Melanie Ruiz', 'Beatae dolore sit e', '2025-04-07 02:38:35', '2025-04-07 02:38:35'),
(36, 'Glenna Mitchell', 'Labore veniam hic s', '2025-04-07 03:38:15', '2025-04-07 03:38:15'),
(37, 'Brian Montoya', 'In magna fugiat qui', '2025-04-07 03:42:17', '2025-04-07 03:42:17'),
(38, 'Mikayla Blair', 'Iure natus repudiand', '2025-04-07 03:45:42', '2025-04-07 03:45:42'),
(39, 'Daphne Sherman', 'Sed qui ex ex aut', '2025-04-07 03:50:24', '2025-04-07 03:50:24'),
(40, 'Jesse Stevenson', 'Et blanditiis asperi', '2025-04-07 03:50:55', '2025-04-07 03:50:55'),
(42, 'Jesse Stevens12345', 'Et blanditiis asperi', '2025-04-07 03:52:16', '2025-04-07 04:09:05'),
(44, 'Haviva Conrad', 'Sint ipsum quod pos', '2025-04-08 12:48:33', '2025-04-08 12:48:33');

-- --------------------------------------------------------

--
-- Table structure for table `category_history`
--

CREATE TABLE `category_history` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `action` enum('created','updated','deleted') NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_history`
--

INSERT INTO `category_history` (`id`, `category_name`, `action`, `user_id`, `date`) VALUES
(7, 'Hilda Cotton', 'created', 20, '2025-04-08 12:52:00'),
(8, 'Hilda Cotton1234', 'updated', 20, '2025-04-08 12:52:57'),
(9, 'Hilda Cotton1234', 'deleted', 20, '2025-04-08 12:53:01'),
(10, 'kuky', 'created', 20, '2025-04-19 03:55:20'),
(11, 'yiyi', 'created', 20, '2025-04-19 03:55:52'),
(12, 'kuky', 'deleted', 59, '2025-04-22 06:58:51'),
(13, 'yiyii', 'updated', 59, '2025-04-22 15:04:04'),
(14, 'yiyii', 'deleted', 59, '2025-04-25 09:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `total_debt` decimal(10,2) NOT NULL DEFAULT 0.00,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `total_debt`, `address`) VALUES
(6, 'sreyka hon', '090482766', NULL, 80.00, 'Cambodia'),
(9, 'sreyka hon', '090482766', NULL, 67.00, 'Cambodia');

-- --------------------------------------------------------

--
-- Table structure for table `debts`
--

CREATE TABLE `debts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `payment_method` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments_backup`
--

CREATE TABLE `payments_backup` (
  `id` int(11) NOT NULL DEFAULT 0,
  `sale_id` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL
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
  `profit_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `created_at`, `updated_at`, `stocks`, `status`, `image`, `start_date`, `expire_date`, `original_price`, `profit_value`, `barcode`) VALUES
(64, 'nivea12', 'adsfgh', 4.00, 12, '2025-03-24 07:56:09', '2025-04-03 04:21:17', 0, 'low-stock', 'uploads/Vaseline-Intensive-Care-Radiant-Non-Greasy-Body-Lotion-Cocoa-10-fl-oz_8fc448dd-1016-4d19-859b-5b78bce98fef.7e5cfbe72427047913a4223726aa6948.webp', '2025-03-28', '2025-03-30', 0.00, 0.00, NULL),
(65, 'vaseline', 'wqsadcv', 5.00, 12, '2025-03-24 07:57:24', '2025-03-24 08:49:46', 0, 'low-stock', 'uploads/6764dfde5a3f42f9bba32bfa98fc6196-web_1010x1180_transparent_png.webp', '2025-03-29', '2025-03-31', 0.00, 0.00, NULL),
(69, 'Jaime Sears', 'Animi dolore aut sa', 736.00, 12, '2025-03-27 02:35:18', '2025-04-07 06:01:42', 0, 'low-stock', 'uploads/default-image.jpg', '2012-10-05', '1997-11-30', 0.00, 0.00, NULL),
(70, 'Samuel Galloway', 'Do vitae sit molesti', 410.00, 29, '2025-04-03 06:11:50', '2025-04-08 13:36:04', 20, 'instock', '', NULL, NULL, 0.00, 0.00, NULL),
(71, 'Sierra Jimenez', 'Maxime eos doloremqu', 314.00, 12, '2025-04-03 06:12:22', '2025-04-07 06:18:02', 57, 'instock', '', NULL, NULL, 0.00, 0.00, NULL),
(72, 'Shelby Hinton', 'Consequuntur illo es', 946.00, 30, '2025-04-03 06:15:05', '2025-04-08 13:52:01', 49, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(74, 'Jessica Duran', 'Eligendi eos nisi do', 409.00, 30, '2025-04-03 06:56:26', '2025-04-09 16:33:40', 43, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(75, 'Judah Phelps', 'Et amet soluta enim', 684.00, 29, '2025-04-04 11:58:38', '2025-04-09 11:44:28', 82, 'instock', 'uploads/default-image.jpg', '2019-03-26', '1981-12-29', 998.00, 0.00, NULL),
(77, 'Porter Sanchez', 'Quam perferendis qua', 933.00, 12, '2025-04-07 01:07:42', '2025-04-07 01:07:42', 96, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(78, 'Helen Logan', 'Nisi aute laborum qu', 966.00, 31, '2025-04-07 01:10:18', '2025-04-07 01:10:18', 77, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(80, 'Jessica Richard', 'Omnis et ut at error', 875.00, 30, '2025-04-07 01:54:45', '2025-04-07 01:54:45', 69, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(81, 'Sonia Hunter', 'Provident quia ut n', 523.00, 32, '2025-04-07 02:01:02', '2025-04-07 02:01:02', 55, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(83, 'Rama Cline', 'Dolorem aspernatur s', 802.00, 31, '2025-04-07 02:47:33', '2025-04-07 06:02:33', 88, 'instock', 'uploads/default-image.jpg', NULL, NULL, 0.00, 0.00, NULL),
(88, 'Summer Johns', 'Sapiente quam mollit', 691.00, 35, '2025-04-08 12:38:18', '2025-04-08 12:38:18', 75, 'instock', 'uploads/default-image.jpg', '1994-07-30', '2009-04-28', 609.00, 0.00, NULL),
(89, 'Tatiana Perry', 'Duis quibusdam quia ', 765.00, 34, '2025-04-08 12:39:35', '2025-04-08 12:39:35', 94, 'instock', 'uploads/default-image.jpg', '2007-04-29', '1973-08-16', 79.00, 0.00, NULL),
(90, 'Katell Curry', 'Ut quisquam do sapie', 32.00, 42, '2025-04-08 12:40:01', '2025-04-08 12:40:01', 53, 'instock', 'uploads/WIN_20250331_08_27_43_Pro.jpg', '1981-12-03', '1984-04-25', 725.00, 0.00, NULL);

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
-- Table structure for table `product_history`
--

CREATE TABLE `product_history` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `action` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_history`
--

INSERT INTO `product_history` (`id`, `product_name`, `action`, `user_id`, `date`) VALUES
(5, 'Bradley Pierce', 'deleted', 20, '2025-04-08 12:36:18'),
(6, 'Branden Johnston12', 'updated', 20, '2025-04-08 12:36:46'),
(7, 'Tatiana Perry', 'created', 20, '2025-04-08 12:39:35'),
(8, 'Katell Curry', 'created', 20, '2025-04-08 12:40:01'),
(9, 'haha', 'created', 20, '2025-04-19 03:58:48'),
(10, 'aaaaa', 'created', 20, '2025-04-19 13:31:44'),
(11, 'aa', 'updated', 20, '2025-04-19 13:55:02'),
(12, 'jujuju', 'created', 59, '2025-04-20 09:46:33'),
(13, 'jujuju', 'deleted', 59, '2025-04-20 10:00:04'),
(14, 'aa', 'deleted', 59, '2025-04-20 10:34:32'),
(15, 'Bree Riddles', 'deleted', 59, '2025-04-20 10:37:08'),
(16, 'hahaa', 'updated', 59, '2025-04-25 09:33:57'),
(17, 'hahaa', 'updated', 59, '2025-04-25 09:34:08');

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
(19, 'khmer', 'qwerty ', '2025-03-19', '2025-03-26', 12.00, '77', 'active', '2025-03-18 02:36:23', '2025-03-27 02:34:40'),
(27, 'kaka', 'asdfgh wertyu', '2025-03-26', '2025-03-31', 999.99, '09', 'active', '2025-03-20 13:11:33', '2025-04-23 05:54:38');

-- --------------------------------------------------------

--
-- Table structure for table `promotion_history`
--

CREATE TABLE `promotion_history` (
  `id` int(11) NOT NULL,
  `promotion_name` varchar(255) NOT NULL,
  `action` enum('created','updated','deleted','sent') NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promotion_history`
--

INSERT INTO `promotion_history` (`id`, `promotion_name`, `action`, `user_id`, `date`) VALUES
(4, 'Lyle Stanton123', 'sent', 20, '2025-04-08 12:41:05'),
(5, 'Lyle Stanton123', 'updated', 20, '2025-04-08 12:41:42'),
(6, 'Lyle Stanton123', 'deleted', 20, '2025-04-08 12:42:12'),
(7, 'Basia Campos', 'created', 20, '2025-04-08 12:42:46'),
(9, 'Basia Campos', 'sent', 59, '2025-04-23 05:28:15'),
(10, 'Basia Campos', 'sent', 59, '2025-04-23 05:37:15'),
(11, 'Basia Campos', 'sent', 59, '2025-04-23 05:37:51'),
(12, 'Basia Campos', 'sent', 59, '2025-04-23 05:40:07'),
(13, 'Basia Campos', 'sent', 59, '2025-04-23 05:40:47'),
(14, 'Basia Campos', 'updated', 59, '2025-04-23 05:42:42'),
(15, 'Basia Campos', 'updated', 59, '2025-04-23 05:42:59'),
(16, 'nwe', 'deleted', 59, '2025-04-23 05:51:19'),
(17, 'kaka', 'updated', 59, '2025-04-23 05:54:38'),
(18, 'Basia Campos', 'updated', 59, '2025-04-23 05:54:49'),
(19, 'Basia Camposs', 'updated', 59, '2025-04-23 06:20:34'),
(20, 'Basia Camposs', 'sent', 59, '2025-04-25 08:38:12'),
(21, 'Basia Camposss', 'updated', 59, '2025-04-25 09:34:45'),
(22, 'Basia Camposss', 'deleted', 59, '2025-04-25 09:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_status` enum('paid','unpaid','pending') DEFAULT 'pending',
  `sale_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `payment_status`, `sale_date`, `total_amount`) VALUES
(1, 0, 'pending', '2025-03-23 23:15:01', 0.00),
(2, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(3, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(4, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(5, 0, 'pending', '2025-03-29 00:00:00', 4.00),
(6, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(7, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(8, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(9, 0, 'pending', '2025-03-29 00:00:00', 8.00),
(10, 0, 'pending', '2025-03-29 00:00:00', 1472.00),
(11, 0, 'pending', '2025-03-29 00:00:00', 1472.00),
(12, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(13, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(14, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(15, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(16, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(17, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(18, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(19, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(20, 0, 'pending', '2025-03-29 00:00:00', 1472.00),
(21, 0, 'pending', '2025-03-29 00:00:00', 1472.00),
(22, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(23, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(24, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(25, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(26, 0, 'pending', '2025-03-29 00:00:00', 736.00),
(27, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(28, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(29, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(30, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(31, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(32, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(33, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(34, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(35, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(36, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(37, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(38, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(39, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(40, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(41, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(42, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(43, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(44, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(45, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(46, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(47, 0, 'pending', '2025-03-30 00:00:00', 736.00),
(48, 0, 'pending', '2025-04-07 00:00:00', 736.00),
(49, 0, 'pending', '2025-04-07 00:00:00', 802.00),
(50, 0, 'pending', '2025-04-07 00:00:00', 314.00),
(51, 0, 'pending', '2025-04-07 00:00:00', 6290.00),
(52, 0, 'pending', '2025-04-07 00:00:00', 314.00),
(53, 0, 'pending', '2025-04-08 00:00:00', 410.00),
(54, 0, 'pending', '2025-04-08 00:00:00', 4920.00),
(55, 0, 'pending', '2025-04-08 00:00:00', 946.00),
(56, 0, 'pending', '2025-04-08 00:00:00', 31450.00),
(57, 0, 'pending', '2025-04-08 15:56:03', 629.00),
(58, 0, 'pending', '2025-04-08 15:59:16', 629.00),
(59, 0, 'pending', '2025-04-09 07:08:00', 409.00),
(60, 0, 'pending', '2025-04-09 10:12:03', 684.00),
(61, 0, 'pending', '2025-04-09 10:18:53', 409.00),
(62, 0, 'pending', '2025-04-09 11:04:49', 1368.00),
(63, 0, 'pending', '2025-04-09 13:44:28', 684.00),
(64, 0, 'pending', '2025-04-09 18:33:40', 409.00),
(65, 0, 'pending', '2025-04-19 06:00:38', 312.00),
(66, 0, 'pending', '2025-04-19 06:01:55', 2496.00),
(67, 0, 'pending', '2025-04-25 10:39:18', 3120.00);

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
(44, 1, 65, 2, 10.00),
(45, 1, 65, 3, 15.00),
(51, 1, 64, 5, 20.00),
(52, 1, 64, 1, 4.00),
(53, 1, 64, 1, 4.00),
(55, 1, 64, 2, 8.00),
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
(115, 47, 69, 1, 736.00),
(116, 48, 69, 1, 736.00),
(117, 49, 83, 1, 802.00),
(118, 50, 71, 1, 314.00),
(120, 52, 71, 1, 314.00),
(121, 53, 70, 1, 410.00),
(122, 54, 70, 12, 4920.00),
(123, 55, 72, 1, 946.00),
(127, 59, 74, 1, 409.00),
(128, 60, 75, 1, 684.00),
(129, 61, 74, 1, 409.00),
(130, 62, 75, 2, 1368.00),
(131, 63, 75, 1, 684.00),
(132, 64, 74, 1, 409.00);

-- --------------------------------------------------------

--
-- Table structure for table `sale_products`
--

CREATE TABLE `sale_products` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_history`
--

CREATE TABLE `sell_history` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `performed_by` int(11) NOT NULL,
  `sale_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sell_history`
--

INSERT INTO `sell_history` (`id`, `sale_id`, `product_name`, `amount`, `quantity`, `performed_by`, `sale_date`) VALUES
(1, 58, 'Branden Johnston12', 629.00, 1, 58, '2025-04-08 15:59:16'),
(2, 59, 'Jessica Duran', 409.00, 1, 58, '2025-04-09 07:08:00'),
(3, 60, 'Judah Phelps', 684.00, 1, 58, '2025-04-09 10:12:03'),
(4, 61, 'Jessica Duran', 409.00, 1, 58, '2025-04-09 10:18:53'),
(5, 62, 'Judah Phelps', 1368.00, 2, 58, '2025-04-09 11:04:49'),
(6, 63, 'Judah Phelps', 684.00, 1, 58, '2025-04-09 13:44:28'),
(7, 64, 'Jessica Duran', 409.00, 1, 58, '2025-04-09 18:33:40'),
(8, 65, 'Cheryl Torres', 312.00, 1, 20, '2025-04-19 06:00:38'),
(9, 66, 'Cheryl Torres', 2496.00, 8, 20, '2025-04-19 06:01:55'),
(10, 67, 'Cheryl Torres', 3120.00, 10, 59, '2025-04-25 10:39:18');

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
(8, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
(9, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:31', '2025-03-25 08:02:31'),
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
(28, 'low', 'asdfghjk', '', '2025-03-26 15:02:00', '2025-03-27 15:02:00', '', '2025-03-25 02:02:32', '2025-03-25 08:02:32'),
(29, 'Low Stock Alert: nivea12', 'The product \'nivea12\' is running low with only 0 items left in stock.', '', '2025-04-08 14:26:28', '2025-04-15 14:26:28', '', '2025-04-08 07:26:28', '2025-04-08 12:26:28'),
(30, 'Low Stock Alert: vaseline', 'The product \'vaseline\' is running low with only 0 items left in stock.', '', '2025-04-08 14:26:28', '2025-04-15 14:26:28', '', '2025-04-08 07:26:28', '2025-04-08 12:26:28'),
(31, 'Low Stock Alert: DR', 'The product \'DR\' is running low with only 0 items left in stock.', '', '2025-04-08 14:26:28', '2025-04-15 14:26:28', '', '2025-04-08 07:26:28', '2025-04-08 12:26:28'),
(32, 'Low Stock Alert: Jaime Sears', 'The product \'Jaime Sears\' is running low with only 0 items left in stock.', '', '2025-04-08 14:26:28', '2025-04-15 14:26:28', '', '2025-04-08 07:26:28', '2025-04-08 12:26:28'),
(33, 'Low Stock Alert: haha', 'The product \'haha\' is running low with only 4 items left in stock.', '', '2025-04-19 06:00:58', '2025-04-26 06:00:58', '', '2025-04-18 23:00:58', '2025-04-19 04:00:58');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `action` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`, `action`, `image`, `role`) VALUES
(20, 'sreyka', 'honsreyka6@gmail.com', '$2y$10$5j6.ZrBUxbNR278RLGR6VebiUoK.ybLdUlPoRNoprtb5hTzIXKDd2', '2025-03-07 13:32:06', '2025-03-07 13:32:06', NULL, NULL, 'staff'),
(57, 'koooo', 'koo@gmail.com', '$2y$10$gbbtxH7Yt0i2qrldp4w5W.s9zjEcYSdKlTivIr5I2Vn23Rc/zFxEe', '2025-04-08 05:40:51', '2025-04-25 09:38:49', NULL, NULL, 'admin'),
(59, 'admin', 'admin@gmail.com', '$2y$10$xa5b87.uo2Q9rzk3.NLQvOStvCdCQYppXnheL4KlMYQ8DBsoLA4YW', '2025-04-19 03:10:57', '2025-04-19 03:10:57', NULL, 'https://cdn-icons-png.flaticon.com/512/149/149071.png', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_history`
--

CREATE TABLE `user_login_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` text NOT NULL,
  `status` enum('success','failed') NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login_history`
--

INSERT INTO `user_login_history` (`id`, `user_id`, `ip_address`, `user_agent`, `status`, `login_time`, `logout_time`) VALUES
(77, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 03:11:56', '2025-04-07 03:26:47'),
(78, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 03:26:51', '2025-04-07 03:56:00'),
(79, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 03:56:39', '2025-04-07 03:57:04'),
(80, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 03:57:24', '2025-04-07 03:58:04'),
(81, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 03:58:20', '2025-04-07 05:58:04'),
(82, 55, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 05:58:10', '2025-04-07 06:44:17'),
(83, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 06:44:21', '2025-04-07 06:44:25'),
(84, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 06:44:28', '2025-04-07 06:44:35'),
(85, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 06:44:37', '2025-04-07 06:44:47'),
(86, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 06:44:50', '2025-04-07 06:44:58'),
(87, 53, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-07 06:45:01', NULL),
(88, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 04:48:47', '2025-04-08 04:54:30'),
(89, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 04:54:46', '2025-04-08 04:55:37'),
(90, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 04:55:42', '2025-04-08 04:59:32'),
(91, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 04:59:38', '2025-04-08 05:04:44'),
(92, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:04:59', '2025-04-08 05:05:03'),
(93, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:05:09', '2025-04-08 05:10:24'),
(94, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:10:30', '2025-04-08 05:17:22'),
(95, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:17:28', '2025-04-08 05:18:37'),
(96, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:18:42', '2025-04-08 05:24:31'),
(97, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:24:39', '2025-04-08 05:24:44'),
(98, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:24:50', '2025-04-08 05:31:44'),
(99, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:31:49', '2025-04-08 05:33:53'),
(100, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:33:59', '2025-04-08 05:40:56'),
(101, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:41:24', '2025-04-08 05:42:39'),
(102, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:42:53', '2025-04-08 05:47:48'),
(103, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:47:55', '2025-04-08 05:54:04'),
(104, 58, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 05:54:10', '2025-04-08 13:01:56'),
(105, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-08 12:24:16', '2025-04-08 12:59:39'),
(106, 56, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-08 12:59:50', '2025-04-08 13:00:47'),
(107, 58, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-08 13:02:06', '2025-04-11 04:52:06'),
(108, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-08 15:39:09', '2025-04-08 15:42:06'),
(109, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-09 00:39:27', '2025-04-09 00:39:41'),
(110, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-09 09:23:44', '2025-04-11 00:04:48'),
(111, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-11 04:33:51', '2025-04-11 04:37:01'),
(112, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-11 04:52:13', '2025-04-11 04:53:30'),
(113, 58, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-11 04:53:34', '2025-04-11 05:06:04'),
(114, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-11 05:06:11', '2025-04-19 03:11:05'),
(115, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-19 03:11:13', '2025-04-19 03:11:19'),
(116, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'success', '2025-04-19 03:11:33', '2025-04-20 10:30:29'),
(117, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-20 06:37:57', '2025-04-20 10:30:07'),
(118, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-20 10:30:34', '2025-04-20 10:37:14'),
(119, 20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-20 10:37:22', '2025-04-20 10:42:06'),
(120, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-20 10:42:13', '2025-04-22 04:41:56'),
(121, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-22 04:42:56', '2025-04-22 15:21:57'),
(122, 59, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'success', '2025-04-22 15:22:05', NULL);

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
-- Indexes for table `category_history`
--
ALTER TABLE `category_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debts`
--
ALTER TABLE `debts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sale_id` (`sale_id`);

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
  ADD KEY `sale_id_index` (`sale_id`),
  ADD KEY `customer_id_index` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`barcode`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Indexes for table `product_expirations`
--
ALTER TABLE `product_expirations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batch_number` (`batch_number`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_history`
--
ALTER TABLE `product_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promotion_code` (`promotion_code`);

--
-- Indexes for table `promotion_history`
--
ALTER TABLE `promotion_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sale_products`
--
ALTER TABLE `sale_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sell_history`
--
ALTER TABLE `sell_history`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `category_history`
--
ALTER TABLE `category_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `debts`
--
ALTER TABLE `debts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `product_expirations`
--
ALTER TABLE `product_expirations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_history`
--
ALTER TABLE `product_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `promotion_history`
--
ALTER TABLE `promotion_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `sale_products`
--
ALTER TABLE `sale_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_history`
--
ALTER TABLE `sell_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_quantity`
--
ALTER TABLE `stock_quantity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_notifications`
--
ALTER TABLE `store_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `user_login_history`
--
ALTER TABLE `user_login_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

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
-- Constraints for table `category_history`
--
ALTER TABLE `category_history`
  ADD CONSTRAINT `category_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `debts`
--
ALTER TABLE `debts`
  ADD CONSTRAINT `debts_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `debts_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

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
  ADD CONSTRAINT `fk_customer_id_constraint` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `product_history`
--
ALTER TABLE `product_history`
  ADD CONSTRAINT `product_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `promotion_history`
--
ALTER TABLE `promotion_history`
  ADD CONSTRAINT `promotion_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
