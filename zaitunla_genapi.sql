-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 23, 2019 at 03:52 PM
-- Server version: 10.0.38-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaitunla_genapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `APIKeys`
--

CREATE TABLE `APIKeys` (
  `id` int(11) NOT NULL,
  `api` varchar(100) NOT NULL,
  `appid` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Apps`
--

CREATE TABLE `Apps` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `packagename` varchar(200) NOT NULL,
  `platform` varchar(10) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `newest_version_code` int(11) NOT NULL DEFAULT '1',
  `download_title` varchar(50) NOT NULL DEFAULT 'Need Update',
  `download_message` varchar(100) NOT NULL DEFAULT 'There is new version of this application, please update it',
  `download_detail` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `FCMs`
--

CREATE TABLE `FCMs` (
  `id` bigint(20) NOT NULL,
  `fcmid` varchar(250) NOT NULL,
  `appid` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `screensize` varchar(30) DEFAULT NULL,
  `model` varchar(200) DEFAULT NULL,
  `meid` varchar(100) DEFAULT NULL,
  `packagename` varchar(150) DEFAULT NULL,
  `versionname` varchar(50) DEFAULT NULL,
  `versioncode` varchar(20) DEFAULT NULL,
  `lang` varchar(20) DEFAULT NULL,
  `platform` varchar(10) NOT NULL DEFAULT 'android',
  `os` varchar(30) DEFAULT NULL,
  `deviceid` varchar(50) DEFAULT NULL,
  `useragent` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `APIKeys`
--
ALTER TABLE `APIKeys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Apps`
--
ALTER TABLE `Apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `FCMs`
--
ALTER TABLE `FCMs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app` (`appid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APIKeys`
--
ALTER TABLE `APIKeys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Apps`
--
ALTER TABLE `Apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `FCMs`
--
ALTER TABLE `FCMs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
