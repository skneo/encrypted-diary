-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2022 at 04:44 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notebookdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `enjoyers`
--

CREATE TABLE `enjoyers` (
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `logKey` varchar(256) NOT NULL,
  `pwdChangeOn` datetime NOT NULL,
  `logKeyChangedOn` datetime NOT NULL DEFAULT current_timestamp(),
  `last_login` datetime NOT NULL,
  `login_ip` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enjoyers`
--

INSERT INTO `enjoyers` (`username`, `password`, `logKey`, `pwdChangeOn`, `logKeyChangedOn`, `last_login`, `login_ip`) VALUES
('user', '$2y$10$Owch5m.Yff/g65baM3mOVeV1K/hZaJUGFfI4aP9T3o.d1iAfUO0l2', '$2y$10$dP.rQZ2Wr8/yYjjK8Sqa.uqdgAHSObuhwp2CKFeDvnLU4Tg4wlLxW', '2022-09-01 08:12:40', '2022-09-01 08:10:05', '2022-09-01 08:12:48', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `mylogs`
--

CREATE TABLE `mylogs` (
  `id` int(11) NOT NULL,
  `subject` varchar(512) NOT NULL,
  `logBody` mediumtext NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enjoyers`
--
ALTER TABLE `enjoyers`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `mylogs`
--
ALTER TABLE `mylogs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mylogs`
--
ALTER TABLE `mylogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
