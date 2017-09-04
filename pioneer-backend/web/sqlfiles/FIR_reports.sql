-- MySQL dump 10.13  Distrib 5.5.50, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: FIR_reports
-- ------------------------------------------------------
-- Server version	5.5.50-0ubuntu0.14.04.1

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
-- Table structure for table `apps_countries`
--

DROP TABLE IF EXISTS `apps_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apps_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CountryCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `CountryName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apps_countries`
--

LOCK TABLES `apps_countries` WRITE;
/*!40000 ALTER TABLE `apps_countries` DISABLE KEYS */;
INSERT INTO `apps_countries` VALUES (1,'AF','Afghanistan'),(2,'AL','Albania'),(3,'DZ','Algeria'),(4,'DS','American Samoa'),(5,'AD','Andorra'),(6,'AO','Angola'),(7,'AI','Anguilla'),(8,'AQ','Antarctica'),(9,'AG','Antigua and Barbuda'),(10,'AR','Argentina'),(11,'AM','Armenia'),(12,'AW','Aruba'),(13,'AU','Australia'),(14,'AT','Austria'),(15,'AZ','Azerbaijan'),(16,'BS','Bahamas'),(17,'BH','Bahrain'),(18,'BD','Bangladesh'),(19,'BB','Barbados'),(20,'BY','Belarus'),(21,'BE','Belgium'),(22,'BZ','Belize'),(23,'BJ','Benin'),(24,'BM','Bermuda'),(25,'BT','Bhutan'),(26,'BO','Bolivia'),(27,'BA','Bosnia and Herzegovina'),(28,'BW','Botswana'),(29,'BV','Bouvet Island'),(30,'BR','Brazil'),(31,'IO','British Indian Ocean Territory'),(32,'BN','Brunei Darussalam'),(33,'BG','Bulgaria'),(34,'BF','Burkina Faso'),(35,'BI','Burundi'),(36,'KH','Cambodia'),(37,'CM','Cameroon'),(38,'CA','Canada'),(39,'CV','Cape Verde'),(40,'KY','Cayman Islands'),(41,'CF','Central African Republic'),(42,'TD','Chad'),(43,'CL','Chile'),(44,'CN','China'),(45,'CX','Christmas Island'),(46,'CC','Cocos (Keeling) Islands'),(47,'CO','Colombia'),(48,'KM','Comoros'),(49,'CG','Congo'),(50,'CK','Cook Islands'),(51,'CR','Costa Rica'),(52,'HR','Croatia (Hrvatska)'),(53,'CU','Cuba'),(54,'CY','Cyprus'),(55,'CZ','Czech Republic'),(56,'DK','Denmark'),(57,'DJ','Djibouti'),(58,'DM','Dominica'),(59,'DO','Dominican Republic'),(60,'TP','East Timor'),(61,'EC','Ecuador'),(62,'EG','Egypt'),(63,'SV','El Salvador'),(64,'GQ','Equatorial Guinea'),(65,'ER','Eritrea'),(66,'EE','Estonia'),(67,'ET','Ethiopia'),(68,'FK','Falkland Islands (Malvinas)'),(69,'FO','Faroe Islands'),(70,'FJ','Fiji'),(71,'FI','Finland'),(72,'FR','France'),(73,'FX','France, Metropolitan'),(74,'GF','French Guiana'),(75,'PF','French Polynesia'),(76,'TF','French Southern Territories'),(77,'GA','Gabon'),(78,'GM','Gambia'),(79,'GE','Georgia'),(80,'DE','Germany'),(81,'GH','Ghana'),(82,'GI','Gibraltar'),(83,'GK','Guernsey'),(84,'GR','Greece'),(85,'GL','Greenland'),(86,'GD','Grenada'),(87,'GP','Guadeloupe'),(88,'GU','Guam'),(89,'GT','Guatemala'),(90,'GN','Guinea'),(91,'GW','Guinea-Bissau'),(92,'GY','Guyana'),(93,'HT','Haiti'),(94,'HM','Heard and Mc Donald Islands'),(95,'HN','Honduras'),(96,'HK','Hong Kong'),(97,'HU','Hungary'),(98,'IS','Iceland'),(99,'IN','India'),(100,'IM','Isle of Man'),(101,'ID','Indonesia'),(102,'IR','Iran (Islamic Republic of)'),(103,'IQ','Iraq'),(104,'IE','Ireland'),(105,'IL','Israel'),(106,'IT','Italy'),(107,'CI','Ivory Coast'),(108,'JE','Jersey'),(109,'JM','Jamaica'),(110,'JP','Japan'),(111,'JO','Jordan'),(112,'KZ','Kazakhstan'),(113,'KE','Kenya'),(114,'KI','Kiribati'),(115,'KP','Korea, Democratic People\'s Republic of'),(116,'KR','Korea, Republic of'),(117,'XK','Kosovo'),(118,'KW','Kuwait'),(119,'KG','Kyrgyzstan'),(120,'LA','Lao People\'s Democratic Republic'),(121,'LV','Latvia'),(122,'LB','Lebanon'),(123,'LS','Lesotho'),(124,'LR','Liberia'),(125,'LY','Libyan Arab Jamahiriya'),(126,'LI','Liechtenstein'),(127,'LT','Lithuania'),(128,'LU','Luxembourg'),(129,'MO','Macau'),(130,'MK','Macedonia'),(131,'MG','Madagascar'),(132,'MW','Malawi'),(133,'MY','Malaysia'),(134,'MV','Maldives'),(135,'ML','Mali'),(136,'MT','Malta'),(137,'MH','Marshall Islands'),(138,'MQ','Martinique'),(139,'MR','Mauritania'),(140,'MU','Mauritius'),(141,'TY','Mayotte'),(142,'MX','Mexico'),(143,'FM','Micronesia, Federated States of'),(144,'MD','Moldova, Republic of'),(145,'MC','Monaco'),(146,'MN','Mongolia'),(147,'ME','Montenegro'),(148,'MS','Montserrat'),(149,'MA','Morocco'),(150,'MZ','Mozambique'),(151,'MM','Myanmar'),(152,'NA','Namibia'),(153,'NR','Nauru'),(154,'NP','Nepal'),(155,'NL','Netherlands'),(156,'AN','Netherlands Antilles'),(157,'NC','New Caledonia'),(158,'NZ','New Zealand'),(159,'NI','Nicaragua'),(160,'NE','Niger'),(161,'NG','Nigeria'),(162,'NU','Niue'),(163,'NF','Norfolk Island'),(164,'MP','Northern Mariana Islands'),(165,'NO','Norway'),(166,'OM','Oman'),(167,'PK','Pakistan'),(168,'PW','Palau'),(169,'PS','Palestine'),(170,'PA','Panama'),(171,'PG','Papua New Guinea'),(172,'PY','Paraguay'),(173,'PE','Peru'),(174,'PH','Philippines'),(175,'PN','Pitcairn'),(176,'PL','Poland'),(177,'PT','Portugal'),(178,'PR','Puerto Rico'),(179,'QA','Qatar'),(180,'RE','Reunion'),(181,'RO','Romania'),(182,'RU','Russian Federation'),(183,'RW','Rwanda'),(184,'KN','Saint Kitts and Nevis'),(185,'LC','Saint Lucia'),(186,'VC','Saint Vincent and the Grenadines'),(187,'WS','Samoa'),(188,'SM','San Marino'),(189,'ST','Sao Tome and Principe'),(190,'SA','Saudi Arabia'),(191,'SN','Senegal'),(192,'RS','Serbia'),(193,'SC','Seychelles'),(194,'SL','Sierra Leone'),(195,'SG','Singapore'),(196,'SK','Slovakia'),(197,'SI','Slovenia'),(198,'SB','Solomon Islands'),(199,'SO','Somalia'),(200,'ZA','South Africa'),(201,'GS','South Georgia South Sandwich Islands'),(202,'ES','Spain'),(203,'LK','Sri Lanka'),(204,'SH','St. Helena'),(205,'PM','St. Pierre and Miquelon'),(206,'SD','Sudan'),(207,'SR','Suriname'),(208,'SJ','Svalbard and Jan Mayen Islands'),(209,'SZ','Swaziland'),(210,'SE','Sweden'),(211,'CH','Switzerland'),(212,'SY','Syrian Arab Republic'),(213,'TW','Taiwan'),(214,'TJ','Tajikistan'),(215,'TZ','Tanzania, United Republic of'),(216,'TH','Thailand'),(217,'TG','Togo'),(218,'TK','Tokelau'),(219,'TO','Tonga'),(220,'TT','Trinidad and Tobago'),(221,'TN','Tunisia'),(222,'TR','Turkey'),(223,'TM','Turkmenistan'),(224,'TC','Turks and Caicos Islands'),(225,'TV','Tuvalu'),(226,'UG','Uganda'),(227,'UA','Ukraine'),(228,'AE','United Arab Emirates'),(229,'GB','United Kingdom'),(230,'US','United States'),(231,'UM','United States minor outlying islands'),(232,'UY','Uruguay'),(233,'UZ','Uzbekistan'),(234,'VU','Vanuatu'),(235,'VA','Vatican City State'),(236,'VE','Venezuela'),(237,'VN','Vietnam'),(238,'VG','Virgin Islands (British)'),(239,'VI','Virgin Islands (U.S.)'),(240,'WF','Wallis and Futuna Islands'),(241,'EH','Western Sahara'),(242,'YE','Yemen'),(243,'YU','Yugoslavia'),(244,'ZR','Zaire'),(245,'ZM','Zambia'),(246,'ZW','Zimbabwe');
/*!40000 ALTER TABLE `apps_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backupreport`
--

DROP TABLE IF EXISTS `backupreport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backupreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backupreport`
--

LOCK TABLES `backupreport` WRITE;
/*!40000 ALTER TABLE `backupreport` DISABLE KEYS */;
INSERT INTO `backupreport` VALUES (6,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 11:03:25'),(7,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 11:08:48'),(8,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 11:09:06'),(9,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 11:20:15'),(12,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 13:30:49'),(13,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 13:31:56'),(14,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 13:32:01'),(16,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 15:38:53'),(19,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 18:38:26'),(20,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 18:40:59'),(21,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 18:44:53'),(22,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-08 18:51:06'),(23,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 12:21:09'),(24,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 12:21:55'),(25,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 12:25:17'),(26,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 14:48:43'),(27,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 14:51:37'),(28,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 14:55:59'),(29,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 14:58:21'),(30,'TestUser','/var/www/html/fireports/app/../web/sqlfiles/FIR_reports.sql','2016-12-10 15:06:52');
/*!40000 ALTER TABLE `backupreport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_users`
--

DROP TABLE IF EXISTS `company_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5372078C64B64DCC` (`userId`),
  CONSTRAINT `FK_5372078C64B64DCC` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_users`
