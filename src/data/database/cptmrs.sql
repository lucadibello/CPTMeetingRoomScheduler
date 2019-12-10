-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: cptmrs
-- ------------------------------------------------------
-- Server version	5.7.21-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `email`
--
USE cptmrs;

DROP TABLE IF EXISTS `email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_conferma` text NOT NULL,
  `sent_at_datetime` datetime NOT NULL,
  `expiration_datetime` datetime NOT NULL,
  `utente` varchar(255) NOT NULL,
  `riservazione` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_email_utente_idx` (`utente`),
  KEY `fk_email_riservazione_idx` (`riservazione`),
  CONSTRAINT `fk_email_riservazione` FOREIGN KEY (`riservazione`) REFERENCES `riservazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_email_utente` FOREIGN KEY (`utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=860 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email`
--

LOCK TABLES `email` WRITE;
/*!40000 ALTER TABLE `email` DISABLE KEYS */;
INSERT INTO `email` VALUES (851,'d3d9446802a44259755d38e6d163e820','2019-10-04 15:34:23','2019-10-05 15:34:23','mattia.lazzaroni',NULL),(852,'eccbc87e4b5ce2fe28308fd9f2a7baf3','2019-10-04 15:36:18','2019-10-05 15:36:18','mattia.lazzaroni',NULL),(853,'838fa4fcfda37c8448a7369ee9a2fe2a','2019-10-04 15:47:31','2019-10-05 15:47:31','mattia.lazzaroni',NULL),(854,'09b732ca339e849b71d80bd03d68f972','2019-10-04 15:51:20','2019-10-05 15:51:20','luca.dibello',NULL),(855,'bde80344dc4c32450c6ce5fdfc6bb63f','2019-10-04 16:15:15','2019-10-05 16:15:15','luca.dibello',NULL),(856,'80c722bc571e2768d0a5a4707462548b','2019-10-08 15:38:26','2019-10-09 15:38:26','mattia.toscanelli',NULL),(858,'d5010113eb1db2289a43cdef8984533b','2019-10-10 15:55:38','2019-10-11 15:55:38','luca.dibello',NULL),(859,'ed80b356b5720483925318ffb745bc0c','2019-10-11 16:00:08','2019-10-12 16:00:08','luca.dibello',NULL);
/*!40000 ALTER TABLE `email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riservazione`
--

DROP TABLE IF EXISTS `riservazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riservazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL,
  `osservazioni` varchar(512) DEFAULT NULL,
  `utente` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_riservazione_utente_idx` (`utente`),
  CONSTRAINT `fk_riservazione_utente` FOREIGN KEY (`utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riservazione`
--

LOCK TABLES `riservazione` WRITE;
/*!40000 ALTER TABLE `riservazione` DISABLE KEYS */;
INSERT INTO `riservazione` VALUES (1,'2019-10-15','08:50:00','09:50:00','adawd','luca.dibello');
/*!40000 ALTER TABLE `riservazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_mail`
--

DROP TABLE IF EXISTS `tipo_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_mail` (
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_mail`
--

LOCK TABLES `tipo_mail` WRITE;
/*!40000 ALTER TABLE `tipo_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_utente`
--

DROP TABLE IF EXISTS `tipo_utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_utente` (
  `nome` varchar(50) NOT NULL,
  `creazione_utenti` bit(1) NOT NULL DEFAULT b'0',
  `eliminazione_utenti` bit(1) NOT NULL DEFAULT b'0',
  `modifica_utenti` bit(1) NOT NULL DEFAULT b'0',
  `promozione_utenti` bit(1) NOT NULL DEFAULT b'0',
  `visione_prenotazioni` bit(1) NOT NULL DEFAULT b'0',
  `inserimento_prenotazioni` bit(1) NOT NULL DEFAULT b'0',
  `cancellazione_prenotazioni_personali` bit(1) NOT NULL DEFAULT b'0',
  `cancellazione_prenotazioni_altri_utenti` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_utente`
--

--
-- Table structure for table `utente`
--

DROP TABLE IF EXISTS `utente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utente` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `tipo_utente` varchar(50) NOT NULL,
  `default_password_changed` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`username`),
  KEY `fk_utente_tipo:utente_idx` (`tipo_utente`),
  CONSTRAINT `fk_utente_tipoutente` FOREIGN KEY (`tipo_utente`) REFERENCES `tipo_utente` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utente`
--

LOCK TABLES `utente` WRITE;
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` VALUES ('luca.dibello','luca.dibello','$2y$10$uD8sJuyIirM.7nALAujL5eIyxyfkliyhin6EI0baa3wIXK6KQZiV.','Luca','Di Bello','admin',''),('mattia.lazzaroni','mattia.lazzaroni','$2y$10$uYpHRUik4mQ/SR97dq3BCefw8GhJCliNfwWNqcrSw6qiYlaLlbhpy','Mattia','Lazzaroni','avanzato',''),('mattia.toscanelli','mattia.toscanelli','$2y$10$QCxVmJd8OU6Xa.BFpoeU5OvbRtYL1UM/kPsEztdQTuPzEqZnAcyKW','Mattia','Toscanelli','user',''),('prova','prova.prova','$2y$10$D8nAQpt7QCOCl4BvNqxy5eVeQ7ask9XfNRKQjo8PY/7q4lSD6vYH2','prova','prova','admin','\0');
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-05 12:03:44
