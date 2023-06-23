-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 03:13 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

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
  `allowed_modules` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `official_id`, `allowed_modules`, `username`, `password`) VALUES
(1, 1, '', 'jeep123', '$2y$10$tQLjkLYkhwqAKsgoA2xEZupcEEKUEoQ0s21crdIY6KHZ/FNtsuB8e'),
(62, 38, '[\"announcement\"]', 'ad123', '$2y$10$78XDvWNNBG3eyOFuOfmgeubhGC4jI1h/REkluZISaxEm1nX7XEQ.u');

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
  `announcement_when` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `brgy_id`, `announcement_photo`, `announcement_title`, `announcement_message`, `announcement_what`, `announcement_where`, `announcement_when`, `created_at`) VALUES
(18, 410, '644276e6e0c461.95506790.jpg', 'Sample Title', 'Sample msg', NULL, NULL, NULL, '2023-04-21 19:43:34'),
(19, 410, '64427ab9c27c62.89684079.jpg', 'TITLE', 'MESSAEG', NULL, NULL, NULL, '2023-04-21 19:59:53'),
(20, 410, '64428d489497c5.82321679.png', 'sample 2', 'asdasdsd', NULL, NULL, NULL, '2023-04-21 21:19:04'),
(21, 410, '64429042c50920.52350854.jpg', 'TITLE', 'MESSAEG', NULL, NULL, NULL, '2023-04-21 21:31:46'),
(22, 410, '6442904ed55781.38692922.jpg', 'sample 2', 'asdasdasdasd', NULL, NULL, NULL, '2023-04-21 21:31:58'),
(23, 410, '6442910b7ec676.95359815.jpg', 'TIETLETLETELTELT', 'SDFASDFASDFASDFASF', NULL, NULL, NULL, '2023-04-21 21:35:07'),
(24, 410, '6443947ea408e6.08074828.jpg', 'Sample title ulet', 'last message', NULL, NULL, NULL, '2023-04-22 16:02:06'),
(25, 410, '6444ad906b21d2.58516052.png', 'MINA TITLE', 'MINA MESSAGE', NULL, NULL, NULL, '2023-04-23 12:01:20'),
(26, 410, '645cbd8c2a2fa4.10930140.jpg', 'RIPPED REV ED', 'Sample Message for Ripped Rev Ed', NULL, NULL, NULL, '2023-05-11 18:03:56'),
(27, 410, '645ccab1930502.68665013.jpg', 'Mina Sample Title', 'Mina message to all', NULL, NULL, NULL, '2023-05-11 19:00:01'),
(28, 410, '645d1a2f624e01.58997727.jpg', 'Ang Pagwawakas', 'Graduation', 'CVSU', 'August, 2023', 'Yehey Congrats', '2023-05-12 00:39:11'),
(29, 410, '645d4277ac84e4.86611240.jpg', 'TITLE ', 'Sample Title ', 'Covered court', 'May 14, 2023', 'Message to all viewers, labyu', '2023-05-12 03:31:03'),
(30, 410, '645d43e615a5a7.08887636.png', 'ETO LEGIT TITLE', 'Mensahe to all, gumana kana pls', 'DITO SA WHAT TO', 'Covered Court', 'May 14, 2023', '2023-05-12 03:37:10'),
(31, 410, '645e6dbb729fb9.11838149.jpg', 'Hero', 'mensahe', 'Hero IMG', 'sa court ', 'bukas', '2023-05-13 00:47:55');

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
(410, 'Do Not Delete This', '123 Jeepney Indang, Cavite', '64717f00d80d87.83346183.png', 'indang.gov.ph/do-not-delete-this', 1);

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
(1, 410, 'Sample Mission', 'Sample Vision', 'Sample Objectives', 'Sample history history', '');

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

--
-- Dumping data for table `clearance`
--

