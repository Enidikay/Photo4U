CREATE DATABASE  IF NOT EXISTS `photo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `photo`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: photo
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Mdp` varchar(32) NOT NULL,
  `Credit` int(11) NOT NULL DEFAULT 0,
  `Photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `mail_UNIQUE` (`Mail`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (184,'Siala','Jad','client','jadsiala15@gmail.com','a8542fe791b6a005741707e238afbea3',100,NULL),(185,'Chimaev','Khamzat','Photographe','carlos.juan@tacos.com','b1d1adbb133ca59935a3d146b8863822',130,NULL),(186,'Benzema','Karim','Photographe','ballondor.peuple@realmadrid.es','ce72119b90d2b762bcd24c67a1ab3ba7',50000,NULL),(187,'Das','Nas','client','lachenter.perpi@monquartier.fr','2b4da4b15b9661fddd6cccc65a7989e0',0,NULL),(188,'Doumbe','Cedric','Photographe','jevsavais.disquoi@tmort.com','b039a3474805902b73b06f827c5fe12a',1,NULL),(189,'CORP','Simmou','client','simmoucorp@sialah.com','b03e6c8474904244d72fd6a688b46799',0,NULL),(190,'Mbapa','bazama','Photographe','bazamaMbape@gmail.com','b03e6c8474904244d72fd6a688b46799',0,NULL),(191,'Abdallah','Yakidine','client','abdallah.yakidine@gmail.com','b9997999ce1deb52f52f7c1e7a527590',2,NULL),(198,'James','Patagueule','photographe','yakidine.abdallah@gmail.com','b9997999ce1deb52f52f7c1e7a527590',0,'images/pdp/66bee5e5f3c20a46736fe66634b6eba9.jpg'),(199,'Enidikay','Abdallah','photographe','enidikay@gmail.com','b9997999ce1deb52f52f7c1e7a527590',0,'images/pdp/66bee5e5f3c20a46736fe66634b6eba9.jpg');
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

-- Dump completed on 2024-05-01 23:56:38
