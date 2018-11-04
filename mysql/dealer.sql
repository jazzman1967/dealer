-- MySQL dump 10.16  Distrib 10.2.18-MariaDB, for Linux (i686)
--
-- Host: localhost    Database: dealer
-- ------------------------------------------------------
-- Server version	10.2.18-MariaDB

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
-- Table structure for table `account_types`
--

DROP TABLE IF EXISTS `account_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_types` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `type` enum('C','D') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `body_types`
--

DROP TABLE IF EXISTS `body_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `body_types` (
  `body_type_id` tinyint(4) NOT NULL,
  `description` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`body_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `coa`
--

DROP TABLE IF EXISTS `coa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coa` (
  `account` smallint(5) unsigned NOT NULL,
  `description` varchar(50) NOT NULL,
  `type_id` tinyint(3) unsigned DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`account`),
  KEY `type_id` (`type_id`),
  CONSTRAINT `coa_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `account_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `cust_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(27) DEFAULT NULL,
  `post_code` char(7) NOT NULL,
  `main_phone` char(12) NOT NULL,
  `work_phone` char(12) DEFAULT NULL,
  `work_ext` varchar(10) DEFAULT NULL,
  `cell_phone_1` char(12) DEFAULT NULL,
  `dns_flag_c1` tinyint(1) DEFAULT NULL,
  `cell_phone_2` char(12) DEFAULT NULL,
  `dns_flag_c2` tinyint(1) DEFAULT NULL,
  `email1` varchar(100) NOT NULL,
  `dns_flag_e1` tinyint(1) DEFAULT NULL,
  `email2` varchar(100) DEFAULT NULL,
  `dns_flag_e2` tinyint(1) DEFAULT NULL,
  `email3` varchar(100) DEFAULT NULL,
  `dns_flag_e3` tinyint(1) DEFAULT NULL,
  `last_purch_date` date DEFAULT NULL,
  `vendor_id` smallint(5) unsigned DEFAULT NULL,
  `license` varchar(255) DEFAULT NULL,
  `license_expiry` date DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `lead_id` tinyint(3) unsigned DEFAULT NULL,
  `tax_exempt` tinyint(1) DEFAULT NULL,
  `tax_number` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`cust_id`),
  KEY `prov_id` (`province`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fee_sales`
--

