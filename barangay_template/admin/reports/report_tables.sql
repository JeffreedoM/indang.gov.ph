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
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_accomplishment`
--

LOCK TABLES `report_accomplishment` WRITE;
/*!40000 ALTER TABLE `report_accomplishment` DISABLE KEYS */;
INSERT INTO `report_accomplishment` VALUES (14,'Accomplishment Report','2023-05-09 03:15:06','fsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfg','January',2023),(15,'Accomplishment Report','2023-05-09 03:16:44','dfasdfa','January',2020),(16,'Accomplishment Report','2023-05-09 03:17:10','sssss','January',2020),(17,'Accomplishment Report','2023-05-09 03:18:47','dasdsadsa','January',2020),(18,'Accomplishment Report','2023-05-09 03:19:30','asdfa','January',2020),(19,'Accomplishment Report','2023-05-09 03:20:53','21323','January',2020),(20,'Accomplishment Report','2023-05-09 03:21:19','234241','January',2020),(21,'Accomplishment Report','2023-05-09 03:26:55','fsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfgfsdfdageeggfg','January',2020),(22,'Accomplishment Report','2023-05-10 00:00:51','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris tempus et sapien nec interdum. Phasellus ut sollicitudin sem, euismod rhoncus elit. Cras maximus tempus elit quis varius. Ut nec magna sodales, dignissim purus sit amet, ornare dui. Vivamus tempor facilisis nibh, at pharetra ex porttitor at. Praesent mollis metus commodo porttitor sodales. Mauris accumsan libero a nisi malesuada, ut ultrices orci lacinia. Nunc metus urna, laoreet eu augue eu, hendrerit rutrum est. Fusce condimentum ','August',2024);
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
  PRIMARY KEY (`cert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_certificate`
--

LOCK TABLES `report_certificate` WRITE;
/*!40000 ALTER TABLE `report_certificate` DISABLE KEYS */;
INSERT INTO `report_certificate` VALUES (77,'Certificate Of Validation','2023-05-04 07:14:58','Joshua Ponciano','2023-02-28'),(78,'Certificate Of Validation','2023-05-09 03:27:50','Joshua Ponciano','2023-02-28');
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
  PRIMARY KEY (`mcu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_cleanup`
--

LOCK TABLES `report_cleanup` WRITE;
/*!40000 ALTER TABLE `report_cleanup` DISABLE KEYS */;
INSERT INTO `report_cleanup` VALUES (56,'Monthly Clean-up','2nd','2020',0,'',0,0,'2023-05-09 14:51:49','gian carlo cesar',0),(57,'Monthly Clean-up','1st','2019',2,'2',22,22,'2023-05-09 14:53:37','gian carlo cesar',0),(58,'Monthly Clean-up','1st','2019',2,'2',22,22,'2023-05-09 14:53:37','gian carlo cesar',0),(59,'Monthly Clean-up','1st','2019',2,'2',4,4,'2023-05-10 02:30:50','Gian Carlo Cesar',15),(60,'Monthly Clean-up','1st','2019',2,'2',4,4,'2023-05-10 02:30:50','Gian Carlo Cesar',15);
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
  KEY `mcu_id` (`mcu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_cleanup_nstep`
--

LOCK TABLES `report_cleanup_nstep` WRITE;
/*!40000 ALTER TABLE `report_cleanup_nstep` DISABLE KEYS */;
INSERT INTO `report_cleanup_nstep` VALUES (15,'www','rrr','rrr','rrrr',56),(16,'eeee','rrrr','rrr','',56),(17,'eeee','ttt','','',56),(18,'eee','ttt','','',56),(19,'111','12','2222','333',58),(20,'111','111','111','111',58),(21,'','','','',58),(22,'','','','',58),(23,'key','walalal','2222','rrrr',60),(24,'key','walalal','2222','rrrr',60),(25,'key','walalal','','',60),(26,'','','','',60);
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
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel`
--

LOCK TABLES `report_personnel` WRITE;
/*!40000 ALTER TABLE `report_personnel` DISABLE KEYS */;
INSERT INTO `report_personnel` VALUES (81,'Adrean','1','1','building 2','tanod',28),(82,'Adrean','1','1','building 2','tanod',29),(83,'Adrean','2','2','building 2','tanod',30);
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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_personnel_list`
--

LOCK TABLES `report_personnel_list` WRITE;
/*!40000 ALTER TABLE `report_personnel_list` DISABLE KEYS */;
INSERT INTO `report_personnel_list` VALUES (28,'Personal Attendance Monitoring','2023-05-09 07:31:55','Rev Sales','1st'),(29,'Personal Attendance Monitoring','2023-05-09 07:32:34','Rev Sales','2nd'),(30,'Personal Attendance Monitoring','2023-05-10 02:15:32','Rev Sales','2nd');
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

-- Dump completed on 2023-05-10 23:13:47