INSERT INTO `clearance` (`clearance_id`, `barangay_id`, `clearance_name`, `clearance_amount`) VALUES
(72, 0, 'Certificate of Indigency', 25),
(77, 0, 'Barangay Business Clearance', 20),
(78, 0, 'Barangay Clearance', 40),
(79, 0, 'Certificate of Good Moral Character', 10),
(80, 0, 'Certificate of Residency', 25),
(81, 0, 'Certificate of Clearance', 20),
(82, 410, 'Clearance', 50);

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

--
-- Dumping data for table `clearance_release`
--

INSERT INTO `clearance_release` (`release_id`, `clearance_id`, `resident_id`, `purpose`, `date`) VALUES
(28, 78, 20, 'Scholarship', '2023-05-10 07:34:32'),
(29, 78, 20, 'Wala lang', '2023-05-16 01:23:00');

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

--
-- Dumping data for table `clearance_total`
--

INSERT INTO `clearance_total` (`distrib_id`, `clearance_id`, `distrib_quantity`, `distrib_total`) VALUES
(1, 81, 3, 60),
(3, 72, 1, 0),
(4, 79, 2, 0),
(5, 80, 3, 75),
(8, 78, 2, 80);

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `death_id` int(11) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `death_fname` varchar(250) NOT NULL,
  `death_cause` varchar(250) NOT NULL,
  `death_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `death`
--

INSERT INTO `death` (`death_id`, `id_resident`, `death_fname`, `death_cause`, `death_date`) VALUES
(18, 23, 'Ripped Rev Sales                                    ', 'csd', '2023-05-13'),
(19, 19, 'Adrean Barurot Madrionaa                                    ', 'dfsd', '2023-05-12');

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
(34, 'not resident', NULL, 46, 36);

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
(35, 'not resident', NULL, 36, 47, 'wqerqwreqerq');

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
  `status` varchar(250) NOT NULL,
  `narrative` mediumtext NOT NULL,
  `blotterType_id` int(11) NOT NULL,
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_table`
--

