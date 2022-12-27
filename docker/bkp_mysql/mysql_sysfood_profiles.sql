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
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `idx` mediumint(9) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removed_at` datetime DEFAULT NULL,
  `removed_by` int(11) DEFAULT NULL,
  `active` enum('yes','no') DEFAULT 'yes',
  `name` varchar(255) DEFAULT NULL,
  `editabled` enum('yes','no') DEFAULT 'yes',
  `slug` varchar(255) NOT NULL,
  `adm` enum('yes','no') DEFAULT 'no',
  `parent` int(11) DEFAULT '0',
  `description` longtext,
  `hierarchy` int(11) DEFAULT '0',
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,NULL,NULL,'2021-12-27 02:47:32',1,NULL,NULL,'yes','master','no','master','yes',0,NULL,0),(39,'2022-03-20 17:52:31',2,'2022-07-27 01:12:38',2,NULL,NULL,'yes','ADM','yes','administrador','yes',0,'Acesso <b>full </b>a todos as funcionalidades (Inclusão, Edição e Exclusão)',1),(40,'2022-03-20 17:55:26',2,NULL,NULL,NULL,NULL,'yes','Supervisor','yes','supervisor','yes',0,'Acesso a todos os módulos, exceto o cadastro de usuários e permissão de incluir informações, editar informações, mas não pode excluir informações',2),(41,'2022-03-20 17:57:18',2,NULL,NULL,NULL,NULL,'yes','Usuário 1','yes','usuario-1','yes',0,'Acesso a todos os módulos, exceto o Cadastro de Usuários e Contas a Pagar. Permissão de incluir informações, editar informações, mas não pode excluir informações',4),(42,'2022-03-20 17:57:51',2,NULL,NULL,NULL,NULL,'yes','Usuário 2','yes','usuario-2','yes',0,'Acesso a todos os módulos, exceto o Cadastro de Usuários e Contas a Receber. Permissão de incluir informações, editar informações, mas não pode excluir informações',5),(43,'2022-03-20 17:59:33',2,NULL,NULL,NULL,NULL,'yes','Gerente','yes','gerente','yes',0,'Acesso a todos os módulos, exceto o Cadastro de Usuários e permissão de incluir informações, editar informações e excluir.',3),(44,NULL,NULL,NULL,NULL,NULL,NULL,'yes','Paciente','yes','paciente','no',0,NULL,0);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
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
