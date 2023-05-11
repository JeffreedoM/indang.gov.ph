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
-- Table structure for table `incident_table`
--

DROP TABLE IF EXISTS `incident_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_table` (
  `incident_id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_title` varchar(250) NOT NULL,
  `case_incident` int(100) NOT NULL,
  `date_incident` date NOT NULL,
  `time_incident` time NOT NULL,
  `location` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `narrative` mediumtext NOT NULL,
  `blotterType_id` int(11) NOT NULL,
  `date_reported` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`incident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_table`
--

LOCK TABLES `incident_table` WRITE;
/*!40000 ALTER TABLE `incident_table` DISABLE KEYS */;
INSERT INTO `incident_table` VALUES (9,'Dahil sa pagibig222',0,'2023-05-11','14:26:00','222222','1','222222',1,'2023-05-11 06:26:17'),(10,'Dahil sa pagibig222',0,'2023-05-11','14:26:00','222222','1','222222',1,'2023-05-11 06:26:21'),(11,'Dahil sa pagibig222',0,'2023-05-11','14:26:00','222222','1','222222',1,'2023-05-11 06:31:36');
/*!40000 ALTER TABLE `incident_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_offender`
--

DROP TABLE IF EXISTS `incident_offender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_offender` (
  `offender_id` int(11) NOT NULL AUTO_INCREMENT,
  `offender_type` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `incident_id` int(11) NOT NULL,
  `non_resident_id` int(11) DEFAULT NULL,
  `desc` mediumtext NOT NULL,
  PRIMARY KEY (`offender_id`),
  KEY `incident_id` (`incident_id`),
  KEY `resident_id` (`resident_id`),
  KEY `non_resident_id` (`non_resident_id`),
  CONSTRAINT `fk_incident_id` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nonres_id` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_res_id` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_offender`
--

LOCK TABLES `incident_offender` WRITE;
/*!40000 ALTER TABLE `incident_offender` DISABLE KEYS */;
INSERT INTO `incident_offender` VALUES (7,'not resident',NULL,9,13,'wwww'),(8,'not resident',NULL,10,15,'wwww'),(9,'not resident',NULL,11,17,'wwww');
/*!40000 ALTER TABLE `incident_offender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_complainant`
--

DROP TABLE IF EXISTS `incident_complainant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_complainant` (
  `complainant_id` int(11) NOT NULL AUTO_INCREMENT,
  `complainant_type` varchar(250) NOT NULL,
  `resident_id` int(11) DEFAULT NULL,
  `non_resident_id` int(11) DEFAULT NULL,
  `incident_id` int(11) NOT NULL,
  PRIMARY KEY (`complainant_id`),
  KEY `incident_id` (`incident_id`),
  KEY `non_resident_id` (`non_resident_id`),
  KEY `resident_id` (`resident_id`),
  CONSTRAINT `fk_incident2_id` FOREIGN KEY (`incident_id`) REFERENCES `incident_table` (`incident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nonres2_id` FOREIGN KEY (`non_resident_id`) REFERENCES `non_resident` (`non_resident_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_res2_id` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_complainant`
--

LOCK TABLES `incident_complainant` WRITE;
/*!40000 ALTER TABLE `incident_complainant` DISABLE KEYS */;
INSERT INTO `incident_complainant` VALUES (6,'not resident',NULL,12,9),(7,'not resident',NULL,14,10),(8,'not resident',NULL,16,11);
/*!40000 ALTER TABLE `incident_complainant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `non_resident`
--

DROP TABLE IF EXISTS `non_resident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `non_resident` (
  `non_resident_id` int(11) NOT NULL AUTO_INCREMENT,
  `non_res_firstname` varchar(250) NOT NULL,
  `non_res_lastname` varchar(250) NOT NULL,
  `non_res_gender` varchar(10) NOT NULL,
  `non_res_birthdate` date NOT NULL,
  `non_res_contact` int(11) NOT NULL,
  `non_res_address` mediumtext NOT NULL,
  PRIMARY KEY (`non_resident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `non_resident`
--

LOCK TABLES `non_resident` WRITE;
/*!40000 ALTER TABLE `non_resident` DISABLE KEYS */;
INSERT INTO `non_resident` VALUES (1,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(2,'Adrean','Madrio','0963635357','0000-00-00',4,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(3,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(4,'Adrean','Madrio','0963635357','0000-00-00',4,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(5,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(6,'Adrean','Madrio','0963635357','0000-00-00',4,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(7,'Adrean','Madrio','female','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(8,'Adrean','Madrio','0963635357','0000-00-00',5,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(9,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(10,'Adrean','Madrio','0963635357','0000-00-00',4,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(11,'Adrean','Madrio','0963635357','0000-00-00',5,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(12,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(13,'Adrean','Madrio','0963635357','0000-00-00',5,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(14,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(15,'Adrean','Madrio','0963635357','0000-00-00',5,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(16,'Adrean','Madrio','male','0000-00-00',2147483647,'Blk 25, Lot 21 Ph5 Carissa, Bagtas'),(17,'Adrean','Madrio','0963635357','0000-00-00',5,'Blk 25, Lot 21 Ph5 Carissa, Bagtas');
/*!40000 ALTER TABLE `non_resident` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-11 14:46:56
