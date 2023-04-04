-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2023 at 10:04 AM
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
  `resident_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `resident_id`, `username`, `password`, `position`) VALUES
(3, 17, 'jeep123', '$2y$10$wzvJvxfbdlFqK7B2G8yz.OUnFfqPE2J/GzcNzVejXytRrQOb57jra', 'Barangay Secretary');

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
(410, 'do not delete this', '123 Jeepney Indang, Cavite', '63f86f002b8921.23439519.png', 'indang.gov.ph/do-not-delete-this', 1);

-- --------------------------------------------------------

--
-- Table structure for table `incident_offender1`
--

CREATE TABLE `incident_offender1` (
  `offender_id` int(11) NOT NULL,
  `offender_name` varchar(255) NOT NULL,
  `offender_gender` varchar(6) NOT NULL,
  `offender_address` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `complainant_type_id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_offender1`
--

INSERT INTO `incident_offender1` (`offender_id`, `offender_name`, `offender_gender`, `offender_address`, `description`, `complainant_type_id`, `incident_id`) VALUES
(1, 'Josh', 'male', 'carissa, bagtas, tanza, cavite', '          1111  ', 0, 0),
(2, 'Josh', 'male', 'carissa, bagtas, tanza, cavite', '          1111  ', 0, 0),
(3, 'Josh', 'male', 'carissa, bagtas, tanza, cavite', '           wwwwww ', 0, 0),
(4, 'Josh', 'male', 'carissa, bagtas, tanza, cavite', '           wwwwww ', 0, 0),
(5, 'Josh', 'Gender', 'trece', '            ', 0, 0),
(6, 'Pedro', 'male', 'trece', '    maputi at matangkad        ', 0, 0),
(7, 'Josh', 'male', 'carissa, bagtas, tanza, cavite', '         qqqqq   ', 0, 0),
(8, ' Josh Ponciano', 'male', 'trece, cavite', '    lagi nagkukwento sa politika        ', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `incident_reporting_person`
--

CREATE TABLE `incident_reporting_person` (
  `person_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `phone_number` varchar(13) NOT NULL,
  `address` varchar(255) NOT NULL,
  `complainantType_id` int(11) NOT NULL,
  `incident` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_reporting_person`
--

INSERT INTO `incident_reporting_person` (`person_id`, `name`, `gender`, `phone_number`, `address`, `complainantType_id`, `incident`) VALUES
(1, '', '', '', '', 0, 0),
(2, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(3, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(4, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(5, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(6, 'Jose', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(7, 'Adrean', 'Gender', '096363575', 'carissa, bagtas, tanza, cavite', 0, 0),
(8, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(9, 'Adrean', 'male', '111', 'carissa, bagtas, tanza, cavite', 0, 0),
(10, 'Adrean', 'male', '09636353575', 'carissa, bagtas, tanza, cavite', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `incident_table`
--

CREATE TABLE `incident_table` (
  `incident_id` int(11) NOT NULL,
  `case_incident` varchar(250) NOT NULL,
  `incident_title` varchar(250) NOT NULL,
  `date_incident` date NOT NULL,
  `time_incident` time NOT NULL,
  `location` varchar(250) NOT NULL,
  `narrative` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `blotterType_id` int(11) NOT NULL,
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `offender_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `complainantType_id` int(11) NOT NULL,
  `involve_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incident_table`
--

