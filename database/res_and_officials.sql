-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bmis
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB

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
-- Table structure for table `officials`
--

DROP TABLE IF EXISTS `officials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resident_id` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `resident_id` (`resident_id`),
  CONSTRAINT `officials_ibfk_1` FOREIGN KEY (`resident_id`) REFERENCES `resident` (`resident_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officials`
--

LOCK TABLES `officials` WRITE;
/*!40000 ALTER TABLE `officials` DISABLE KEYS */;
INSERT INTO `officials` VALUES (1,22,'Barangay Tanod','2023-04-08','2023-05-18'),(3,19,'Committee on Health and Sports','2023-04-08','2025-04-08'),(4,52,'Barangay Captain','2023-04-08','2026-04-08'),(5,17,'Barangay Tanod','2023-04-15','2023-04-15'),(6,17,'Barangay Tanod','2023-04-06','2023-04-06'),(7,17,'Barangay Tanod','2023-04-12','2023-04-12'),(8,21,'Barangay Treasurer','2023-04-09','2024-04-09'),(9,23,'Barangay Tanod','2023-04-15','2026-04-15'),(10,19,'Barangay Tanod','2023-04-22','2025-04-22'),(12,17,'Committee on Peace and Order','2023-05-06','2023-05-06'),(13,19,'Committee on Public Information/Environment','2023-04-29','2023-04-29'),(14,17,'Committee on Agricultural','2023-04-28','2023-04-28'),(15,17,'Committee on Education','2023-04-29','2023-04-29'),(16,17,'Committee on Budget and Appropriation','2023-04-12','2023-04-12'),(17,17,'Committee on Infrastructure','2023-04-13','2023-04-13'),(18,17,'Sangguniang Kabataan','2023-04-13','2023-04-13'),(19,20,'Sangguniang Kabataan','2023-04-13','2023-04-13');
/*!40000 ALTER TABLE `officials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resident`
--

DROP TABLE IF EXISTS `resident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resident` (
  `resident_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`resident_id`),
  KEY `barangay_id` (`barangay_id`),
  CONSTRAINT `resident_ibfk_1` FOREIGN KEY (`barangay_id`) REFERENCES `barangay` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resident`
--

LOCK TABLES `resident` WRITE;
/*!40000 ALTER TABLE `resident` DISABLE KEYS */;
INSERT INTO `resident` VALUES (17,410,'Jeffrey','Villamor','Nuñez','','Male','2000-09-29',22,'single','09123456789','mobile',160,70,'Christian Catholic','Unemployed','','123 Hahaha Poblacion','642c435a7dacd8.13869559.jpg'),(19,410,'Adrean','Barurot','Madrio','','Male','2000-02-28',12,'single','','mobile',170,170,'Born Again','Unemployed','','123 Bagtas Bagtas','63ff24384f6d32.13857671.png'),(20,410,'Jeep','Villa','Nuñez','','Male','2000-09-29',22,'single','','no_contact',165,70,'Seventh Day Adventist','Unemployed','','123 Sitio Pulo Kalokohan','63ff240cbd6f53.78912086.png'),(21,410,'Rev Ed','Tigang','Sales','','Male','2023-01-01',0,'single','','no_contact',123,123,'Christian Catholic','Unemployed','','123 456 yoyo','63ff29d52ae238.19457172.jpg'),(22,410,'Jeffrey','Villamor','Nuñez','','Male','2000-09-29',22,'single','','no_contact',165,70,'Christian Catholic','Unemployed','','123 Mahalay Street Poblacion 1','64015c1b54c731.54117511.jpg'),(23,410,'Ripped','Rev','Sales','','Male','2000-01-01',23,'single','','tel',165,70,'Christian Catholic','Unemployed','','123 Bagtas Poblacion 1','6425913f2a8de3.82572586.png'),(52,410,'Joshua','Oafericua','Ponciano','','Male','2023-04-06',0,'married','09123456789','mobile',160,60,'Ang Dating Daan','Employed','Comshop Manager','123 Puntahan Street Barangay Uno','642ea0215eea81.85696232.png');
/*!40000 ALTER TABLE `resident` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-14 15:36:09
