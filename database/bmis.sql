-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2023 at 05:38 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.33

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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `official_id` int(11) NOT NULL,
  `allowed_modules` varchar(255) NOT NULL DEFAULT '[]',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `official_id`, `allowed_modules`, `username`, `password`) VALUES
(1, 1, '[]', 'jeep123', '$2y$10$Za5fh8r6uyZ6vTJhrhtOWugVCQN46M6ODKlz.IPOLGQknxvBTg892'),
(72, 47, '[\"resident\"]', 'ed123', '$2y$10$vUlP7UYOC92fo50gS3tXtuEP/AjlZhxvgbXeqhZNliHCOOIL3ynNu'),
(75, 49, '[]', 'john123', '$2y$10$DrcDLXtLKQrvx.xH1gVMA.Ii7wxTx9j3BLncNm2rdp9SLlBMYOLbW');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `brgy_id` int(11) NOT NULL,
  `announcement_photo` varchar(100) NOT NULL,
  `announcement_title` varchar(255) NOT NULL,
  `announcement_message` text NOT NULL,
  `announcement_what` varchar(255) DEFAULT NULL,
  `announcement_where` varchar(255) DEFAULT NULL,
  `announcement_when` date DEFAULT NULL,
  `is_highlighted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `brgy_id`, `announcement_photo`, `announcement_title`, `announcement_message`, `announcement_what`, `announcement_where`, `announcement_when`, `is_highlighted`, `created_at`) VALUES
(41, 410, '64b4f2f1bccd27.70035555.jpg', 'Captain Vs. Tanod Suntukan', 'Punta kayo dito, suntukan to guys!!!', 'Boxing Match', '2C Covered Court', '2023-07-21', 1, '2023-07-17 15:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(50) NOT NULL,
  `b_address` varchar(100) NOT NULL,
  `b_logo` varchar(100) NOT NULL,
  `b_link` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`b_id`, `b_name`, `b_address`, `b_logo`, `b_link`, `is_active`) VALUES
(410, 'Do Not Delete This', '123 Jeepney Indang, Cavite', '64b4ebd3d0dbc0.68962113.jpg', 'indang.gov.ph/do-not-delete-this', 1),
(454, 'Barangay', '123 Barangay Indang, Cavite', '64b567b88d2f54.99548962.png', 'indang.gov.ph/barangay', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangay_configuration`
--

