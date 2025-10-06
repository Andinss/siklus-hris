-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2018 at 10:01 AM
-- Server version: 5.6.37
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `document-monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_category_id` int(10) DEFAULT NULL,
  `item_brand_id` int(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `item_code`, `item_name`, `item_category_id`, `item_brand_id`, `image`, `description`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '000000000001100001', '2PH CIT LOW SEED MURCOTT CLS1 100 CTN', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '000000000001100002', '2PH CIT LOW SEED MURCOTT CLS1 110 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '000000000001100003', '2PH CIT LOW SEED MURCOTT CLS1 56 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '000000000001100004', '2PH CIT LOW SEED MURCOTT CLS1 64 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '000000000001100005', '2PH CIT LOW SEED MURCOTT CLS1 72 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '000000000001100006', '2PH CIT LOW SEED MURCOTT CLS1 80 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '000000000001100007', '2PH CIT LOW SEED MURCOTT CLS1 90 CTN ', 58, 57, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '000000000001100008', '2PH CITRUS AFOURER 113 CTN ', 64, 63, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '000000000001100009', '2PH CITRUS AFOURER 125 CTN ', 64, 63, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '000000000001100010', '2PH CITRUS AFOURER 144 CTN ', 64, 63, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '234', '2PH CIT LOW SEED MURCOTT CLS1 64 CTN d', 6, 7, NULL, 'sffd', 0, 1, NULL, NULL, '2018-10-23 02:54:25', '2018-10-23 02:54:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_brand_id` (`item_brand_id`),
  ADD KEY `item_category_id` (`item_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`item_brand_id`) REFERENCES `item_brand` (`id`),
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`item_category_id`) REFERENCES `item_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
