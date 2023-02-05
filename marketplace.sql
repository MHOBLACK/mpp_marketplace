-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2023 at 10:41 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `market_list`
--

CREATE TABLE `market_list` (
  `market_id` int(11) NOT NULL,
  `market_img` text NOT NULL,
  `market_name` text NOT NULL,
  `market_content` mediumtext NOT NULL,
  `market_contact` text NOT NULL,
  `owner` text NOT NULL,
  `market_point` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `market_list`
--

INSERT INTO `market_list` (`market_id`, `market_img`, `market_name`, `market_content`, `market_contact`, `owner`, `market_point`) VALUES
(7, 'img/upload/market_list/หน้าร้านอาหารตามสั่ง.jpg', 'ร้านอาหารตามสั่ง', 'ร้านอาหารตามสั่งสุดเจ๋ง สั่งได้ทุกอย่างเลย', ' 097-032-4066', 'chatchai', 10);

-- --------------------------------------------------------

--
-- Table structure for table `rating_market`
--

CREATE TABLE `rating_market` (
  `id` int(11) NOT NULL,
  `market_id` int(11) NOT NULL,
  `market_name` text NOT NULL,
  `rate` int(11) NOT NULL,
  `voter` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rating_market`
--

INSERT INTO `rating_market` (`id`, `market_id`, `market_name`, `rate`, `voter`) VALUES
(33, 7, 'ร้านอาหารตามสั่ง', 5, 'pitiphat'),
(34, 7, 'ร้านอาหารตามสั่ง', 5, 'sasikan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '16615', 'admin'),
(2, 'chatchai', '1234', 'member'),
(3, 'sasikan', '1234', 'member'),
(4, 'pitiphat', '1234', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `ร้านอาหารตามสั่ง`
--

CREATE TABLE `ร้านอาหารตามสั่ง` (
  `item_id` int(11) NOT NULL,
  `item_img` text NOT NULL,
  `item_name` text NOT NULL,
  `item_content` mediumtext NOT NULL,
  `item_price` int(11) NOT NULL,
  `item_category` text NOT NULL,
  `item_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ร้านอาหารตามสั่ง`
--

INSERT INTO `ร้านอาหารตามสั่ง` (`item_id`, `item_img`, `item_name`, `item_content`, `item_price`, `item_category`, `item_type`) VALUES
(3, 'img/upload/item_list/ข้าวผัดกุ้ง.jpg', 'ข้าวผัดกุ้ง', 'อร่อยมากต้องลอง', 25, 'อาหารคาว', 'ผัด'),
(4, 'img/upload/item_list/ข้าวไข่เจียว.jpg', 'ข้าวไข่เจียว', 'เอาไข่มาทอดมาทิ้ง', 25, 'อาหารคาว', 'ทอด / เผา / ย่าง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `market_list`
--
ALTER TABLE `market_list`
  ADD PRIMARY KEY (`market_id`);

--
-- Indexes for table `rating_market`
--
ALTER TABLE `rating_market`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ร้านอาหารตามสั่ง`
--
ALTER TABLE `ร้านอาหารตามสั่ง`
  ADD PRIMARY KEY (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `market_list`
--
ALTER TABLE `market_list`
  MODIFY `market_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rating_market`
--
ALTER TABLE `rating_market`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ร้านอาหารตามสั่ง`
--
ALTER TABLE `ร้านอาหารตามสั่ง`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