--

LOCK TABLES `company_users` WRITE;
/*!40000 ALTER TABLE `company_users` DISABLE KEYS */;
INSERT INTO `company_users` VALUES (1,'companyId212',5),(2,'companyId212',6),(3,'companyId312',9),(4,'companyId212',11),(5,'companyId212',13),(6,'companyId212',14);
/*!40000 ALTER TABLE `company_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_group`
--

DROP TABLE IF EXISTS `email_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupstatus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_group`
--

LOCK TABLES `email_group` WRITE;
/*!40000 ALTER TABLE `email_group` DISABLE KEYS */;
INSERT INTO `email_group` VALUES (15,'Starsystem','companyId212',1),(16,'FIRgroup','companyId212',1),(17,'pioneer group','companyId212',1),(19,'shipping group','companyId212',1),(28,'Testing list','companyId212',1);
/*!40000 ALTER TABLE `email_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_users`
--

DROP TABLE IF EXISTS `email_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `useremailid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89CEE4667805AC12` (`groupid`),
  CONSTRAINT `FK_89CEE4667805AC12` FOREIGN KEY (`groupid`) REFERENCES `email_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_users`
--

LOCK TABLES `email_users` WRITE;
/*!40000 ALTER TABLE `email_users` DISABLE KEYS */;
INSERT INTO `email_users` VALUES (38,19,'satz123@gmail.com'),(39,19,'rob12@gmail.com'),(40,19,'devakumar1234@gmail.com'),(41,19,'sarath123@gmail.com'),(42,19,'david12@gmail.com'),(43,16,'sathishravi12@gmail.com'),(44,16,'satz123@gmail.com'),(55,17,'admin00@gmail.com'),(56,17,'testuser12@gmail.com'),(59,16,'testuser@gmail.com'),(60,15,'sathishr29@gmail.com'),(61,15,'satzkumar1234@gmail.com'),(62,17,'sarath12@gmail.com'),(64,28,'users123@gmail.com'),(65,28,'sam12300@gmail.com');
/*!40000 ALTER TABLE `email_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factorto_incident`
--

DROP TABLE IF EXISTS `factorto_incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factorto_incident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `factorName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `severityClassification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factorto_incident`
--

LOCK TABLES `factorto_incident` WRITE;
/*!40000 ALTER TABLE `factorto_incident` DISABLE KEYS */;
/*!40000 ALTER TABLE `factorto_incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `username_canonical` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(155) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user`
--

LOCK TABLES `fos_user` WRITE;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` VALUES (1,'admin','sathishr29@gmail.com',0,'ncpqgi28mj48ocwowo4o4cw84w8kkc','$2y$13$ncpqgi28mj48ocwowo4o4Ok6mtmHEc35F6hljz4XyD3sHGZNBGZMa',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'admin','sathishr29@gmail.com'),(2,'sathish','satzkumar1234@gmail.com',0,'awkqbt8qolc08owogk8wsgwco40kwws','$2y$13$awkqbt8qolc08owogk8wseRDPDDBXaXyrxM3rewlsaKljPQJT8TJW',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'sathish','satzkumar1234@gmail.com'),(3,'raja','raj@gmail.com',0,'eugtanrfrq8g0ow4kg8wgsog8o8cskw','$2y$13$eugtanrfrq8g0ow4kg8wgeGwcgb9DeNDrctyupRvWSVXzhOxVXY8.',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'raja','raj@gmail.com'),(4,'Hari','hprakashs143@gmail.com',0,'e5od84yw2fsc8040gk0844gw888o8cs','$2y$13$e5od84yw2fsc8040gk084usZHpu7J3mh9uiQNUkRnA0j5lhIdrIHm',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'hari','hprakashs143@gmail.com'),(5,'Test','satzkumar1234@gmail.com',0,'bqzobon2i680w48o0k8ww4wosw40c0c','$2y$13$bqzobon2i680w48o0k8wwuVS5UnjMNsqwmVz0F5m1GkbFc1zbBWL.',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'test','satzkumar1234@gmail.com');
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident`
--

DROP TABLE IF EXISTS `incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `incidentStatus` int(11) NOT NULL,
  `incidentUId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3D03A11A64B64DCC` (`userId`),
  CONSTRAINT `FK_3D03A11A64B64DCC` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident`
--

LOCK TABLES `incident` WRITE;
/*!40000 ALTER TABLE `incident` DISABLE KEYS */;
INSERT INTO `incident` VALUES (1,1,1,'INC-000001');
/*!40000 ALTER TABLE `incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_cost`
--

DROP TABLE IF EXISTS `incident_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incidentReportFinalCost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `offHireDays` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `managersCostUSD` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ownersCostUSD` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incidentFinalCostUSD` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timebetweenincidentandincidentmade` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateReportsenttoowners` datetime DEFAULT NULL,
  `timebetweenincidentreportmadeandreportsendtoowners` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incidentClosedbyOwners` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incidentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F22AE3433B411754` (`incidentId`),
  CONSTRAINT `FK_F22AE3433B411754` FOREIGN KEY (`incidentId`) REFERENCES `incident` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_cost`
--

LOCK TABLES `incident_cost` WRITE;
/*!40000 ALTER TABLE `incident_cost` DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_details`
--

DROP TABLE IF EXISTS `incident_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `totalDemage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rcaRequired` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `incidentDescription` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `immediateAction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `followupAction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `incidentId` int(11) DEFAULT NULL,
  `typeofCause` int(11) DEFAULT NULL,
  `operationattimeofIncident` int(11) DEFAULT NULL,
  `factortoIncident` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5EC11573B411754` (`incidentId`),
  KEY `IDX_D5EC115713E22428` (`typeofCause`),
  KEY `IDX_D5EC11574DF69FA1` (`operationattimeofIncident`),
  KEY `IDX_D5EC1157D6F8E224` (`factortoIncident`),
  CONSTRAINT `FK_D5EC115713E22428` FOREIGN KEY (`typeofCause`) REFERENCES `typeof_cause` (`id`),
  CONSTRAINT `FK_D5EC11573B411754` FOREIGN KEY (`incidentId`) REFERENCES `incident` (`id`),
  CONSTRAINT `FK_D5EC11574DF69FA1` FOREIGN KEY (`operationattimeofIncident`) REFERENCES `operationattimeof_incident` (`id`),
  CONSTRAINT `FK_D5EC1157D6F8E224` FOREIGN KEY (`factortoIncident`) REFERENCES `factorto_incident` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_details`
--

LOCK TABLES `incident_details` WRITE;
/*!40000 ALTER TABLE `incident_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_first_info`
--

DROP TABLE IF EXISTS `incident_first_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_first_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateofIncident` datetime DEFAULT NULL,
  `dateofIncidentreportMade` datetime DEFAULT NULL,
  `statusofReport` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incidentId` int(11) DEFAULT NULL,
  `typeofIncdientId` int(11) DEFAULT NULL,
  `shipId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_72B6F9D23B411754` (`incidentId`),
  KEY `IDX_72B6F9D2C60902EE` (`typeofIncdientId`),
  KEY `IDX_72B6F9D2EC8D6394` (`shipId`),
  CONSTRAINT `FK_72B6F9D23B411754` FOREIGN KEY (`incidentId`) REFERENCES `incident` (`id`),
  CONSTRAINT `FK_72B6F9D2C60902EE` FOREIGN KEY (`typeofIncdientId`) REFERENCES `typeof_incident` (`id`),
  CONSTRAINT `FK_72B6F9D2EC8D6394` FOREIGN KEY (`shipId`) REFERENCES `shipdetails` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_first_info`
--

LOCK TABLES `incident_first_info` WRITE;
/*!40000 ALTER TABLE `incident_first_info` DISABLE KEYS */;
INSERT INTO `incident_first_info` VALUES (1,'2016-12-06 05:13:00','2016-12-15 05:13:00','1','world wide',1,2,34);
/*!40000 ALTER TABLE `incident_first_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_operator_weather`
--

DROP TABLE IF EXISTS `incident_operator_weather`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_operator_weather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `whether` int(11) NOT NULL,
  `water` int(11) NOT NULL,
  `wind` int(11) NOT NULL,
  `windDirection` int(11) NOT NULL,
  `visiblity` int(11) NOT NULL,
  `tide` int(11) NOT NULL,
  `operator_sure_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_given_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_dob` datetime DEFAULT NULL,
  `operator_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_landline` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_LicenseType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `operator_LicenseNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `incidentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5D261133B411754` (`incidentId`),
  CONSTRAINT `FK_B5D261133B411754` FOREIGN KEY (`incidentId`) REFERENCES `incident` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_operator_weather`
--

LOCK TABLES `incident_operator_weather` WRITE;
/*!40000 ALTER TABLE `incident_operator_weather` DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_operator_weather` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_details`
--

DROP TABLE IF EXISTS `log_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `CreatedByID` int(11) NOT NULL,
  `CreatedOnDateTime` datetime NOT NULL,
  `TableName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TablePKID` int(11) NOT NULL,
  `oldvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fieldName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `newvalue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_details`
--

LOCK TABLES `log_details` WRITE;
/*!40000 ALTER TABLE `log_details` DISABLE KEYS */;
INSERT INTO `log_details` VALUES (1,12,'2016-11-30 15:45:39','Vessel Details',33,'sathish ship','shipName','star systems ship'),(2,12,'2016-11-30 15:47:41','Vessel Details',32,'sample1ship','shipName','testing ship'),(3,12,'2016-11-30 15:47:41','Vessel Details',32,'2000','size','0077'),(4,1,'2016-12-01 10:48:41','Vessel Details',30,'Emerald Bay	','shipName',' testing ship '),(5,1,'2016-12-01 12:58:15','Vessel Details',30,' testing ship ','shipName','  calm Bay '),(6,1,'2016-12-01 13:00:48','Vessel Details',30,'  calm Bay ','shipName','test'),(7,1,'2016-12-01 13:31:50','Vessel Details',32,'testing ship','shipName','sample1 vessels'),(8,1,'2016-12-01 13:31:50','Vessel Details',32,'0012345','imoNumber','1012345'),(9,1,'2016-12-08 13:17:36','Vessel Details',36,'AzureBay','shipName','AzureB'),(10,1,'2016-12-08 13:17:36','Vessel Details',36,'0003251','imoNumber',' 1122334  ');
/*!40000 ALTER TABLE `log_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mailingdetails`
--

DROP TABLE IF EXISTS `mailingdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mailingdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `senderMail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Date` datetime DEFAULT NULL,
  `sendername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Textcontent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mailingdetails`
--

LOCK TABLES `mailingdetails` WRITE;
/*!40000 ALTER TABLE `mailingdetails` DISABLE KEYS */;
INSERT INTO `mailingdetails` VALUES (130,'sathishr29@gmail.com','sending email as per user ','companyId312','starshipping123@gmail.com','2016-11-26 12:25:43','starsystems','0','user mail file attachment'),(134,'sathishr29@gmail.com','mail sending to specific users','companyId212','starshipping123@gmail.com','2016-11-28 12:50:17','TestUser','0','Report status'),(135,'sathishr29@gmail.com','mail sending to specific users','companyId212','starshipping123@gmail.com','2016-11-28 12:57:09','TestUser','0','user list status report'),(136,'starsystems','mail sending to specific users','companyId212','starshipping123@gmail.com','2016-11-28 13:19:06','TestUser','0','list of reports'),(137,'sathishr29@gmail.com','testing sample mail list','companyId212','starshipping123@gmail.com','2016-11-28 13:21:44','TestUser','0','report'),(138,'starsystems','sending mail to group of users','companyId212','starshipping123@gmail.com','2016-11-28 13:23:25','TestUser','0','group of user mails'),(141,'sathishr29@gmail.com','sending mail to group of users','companyId212','starshipping123@gmail.com','2016-11-28 15:22:06','TestUser','0','status reports'),(142,'sathishr29@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 15:23:08','TestUser','0','ccccc list'),(143,'sathishr29@gmail.com','testing sample mail list','companyId212','satzkumar1234@gmail.com','2016-11-28 15:29:54','TestUser','0','list of sample status'),(148,'satzkumar1234@gmail.com','testing sample mail list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:03:21','TestUser','0','\n                    '),(151,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:10','TestUser','0','user list &nbsp;reports'),(153,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:11','TestUser','0','user list &nbsp;reports'),(154,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:12','TestUser','0','user list &nbsp;reports'),(156,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:13','TestUser','0','user list &nbsp;reports'),(157,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:14','TestUser','0','user list &nbsp;reports'),(158,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:14','TestUser','0','user list &nbsp;reports'),(159,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:15','TestUser','0','user list &nbsp;reports'),(162,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:18','TestUser','0','user list &nbsp;reports'),(163,'satzkumar1234@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-28 18:04:18','TestUser','0','user list &nbsp;reports'),(164,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:27:59','TestUser','0','status report'),(165,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:03','TestUser','0','status report'),(166,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:09','TestUser','0','status report'),(167,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:13','TestUser','0','status report'),(168,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:19','TestUser','0','status report'),(169,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:23','TestUser','0','status report'),(170,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:26','TestUser','0','status report'),(171,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:30','TestUser','0','status report'),(172,'satzkumar1234@gmail.com','mail test','companyId212','satzkumar1234@gmail.com','2016-11-28 18:28:34','TestUser','0','status report'),(180,'sathishr29@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-11-30 19:16:43','TestUser','1','list added'),(181,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:36:26','TestUser','1','group of added messages'),(182,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:36:47','TestUser','1','group of added messages'),(183,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:36:58','TestUser','1','group of added messages'),(184,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:37:05','TestUser','1','group of added messages'),(185,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:37:09','TestUser','1','group of added messages'),(186,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:37:15','TestUser','0','group of added messages'),(187,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:37:20','TestUser','0','group of added messages'),(188,'satzkumar1234@gmail.com','semding email with subject','companyId212','satzkumar1234@gmail.com','2016-12-01 19:37:24','TestUser','0','group of added messages'),(189,'sathishr29@gmail.com','checking email list','companyId212','satzkumar1234@gmail.com','2016-12-09 11:59:15','TestUser','1','sending mail receipent');
/*!40000 ALTER TABLE `mailingdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_access_tokens`
--

DROP TABLE IF EXISTS `oauth2_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_access_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D247A21B19EB6921` (`client_id`),
  KEY `IDX_D247A21BA76ED395` (`user_id`),
  CONSTRAINT `FK_D247A21B19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_D247A21BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_access_tokens`
--

LOCK TABLES `oauth2_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_auth_codes`
--

DROP TABLE IF EXISTS `oauth2_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_auth_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A018A10D19EB6921` (`client_id`),
  KEY `IDX_A018A10DA76ED395` (`user_id`),
  CONSTRAINT `FK_A018A10D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_A018A10DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_auth_codes`
--

LOCK TABLES `oauth2_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth2_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_clients`
--

DROP TABLE IF EXISTS `oauth2_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_clients`
--

LOCK TABLES `oauth2_clients` WRITE;
/*!40000 ALTER TABLE `oauth2_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth2_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth2_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth2_refresh_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D394478C19EB6921` (`client_id`),
  KEY `IDX_D394478CA76ED395` (`user_id`),
  CONSTRAINT `FK_D394478C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
  CONSTRAINT `FK_D394478CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth2_refresh_tokens`
--

LOCK TABLES `oauth2_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth2_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth2_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operationattimeof_incident`
--

DROP TABLE IF EXISTS `operationattimeof_incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operationattimeof_incident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timeofIncident` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `severityClassification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operationattimeof_incident`
--

LOCK TABLES `operationattimeof_incident` WRITE;
/*!40000 ALTER TABLE `operationattimeof_incident` DISABLE KEYS */;
/*!40000 ALTER TABLE `operationattimeof_incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ship_status_details`
--

DROP TABLE IF EXISTS `ship_status_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_status_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activeDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ShipDetailsId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4D63CA015041247E` (`ShipDetailsId`),
  CONSTRAINT `FK_4D63CA015041247E` FOREIGN KEY (`ShipDetailsId`) REFERENCES `shipdetails` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=268 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_status_details`
--

LOCK TABLES `ship_status_details` WRITE;
/*!40000 ALTER TABLE `ship_status_details` DISABLE KEYS */;
INSERT INTO `ship_status_details` VALUES (91,'2016-11-14 19:12:51',NULL,'1',30),(92,'2016-11-21 16:47:27',NULL,'1',32),(93,NULL,'2016-11-21 17:51:44','0',30),(94,'2016-11-21 17:52:46',NULL,'1',30),(95,NULL,'2016-11-21 17:53:23','0',30),(96,'2016-11-21 17:55:11',NULL,'1',30),(97,NULL,'2016-11-21 17:55:12','0',30),(98,'2016-11-21 17:55:17',NULL,'1',30),(99,'2016-11-26 15:22:30',NULL,'1',33),(100,'2016-11-26 15:32:28',NULL,'1',34),(101,'2016-11-26 15:36:58',NULL,'1',35),(102,NULL,'2016-11-29 18:06:13','0',30),(103,'2016-11-29 18:08:04',NULL,'1',30),(104,NULL,'2016-11-29 18:51:54','0',30),(105,NULL,'2016-11-29 18:52:33','0',32),(106,NULL,'2016-11-29 19:06:07','0',33),(107,'2016-11-29 19:06:24',NULL,'1',33),(108,NULL,'2016-11-29 19:09:49','0',33),(109,NULL,'2016-11-29 19:11:33','0',34),(110,'2016-11-29 19:11:53',NULL,'1',34),(111,'2016-11-29 19:11:59',NULL,'1',33),(112,NULL,'2016-11-29 19:12:03','0',33),(113,'2016-11-29 19:12:53',NULL,'1',33),(114,'2016-11-29 19:14:01',NULL,'1',32),(115,NULL,'2016-11-29 19:14:13','0',32),(116,'2016-11-29 19:14:48',NULL,'1',32),(117,'2016-11-29 19:14:50',NULL,'1',30),(118,NULL,'2016-11-29 19:15:15','0',30),(119,'2016-11-29 19:15:18',NULL,'1',30),(120,NULL,'2016-11-29 19:15:19','0',32),(121,'2016-11-29 19:15:21',NULL,'1',32),(122,NULL,'2016-11-29 19:17:15','0',30),(123,'2016-11-29 19:17:17',NULL,'1',30),(124,NULL,'2016-11-29 19:17:18','0',32),(125,'2016-11-29 19:17:21',NULL,'1',32),(126,NULL,'2016-11-29 19:17:22','0',33),(127,'2016-11-29 19:17:23',NULL,'1',33),(128,NULL,'2016-11-29 19:17:24','0',34),(129,'2016-11-29 19:17:27',NULL,'1',34),(130,NULL,'2016-11-29 19:17:28','0',35),(131,'2016-11-29 19:17:29',NULL,'1',35),(132,'2016-11-29 19:17:54',NULL,'1',36),(133,NULL,'2016-11-29 19:18:13','0',36),(134,'2016-11-29 19:18:15',NULL,'1',36),(135,NULL,'2016-11-29 19:18:28','0',30),(136,'2016-11-29 19:18:30',NULL,'1',30),(137,NULL,'2016-11-29 19:18:31','0',32),(138,'2016-11-29 19:18:32',NULL,'1',32),(139,NULL,'2016-11-29 19:18:33','0',33),(140,'2016-11-29 19:18:34',NULL,'1',33),(141,'2016-11-29 19:22:27',NULL,'1',37),(142,NULL,'2016-11-30 10:43:14','0',37),(143,'2016-11-30 10:43:17',NULL,'1',37),(144,NULL,'2016-11-30 10:43:18','0',36),(145,NULL,'2016-11-30 10:43:43','0',33),(146,'2016-11-30 10:43:45',NULL,'1',33),(147,'2016-11-30 11:05:30',NULL,'1',38),(148,'2016-11-30 11:07:01',NULL,'1',39),(149,'2016-11-30 11:08:07',NULL,'1',40),(150,'2016-11-30 11:09:16',NULL,'1',41),(151,NULL,'2016-11-30 11:48:10','0',30),(152,NULL,'2016-11-30 11:48:12','0',32),(153,NULL,'2016-11-30 11:48:13','0',33),(154,NULL,'2016-11-30 11:48:17','0',37),(155,'2016-11-30 11:49:24',NULL,'1',33),(156,NULL,'2016-11-30 11:49:26','0',34),(157,'2016-11-30 11:49:27',NULL,'1',34),(158,NULL,'2016-11-30 11:49:29','0',35),(159,'2016-11-30 11:49:32',NULL,'1',35),(160,'2016-11-30 11:49:33',NULL,'1',36),(161,NULL,'2016-11-30 11:52:54','0',33),(162,'2016-11-30 11:52:56',NULL,'1',33),(163,NULL,'2016-11-30 11:52:58','0',34),(164,'2016-11-30 11:52:59',NULL,'1',34),(165,NULL,'2016-11-30 11:53:01','0',35),(166,'2016-11-30 11:53:03',NULL,'1',35),(167,NULL,'2016-11-30 11:53:05','0',36),(168,'2016-11-30 11:53:06',NULL,'1',36),(169,'2016-11-30 11:54:34',NULL,'1',30),(170,'2016-11-30 11:54:36',NULL,'1',32),(171,NULL,'2016-11-30 11:54:39','0',33),(172,NULL,'2016-11-30 11:54:40','0',34),(173,NULL,'2016-11-30 11:54:42','0',35),(174,NULL,'2016-11-30 11:55:03','0',41),(175,'2016-11-30 11:55:28',NULL,'1',41),(176,NULL,'2016-11-30 11:55:30','0',41),(177,'2016-11-30 12:04:18',NULL,'1',41),(178,NULL,'2016-11-30 12:04:20','0',41),(179,NULL,'2016-11-30 12:04:35','0',38),(180,'2016-11-30 12:04:50',NULL,'1',37),(181,'2016-11-30 12:05:31',NULL,'1',41),(182,NULL,'2016-11-30 12:05:40','0',41),(183,'2016-11-30 12:25:23',NULL,'1',34),(184,NULL,'2016-11-30 12:44:15','0',30),(185,'2016-11-30 15:53:31',NULL,'1',42),(186,NULL,'2016-11-30 15:55:08','0',40),(187,'2016-11-30 15:55:25',NULL,'1',40),(188,'2016-11-30 15:55:48',NULL,'1',41),(189,NULL,'2016-11-30 15:56:07','0',40),(190,'2016-11-30 15:56:14',NULL,'1',40),(191,NULL,'2016-11-30 15:56:17','0',40),(192,NULL,'2016-11-30 15:56:39','0',41),(193,'2016-11-30 15:56:42',NULL,'1',41),(194,NULL,'2016-11-30 15:57:04','0',41),(195,'2016-11-30 15:57:07',NULL,'1',41),(196,NULL,'2016-11-30 15:57:30','0',41),(197,'2016-11-30 15:57:33',NULL,'1',41),(198,NULL,'2016-11-30 15:58:04','0',42),(199,'2016-11-30 15:58:30',NULL,'1',42),(200,NULL,'2016-11-30 15:58:33','0',42),(201,NULL,'2016-11-30 15:58:43','0',41),(202,'2016-11-30 15:58:45',NULL,'1',41),(203,'2016-12-01 11:19:04',NULL,'1',43),(204,'2016-12-01 11:30:39',NULL,'1',44),(205,NULL,'2016-12-01 13:37:31','0',44),(206,'2016-12-01 13:37:41',NULL,'1',44),(207,NULL,'2016-12-01 13:37:42','0',43),(208,'2016-12-01 13:37:44',NULL,'1',43),(209,NULL,'2016-12-01 13:53:54','0',44),(210,'2016-12-01 14:43:37',NULL,'1',40),(211,NULL,'2016-12-01 14:43:55','0',40),(212,'2016-12-01 14:59:04',NULL,'1',40),(213,NULL,'2016-12-01 15:05:26','0',40),(214,'2016-12-01 15:17:29',NULL,'1',40),(215,NULL,'2016-12-01 15:19:16','0',40),(216,'2016-12-01 15:20:04',NULL,'1',40),(217,NULL,'2016-12-01 15:23:10','0',40),(218,'2016-12-01 15:23:35',NULL,'1',40),(219,'2016-12-01 15:32:02',NULL,'1',30),(220,NULL,'2016-12-01 15:33:03','0',39),(221,'2016-12-01 15:34:44',NULL,'1',38),(222,NULL,'2016-12-01 15:34:51','0',30),(223,'2016-12-01 15:35:22',NULL,'1',30),(224,NULL,'2016-12-01 15:37:24','0',37),(225,'2016-12-01 15:37:34',NULL,'1',39),(226,NULL,'2016-12-01 15:39:43','0',32),(227,'2016-12-01 15:39:48',NULL,'1',32),(228,NULL,'2016-12-01 15:39:52','0',34),(229,'2016-12-01 15:39:55',NULL,'1',35),(230,'2016-12-01 15:39:58',NULL,'1',37),(231,NULL,'2016-12-01 15:40:02','0',35),(232,NULL,'2016-12-01 15:40:39','0',39),(233,NULL,'2016-12-01 15:40:42','0',37),(234,'2016-12-01 15:40:47',NULL,'1',33),(235,'2016-12-01 15:40:51',NULL,'1',39),(236,NULL,'2016-12-01 15:42:06','0',38),(237,NULL,'2016-12-01 15:42:39','0',43),(238,'2016-12-01 15:42:44',NULL,'1',44),(239,'2016-12-01 15:42:50',NULL,'1',42),(240,NULL,'2016-12-01 15:43:09','0',42),(241,'2016-12-01 15:43:26',NULL,'1',43),(242,NULL,'2016-12-01 15:43:29','0',41),(243,'2016-12-01 16:09:03',NULL,'1',41),(244,NULL,'2016-12-01 16:09:05','0',41),(245,'2016-12-01 16:09:08',NULL,'1',42),(246,NULL,'2016-12-01 16:09:10','0',42),(247,NULL,'2016-12-01 16:09:12','0',43),(248,'2016-12-01 16:09:58',NULL,'1',42),(249,NULL,'2016-12-01 16:09:58','0',42),(250,'2016-12-01 16:10:01',NULL,'1',43),(251,NULL,'2016-12-01 16:10:03','0',43),(252,'2016-12-01 16:10:06',NULL,'1',41),(253,NULL,'2016-12-01 16:10:10','0',41),(254,'2016-12-01 16:11:26',NULL,'1',41),(255,NULL,'2016-12-01 16:16:02','0',41),(256,NULL,'2016-12-01 16:25:23','0',44),(257,'2016-12-01 16:26:17',NULL,'1',44),(258,'2016-12-01 16:28:43',NULL,'1',41),(259,NULL,'2016-12-01 16:28:46','0',41),(260,'2016-12-01 16:29:08',NULL,'1',41),(261,'2016-12-02 10:59:03',NULL,'1',43),(262,NULL,'2016-12-02 10:59:07','0',43),(263,NULL,'2016-12-02 10:59:30','0',32),(264,NULL,'2016-12-07 10:43:34','0',44),(265,'2016-12-07 10:43:38',NULL,'1',44),(266,'2016-12-09 11:21:01',NULL,'1',42),(267,NULL,'2016-12-09 11:24:34','0',44);
/*!40000 ALTER TABLE `ship_status_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ship_types`
--

DROP TABLE IF EXISTS `ship_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ShipType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_types`
--

LOCK TABLES `ship_types` WRITE;
/*!40000 ALTER TABLE `ship_types` DISABLE KEYS */;
INSERT INTO `ship_types` VALUES (1,'Cargo Ships'),(2,'Fishing Ships'),(3,'Passenger/Cruise ships'),(4,'Tankers'),(5,'High speed crafts'),(6,'Military ships');
/*!40000 ALTER TABLE `ship_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipdetails`
--

DROP TABLE IF EXISTS `shipdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shipdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ShipName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `imoNumber` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturingYear` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `built` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `gt` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `country` int(11) DEFAULT NULL,
  `shipType` int(11) DEFAULT NULL,
  `companyName` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7DADB301FAE99B7` (`ShipName`),
  KEY `IDX_7DADB3015373C966` (`country`),
  KEY `IDX_7DADB3012425D2CE` (`shipType`),
  CONSTRAINT `FK_7DADB3012425D2CE` FOREIGN KEY (`shipType`) REFERENCES `ship_types` (`id`),
  CONSTRAINT `FK_7DADB3015373C966` FOREIGN KEY (`country`) REFERENCES `apps_countries` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipdetails`
--

LOCK TABLES `shipdetails` WRITE;
/*!40000 ALTER TABLE `shipdetails` DISABLE KEYS */;
INSERT INTO `shipdetails` VALUES (30,'test','00125671','performing good','world wide','2009 January	','500mm','20003','22',18,1,'companyId375'),(32,'sample1 vessels','1012345','performing good','world wide','2009 January	','500mm','0077','22',5,1,'companyId212'),(33,'star systems ship','00123451','performing good','world wide','2009 January	','500mm','205','available',5,3,'companyId212'),(34,'Kite Bay	','9741736','performing good','world wide','2009 January	','Guoyu Ship Building	','500','25598',5,2,'companyId212'),(35,'testship','93436391','performing good','CHENNAI','2008 July	','233','72','available',5,2,'companyId212'),(36,'AzureB',' 1122334  ','performing good','world wide','2009 January	','900mm','205','22',4,2,'companyId212'),(37,'Mykonos ship','00712345','work good','world wide','2007 april','500mm','2000','33.76',18,5,'companyId212'),(38,'venusBay','110098765','work good','world wide','2009 January	','500mm','2.90','22',18,2,'companyId212'),(39,'calm Bay','0071234','work good','CHENNAI','2014','3.99mm','205','2',10,4,'companyId212'),(40,'Halong Bay','9087654','work good','dubai','2008 July	','900mm','2000','22',24,4,'companyId212'),(41,'Orion Bay','7126780','good','world wide','2009 January	','8.90mm','345','12',16,5,'companyId212'),(42,'samples ship','1234500','performing good','world wide','2008 July	','900mm','20003','yes',18,6,'companyId109'),(43,' calm Bay','1100234','performing good','world wide','2016 january','769mm','2000','22.5',18,1,'companyId212'),(44,'cargo ships','1122334','performing good','world wide','2008 July	','500mm','20003','available',1,1,'companyId212');
/*!40000 ALTER TABLE `shipdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeof_cause`
--

DROP TABLE IF EXISTS `typeof_cause`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeof_cause` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `causeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `severityClassification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeof_cause`
--

LOCK TABLES `typeof_cause` WRITE;
/*!40000 ALTER TABLE `typeof_cause` DISABLE KEYS */;
/*!40000 ALTER TABLE `typeof_cause` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `typeof_incident`
--

DROP TABLE IF EXISTS `typeof_incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `typeof_incident` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `incidentName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `severityClassification` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `typeof_incident`
--

LOCK TABLES `typeof_incident` WRITE;
/*!40000 ALTER TABLE `typeof_incident` DISABLE KEYS */;
INSERT INTO `typeof_incident` VALUES (1,'Test Incident',NULL),(2,'new incident',NULL),(3,'new incident',NULL),(4,'new incidentss',NULL);
/*!40000 ALTER TABLE `typeof_incident` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `companyId` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagepath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `systemsettings` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9C05FB297` (`confirmation_token`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'TestUser','testuser','satzkumar1234@gmail.com','satzkumar1234@gmail.com',1,'q3r262o7mtwo4ogw4c4004okckkco0c','$2y$13$q3r262o7mtwo4ogw4c400u6GTjtKNBH8oNf4pkJEXf2Z.ueKLbuMS','2016-12-10 15:18:37',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'companyId212',NULL,NULL,'1',NULL),(2,'sathish','sathish','satz1@gmail.com','satz1@gmail.com',1,'isvm82xajig440goc00ggcooww8og4g','$2y$13$isvm82xajig440goc00ggOF/rbWpoHXmteAieqeRgE/T4NeLYDEiW',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,NULL,'9176420055',NULL,NULL,NULL),(3,'admin','admin','satzkumar134@gmail.com','satzkumar134@gmail.com',1,'lr22pfa99nkg044g448sc8s88ks84c4','$2y$13$lr22pfa99nkg044g448scuwZ613qn6LMbSKUVHuaP6LgA8hDuYhYO',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MANAGER\";}',0,NULL,NULL,'9176807691',NULL,NULL,NULL),(4,'kumar','kumar','sawe12@gmail.com','sawe12@gmail.com',1,'ihl8nrgri5cgcss8wcgog8gss4ogo4c','$2y$13$ihl8nrgri5cgcss8wcgoguh/gWLvmdO7x3ScgL3ZJbHrOY4w7bR.C',NULL,0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,NULL,'917642908',NULL,NULL,NULL),(5,'sathishh','sathishh','sathishkumar','sathishkumar',1,'p1e5r8ymoaskccko4skws8k0sc480g4','$2y$13$p1e5r8ymoaskccko4skwsurOHyWRSBRi6QO91McIiwr7ye22TJd2K',NULL,1,0,NULL,NULL,NULL,'a:1:{i:0;s:11:\"ROLE_REPORT\";}',0,NULL,NULL,'9176807693',NULL,NULL,'sathishkumar'),(6,'satz','satz','kumar','kumar',1,'hju9kgymddkw88k8wocwwgo4wowg4wo','$2y$13$hju9kgymddkw88k8wocwwedrGNqr3uaSIWZ/aBwj91z/pz0JewY4y',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:11:\"ROLE_REPORT\";}',0,NULL,NULL,'9176807600',NULL,NULL,'kumar'),(7,'starsystems','starsystems','starshipping123@gmail.com','star123@gmail.com',1,'nrn56g4xh68oow84s0ooccsk0ook0s8','$2y$13$nrn56g4xh68oow84s0oocOFQ/Isr0A2VPh.rgCgt8oXDyiPF5.39C','2016-11-14 15:35:21',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'companyId312',NULL,NULL,'',NULL),(8,'shippingcompany','shippingcompany','shipping12@gmail.com','shipping12@gmail.com',1,'bga112zh6g8oc0ok04k40c48css44ck','$2y$13$bga112zh6g8oc0ok04k40OWTJGRTg8CGautEtHwPwPAs1fmdHojdW','2016-11-14 19:04:41',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'companyId375',NULL,NULL,'2',NULL),(9,'roberts','roberts','robert','robert',1,'m6vk6mehlmo40g0cc8ogc0go4k8cs8s','$2y$13$m6vk6mehlmo40g0cc8ogcuyNR/quPrBEkHOjhHs9sDJFSr1PfSqza',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MANAGER\";}',0,NULL,NULL,'9001234576',NULL,NULL,'robert'),(11,'ravi','ravi','sathishbravo','sathishbravo',1,'66iyu2q0m58g0o4o8sos44gwwg0k8c8','$2y$13$66iyu2q0m58g0o4o8sos4uf3IIx4wUvjzSsIRWrDN08HFA1gZ.jN2',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:11:\"ROLE_REPORT\";}',0,NULL,NULL,'9176420055',NULL,NULL,'sathishbravo'),(12,'Robert','robert','robert@gmail.com','robert@gmail.com',1,'jkhs0581ql4cwgskg88cswk8wk4o4cs','$2y$13$jkhs0581ql4cwgskg88csuL5JJRmjxZ1VzBdYeoqcmmEAdDUBnApO','2016-11-30 16:02:42',0,0,NULL,NULL,NULL,'a:1:{i:0;s:10:\"ROLE_ADMIN\";}',0,NULL,'companyId109',NULL,NULL,'2',NULL),(13,'samkumar','samkumar','sammm','sammm',1,'j08hrkwt8m8k0wgkw0goo04cs4s4ogg','$2y$13$j08hrkwt8m8k0wgkw0goou4mThAS8hdUXlR5SUGCcO87ebRZon2aS',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MANAGER\";}',0,NULL,NULL,'9001234566',NULL,NULL,'sammm'),(14,'Ravichandran','ravichandran','sathishkumar ravi','sathishkumar ravi',1,'azg1hrgqqncoocw4gos8g8g80okcoss','$2y$13$azg1hrgqqncoocw4gos8guXjTnwjd9DRIZ8sqTSB9IW4AW0nI1Sd6',NULL,0,0,NULL,NULL,NULL,'a:1:{i:0;s:12:\"ROLE_MANAGER\";}',0,NULL,NULL,'9176807688',NULL,NULL,'sathishkumar ravi');
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

-- Dump completed on 2016-12-10 15:19:58