CREATE TABLE `barangay_configuration` (
  `id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `mission` text NOT NULL,
  `vision` text NOT NULL,
  `objectives` text NOT NULL,
  `history` text NOT NULL,
  `contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barangay_configuration`
--

INSERT INTO `barangay_configuration` (`id`, `barangay_id`, `mission`, `vision`, `objectives`, `history`, `contact`) VALUES
(1, 410, 'Sample Mission', 'Sample Vision', 'Sample Objectives', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n\r\nWhere does it come from?\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', ''),
(28, 454, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `clearance`
--

CREATE TABLE `clearance` (
  `clearance_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `clearance_name` varchar(100) NOT NULL,
  `clearance_amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_release`
--

CREATE TABLE `clearance_release` (
  `release_id` int(11) NOT NULL,
  `clearance_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `purpose` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_total`
--

CREATE TABLE `clearance_total` (
  `distrib_id` int(11) NOT NULL,
  `clearance_id` int(11) NOT NULL,
  `distrib_quantity` int(11) NOT NULL,
  `distrib_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `death_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `death_date` date NOT NULL,
  `death_cause` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `death`
--

INSERT INTO `death` (`death_id`, `resident_id`, `death_date`, `death_cause`) VALUES
(1, 100, '2023-07-20', 'Cardiac Arrest'),
(2, 1016, '2023-07-20', 'Pinatay ni Jeep'),
(3, 1003, '2023-07-20', 'Pinatay din ni Jeep'),
(4, 203, '2023-07-20', 'Confidential');

-- --------------------------------------------------------

--
-- Table structure for table `hns_newborn`
--

CREATE TABLE `hns_newborn` (
  `newborn_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hns_newborn`
--

INSERT INTO `hns_newborn` (`newborn_id`, `resident_id`) VALUES
(24, 1020);

-- --------------------------------------------------------

--
-- Table structure for table `incident_complainant`
--

CREATE TABLE `incident_complainant` (
  `complainant_id` int(11) NOT NULL,
  `complainant_type` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `non_resident_id` int(11) DEFAULT NULL,
  `incident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_complainant`
--

INSERT INTO `incident_complainant` (`complainant_id`, `complainant_type`, `resident_id`, `non_resident_id`, `incident_id`) VALUES
(115, 'not resident', NULL, 88, 81);

-- --------------------------------------------------------

--
-- Table structure for table `incident_offender`
--

CREATE TABLE `incident_offender` (
  `offender_id` int(11) NOT NULL,
  `offender_type` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `incident_id` int(11) NOT NULL,
  `non_resident_id` int(11) DEFAULT NULL,
  `desc` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_offender`
--

INSERT INTO `incident_offender` (`offender_id`, `offender_type`, `resident_id`, `incident_id`, `non_resident_id`, `desc`) VALUES
(99, 'not resident', NULL, 81, 89, 'nag-away');

-- --------------------------------------------------------

--
-- Table structure for table `incident_table`
--

CREATE TABLE `incident_table` (
  `incident_id` int(11) NOT NULL,
  `incident_title` varchar(250) NOT NULL,
  `case_incident` varchar(250) NOT NULL,
  `date_incident` date NOT NULL,
  `time_incident` time NOT NULL,
  `location` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL COMMENT '1 - Mediated,\r\n2 - Dismiss,\r\n3 - Certified 4a',
  `narrative` mediumtext NOT NULL,
  `blotterType_id` int(11) NOT NULL,
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_table`
--

INSERT INTO `incident_table` (`incident_id`, `incident_title`, `case_incident`, `date_incident`, `time_incident`, `location`, `status`, `narrative`, `blotterType_id`, `date_reported`, `barangay_id`) VALUES
(9, 'Dahil sa pagibig222', '0', '2023-05-11', '14:26:00', '222222', '1', '222222', 1, '2023-05-11 06:26:17', 0),
(10, 'Dahil sa pagibig222', '0', '2023-05-11', '14:26:00', '222222', '1', '222222', 1, '2023-05-11 06:26:21', 0),
(11, 'Dahil sa pagibig222', '0', '2023-05-11', '14:26:00', '222222', '1', '222222', 1, '2023-05-11 06:31:36', 0),
(81, 'nanghampas', 'criminal', '2023-07-11', '20:51:00', 'Imus', '3', '[\"<p>Nasa concert silang magkapatid, tapos hinampas ni Jason si Joshua Ponciano<\\/p>\\r\\n\",\"<p>123213<\\/p>\\r\\n\"]', 2, '2023-07-16 11:11:25', 410);

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

-- --------------------------------------------------------

--
-- Table structure for table `medicine_inventory`
--

CREATE TABLE `medicine_inventory` (
  `ID` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `medicine_availability` varchar(100) NOT NULL,
  `medicine_quantity` int(11) NOT NULL,
  `medicine_expiration` date NOT NULL,
  `medicine_description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `medicine_inventory`
--

INSERT INTO `medicine_inventory` (`ID`, `barangay_id`, `medicine_name`, `medicine_availability`, `medicine_quantity`, `medicine_expiration`, `medicine_description`) VALUES
(100, 410, 'Paracetamol', 'Available', 28, '2023-04-21', 'For flu'),
(101, 410, 'Bioflu', 'Available', 25, '2023-04-28', 'For flu'),
(102, 410, 'Neozep', 'Available', 10, '2023-04-24', 'For colds'),
(103, 410, 'Medicol', 'Available', 10, '2023-04-17', 'For sakit ng ulo'),
(104, 410, 'Medicol', 'Available', 35, '2023-04-24', 'For sakit ng ulo'),
(106, 410, 'Cetirizine', 'Out of Stock', 0, '2023-04-30', 'Allergy'),
(111, 410, 'Biogesic', 'Available', 1, '2023-06-28', 'jeep');

-- --------------------------------------------------------

--
-- Table structure for table `new_clearance`
--

CREATE TABLE `new_clearance` (
  `finance_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `form_request` varchar(250) NOT NULL,
  `amount` int(11) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `finance_date` date DEFAULT NULL,
  `date_string` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_clearance`
--

INSERT INTO `new_clearance` (`finance_id`, `resident_id`, `barangay_id`, `form_request`, `amount`, `purpose`, `finance_date`, `date_string`, `status`) VALUES
(17, 20, 410, 'Barangay Business Clearance', 120, 'Work', '2023-06-08', 'June 8, 2023 9:46 AM', 'Pending'),
(20, 20, 410, 'Barangay Business Clearance', 100, 'wala lang', '2023-06-27', 'June 27, 2023 9:42 AM', 'Paid'),
(21, 20, 410, 'Barangay Business Clearance', 100, '123', '2023-06-28', 'June 28, 2023 10:52 AM', 'Pending'),
(22, 22, 410, 'Certificate of Indigency', 45, 'dfsdf', '2023-07-18', 'July 18, 2023 6:57 PM', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `new_finance`
--

CREATE TABLE `new_finance` (
  `financeID` int(11) NOT NULL,
  `financeBrgyID` int(11) NOT NULL,
  `collectionPayor` varchar(250) NOT NULL,
  `collectionDate` date NOT NULL,
  `collectionAmount` int(11) NOT NULL,
  `collectionNature` varchar(250) DEFAULT NULL,
  `financeNote` varchar(200) NOT NULL,
  `expensesProject` varchar(100) NOT NULL,
  `expensesProjectAmount` int(11) NOT NULL,
  `expensesElectricAmount` int(11) NOT NULL,
  `expensesWaterAmount` int(11) NOT NULL,
  `expensesDateFrom` date DEFAULT NULL,
  `expensesDateTo` date DEFAULT NULL,
  `financeLabel` varchar(100) NOT NULL,
  `depositDate` date DEFAULT NULL,
  `depositBank` varchar(250) NOT NULL,
  `depositReference` varchar(250) NOT NULL,
  `depositAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_finance`
--

INSERT INTO `new_finance` (`financeID`, `financeBrgyID`, `collectionPayor`, `collectionDate`, `collectionAmount`, `collectionNature`, `financeNote`, `expensesProject`, `expensesProjectAmount`, `expensesElectricAmount`, `expensesWaterAmount`, `expensesDateFrom`, `expensesDateTo`, `financeLabel`, `depositDate`, `depositBank`, `depositReference`, `depositAmount`) VALUES
(9, 410, 'Jeep Villa Nuñez                                    ', '2023-07-13', 232, 'asdasdas', 'Test', '', 0, 0, 0, NULL, NULL, 'collection', NULL, '', '', 0),
(11, 410, '', '0000-00-00', 0, NULL, 'Nothing', 'Basketball Adult K', 1000, 1000, 1000, '2023-07-02', '2023-07-30', 'expenses', NULL, '', '', 0),
(13, 410, 'Jeffrey Villamor Nuñez                                    ', '2023-07-20', 5667, 'fjhfhgh', '', '', 0, 0, 0, NULL, NULL, 'collection', NULL, '', '', 0),
(14, 410, '', '0000-00-00', 0, NULL, 'lahsd', '', 0, 0, 0, NULL, NULL, 'deposit', '2023-07-18', 'BDI', '2329DSSD', 343);

-- --------------------------------------------------------

--
-- Table structure for table `non_resident`
--

CREATE TABLE `non_resident` (
  `non_resident_id` int(11) NOT NULL,
  `non_res_firstname` varchar(250) NOT NULL,
  `non_res_lastname` varchar(250) NOT NULL,
  `non_res_gender` varchar(10) NOT NULL,
  `non_res_birthdate` date NOT NULL,
  `non_res_contact` varchar(50) NOT NULL,
  `non_res_address` mediumtext NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `non_resident`
--

INSERT INTO `non_resident` (`non_resident_id`, `non_res_firstname`, `non_res_lastname`, `non_res_gender`, `non_res_birthdate`, `non_res_contact`, `non_res_address`, `barangay_id`, `incident_id`) VALUES
(1, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(2, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '4', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(3, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(4, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '4', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(5, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(6, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '4', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(7, 'Adrean', 'Madrio', 'female', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(8, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '5', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(9, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(10, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '4', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(11, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '5', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(12, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(13, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '5', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(14, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(15, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '5', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(16, 'Adrean', 'Madrio', 'male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(17, 'Adrean', 'Madrio', '0963635357', '0000-00-00', '5', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 0, 0),
(46, 'Adrean', 'Madrio', 'Male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 36),
(47, 'Adrean', 'Madrio', 'Male', '0000-00-00', '2147483647', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 36),
(79, 'Gianginonsa', 'Cezariz', 'Male', '2023-05-13', '09636353575', '123 Judil Street Pandacan', 70, 410),
(80, 'Bobby', 'Yagami', 'Male', '0000-00-00', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 69, 410),
(81, 'Adrianne', 'Madrid', 'Male', '2023-06-06', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 80),
(82, 'Adrianne', 'Madrid', 'Male', '2023-06-06', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 80),
(83, 'Adrean', 'Madrio', 'Male', '2000-02-28', '09636353575', '123 Bagtas Bagtas', 70, 410),
(84, 'Adrean2', 'Madrio2', 'Male', '2023-06-06', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 70, 410),
(85, 'Adrean3', 'Madrio3', 'Male', '2023-05-31', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 70, 410),
(86, 'Adrean3', 'Madrio3', 'Male', '2023-05-31', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 70, 410),
(87, 'Adrean3', 'Madrio3', 'Male', '2023-05-31', '09636353575', 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 70, 410),
(88, 'Joshua', 'Ponciano', 'Male', '2023-07-11', '09123456789', '123 Mahalay Street Poblacion 1', 410, 81),
(89, 'jason', 'Ponciano', 'Male', '2023-07-11', '09123456789', '123 Puntahan Street Barangay Uno', 410, 81);

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `official_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`official_id`, `resident_id`, `position`, `date_start`, `date_end`) VALUES
(1, 1, 'Barangay Secretary', '2023-07-20', '2026-06-02'),
(45, 100, 'Barangay Leaders', '2023-07-13', '2023-07-13'),
(47, 205, 'Barangay Captain', '2023-07-20', '2023-07-20'),
(49, 213, 'Barangay Secretary', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `past_officials`
--

CREATE TABLE `past_officials` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `past_officials`
--

INSERT INTO `past_officials` (`id`, `resident_id`, `position`, `date_start`, `date_end`) VALUES
(7, 204, 'Committee on Agricultural', '2023-07-13', '2023-07-13');

-- --------------------------------------------------------

--
-- Table structure for table `pregnant`
--

CREATE TABLE `pregnant` (
  `pregnant_id` int(11) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `pregnant_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pregnant`
--

INSERT INTO `pregnant` (`pregnant_id`, `id_resident`, `pregnant_num`) VALUES
(9, 100, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `report_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `report_name`) VALUES
(1, 'Accomplishment Report'),
(2, 'Certificate of Validation'),
(3, 'Monthly Clean-up'),
(4, 'Personal Attendance Monitoring');

-- --------------------------------------------------------

--
-- Table structure for table `report_accomplishment`
--

CREATE TABLE `report_accomplishment` (
  `acc_id` int(11) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  `acc_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `acc_content` mediumtext NOT NULL,
  `month` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_accomplishment`
--

INSERT INTO `report_accomplishment` (`acc_id`, `acc_name`, `acc_date`, `acc_content`, `month`, `year`, `barangay_id`) VALUES
(19, 'Accomplishment Report', '2023-05-09 03:20:53', '21323', 'January', 2020, 0),
(20, 'Accomplishment Report', '2023-05-09 03:21:19', '234241', 'January', 2020, 0),
(21, 'Accomplishment Report', '2023-05-09 03:26:55', 'fsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfg', 'January', 2020, 0),
(22, 'Accomplishment Report', '2023-05-10 00:00:51', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus et sapien nec interdum. Phasellus ut sollicitudin sem, euismod rhoncus elit. Cras maximus tempus elit quis varius. Ut nec magna sodales, dignissim purus sit amet, ornare dui. Vivamus tempor facilisis nibh, at pharetra ex porttitor at. Praesent mollis metus commodo porttitor sodales. Mauris accumsan libero a nisi malesuada, ut ultrices orci lacinia. Nunc metus urna, laoreet eu augue eu, hendrerit rutrum est. Fusce condimentum ', 'August', 2024, 0),
(24, 'Accomplishment Report', '2023-05-12 07:46:09', ' fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fds', 'May', 2023, 0),
(25, 'Accomplishment Report', '2023-05-12 07:47:13', 'sdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsa', 'May', 2023, 0),
(26, 'Accomplishment Report', '2023-05-15 05:22:21', 'ewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqw', 'January', 2020, 410),
(27, 'Accomplishment Report', '2023-05-15 05:50:16', 'asdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgf', 'January', 2020, 447);

-- --------------------------------------------------------

--
-- Table structure for table `report_certificate`
--

CREATE TABLE `report_certificate` (
  `cert_id` int(11) NOT NULL,
  `cert_name` varchar(255) NOT NULL,
  `cert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `capt` varchar(250) NOT NULL,
  `Ldate` date NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_certificate`
--

INSERT INTO `report_certificate` (`cert_id`, `cert_name`, `cert_date`, `capt`, `Ldate`, `barangay_id`) VALUES
(77, 'Certificate Of Validation', '2023-05-04 07:14:58', 'Joshua Ponciano', '2023-02-28', 0),
(78, 'Certificate Of Validation', '2023-05-09 03:27:50', 'Joshua Ponciano', '2023-02-28', 0),
(79, 'Certificate Of Validation', '2023-05-12 03:34:29', 'Joahu', '2023-01-31', 0),
(80, 'Certificate Of Validation', '2023-05-15 05:28:36', 'Adrean Madrio', '2020-02-29', 410),
(81, 'Certificate Of Validation', '2023-05-15 06:19:21', 'Adrean Madrio', '2020-01-31', 410);

-- --------------------------------------------------------

--
-- Table structure for table `report_cleanup`
--

CREATE TABLE `report_cleanup` (
  `mcu_id` int(11) NOT NULL,
  `mcu_name` varchar(250) NOT NULL,
  `mcu_quarter` varchar(100) NOT NULL,
  `mcu_year` varchar(100) NOT NULL,
  `total_compliant` int(100) NOT NULL,
  `com_ave` varchar(250) NOT NULL,
  `mrf_brngy` int(100) NOT NULL,
  `mrf_fclty` int(100) NOT NULL,
  `mcu_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `commChairman` varchar(250) NOT NULL,
  `checks` smallint(6) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_cleanup`
--

INSERT INTO `report_cleanup` (`mcu_id`, `mcu_name`, `mcu_quarter`, `mcu_year`, `total_compliant`, `com_ave`, `mrf_brngy`, `mrf_fclty`, `mcu_date`, `commChairman`, `checks`, `barangay_id`) VALUES
(61, 'Monthly Clean-up', '4th', '2023', 30, '12', 13, 55, '2023-05-12 03:38:39', 'Gian Carlo Cesar', 5, 0),
(62, 'Monthly Clean-up', '4th', '2023', 30, '12', 13, 55, '2023-05-12 03:38:39', 'Gian Carlo Cesar', 5, 0),
(63, 'Monthly Clean-up', '1st', '2020', 2, '2', 2, 2, '2023-05-15 05:35:04', 'Gian Carlo Cesar', 0, 410),
(64, 'Monthly Clean-up', '1st', '2020', 2, '2', 2, 2, '2023-05-15 05:35:04', 'Gian Carlo Cesar', 0, 410),
(65, 'Monthly Clean-up', '2nd', '2020', 2, '2', 2, 2, '2023-05-15 05:51:57', 'Gian Carlo Cesar', 0, 447),
(66, 'Monthly Clean-up', '2nd', '2020', 2, '2', 2, 2, '2023-05-15 05:51:57', 'Gian Carlo Cesar', 0, 447);

-- --------------------------------------------------------

--
-- Table structure for table `report_cleanup_nstep`
--

CREATE TABLE `report_cleanup_nstep` (
  `nstep_id` int(11) NOT NULL,
  `key_legal` varchar(250) NOT NULL,
  `legal_consq` varchar(250) NOT NULL,
  `reason_low` varchar(250) NOT NULL,
  `next_step` varchar(250) NOT NULL,
  `mcu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_cleanup_nstep`
--

INSERT INTO `report_cleanup_nstep` (`nstep_id`, `key_legal`, `legal_consq`, `reason_low`, `next_step`, `mcu_id`) VALUES
(27, 'yes', 'yes', 'yes', 'yes', 62),
(28, 'yes', 'yes', 'yes', '', 62),
(29, 'yes', 'yes', '', '', 62),
(30, 'yes', '', '', '', 62),
(31, '', '', '', '', 64),
(32, '', '', '', '', 64),
(33, '', '', '', '', 64),
(34, '', '', '', '', 64),
(35, '', '', '', '', 66),
(36, '', '', '', '', 66),
(37, '', '', '', '', 66),
(38, '', '', '', '', 66);

-- --------------------------------------------------------

--
-- Table structure for table `report_personnel`
--

CREATE TABLE `report_personnel` (
  `perAtt_id` int(11) NOT NULL,
  `nonComp_name` varchar(255) NOT NULL,
  `nonComp_absent` varchar(255) NOT NULL,
  `nonComp_tardy` varchar(255) NOT NULL,
  `station` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `pam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_personnel`
--

INSERT INTO `report_personnel` (`perAtt_id`, `nonComp_name`, `nonComp_absent`, `nonComp_tardy`, `station`, `position`, `pam_id`) VALUES
(130, 'Adrean', '2', '2', 'building 2', 'tanod', 69),
(131, 'Adrean2', '3', '3', 'at trece', 'supervisor', 69),
(132, 'Adrean3', '4', '4', 'wwww', '2', 69),
(133, 'Adrean', '1', '1', 'building 2', 'tanod', 70),
(134, 'Adrean', '2', '2', 'building 2', 'tanod', 70),
(135, 'Adrean', '3', '3', 'building 2', 'tanod', 70),
(136, 'Adrean', '4', '4', 'building 2', 'tanod', 70),
(137, 'Adrean', '5', '5', 'building 2', 'tanod', 70),
(138, 'Adrean', '6', '6', 'building 2', 'tanod', 70),
(139, 'Adrean', '7', '7', 'building 2', 'tanod', 70),
(140, 'Adrean', '8', '8', 'building 2', 'tanod', 70),
(141, 'Adrean', '9', '9', 'building 2', 'tanod', 70),
(142, 'Adrean', '10', '10', 'building 2', 'tanod', 70),
(143, 'Adrean', '1', '1', 'building 2', 'tanod', 71),
(144, 'Adrean', '2', '2', 'building 2', 'janitor', 72);

-- --------------------------------------------------------

--
-- Table structure for table `report_personnel_list`
--

CREATE TABLE `report_personnel_list` (
  `pam_id` int(11) NOT NULL,
  `pam_title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `n_name` varchar(255) NOT NULL,
  `quarter` varchar(100) NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_personnel_list`
--

INSERT INTO `report_personnel_list` (`pam_id`, `pam_title`, `date`, `n_name`, `quarter`, `barangay_id`) VALUES
(69, 'Personal Attendance Monitoring', '2023-05-12 08:05:51', 'Rev Sales', '1st', 0),
(70, 'Personal Attendance Monitoring', '2023-05-12 08:07:46', 'Rev Sales', '1st', 0),
(71, 'Personal Attendance Monitoring', '2023-05-15 05:42:55', 'Rev Sales', '1st', 410),
(72, 'Personal Attendance Monitoring', '2023-05-15 05:52:49', 'Rev Sales', '2nd', 447);

-- --------------------------------------------------------

--
-- Table structure for table `report_resident`
--

CREATE TABLE `report_resident` (
  `rres_id` int(11) NOT NULL,
  `rres_category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_resident`
--

INSERT INTO `report_resident` (`rres_id`, `rres_category`) VALUES
(1, 'All resident'),
(2, 'Adult'),
(3, 'Employed'),
(4, 'Female'),
(5, 'Infant'),
(6, 'Male'),
(7, 'Minor'),
(8, 'Pregnant'),
(9, 'Senior'),
(10, 'Teenager'),
(11, 'Unemployed'),
(12, 'Death');

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `resident_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `family_id` int(11) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `suffix` varchar(10) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birthdate` date NOT NULL,
  `age` int(11) DEFAULT 0,
  `civil_status` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `contact_type` varchar(50) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `citizenship` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `occupation_status` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL,
  `is_alive` tinyint(1) NOT NULL DEFAULT 1,
  `date_recorded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `barangay_id`, `family_id`, `firstname`, `middlename`, `lastname`, `suffix`, `sex`, `birthdate`, `age`, `civil_status`, `contact`, `contact_type`, `height`, `weight`, `citizenship`, `religion`, `occupation_status`, `occupation`, `address`, `image`, `is_alive`, `date_recorded`) VALUES
(1, 410, 47, 'Jeffrey', 'Villamor', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 0, 0, '', 'Christian Catholic', 'Employed', '', '123 Sitio Pulo Kalokohan', '64b4eaab2c32c4.59612503.jpg', 1, '2023-07-17 07:15:55'),
(100, 410, NULL, 'Annas', '', '', '', 'Female', '0000-00-00', NULL, 'Married', '', '', 0, 0, '', '', '', 'Nurse', '', '', 0, '2023-07-20 05:31:17'),
(201, 410, NULL, 'Marites', '', '', '', 'Female', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-15 07:26:42'),
(202, 410, NULL, 'Melinda', '', '', '', 'Female', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-15 07:27:05'),
(203, 410, NULL, 'Nena', 'Ebido', 'Mañanita', '', 'Female', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 0, '2023-07-20 09:21:56'),
(204, 410, NULL, 'Filemon', '', '', '', 'Male', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-15 07:28:11'),
(205, 410, NULL, 'Edmund', '', '', '', 'Male', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-15 07:28:54'),
(206, 410, NULL, 'Efren', '', '', '', 'Male', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-15 07:29:40'),
(210, 410, 48, 'Manny', '', '', '', '', '2023-07-12', 0, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-16 02:04:32'),
(211, 410, NULL, 'Babyasdf', '', 'Ponciano', '', 'Male', '2020-07-16', 3, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-16 04:45:08'),
(213, 454, NULL, 'John', 'Smith', 'Doe', '', '', '0000-00-00', NULL, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-17 16:09:28'),
(1000, 454, NULL, 'Julius', 'Quiason', 'Natividad', '', 'Male', '1990-01-11', 33, 'single', '09568111904', 'mobile', 166, 50, 'Filipino', 'Ang Dating Daan', 'Employed', 'Factory Worker', '4106 Luna Street Agus-Us', '64aca9e30c2b99.77909025.jpg', 1, '2023-07-10 17:01:23'),
(1001, 454, NULL, 'Clarence ', 'Rico', 'Galendez', '', 'Male', '2005-07-15', 18, 'single', '09759824875', 'mobile', 144, 49, '', 'Christian Catholic', 'Unemployed', 'Unemployed', '1007 Mabini Street Alulod', '64acab52ca0425.34657074.png', 1, '2023-07-10 17:13:01'),
(1002, 454, NULL, 'Ella Catalina  ', 'Parsaligan', 'Roxas', '', 'Female', '2018-05-09', 5, 'single', '09451247685', 'mobile', 40, 25, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '3105 Alulod Bridge Alulod', '64acaeac91e869.52741623.png', 1, '2023-07-10 17:21:48'),
(1003, 454, NULL, 'Felicita ', 'Tiu ', 'Lorete', '', 'Female', '1961-12-18', 61, 'married', '212456', 'tel', 152, 52, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '2102 Balagtas Street Bancod', '64acafb912e365.94910013.jpg', 0, '2023-07-20 08:34:37'),
(1004, 454, NULL, 'Megan Yasmin ', 'Sayco ', 'Estrella', '', 'Female', '1998-03-08', 25, 'married', '09712639654', 'mobile', 158, 58, 'Filipino', 'Christian Catholic', 'Employed Government', 'Teacher', '4110 Pajo Bridge Bukal', '64acb098683951.48018226.jpg', 1, '2023-07-10 17:30:00'),
(1005, 454, NULL, 'Tomas ', 'Quiason ', 'Asuncion', 'M.D.', 'Male', '1985-10-07', 37, 'married', '09413648745', 'mobile', 164, 55, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Doctor', '158 Saluysoy Bridge Mataas na Lupa', '64acb1b12a54d3.62946030.jfif', 1, '2023-07-10 17:34:41'),
(1006, 454, NULL, 'Preston ', 'Garcia ', 'Pamintuan', '', 'Male', '2010-04-14', 13, 'single', '09147855989', 'mobile', 140, 60, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '5201 R. Jeciel Street Banaba Lejos', '64acb25826d734.44770191.png', 1, '2023-07-10 17:37:28'),
(1007, 454, NULL, 'Tanya Elisa ', 'Angping ', 'Jugueta', '', 'Female', '1989-06-14', 34, 'legally separated', '09413647785', 'mobile', 151, 54, 'Filipino', 'Christian Catholic', 'Employed', 'Factory Worker', '4210 Ilang-ilang Street Carasuchi', '64acb35a9a4882.35575368.png', 1, '2023-07-10 17:41:46'),
(1008, 454, NULL, 'Maeve Keila', ' Cosalan ', 'Gonzalez', '', 'Female', '2016-02-02', 7, 'single', '09515878563', 'mobile', 33, 25, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '145 Guyam Malaki Bonifacio Street', '64acb451543a36.64643825.png', 1, '2023-07-10 17:45:53'),
(1009, 454, NULL, 'Criston ', 'Diokno ', 'Romero', '', 'Male', '2007-08-03', 15, 'single', '09317426413', 'mobile', 149, 48, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '1420 Camia Street Bancod', '64acb56d92d3d7.36235938.jpg', 1, '2023-07-10 17:50:37'),
(1010, 454, NULL, 'Nicanor ', 'Abbas ', 'Rodriguez', 'Ltd.', 'Female', '1950-09-08', 72, 'widow', '09781357479', 'mobile', 172, 59, 'Filipino', 'Baptist', 'Unemployed', 'Unemployed', '112 San Francisco Javier Road Pulo', '64acb66705bef9.42203621.jpg', 1, '2023-07-10 17:54:47'),
(1011, 454, NULL, 'Carolyn ', 'Cawayan', ' Acosta', 'Ph.D.', 'Female', '1995-10-07', 27, 'married', '09451296857', 'mobile', 158, 59, 'Filipino', 'Baptist', 'Employed', 'Doctor', '1487 Mahabangkahoy Lejos Sampaguita Street', '64acb71831fad5.47801560.jfif', 1, '2023-07-10 17:57:44'),
(1012, 454, NULL, 'Judith Shaylee ', 'Ison ', 'Piñero', '', 'Female', '2019-07-11', 4, 'single', '09413587416', 'mobile', 39, 34, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '0121 H. Ilagan Street Tambo Ilaya', '64acb7c53155d5.21574046.png', 1, '2023-07-10 18:00:37'),
(1013, 454, NULL, 'Lora ', 'Calunod ', 'Prieto', '', 'Female', '2006-01-26', 17, 'single', '09815481365', 'mobile', 170, 62, 'Filipino', 'Iglesia Ni Kristo', 'Unemployed', 'Unemployed', '1523 Molave Street Kayquit I', '64acb863d412d9.09175853.png', 1, '2023-07-10 18:03:15'),
(1014, 454, NULL, 'Joselito ', 'Caris ', 'Miedes', 'Jr.', 'Male', '1959-06-05', 64, 'widow', '09871563148', 'mobile', 152, 48, 'Filipino', 'Born Again', 'Employed', 'Construction Worker', '4312 J. Dimabiling Kaytambog', '64acb92e1e3f85.26672294.jpg', 1, '2023-07-10 18:06:38'),
(1015, 454, NULL, 'Kody Serafin ', 'Tiamson ', 'Herrera', '', 'Male', '2011-08-25', 11, 'single', '09713659214', 'mobile', 81, 36, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '1453 Binambangan Street Kaytapos', '64acb9e68531b7.24888291.png', 1, '2023-07-10 18:09:42'),
(1016, 454, NULL, 'Adan ', 'Limsin ', 'Villamar', '', 'Male', '1980-11-11', 42, 'married', '09623148792', 'mobile', 182, 65, 'Filipino', 'Christian Catholic', 'Employed Government', 'Architect', '2150 Calderon Street Harasan', '64acbad74fda94.71361820.png', 0, '2023-07-20 08:31:53'),
(1017, 454, NULL, 'Emesto ', 'Kalim ', 'Dulay', '', 'Male', '2008-12-20', 14, 'single', '09214579536', 'mobile', 149, 49, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '1754 Rosal Street Tambo Ilaya', '64acbba43bd9c9.68446339.jpg', 1, '2023-07-10 18:17:08'),
(1018, 454, NULL, 'Alexandrea ', 'Lauzon ', 'Gatus', '', 'Female', '1982-11-04', 40, 'single', '09411577946', 'mobile', 172, 55, 'Filipino', 'Born Again', 'Overseas Filipino Worker (OFW)', 'Domestic Helper', '5102 San Isidro Road Bancod', '64acbc20330da2.39220653.png', 1, '2023-07-10 18:19:12'),
(1019, 454, NULL, 'Cristobal ', 'Lapiz ', 'Caringal', '', 'Female', '1996-12-20', 26, 'married', '09124789526', 'mobile', 190, 65, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Call Center', '1502 Lakandula Street Daine I', '64acbd0bedbcb3.84924647.jpg', 1, '2023-07-10 18:23:07'),
(1020, 410, NULL, 'Baby Jeff', 'Villamor', 'Nuñez', '', 'Male', '2023-07-20', 0, '', '', '', 0, 0, '', '', '', '', '', '', 1, '2023-07-20 07:03:55');

--
-- Triggers `resident`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_newborns` AFTER UPDATE ON `resident` FOR EACH ROW BEGIN
    -- Check the condition (age >= 2)
    IF NEW.age >= 2 THEN
        -- Delete the corresponding newborn records
        DELETE FROM hns_newborn WHERE resident_id = NEW.resident_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_age_insert` BEFORE INSERT ON `resident` FOR EACH ROW BEGIN
  SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.birthdate, CURDATE());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_age_update` BEFORE UPDATE ON `resident` FOR EACH ROW BEGIN
  SET NEW.age = TIMESTAMPDIFF(YEAR, NEW.birthdate, CURDATE());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `resident_family`
--

CREATE TABLE `resident_family` (
  `family_id` int(11) NOT NULL,
  `father_id` int(11) DEFAULT NULL,
  `mother_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident_family`
--

INSERT INTO `resident_family` (`family_id`, `father_id`, `mother_id`) VALUES
(47, 204, 201),
(48, 206, 203);

-- --------------------------------------------------------

--
-- Table structure for table `special_project`
--

CREATE TABLE `special_project` (
  `project_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `project_date` date DEFAULT NULL,
  `project_description` varchar(250) NOT NULL,
  `project_requirements` varchar(250) NOT NULL,
  `project_host` varchar(250) NOT NULL,
  `project_other_host` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `special_project`
--

INSERT INTO `special_project` (`project_id`, `barangay_id`, `project_name`, `project_date`, `project_description`, `project_requirements`, `project_host`, `project_other_host`) VALUES
(1, 410, 'Basketball Adult', '2023-04-10', 'Basketball League 2023 Adult Edition', '- Must be 18 years and above\r\n- No Health Condition\r\n- Bring 3 Photocopy of PSA', 'Others', 'Taugama'),
(2, 410, 'Volleyball', '2023-04-12', 'Womens Volleyball League', '18 and above\r\nGroup of 15 team', 'Barangay Officials', 'Officials'),
(3, 410, 'Cheerdancing', '2023-04-15', 'Cheering Competition for 18 and above', '[18 and above] \r\n[Must be a group of 15]', 'SK', 'SK'),
(4, 410, 'HipHop Competition', '2023-04-16', 'HipHop Competition 2023 (Men and Women)', 'Must be 18 and up, Group of 20 people.', 'Barangay Officials', 'Officials'),
(5, 410, 'Bikini Contest 2023', '2023-04-21', 'Bikini Contest 2023 open for man and women', 'Must be 18 and above', 'Others', ''),
(6, 410, 'Project Name', '2023-04-18', 'Testing Foreign key for special projects', 'wala naman', 'Others', 'Sample Host');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin_config`
--

CREATE TABLE `superadmin_config` (
  `municipality_id` int(11) NOT NULL,
  `municipality_name` varchar(255) NOT NULL,
  `municipality_link` varchar(255) NOT NULL,
  `municipality_logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `superadmin_config`
--

INSERT INTO `superadmin_config` (`municipality_id`, `municipality_name`, `municipality_link`, `municipality_logo`) VALUES
(1, 'Indang', 'indang.gov.ph', 'logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `super_accounts`
--

CREATE TABLE `super_accounts` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `super_accounts`
--

INSERT INTO `super_accounts` (`id`, `user_id`, `fullname`, `username`, `password`) VALUES
(1, 6997, 'admin', 'admin', '$2y$10$lJIkMVTaoEiB2lOaXa5yO..qXn9EiNtY/Ta8TOoVYxNYu0oGPEx6G');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `vaccine_id` int(11) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `vaccineInvID` int(11) NOT NULL,
  `vaccine_dose` varchar(250) NOT NULL,
  `vaccine_type` varchar(50) NOT NULL,
  `vaccine_date` date DEFAULT NULL,
  `vaccine_place` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_inventory`
--

CREATE TABLE `vaccine_inventory` (
  `vaccineInventoryID` int(11) NOT NULL,
  `vaccineBrgyID` int(11) NOT NULL,
  `vaccineName` varchar(100) NOT NULL,
  `vaccineQuantity` int(11) NOT NULL,
  `vaccineExpDate` date DEFAULT NULL,
  `vaccineStatus` varchar(100) NOT NULL,
  `vaccineDescrip` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine_inventory`
--

INSERT INTO `vaccine_inventory` (`vaccineInventoryID`, `vaccineBrgyID`, `vaccineName`, `vaccineQuantity`, `vaccineExpDate`, `vaccineStatus`, `vaccineDescrip`) VALUES
(1, 410, 'Pfizer', 50, '2027-06-12', 'Available', 'Covid 19 2023'),
(2, 410, 'Moderna', 24, '2027-03-12', 'Available', 'Covid 202'),
(3, 410, 'J&J', 0, '2023-06-16', 'Out of Stock', 'sds'),
(6, 410, 'Unilab', 21, '2054-12-05', 'Available', 'dasdas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `accounts_ibfk_1` (`official_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `brgy_id` (`brgy_id`),
  ADD KEY `brgy_id_2` (`brgy_id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `clearance`
--
ALTER TABLE `clearance`
  ADD PRIMARY KEY (`clearance_id`);

--
-- Indexes for table `clearance_release`
--
ALTER TABLE `clearance_release`
  ADD PRIMARY KEY (`release_id`),
  ADD KEY `resident_id` (`resident_id`),
  ADD KEY `clearance_id` (`clearance_id`);

--
-- Indexes for table `clearance_total`
--
ALTER TABLE `clearance_total`
  ADD PRIMARY KEY (`distrib_id`),
  ADD KEY `clearance_id` (`clearance_id`);

--
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`death_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  ADD PRIMARY KEY (`newborn_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  ADD PRIMARY KEY (`complainant_id`),
  ADD KEY `incident_id` (`incident_id`),
  ADD KEY `non_resident_id` (`non_resident_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `incident_offender`
--
ALTER TABLE `incident_offender`
  ADD PRIMARY KEY (`offender_id`),
  ADD KEY `incident_id` (`incident_id`),
  ADD KEY `resident_id` (`resident_id`),
  ADD KEY `non_resident_id` (`non_resident_id`);

--
-- Indexes for table `incident_table`
--
ALTER TABLE `incident_table`
  ADD PRIMARY KEY (`incident_id`);

--
-- Indexes for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  ADD PRIMARY KEY (`distrib_id`),
  ADD KEY `medicine_id` (`medicine_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `new_clearance`
--
ALTER TABLE `new_clearance`
  ADD PRIMARY KEY (`finance_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `new_finance`
--
ALTER TABLE `new_finance`
  ADD PRIMARY KEY (`financeID`);

--
-- Indexes for table `non_resident`
--
ALTER TABLE `non_resident`
  ADD PRIMARY KEY (`non_resident_id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`official_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `past_officials`
--
ALTER TABLE `past_officials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `pregnant`
--
ALTER TABLE `pregnant`
  ADD PRIMARY KEY (`pregnant_id`),
  ADD KEY `id_resident` (`id_resident`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `report_accomplishment`
--
ALTER TABLE `report_accomplishment`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `report_certificate`
--
ALTER TABLE `report_certificate`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `report_cleanup`
--
ALTER TABLE `report_cleanup`
  ADD PRIMARY KEY (`mcu_id`);

--
-- Indexes for table `report_cleanup_nstep`
--
ALTER TABLE `report_cleanup_nstep`
  ADD PRIMARY KEY (`nstep_id`),
  ADD KEY `mcu_id` (`mcu_id`);

--
-- Indexes for table `report_personnel`
--
ALTER TABLE `report_personnel`
  ADD PRIMARY KEY (`perAtt_id`),
  ADD KEY `pam_id` (`pam_id`);

--
-- Indexes for table `report_personnel_list`
--
ALTER TABLE `report_personnel_list`
  ADD PRIMARY KEY (`pam_id`);

--
-- Indexes for table `report_resident`
--
ALTER TABLE `report_resident`
  ADD PRIMARY KEY (`rres_id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`resident_id`),
  ADD KEY `barangay_id` (`barangay_id`),
  ADD KEY `family_id` (`family_id`);

--
-- Indexes for table `resident_family`
--
ALTER TABLE `resident_family`
  ADD PRIMARY KEY (`family_id`),
  ADD KEY `father_id` (`father_id`),
  ADD KEY `mother_id` (`mother_id`);

--
-- Indexes for table `special_project`
--
ALTER TABLE `special_project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `superadmin_config`
--
ALTER TABLE `superadmin_config`
  ADD PRIMARY KEY (`municipality_id`);

--
-- Indexes for table `super_accounts`
--
ALTER TABLE `super_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`vaccine_id`),
  ADD KEY `id_resident` (`id_resident`);

--
-- Indexes for table `vaccine_inventory`
--
ALTER TABLE `vaccine_inventory`
  ADD PRIMARY KEY (`vaccineInventoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=457;

--
-- AUTO_INCREMENT for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `clearance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `clearance_release`
--
ALTER TABLE `clearance_release`
  MODIFY `release_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `clearance_total`
--
ALTER TABLE `clearance_total`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `death_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  MODIFY `newborn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  MODIFY `complainant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `incident_offender`
--
ALTER TABLE `incident_offender`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `new_clearance`
--
ALTER TABLE `new_clearance`
  MODIFY `finance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `new_finance`
--
ALTER TABLE `new_finance`
  MODIFY `financeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `non_resident`
--
ALTER TABLE `non_resident`
  MODIFY `non_resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `official_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `past_officials`
--
ALTER TABLE `past_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pregnant`
--
ALTER TABLE `pregnant`
  MODIFY `pregnant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report_accomplishment`
--
ALTER TABLE `report_accomplishment`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `report_certificate`
--
ALTER TABLE `report_certificate`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `report_cleanup`
--
ALTER TABLE `report_cleanup`
  MODIFY `mcu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `report_cleanup_nstep`
--
ALTER TABLE `report_cleanup_nstep`
  MODIFY `nstep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `report_personnel`
--
ALTER TABLE `report_personnel`
  MODIFY `perAtt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `report_personnel_list`
--
ALTER TABLE `report_personnel_list`
  MODIFY `pam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `report_resident`
--
ALTER TABLE `report_resident`
  MODIFY `rres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1021;

--
-- AUTO_INCREMENT for table `resident_family`
--
ALTER TABLE `resident_family`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `special_project`
--
ALTER TABLE `special_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `superadmin_config`
--
ALTER TABLE `superadmin_config`
  MODIFY `municipality_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `super_accounts`
--
ALTER TABLE `super_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vaccine`
--
ALTER TABLE `vaccine`
  MODIFY `vaccine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vaccine_inventory`
--
ALTER TABLE `vaccine_inventory`
  MODIFY `vaccineInventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`official_id`) REFERENCES `officials` (`official_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`brgy_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  ADD CONSTRAINT `barangay_configuration_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clearance_release`
--
ALTER TABLE `clearance_release`
  ADD CONSTRAINT `clearance_release_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`),
  ADD CONSTRAINT `clearance_release_ibfk_3` FOREIGN KEY (`clearance_id`) REFERENCES `clearance` (`clearance_id`);

--
-- Constraints for table `clearance_total`
--
ALTER TABLE `clearance_total`
  ADD CONSTRAINT `clearance_total_ibfk_1` FOREIGN KEY (`clearance_id`) REFERENCES `clearance` (`clearance_id`);

--
-- Constraints for table `death`
--
ALTER TABLE `death`
  ADD CONSTRAINT `death_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  ADD CONSTRAINT `hns_newborn_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  ADD CONSTRAINT `incident_complainant_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incident_offender`
--
ALTER TABLE `incident_offender`
  ADD CONSTRAINT `fk_incident_id` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nonres_id` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res_id` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  ADD CONSTRAINT `medicine_distribution_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_distribution_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicine_inventory` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  ADD CONSTRAINT `medicine_inventory_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `officials`
--
ALTER TABLE `officials`
  ADD CONSTRAINT `officials_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `past_officials`
--
ALTER TABLE `past_officials`
  ADD CONSTRAINT `past_officials_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pregnant`
--
ALTER TABLE `pregnant`
  ADD CONSTRAINT `pregnant_ibfk_1` FOREIGN KEY (`id_resident`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_cleanup_nstep`
--
ALTER TABLE `report_cleanup_nstep`
  ADD CONSTRAINT `fk_mcu_id` FOREIGN KEY (`mcu_id`) REFERENCES `report_cleanup` (`mcu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report_personnel`
--
ALTER TABLE `report_personnel`
  ADD CONSTRAINT `fk_pam_id` FOREIGN KEY (`pam_id`) REFERENCES `report_personnel_list` (`pam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `resident`
--
ALTER TABLE `resident`
  ADD CONSTRAINT `resident_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resident_ibfk_2` FOREIGN KEY (`family_id`) REFERENCES `resident_family` (`family_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `resident_family`
--
ALTER TABLE `resident_family`
  ADD CONSTRAINT `resident_family_ibfk_1` FOREIGN KEY (`father_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resident_family_ibfk_2` FOREIGN KEY (`mother_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD CONSTRAINT `vaccine_ibfk_1` FOREIGN KEY (`id_resident`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
