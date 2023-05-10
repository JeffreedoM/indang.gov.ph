-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20230412.45c7d30093
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2023 at 06:20 AM
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
-- Table structure for table `medicine_inventory`
--

CREATE TABLE `medicine_inventory` (
  `ID` int(11) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `medicine_availability` varchar(100) NOT NULL,
  `medicine_quantity` int(11) NOT NULL,
  `medicine_expiration` date NOT NULL,
  `medicine_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine_inventory`
--

INSERT INTO `medicine_inventory` (`ID`, `medicine_name`, `medicine_availability`, `medicine_quantity`, `medicine_expiration`, `medicine_description`) VALUES
(100, 'Paracetamol', 'Available', 30, '2023-04-21', 'For flu'),
(101, 'Bioflu', 'Available', 25, '2023-04-28', 'For flu'),
(102, 'Neozep', 'Out of Stock', 0, '2023-04-24', 'For colds'),
(103, 'Medicol', 'Available', 10, '2023-04-17', 'For sakit ng ulo'),
(104, 'Medicol', 'Available', 35, '2023-04-24', 'For sakit ng ulo'),
(105, 'Anti-Histamine', 'Available', 20, '2023-04-25', 'For allergy'),
(106, 'Cetirizine', 'Out of Stock', 0, '2023-04-30', 'Allergy'),
(107, 'Diatabs', 'Available', 5, '2023-04-13', 'Pagtatae'),
(108, 'Paracetamol', 'Available', 9, '2023-05-02', 'For flu'),
(109, 'Biogesic', 'Available', 95, '2024-04-14', 'For flu');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
