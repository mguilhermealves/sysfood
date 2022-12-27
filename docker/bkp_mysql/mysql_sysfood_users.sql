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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removed_at` datetime DEFAULT NULL,
  `removed_by` int(11) DEFAULT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `mail` varchar(255) NOT NULL DEFAULT '-',
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) NOT NULL DEFAULT '-',
  `last_login` datetime DEFAULT NULL,
  `celphone` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `regional` varchar(255) DEFAULT NULL,
  `distribuidora` varchar(255) DEFAULT NULL,
  `genre` enum('wait','male','female') NOT NULL DEFAULT 'wait',
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `external_id` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `address` text,
  `number` varchar(45) DEFAULT NULL,
  `complement` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `uf` varchar(45) DEFAULT NULL,
  `units_id` int(11) DEFAULT NULL,
  `accept_at` datetime DEFAULT NULL,
  `parent` int(11) DEFAULT '0',
  `uuid` longtext NOT NULL,
  PRIMARY KEY (`idx`),
  UNIQUE KEY `mail_UNIQUE` (`mail`),
  UNIQUE KEY `cpf_UNIQUE` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'0000-00-00 00:00:00',0,'2022-03-02 16:07:40',1,NULL,NULL,'yes','rcarpi@hsolmkt.com.br','rcarpi','19086c11e44d7562280a25e41e168851','Raphael','Carpi','28126547839','2022-03-02 16:04:32',NULL,NULL,NULL,NULL,'wait','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-12-15 12:43:33',0,''),(2,'2021-05-19 13:37:46',1,'2022-12-26 23:21:07',2,NULL,NULL,'yes','malves@hsolmkt.com.br','malves','e10adc3949ba59abbe56e057f20f883e','Marcos','Silva','38044791892','2022-12-26 21:21:07',NULL,NULL,NULL,NULL,'male','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2021-12-14 17:49:33',0,''),(3,'2022-02-09 15:48:58',1,'2022-03-04 19:20:34',3,NULL,NULL,'no','etoyoda@hsolmkt.com.br',NULL,'e10adc3949ba59abbe56e057f20f883e','Eduardo','Toyoda','27926330850','2022-03-04 16:20:34',NULL,NULL,NULL,NULL,'male','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,''),(4,'0000-00-00 00:00:00',0,'2022-03-02 13:15:52',4,NULL,NULL,'yes','jsilva@hsolmkt.com.br','jsilva','38d11b1ab4fe2d4c4a704a22a822f841','Zé','Máximo','35964965865','2022-03-02 13:16:00',NULL,NULL,NULL,NULL,'male','yes',NULL,'(11) 11111-1111','09639-000','Avenida Doutor Rudge Ramos','695','casa','Rudge Ramos','São Bernardo do Campo','SP',NULL,'2022-02-10 17:38:00',0,''),(5,'2022-11-15 17:59:44',2,'2022-12-04 20:04:42',5,NULL,NULL,'yes','supervisorteste@dermolaser.com.br','supervisor','e10adc3949ba59abbe56e057f20f883e','Gustavo','Carvalho','24512345666','2022-12-04 18:04:42','(11) 97020-2022',NULL,NULL,NULL,'male','yes',NULL,'(11) 4747-4747',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,''),(6,'2022-11-15 21:22:31',2,'2022-12-04 19:39:22',6,NULL,NULL,'yes','jgomes@dermolaser.com.br',NULL,'e10adc3949ba59abbe56e057f20f883e','Juliana','Gomes ','14578222556','2022-12-04 17:39:22','(11) 97425-2222',NULL,NULL,NULL,'female','yes',NULL,'(11) 4747-8787',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,5,''),(7,'2022-11-15 22:01:19',6,NULL,NULL,NULL,NULL,'yes','jusuario@dermolasergrupo.com.br',NULL,NULL,'Joao','Usuario 1','24515225555',NULL,'(11) 97855-5555',NULL,NULL,NULL,'female','yes',NULL,'(11) 1444-7885',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,5,''),(8,'2022-12-04 19:32:01',2,NULL,NULL,NULL,NULL,'yes','teste@teste55.com.br',NULL,NULL,'Juvenal','Silva','24512216663',NULL,NULL,NULL,NULL,NULL,'male','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,''),(9,'2022-12-04 19:32:01',2,NULL,NULL,NULL,NULL,'yes','-',NULL,NULL,NULL,NULL,'-',NULL,NULL,NULL,NULL,NULL,'wait','yes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,'c5c88fe39ec07d6fd65dc5546176a61d');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-27  9:08:45
