-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: catering_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `actor_name` varchar(255) DEFAULT NULL,
  `actor_email` varchar(255) DEFAULT NULL,
  `actor_role` varchar(20) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `method` varchar(12) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `activity_date` date NOT NULL,
  `activity_time` time NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_actor_email_created_at_index` (`actor_email`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (172,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','192.168.18.52','2026-08-15','04:54:41','Signed in to the admin panel.','2026-08-14 20:54:41','2026-08-14 20:54:41'),(173,NULL,'Primary Administrator','admin@3yos.com','full','Updated reservation status','PATCH','192.168.18.52','2026-08-15','04:58:47','Changed reservation #2 status to Cancelled.','2026-08-14 20:58:47','2026-08-14 20:58:47'),(174,NULL,'Primary Administrator','admin@3yos.com','full','Signed out','SESSION','192.168.18.52','2026-08-15','04:59:55','Signed out to the admin panel.','2026-08-14 20:59:55','2026-08-14 20:59:55'),(175,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','192.168.18.52','2026-08-15','05:00:11','Signed in to the admin panel.','2026-08-14 21:00:11','2026-08-14 21:00:11'),(176,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-08-15','05:20:02','Signed in to the admin panel.','2026-08-14 21:20:02','2026-08-14 21:20:02'),(177,NULL,'Primary Administrator','admin@3yos.com','full','Signed out','SESSION','127.0.0.1','2026-08-15','05:23:00','Signed out to the admin panel.','2026-08-14 21:23:00','2026-08-14 21:23:00'),(178,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-08-15','06:01:03','Signed in to the admin panel.','2026-08-14 22:01:03','2026-08-14 22:01:03'),(179,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:02:14','Sent an email reply for inquiry #2.','2026-08-14 22:02:14','2026-08-14 22:02:14'),(180,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:03:01','Sent an email reply for inquiry #2.','2026-08-14 22:03:01','2026-08-14 22:03:01'),(181,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:03:58','Sent an email reply for inquiry #2.','2026-08-14 22:03:58','2026-08-14 22:03:58'),(182,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:04:11','Sent an email reply for inquiry #2.','2026-08-14 22:04:11','2026-08-14 22:04:11'),(183,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:21:55','Sent an email reply for inquiry #2.','2026-08-14 22:21:55','2026-08-14 22:21:55'),(184,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:22:46','Sent an email reply for inquiry #2.','2026-08-14 22:22:46','2026-08-14 22:22:46'),(185,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-15','06:23:08','Sent an email reply for inquiry #2.','2026-08-14 22:23:08','2026-08-14 22:23:08'),(186,NULL,'Primary Administrator','admin@3yos.com','full','Signed out','SESSION','127.0.0.1','2026-08-15','06:23:37','Signed out to the admin panel.','2026-08-14 22:23:37','2026-08-14 22:23:37'),(187,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-08-17','06:38:05','Signed in to the admin panel.','2026-08-16 22:38:05','2026-08-16 22:38:05'),(188,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-08-17','06:39:18','Sent an email reply for inquiry #2.','2026-08-16 22:39:18','2026-08-16 22:39:18'),(189,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-08-17','07:54:07','Signed in to the admin panel.','2026-08-16 23:54:07','2026-08-16 23:54:07'),(190,NULL,'Primary Administrator','admin@3yos.com','full','Updated reservation status','PATCH','127.0.0.1','2026-08-17','07:54:25','Changed reservation #2 status to Completed.','2026-08-16 23:54:25','2026-08-16 23:54:25'),(191,NULL,'Primary Administrator','admin@3yos.com','full','Added gallery item','POST','127.0.0.1','2026-08-17','07:55:01','Added gallery item “MOON”.','2026-08-16 23:55:01','2026-08-16 23:55:01'),(192,NULL,'Primary Administrator','admin@3yos.com','full','Added gallery item','POST','127.0.0.1','2026-08-17','07:56:09','Added gallery item “Moon”.','2026-08-16 23:56:09','2026-08-16 23:56:09'),(193,NULL,'Primary Administrator','admin@3yos.com','full','Added gallery item','POST','127.0.0.1','2026-08-17','07:56:26','Added gallery item “Moon”.','2026-08-16 23:56:26','2026-08-16 23:56:26'),(194,NULL,'Primary Administrator','admin@3yos.com','full','Added gallery item','POST','127.0.0.1','2026-08-17','07:56:51','Added gallery item “Moon”.','2026-08-16 23:56:51','2026-08-16 23:56:51'),(195,NULL,'Primary Administrator','admin@3yos.com','full','Deleted gallery item','DELETE','127.0.0.1','2026-08-17','07:57:02','Deleted gallery item “Moon”.','2026-08-16 23:57:02','2026-08-16 23:57:02'),(196,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-01','15:56:47','Signed in to the admin panel.','2026-09-01 07:56:47','2026-09-01 07:56:47'),(197,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-03','15:45:02','Signed in to the admin panel.','2026-09-03 07:45:02','2026-09-03 07:45:02'),(198,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-09','10:04:01','Signed in to the admin panel.','2026-09-09 02:04:01','2026-09-09 02:04:01'),(199,NULL,'Primary Administrator','admin@3yos.com','full','Deleted gallery item','DELETE','127.0.0.1','2026-09-09','10:04:20','Deleted gallery item “Moon”.','2026-09-09 02:04:20','2026-09-09 02:04:20'),(200,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-09','11:10:00','Signed in to the admin panel.','2026-09-09 03:10:00','2026-09-09 03:10:00'),(201,NULL,'Primary Administrator','admin@3yos.com','full','Updated reservation status','PATCH','127.0.0.1','2026-09-09','11:15:47','Changed reservation #2 status to Confirmed.','2026-09-09 03:15:47','2026-09-09 03:15:47'),(202,NULL,'Primary Administrator','admin@3yos.com','full','Updated reservation status','PATCH','127.0.0.1','2026-09-09','11:36:54','Changed reservation #2 status to Confirmed.','2026-09-09 03:36:54','2026-09-09 03:36:54'),(203,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-09','11:59:10','POST admin/reservations/2/service-contract','2026-09-09 03:59:10','2026-09-09 03:59:10'),(204,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-09','12:04:55','POST admin/reservations/2/service-contract','2026-09-09 04:04:55','2026-09-09 04:04:55'),(205,NULL,'Primary Administrator','admin@3yos.com','full','Updated reservation status','PATCH','127.0.0.1','2026-09-09','12:05:11','Changed reservation #2 status to Confirmed.','2026-09-09 04:05:11','2026-09-09 04:05:11'),(206,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-09','14:02:19','DELETE admin/backups','2026-09-09 06:02:19','2026-09-09 06:02:19'),(207,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-09','14:02:24','DELETE admin/backups','2026-09-09 06:02:24','2026-09-09 06:02:24'),(208,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-09','14:02:32','DELETE admin/backups','2026-09-09 06:02:32','2026-09-09 06:02:32'),(209,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-09','14:07:13','POST admin/backups/create','2026-09-09 06:07:13','2026-09-09 06:07:13'),(210,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-09','14:07:18','POST admin/backups/download','2026-09-09 06:07:18','2026-09-09 06:07:18'),(211,NULL,'Primary Administrator','admin@3yos.com','full','Replied to inquiry','POST','127.0.0.1','2026-09-09','14:12:05','Sent an email reply for inquiry #2.','2026-09-09 06:12:05','2026-09-09 06:12:05'),(212,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-09','17:30:21','Signed in to the admin panel.','2026-09-09 09:30:21','2026-09-09 09:30:21'),(213,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-09','18:10:12','Signed in to the admin panel.','2026-09-09 10:10:12','2026-09-09 10:10:12'),(214,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','PUT','127.0.0.1','2026-09-09','18:13:45','PUT admin/team-admins/1/reset-password','2026-09-09 10:13:45','2026-09-09 10:13:45'),(215,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-19','11:22:09','Signed in to the admin panel.','2026-09-19 03:22:09','2026-09-19 03:22:09'),(216,NULL,'Primary Administrator','admin@3yos.com','full','Signed out','SESSION','127.0.0.1','2026-09-19','11:41:28','Signed out to the admin panel.','2026-09-19 03:41:28','2026-09-19 03:41:28'),(217,NULL,'Primary Administrator','admin@3yos.com','full','Signed in','SESSION','127.0.0.1','2026-09-19','11:45:20','Signed in to the admin panel.','2026-09-19 03:45:20','2026-09-19 03:45:20'),(218,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-19','12:36:00','POST admin/reservations/2/service-contract','2026-09-19 04:36:00','2026-09-19 04:36:00'),(219,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','POST','127.0.0.1','2026-09-19','12:36:04','POST admin/reservations/2/service-contract','2026-09-19 04:36:04','2026-09-19 04:36:04'),(220,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-19','12:40:01','DELETE admin/reservations/2/service-contract/3','2026-09-19 04:40:01','2026-09-19 04:40:01'),(221,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-19','12:40:06','DELETE admin/reservations/2/service-contract/2','2026-09-19 04:40:06','2026-09-19 04:40:06'),(222,NULL,'Primary Administrator','admin@3yos.com','full','Performed admin action','DELETE','127.0.0.1','2026-09-19','12:40:10','DELETE admin/reservations/2/service-contract/1','2026-09-19 04:40:10','2026-09-19 04:40:10');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Jervy “Jerv” Fontanilla','jervyfontanilla5@gmail.com','09633559185','Stonecrest','2026-07-26 03:15:08','2026-07-26 03:15:08'),(2,'Jervy “Jerv” Fontanilla','fontanillajervy@gmail.com','09633559185','San Jose Community High School','2026-09-19 05:20:52','2026-09-19 05:20:52'),(3,'fontanillajervy','kouseeeeiiiii@gmail.com','09633559185','San Jose Community High School','2026-09-19 05:27:59','2026-09-19 05:27:59'),(4,'effuhwefuwh','jsdvsjcskjcnsj@gmail.com','98734823472983','jhfcfkjcbsnckjs','2026-09-19 07:59:42','2026-09-19 07:59:42');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_items`
