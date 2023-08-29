-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2023 at 01:30 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `noon`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_stock_lines`
--

CREATE TABLE `add_stock_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `quantity_sold` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'quantity sold from this purchase line',
  `quantity_returned` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `expired_qauntity` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `purchase_price` decimal(15,4) DEFAULT NULL,
  `final_cost` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `sub_total` decimal(15,4) DEFAULT NULL,
  `sell_price` decimal(15,4) DEFAULT NULL,
  `dollar_purchase_price` decimal(15,4) DEFAULT NULL,
  `dollar_final_cost` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `dollar_sub_total` decimal(15,4) DEFAULT NULL,
  `dollar_sell_price` decimal(15,4) DEFAULT NULL,
  `cost` decimal(15,4) DEFAULT NULL,
  `dollar_cost` decimal(15,4) DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `manufacturing_date` varchar(255) DEFAULT NULL,
  `expiry_date` varchar(255) DEFAULT NULL,
  `expiry_warning` int(11) DEFAULT NULL,
  `convert_status_expire` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `add_stock_lines`
--

INSERT INTO `add_stock_lines` (`id`, `stock_transaction_id`, `product_id`, `quantity`, `quantity_sold`, `quantity_returned`, `expired_qauntity`, `purchase_price`, `final_cost`, `sub_total`, `sell_price`, `dollar_purchase_price`, `dollar_final_cost`, `dollar_sub_total`, `dollar_sell_price`, `cost`, `dollar_cost`, `batch_number`, `manufacturing_date`, `expiry_date`, `expiry_warning`, `convert_status_expire`, `deleted_at`, `created_at`, `updated_at`) VALUES
(12, 1, 1, 3.0000, 0.0000, 0.0000, 0.0000, NULL, 396.0000, 396.0000, NULL, 1.0000, 3.0000, 3.0000, 1.5000, 132.0000, 1.0000, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-16 01:04:19', '2023-08-16 01:04:19'),
(13, 1, 2, 2.0000, 0.0000, 0.0000, 0.0000, 140.0000, 280.0000, 280.0000, 150.0000, NULL, 2.1212, 2.1200, NULL, 140.0000, 1.0606, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-16 01:04:19', '2023-08-16 01:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `store_pos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('open','close') NOT NULL,
  `closed_at` datetime DEFAULT NULL,
  `closing_amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `discrepancy` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `source_type` varchar(25) DEFAULT NULL,
  `cash_given_to` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_register_transactions`
--

CREATE TABLE `cash_register_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash_register_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `pay_method` varchar(255) NOT NULL,
  `type` enum('debit','credit') DEFAULT NULL,
  `transaction_type` enum('initial','sell','transfer','refund','add_stock','cash_in','cash_out','expense','sell_return','closing_cash','wages_and_compensation') DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_type` varchar(25) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Other users in the system as source.',
  `referenced_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'used for cash in and cash out.',
  `notes` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `translation` longtext DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_update` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `cover`, `status`, `parent_id`, `translation`, `user_id`, `last_update`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'ملابس', 'categories/1.jpg', 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(2, 'Women\'s T-Shirts', 'categories/2.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(3, 'Men\'s T-Shirts', 'categories/3.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(4, 'Dresses', 'categories/4.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(5, 'Novelty socks', 'categories/5.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(6, 'Women\'s sunglasses', 'categories/6.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(7, 'Men\'s sunglasses', 'categories/7.jpg', 1, 1, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(8, 'الكترونيات', 'categories/8.jpg', 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(9, 'smart-tv', 'categories/9.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(10, 'labtop', 'categories/10.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(11, 'Headphone', 'categories/11.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(12, 'smart-phone', 'categories/12.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(13, 'camira', 'categories/13.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(14, 'playstation-5', 'categories/14.jpg', 1, 8, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `translations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`translations`)),
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `translation` longtext DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_update` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `slug`, `translation`, `user_id`, `last_update`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'red', 'red', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(2, 'sayan', 'sayan', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(3, 'pink', 'pink', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(4, 'green', 'green', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(5, 'skyblue', 'skyblue', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(6, 'gray', 'gray', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(7, 'white', 'white', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(8, 'black', 'black', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(9, 'yellow', 'yellow', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `thousand_seperator` varchar(255) DEFAULT ',',
  `decimal_seperator` varchar(255) DEFAULT '.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `country`, `currency`, `symbol`, `thousand_seperator`, `decimal_seperator`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ALL', 'Albania', 'Leke', 'Lek', ',', '.', NULL, NULL, NULL),
(2, 'USD', 'America', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(3, 'AF', 'Afghanistan', 'Afghanis', '؋', ',', '.', NULL, NULL, NULL),
(4, 'ARS', 'Argentina', 'Pesos', '$', ',', '.', NULL, NULL, NULL),
(5, 'AWG', 'Aruba', 'Guilders', 'ƒ', ',', '.', NULL, NULL, NULL),
(6, 'AUD', 'Australia', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(7, 'AZ', 'Azerbaijan', 'New Manats', 'ман', ',', '.', NULL, NULL, NULL),
(8, 'BSD', 'Bahamas', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(9, 'BBD', 'Barbados', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(10, 'BYR', 'Belarus', 'Rubles', 'p.', ',', '.', NULL, NULL, NULL),
(11, 'EUR', 'Belgium', 'Euro', '€', ',', '.', NULL, NULL, NULL),
(12, 'BZD', 'Beliz', 'Dollars', 'BZ$', ',', '.', NULL, NULL, NULL),
(13, 'BMD', 'Bermuda', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(14, 'BOB', 'Bolivia', 'Bolivianos', '$b', ',', '.', NULL, NULL, NULL),
(15, 'BAM', 'Bosnia and Herzegovina', 'Convertible Marka', 'KM', ',', '.', NULL, NULL, NULL),
(16, 'BWP', 'Botswana', 'Pula\'s', 'P', ',', '.', NULL, NULL, NULL),
(17, 'BG', 'Bulgaria', 'Leva', 'лв', ',', '.', NULL, NULL, NULL),
(18, 'BRL', 'Brazil', 'Reais', 'R$', ',', '.', NULL, NULL, NULL),
(19, 'GBP', 'Britain [United Kingdom]', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(20, 'BND', 'Brunei Darussalam', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(21, 'KHR', 'Cambodia', 'Riels', '៛', ',', '.', NULL, NULL, NULL),
(22, 'CAD', 'Canada', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(23, 'KYD', 'Cayman Islands', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(24, 'CLP', 'Chile', 'Pesos', '$', ',', '.', NULL, NULL, NULL),
(25, 'CNY', 'China', 'Yuan Renminbi', '¥', ',', '.', NULL, NULL, NULL),
(26, 'COP', 'Colombia', 'Pesos', '$', ',', '.', NULL, NULL, NULL),
(27, 'CRC', 'Costa Rica', 'Colón', '₡', ',', '.', NULL, NULL, NULL),
(28, 'HRK', 'Croatia', 'Kuna', 'kn', ',', '.', NULL, NULL, NULL),
(29, 'CUP', 'Cuba', 'Pesos', '₱', ',', '.', NULL, NULL, NULL),
(30, 'EUR', 'Cyprus', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(31, 'CZK', 'Czech Republic', 'Koruny', 'Kč', ',', '.', NULL, NULL, NULL),
(32, 'DKK', 'Denmark', 'Kroner', 'kr', ',', '.', NULL, NULL, NULL),
(33, 'DOP ', 'Dominican Republic', 'Pesos', 'RD$', ',', '.', NULL, NULL, NULL),
(34, 'XCD', 'East Caribbean', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(35, 'EGP', 'Egypt', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(36, 'SVC', 'El Salvador', 'Colones', '$', ',', '.', NULL, NULL, NULL),
(37, 'GBP', 'England [United Kingdom]', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(38, 'EUR', 'Euro', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(39, 'FKP', 'Falkland Islands', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(40, 'FJD', 'Fiji', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(41, 'EUR', 'France', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(42, 'GHC', 'Ghana', 'Cedis', '¢', ',', '.', NULL, NULL, NULL),
(43, 'GIP', 'Gibraltar', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(44, 'EUR', 'Greece', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(45, 'GTQ', 'Guatemala', 'Quetzales', 'Q', ',', '.', NULL, NULL, NULL),
(46, 'GGP', 'Guernsey', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(47, 'GYD', 'Guyana', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(48, 'EUR', 'Holland [Netherlands]', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(49, 'HNL', 'Honduras', 'Lempiras', 'L', ',', '.', NULL, NULL, NULL),
(50, 'HKD', 'Hong Kong', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(51, 'HUF', 'Hungary', 'Forint', 'Ft', ',', '.', NULL, NULL, NULL),
(52, 'ISK', 'Iceland', 'Kronur', 'kr', ',', '.', NULL, NULL, NULL),
(53, 'INR', 'India', 'Rupees', '₹', ',', '.', NULL, NULL, NULL),
(54, 'IDR', 'Indonesia', 'Rupiahs', 'Rp', ',', '.', NULL, NULL, NULL),
(55, 'IRR', 'Iran', 'Rials', '﷼', ',', '.', NULL, NULL, NULL),
(56, 'EUR', 'Ireland', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(57, 'IMP', 'Isle of Man', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(58, 'ILS', 'Israel', 'New Shekels', '₪', ',', '.', NULL, NULL, NULL),
(59, 'EUR', 'Italy', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(60, 'JMD', 'Jamaica', 'Dollars', 'J$', ',', '.', NULL, NULL, NULL),
(61, 'JPY', 'Japan', 'Yen', '¥', ',', '.', NULL, NULL, NULL),
(62, 'JEP', 'Jersey', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(63, 'KZT', 'Kazakhstan', 'Tenge', 'лв', ',', '.', NULL, NULL, NULL),
(64, 'KPW', 'Korea [North]', 'Won', '₩', ',', '.', NULL, NULL, NULL),
(65, 'KRW', 'Korea [South]', 'Won', '₩', ',', '.', NULL, NULL, NULL),
(66, 'KGS', 'Kyrgyzstan', 'Soms', 'лв', ',', '.', NULL, NULL, NULL),
(67, 'LAK', 'Laos', 'Kips', '₭', ',', '.', NULL, NULL, NULL),
(68, 'LVL', 'Latvia', 'Lati', 'Ls', ',', '.', NULL, NULL, NULL),
(69, 'LBP', 'Lebanon', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(70, 'LRD', 'Liberia', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(71, 'CHF', 'Liechtenstein', 'Switzerland Francs', 'CHF', ',', '.', NULL, NULL, NULL),
(72, 'LTL', 'Lithuania', 'Litai', 'Lt', ',', '.', NULL, NULL, NULL),
(73, 'EUR', 'Luxembourg', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(74, 'MKD', 'Macedonia', 'Denars', 'ден', ',', '.', NULL, NULL, NULL),
(75, 'MYR', 'Malaysia', 'Ringgits', 'RM', ',', '.', NULL, NULL, NULL),
(76, 'EUR', 'Malta', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(77, 'MUR', 'Mauritius', 'Rupees', '₨', ',', '.', NULL, NULL, NULL),
(78, 'MXN', 'Mexico', 'Pesos', '$', ',', '.', NULL, NULL, NULL),
(79, 'MNT', 'Mongolia', 'Tugriks', '₮', ',', '.', NULL, NULL, NULL),
(80, 'MZ', 'Mozambique', 'Meticais', 'MT', ',', '.', NULL, NULL, NULL),
(81, 'NAD', 'Namibia', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(82, 'NPR', 'Nepal', 'Rupees', '₨', ',', '.', NULL, NULL, NULL),
(83, 'ANG', 'Netherlands Antilles', 'Guilders', 'ƒ', ',', '.', NULL, NULL, NULL),
(84, 'EUR', 'Netherlands', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(85, 'NZD', 'New Zealand', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(86, 'NIO', 'Nicaragua', 'Cordobas', 'C$', ',', '.', NULL, NULL, NULL),
(87, 'NG', 'Nigeria', 'Nairas', '₦', ',', '.', NULL, NULL, NULL),
(88, 'KPW', 'North Korea', 'Won', '₩', ',', '.', NULL, NULL, NULL),
(89, 'NOK', 'Norway', 'Krone', 'kr', ',', '.', NULL, NULL, NULL),
(90, 'OMR', 'Oman', 'Rials', '﷼', ',', '.', NULL, NULL, NULL),
(91, 'PKR', 'Pakistan', 'Rupees', '₨', ',', '.', NULL, NULL, NULL),
(92, 'PAB', 'Panama', 'Balboa', 'B/.', ',', '.', NULL, NULL, NULL),
(93, 'PYG', 'Paraguay', 'Guarani', 'Gs', ',', '.', NULL, NULL, NULL),
(94, 'PE', 'Peru', 'Nuevos Soles', 'S/.', ',', '.', NULL, NULL, NULL),
(95, 'PHP', 'Philippines', 'Pesos', 'Php', ',', '.', NULL, NULL, NULL),
(96, 'PL', 'Poland', 'Zlotych', 'zł', ',', '.', NULL, NULL, NULL),
(97, 'QAR', 'Qatar', 'Rials', '﷼', ',', '.', NULL, NULL, NULL),
(98, 'RO', 'Romania', 'New Lei', 'lei', ',', '.', NULL, NULL, NULL),
(99, 'RUB', 'Russia', 'Rubles', 'руб', ',', '.', NULL, NULL, NULL),
(100, 'SHP', 'Saint Helena', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(101, 'SAR', 'Saudi Arabia', 'Riyals', '﷼', ',', '.', NULL, NULL, NULL),
(102, 'RSD', 'Serbia', 'Dinars', 'Дин.', ',', '.', NULL, NULL, NULL),
(103, 'SCR', 'Seychelles', 'Rupees', '₨', ',', '.', NULL, NULL, NULL),
(104, 'SGD', 'Singapore', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(105, 'EUR', 'Slovenia', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(106, 'SBD', 'Solomon Islands', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(107, 'SOS', 'Somalia', 'Shillings', 'S', ',', '.', NULL, NULL, NULL),
(108, 'ZAR', 'South Africa', 'Rand', 'R', ',', '.', NULL, NULL, NULL),
(109, 'KRW', 'South Korea', 'Won', '₩', ',', '.', NULL, NULL, NULL),
(110, 'EUR', 'Spain', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(111, 'LKR', 'Sri Lanka', 'Rupees', '₨', ',', '.', NULL, NULL, NULL),
(112, 'SEK', 'Sweden', 'Kronor', 'kr', ',', '.', NULL, NULL, NULL),
(113, 'CHF', 'Switzerland', 'Francs', 'CHF', ',', '.', NULL, NULL, NULL),
(114, 'SRD', 'Suriname', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(115, 'SYP', 'Syria', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(116, 'TWD', 'Taiwan', 'New Dollars', 'NT$', ',', '.', NULL, NULL, NULL),
(117, 'THB', 'Thailand', 'Baht', '฿', ',', '.', NULL, NULL, NULL),
(118, 'TTD', 'Trinidad and Tobago', 'Dollars', 'TT$', ',', '.', NULL, NULL, NULL),
(119, 'TRY', 'Turkey', 'Lira', 'TL', ',', '.', NULL, NULL, NULL),
(120, 'TRL', 'Turkey', 'Liras', '£', ',', '.', NULL, NULL, NULL),
(121, 'TVD', 'Tuvalu', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(122, 'UAH', 'Ukraine', 'Hryvnia', '₴', ',', '.', NULL, NULL, NULL),
(123, 'GBP', 'United Kingdom', 'Pounds', '£', ',', '.', NULL, NULL, NULL),
(124, 'USD', 'United States of America', 'Dollars', '$', ',', '.', NULL, NULL, NULL),
(125, 'UYU', 'Uruguay', 'Pesos', '$U', ',', '.', NULL, NULL, NULL),
(126, 'UZS', 'Uzbekistan', 'Sums', 'лв', ',', '.', NULL, NULL, NULL),
(127, 'EUR', 'Vatican City', 'Euro', '€', '.', ',', NULL, NULL, NULL),
(128, 'VEF', 'Venezuela', 'Bolivares Fuertes', 'Bs', ',', '.', NULL, NULL, NULL),
(129, 'VND', 'Vietnam', 'Dong', '₫', ',', '.', NULL, NULL, NULL),
(130, 'YER', 'Yemen', 'Rials', '﷼', ',', '.', NULL, NULL, NULL),
(131, 'ZWD', 'Zimbabwe', 'Zimbabwe Dollars', 'Z$', ',', '.', NULL, NULL, NULL),
(132, 'IQD', 'Iraq', 'Iraqi dinar', 'د.ع', ',', '.', NULL, NULL, NULL),
(133, 'KES', 'Kenya', 'Kenyan shilling', 'KSh', ',', '.', NULL, NULL, NULL),
(134, 'BDT', 'Bangladesh', 'Taka', '৳', ',', '.', NULL, NULL, NULL),
(135, 'LYD', 'Libyan', 'Libyan dinar', 'LD', ',', '.', NULL, NULL, NULL),
(136, 'DZD', 'Algerie', 'Algerian dinar', 'د.ج', ' ', '.', NULL, NULL, NULL),
(137, 'AED', 'United Arab Emirates', 'United Arab Emirates dirham', 'د.إ', ',', '.', NULL, NULL, NULL),
(138, 'UGX', 'Uganda', 'Uganda shillings', 'USh', ',', '.', NULL, NULL, NULL),
(139, 'TZS', 'Tanzania', 'Tanzanian shilling', 'TSh', ',', '.', NULL, NULL, NULL),
(140, 'AOA', 'Angola', 'Kwanza', 'Kz', ',', '.', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `deposit_balance` decimal(10,2) DEFAULT 0.00,
  `added_balance` decimal(10,2) DEFAULT 0.00,
  `customer_type_id` int(10) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `address`, `phone`, `deposit_balance`, `added_balance`, `customer_type_id`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Walk-in-customer', NULL, '', '12345678', 0.00, 0.00, 1, 1, NULL, NULL, NULL, '2023-08-07 07:10:00', '2023-08-13 08:43:53'),
(2, 'test1', NULL, NULL, NULL, 0.00, 0.00, 2, 2, NULL, NULL, NULL, '2023-08-15 03:21:09', '2023-08-15 03:21:09');

-- --------------------------------------------------------

--
-- Table structure for table `customer_balance_adjustments`
--

CREATE TABLE `customer_balance_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `current_balance` decimal(10,2) DEFAULT NULL,
  `add_new_balance` decimal(10,2) DEFAULT 0.00,
  `new_balance` decimal(10,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `date_and_time` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_important_dates`
--

CREATE TABLE `customer_important_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` text NOT NULL,
  `date` varchar(255) NOT NULL,
  `notify_before_days` int(11) NOT NULL,
  `is_notified` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_types`
--

CREATE TABLE `customer_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `translations` text DEFAULT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_types`
--

INSERT INTO `customer_types` (`id`, `name`, `translations`, `store_id`, `created_by`, `edited_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Walk in', NULL, NULL, 1, NULL, NULL, NULL, '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(2, 'test', '{\"name\":{\"en\":null,\"fr\":null,\"ar\":null,\"tr\":null,\"nl\":null,\"ur\":null,\"hi\":null,\"fa\":null}}', 3, 2, NULL, NULL, NULL, '2023-08-15 03:20:43', '2023-08-15 03:20:43');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `pass_string` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) NOT NULL,
  `date_of_start_working` date DEFAULT NULL,
  `job_type_id` int(10) UNSIGNED DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `annual_leave_per_year` int(11) DEFAULT NULL,
  `sick_leave_per_year` int(11) DEFAULT NULL,
  `payment_cycle` enum('daily','weekly','monthly') DEFAULT NULL,
  `commission` tinyint(4) DEFAULT NULL,
  `commission_value` decimal(10,2) DEFAULT NULL,
  `commission_type` enum('profit_sales') DEFAULT NULL,
  `commision_calculation_period` enum('daily','weekly','one_month','three_month') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `comissioned_products` text DEFAULT NULL,
  `comission_customer_types` text DEFAULT NULL,
  `comission_stores` text DEFAULT NULL,
  `comission_cashier` text DEFAULT NULL,
  `working_day_per_weak` varchar(255) DEFAULT NULL,
  `check_in` varchar(255) DEFAULT NULL,
  `check_out` varchar(255) DEFAULT NULL,
  `number_of_days_any_leave_added` int(11) DEFAULT NULL,
  `working_day_per_week` varchar(255) DEFAULT NULL,
  `fixed_wage` tinyint(1) NOT NULL DEFAULT 0,
  `fixed_wage_value` decimal(8,2) NOT NULL DEFAULT 0.00,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `updated_by`, `pass_string`, `employee_name`, `date_of_start_working`, `job_type_id`, `mobile`, `date_of_birth`, `annual_leave_per_year`, `sick_leave_per_year`, `payment_cycle`, `commission`, `commission_value`, `commission_type`, `commision_calculation_period`, `created_by`, `created_at`, `updated_at`, `deleted_by`, `deleted_at`, `comissioned_products`, `comission_customer_types`, `comission_stores`, `comission_cashier`, `working_day_per_weak`, `check_in`, `check_out`, `number_of_days_any_leave_added`, `working_day_per_week`, `fixed_wage`, `fixed_wage_value`, `photo`) VALUES
(1, 1, NULL, NULL, 'superadmin', '2023-08-13', NULL, '123456789', '1995-02-03', 0, 0, NULL, 0, 0.00, NULL, NULL, NULL, '2023-08-07 07:10:00', '2023-08-13 09:32:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{\"sunday\":null,\"monday\":null,\"tuesday\":null,\"wednesday\":null,\"thursday\":null,\"friday\":null,\"saturday\":null}', '{\"sunday\":null,\"monday\":null,\"tuesday\":null,\"wednesday\":null,\"thursday\":null,\"friday\":null,\"saturday\":null}', NULL, NULL, 0, 0.00, NULL),
(2, 2, NULL, NULL, 'Admin', '2023-08-13', NULL, '123456789', '1995-02-03', 10, 10, NULL, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:00', '2023-08-13 08:43:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_stores`
--

CREATE TABLE `employee_stores` (
  `employee_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_stores`
--

INSERT INTO `employee_stores` (`employee_id`, `store_id`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `price` double DEFAULT 0,
  `discount` double DEFAULT 0,
  `tax` double DEFAULT 0,
  `total` double DEFAULT 0,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cash',
  `status` varchar(255) NOT NULL DEFAULT 'paid',
  `cash` double DEFAULT NULL,
  `card` double DEFAULT NULL,
  `rest` double NOT NULL DEFAULT 0,
  `refund` double DEFAULT NULL,
  `refund_status` enum('creditor','debtor') DEFAULT NULL,
  `last_update` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `quantity` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

CREATE TABLE `job_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `date_of_creation` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `created_at`, `updated_at`, `deleted_at`, `title`, `date_of_creation`, `created_by`, `deleted_by`, `updated_by`) VALUES
(1, '2023-08-13 08:45:43', '2023-08-13 08:45:43', NULL, 'Cashier', '2023-08-13', 2, NULL, NULL),
(2, '2023-08-13 08:45:53', '2023-08-13 08:45:53', NULL, 'Deliveryman', '2023-08-13', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `number_of_days_per_year` int(11) DEFAULT NULL,
  `date_of_creation` date NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_03_094223_create_colors_table', 1),
(6, '2023_07_03_094342_create_sizes_table', 1),
(7, '2023_07_03_094355_create_units_table', 1),
(8, '2023_07_04_051201_create_product_subcategories_table', 1),
(9, '2023_07_04_090629_create_brands_table', 1),
(10, '2023_07_04_090629_create_categories_table', 1),
(11, '2023_07_04_090629_create_classes_table', 1),
(12, '2023_07_04_090629_create_currencies_table', 1),
(13, '2023_07_04_090629_create_customer_balance_adjustments_table', 1),
(14, '2023_07_04_090629_create_customer_types_table', 1),
(15, '2023_07_04_090629_create_customers_table', 1),
(16, '2023_07_04_090629_create_employees_table', 1),
(17, '2023_07_04_090629_create_exchange_rates_table', 1),
(18, '2023_07_04_090629_create_job_types_table', 1),
(19, '2023_07_04_090629_create_product_prices_table', 1),
(20, '2023_07_04_090629_create_product_stores_table', 1),
(21, '2023_07_04_090629_create_products_table', 1),
(22, '2023_07_04_090629_create_stores_table', 1),
(23, '2023_07_04_090639_create_foreign_keys', 1),
(24, '2023_07_05_101816_create_systems_table', 1),
(25, '2023_07_08_080223_create_permission_tables', 1),
(26, '2023_07_09_131841_add_foreign_keys_to_job_types_table', 1),
(27, '2023_07_09_225638_create_suppliers_table', 1),
(28, '2023_07_10_064024_create_leave_types_table', 1),
(29, '2023_07_10_105048_create_number_of_leaves_table', 1),
(30, '2023_07_11_095452_create_employee_stores_table', 1),
(34, '2023_07_23_052422_create_customer_important_dates_table', 1),
(35, '2023_07_23_103351_create_wages_table', 1),
(36, '2023_07_24_070519_create_wage_transactions_table', 1),
(37, '2023_07_24_072619_create_wage_transaction_payments_table', 1),
(38, '2023_07_24_132806_create_invoices_table', 1),
(39, '2023_07_24_133658_create_invoice_items_table', 1),
(40, '2023_07_26_090045_create_money_safes_table', 1),
(41, '2023_07_27_070552_create_money_safe_transactions_table', 1),
(42, '2023_08_01_051602_create_store_pos_table', 1),
(43, '2023_08_03_055529_create_cash_registers_table', 1),
(44, '2023_08_03_125118_create_cash_register_transactions_table', 1),
(45, '2023_07_18_065320_create_add_stock_lines_table', 2),
(47, '2023_07_18_065236_create_stock_transactions_table', 3),
(48, '2023_07_18_065319_create_stock_transaction_payments_table', 4),
(49, '2023_08_17_134040_create_transaction_sell_lines_table', 5),
(50, '2023_08_17_134042_create_sell_lines_table', 5),
(51, '2023_08_17_134134_create_payment_transaction_sell_lines_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_safes`
--

CREATE TABLE `money_safes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(60) NOT NULL,
  `type` varchar(20) NOT NULL,
  `add_money_users` text DEFAULT NULL,
  `take_money_users` text DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_safe_transactions`
--

CREATE TABLE `money_safe_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `money_safe_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `job_type_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,4) NOT NULL,
  `balance` decimal(15,4) DEFAULT 0.0000,
  `type` varchar(20) NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `number_of_leaves`
--

CREATE TABLE `number_of_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `leave_type_id` bigint(20) UNSIGNED NOT NULL,
  `number_of_days` int(11) DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction_sell_lines`
--

CREATE TABLE `payment_transaction_sell_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `paying_currency` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,4) NOT NULL,
  `method` varchar(255) NOT NULL,
  `paid_on` varchar(255) NOT NULL,
  `is_return` tinyint(1) NOT NULL DEFAULT 0,
  `payment_for` bigint(20) UNSIGNED DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Other users in the system as source.',
  `payment_note` text DEFAULT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'product_module.product.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(2, 'product_module.product.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(3, 'product_module.product.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(4, 'product_module.product.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(5, 'product_module.product_classification_tree.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(6, 'product_module.product_classification_tree.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(7, 'product_module.product_classification_tree.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(8, 'product_module.product_classification_tree.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(9, 'product_module.purchase_price.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(10, 'product_module.purchase_price.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(11, 'product_module.purchase_price.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(12, 'product_module.purchase_price.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(13, 'product_module.sell_price.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(14, 'product_module.sell_price.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(15, 'product_module.sell_price.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(16, 'product_module.sell_price.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(17, 'product_module.discount.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(18, 'product_module.discount.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(19, 'product_module.discount.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(20, 'product_module.discount.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(21, 'stock_module.add_stock.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(22, 'stock_module.add_stock.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(23, 'stock_module.add_stock.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(24, 'stock_module.add_stock.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(25, 'stock_module.pay.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(26, 'stock_module.pay.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(27, 'stock_module.pay.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(28, 'stock_module.pay.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(29, 'stock_module.remove_stock.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(30, 'stock_module.remove_stock.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(31, 'stock_module.remove_stock.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(32, 'stock_module.remove_stock.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(33, 'stock_module.internal_stock_request.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(34, 'stock_module.internal_stock_request.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(35, 'stock_module.internal_stock_request.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(36, 'stock_module.internal_stock_request.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(37, 'stock_module.internal_stock_return.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(38, 'stock_module.internal_stock_return.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(39, 'stock_module.internal_stock_return.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(40, 'stock_module.internal_stock_return.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(41, 'stock_module.transfer.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(42, 'stock_module.transfer.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(43, 'stock_module.transfer.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(44, 'stock_module.transfer.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(45, 'stock_module.import.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(46, 'stock_module.import.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(47, 'stock_module.import.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(48, 'stock_module.import.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(49, 'cashier_module.pos.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(50, 'cashier_module.pos.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(51, 'cashier_module.pos.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(52, 'cashier_module.pos.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(53, 'cashier_module.pay.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(54, 'cashier_module.pay.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(55, 'cashier_module.pay.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(56, 'cashier_module.pay.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(57, 'cashier_module.sale.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(58, 'cashier_module.sale.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(59, 'cashier_module.sale.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(60, 'cashier_module.sale.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(61, 'cashier_module.delivery_list.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(62, 'cashier_module.delivery_list.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(63, 'cashier_module.delivery_list.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(64, 'cashier_module.delivery_list.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(65, 'cashier_module.import.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:00'),
(66, 'cashier_module.import.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(67, 'cashier_module.import.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(68, 'cashier_module.import.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(69, 'return_module.sell_return.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(70, 'return_module.sell_return.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(71, 'return_module.sell_return.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(72, 'return_module.sell_return.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(73, 'return_module.sell_return_pay.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(74, 'return_module.sell_return_pay.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(75, 'return_module.sell_return_pay.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(76, 'return_module.sell_return_pay.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(77, 'return_module.purchase_return.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(78, 'return_module.purchase_return.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(79, 'return_module.purchase_return.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(80, 'return_module.purchase_return.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(81, 'return_module.purchase_return_pay.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(82, 'return_module.purchase_return_pay.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(83, 'return_module.purchase_return_pay.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(84, 'return_module.purchase_return_pay.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(85, 'employee_module.employee.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(86, 'employee_module.employee.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(87, 'employee_module.employee.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(88, 'employee_module.employee.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(89, 'employee_module.employee_commission.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(90, 'employee_module.employee_commission.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(91, 'employee_module.employee_commission.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(92, 'employee_module.employee_commission.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(93, 'employee_module.jobs.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(94, 'employee_module.jobs.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(95, 'employee_module.jobs.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(96, 'employee_module.jobs.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(97, 'employee_module.leave_types.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(98, 'employee_module.leave_types.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(99, 'employee_module.leave_types.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(100, 'employee_module.leave_types.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(101, 'employee_module.leaves.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(102, 'employee_module.leaves.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(103, 'employee_module.leaves.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(104, 'employee_module.leaves.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(105, 'employee_module.attendance.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(106, 'employee_module.attendance.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(107, 'employee_module.attendance.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(108, 'employee_module.attendance.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(109, 'employee_module.wages.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(110, 'employee_module.wages.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(111, 'employee_module.wages.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(112, 'employee_module.wages.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(113, 'customer_module.customer.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(114, 'customer_module.customer.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(115, 'customer_module.customer.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(116, 'customer_module.customer.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(117, 'customer_module.customer_type.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(118, 'customer_module.customer_type.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(119, 'customer_module.customer_type.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(120, 'customer_module.customer_type.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(121, 'customer_module.add_payment.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(122, 'customer_module.add_payment.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(123, 'customer_module.add_payment.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(124, 'customer_module.add_payment.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(125, 'supplier_module.supplier.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(126, 'supplier_module.supplier.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(127, 'supplier_module.supplier.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(128, 'supplier_module.supplier.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(129, 'reports_module.profit_loss.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(130, 'reports_module.profit_loss.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(131, 'reports_module.profit_loss.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(132, 'reports_module.profit_loss.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(133, 'reports_module.daily_sales_summary.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(134, 'reports_module.daily_sales_summary.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(135, 'reports_module.daily_sales_summary.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(136, 'reports_module.daily_sales_summary.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(137, 'reports_module.receivable_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(138, 'reports_module.receivable_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(139, 'reports_module.receivable_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(140, 'reports_module.receivable_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(141, 'reports_module.payable_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(142, 'reports_module.payable_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(143, 'reports_module.payable_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(144, 'reports_module.payable_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(145, 'reports_module.expected_receivable_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(146, 'reports_module.expected_receivable_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(147, 'reports_module.expected_receivable_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(148, 'reports_module.expected_receivable_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(149, 'reports_module.expected_payable_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(150, 'reports_module.expected_payable_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(151, 'reports_module.expected_payable_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(152, 'reports_module.expected_payable_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(153, 'reports_module.summary_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(154, 'reports_module.summary_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(155, 'reports_module.summary_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(156, 'reports_module.summary_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(157, 'reports_module.sales_per_employee.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(158, 'reports_module.sales_per_employee.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(159, 'reports_module.sales_per_employee.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(160, 'reports_module.sales_per_employee.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(161, 'reports_module.best_seller_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(162, 'reports_module.best_seller_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(163, 'reports_module.best_seller_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(164, 'reports_module.best_seller_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(165, 'reports_module.product_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(166, 'reports_module.product_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(167, 'reports_module.product_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(168, 'reports_module.product_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(169, 'reports_module.daily_sale_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(170, 'reports_module.daily_sale_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(171, 'reports_module.daily_sale_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(172, 'reports_module.daily_sale_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(173, 'reports_module.monthly_sale_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(174, 'reports_module.monthly_sale_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(175, 'reports_module.monthly_sale_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(176, 'reports_module.monthly_sale_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(177, 'reports_module.daily_purchase_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(178, 'reports_module.daily_purchase_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(179, 'reports_module.daily_purchase_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(180, 'reports_module.daily_purchase_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(181, 'reports_module.monthly_purchase_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(182, 'reports_module.monthly_purchase_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(183, 'reports_module.monthly_purchase_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(184, 'reports_module.monthly_purchase_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(185, 'reports_module.sale_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(186, 'reports_module.sale_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(187, 'reports_module.sale_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(188, 'reports_module.sale_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(189, 'reports_module.purchase_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(190, 'reports_module.purchase_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(191, 'reports_module.purchase_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(192, 'reports_module.purchase_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(193, 'reports_module.store_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(194, 'reports_module.store_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(195, 'reports_module.store_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(196, 'reports_module.store_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(197, 'reports_module.store_stock_chart.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(198, 'reports_module.store_stock_chart.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(199, 'reports_module.store_stock_chart.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(200, 'reports_module.store_stock_chart.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(201, 'reports_module.product_quantity_alert_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(202, 'reports_module.product_quantity_alert_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(203, 'reports_module.product_quantity_alert_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(204, 'reports_module.product_quantity_alert_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(205, 'reports_module.user_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(206, 'reports_module.user_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(207, 'reports_module.user_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(208, 'reports_module.user_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(209, 'reports_module.customer_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(210, 'reports_module.customer_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(211, 'reports_module.customer_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(212, 'reports_module.customer_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(213, 'reports_module.supplier_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(214, 'reports_module.supplier_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(215, 'reports_module.supplier_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(216, 'reports_module.supplier_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(217, 'reports_module.due_report.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(218, 'reports_module.due_report.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(219, 'reports_module.due_report.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(220, 'reports_module.due_report.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(221, 'settings_module.store.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(222, 'settings_module.store.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(223, 'settings_module.store.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(224, 'settings_module.store.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(225, 'settings_module.modules.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(226, 'settings_module.modules.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(227, 'settings_module.modules.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(228, 'settings_module.modules.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(229, 'settings_module.general_settings.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(230, 'settings_module.general_settings.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(231, 'settings_module.general_settings.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(232, 'settings_module.general_settings.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(233, 'settings_module.category.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(234, 'settings_module.category.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(235, 'settings_module.category.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(236, 'settings_module.category.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(237, 'settings_module.brand.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(238, 'settings_module.brand.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(239, 'settings_module.brand.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(240, 'settings_module.brand.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(241, 'settings_module.unit.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(242, 'settings_module.unit.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(243, 'settings_module.unit.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(244, 'settings_module.unit.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(245, 'settings_module.color.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(246, 'settings_module.color.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(247, 'settings_module.color.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(248, 'settings_module.color.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(249, 'settings_module.size.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(250, 'settings_module.size.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(251, 'settings_module.size.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(252, 'settings_module.size.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(253, 'settings_module.money_safe.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(254, 'settings_module.money_safe.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(255, 'settings_module.money_safe.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(256, 'settings_module.money_safe.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(257, 'settings_module.add_money_to_safe.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(258, 'settings_module.add_money_to_safe.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(259, 'settings_module.add_money_to_safe.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(260, 'settings_module.add_money_to_safe.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(261, 'settings_module.take_money_from_safe.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(262, 'settings_module.take_money_from_safe.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(263, 'settings_module.take_money_from_safe.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(264, 'settings_module.take_money_from_safe.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(265, 'settings_module.statement.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(266, 'settings_module.statement.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(267, 'settings_module.statement.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(268, 'settings_module.statement.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(269, 'settings_module.add_cash_in.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(270, 'settings_module.add_cash_in.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(271, 'settings_module.add_cash_in.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(272, 'settings_module.add_cash_in.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(273, 'settings_module.add_closing_cash.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(274, 'settings_module.add_closing_cash.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(275, 'settings_module.add_closing_cash.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(276, 'settings_module.add_closing_cash.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(277, 'settings_module.add_cash_out.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(278, 'settings_module.add_cash_out.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(279, 'settings_module.add_cash_out.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(280, 'settings_module.add_cash_out.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(281, 'settings_module.view_details.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(282, 'settings_module.view_details.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(283, 'settings_module.view_details.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(284, 'settings_module.view_details.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(285, 'settings_module.sales_promotion.view', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(286, 'settings_module.sales_promotion.create', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(287, 'settings_module.sales_promotion.edit', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01'),
(288, 'settings_module.sales_promotion.delete', 'web', '2023-08-07 07:10:00', '2023-08-07 07:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `translations` text DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` text DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `details_translations` text DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `length` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `size` decimal(10,2) DEFAULT 0.00,
  `weight` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `brand_id` int(10) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `translations`, `sku`, `category_id`, `image`, `unit_id`, `details`, `details_translations`, `height`, `length`, `width`, `size`, `weight`, `active`, `brand_id`, `created_by`, `edited_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'برتقال', '{\"name\":{\"en\":null,\"fr\":null,\"ar\":null,\"tr\":null,\"nl\":null,\"ur\":null,\"hi\":null,\"fa\":null}}', '123', 1, '1.jpg', 1, NULL, '{\"details\":{\"en\":null,\"fr\":null,\"ar\":null,\"tr\":null,\"nl\":null,\"ur\":null,\"hi\":null,\"fa\":null}}', 1.00, 2.00, 3.00, 6.00, 0.25, 0, NULL, NULL, 2, NULL, NULL, '2023-08-07 07:10:02', '2023-08-22 04:43:53'),
(2, 'مانجا', NULL, NULL, 1, '2.jpg', 1, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(3, 'شاورما', NULL, NULL, 2, '3.jpg', 2, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(4, 'كباب', NULL, NULL, 2, '4.jpg', 2, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(5, 'فليه', NULL, NULL, 3, '5.jpg', 3, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02'),
(6, 'جمبري', NULL, NULL, 3, '6.jpg', 3, NULL, NULL, NULL, NULL, NULL, 0.00, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', '2023-08-07 07:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price_type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_start_date` varchar(255) DEFAULT NULL,
  `price_end_date` varchar(255) DEFAULT NULL,
  `price_customer_types` text DEFAULT NULL,
  `price_customers` text DEFAULT NULL,
  `price_category` text DEFAULT NULL,
  `is_price_permenant` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `bonus_quantity` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_id`, `price_type`, `price`, `price_start_date`, `price_end_date`, `price_customer_types`, `price_customers`, `price_category`, `is_price_permenant`, `quantity`, `bonus_quantity`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(10, 1, 'fixed', 0.50, NULL, NULL, '[\"2\"]', NULL, 'test2', '1', 1, 1, 2, NULL, NULL, '2023-08-22 04:43:53', '2023-08-22 04:43:53'),
(11, 1, 'fixed', 1.00, NULL, NULL, '[\"1\"]', NULL, 'test', '1', 10, 2, 2, NULL, NULL, '2023-08-22 04:43:53', '2023-08-22 04:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_stores`
--

CREATE TABLE `product_stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `quantity_available` double DEFAULT NULL,
  `quantity_expired` double DEFAULT NULL,
  `block_quantity` double DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_subcategories`
--

CREATE TABLE `product_subcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sell_lines`
--

CREATE TABLE `sell_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `quantity_returned` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `purchase_price` decimal(15,4) NOT NULL,
  `sell_price` decimal(15,4) NOT NULL,
  `sub_total` decimal(15,4) NOT NULL,
  `coupon_discount_type` varchar(255) DEFAULT NULL,
  `coupon_discount` decimal(15,4) DEFAULT NULL,
  `coupon_discount_amount` decimal(15,4) DEFAULT NULL,
  `promotion_discount_type` varchar(255) DEFAULT NULL,
  `promotion_discount` decimal(15,4) DEFAULT NULL,
  `promotion_discount_amount` decimal(15,4) DEFAULT NULL,
  `point_earned` tinyint(1) NOT NULL DEFAULT 0,
  `point_redeemed` tinyint(1) NOT NULL DEFAULT 0,
  `product_discount_type` varchar(255) DEFAULT NULL,
  `product_discount_value` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `product_discount_amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_method` varchar(255) DEFAULT NULL,
  `item_tax` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `tax_rate` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `restaurant_order_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `translation` longtext DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_update` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `slug`, `translation`, `user_id`, `last_update`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'xs', 'xs', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(2, 's', 's', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(3, 'm', 'm', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(4, 'l', 'l', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(5, 'xl', 'xl', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(6, 'xxl', 'xxl', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL),
(7, 'xxxl', 'xxxl', NULL, NULL, NULL, NULL, '2023-08-07 07:10:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `transaction_currency` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('received','partially_received') NOT NULL,
  `purchase_type` enum('import','local') NOT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `payment_status` enum('paid','pending','partial') DEFAULT NULL,
  `divide_costs` enum('price','size','weight') DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `other_expenses` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `other_payments` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `discount_amount` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'amount calculated based on type and value',
  `grand_total` decimal(15,4) DEFAULT NULL,
  `final_total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `dollar_grand_total` decimal(15,4) DEFAULT NULL,
  `dollar_final_total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `notes` text DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `notify_me` tinyint(1) NOT NULL DEFAULT 0,
  `notify_before_days` int(11) NOT NULL DEFAULT 0,
  `canceled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `store_id`, `transaction_currency`, `supplier_id`, `status`, `purchase_type`, `order_date`, `transaction_date`, `payment_status`, `divide_costs`, `invoice_no`, `po_no`, `purchase_order_id`, `other_expenses`, `other_payments`, `discount_amount`, `grand_total`, `final_total`, `dollar_grand_total`, `dollar_final_total`, `notes`, `source_type`, `source_id`, `due_date`, `notify_me`, `notify_before_days`, `canceled_by`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 'received', 'local', '2023-08-16 04:04:19', '2023-08-16 04:04:19', 'partial', NULL, NULL, NULL, NULL, 0.0000, 0.0000, 0.0000, 676.0000, 676.0000, 5.1200, 5.1200, NULL, NULL, NULL, NULL, 0, 0, NULL, 2, NULL, NULL, NULL, '2023-08-16 01:04:19', '2023-08-16 01:04:19');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transaction_payments`
--

CREATE TABLE `stock_transaction_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `paying_currency` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,4) NOT NULL,
  `method` varchar(255) NOT NULL,
  `paid_on` varchar(255) NOT NULL,
  `is_return` tinyint(1) NOT NULL DEFAULT 0,
  `payment_for` bigint(20) UNSIGNED DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Other users in the system as source.',
  `payment_note` text DEFAULT NULL,
  `exchange_rate` decimal(8,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transaction_payments`
--

INSERT INTO `stock_transaction_payments` (`id`, `stock_transaction_id`, `paying_currency`, `amount`, `method`, `paid_on`, `is_return`, `payment_for`, `source_type`, `source_id`, `payment_note`, `exchange_rate`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 4.0000, 'cash', '2023-08-16 04:04:19', 0, NULL, NULL, NULL, NULL, 132.00, 2, NULL, '2023-08-16 01:04:19', '2023-08-16 01:04:19'),
(2, 1, 2, 0.1200, 'cash', '2023-08-16 14:36:12', 0, NULL, NULL, NULL, NULL, 132.00, 2, NULL, '2023-08-16 11:36:12', '2023-08-16 11:36:12'),
(3, 1, 2, 0.5000, 'cash', '2023-08-17 07:47:35', 0, NULL, NULL, NULL, NULL, 132.00, 2, NULL, '2023-08-17 04:47:35', '2023-08-17 04:47:35'),
(4, 1, 119, 66.0000, 'cash', '2023-08-17 08:19:17', 0, NULL, NULL, NULL, NULL, 132.00, 2, NULL, '2023-08-17 05:19:17', '2023-08-17 05:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `manager_name` varchar(255) DEFAULT NULL,
  `manager_mobile_number` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `location`, `phone_number`, `email`, `manager_name`, `manager_mobile_number`, `details`, `created_by`, `deleted_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Default Storee', '', '01000', NULL, 'superadmin', NULL, NULL, 1, NULL, 2, '2023-08-07 07:10:00', '2023-08-10 04:00:12', '2023-08-10 04:00:12'),
(2, 'store', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, '2023-08-10 04:01:35', '2023-08-10 04:01:48', '2023-08-10 04:01:48'),
(3, 'store2', NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, '2023-08-10 04:02:07', '2023-08-10 04:02:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_pos`
--

CREATE TABLE `store_pos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_pos`
--

INSERT INTO `store_pos` (`id`, `store_id`, `name`, `user_id`, `created_by`, `edited_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'store_poss', 2, NULL, NULL, NULL, NULL, '2023-08-08 09:29:20', '2023-08-08 09:29:31'),
(2, 3, 'Cashier', 2, NULL, NULL, NULL, NULL, '2023-08-13 08:29:33', '2023-08-13 08:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `company_name` varchar(30) DEFAULT NULL,
  `vat_number` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(30) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `postal_code` varchar(30) DEFAULT NULL,
  `exchange_rate` decimal(15,4) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_category_id`, `name`, `company_name`, `vat_number`, `email`, `mobile_number`, `address`, `city`, `state`, `country`, `postal_code`, `exchange_rate`, `image`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'test12', NULL, NULL, 'test12@test12.com', '010', NULL, NULL, NULL, NULL, NULL, 132.0000, NULL, 2, NULL, NULL, NULL, '2023-08-07 07:10:54', '2023-08-17 05:17:23'),
(2, NULL, 'test1', NULL, NULL, 'test1@test.com', NULL, NULL, NULL, NULL, NULL, NULL, 1240.0000, NULL, 2, 2, NULL, NULL, '2023-08-07 09:19:31', '2023-08-13 04:42:42'),
(3, 1, 'test22', NULL, NULL, 'test22@test22.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, '2023-08-08 09:00:26', '2023-08-08 09:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `systems`
--

CREATE TABLE `systems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `date_and_time` datetime NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `systems`
--

INSERT INTO `systems` (`id`, `key`, `value`, `date_and_time`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'sender_email', 'admin@gmail.com', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(2, 'time_format', '24', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(3, 'timezone', 'Asia/Qatar', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(4, 'language', 'en', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(5, 'logo', 'sharifshalaby.png', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(6, 'site_title', 'sherifsalaby.tech', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(7, 'system_type', 'noon', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(8, 'tutorial_guide_url', 'https://noon.sherifshalaby.tech', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(9, 'show_the_window_printing_prompt', '1', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(10, 'currency', '119', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(11, 'numbers_length_after_dot', '2', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(12, 'module_settings', '{\"dashboard\":1,\"product_module\":1,\"stock_module\":1,\"cashier_module\":1,\"return_module\":1,\"employee_module\":1,\"customer_module\":1,\"supplier_module\":1,\"reports_module\":1,\"settings_module\":1}', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(13, 'dollar_exchange', '132', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(14, 'watsapp_numbers', '123456789', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(15, 'tax', '33', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(16, 'default_payment_type', 'cash', '2023-08-13 11:43:53', 1, NULL, NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53'),
(17, 'weight_product1', '0', '2023-08-08 12:29:20', 2, NULL, NULL, '2023-08-08 09:29:20', '2023-08-08 09:29:20'),
(18, 'weight_product2', '0', '2023-08-13 11:29:33', 2, NULL, NULL, '2023-08-13 08:29:33', '2023-08-13 08:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_sell_lines`
--

CREATE TABLE `transaction_sell_lines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `store_pos_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sub_type` varchar(255) DEFAULT NULL,
  `status` enum('received','pending','ordered','final','draft','sent_admin','sent_supplier','partially_received','approved','rejected','expired','valid','declined','send_the_goods','compensated','canceled') NOT NULL,
  `ticket_number` int(11) NOT NULL DEFAULT 0 COMMENT 'used for restaurant only',
  `order_date` varchar(255) DEFAULT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `payment_status` enum('paid','pending','partial') DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `is_raw_material` tinyint(1) NOT NULL DEFAULT 0,
  `is_direct_sale` tinyint(1) NOT NULL DEFAULT 0,
  `is_return` tinyint(1) NOT NULL DEFAULT 0,
  `is_quotation` tinyint(1) NOT NULL DEFAULT 0,
  `is_internal_stock_transfer` tinyint(1) NOT NULL DEFAULT 0,
  `block_qty` tinyint(1) NOT NULL DEFAULT 0,
  `block_for_days` int(11) NOT NULL DEFAULT 0,
  `validity_days` int(11) NOT NULL DEFAULT 0,
  `parent_sale_id` bigint(20) UNSIGNED DEFAULT NULL,
  `return_parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `add_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gift_card_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gift_card_amount` decimal(15,4) DEFAULT NULL,
  `tax_method` varchar(25) DEFAULT NULL,
  `total_tax` decimal(15,4) DEFAULT NULL,
  `total_item_tax` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `other_expenses` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `other_payments` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'discount value applied by user',
  `discount_amount` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'amount calculated based on type and value',
  `total_sp_discount` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'total of sale promotion discount',
  `total_product_surplus` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'total of product surplus',
  `total_product_discount` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'total of product discount',
  `total_coupon_discount` decimal(15,4) NOT NULL DEFAULT 0.0000 COMMENT 'total of coupon discount',
  `ref_no` varchar(255) DEFAULT NULL,
  `grand_total` decimal(15,4) DEFAULT NULL,
  `final_total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `exchange_rate` decimal(15,4) NOT NULL DEFAULT 1.0000,
  `default_currency_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'system default currency id',
  `received_currency_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'currency id of received currency',
  `paying_currency_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'currency id of paying currency',
  `deliveryman_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'employee id foriegn key from employees table',
  `delivery_status` varchar(255) DEFAULT NULL,
  `delivery_cost` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `delivery_cost_paid_by_customer` tinyint(1) NOT NULL DEFAULT 1,
  `delivery_cost_given_to_deliveryman` tinyint(1) NOT NULL DEFAULT 0,
  `delivery_address` text DEFAULT NULL,
  `expense_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_beneficiary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `next_payment_date` varchar(255) DEFAULT NULL,
  `sender_store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_store_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rp_earned` int(11) NOT NULL DEFAULT 0,
  `rp_redeemed` int(11) NOT NULL DEFAULT 0,
  `rp_redeemed_value` int(11) NOT NULL DEFAULT 0,
  `current_deposit_balance` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `used_deposit_balance` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `remaining_deposit_balance` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `add_to_deposit` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `details` text DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `sale_note` text DEFAULT NULL,
  `staff_note` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `customer_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fabric_name` varchar(255) DEFAULT NULL,
  `fabric_squatch` varchar(255) DEFAULT NULL,
  `prova_datetime` varchar(255) DEFAULT NULL,
  `delivery_datetime` varchar(255) DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `terms_and_condition_id` bigint(20) UNSIGNED DEFAULT NULL,
  `compensated_value` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `compensated_at` varchar(255) DEFAULT NULL,
  `compensated_invoice_no` varchar(255) DEFAULT NULL,
  `approved_at` varchar(255) DEFAULT NULL,
  `received_at` varchar(255) DEFAULT NULL,
  `declined_at` varchar(255) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `declined_by` varchar(255) DEFAULT NULL,
  `due_date` varchar(255) DEFAULT NULL,
  `notify_me` tinyint(1) NOT NULL DEFAULT 0,
  `notify_before_days` int(11) NOT NULL DEFAULT 0,
  `wages_and_compensation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `restaurant_order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dining_room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dining_table_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_fee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_fee_rate` decimal(15,4) DEFAULT NULL,
  `service_fee_value` decimal(15,4) DEFAULT NULL,
  `delivery_zone_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manual_delivery_zone` varchar(255) DEFAULT NULL,
  `table_no` varchar(255) DEFAULT NULL,
  `commissioned_employees` text DEFAULT NULL,
  `shared_commission` tinyint(1) NOT NULL DEFAULT 0,
  `canceled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `translation` longtext DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_update` bigint(20) UNSIGNED DEFAULT NULL,
  `base_unit_multiplier` decimal(8,2) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `slug`, `translation`, `user_id`, `last_update`, `base_unit_multiplier`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'كارتون10', 'karton10', '{\"name\":{\"en\":null,\"fr\":null,\"ar\":null,\"tr\":null,\"nl\":null,\"ur\":null,\"hi\":null,\"fa\":null}}', 2, NULL, 10.00, NULL, '2023-08-22 04:41:05', '2023-08-22 04:41:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin@sherifshalaby.tech', NULL, '$2y$10$p81xROfFre5HBAeQvVMvnuSPpkgQwAOd38W3gs1cu4mN1J0xD1aCa', NULL, '2023-08-13 08:43:53', '2023-08-13 09:31:59'),
(2, 'Admin', 'admin@sherifshalaby.tech', NULL, '$2y$10$IG/3haPKMr0RU.2o1caJBO7drMxkBWER0qqZGt/d24P9/9AoFaPsG', NULL, '2023-08-13 08:43:53', '2023-08-13 08:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `wages`
--

CREATE TABLE `wages` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `other_payment` decimal(8,2) NOT NULL DEFAULT 0.00,
  `account_period` varchar(255) DEFAULT NULL,
  `acount_period_start_date` date DEFAULT NULL,
  `acount_period_end_date` date DEFAULT NULL,
  `deductibles` decimal(8,2) DEFAULT 0.00,
  `reasons_of_deductibles` text DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL,
  `net_amount` decimal(8,2) NOT NULL,
  `payment_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `date_of_creation` date NOT NULL,
  `status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wage_transactions`
--

CREATE TABLE `wage_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `employee_id` int(10) UNSIGNED DEFAULT NULL,
  `wage_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `grand_total` decimal(15,4) DEFAULT NULL,
  `final_total` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `status` enum('received','pending','ordered','final','draft','sent_admin','sent_supplier','partially_received','approved','rejected','expired','valid','declined','send_the_goods','compensated','canceled') NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `payment_status` enum('paid','pending','partial') DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wage_transaction_payments`
--

CREATE TABLE `wage_transaction_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(15,4) NOT NULL,
  `paid_on` varchar(255) NOT NULL,
  `is_return` tinyint(1) NOT NULL DEFAULT 0,
  `payment_for` bigint(20) UNSIGNED DEFAULT NULL,
  `source_type` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Other users in the system as source.',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `edited_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_stock_lines`
--
ALTER TABLE `add_stock_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `add_stock_lines_stock_transaction_id_foreign` (`stock_transaction_id`),
  ADD KEY `add_stock_lines_product_id_foreign` (`product_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_registers_store_id_foreign` (`store_id`),
  ADD KEY `cash_registers_store_pos_id_foreign` (`store_pos_id`),
  ADD KEY `cash_registers_user_id_foreign` (`user_id`);

--
-- Indexes for table `cash_register_transactions`
--
ALTER TABLE `cash_register_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_register_transactions_cash_register_id_foreign` (`cash_register_id`),
  ADD KEY `cash_register_transactions_source_id_foreign` (`source_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`),
  ADD KEY `categories_user_id_foreign` (`user_id`),
  ADD KEY `categories_last_update_foreign` (`last_update`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_name_unique` (`name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `colors_name_unique` (`name`),
  ADD KEY `colors_user_id_foreign` (`user_id`),
  ADD KEY `colors_last_update_foreign` (`last_update`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_updated_by_foreign` (`updated_by`),
  ADD KEY `customers_deleted_by_foreign` (`deleted_by`),
  ADD KEY `customers_customer_type_id_foreign` (`customer_type_id`);

--
-- Indexes for table `customer_balance_adjustments`
--
ALTER TABLE `customer_balance_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_balance_adjustments_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_balance_adjustments_store_id_foreign` (`store_id`);

--
-- Indexes for table `customer_important_dates`
--
ALTER TABLE `customer_important_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_important_dates_customer_id_foreign` (`customer_id`),
  ADD KEY `customer_important_dates_created_by_foreign` (`created_by`);

--
-- Indexes for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_types_created_by_foreign` (`created_by`),
  ADD KEY `customer_types_edited_by_foreign` (`edited_by`),
  ADD KEY `customer_types_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`),
  ADD KEY `employees_job_type_id_foreign` (`job_type_id`);

--
-- Indexes for table `employee_stores`
--
ALTER TABLE `employee_stores`
  ADD KEY `employee_stores_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_stores_store_id_foreign` (`store_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_user_id_foreign` (`user_id`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_last_update_foreign` (`last_update`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_product_id_foreign` (`product_id`),
  ADD KEY `invoice_items_category_id_foreign` (`category_id`);

--
-- Indexes for table `job_types`
--
ALTER TABLE `job_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_types_created_by_foreign` (`created_by`),
  ADD KEY `job_types_deleted_by_foreign` (`deleted_by`),
  ADD KEY `job_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_types_created_by_foreign` (`created_by`),
  ADD KEY `leave_types_deleted_by_foreign` (`deleted_by`),
  ADD KEY `leave_types_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `money_safes`
--
ALTER TABLE `money_safes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `money_safes_name_unique` (`name`),
  ADD KEY `money_safes_store_id_foreign` (`store_id`),
  ADD KEY `money_safes_currency_id_foreign` (`currency_id`),
  ADD KEY `money_safes_created_by_foreign` (`created_by`),
  ADD KEY `money_safes_edited_by_foreign` (`edited_by`),
  ADD KEY `money_safes_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `money_safe_transactions`
--
ALTER TABLE `money_safe_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `money_safe_transactions_money_safe_id_foreign` (`money_safe_id`),
  ADD KEY `money_safe_transactions_source_id_foreign` (`source_id`),
  ADD KEY `money_safe_transactions_store_id_foreign` (`store_id`),
  ADD KEY `money_safe_transactions_job_type_id_foreign` (`job_type_id`),
  ADD KEY `money_safe_transactions_currency_id_foreign` (`currency_id`),
  ADD KEY `money_safe_transactions_created_by_foreign` (`created_by`),
  ADD KEY `money_safe_transactions_edited_by_foreign` (`edited_by`),
  ADD KEY `money_safe_transactions_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `number_of_leaves`
--
ALTER TABLE `number_of_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `number_of_leaves_employee_id_foreign` (`employee_id`),
  ADD KEY `number_of_leaves_leave_type_id_foreign` (`leave_type_id`),
  ADD KEY `number_of_leaves_created_by_foreign` (`created_by`),
  ADD KEY `number_of_leaves_deleted_by_foreign` (`deleted_by`),
  ADD KEY `number_of_leaves_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_transaction_sell_lines`
--
ALTER TABLE `payment_transaction_sell_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_transaction_sell_lines_transaction_id_foreign` (`transaction_id`),
  ADD KEY `payment_transaction_sell_lines_paying_currency_foreign` (`paying_currency`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_created_by_foreign` (`created_by`),
  ADD KEY `products_edited_by_foreign` (`edited_by`),
  ADD KEY `products_deleted_by_foreign` (`deleted_by`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_stores`
--
ALTER TABLE `product_stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_stores_created_by_foreign` (`created_by`),
  ADD KEY `product_stores_deleted_by_foreign` (`deleted_by`),
  ADD KEY `product_stores_updated_by_foreign` (`updated_by`),
  ADD KEY `product_stores_product_id_foreign` (`product_id`),
  ADD KEY `product_stores_store_id_foreign` (`store_id`);

--
-- Indexes for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_subcategories_created_by_foreign` (`created_by`),
  ADD KEY `product_subcategories_deleted_by_foreign` (`deleted_by`),
  ADD KEY `product_subcategories_updated_by_foreign` (`updated_by`),
  ADD KEY `product_subcategories_product_id_foreign` (`product_id`),
  ADD KEY `product_subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sell_lines`
--
ALTER TABLE `sell_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sell_lines_transaction_id_foreign` (`transaction_id`),
  ADD KEY `sell_lines_product_id_foreign` (`product_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sizes_name_unique` (`name`),
  ADD KEY `sizes_user_id_foreign` (`user_id`),
  ADD KEY `sizes_last_update_foreign` (`last_update`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_store_id_foreign` (`store_id`),
  ADD KEY `stock_transactions_transaction_currency_foreign` (`transaction_currency`),
  ADD KEY `stock_transactions_supplier_id_foreign` (`supplier_id`),
  ADD KEY `stock_transactions_source_id_foreign` (`source_id`),
  ADD KEY `stock_transactions_canceled_by_foreign` (`canceled_by`),
  ADD KEY `stock_transactions_created_by_foreign` (`created_by`),
  ADD KEY `stock_transactions_updated_by_foreign` (`updated_by`),
  ADD KEY `stock_transactions_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `stock_transaction_payments`
--
ALTER TABLE `stock_transaction_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transaction_payments_stock_transaction_id_foreign` (`stock_transaction_id`),
  ADD KEY `stock_transaction_payments_paying_currency_foreign` (`paying_currency`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_pos`
--
ALTER TABLE `store_pos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_pos_store_id_foreign` (`store_id`),
  ADD KEY `store_pos_user_id_foreign` (`user_id`),
  ADD KEY `store_pos_created_by_foreign` (`created_by`),
  ADD KEY `store_pos_edited_by_foreign` (`edited_by`),
  ADD KEY `store_pos_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `systems`
--
ALTER TABLE `systems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `systems_created_by_foreign` (`created_by`),
  ADD KEY `systems_updated_by_foreign` (`updated_by`),
  ADD KEY `systems_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `transaction_sell_lines`
--
ALTER TABLE `transaction_sell_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_sell_lines_store_id_foreign` (`store_id`),
  ADD KEY `transaction_sell_lines_supplier_id_foreign` (`supplier_id`),
  ADD KEY `transaction_sell_lines_customer_id_foreign` (`customer_id`),
  ADD KEY `transaction_sell_lines_canceled_by_foreign` (`canceled_by`),
  ADD KEY `transaction_sell_lines_created_by_foreign` (`created_by`),
  ADD KEY `transaction_sell_lines_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`),
  ADD KEY `units_user_id_foreign` (`user_id`),
  ADD KEY `units_last_update_foreign` (`last_update`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wages`
--
ALTER TABLE `wages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wages_source_id_foreign` (`source_id`),
  ADD KEY `wages_created_by_foreign` (`created_by`),
  ADD KEY `wages_edited_by_foreign` (`edited_by`),
  ADD KEY `wages_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `wage_transactions`
--
ALTER TABLE `wage_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wage_transactions_store_id_foreign` (`store_id`),
  ADD KEY `wage_transactions_employee_id_foreign` (`employee_id`),
  ADD KEY `wage_transactions_wage_id_foreign` (`wage_id`),
  ADD KEY `wage_transactions_source_id_foreign` (`source_id`),
  ADD KEY `wage_transactions_created_by_foreign` (`created_by`),
  ADD KEY `wage_transactions_edited_by_foreign` (`edited_by`),
  ADD KEY `wage_transactions_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `wage_transaction_payments`
--
ALTER TABLE `wage_transaction_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wage_transaction_payments_transaction_id_foreign` (`transaction_id`),
  ADD KEY `wage_transaction_payments_created_by_foreign` (`created_by`),
  ADD KEY `wage_transaction_payments_edited_by_foreign` (`edited_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_stock_lines`
--
ALTER TABLE `add_stock_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_register_transactions`
--
ALTER TABLE `cash_register_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_balance_adjustments`
--
ALTER TABLE `customer_balance_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_important_dates`
--
ALTER TABLE `customer_important_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_types`
--
ALTER TABLE `customer_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_types`
--
ALTER TABLE `job_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `money_safes`
--
ALTER TABLE `money_safes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_safe_transactions`
--
ALTER TABLE `money_safe_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `number_of_leaves`
--
ALTER TABLE `number_of_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_transaction_sell_lines`
--
ALTER TABLE `payment_transaction_sell_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_stores`
--
ALTER TABLE `product_stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_lines`
--
ALTER TABLE `sell_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_transaction_payments`
--
ALTER TABLE `stock_transaction_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store_pos`
--
ALTER TABLE `store_pos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `systems`
--
ALTER TABLE `systems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transaction_sell_lines`
--
ALTER TABLE `transaction_sell_lines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wages`
--
ALTER TABLE `wages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wage_transactions`
--
ALTER TABLE `wage_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wage_transaction_payments`
--
ALTER TABLE `wage_transaction_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_stock_lines`
--
ALTER TABLE `add_stock_lines`
  ADD CONSTRAINT `add_stock_lines_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `add_stock_lines_stock_transaction_id_foreign` FOREIGN KEY (`stock_transaction_id`) REFERENCES `stock_transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD CONSTRAINT `cash_registers_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_registers_store_pos_id_foreign` FOREIGN KEY (`store_pos_id`) REFERENCES `store_pos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_registers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cash_register_transactions`
--
ALTER TABLE `cash_register_transactions`
  ADD CONSTRAINT `cash_register_transactions_cash_register_id_foreign` FOREIGN KEY (`cash_register_id`) REFERENCES `cash_registers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cash_register_transactions_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_last_update_foreign` FOREIGN KEY (`last_update`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `colors`
--
ALTER TABLE `colors`
  ADD CONSTRAINT `colors_last_update_foreign` FOREIGN KEY (`last_update`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `colors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_customer_type_id_foreign` FOREIGN KEY (`customer_type_id`) REFERENCES `customer_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_balance_adjustments`
--
ALTER TABLE `customer_balance_adjustments`
  ADD CONSTRAINT `customer_balance_adjustments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_balance_adjustments_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_important_dates`
--
ALTER TABLE `customer_important_dates`
  ADD CONSTRAINT `customer_important_dates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_important_dates_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD CONSTRAINT `customer_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_types_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_job_type_id_foreign` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_stores`
--
ALTER TABLE `employee_stores`
  ADD CONSTRAINT `employee_stores_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_stores_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `invoices_last_update_foreign` FOREIGN KEY (`last_update`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_types`
--
ALTER TABLE `job_types`
  ADD CONSTRAINT `job_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `job_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `job_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD CONSTRAINT `leave_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leave_types_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leave_types_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `money_safes`
--
ALTER TABLE `money_safes`
  ADD CONSTRAINT `money_safes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safes_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safes_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safes_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safes_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `money_safe_transactions`
--
ALTER TABLE `money_safe_transactions`
  ADD CONSTRAINT `money_safe_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_job_type_id_foreign` FOREIGN KEY (`job_type_id`) REFERENCES `job_types` (`id`),
  ADD CONSTRAINT `money_safe_transactions_money_safe_id_foreign` FOREIGN KEY (`money_safe_id`) REFERENCES `money_safes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `money_safe_transactions_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `number_of_leaves`
--
ALTER TABLE `number_of_leaves`
  ADD CONSTRAINT `number_of_leaves_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `number_of_leaves_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `number_of_leaves_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `number_of_leaves_leave_type_id_foreign` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`),
  ADD CONSTRAINT `number_of_leaves_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_transaction_sell_lines`
--
ALTER TABLE `payment_transaction_sell_lines`
  ADD CONSTRAINT `payment_transaction_sell_lines_paying_currency_foreign` FOREIGN KEY (`paying_currency`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_transaction_sell_lines_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_sell_lines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_stores`
--
ALTER TABLE `product_stores`
  ADD CONSTRAINT `product_stores_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stores_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_stores_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_stores_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_stores_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD CONSTRAINT `product_subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_subcategories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_subcategories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_subcategories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_subcategories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sell_lines`
--
ALTER TABLE `sell_lines`
  ADD CONSTRAINT `sell_lines_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sell_lines_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transaction_sell_lines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sizes`
--
ALTER TABLE `sizes`
  ADD CONSTRAINT `sizes_last_update_foreign` FOREIGN KEY (`last_update`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sizes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_canceled_by_foreign` FOREIGN KEY (`canceled_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_transaction_currency_foreign` FOREIGN KEY (`transaction_currency`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_transaction_payments`
--
ALTER TABLE `stock_transaction_payments`
  ADD CONSTRAINT `stock_transaction_payments_paying_currency_foreign` FOREIGN KEY (`paying_currency`) REFERENCES `currencies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transaction_payments_stock_transaction_id_foreign` FOREIGN KEY (`stock_transaction_id`) REFERENCES `stock_transactions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `store_pos`
--
ALTER TABLE `store_pos`
  ADD CONSTRAINT `store_pos_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `store_pos_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `store_pos_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `store_pos_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `store_pos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `systems`
--
ALTER TABLE `systems`
  ADD CONSTRAINT `systems_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `systems_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `systems_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_sell_lines`
--
ALTER TABLE `transaction_sell_lines`
  ADD CONSTRAINT `transaction_sell_lines_canceled_by_foreign` FOREIGN KEY (`canceled_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_sell_lines_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_sell_lines_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_sell_lines_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_sell_lines_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_sell_lines_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_last_update_foreign` FOREIGN KEY (`last_update`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `units_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wages`
--
ALTER TABLE `wages`
  ADD CONSTRAINT `wages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wages_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wages_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wages_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wage_transactions`
--
ALTER TABLE `wage_transactions`
  ADD CONSTRAINT `wage_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transactions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transactions_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transactions_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `wage_transactions_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transactions_store_id_foreign` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`),
  ADD CONSTRAINT `wage_transactions_wage_id_foreign` FOREIGN KEY (`wage_id`) REFERENCES `wages` (`id`);

--
-- Constraints for table `wage_transaction_payments`
--
ALTER TABLE `wage_transaction_payments`
  ADD CONSTRAINT `wage_transaction_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transaction_payments_edited_by_foreign` FOREIGN KEY (`edited_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wage_transaction_payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `wage_transactions` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
