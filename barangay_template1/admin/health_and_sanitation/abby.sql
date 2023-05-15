-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bmis
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `death`
--

DROP TABLE IF EXISTS `death`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `death` (
  `death_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_resident` int(11) NOT NULL,
  `death_fname` varchar(250) NOT NULL,
  `death_cause` varchar(250) NOT NULL,
  `death_date` date DEFAULT NULL,
  PRIMARY KEY (`death_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `death`
--

LOCK TABLES `death` WRITE;
/*!40000 ALTER TABLE `death` DISABLE KEYS */;
INSERT INTO `death` VALUES (2,17,'Jeffrey Villamor Nuñezzzzz                                    ','Cold Severeeeeeeeee','2023-05-24');
/*!40000 ALTER TABLE `death` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregnant`
--

DROP TABLE IF EXISTS `pregnant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pregnant` (
  `pregnant_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_resident` int(11) NOT NULL,
  `pregnant_fname` varchar(250) NOT NULL,
  `pregnant_num` int(11) NOT NULL,
  `pregnant_status` varchar(50) NOT NULL,
  `pregnant_occupation` varchar(250) NOT NULL,
  PRIMARY KEY (`pregnant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregnant`
--

LOCK TABLES `pregnant` WRITE;
/*!40000 ALTER TABLE `pregnant` DISABLE KEYS */;
INSERT INTO `pregnant` VALUES (4,22,'Jeffrey Villamor Nuñezzz                                    ',5,'Widow','Driver');
/*!40000 ALTER TABLE `pregnant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vaccine`
--

DROP TABLE IF EXISTS `vaccine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vaccine` (
  `vaccine_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_resident` int(11) NOT NULL,
  `vaccine_fname` varchar(250) NOT NULL,
  `vaccine_dose` varchar(250) NOT NULL,
  `vaccine_type` varchar(50) NOT NULL,
  `vaccine_date` date DEFAULT NULL,
  `vaccine_place` varchar(250) NOT NULL,
  PRIMARY KEY (`vaccine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vaccine`
--

LOCK TABLES `vaccine` WRITE;
/*!40000 ALTER TABLE `vaccine` DISABLE KEYS */;
INSERT INTO `vaccine` VALUES (4,20,'Jeep Villa Nuñez                                    ','2nd Dose','Pfizer','2023-05-20','Dasma'),(5,21,'Rev Ed Tigang Sales                                    ','1st Dose','Pfizer','2023-05-09','Imus'),(7,17,'Jeffrey Villamor Nuñez                                    ','Booster','Parkinson','2023-05-11','Imus'),(9,23,'Ripped Rev Sales                                    ','2nd Dose','Pfizer','2023-05-11','Imus');
/*!40000 ALTER TABLE `vaccine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newborn`
--

DROP TABLE IF EXISTS `newborn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newborn` (
  `newborn_id` int(11) NOT NULL AUTO_INCREMENT,
  `newborn_fname` varchar(250) NOT NULL,
  `newborn_mname` varchar(250) NOT NULL,
  `newborn_lname` varchar(250) NOT NULL,
  `newborn_gender` varchar(50) NOT NULL,
  `newborn_date_birth` date DEFAULT NULL,
  `newborn_date_added` date DEFAULT NULL,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`newborn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newborn`
--

LOCK TABLES `newborn` WRITE;
/*!40000 ALTER TABLE `newborn` DISABLE KEYS */;
INSERT INTO `newborn` VALUES (3,'Kalen','Mon','Serrat','Male','2023-05-09','2023-05-03',''),(4,'Linda','Selene','Plona','Female','2023-05-02','2023-05-03',''),(6,'Arianne','Hernandez','Quimpo','Female','2023-05-30','2023-06-02','');
/*!40000 ALTER TABLE `newborn` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-10 14:30:48