INSERT INTO `incident_table` (`incident_id`, `case_incident`, `incident_title`, `date_incident`, `time_incident`, `location`, `narrative`, `status`, `blotterType_id`, `date_reported`, `offender_id`, `person_id`, `complainantType_id`, `involve_id`) VALUES
(37, 'criminal', 'www', '2023-02-14', '19:30:00', 'wwww', '      di parin nag babayad ng utang          ', 0, 0, '2023-04-01 11:27:10', 4, 6, 0, 1),
(39, 'criminal', 'Lover quarrel', '2023-02-14', '00:16:00', 'Bagtas', '    nag away ang kabit           ', 0, 0, '2023-04-01 11:27:15', 6, 8, 0, 1),
(40, 'civil', 'qqqq', '2023-02-14', '13:44:00', 'qqqq', '       qqqq         ', 0, 0, '2023-04-01 11:27:20', 7, 9, 0, 1),
(41, 'criminal', '123 sa jeep', '2023-02-14', '18:00:00', 'babaan ng Trece', '     Di nagbayad sa jeep na sinakyan namin papuntang school           ', 0, 0, '2023-04-01 11:27:23', 8, 10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `date_appointed` date NOT NULL,
  `date_ended` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resident`
--

CREATE TABLE `resident` (
  `resident_id` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
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
  `religion` varchar(50) NOT NULL,
  `occupation_status` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resident`
--

INSERT INTO `resident` (`resident_id`, `barangay_id`, `firstname`, `middlename`, `lastname`, `suffix`, `sex`, `birthdate`, `age`, `civil_status`, `contact`, `contact_type`, `height`, `weight`, `religion`, `occupation_status`, `occupation`, `address`, `image`) VALUES
(17, 410, 'Jeffrey', 'Villamor', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 160, 70, 'Christian Catholic', 'Unemployed', '', '123 Hahaha Poblacion', '6402c8a1d940d4.27808512.png'),
(19, 410, 'Adrean', 'Barurot', 'Madrio', '', 'Male', '2000-02-28', 12, 'single', '', 'mobile', 170, 170, 'Born Again', 'Unemployed', '', '123 Bagtas Bagtas', '63ff24384f6d32.13857671.png'),
(20, 410, 'Jeep', 'Villa', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 165, 70, 'Seventh Day Adventist', 'Unemployed', '', '123 Sitio Pulo Kalokohan', '63ff240cbd6f53.78912086.png'),
(21, 410, 'Rev Ed', 'Tigang', 'Sales', '', 'Male', '2023-01-01', 0, 'single', '', 'no_contact', 123, 123, 'Christian Catholic', 'Unemployed', '', '123 456 yoyo', '63ff29d52ae238.19457172.jpg'),
(22, 410, 'Jeffrey', 'Villamor', 'Nuñez', '', 'Male', '2000-09-29', 22, 'single', '', 'no_contact', 165, 70, 'Christian Catholic', 'Unemployed', '', '123 Mahalay Street Poblacion 1', '64015c1b54c731.54117511.jpg'),
(23, 410, 'Ripped', 'Rev', 'Sales', '', 'Male', '2000-01-01', 23, 'single', '', 'tel', 165, 70, 'Christian Catholic', 'Unemployed', '', '123 Bagtas Poblacion 1', '6425913f2a8de3.82572586.png');

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
(1, 6997, 'admin', 'admin', '$2y$10$CAKk2STuck2u0ScxGLxHpeKi65Id2VBSL.6isFdFVhoPCq1E1FWm2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `resident_id` (`resident_id`);

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `incident_offender1`
--
ALTER TABLE `incident_offender1`
  ADD PRIMARY KEY (`offender_id`),
  ADD KEY `incident_id` (`incident_id`);

--
-- Indexes for table `incident_reporting_person`
--
ALTER TABLE `incident_reporting_person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `incident_table`
--
ALTER TABLE `incident_table`
  ADD PRIMARY KEY (`incident_id`),
  ADD KEY `offender_id` (`offender_id`),
  ADD KEY `person_id` (`person_id`),
  ADD KEY `involve_id` (`involve_id`);

--
-- Indexes for table `resident`
--
ALTER TABLE `resident`
  ADD PRIMARY KEY (`resident_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- Indexes for table `super_accounts`
--
ALTER TABLE `super_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=438;

--
-- AUTO_INCREMENT for table `incident_offender1`
--
ALTER TABLE `incident_offender1`
  MODIFY `offender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `incident_reporting_person`
--
ALTER TABLE `incident_reporting_person`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `incident_table`
--
ALTER TABLE `incident_table`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `resident`
--
ALTER TABLE `resident`
  MODIFY `resident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `super_accounts`
--
ALTER TABLE `super_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `incident_table`
--
ALTER TABLE `incident_table`
  ADD CONSTRAINT `incident_table_ibfk_1` FOREIGN KEY (`offender_id`) REFERENCES `incident_offender1` (`offender_id`),
  ADD CONSTRAINT `incident_table_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `incident_reporting_person` (`person_id`);

--
-- Constraints for table `resident`
--
ALTER TABLE `resident`
  ADD CONSTRAINT `resident_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
