-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
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
-- Table structure for table `service_messages`
--

DROP TABLE IF EXISTS `service_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_messages` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `header` text,
  `body` longtext,
  `status` varchar(45) DEFAULT NULL,
  `scheduled_at` datetime DEFAULT NULL,
  `scheduled_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removed_at` datetime DEFAULT NULL,
  `removed_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_msg` longtext,
  `active` enum('yes','no') DEFAULT 'yes',
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_messages`
--

LOCK TABLES `service_messages` WRITE;
/*!40000 ALTER TABLE `service_messages` DISABLE KEYS */;
INSERT INTO `service_messages` VALUES (1,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste1@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:8:\"Dúvidas\";s:12:\"scheduled_at\";s:19:\"2022-02-22 14:52:09\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 14:52:09\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 14:52:09',1,'2022-02-22 14:52:07',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes'),(2,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste3@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:13:\"Reclamações\";s:12:\"scheduled_at\";s:19:\"2022-02-22 15:20:04\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 15:20:04\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 15:20:04',1,'2022-02-22 15:20:02',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes'),(3,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste3@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:13:\"Reclamações\";s:12:\"scheduled_at\";s:19:\"2022-02-22 15:20:42\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 15:20:42\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 15:20:42',1,'2022-02-22 15:20:40',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes'),(4,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste4@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:7:\"Elogios\";s:12:\"scheduled_at\";s:19:\"2022-02-22 15:24:11\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 15:24:11\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 15:24:11',1,'2022-02-22 15:24:09',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes'),(5,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste4@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:7:\"Elogios\";s:12:\"scheduled_at\";s:19:\"2022-02-22 15:25:20\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 15:25:20\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 15:25:20',1,'2022-02-22 15:25:18',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes'),(6,'a:1:{i:0;a:8:{s:2:\"to\";a:1:{i:0;s:16:\"teste4@teste.com\";}s:3:\"Bcc\";a:0:{}s:2:\"cc\";a:0:{}s:7:\"subject\";s:7:\"Elogios\";s:12:\"scheduled_at\";s:19:\"2022-02-22 15:26:57\";s:12:\"scheduled_by\";i:1;s:10:\"created_at\";s:19:\"2022-02-22 15:26:57\";s:10:\"created_by\";i:1;}}','Novo contato do Wikipet:<br/>\r\n		Nome: <b>teste</b><br/>\r\n		E-mail: <b>teste@teste.com</b><br/>		\r\n        Mensagem: <b>teste</b>','1','2022-02-22 15:26:57',1,'2022-02-22 15:26:55',4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'yes');
/*!40000 ALTER TABLE `service_messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-27  9:08:47
