-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2023 at 11:42 AM
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
  `password` varchar(255) NOT NULL,
  `default_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `official_id`, `allowed_modules`, `username`, `password`, `default_password`) VALUES
(76, 50, '[]', 'john123', '$2y$10$V9FP2b/nCoWfOddWbFyu2OLNiJxq368D85hfRdXvxMbqyLzjFs4.a', 'john456');

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
(457, 'Barangay', 'Barangay Indang, Cavite', '64bf7160430384.55102444.png', 'indang.gov.ph/barangay', 1);

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
(29, 457, '', '', '', '', '');

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

-- --------------------------------------------------------

--
-- Table structure for table `hns_newborn`
--

CREATE TABLE `hns_newborn` (
  `newborn_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `status` tinyint(4) NOT NULL COMMENT '1 - Mediated,\r\n2 - Dismiss,\r\n3 - Certified 4a',
  `narrative` mediumtext NOT NULL,
  `blotterType_id` tinyint(4) NOT NULL COMMENT '1-Complainant, 2-Incident',
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `barangay_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `new_clearance`
--

CREATE TABLE `new_clearance` (
  `clearance_id` int(11) NOT NULL,
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

INSERT INTO `new_clearance` (`clearance_id`, `resident_id`, `barangay_id`, `form_request`, `amount`, `purpose`, `finance_date`, `date_string`, `status`) VALUES
(24, 1021, 457, 'Barangay Business Clearance', 100, '123', '2023-07-26', 'July 26, 2023 11:14 AM', 'Pending'),
(25, 1021, 457, 'Barangay Business Clearance', 100, 'For work', '2023-07-26', 'July 26, 2023 1:26 PM', 'Paid'),
(26, 1021, 457, 'Barangay Business Clearance', 100, 'For work', '2023-07-26', 'July 26, 2023 1:27 PM', 'Paid'),
(27, 1021, 457, 'Barangay Clearance', 100, 'For work', '2023-07-26', 'July 26, 2023 1:27 PM', 'Paid'),
(28, 1021, 457, 'Certificate of Good Moral Character', 100, 'school', '2023-07-26', 'July 26, 2023 2:00 PM', 'Paid'),
(29, 1021, 457, 'Certificate of Good Moral Character', 100, 'work', '2023-07-26', 'July 26, 2023 2:44 PM', 'Paid'),
(30, 1021, 457, 'Certificate of Indigency', 100, 'All Purpose cream', '2023-07-26', 'July 26, 2023 3:34 PM', 'Paid'),
(31, 1021, 457, 'Certificate of Residency', 100, 'All Purpose Cream', '2023-07-26', 'July 26, 2023 3:57 PM', 'Paid'),
(32, 1021, 457, 'Barangay Business Clearance', 100, 'porpos', '2023-07-26', 'July 26, 2023 4:49 PM', 'Paid');

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
(9, 410, 'Jeep Villa Nuñez                                    ', '2023-07-13', '232.00', 'asdasdas', 'Test', '', '0.00', '0.00', '0.00', NULL, NULL, 'collection', NULL, '', '', '0.00'),
(11, 410, '', '0000-00-00', '0.00', NULL, 'Nothing', 'Basketball Adult K', '1000.00', '1000.00', '1000.00', '2023-07-02', '2023-07-30', 'expenses', NULL, '', '', '0.00'),
(13, 410, 'Jeffrey Villamor Nuñez                                    ', '2023-07-20', '5667.00', 'fjhfhgh', '', '', '0.00', '0.00', '0.00', NULL, NULL, 'collection', NULL, '', '', '0.00'),
(14, 410, '', '0000-00-00', '0.00', NULL, 'lahsd', '', '0.00', '0.00', '0.00', NULL, NULL, 'deposit', '2023-07-18', 'BDI', '2329DSSD', '343.00'),
(16, 410, 'Jeep Villa Nuñez                                    ', '2023-07-26', '123.45', 'gmjhh', '', '', '0.00', '0.00', '0.00', NULL, NULL, 'collection', NULL, '', '', '0.00'),
(17, 410, '', '0000-00-00', '0.00', NULL, '', '', '0.00', '0.00', '0.00', NULL, NULL, 'deposit', '2023-07-26', 'Cebuana', '12FJG3456KJ', '100.99'),
(18, 410, '', '0000-00-00', '0.00', NULL, '', 'Cheerdancing', '999.44', '343.34', '556.43', '2023-08-01', '2023-09-01', 'expenses', NULL, '', '', '0.00');

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
(50, 1021, 'Barangay Secretary', '0000-00-00', '0000-00-00');

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
  `pregnant_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1021, 457, NULL, 'John', 'Smith', 'Doe', '', '', '2000-09-29', 22, '', '', '', 0, 0, '', '', '', '', 'Anahaw Street Alulod I Indang, Cavite', '', 1, '2023-07-26 06:20:06');

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
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=458;

--
-- AUTO_INCREMENT for table `barangay_configuration`
--
ALTER TABLE `barangay_configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `complainant_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_offender`
--
ALTER TABLE `incident_offender`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `clearance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `new_finance`
--
ALTER TABLE `new_finance`
  MODIFY `financeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `non_resident`
--
ALTER TABLE `non_resident`
  MODIFY `non_resident_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `official_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1022;

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
