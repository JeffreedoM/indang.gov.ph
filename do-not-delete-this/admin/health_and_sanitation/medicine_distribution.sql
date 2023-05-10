-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230412.45c7d30093
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 06:21 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

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
-- Table structure for table `medicine_distribution`
--

CREATE TABLE `medicine_distribution` (
  `distrib_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `distrib_quantity` int(11) NOT NULL,
  `distrib_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine_distribution`
--

INSERT INTO `medicine_distribution` (`distrib_id`, `medicine_id`, `resident_id`, `distrib_quantity`, `distrib_date`) VALUES
(26, 100, 46, -15, '2023-04-22'),
(27, 101, 45, 20, '2023-04-19'),
(28, 102, 46, 41, '2023-04-19'),
(29, 103, 46, 18, '2023-04-27'),
(30, 103, 47, 33, '2023-04-28'),
(31, 104, 46, 10, '2023-04-28'),
(34, 101, 47, 20, '2023-04-24'),
(35, 104, 47, 5, '2023-04-25'),
(36, 100, 47, 2, '2023-04-25'),
(37, 100, 45, 5, '2023-04-24'),
(38, 103, 47, 4, '2023-04-26'),
(39, 103, 47, 1, '2023-04-21'),
(40, 107, 47, 5, '2023-04-23'),
(41, 102, 47, 9, '2023-04-24'),
(42, 106, 47, 5, '2023-05-06'),
(43, 109, 45, 5, '2023-04-14'),
(44, 102, 45, 10, '2023-04-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  ADD PRIMARY KEY (`distrib_id`),
  ADD KEY `medicine_id` (`medicine_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  ADD CONSTRAINT `medicine_distribution_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicine_inventory` (`ID`),
  ADD CONSTRAINT `medicine_distribution_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
