-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2023 at 04:22 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bmis`
--

-- --------------------------------------------------------

--
-- Table structure for table `report_certificate`
--

CREATE TABLE `report_certificate` (
  `cert_id` int(11) NOT NULL,
  `cert_name` varchar(255) NOT NULL,
  `cert_month` varchar(255) NOT NULL,
  `cert_year` year(4) NOT NULL,
  `cert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_certificate`
--

INSERT INTO `report_certificate` (`cert_id`, `cert_name`, `cert_month`, `cert_year`, `cert_date`) VALUES
(1, 'Certificate Of Validation', 'January', 2020, '2023-04-21 11:51:49'),
(2, 'Certificate Of Validation', 'January', 2020, '2023-04-21 11:53:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report_certificate`
--
ALTER TABLE `report_certificate`
  ADD PRIMARY KEY (`cert_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report_certificate`
--
ALTER TABLE `report_certificate`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
