-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mysql_sysfood
-- ------------------------------------------------------
-- Server version	5.6.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `idx` mediumint(9) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removed_at` datetime DEFAULT NULL,
  `removed_by` int(11) DEFAULT NULL,
  `active` enum('yes','no') DEFAULT 'yes',
  `name` varchar(255) DEFAULT NULL,
  `parent` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,'yes','Configurações','-1','bi bi-gear',1),(2,NULL,NULL,NULL,NULL,NULL,NULL,'yes','Menus','1','bi bi-circle',2),(3,'2022-11-13 18:38:09',2,NULL,NULL,NULL,NULL,'yes','Urls','1','bi bi-circle',3),(4,'2022-11-13 18:38:29',2,NULL,NULL,NULL,NULL,'yes','Rotas','1','bi bi-circle',4),(5,'2022-11-13 18:39:59',2,'2022-11-15 18:06:01',2,NULL,NULL,'yes','Acessos','-1','bi bi-people',10),(6,'2022-11-13 18:40:19',2,'2022-11-15 18:34:15',2,NULL,NULL,'yes','Usuarios','5','bi bi-circle',11),(7,'2022-11-13 18:40:43',2,'2022-11-15 18:34:40',2,NULL,NULL,'yes','Perfis','5','bi bi-circle',12),(8,'2022-11-13 18:41:15',2,'2022-11-15 18:06:41',2,NULL,NULL,'no','Banners','-1','bi bi-images',20),(9,'2022-11-13 18:42:16',2,'2022-11-15 18:07:21',2,NULL,NULL,'no','Tratamentos','16','bi bi-circle',62),(10,'2022-11-13 18:42:45',2,'2022-11-15 18:09:35',2,NULL,NULL,'no','Unidades','-1','bi bi-building',30),(11,'2022-11-13 18:43:03',2,'2022-11-15 18:09:45',2,NULL,NULL,'no','Unidades','10','bi bi-circle',31),(12,'2022-11-13 18:43:31',2,'2022-11-15 18:09:58',2,NULL,NULL,'no','Banners Unidades','10','bi bi-circle',32),(13,'2022-11-13 18:44:34',2,'2022-11-15 22:50:55',2,NULL,NULL,'no','Blog','-1','bi bi-newspaper',40),(14,'2022-11-13 18:44:51',2,'2022-11-15 18:10:23',2,NULL,NULL,'yes','Relatórios','-1','bi bi-file-excel',50),(15,'2022-11-13 22:25:15',2,'2022-11-27 15:39:43',2,NULL,NULL,'no','Depoimentos','10','bi bi-circle',33),(16,'2022-11-13 22:53:41',2,'2022-11-15 18:10:49',2,NULL,NULL,'no','Tratamentos','-1','bi bi-hospital',60),(17,'2022-11-13 22:54:27',2,'2022-11-27 00:01:43',2,NULL,NULL,'no','Tipos','16','bi bi-circle',61),(18,'2022-12-26 23:25:51',2,NULL,NULL,NULL,NULL,'yes','Produtos','-1','bi bi-box',70),(19,'2022-12-26 23:26:10',2,'2022-12-26 23:27:11',2,NULL,NULL,'yes','Produtos','18',NULL,71),(20,'2022-12-26 23:26:25',2,'2022-12-27 14:42:47',2,NULL,NULL,'yes','Categorias','18',NULL,72),(21,'2022-12-26 23:44:21',2,NULL,NULL,NULL,NULL,'yes','Caixa','-1','bi bi-bank',90),(22,'2022-12-26 23:44:36',2,NULL,NULL,NULL,NULL,'no','Caixa','21',NULL,81),(23,'2022-12-26 23:44:49',2,'2022-12-27 12:43:59',2,NULL,NULL,'yes','Mesas','-1','bi bi-square',80);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-27 14:36:07