DROP TABLE IF EXISTS `fee_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee_sales` (
  `deal_id` int(10) unsigned NOT NULL,
  `line_number` smallint(5) unsigned NOT NULL,
  `fee_id` smallint(5) unsigned NOT NULL,
  `sale_amt` decimal(10,2) NOT NULL,
  `sale_account` smallint(5) unsigned NOT NULL,
  `cost_amt` decimal(10,2) DEFAULT NULL,
  `cost_account` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`deal_id`,`line_number`),
  KEY `fee_id` (`fee_id`),
  KEY `sale_account` (`sale_account`),
  KEY `cost_account` (`cost_account`),
  CONSTRAINT `fee_sales_ibfk_1` FOREIGN KEY (`deal_id`) REFERENCES `sales` (`deal_id`),
  CONSTRAINT `fee_sales_ibfk_2` FOREIGN KEY (`fee_id`) REFERENCES `fees` (`fee_id`),
  CONSTRAINT `fee_sales_ibfk_3` FOREIGN KEY (`sale_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `fee_sales_ibfk_4` FOREIGN KEY (`cost_account`) REFERENCES `coa` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gl_detail`
--

DROP TABLE IF EXISTS `gl_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gl_detail` (
  `tx_id` bigint(20) unsigned NOT NULL,
  `line_number` tinyint(3) unsigned NOT NULL,
  `account` smallint(5) unsigned NOT NULL,
  `journal_id` int(10) unsigned NOT NULL,
  `cust_id` mediumint(8) unsigned DEFAULT NULL,
  `vendor_id` smallint(5) unsigned DEFAULT NULL,
  `vehicle_id` int(10) unsigned DEFAULT NULL,
  `control` varchar(25) DEFAULT NULL,
  `type` enum('D','C') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gl_header`
--

DROP TABLE IF EXISTS `gl_header`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gl_header` (
  `tx_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tx_date` date DEFAULT NULL,
  `total_dr_amount` decimal(10,2) DEFAULT NULL,
  `total_cr_amount` decimal(10,2) DEFAULT NULL,
  `post_description` varchar(255) DEFAULT NULL,
  `source` enum('A/P','A/R','Sales','General') DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`tx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journals` (
  `journal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`journal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `makes`
--

DROP TABLE IF EXISTS `makes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `makes` (
  `make_id` tinyint(3) unsigned NOT NULL,
  `make` varchar(40) NOT NULL,
  PRIMARY KEY (`make_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `model_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `model_code` varchar(20) DEFAULT NULL,
  `make` varchar(50) DEFAULT NULL,
  `description` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`model_id`),
  KEY `make_id` (`make`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `cost_amount` decimal(10,2) DEFAULT NULL,
  `sale_amount` decimal(10,2) NOT NULL,
  `cost_account` smallint(5) unsigned DEFAULT NULL,
  `sale_account` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cost_account` (`cost_account`),
  KEY `sale_account` (`sale_account`),
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`cost_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `options_ibfk_2` FOREIGN KEY (`sale_account`) REFERENCES `coa` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `account` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`account`) REFERENCES `coa` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provinces` (
  `prov_id` tinyint(4) NOT NULL,
  `province` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`prov_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `deal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock` varchar(25) NOT NULL,
  `cust_id` mediumint(8) unsigned NOT NULL,
  `sale_amt` decimal(10,2) NOT NULL,
  `sale_account` smallint(5) unsigned NOT NULL,
  `cost_amt` decimal(10,2) NOT NULL,
  `cost_account` smallint(5) unsigned NOT NULL,
  `date_sold` date NOT NULL,
  `taxes` decimal(7,2) DEFAULT NULL,
  `cash_amt` decimal(10,2) DEFAULT NULL,
  `finance_amt` decimal(10,2) DEFAULT NULL,
  `vendor_id` smallint(5) unsigned DEFAULT NULL,
  `line_count` smallint(6) DEFAULT NULL,
  `taxmod` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`deal_id`),
  KEY `stock` (`stock`),
  KEY `sale_account` (`sale_account`),
  KEY `cost_account` (`cost_account`),
  KEY `vendor_id` (`vendor_id`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`stock`) REFERENCES `vehicles` (`stock`),
  CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`sale_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`cost_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `sales_ibfk_5` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`),
  CONSTRAINT `sales_ibfk_6` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `rate` decimal(6,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `sale_account` smallint(5) unsigned NOT NULL,
  `cost_account` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_account` (`sale_account`),
  KEY `cost_account` (`cost_account`),
  CONSTRAINT `templates_ibfk_1` FOREIGN KEY (`sale_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `templates_ibfk_2` FOREIGN KEY (`cost_account`) REFERENCES `coa` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `vehicle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vin` char(17) NOT NULL,
  `stock` varchar(25) NOT NULL,
  `cust_id` mediumint(8) unsigned DEFAULT NULL,
  `year` year(4) NOT NULL,
  `make` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `colour` varchar(35) DEFAULT NULL,
  `plate` varchar(10) DEFAULT NULL,
  `mileage` mediumint(8) unsigned DEFAULT NULL,
  `original_sold_date` date DEFAULT NULL,
  `original_delivery_date` date DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `num_previous_owners` tinyint(3) unsigned DEFAULT NULL,
  `status` enum('available','pending','test drive','offer','sold') DEFAULT NULL,
  `engine_type` enum('combustion','hybrid','electric') DEFAULT NULL,
  `drive_type` enum('4WD','2WD FRONT','2WD REAR','AWD','N/A') DEFAULT NULL,
  `axles` tinyint(3) unsigned DEFAULT NULL,
  `body_type_id` tinyint(3) unsigned DEFAULT NULL,
  `cylinders` tinyint(3) unsigned DEFAULT NULL,
  `horsepower` smallint(5) unsigned DEFAULT NULL,
  `transmission` enum('automatic','manual','none') DEFAULT NULL,
  `speeds` tinyint(3) unsigned DEFAULT NULL,
  `seats` tinyint(3) unsigned DEFAULT NULL,
  `doors` tinyint(3) unsigned DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `fuel_hwy` smallint(5) unsigned DEFAULT NULL,
  `fuel_city` smallint(5) unsigned DEFAULT NULL,
  `electric_range` smallint(5) unsigned DEFAULT NULL,
  `motor_size` smallint(5) unsigned DEFAULT NULL,
  `chg120` tinyint(3) unsigned DEFAULT NULL,
  `chg240` tinyint(3) unsigned DEFAULT NULL,
  `inventory_account` smallint(5) unsigned NOT NULL,
  `hits` mediumint(8) unsigned DEFAULT NULL,
  `sold_date` date DEFAULT NULL,
  `description` varchar(2500) DEFAULT NULL,
  `entry_date` date DEFAULT NULL,
  PRIMARY KEY (`vehicle_id`),
  UNIQUE KEY `vin` (`vin`),
  UNIQUE KEY `stock` (`stock`),
  KEY `inventory_account` (`inventory_account`),
  KEY `cust_id` (`cust_id`),
  CONSTRAINT `vehicles_ibfk_2` FOREIGN KEY (`inventory_account`) REFERENCES `coa` (`account`),
  CONSTRAINT `vehicles_ibfk_3` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vendor_contacts`
--

DROP TABLE IF EXISTS `vendor_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor_contacts` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` smallint(5) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `phone` char(12) NOT NULL,
  `ext` varchar(10) DEFAULT NULL,
  `cell_phone` char(12) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `vendor_id` (`vendor_id`),
  CONSTRAINT `vendor_contacts_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendors` (
  `vendor_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(25) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `prov_id` tinyint(4) DEFAULT NULL,
  `post_code` char(7) DEFAULT NULL,
  `phone` char(12) NOT NULL,
  `web_address` varchar(150) DEFAULT NULL,
  `account` varchar(75) DEFAULT NULL,
  `last_purch_date` date DEFAULT NULL,
  PRIMARY KEY (`vendor_id`),
  KEY `prov_id` (`prov_id`),
  CONSTRAINT `vendors_ibfk_1` FOREIGN KEY (`prov_id`) REFERENCES `provinces` (`prov_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-04 15:36:33
