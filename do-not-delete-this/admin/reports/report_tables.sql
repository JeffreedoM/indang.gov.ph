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
  `month` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `barangay_id` int(11) NOT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_accomplishment`
--

LOCK TABLES `report_accomplishment` WRITE;
/*!40000 ALTER TABLE `report_accomplishment` DISABLE KEYS */;
INSERT INTO `report_accomplishment` VALUES (19,'Accomplishment Report','2023-05-09 03:20:53','21323','January',2020,0),(20,'Accomplishment Report','2023-05-09 03:21:19','234241','January',2020,0),(21,'Accomplishment Report','2023-05-09 03:26:55','fsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfg','January',2020,0),(22,'Accomplishment Report','2023-05-10 00:00:51','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus et sapien nec interdum. Phasellus ut sollicitudin sem, euismod rhoncus elit. Cras maximus tempus elit quis varius. Ut nec magna sodales, dignissim purus sit amet, ornare dui. Vivamus tempor facilisis nibh, at pharetra ex porttitor at. Praesent mollis metus commodo porttitor sodales. Mauris accumsan libero a nisi malesuada, ut ultrices orci lacinia. Nunc metus urna, laoreet eu augue eu, hendrerit rutrum est. Fusce condimentum ','August',2024,0),(24,'Accomplishment Report','2023-05-12 07:46:09',' fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fdsfdsafasdfasf fds','May',2023,0),(25,'Accomplishment Report','2023-05-12 07:47:13','sdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsasdfcdsfdsa','May',2023,0),(26,'Accomplishment Report','2023-05-15 05:22:21','ewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqwewrqweqrqw','January',2020,410),(27,'Accomplishment Report','2023-05-15 05:50:16','asdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgfasdfadsfgf','January',2020,447);
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
  `cert_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `capt` varchar(250) NOT NULL,
  `Ldate` date NOT NULL,
  `barangay_id` int(11) NOT NULL,
  PRIMARY KEY (`cert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_certificate`
--

LOCK TABLES `report_certificate` WRITE;
/*!40000 ALTER TABLE `report_certificate` DISABLE KEYS */;
INSERT INTO `report_certificate` VALUES (77,'Certificate Of Validation','2023-05-04 07:14:58','Joshua Ponciano','2023-02-28',0),(78,'Certificate Of Validation','2023-05-09 03:27:50','Joshua Ponciano','2023-02-28',0),(79,'Certificate Of Validation','2023-05-12 03:34:29','Joahu','2023-01-31',0),(80,'Certificate Of Validation','2023-05-15 05:28:36','Adrean Madrio','2020-02-29',410),(81,'Certificate Of Validation','2023-05-15 06:19:21','Adrean Madrio','2020-01-31',410);
/*!40000 ALTER TABLE `report_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_cleanup`
--

DROP TABLE IF EXISTS `report_cleanup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_cleanup` (
  `mcu_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `barangay_id` int(11) NOT NULL,
  PRIMARY KEY (`mcu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_cleanup`
--

LOCK TABLES `report_cleanup` WRITE;
/*!40000 ALTER TABLE `report_cleanup` DISABLE KEYS */;
INSERT INTO `report_cleanup` VALUES (61,'Monthly Clean-up','4th','2023',30,'12',13,55,'2023-05-12 03:38:39','Gian Carlo Cesar',5,0),(62,'Monthly Clean-up','4th','2023',30,'12',13,55,'2023-05-12 03:38:39','Gian Carlo Cesar',5,0),(63,'Monthly Clean-up','1st','2020',2,'2',2,2,'2023-05-15 05:35:04','Gian Carlo Cesar',0,410),(64,'Monthly Clean-up','1st','2020',2,'2',2,2,'2023-05-15 05:35:04','Gian Carlo Cesar',0,410),(65,'Monthly Clean-up','2nd','2020',2,'2',2,2,'2023-05-15 05:51:57','Gian Carlo Cesar',0,447),(66,'Monthly Clean-up','2nd','2020',2,'2',2,2,'2023-05-15 05:51:57','Gian Carlo Cesar',0,447);
/*!40000 ALTER TABLE `report_cleanup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_cleanup_nstep`
--

DROP TABLE IF EXISTS `report_cleanup_nstep`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_cleanup_nstep` (
  `nstep_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_legal` varchar(250) NOT NULL,
  `legal_consq` varchar(250) NOT NULL,
  `reason_low` varchar(250) NOT NULL,
  `next_step` varchar(250) NOT NULL,
  `mcu_id` int(11) NOT NULL,
  PRIMARY KEY (`nstep_id`),
  KEY `mcu_id` (`mcu_id`),
  CONSTRAINT `fk_mcu_id` FOREIGN KEY (`mcu_id`) REFERENCES `report_cleanup` (`mcu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_cleanup_nstep`
--

LOCK TABLES `report_cleanup_nstep` WRITE;
/*!40000 ALTER TABLE `report_cleanup_nstep` DISABLE KEYS */;
INSERT INTO `report_cleanup_nstep` VALUES (27,'yes','yes','yes','yes',62),(28,'yes','yes','yes','',62),(29,'yes','yes','','',62),(30,'yes','','','',62),(31,'','','','',64),(32,'','','','',64),(33,'','','','',64),(34,'','','','',64),(35,'','','','',66),(36,'','','','',66),(37,'','','','',66),(38,'','','','',66);
/*!40000 ALTER TABLE `report_cleanup_nstep` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel`
--

LOCK TABLES `report_personnel` WRITE;
/*!40000 ALTER TABLE `report_personnel` DISABLE KEYS */;
INSERT INTO `report_personnel` VALUES (130,'Adrean','2','2','building 2','tanod',69),(131,'Adrean2','3','3','at trece','supervisor',69),(132,'Adrean3','4','4','wwww','2',69),(133,'Adrean','1','1','building 2','tanod',70),(134,'Adrean','2','2','building 2','tanod',70),(135,'Adrean','3','3','building 2','tanod',70),(136,'Adrean','4','4','building 2','tanod',70),(137,'Adrean','5','5','building 2','tanod',70),(138,'Adrean','6','6','building 2','tanod',70),(139,'Adrean','7','7','building 2','tanod',70),(140,'Adrean','8','8','building 2','tanod',70),(141,'Adrean','9','9','building 2','tanod',70),(142,'Adrean','10','10','building 2','tanod',70),(143,'Adrean','1','1','building 2','tanod',71),(144,'Adrean','2','2','building 2','janitor',72);
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
  `barangay_id` int(11) NOT NULL,
  PRIMARY KEY (`pam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel_list`
--

LOCK TABLES `report_personnel_list` WRITE;
/*!40000 ALTER TABLE `report_personnel_list` DISABLE KEYS */;
INSERT INTO `report_personnel_list` VALUES (69,'Personal Attendance Monitoring','2023-05-12 08:05:51','Rev Sales','1st',0),(70,'Personal Attendance Monitoring','2023-05-12 08:07:46','Rev Sales','1st',0),(71,'Personal Attendance Monitoring','2023-05-15 05:42:55','Rev Sales','1st',410),(72,'Personal Attendance Monitoring','2023-05-15 05:52:49','Rev Sales','2nd',447);
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

-- Dump completed on 2023-05-15 14:45:22
