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
-- Table structure for table `treatments`
--

DROP TABLE IF EXISTS `treatments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `treatments` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `removed_at` datetime DEFAULT NULL,
  `removed_by` int(11) DEFAULT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `description` longtext,
  `image_banner` longtext NOT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treatments`
--

LOCK TABLES `treatments` WRITE;
/*!40000 ALTER TABLE `treatments` DISABLE KEYS */;
INSERT INTO `treatments` VALUES (1,'2022-11-27 15:00:39',2,NULL,NULL,NULL,NULL,'yes','PEELING QUIMICO',NULL,1,'O tratamento consiste em aplicar camadas de ácido na pele, estimulando a descamação e a renovação celular. É ideal para remover manchas, marcas de acne e cicatrizes.','furniture/upload/tipos-tratamentos/peeling-quimico20221127130039.png'),(2,'2022-11-27 15:30:37',2,NULL,NULL,NULL,NULL,'yes','MICROAGULHAMENTO',NULL,1,'<p>O procedimento é feito com um aparelho que apresenta diversas agulhas de aço que estimula a formação de colágeno. Melhora o aspecto das rugas, das linhas de expressão, cicatrizes de acne.</p>','furniture/upload/tipos-tratamentos/microagulhamento20221127133037.png'),(3,'2022-11-27 17:46:05',2,NULL,NULL,NULL,NULL,'yes','Franciele Lopes',NULL,1,'<p>Eu queria deixar aqui registrado o quanto o atendimento da DermoLaser Centro de Sorocaba é maravilhoso, em todos os estágios. Tanto no primeiro atendimento quanto já no tratamento. Eu quero agradecer todo carinho e dedicação da Sílvia, profissional incrível, amável e sempre querida???</p><p>As meninas da recepção são um amor ?? Sem falar que os preços são justos e facilitam demais o pagamento. Vocês tem noção do que é já vê resultado na primeira sessão? Pois na Dermo foi assim!! DermoLaser foi um feliz achado, podem ir conhecer sem medo ????</p>',''),(4,'2022-11-27 17:47:36',2,NULL,NULL,NULL,NULL,'yes','Franciele Lopes',NULL,1,'<p>Eu queria deixar aqui registrado o quanto o atendimento da DermoLaser Centro de Sorocaba é maravilhoso, em todos os estágios. Tanto no primeiro atendimento quanto já no tratamento. Eu quero agradecer todo carinho e dedicação da Sílvia, profissional incrível, amável e sempre querida???</p><p>As meninas da recepção são um amor ?? Sem falar que os preços são justos e facilitam demais o pagamento. Vocês tem noção do que é já vê resultado na primeira sessão? Pois na Dermo foi assim!! DermoLaser foi um feliz achado, podem ir conhecer sem medo ????</p>','');
/*!40000 ALTER TABLE `treatments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-27 14:36:06