INSERT INTO `incident_table` (`incident_id`, `incident_title`, `case_incident`, `date_incident`, `time_incident`, `location`, `status`, `narrative`, `blotterType_id`, `date_reported`, `barangay_id`) VALUES
(36, 'Dahil sa pagibig', 'civil', '2023-05-16', '12:23:00', 'babaan ng Trece', '1', 'werqreqrq', 1, '2023-05-22 04:24:02', 410),
(38, 'Dahil sa pagibig', 'civil', '2023-05-09', '15:06:00', 'babaan ng Trece', '1', '134141', 1, '2023-05-22 07:08:00', 410);

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
(44, 102, 45, 10, '2023-04-14'),
(45, 107, 45, 5, '2023-04-27');

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
(102, 'Neozep', 'Available', 10, '2023-04-24', 'For colds'),
(103, 'Medicol', 'Available', 10, '2023-04-17', 'For sakit ng ulo'),
(104, 'Medicol', 'Available', 35, '2023-04-24', 'For sakit ng ulo'),
(105, 'Anti-Histamine', 'Available', 20, '2023-04-25', 'For allergy'),
(106, 'Cetirizine', 'Out of Stock', 0, '2023-04-30', 'Allergy'),
(107, 'Diatabs', 'Out of Stock', 0, '2023-04-13', 'Pagtatae'),
(108, 'Paracetamol', 'Available', 9, '2023-05-02', 'For flu'),
(109, 'Biogesic', 'Available', 95, '2024-04-14', 'For flu'),
(110, 'neozep', 'Available', 5, '2023-04-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `newborn`
--

CREATE TABLE `newborn` (
  `newborn_id` int(11) NOT NULL,
  `newborn_fname` varchar(250) NOT NULL,
  `newborn_mname` varchar(250) NOT NULL,
  `newborn_lname` varchar(250) NOT NULL,
  `newborn_gender` varchar(50) NOT NULL,
  `newborn_date_birth` date DEFAULT NULL,
  `newborn_date_added` date DEFAULT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `newborn`
--

INSERT INTO `newborn` (`newborn_id`, `newborn_fname`, `newborn_mname`, `newborn_lname`, `newborn_gender`, `newborn_date_birth`, `newborn_date_added`, `label`) VALUES
(7, 'Ayatotto', 'Hernan', 'Quim', 'Male', '2023-05-19', '2023-05-12', '');

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
  `non_res_contact` int(11) NOT NULL,
  `non_res_address` mediumtext NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `non_resident`
--

INSERT INTO `non_resident` (`non_resident_id`, `non_res_firstname`, `non_res_lastname`, `non_res_gender`, `non_res_birthdate`, `non_res_contact`, `non_res_address`, `barangay_id`, `incident_id`) VALUES
(46, 'Adrean', 'Madrio', 'Male', '0000-00-00', 2147483647, 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 36),
(47, 'Adrean', 'Madrio', 'Male', '0000-00-00', 2147483647, 'Blk 25, Lot 21 Ph5 Carissa, Bagtas', 410, 36);

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
(1, 17, 'Barangay Secretary', '0000-00-00', '0000-00-00'),
(38, 19, 'Barangay Captain', '2023-05-25', '2023-05-25');

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

-- --------------------------------------------------------

--
-- Table structure for table `pregnant`
--

CREATE TABLE `pregnant` (
  `pregnant_id` int(11) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `pregnant_num` int(11) NOT NULL,
  `pregnant_status` varchar(50) NOT NULL,
  `pregnant_occupation` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pregnant`
--

INSERT INTO `pregnant` (`pregnant_id`, `id_resident`, `pregnant_num`, `pregnant_status`, `pregnant_occupation`) VALUES
(5, 19, 4, 'Married', 'Housewife'),
(6, 20, 12, 'Separated', 'Driver'),
(7, 22, 9, 'Married', 'Housewife');

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
  `age` int(11) NOT NULL,
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
  `date_recorded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `barangay_id`, `family_id`, `firstname`, `middlename`, `lastname`, `suffix`, `sex`, `birthdate`, `age`, `civil_status`, `contact`, `contact_type`, `height`, `weight`, `citizenship`, `religion`, `occupation_status`, `occupation`, `address`, `image`, `date_recorded`) VALUES
(17, 410, NULL, 'Jeffrey', 'Villamor', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '09123456789', 'mobile', 160, 70, '', 'Christian Catholic', 'Unemployed', '', '123 Hahaha Poblacion', '6462ea6540a5a7.48041657.jpg', '2023-05-16 02:28:53'),
(19, 410, 41, 'Adrean', 'Barurot', 'Madrio', '', 'Male', '2000-02-28', 12, 'single', '', 'mobile', 171, 170, '', 'Born Again', 'Unemployed', '', '123 Bagtas Bagtas', '63ff24384f6d32.13857671.png', '2023-05-13 05:58:27'),
(20, 410, 41, 'Jeep', 'Villa', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 165, 70, '', 'Seventh Day Adventist', 'Unemployed', '', '123 Sitio Pulo Kalokohan', '63ff240cbd6f53.78912086.png', '2023-05-13 05:58:27'),
(21, 410, NULL, 'Rev Ed', 'Tigang', 'Sales', '', 'Male', '2023-01-01', 0, 'single', '', 'no_contact', 123, 123, '', 'Christian Catholic', 'Unemployed', '', '123 456 yoyo', '63ff29d52ae238.19457172.jpg', '2023-05-13 05:58:27'),
(22, 410, NULL, 'Jeffrey', 'Villamor', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 165, 70, '', 'Christian Catholic', 'Unemployed', '', '123 Mahalay Street Poblacion 1', '64015c1b54c731.54117511.jpg', '2023-05-13 05:58:27'),
(23, 410, 41, 'Ripped', 'Rev', 'Sales', '', 'Male', '2000-01-01', 23, 'single', '', 'tel', 165, 70, '', 'Christian Catholic', 'Unemployed', '', '123 Bagtas Poblacion 1', '6425913f2a8de3.82572586.png', '2023-05-13 05:58:27'),
(52, 410, NULL, 'Joshua', 'Oafericua', 'Ponciano', '', 'Female', '2023-04-06', 0, 'married', '09123456789', 'mobile', 160, 60, '', 'Ang Dating Daan', 'Employed', 'Comshop Manager', '123 Puntahan Street Barangay Uno', '642ea0215eea81.85696232.png', '2023-05-13 05:58:27'),
(88, 410, 41, 'Gian', 'Carlo', 'Cezar', '', 'Male', '2023-05-13', 0, 'single', '1909900', 'tel', 123, 123123, 'Filipino', 'Born Again', 'Employed Private', 'Pizza Maker', '123 Judil Street Pandacan', '645f3233430961.64166343.jpg', '2023-05-28 02:30:31'),
(89, 410, NULL, 'jo', 'a', 'hu', 'Jr.', 'Male', '2001-05-13', 21, 'single', '', 'no_contact', 123, 122, 'Filipino', 'Islam', 'Unemployed', 'Unemployed', '123 Mahalay Street Hugo Perez', '645f3d6c4c9a67.06406065.jpg', '2023-05-13 07:34:04');

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
(41, 21, 52);

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
  `vaccine_dose` varchar(250) NOT NULL,
  `vaccine_type` varchar(50) NOT NULL,
  `vaccine_date` date DEFAULT NULL,
  `vaccine_place` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccine_id`, `id_resident`, `vaccine_dose`, `vaccine_type`, `vaccine_date`, `vaccine_place`) VALUES
(11, 21, '1st Dose', 'Pfizer', '2023-05-25', 'Dasmarinas'),
(12, 17, 'Booster', 'Parkinson', '2023-05-31', 'Imuss');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `resident_id` (`official_id`);

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
  ADD PRIMARY KEY (`death_id`);

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
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `newborn`
--
ALTER TABLE `newborn`
  ADD PRIMARY KEY (`newborn_id`);

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
  ADD PRIMARY KEY (`pregnant_id`);

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
  ADD PRIMARY KEY (`vaccine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=450;

--
-- AUTO_INCREMENT for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `clearance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `clearance_release`
--
ALTER TABLE `clearance_release`
  MODIFY `release_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `clearance_total`
--
ALTER TABLE `clearance_total`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `death_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  MODIFY `complainant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `incident_offender`
--
ALTER TABLE `incident_offender`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `newborn`
--
ALTER TABLE `newborn`
  MODIFY `newborn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `non_resident`
--
ALTER TABLE `non_resident`
  MODIFY `non_resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `official_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `past_officials`
--
ALTER TABLE `past_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pregnant`
--
ALTER TABLE `pregnant`
  MODIFY `pregnant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `resident_family`
--
ALTER TABLE `resident_family`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  MODIFY `vaccine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- Constraints for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  ADD CONSTRAINT `fk_incident2_id` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nonres2_id` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res2_id` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `incident_offender`
--
ALTER TABLE `incident_offender`
  ADD CONSTRAINT `fk_incident_id` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nonres_id` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res_id` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE;

--
-- Constraints for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  ADD CONSTRAINT `medicine_distribution_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicine_inventory` (`ID`),
  ADD CONSTRAINT `medicine_distribution_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`);

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
  ADD CONSTRAINT `resident_family_ibfk_1` FOREIGN KEY (`mother_id`) REFERENCES `resident` (`resident_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `resident_family_ibfk_2` FOREIGN KEY (`father_id`) REFERENCES `resident` (`resident_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `special_project`
--
ALTER TABLE `special_project`
  ADD CONSTRAINT `special_project_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
