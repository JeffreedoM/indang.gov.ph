-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bmis
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `clearance`
--

DROP TABLE IF EXISTS `clearance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clearance` (
  `clearance_id` int(11) NOT NULL AUTO_INCREMENT,
  `clearance_name` varchar(100) NOT NULL,
  `clearance_amount` float NOT NULL,
  PRIMARY KEY (`clearance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clearance`
--

LOCK TABLES `clearance` WRITE;
/*!40000 ALTER TABLE `clearance` DISABLE KEYS */;
INSERT INTO `clearance` VALUES (72,'Certificate of Indigency',25),(77,'Barangay Business Clearance',20),(78,'Barangay Clearance',40),(79,'Certificate of Good Moral Character',10),(80,'Certificate of Residency',25),(81,'Certificate of Clearance',20);
/*!40000 ALTER TABLE `clearance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clearance_release`
--

DROP TABLE IF EXISTS `clearance_release`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clearance_release` (
  `release_id` int(11) NOT NULL AUTO_INCREMENT,
  `clearance_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `purpose` varchar(500) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`release_id`),
  KEY `resident_id` (`resident_id`),
  KEY `clearance_id` (`clearance_id`),
  CONSTRAINT `clearance_release_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`),
  CONSTRAINT `clearance_release_ibfk_3` FOREIGN KEY (`clearance_id`) REFERENCES `clearance` (`clearance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clearance_release`
--

LOCK TABLES `clearance_release` WRITE;
/*!40000 ALTER TABLE `clearance_release` DISABLE KEYS */;
INSERT INTO `clearance_release` VALUES (3,72,45,'','2023-05-03 01:06:56'),(4,78,47,'','2023-05-03 01:24:06'),(6,78,45,'Educational Assistance','2023-05-03 03:37:41'),(7,81,45,'Trippings lang','2023-05-03 09:11:56'),(8,81,45,'asd','2023-05-05 03:32:31'),(9,81,47,'Rawr','2023-05-05 03:33:46'),(10,81,47,'Rawr','2023-05-05 03:54:53'),(11,78,47,'Wala','2023-05-05 03:55:03'),(12,81,46,'asd','2023-05-05 03:59:14'),(13,81,45,'asdasda','2023-05-05 03:59:52'),(14,81,45,'dasdasda','2023-05-05 04:02:22'),(15,72,46,'','2023-05-05 04:02:47'),(16,81,47,'asd','2023-05-05 04:03:06'),(17,81,47,'asd','2023-05-05 04:07:57'),(18,81,47,'aaaaaa','2023-05-05 04:13:43'),(19,81,45,'sssss','2023-05-05 04:14:55'),(20,79,47,'','2023-05-05 04:15:16'),(21,79,46,'','2023-05-05 04:15:27'),(22,80,45,'Wala','2023-05-08 10:36:27'),(23,80,47,'','2023-05-08 10:37:10'),(24,80,47,'','2023-05-08 10:38:08'),(25,81,45,'','2023-05-08 10:38:35');
/*!40000 ALTER TABLE `clearance_release` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clearance_total`
--

DROP TABLE IF EXISTS `clearance_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clearance_total` (
  `distrib_id` int(11) NOT NULL AUTO_INCREMENT,
  `clearance_id` int(11) NOT NULL,
  `distrib_quantity` int(11) NOT NULL,
  `distrib_total` int(11) NOT NULL,
  PRIMARY KEY (`distrib_id`),
  KEY `clearance_id` (`clearance_id`),
  CONSTRAINT `clearance_total_ibfk_1` FOREIGN KEY (`clearance_id`) REFERENCES `clearance` (`clearance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clearance_total`
--

LOCK TABLES `clearance_total` WRITE;
/*!40000 ALTER TABLE `clearance_total` DISABLE KEYS */;
INSERT INTO `clearance_total` VALUES (1,81,3,60),(3,72,1,0),(4,79,2,0),(5,80,3,75);
/*!40000 ALTER TABLE `clearance_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_distribution`
--

DROP TABLE IF EXISTS `medicine_distribution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_distribution` (
  `distrib_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_id` int(11) NOT NULL,
  `resident_id` int(11) NOT NULL,
  `distrib_quantity` int(11) NOT NULL,
  `distrib_date` date NOT NULL,
  PRIMARY KEY (`distrib_id`),
  KEY `medicine_id` (`medicine_id`),
  KEY `resident_id` (`resident_id`),
  CONSTRAINT `medicine_distribution_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicine_inventory` (`ID`),
  CONSTRAINT `medicine_distribution_ibfk_2` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_distribution`
--

LOCK TABLES `medicine_distribution` WRITE;
/*!40000 ALTER TABLE `medicine_distribution` DISABLE KEYS */;
INSERT INTO `medicine_distribution` VALUES (26,100,46,-15,'2023-04-22'),(27,101,45,20,'2023-04-19'),(28,102,46,41,'2023-04-19'),(29,103,46,18,'2023-04-27'),(30,103,47,33,'2023-04-28'),(31,104,46,10,'2023-04-28'),(34,101,47,20,'2023-04-24'),(35,104,47,5,'2023-04-25'),(36,100,47,2,'2023-04-25'),(37,100,45,5,'2023-04-24'),(38,103,47,4,'2023-04-26'),(39,103,47,1,'2023-04-21'),(40,107,47,5,'2023-04-23'),(41,102,47,9,'2023-04-24'),(42,106,47,5,'2023-05-06'),(43,109,45,5,'2023-04-14'),(44,102,45,10,'2023-04-14'),(45,107,45,5,'2023-04-27');
/*!40000 ALTER TABLE `medicine_distribution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_inventory`
--

DROP TABLE IF EXISTS `medicine_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_inventory` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(50) NOT NULL,
  `medicine_availability` varchar(100) NOT NULL,
  `medicine_quantity` int(11) NOT NULL,
  `medicine_expiration` date NOT NULL,
  `medicine_description` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_inventory`
--

LOCK TABLES `medicine_inventory` WRITE;
/*!40000 ALTER TABLE `medicine_inventory` DISABLE KEYS */;
INSERT INTO `medicine_inventory` VALUES (100,'Paracetamol','Available',30,'2023-04-21','For flu'),(101,'Bioflu','Available',25,'2023-04-28','For flu'),(102,'Neozep','Available',10,'2023-04-24','For colds'),(103,'Medicol','Available',10,'2023-04-17','For sakit ng ulo'),(104,'Medicol','Available',35,'2023-04-24','For sakit ng ulo'),(105,'Anti-Histamine','Available',20,'2023-04-25','For allergy'),(106,'Cetirizine','Out of Stock',0,'2023-04-30','Allergy'),(107,'Diatabs','Out of Stock',0,'2023-04-13','Pagtatae'),(108,'Paracetamol','Available',9,'2023-05-02','For flu'),(109,'Biogesic','Available',95,'2024-04-14','For flu'),(110,'neozep','Available',5,'2023-04-05','');
/*!40000 ALTER TABLE `medicine_inventory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-08 21:15:15