--

DROP TABLE IF EXISTS `gallery_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_items`
--

LOCK TABLES `gallery_items` WRITE;
/*!40000 ALTER TABLE `gallery_items` DISABLE KEYS */;
INSERT INTO `gallery_items` VALUES (1,'MOON',NULL,'gallery/E8VjTe8ChqobNWfiujcgkysN3MNjDy4tWR4HseMZ.jpg','Birthday',0,'2026-08-16 23:55:01','2026-08-16 23:55:01'),(2,'Moon',NULL,'gallery/SDqeQsQRrsnyXUiySzIeVgq9y1XQYkxElX30Axg3.jpg','Birthday',0,'2026-08-16 23:56:09','2026-08-16 23:56:09');
/*!40000 ALTER TABLE `gallery_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inquiries`
--

DROP TABLE IF EXISTS `inquiries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inquiries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inquiries`
--

LOCK TABLES `inquiries` WRITE;
/*!40000 ALTER TABLE `inquiries` DISABLE KEYS */;
INSERT INTO `inquiries` VALUES (1,'Jervy “Jerv” Fontanilla','5646546456','jervyfontanilla5@gmail.com','cgfhb','Custom Event','potangina',NULL,NULL,'in_progress','2026-07-26 23:50:20','2026-08-14 20:59:32'),(2,'Jervy “Jerv” Fontanilla','09633559185','jervyfontanilla5@gmail.com','cgfhb','Packages','about packages','Hello','2026-09-09 06:12:05','responded','2026-08-07 16:56:41','2026-09-09 06:12:05');
/*!40000 ALTER TABLE `inquiries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_01_000000_create_services_table',1),(5,'2024_01_01_000001_create_packages_table',1),(6,'2024_01_01_000002_create_clients_table',1),(7,'2024_01_01_000003_create_reservations_table',1),(8,'2024_01_01_000004_create_inquiries_table',1),(9,'2024_01_01_000005_create_activity_logs_table',1),(10,'2024_01_01_000006_create_settings_table',1),(11,'2024_01_01_000007_create_notification_templates_table',1),(12,'2026_07_26_000000_add_signature_catering_packages',1),(13,'2026_07_26_000001_add_role_to_users_table',1),(14,'2026_08_13_000000_add_reply_to_inquiries_table',1),(15,'2026_08_13_000001_create_gallery_items_table',1),(16,'2026_08_13_000002_add_actor_details_to_activity_logs_table',1),(17,'2026_09_09_000000_add_service_contract_to_reservations_table',1),(18,'2026_09_09_000001_add_service_contracts_to_reservations_table',1),(19,'2026_09_19_000000_add_reservation_code_to_reservations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_templates`
--

DROP TABLE IF EXISTS `notification_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `body` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_templates`
--

LOCK TABLES `notification_templates` WRITE;
/*!40000 ALTER TABLE `notification_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `min_guests` int(11) NOT NULL DEFAULT 0,
  `max_guests` int(11) NOT NULL DEFAULT 0,
  `menu` text DEFAULT NULL,
  `freebies` text DEFAULT NULL,
  `addons` text DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (1,'Silver','silver','A generous, polished buffet for relaxed celebrations and intimate gatherings.',550.00,30,80,'2 mains, pasta or noodles, vegetables, rice, dessert, and iced tea','Basic buffet styling, menu labels, and trained service crew','Dessert station, tablescape styling, and additional mains','Birthdays, reunions, and simple celebrations',0,'2026-08-12 12:44:30','2026-08-12 12:44:30'),(2,'Gold','gold','A crowd-pleasing selection with elevated presentation for milestone moments.',750.00,50,150,'3 mains, pasta, vegetables, rice, dessert station, and refreshments','Styled buffet setup, menu labels, basic floral accents, and service crew','Grazing table, mocktail bar, and upgraded styling','Debuts, anniversaries, and company events',1,'2026-08-12 12:44:30','2026-08-12 12:44:30'),(3,'Platinum','platinum','A refined menu and fuller service for memorable celebrations with more to share.',950.00,80,250,'4 mains, pasta, vegetables, rice, premium dessert station, and drinks','Enhanced tablescape, welcome drinks, menu labels, and dedicated event lead','Live station, mobile bar, and premium floral styling','Weddings, launches, and formal celebrations',0,'2026-08-12 12:44:30','2026-08-12 12:44:30'),(4,'Diamond','diamond','Our most complete celebration experience, tailored for grand and unforgettable events.',1250.00,120,400,'5 mains, live station, pasta, vegetables, rice, premium desserts, and drinks','Full event styling consultation, upgraded tablescape, service team, and event lead','Custom menu development, lounge setup, and premium bar service','Luxury weddings, gala dinners, and large-scale events',0,'2026-08-12 12:44:30','2026-08-12 12:44:30');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned DEFAULT NULL,
  `package_id` bigint(20) unsigned DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(255) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `guest_count` int(11) NOT NULL,
  `estimated_budget` decimal(12,2) NOT NULL DEFAULT 0.00,
  `additional_services` text DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `service_contract` varchar(255) DEFAULT NULL,
  `service_contracts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`service_contracts`)),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `reservation_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reservations_reservation_code_unique` (`reservation_code`),
  KEY `reservations_client_id_foreign` (`client_id`),
  KEY `reservations_package_id_foreign` (`package_id`),
  CONSTRAINT `reservations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reservations_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` VALUES (1,1,NULL,'Jervy “Jerv” Fontanilla','09633559185','jervyfontanilla5@gmail.com','Stonecrest','Birthday','2026-07-26','10am','Cavite',25,1000.00,NULL,NULL,NULL,NULL,NULL,'completed','RES-53781E1F','2026-07-26 03:15:08','2026-08-12 13:33:24'),(2,1,1,'Jervy “Jerv” Fontanilla','09633559185','jervyfontanilla5@gmail.com','Stonecrest','Debut','2026-08-13','18:50','Cavite',50,4999.63,'sound system,',NULL,NULL,NULL,'[\"service-contracts\\/KPUQCWLqMoDWhVupdxLqPJLcodn08dwFszTj9kLj.jpg\"]','confirmed','RES-C3F3610E','2026-08-07 16:53:48','2026-09-19 04:40:10'),(3,2,3,'Jervy “Jerv” Fontanilla','09633559185','fontanillajervy@gmail.com','San Jose Community High School','Wedding','2026-09-30','00:22','Cavite',144,1232322.00,NULL,NULL,NULL,NULL,NULL,'pending','RES-OCHY7OEK','2026-09-19 05:20:52','2026-09-19 05:20:52'),(4,3,2,'fontanillajervy','09633559185','kouseeeeiiiii@gmail.com','San Jose Community High School','Wedding','2026-09-29','09:32','Cavite',80,7698886.00,NULL,NULL,NULL,NULL,NULL,'pending','RES-GFNGLZQJ','2026-09-19 05:27:59','2026-09-19 05:27:59'),(5,4,3,'effuhwefuwh','98734823472983','jsdvsjcskjcnsj@gmail.com','jhfcfkjcbsnckjs','Debut','2026-09-23','11:01','adadadd',12,12312.00,NULL,NULL,NULL,NULL,NULL,'pending','RES-HXDAOOPR','2026-09-19 07:59:42','2026-09-19 07:59:42');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'limited',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin-jervy','jervyfontanilla5@gmail.com',NULL,'$2y$12$iK7w.DOstT0vbieQpyQQ5uJer8y0oUTinpAgPUTX2BfeDwXnx3Ora','limited',NULL,'2026-07-26 06:31:51','2026-09-09 10:13:45'),(2,'daluyo','daluyo@3yos.com',NULL,'$2y$12$X5OAk9t15C5CMhfAD.IYLOm2CeLUIfpnQmKfQyddcv50Xf0Zy31F.','limited',NULL,'2026-07-26 23:45:19','2026-07-26 23:45:19');
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

-- Dump completed on 2026-09-20  0:34:10
