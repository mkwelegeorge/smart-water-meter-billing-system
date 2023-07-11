-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2022 at 11:18 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing_list`
--

CREATE TABLE `billing_list` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `reading_date` date NOT NULL,
  `due_date` date NOT NULL,
  `reading` float(12,2) NOT NULL DEFAULT 0.00,
  `previous` float(12,2) NOT NULL DEFAULT 0.00,
  `rate` float(12,2) NOT NULL DEFAULT 0.00,
  `total` float(12,2) NOT NULL DEFAULT 0.00,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0= pending,\r\n1= paid',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billing_list`
--

INSERT INTO `billing_list` (`id`, `client_id`, `reading_date`, `due_date`, `reading`, `previous`, `rate`, `total`, `status`, `date_created`, `date_updated`) VALUES
(4, 4, '2022-06-10', '2022-06-11', 100.00, 90.00, 1650.00, 16500.00, 1, '2022-06-11 19:51:58', '2022-06-11 19:54:26'),
(5, 5, '2022-06-12', '2022-06-13', 12.00, 0.00, 1650.00, 19800.00, 0, '2022-06-12 18:48:09', '2022-06-12 18:48:09');

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Residential', 1, 0, '2022-05-02 15:13:02', '2022-05-02 15:13:02'),
(2, 'Commercial', 1, 0, '2022-05-02 15:13:09', '2022-05-02 15:13:09'),
(3, 'school', 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'shule', 1, 0, '2022-05-31 17:21:50', '2022-05-31 17:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `category_id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `meter_code` varchar(100) NOT NULL,
  `first_reading` float(12,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `code`, `category_id`, `firstname`, `middlename`, `lastname`, `contact`, `address`, `meter_code`, `first_reading`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, '202205020001', 1, 'Mark', 'D', 'Cooper', '09123456789', 'Sample Address', '123456', 1001.00, 2, 1, '2022-05-02 15:13:35', '2022-06-02 20:48:16'),
(2, '202205250001', 2, 'George', '', 'mkwele', '0745896071', 'dar', '122221', 0.00, 1, 1, '2022-05-25 16:42:30', '2022-06-02 20:48:12'),
(3, '202205310001', 1, 'Najma', '', 'George', '0745896071', 'Bibi Titi Mohamed\r\n', '1234', 0.00, 1, 1, '2022-05-31 17:24:04', '2022-06-02 20:48:08'),
(4, '202206030001', 2, 'g', '', 'g', 'gg', 'g', '123', 90.00, 1, 0, '2022-06-02 20:52:49', '2022-06-02 20:54:19'),
(5, '202206120001', 1, 'ISDORA', 'W', 'MANGA', '0742249502', 'ILALA DAR ES SALAAM 2958', 'MT01', 0.00, 1, 0, '2022-06-12 18:45:42', '2022-06-12 18:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `type_role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `type_role`) VALUES
(1, 'administrator'),
(2, 'staff'),
(3, 'client');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Smart Water Billing System'),
(6, 'short_name', 'SMBS'),
(11, 'logo', 'uploads/logo.png?v=1651282049'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover.png?v=1654186798'),
(15, 'rate', '1650 TZS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'George', 'J', 'Mkwele', 'mkwelegeorge13@gmail.com', '7876e901a8508af89b6148e694f110b5', 'uploads/avatars/1.png?v=1653731297', NULL, 1, '2021-01-20 14:02:37', '2022-05-28 12:49:49'),
(6, 'Dora', '', 'George', 'dora', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 3, '2022-05-29 17:38:30', '2022-06-11 19:49:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing_list`
--
ALTER TABLE `billing_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`),
  ADD UNIQUE KEY `role_id` (`type`),
  ADD KEY `role_id_2` (`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing_list`
--
ALTER TABLE `billing_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing_list`
--
ALTER TABLE `billing_list`
  ADD CONSTRAINT `client_id_fk_bl` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `client_list`
--
ALTER TABLE `client_list`
  ADD CONSTRAINT `category_id_fk_cl` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
