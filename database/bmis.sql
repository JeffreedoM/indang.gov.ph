-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2023 at 04:29 PM
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalculateAge` (`birthdate` DATE) RETURNS INT(11) BEGIN
    DECLARE age INT;
    SET age = YEAR(CURDATE()) - YEAR(birthdate);
    IF DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(birthdate, '%m%d') THEN
        SET age = age - 1;
    END IF;
    RETURN age;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `official_id` int(11) NOT NULL,
  `allowed_modules` varchar(255) NOT NULL DEFAULT '[]',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `default_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `official_id`, `allowed_modules`, `username`, `password`, `default_password`) VALUES
(76, 50, '[]', 'john123', '$2y$10$V9FP2b/nCoWfOddWbFyu2OLNiJxq368D85hfRdXvxMbqyLzjFs4.a', 'john456'),
(110, 93, '[\"announcement\"]', 'cap123', '$2y$10$tVjeSkar09NdXRfT7iDenufIPfUrz6b7HNizq12.XK4j5VT7CC3Pe', ''),
(111, 94, '[\"announcement\"]', 'com123', '$2y$10$aeUGWVWGjAcdBE3XvxEwCe.z7Dy35qd9SilYXnHcM4lF0jMsv.nhK', ''),
(112, 91, '[]', 'janine123', '$2y$10$WVlQv1KwpFicvpc2/aNyRuk24Z3KcVcMHh/dMH8yxS6QcocbcFypK', '');

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
  `receiver` varchar(255) NOT NULL,
  `is_highlighted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `brgy_id`, `announcement_photo`, `announcement_title`, `announcement_message`, `announcement_what`, `announcement_where`, `announcement_when`, `receiver`, `is_highlighted`, `created_at`) VALUES
(45, 454, '64d75b3f9f4f53.77202747.png', 'Sample Announcement', 'Mensahe para sa kapitan', 'Sample What', 'Sample Where', '2023-09-09', 'Barangay Captain', 0, '2023-08-12 18:13:19'),
(46, 454, '64d85e9840ce37.67665596.png', 'All Residents', 'Message for all residents. Mabuhay!', '', '', '0000-00-00', 'All Residents', 0, '2023-08-13 12:39:52'),
(47, 454, '64d861f5898b87.36398190.jpg', 'All Officials', 'Mensahe to all Officials', '', '', '0000-00-00', 'All Barangay Officials', 0, '2023-08-13 12:54:13'),
(48, 454, '64d871ba8302d0.31885898.jpg', 'Committee Announcements', 'Mensahe to All Committee', '', '', '0000-00-00', 'All Councilors', 0, '2023-08-13 14:01:30'),
(55, 454, '64d8793859b066.94084904.png', 'All Residents', 'All Residents to', '', '', '0000-00-00', 'All Residents', 0, '2023-08-13 14:33:28');

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
(454, 'Barangay', 'Barangay Indang, Cavite', '64bf7160430384.55102444.png', 'indang.gov.ph/barangay', 1);

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
(29, 454, '', '', '', '', '');

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
(6, 1000, '2023-07-30', 'Pinatay ni Jeep'),
(7, 1002, '2023-07-30', 'Pinatay ni Jeep');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_content` longtext NOT NULL,
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(81, 1387),
(82, 1389);

-- --------------------------------------------------------

--
-- Table structure for table `hns_newborn_history`
--

