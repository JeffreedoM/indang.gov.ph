-- MariaDB dump 10.19  Distrib 10.4.19-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bmis
-- ------------------------------------------------------
-- Server version	10.4.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (1,'Accomplishment Report'),(2,'Certificate of Validation'),(3,'Monthly Clean-up'),(4,'Personal Attendance Monitoring');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_accomplishment`
--

DROP TABLE IF EXISTS `report_accomplishment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_accomplishment` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_name` varchar(100) NOT NULL,
  `acc_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `acc_content` mediumtext NOT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_accomplishment`
--

LOCK TABLES `report_accomplishment` WRITE;
/*!40000 ALTER TABLE `report_accomplishment` DISABLE KEYS */;
INSERT INTO `report_accomplishment` VALUES (4,'Accomplishment Report','2023-04-21 13:23:50','www'),(5,'Accomplishment Report','2023-04-27 12:10:48','ako si Jeffrey');
/*!40000 ALTER TABLE `report_accomplishment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_certificate`
--

DROP TABLE IF EXISTS `report_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_certificate` (
  `cert_id` int(11) NOT NULL AUTO_INCREMENT,
  `cert_name` varchar(255) NOT NULL,
  `cert_month` varchar(255) NOT NULL,
  `cert_year` year(4) NOT NULL,
  `cert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_certificate`
--

LOCK TABLES `report_certificate` WRITE;
/*!40000 ALTER TABLE `report_certificate` DISABLE KEYS */;
INSERT INTO `report_certificate` VALUES (1,'Certificate Of Validation','January',2020,'2023-04-21 11:51:49'),(3,'Certificate Of Validation','February',2023,'2023-04-26 08:54:56'),(4,'Certificate Of Validation','January',2020,'2023-04-27 12:11:36'),(5,'Certificate Of Validation','',0000,'2023-04-28 03:04:36');
/*!40000 ALTER TABLE `report_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_personnel`
--

DROP TABLE IF EXISTS `report_personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_personnel` (
  `perAtt_id` int(11) NOT NULL AUTO_INCREMENT,
  `nonComp_name` varchar(255) NOT NULL,
  `nonComp_absent` varchar(255) NOT NULL,
  `nonComp_tardy` varchar(255) NOT NULL,
  `station` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `pam_id` int(11) NOT NULL,
  PRIMARY KEY (`perAtt_id`),
  KEY `pam_id` (`pam_id`),
  CONSTRAINT `fk_pam_id` FOREIGN KEY (`pam_id`) REFERENCES `report_personnel_list` (`pam_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel`
--

LOCK TABLES `report_personnel` WRITE;
/*!40000 ALTER TABLE `report_personnel` DISABLE KEYS */;
INSERT INTO `report_personnel` VALUES (39,'adrean','2','3','tanza','tanod',16),(40,'jeff','3','4','tanza','capitan',16),(41,'gian','4','5','tanza','office worker',16),(42,'Adrean','2','3','building 2','tanod',17);
/*!40000 ALTER TABLE `report_personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_personnel_list`
--

DROP TABLE IF EXISTS `report_personnel_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_personnel_list` (
  `pam_id` int(11) NOT NULL AUTO_INCREMENT,
  `pam_title` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `n_name` varchar(255) NOT NULL,
  `quarter` varchar(100) NOT NULL,
  PRIMARY KEY (`pam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel_list`
--

LOCK TABLES `report_personnel_list` WRITE;
/*!40000 ALTER TABLE `report_personnel_list` DISABLE KEYS */;
INSERT INTO `report_personnel_list` VALUES (16,'Personal Attendance Monitoring','2023-04-24 03:14:34','Rev Sales','4th'),(17,'Personal Attendance Monitoring','2023-04-28 03:22:47','Rev Sales','2nd');
/*!40000 ALTER TABLE `report_personnel_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_resident`
--

DROP TABLE IF EXISTS `report_resident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_resident` (
  `rres_id` int(11) NOT NULL AUTO_INCREMENT,
  `rres_category` varchar(100) NOT NULL,
  PRIMARY KEY (`rres_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_resident`
--

LOCK TABLES `report_resident` WRITE;
/*!40000 ALTER TABLE `report_resident` DISABLE KEYS */;
INSERT INTO `report_resident` VALUES (1,'All resident'),(2,'Adult'),(3,'Employed'),(4,'Female'),(5,'Infant'),(6,'Male'),(7,'Minor'),(8,'Pregnant'),(9,'Senior'),(10,'Teenager'),(11,'Unemployed'),(12,'Death');
/*!40000 ALTER TABLE `report_resident` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-29  9:37:25
