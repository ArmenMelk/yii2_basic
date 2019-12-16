-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 16, 2019 at 11:35 AM
-- Server version: 10.3.13-MariaDB
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yii2basic`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE `application` (
  `application_id` int(10) UNSIGNED NOT NULL,
  `application_type_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `start_date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `status` enum('open','in progress','closed','rejected','approved') NOT NULL,
  `description` text NOT NULL,
  `hr_comment` text DEFAULT NULL,
  `manager_comment` text DEFAULT NULL,
  `account_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`application_id`, `application_type_id`, `start_date`, `last_update`, `status`, `description`, `hr_comment`, `manager_comment`, `account_id`) VALUES
(3, 1, '2019-12-16 11:33:05', '2019-12-16 12:34:22', 'closed', 'dfdfgfhf', '', '', 4),
(4, 1, '2019-12-16 11:33:17', '2019-12-16 12:35:06', 'closed', 'gjmghklhjkl.jkl', '', '', 6);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(10) NOT NULL,
  `short_name` varchar(64) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `short_name`, `description`) VALUES
(1, 'Head', 'Main office for'),
(2, 'IT and Engineering', 'IT and Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_recid` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `mentor_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `position` varchar(64) NOT NULL,
  `salary` float UNSIGNED NOT NULL,
  `phone_number` varchar(32) NOT NULL,
  `user_role_id` int(10) UNSIGNED NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_recid`, `first_name`, `last_name`, `email`, `password`, `mentor_id`, `department_id`, `position`, `salary`, `phone_number`, `user_role_id`, `start_date`, `end_date`) VALUES
(1, 'Poghos', 'Poghosyan', 'poghos.poghosyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 'Manager', 5000000, '555555555', 1, '2019-12-15 00:00:00', '2019-12-15 00:00:00'),
(2, 'Petros', 'Petrosyan', 'petros.petrosyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 1, 'Hr Specialist', 500000, '555444333', 2, '2019-12-15 00:00:00', '2019-12-15 00:00:00'),
(3, 'Karen', 'Karenyan', 'karen.karenyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 2, 'Head of IT and Engineering ', 1500000, '66655444', 3, '2019-12-15 00:00:00', '2019-12-15 00:00:00'),
(4, 'Aram', 'aramyan', 'aram.Aramyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, 'Senior Programmer', 1000000, '123456789', 4, '2019-12-15 00:00:00', '2019-12-15 00:00:00'),
(5, 'Anush', 'Anushyan', 'Anush.Anushyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, 'Programmer', 800000, '123456733', 5, '2019-12-15 00:00:00', '2019-12-15 00:00:00'),
(6, 'Syuzi', 'Syuzikyan', 'syuzi.syuzikyan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 2, 'Programmer', 800000, '123456744', 5, '2019-12-15 00:00:00', '2019-12-15 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_recid`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `application_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_recid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
