-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2019 at 05:08 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khocard`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance_history`
--

CREATE TABLE `balance_history` (
  `blh_id` int(11) NOT NULL,
  `blh_user_id` int(11) NOT NULL,
  `blh_user_name` varchar(255) NOT NULL,
  `blh_before_bal` int(11) NOT NULL COMMENT 'số dư trước',
  `blh_after_bal` int(11) NOT NULL COMMENT 'số dư sau',
  `blh_amount` int(11) NOT NULL COMMENT 'số tiền',
  `blh_type` int(11) NOT NULL COMMENT 'loại giao dịch',
  `blh_user_sent_id` int(11) NOT NULL COMMENT 'user thực hiện ( admin hoặc người chuyển tiền )',
  `blh_user_sent_name` varchar(255) NOT NULL,
  `blh_trans_id` int(11) NOT NULL COMMENT 'mã giao dịch',
  `blh_message` varchar(255) NOT NULL,
  `blh_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ngày tạo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL COMMENT 'tài khoản nạp',
  `amount` double NOT NULL COMMENT 'tổng tiền',
  `order_type` int(11) NOT NULL COMMENT 'loại đơn hàng',
  `priority` int(11) NOT NULL DEFAULT '0' COMMENT 'ưu tiên : 0 : ko ưu tiên, 1: có ưu tiên',
  `service_type` int(11) NOT NULL COMMENT 'loại nạp hộ',
  `join_card` int(11) NOT NULL COMMENT 'ghép thẻ',
  `price_min` int(11) NOT NULL COMMENT 'mệnh giá nhỏ nhất nhận (0 :no, 1 :yes)',
  `note` varchar(255) NOT NULL COMMENT 'ghi chú',
  `bef_balance` double NOT NULL COMMENT 'số dư trước',
  `af_balance` double NOT NULL COMMENT 'số dư sau',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'thời gian tạo',
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'thời gian cập nhật',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'trạng thái đơn hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` tinyint(4) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `isadmin` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `balance` double NOT NULL,
  `reset` int(11) NOT NULL COMMENT 'đã đổi pass hay chưa? 0; chưa, 1 rồi'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `avatar`, `username`, `password`, `email`, `fullname`, `phone`, `birthday`, `isadmin`, `active`, `balance`, `reset`) VALUES
(1, '', 'tiennh', '224cf2b695a5e8ecaecfb9015161fa4b', NULL, NULL, NULL, NULL, 0, 1, 100000, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance_history`
--
ALTER TABLE `balance_history`
  ADD PRIMARY KEY (`blh_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance_history`
--
ALTER TABLE `balance_history`
  MODIFY `blh_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