CREATE TABLE `hns_newborn_history` (
  `newborn_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hns_newborn_history`
--

INSERT INTO `hns_newborn_history` (`newborn_id`, `resident_id`) VALUES
(75, 1380);

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
(2, 'resident', 1001, NULL, 2),
(3, 'resident', 1003, NULL, 3),
(4, 'resident', 1006, NULL, 4);

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
(2, 'resident', 1004, 2, NULL, 'sana all'),
(3, 'resident', 1004, 3, NULL, '123'),
(4, 'resident', 1001, 4, NULL, 'sadf');

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
  `status` tinyint(4) NOT NULL COMMENT '1 - On-going, \r\n2 - Dismiss,\r\n3 - Certified 4a,\r\n4 - Mediated,\r\n5 - Resolved',
  `narrative` longtext NOT NULL,
  `blotterType_id` tinyint(4) NOT NULL COMMENT '1-Complainant, 2-Incident',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_table`
--

INSERT INTO `incident_table` (`incident_id`, `incident_title`, `case_incident`, `date_incident`, `time_incident`, `location`, `status`, `narrative`, `blotterType_id`, `date_reported`, `barangay_id`) VALUES
(2, 'nanghampas', 'criminal', '2023-08-01', '09:23:00', 'Imus', 3, '[\"sana all\"]', 2, '2023-08-01 01:24:02', 454),
(3, 'Nambuhos ng mainit na tubig', 'criminal', '2023-08-15', '10:51:00', 'Imus', 1, '[\"<p>Grabe hehe<\\/p>\\r\\n\"]', 2, '2023-08-15 02:51:21', 454),
(4, 'asdf', 'criminal', '2023-08-15', '11:29:00', 'Imus', 1, '[\"<p>123<\\/p>\\r\\n\"]', 2, '2023-08-15 03:29:49', 454);

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
(54, 122, 1009, 11, '2023-08-06');

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
(121, 454, 'Biogesic', 'Available', 1, '2023-07-31', 'Expired'),
(122, 454, 'Yakapsule', 'Available', 189, '2025-06-09', '');

-- --------------------------------------------------------

--
-- Table structure for table `new_clearance`
--

CREATE TABLE `new_clearance` (
  `clearance_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `form_request` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `finance_date` date DEFAULT NULL,
  `date_string` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_clearance`
--

INSERT INTO `new_clearance` (`clearance_id`, `resident_id`, `barangay_id`, `form_request`, `amount`, `purpose`, `finance_date`, `date_string`, `status`) VALUES
(33, 1005, 454, 'CVSU Pre-Reg Form', '100.00', 'eyy', '2023-08-15', 'August 15, 2023 1:22 AM', 'Paid'),
(34, 1003, 454, 'Jeep Form', '100.00', 'Jeep form by Jeep hingi si Jeep', '2023-08-15', 'August 15, 2023 1:41 AM', 'Paid'),
(35, 1004, 454, 'Barangay Clearance', '100.00', 'nah', '2023-08-15', 'August 15, 2023 9:53 AM', 'Paid'),
(36, 1004, 454, 'Barangay Clearance', '100.00', 'nah', '2023-08-15', 'August 15, 2023 9:55 AM', 'Paid'),
(37, 1004, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 9:55 AM', 'Pending'),
(38, 1004, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 9:56 AM', 'Paid'),
(39, 1004, 454, 'Barangay Clearance', '100.00', '12', '2023-08-15', 'August 15, 2023 9:59 AM', 'Paid'),
(40, 1004, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 9:59 AM', 'Paid'),
(41, 1004, 454, 'Barangay Business Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 10:04 AM', 'Pending'),
(42, 1004, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 10:05 AM', 'Paid'),
(44, 1004, 454, 'Barangay Clearance', '100.00', '123', '2023-08-15', 'August 15, 2023 10:09 AM', 'Pending'),
(45, 1004, 454, 'Barangay Clearance', '100.00', '123', '2023-08-15', 'August 15, 2023 10:09 AM', 'Pending'),
(46, 1004, 454, 'Barangay Clearance', '100.00', '123', '2023-08-15', 'August 15, 2023 10:11 AM', 'Paid'),
(47, 1004, 454, 'Barangay Clearance', '1.00', '1', '2023-08-15', 'August 15, 2023 10:12 AM', 'Pending'),
(48, 1004, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 10:14 AM', 'Pending'),
(49, 1005, 454, 'Barangay Clearance', '100.00', '1', '2023-08-15', 'August 15, 2023 10:18 AM', 'Paid'),
(50, 1004, 454, 'Barangay Business Clearance', '100.00', '123', '2023-08-15', 'August 15, 2023 10:21 AM', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `new_finance`
--

CREATE TABLE `new_finance` (
  `financeID` int(11) NOT NULL,
  `financeBrgyID` int(11) NOT NULL,
  `collectionPayor` varchar(250) NOT NULL,
  `collectionDate` date NOT NULL,
  `collectionAmount` decimal(10,2) NOT NULL,
  `collectionNature` varchar(250) DEFAULT NULL,
  `financeNote` varchar(200) NOT NULL,
  `expensesProject` varchar(100) NOT NULL,
  `expensesProjectAmount` decimal(10,2) NOT NULL,
  `expensesElectricAmount` decimal(10,2) NOT NULL,
  `expensesWaterAmount` decimal(10,2) NOT NULL,
  `expensesDateFrom` date DEFAULT NULL,
  `expensesDateTo` date DEFAULT NULL,
  `financeLabel` varchar(100) NOT NULL,
  `depositDate` date DEFAULT NULL,
  `depositBank` varchar(250) NOT NULL,
  `depositReference` varchar(250) NOT NULL,
  `depositAmount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `new_finance`
--

INSERT INTO `new_finance` (`financeID`, `financeBrgyID`, `collectionPayor`, `collectionDate`, `collectionAmount`, `collectionNature`, `financeNote`, `expensesProject`, `expensesProjectAmount`, `expensesElectricAmount`, `expensesWaterAmount`, `expensesDateFrom`, `expensesDateTo`, `financeLabel`, `depositDate`, `depositBank`, `depositReference`, `depositAmount`) VALUES
(21, 454, '', '0000-00-00', '0.00', NULL, '', '1', '1.00', '1.00', '1.00', '2023-07-30', '2023-07-30', 'expenses', NULL, '', '', '0.00'),
(22, 454, '', '0000-00-00', '0.00', NULL, '', '123', '123.00', '123.00', '123.00', '2023-07-30', '2023-07-30', 'expenses', NULL, '', '', '0.00');

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
(50, 1021, 'Barangay Secretary', '2023-08-09', '2023-08-26'),
(91, 1216, 'Sangguniang Kabataan', '2023-08-23', '2023-08-23'),
(93, 1302, 'Barangay Captain', '2023-08-23', '2023-08-23'),
(94, 1309, 'Committee on Peace and Order', '2023-09-08', '2027-09-08');

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
  `pregnant_due` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pregnant`
--

INSERT INTO `pregnant` (`pregnant_id`, `id_resident`, `pregnant_num`, `pregnant_due`) VALUES
(15, 1003, 2, '2023-08-16');

-- --------------------------------------------------------

--
-- Table structure for table `pregnant_history`
--

CREATE TABLE `pregnant_history` (
  `pregnant_id` int(11) NOT NULL,
  `id_resident` int(11) NOT NULL,
  `pregnant_num` int(11) NOT NULL,
  `pregnant_due` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pregnant_history`
--

INSERT INTO `pregnant_history` (`pregnant_id`, `id_resident`, `pregnant_num`, `pregnant_due`) VALUES
(14, 1003, 1, '2023-08-14'),
(16, 1007, 1, '2023-08-14'),
(17, 1013, 2, '2023-08-14');

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
(4, 'Personal Attendance Monitoring'),
(5, 'Complaint Report');

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

-- --------------------------------------------------------

--
-- Table structure for table `report_certificate`
--

CREATE TABLE `report_certificate` (
  `cert_id` int(11) NOT NULL,
  `cert_name` varchar(255) NOT NULL,
  `cert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `capt` varchar(250) NOT NULL,
  `date` varchar(255) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `person` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `report_complaint`
--

CREATE TABLE `report_complaint` (
  `complaint_id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `para_sa` varchar(250) NOT NULL,
  `blg` varchar(250) NOT NULL,
  `date_s` varchar(250) NOT NULL,
  `date_a` varchar(250) NOT NULL,
  `blotter_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_complaint`
--

INSERT INTO `report_complaint` (`complaint_id`, `content`, `para_sa`, `blg`, `date_s`, `date_a`, `blotter_id`, `barangay_id`, `date`) VALUES
(1, '1', '1', '1', '08/01/2023', '07/31/2023', 2, 454, '2023-08-01 01:24:35');

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
(1, 'All residents'),
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
  `house` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `image` varchar(50) NOT NULL,
  `is_alive` tinyint(1) NOT NULL DEFAULT 1,
  `date_recorded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `barangay_id`, `family_id`, `firstname`, `middlename`, `lastname`, `suffix`, `sex`, `birthdate`, `civil_status`, `contact`, `contact_type`, `height`, `weight`, `citizenship`, `religion`, `occupation_status`, `occupation`, `address`, `house`, `street`, `image`, `is_alive`, `date_recorded`) VALUES
(1000, 454, NULL, 'Julius', 'Quiason', 'Natividad', '', 'Male', '1990-01-11', 'Single', '09568111904', 'mobile', 166, 50, 'Filipino', 'Ang Dating Daan', 'Employed', 'Factory Worker', '4106 Luna Street Agus-Us', '', '', '64aca9e30c2b99.77909025.jpg', 0, '2023-07-30 16:03:14'),
(1001, 454, NULL, 'Clarence ', 'Rico', 'Galendez', '', 'Male', '2005-07-15', 'Single', '09759824875', 'mobile', 144, 49, '', 'Christian Catholic', 'Unemployed', 'Unemployed', '1007 Mabini Street Alulod', '', '', '64acab52ca0425.34657074.png', 1, '2023-07-30 15:28:38'),
(1002, 454, NULL, 'Ella Catalina  ', 'Parsaligan', 'Roxas', '', 'Female', '2018-05-09', 'Single', '09451247685', 'mobile', 40, 25, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '3105 Alulod Bridge Alulod', '', '', '64acaeac91e869.52741623.png', 0, '2023-07-30 16:04:19'),
(1003, 454, NULL, 'Felicita ', 'Tiu ', 'Lorete', '', 'Female', '1961-12-18', 'Married', '212456', 'tel', 152, 52, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '2102 Balagtas Street Bancod', '', '', '64acafb912e365.94910013.jpg', 1, '2023-07-30 15:29:19'),
(1004, 454, NULL, 'Megan Yasmin ', 'Sayco ', 'Estrella', '', 'Female', '1998-03-08', 'Married', '09712639654', 'mobile', 158, 58, 'Filipino', 'Christian Catholic', 'Employed Government', 'Teacher', '4110 Pajo Bridge Bukal', '', '', '64acb098683951.48018226.jpg', 1, '2023-07-30 15:29:19'),
(1005, 454, NULL, 'Tomas ', 'Quiason ', 'Asuncion', 'M.D.', 'Male', '1985-10-07', 'Married', '09413648745', 'mobile', 164, 55, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Doctor', '158 Saluysoy Bridge Mataas na Lupa', '', '', '64acb1b12a54d3.62946030.jfif', 1, '2023-07-30 15:29:19'),
(1006, 454, NULL, 'Preston ', 'Garcia ', 'Pamintuan', '', 'Male', '2010-04-14', 'Single', '09147855989', 'mobile', 140, 60, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '5201 R. Jeciel Street Banaba Lejos', '', '', '64acb25826d734.44770191.png', 1, '2023-07-30 15:28:38'),
(1007, 454, NULL, 'Tanya Elisa ', 'Angping ', 'Jugueta', '', 'Female', '1989-06-14', 'Legally Separated', '09413647785', 'mobile', 151, 54, 'Filipino', 'Christian Catholic', 'Employed', 'Factory Worker', '4210 Ilang-ilang Street Carasuchi', '', '', '64acb35a9a4882.35575368.png', 1, '2023-07-30 15:29:54'),
(1008, 454, NULL, 'Maeve Keila', ' Cosalan ', 'Gonzalez', '', 'Female', '2016-02-02', 'Single', '09515878563', 'mobile', 33, 25, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '145 Guyam Malaki Bonifacio Street', '', '', '64acb451543a36.64643825.png', 1, '2023-07-30 15:28:38'),
(1009, 454, NULL, 'Criston ', 'Diokno ', 'Romero', '', 'Male', '2007-08-03', 'Single', '09317426413', 'mobile', 149, 48, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '1420 Camia Street Bancod', '', '', '64acb56d92d3d7.36235938.jpg', 1, '2023-07-30 15:28:38'),
(1010, 454, NULL, 'Nicanor ', 'Abbas ', 'Rodriguez', 'Ltd.', 'Female', '1950-09-08', 'Widow', '09781357479', 'mobile', 172, 59, 'Filipino', 'Baptist', 'Unemployed', 'Unemployed', '112 San Francisco Javier Road Pulo', '', '', '64acb66705bef9.42203621.jpg', 1, '2023-07-30 15:30:09'),
(1011, 454, NULL, 'Carolyn ', 'Cawayan', ' Acosta', 'Ph.D.', 'Female', '1995-10-07', 'Married', '09451296857', 'mobile', 158, 59, 'Filipino', 'Baptist', 'Employed', 'Doctor', '1487 Mahabangkahoy Lejos Sampaguita Street', '', '', '64acb71831fad5.47801560.jfif', 1, '2023-07-30 15:29:19'),
(1012, 454, NULL, 'Judith Shaylee ', 'Ison ', 'Piñero', '', 'Female', '2019-07-11', 'Single', '09413587416', 'mobile', 39, 34, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '0121 H. Ilagan Street Tambo Ilaya', '', '', '64acb7c53155d5.21574046.png', 1, '2023-07-30 15:28:38'),
(1013, 454, NULL, 'Lora ', 'Calunod ', 'Prieto', '', 'Female', '2006-01-26', 'Single', '09815481365', 'mobile', 170, 62, 'Filipino', 'Iglesia Ni Kristo', 'Unemployed', 'Unemployed', '1523 Molave Street Kayquit I', '', '', '64acb863d412d9.09175853.png', 1, '2023-07-30 15:28:38'),
(1014, 454, NULL, 'Joselito ', 'Caris ', 'Miedes', 'Jr.', 'Male', '1959-06-05', 'Widow', '09871563148', 'mobile', 152, 48, 'Filipino', 'Born Again', 'Employed', 'Construction Worker', '4312 J. Dimabiling Kaytambog', '', '', '64acb92e1e3f85.26672294.jpg', 1, '2023-07-30 15:30:09'),
(1015, 454, NULL, 'Kody Serafin ', 'Tiamson ', 'Herrera', '', 'Male', '2011-08-25', 'Single', '09713659214', 'mobile', 81, 36, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '1453 Binambangan Street Kaytapos', '', '', '64acb9e68531b7.24888291.png', 1, '2023-07-30 15:28:38'),
(1016, 454, 49, 'Adan ', 'Limsin ', 'Villamar', '', 'Male', '2000-01-11', 'Married', '', 'mobile', 182, 65, 'Sri Lankan', 'O_Religion', 'Employed', 'Architect', '', 'Hohoho', '123 streetttttt', '64acbad74fda94.71361820.png', 1, '2023-08-11 04:28:18'),
(1017, 454, NULL, 'Emesto ', 'Kalim ', 'Dulay', '', 'Male', '2008-12-20', 'Single', '09214579536', 'mobile', 149, 49, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '1754 Rosal Street Tambo Ilaya', '', '', '64acbba43bd9c9.68446339.jpg', 1, '2023-07-30 15:28:38'),
(1018, 454, 53, 'Alexandrea ', 'Lauzon ', 'Gatus', '', 'Female', '1982-11-04', 'Single', '09411577946', 'mobile', 172, 55, 'Filipino', 'Born Again', 'Overseas Filipino Worker (OFW)', 'Domestic Helper', '5102 San Isidro Road Bancod', '', '', '64acbc20330da2.39220653.png', 1, '2023-08-08 13:58:43'),
(1019, 454, NULL, 'Cristobal ', 'Lapiz ', 'Caringal', '', 'Female', '1996-12-20', 'Married', '09124789526', 'mobile', 190, 65, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Call Center', '1502 Lakandula Street Daine I', '', '', '64acbd0bedbcb3.84924647.jpg', 1, '2023-07-30 15:29:19'),
(1021, 454, NULL, 'John', 'Smith', 'Doe', '', 'Male', '2000-09-29', 'Single', '', '', 0, 0, '', 'Born Again', 'Employed', 'Pizza Maker', 'Anahaw Street Alulod I Indang, Cavite', '', '', '64cdb5d0c79419.09141801.jpg', 0, '2023-08-05 02:37:04'),
(1100, 454, NULL, 'Juan', '', 'Santos', '', 'Male', '1990-07-18', 'Single', '', 'mobile', 154, 55, '', 'Born Again', 'Employed', 'Office Staff', 'Lot 45-A 4TH STREET Kayquit', '', '', '64acd1845e06e7.25724827.jpg', 1, '2023-07-30 15:28:38'),
(1101, 454, NULL, 'Maria', 'Carmer', 'Cruz', '', 'Female', '1991-12-03', 'Married', '09655536092', 'mobile', 130, 42, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', 'Lot 02-A Sampaguita Carasuchi', '', '', '64acd2ccb93dc1.95837646.jpg', 1, '2023-07-30 15:29:19'),
(1102, 454, NULL, 'Manuel', 'Emman', 'Reyes', '', 'Male', '1998-09-17', 'Single', '09546672312', 'mobile', 164, 55, 'Filipino', 'Baptist', 'Employed', 'Teacher', 'Lot 32-B Periwinkle Bucal 1', '', '', '64acd3ce68fd60.55623180.png', 1, '2023-07-30 15:28:38'),
(1103, 454, NULL, 'Ana', '', 'Dela Rosa', '', 'Female', '1995-06-22', 'Single', '09342256789', 'mobile', 145, 47, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Nurse', 'Lot 05-C Luna Street Kaytambog', '', '', '64acd44aca8d77.68450684.jpg', 1, '2023-07-30 15:28:38'),
(1104, 454, NULL, 'Eduardo ', 'Mehil', 'Fernandez', 'Sr.', 'Male', '1970-04-05', 'Married', '', 'no_contact', 156, 60, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', 'Lot 41-A Burgos Lane Calumpang Cerca I', '', '', '64acd4b6639972.82679436.jpg', 1, '2023-07-30 15:29:19'),
(1105, 454, NULL, 'Sofia', 'Cris', 'Garcia', '', 'Female', '2004-11-12', 'Single', '09456653421', 'mobile', 120, 32, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', 'Lot 02-D Del Pilar Street Alulod', '', '', '64acd52694ac45.46583097.png', 1, '2023-07-30 15:28:38'),
(1106, 454, NULL, 'Miguel', 'Felix', 'Hernandez', '', 'Male', '1992-03-28', 'Married', '09533385621', 'mobile', 156, 62, 'Filipino', 'Born Again', 'Employed', 'Pilot', 'Lot 22-A Aguinaldo Road Bucal II', '', '', '64acd58d25caf4.48443638.jpg', 1, '2023-07-30 15:29:19'),
(1107, 454, NULL, 'Gabriella ', '', 'Torres', '', 'Female', '1992-08-19', 'Single', '', 'no_contact', 147, 42, 'Filipino', 'Christian Catholic', 'Employed', 'Teacher', 'Lot 36-B Magdiwang Street Alulod', '', '', '64acd5f3deba18.43408366.jpg', 1, '2023-07-30 15:28:38'),
(1108, 454, NULL, 'Alejandro', 'Virgil', 'Ramirez', '', 'Male', '1965-08-08', 'Widow', '', 'no_contact', 165, 55, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Businessman', 'Lot 51-D Del Pilar Street Bucal II', '', '', '64acd680abe078.43409698.jpg', 1, '2023-07-30 15:30:09'),
(1109, 454, NULL, 'Isabella ', '', 'Lopez', '', 'Female', '2000-02-15', 'Single', '09778234591', 'mobile', 154, 52, 'Filipino', 'Baptist', 'Employed', 'Software Developer', 'Lot 15-A Malvar Street Carasuchi', '', '', '64acd6e6df5e01.64245852.jpg', 1, '2023-07-30 15:28:38'),
(1110, 454, NULL, 'Julia', 'Amor', 'Gonzales', '', 'Female', '1942-01-26', 'Widow', '', 'no_contact', 145, 44, 'Filipino', 'Ang Dating Daan', 'Unemployed', 'Unemployed', 'Lot 05-B Burgos Lane Mataas na Lupa', '', '', '64acd739a7a225.25433431.jpg', 1, '2023-07-30 15:30:09'),
(1111, 454, NULL, 'Carlos ', 'Mercader', 'Ceasar', '', 'Male', '1998-03-17', 'Single', '09686687788', 'mobile', 164, 55, 'Filipino', 'Christian Catholic', 'Employed', 'Photographer', 'Lot 07-C 1st Street Bucal II', '', '', '64acd7aec7d957.32329571.jpg', 1, '2023-07-30 15:28:38'),
(1112, 454, NULL, 'Andres', '', 'Santos', '', 'Male', '1996-08-03', 'Married', '09565578291', 'mobile', 158, 62, 'Filipino', 'Christian Catholic', 'Employed', 'Software Engineer', 'Lot 27-A 2nd Street Carasuchi', '', '', '64acd7fec78dd3.14100370.jpg', 1, '2023-07-30 15:29:19'),
(1113, 454, NULL, 'Camila', 'Aricayos ', 'Surio', '', 'Female', '2006-06-29', 'Single', '', 'no_contact', 126, 33, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', 'Lot 12-C 4th Street Bucal 1', '', '', '64acd869b7e8c5.10872630.png', 1, '2023-07-30 15:28:38'),
(1114, 454, NULL, 'Mateo', 'Demet ', 'Castro', 'Jr.', 'Male', '1994-07-26', 'Single', '', 'no_contact', 154, 83, 'Filipino', 'Islam', 'Employed Private', '', 'Lot 18-C Luna Street Calumpang Cerca I', '', '', '64acd8d6db9661.78265134.jpg', 1, '2023-07-30 15:28:38'),
(1115, 454, NULL, 'Camila ', '', 'Reyes', '', 'Female', '2000-07-18', 'Single', '09362487021', 'mobile', 132, 48, 'Filipino', 'Ang Dating Daan', 'Unemployed', 'Unemployed', 'Lot 06-C 1st Street Calumpang Cerca I', '', '', '64acd94dbe0c70.85758411.png', 1, '2023-07-30 15:28:38'),
(1116, 454, NULL, 'Rafela', 'Serphin', 'Aquino', '', 'Female', '1968-11-09', 'Married', '', 'no_contact', 147, 42, 'Filipino', 'Born Again', 'Employed', 'Teacher', 'Lot 31-D 4th Street Alulod', '', '', '64acd9f1de7e69.98950982.jpg', 1, '2023-07-30 15:29:19'),
(1117, 454, NULL, 'Bianca ', '', 'Santiago', '', 'Female', '2011-12-12', 'Single', '', 'no_contact', 124, 25, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', 'Lot 19-C 1st Street Alulod', '', '', '64acda8fc173e2.90292643.jpg', 1, '2023-07-30 15:28:38'),
(1118, 454, NULL, 'Gabriella ', '', 'Dominguez', '', 'Female', '1991-08-07', 'Single', '09682294582', 'mobile', 149, 42, 'Filipino', 'Born Again', 'Employed', 'HR Manager', 'Lot 32-D 3rd Street Calumpang Cerca I', '', '', '64acdaf0933251.60747045.png', 1, '2023-07-30 15:28:38'),
(1119, 454, NULL, 'Jovie', '', 'Mercado ', '', 'Male', '2001-06-12', 'Single', '09562278912', 'mobile', 150, 54, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', 'Lot 08-A 2nd Street Carasuchi', '', '', '64acdb971e5be9.33074952.png', 1, '2023-07-30 15:28:38'),
(1200, 454, NULL, 'Juan Miguel ', 'Uy', 'Castro', 'II', 'Male', '1997-12-07', 'Single', '09267586432', 'mobile', 170, 65, 'Filipino', 'Born Again', 'Overseas Filipino Worker (OFW)', '', '7788 G Laurente Mataas na Lupa', '', '', '64ace5f593ed52.29306865.jpg', 1, '2023-07-30 15:28:38'),
(1201, 454, NULL, 'Maria Cristina', 'Felix', 'Reyes', '', 'Female', '1994-03-25', 'Married', '09563250198', 'mobile', 160, 55, 'Filipino', 'Iglesia Ni Kristo', 'Employed', 'Nurse', '9767 Highland St. Mataas na Lupa', '', '', '64acf42418dfe0.12296154.jpg', 1, '2023-07-30 15:29:19'),
(1202, 454, NULL, 'Julia', 'Geronimo', 'Solares', '', 'Female', '2003-06-07', 'Single', '09275566592', 'mobile', 157, 53, 'Filipino', 'Born Again', 'Unemployed', 'Unemployed', '5463 Highland St. Mataas na Lupa', '', '', '64acf7deb86be9.75724089.jpg', 1, '2023-07-30 15:28:38'),
(1203, 454, NULL, 'Kyla', 'Macinas', 'Orense', '', 'Female', '2001-09-16', 'Single', '', 'no_contact', 160, 48, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '5624 Epifanio St Mataas na Lupa', '', '', '64acfce6291a71.36773903.jpg', 1, '2023-07-30 15:28:38'),
(1204, 454, NULL, 'Juaquin', 'Castro', 'Del Rosario', '', 'Male', '1999-04-05', 'Single', '', 'no_contact', 0, 0, 'Filipino', 'Iglesia Ni Kristo', 'Employed', '', '9809 Epifanio St Mataas na Lupa', '', '', '64acfd9c1334f5.69882799.jpg', 1, '2023-07-30 15:28:38'),
(1205, 454, NULL, 'Clark', 'Guzman', 'Landrito', '', 'Male', '1989-06-03', 'Single', '', 'no_contact', 163, 63, 'Filipino', 'Born Again', 'Self-Employed (SE)', 'Businessman', '3366 Highland St. Mataas na Lupa', '', '', '64acfec787b3b6.06978621.jpg', 1, '2023-07-30 15:28:38'),
(1206, 454, 51, 'Allysa', '', 'Taylor', '', 'Female', '1985-09-01', 'Single', '', '', 162, 52, 'Filipino', 'Born Again', 'Employed', 'Caster', '3368 Bagong Silang Mataas na Lupa', '', '', '64acff92a128c4.64311946.jpg', 1, '2023-08-05 05:59:42'),
(1207, 454, NULL, 'Benjamin', '', 'De Guzman', '', 'Male', '1952-07-05', 'Married', '', 'no_contact', 158, 52, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '659 G Laurente Mataas na Lupa', '', '', '64ad001160d872.82416762.jpg', 1, '2023-07-30 15:29:19'),
(1208, 454, NULL, 'Roberto', '', 'Sedano', '', 'Male', '1961-03-04', 'Married', '', '', 153, 48, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '1112 Epifanio St Mataas na Lupa', '', '', '64ad007d10c610.27205235.jpg', 1, '2023-07-30 15:29:19'),
(1209, 454, NULL, 'Rodel', 'Vasquez', 'Sonora', '', 'Male', '1973-02-09', 'Married', '09981542658', 'mobile', 154, 54, 'Filipino', 'Christian Catholic', 'Employed', '', '3233 G Laurente Mataas na Lupa', '', '', '64ad00f7dd0401.16313532.jpg', 1, '2023-07-30 15:29:19'),
(1210, 454, NULL, 'Evelyn', 'Melendres', 'Sedano', '', 'Female', '1978-03-03', 'Married', '', 'no_contact', 147, 46, '', 'Christian Catholic', 'Unemployed', 'Unemployed', '1112 Epifanio St Mataas na Lupa', '', '', '64ad01b1a6dd98.37458252.jpg', 1, '2023-07-30 15:29:19'),
(1211, 454, NULL, 'Gian', 'Yambao', 'Sobrevega', '', 'Male', '2007-12-18', 'Single', '', 'no_contact', 150, 43, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '6823 Pasong Saging Mataas na Lupa', '', '', '64ad02766b26a9.03500644.jpg', 1, '2023-07-30 15:28:38'),
(1212, 454, NULL, 'Mikayla', 'Rodiguez', 'Robles', '', 'Female', '2018-02-28', 'Single', '', 'no_contact', 0, 0, '', 'Born Again', 'Unemployed', 'Unemployed', '1212 Pasong Saging Mataas na Lupa', '', '', '64ad033a9882f8.44889838.jpg', 1, '2023-07-30 15:28:38'),
(1213, 454, NULL, 'Michelle', 'Rodiguez', 'Robles', '', 'Female', '1986-11-02', 'Married', '09274455492', 'mobile', 156, 49, 'Filipino', 'Born Again', 'Employed', 'Nurse', '1212 Bagong Silang Mataas na Lupa', '', '', '64ad03d464b4f2.99395533.jpg', 1, '2023-07-30 15:29:19'),
(1214, 454, NULL, 'Mikael', 'Uy', 'Robles', '', 'Male', '1985-02-12', 'Married', '', 'no_contact', 0, 0, 'Filipino', 'Born Again', 'Employed', 'Businessman', '1212 Pasong Saging Mataas na Lupa', '', '', '64ad04668e87f1.22089366.png', 1, '2023-07-30 15:29:19'),
(1215, 454, NULL, 'Allysa', '', 'Aloguin', '', 'Female', '2004-04-02', 'Single', '', 'no_contact', 162, 45, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '6733 G Laurente Mataas na Lupa', '', '', '64ad04e2241605.50898115.jpg', 1, '2023-07-30 15:28:38'),
(1216, 454, NULL, 'Janine', 'Rosales', 'Lee', '', 'Female', '1999-03-03', 'Single', '09981865611', 'mobile', 143, 43, 'Filipino', 'Christian Catholic', 'Employed Government', '', '6723 G Laurente Mataas na Lupa', '', '', '64ad058da1b6f2.19066974.jpg', 1, '2023-07-30 15:28:38'),
(1217, 454, NULL, 'Princess', '', 'Tayongtong', '', 'Female', '1989-01-31', 'Single', '', 'no_contact', 156, 48, 'Filipino', 'Christian Catholic', 'Employed Government', 'Teacher', '9867 Epifanio St Mataas na Lupa', '', '', '64ad05e1be4389.91011935.jpg', 1, '2023-07-30 15:28:38'),
(1218, 454, NULL, 'Joshua', 'Sales', 'Teofillo', 'III', 'Male', '1988-03-04', 'Single', '', 'no_contact', 165, 60, 'Filipino', 'Born Again', 'Employed', '', '1109 G Laurente Mataas na Lupa', '', '', '64ad0669178035.20668884.jpg', 1, '2023-07-30 15:28:38'),
(1219, 454, NULL, 'Kattlene', 'Hernandez', 'Fuentes', '', 'Female', '2000-08-04', 'Single', '', 'no_contact', 157, 42, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '4545 Pasong Saging Mataas na Lupa', '', '', '64ad0717a32e31.47626086.jpg', 1, '2023-07-30 15:28:38'),
(1300, 454, NULL, 'Juan', 'Carlos', 'Caballero', '', 'Male', '1960-07-04', 'Widow', '215962', 'tel', 154, 41, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', ' 50A Heidenreich Terrace Suite 293 Jose Panganiban 5943 Poblacion', '', '', '64ac16d0e27ba6.21300075.webp', 1, '2023-07-30 15:30:09'),
(1301, 454, NULL, 'Mónica', 'Ara', 'Gomez', '', 'Female', '1999-06-01', 'Single', '073004', 'tel', 135, 50, 'Filipino', 'Born Again', 'Employed', '', '00 Osinski Vista Apt. 222 Bacolod 527 Poblacion', '', '', '64ac17b037afe6.79085247.webp', 1, '2023-07-30 15:28:38'),
(1302, 454, NULL, 'Lucia', 'Paja', 'Delgado', '', 'Female', '1990-04-07', 'Married', '815777', 'tel', 133, 47, 'Filipino', 'Baptist', 'Employed Government', '', '00 Jast Brooks Suite 320 Panabo 1660 Alulod', '', '', '64ac18b90b4a20.65837426.webp', 1, '2023-07-30 15:29:19'),
(1303, 454, NULL, 'Alba', 'Perez', 'Sanz', '', 'Female', '1997-01-23', 'Single', '305230', 'tel', 149, 49, 'Austrian', 'Jehovah\'s Witness', 'Employed', '', '81 Cronin Ridges San Jose 4974  Poblacion', '', '', '64ac196c31a5f4.99586835.webp', 1, '2023-08-05 04:57:38'),
(1304, 454, NULL, 'Natalia', '', 'Guerrero', '', 'Female', '1985-09-23', 'Legally Separated', '151205', 'tel', 149, 55, 'Filipino', 'Jehovah\'s Witness', 'Employed', '', '98A/14 Jenkins Roads Naval 7672 Kayquit I', '', '', '64ac1a3d5bb834.37826238.webp', 1, '2023-07-30 15:29:54'),
(1305, 454, NULL, 'Olga', '', 'Calvo', '', 'Female', '1995-08-03', 'Married', '700888', 'tel', 148, 48, 'Filipino', 'Ang Dating Daan', 'Employed', '', '37 Wiza Skyway Apt. 592 Lamitan 2406 Harasan', '', '', '64ac1ad2cd11e1.62205983.webp', 1, '2023-07-30 15:29:19'),
(1306, 454, NULL, 'Santiago', '', 'Castro ', '', 'Male', '1994-06-26', 'Married', '121608', 'tel', 170, 65, 'Filipino', 'Christian Catholic', 'Employed', '', '47A Labadie Island Suite 435 Manjuyod 5210 Kayquit II', '', '', '64ac1b37a05f75.01568464.webp', 1, '2023-07-30 15:29:19'),
(1307, 454, NULL, 'María', 'Rosario', 'Velasco', '', 'Female', '1991-05-25', 'Married', '100844', 'tel', 138, 42, 'Filipino', 'Baptist', 'Employed', '', '93A Walsh Canyon Apt. 875 Santa Maria 7564 Alulod', '', '', '64ac1baf673d64.67357377.webp', 1, '2023-07-30 15:29:19'),
(1308, 454, NULL, 'María', 'Soledad', 'Fuentes', '', 'Female', '1991-08-08', 'Married', '531697', 'tel', 149, 69, 'Filipino', 'Buddhism', 'Employed', '', '15A Hyatt Forest Biñan 0133 Poblacion', '', '', '64ac1c2d7cab96.79161797.webp', 1, '2023-07-30 15:29:19'),
(1309, 454, NULL, 'Joaquin', '', 'Gonzalez', '', 'Male', '1995-07-07', 'Single', '071168', 'tel', 180, 70, 'Filipino', 'Iglesia Ni Kristo', 'Employed Government', '', '19A/45 Terry Stravenue Apt. 332 Kawayan 8727  Harasan', '', '', '64ac1c9a82a353.50562544.webp', 1, '2023-07-30 15:28:38'),
(1310, 454, NULL, 'María ', 'Luisa', 'Gallego', '', 'Female', '1992-09-12', 'Married', '175639', 'tel', 160, 60, 'Filipino', 'Seventh Day Adventist', 'Employed', '', '10A Hodkiewicz Corner Guihulngan 2882 Poblacion', '', '', '64ac1d5c29eb77.40457013.webp', 1, '2023-07-30 15:29:19'),
(1311, 454, NULL, 'Paula ', '', 'Fernandez', '', 'Female', '1992-12-12', 'Married', '239191', 'tel', 0, 0, 'Filipino', 'Born Again', 'Employed', '', '39/90 Pfeffer Trace Suite 846 Bauang 6099 Alulod', '', '', '64ac1dd2ee3288.69951577.webp', 1, '2023-07-30 15:29:19'),
(1312, 454, NULL, 'Manuela', '', ' Herrera ', '', 'Female', '1993-12-11', 'Married', '', 'tel', 0, 0, 'Filipino', 'Jehovah\'s Witness', 'Employed Government', '', '17/84 Nitzsche Stravenue Apt. 920 Masiu 7573  Bancod', '', '', '64ac1e343e1c07.76681375.webp', 1, '2023-07-30 15:29:19'),
(1313, 454, NULL, 'María ', 'José', 'Rodriguez', '', 'Female', '1990-10-25', 'Single', '', 'tel', 0, 0, 'Filipino', 'Baptist', 'Self-Employed (SE)', '', '34/66 Bayer Fall Cevu 2329 Kaytapos', '', '', '64ac1eb609fcc5.59651703.webp', 1, '2023-07-30 15:28:38'),
(1314, 454, NULL, 'Patricia', '', 'Medina', '', 'Female', '2004-08-21', 'Single', '', 'mobile', 145, 47, 'Filipino', 'Christian Catholic', 'Employed', '', '41 Cronin Cape Apt. 839 Lianga 8378  Harasan', '', '', '64ac1f941fc3c5.07851989.webp', 1, '2023-07-30 15:28:38'),
(1315, 454, NULL, 'María', 'Carmen', 'Rodriguez ', '', 'Female', '1990-03-21', 'Married', '', '', 0, 0, 'Filipino', 'Born Again', 'Employed Government', '', '61 Bechtelar Valley Kapangan 6353  Kayquit II', '', '', '64ac1fdd726bb7.90034115.webp', 1, '2023-07-30 15:29:19'),
(1316, 454, NULL, 'Hugo', '', 'Lorenzo', '', 'Male', '2001-11-07', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Employed', '', '90A/42 Waelchi Run  La Carlota 9520 Poblacion', '', '', '64ac206099be71.63838961.webp', 1, '2023-07-30 15:28:38'),
(1317, 454, NULL, 'Xavier', '', 'Pastor', '', 'Male', '2005-02-14', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '61 Wisoky Hollow Apt. 637 Makato 5437  Bancod', '', '', '64ac20b0e6f259.94425558.webp', 1, '2023-07-30 15:28:38'),
(1318, 454, NULL, 'María ', 'Soledad', 'Martin', '', 'Female', '1999-11-11', 'Single', '', '', 0, 0, 'Filipino', 'Born Again', 'Employed Government', '', '44 Moore Ramp Suite 922  Tanauan 0276 Kaytapos', '', '', '64ac21195a07b2.12718010.webp', 1, '2023-07-30 15:28:38'),
(1319, 454, NULL, 'Elena', '', 'Muñoz ', '', 'Female', '1991-06-27', 'Married', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Employed', '', '18A/14 Prosacco Trail, Poblacion 9863 Poblacion', '', '', '64ac21ae3d1c77.76556349.webp', 1, '2023-07-30 15:29:19'),
(1329, 454, 52, 'Jeffrey', 'Villamor', 'Nuñez', 'USN', 'Male', '2000-09-29', 'Single', '', 'no_contact', 165, 50, 'Filipino', 'Ang Dating Daan', 'Employed Private', 'sana ol', '', '123 House', 'Ayala Avenue Bldg.', '64ce7b77d31ad5.92967707.jpg', 1, '2023-08-11 04:59:47'),
(1379, 454, NULL, 'Baby', '', 'Josh', '', 'Male', '2020-08-13', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '', '123 House', 'Ayala Avenue Bldg.', '64d9d867136628.03794567.jpg', 1, '2023-08-14 08:02:16'),
(1380, 454, NULL, 'Joshua', '', 'Ponciano', '', 'Male', '2000-02-09', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '', '123 House', 'Ayala Avenue Bldg.', '64d9edbe721682.78768865.jpg', 1, '2023-08-14 09:04:22'),
(1381, 454, NULL, 'Jeff', '', 'Spike', '', 'Male', '2000-09-29', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '', '123 House', 'Ayala Avenue Bldg.', '64da25825ed8f5.07479336.jpg', 1, '2023-08-14 13:00:50'),
(1387, 454, NULL, 'Jeep', '', 'Newborn', '', 'Male', '2021-09-29', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', 'Unemployed', '', '123 House', 'Ayala Avenue Bldg.', '64da2cc3d28488.72238250.jpg', 1, '2023-08-14 13:31:47'),
(1389, 454, NULL, 'Adrean', '', 'Madrio', '', 'Male', '2000-09-29', 'Single', '', '', 0, 0, 'Filipino', 'Christian Catholic', 'Unemployed', '', '', '123 House', 'Ayala Avenue Bldg.', '', 1, '2023-08-14 14:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `resident_family`
--

CREATE TABLE `resident_family` (
  `family_id` int(11) NOT NULL,
  `father_id` int(11) DEFAULT NULL,
  `mother_id` int(11) DEFAULT NULL,
  `non_resident_mother` tinyint(4) NOT NULL DEFAULT 0,
  `non_resident_father` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident_family`
--

INSERT INTO `resident_family` (`family_id`, `father_id`, `mother_id`, `non_resident_mother`, `non_resident_father`) VALUES
(49, 1300, NULL, 1, 0),
(51, 1317, 1319, 0, 0),
(52, NULL, NULL, 1, 1),
(53, 1102, 1013, 0, 0),
(54, 1009, 1003, 0, 0);

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
  `vaccine_name` varchar(100) NOT NULL,
  `vaccine_dose` varchar(250) NOT NULL,
  `vaccine_type` varchar(50) NOT NULL,
  `vaccine_date` date DEFAULT NULL,
  `vaccine_place` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccine_id`, `id_resident`, `vaccineInvID`, `vaccine_name`, `vaccine_dose`, `vaccine_type`, `vaccine_date`, `vaccine_place`) VALUES
(13, 1001, 0, 'Sample Vaxxx', '2nd Dose', '', '2023-07-31', 'Imus'),
(14, 1003, 7, '', '1st Dose', '', '2023-08-13', 'Imus');

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
(7, 454, 'Vaxxx', 4, '2023-09-09', 'Available', 'vax');

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
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`death_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  ADD PRIMARY KEY (`newborn_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `hns_newborn_history`
--
ALTER TABLE `hns_newborn_history`
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
  ADD PRIMARY KEY (`clearance_id`),
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
  ADD PRIMARY KEY (`non_resident_id`),
  ADD KEY `incident_id` (`incident_id`);

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
-- Indexes for table `pregnant_history`
--
ALTER TABLE `pregnant_history`
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
-- Indexes for table `report_complaint`
--
ALTER TABLE `report_complaint`
  ADD PRIMARY KEY (`complaint_id`);

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
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=487;

--
-- AUTO_INCREMENT for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `clearance`
--
ALTER TABLE `clearance`
  MODIFY `clearance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `death`
--
ALTER TABLE `death`
  MODIFY `death_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  MODIFY `newborn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `hns_newborn_history`
--
ALTER TABLE `hns_newborn_history`
  MODIFY `newborn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  MODIFY `complainant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incident_offender`
--
ALTER TABLE `incident_offender`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medicine_distribution`
--
ALTER TABLE `medicine_distribution`
  MODIFY `distrib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `medicine_inventory`
--
ALTER TABLE `medicine_inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `new_clearance`
--
ALTER TABLE `new_clearance`
  MODIFY `clearance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `new_finance`
--
ALTER TABLE `new_finance`
  MODIFY `financeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `non_resident`
--
ALTER TABLE `non_resident`
  MODIFY `non_resident_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `official_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `past_officials`
--
ALTER TABLE `past_officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pregnant`
--
ALTER TABLE `pregnant`
  MODIFY `pregnant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pregnant_history`
--
ALTER TABLE `pregnant_history`
  MODIFY `pregnant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `report_accomplishment`
--
ALTER TABLE `report_accomplishment`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_certificate`
--
ALTER TABLE `report_certificate`
  MODIFY `cert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_cleanup`
--
ALTER TABLE `report_cleanup`
  MODIFY `mcu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_cleanup_nstep`
--
ALTER TABLE `report_cleanup_nstep`
  MODIFY `nstep_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_complaint`
--
ALTER TABLE `report_complaint`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_personnel`
--
ALTER TABLE `report_personnel`
  MODIFY `perAtt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_personnel_list`
--
ALTER TABLE `report_personnel_list`
  MODIFY `pam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report_resident`
--
ALTER TABLE `report_resident`
  MODIFY `rres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1390;

--
-- AUTO_INCREMENT for table `resident_family`
--
ALTER TABLE `resident_family`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `vaccine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vaccine_inventory`
--
ALTER TABLE `vaccine_inventory`
  MODIFY `vaccineInventoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
-- Constraints for table `death`
--
ALTER TABLE `death`
  ADD CONSTRAINT `death_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hns_newborn`
--
ALTER TABLE `hns_newborn`
  ADD CONSTRAINT `hns_newborn_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hns_newborn_history`
--
ALTER TABLE `hns_newborn_history`
  ADD CONSTRAINT `hns_newborn_history_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incident_complainant`
--
ALTER TABLE `incident_complainant`
  ADD CONSTRAINT `incident_complainant_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incident_complainant_ibfk_2` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incident_complainant_ibfk_3` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `new_clearance`
--
ALTER TABLE `new_clearance`
  ADD CONSTRAINT `new_clearance_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `non_resident`
--
ALTER TABLE `non_resident`
  ADD CONSTRAINT `fk_incident_id_nonres` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `pregnant_history`
--
ALTER TABLE `pregnant_history`
  ADD CONSTRAINT `pregnant_history_ibfk_1` FOREIGN KEY (`id_resident`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `special_project`
--
ALTER TABLE `special_project`
  ADD CONSTRAINT `special_project_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD CONSTRAINT `vaccine_ibfk_1` FOREIGN KEY (`id_resident`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
