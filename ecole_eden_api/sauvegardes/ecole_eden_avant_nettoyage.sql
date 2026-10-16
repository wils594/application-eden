-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ecole_eden
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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'information',
  `published_at` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `target_all_parents` tinyint(1) NOT NULL DEFAULT 1,
  `target_classes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`target_classes`)),
  `created_by` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_created_by_foreign` (`created_by`),
  CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bulletins`
--

DROP TABLE IF EXISTS `bulletins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulletins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `term` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `validated_by` bigint(20) unsigned DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bulletins_student_term_year_unique` (`student_id`,`term`,`school_year`),
  KEY `bulletins_validated_by_foreign` (`validated_by`),
  CONSTRAINT `bulletins_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bulletins_validated_by_foreign` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulletins`
--

LOCK TABLES `bulletins` WRITE;
/*!40000 ALTER TABLE `bulletins` DISABLE KEYS */;
INSERT INTO `bulletins` VALUES (1,5,'1er trimestre','2026-2027','bulletins/5/2026-2027_a5641a005e791b9e70d264e6a286fe7a.pdf',NULL,'2026-10-14 22:22:19','published','2026-10-14 22:00:00','2026-10-14 22:22:19');
/*!40000 ALTER TABLE `bulletins` ENABLE KEYS */;
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
  `expiration` bigint(20) NOT NULL,
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
  `expiration` bigint(20) NOT NULL,
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
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conversations_parent_id_unique` (`parent_id`),
  CONSTRAINT `conversations_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

LOCK TABLES `conversations` WRITE;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
INSERT INTO `conversations` VALUES (1,2,'2026-10-16 19:42:54','2026-10-16 19:40:51','2026-10-16 19:42:54'),(2,3,'2026-10-16 21:44:05','2026-10-16 19:44:45','2026-10-16 21:44:05');
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
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
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `coefficient` decimal(5,2) NOT NULL DEFAULT 1.00,
  `term` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `scan_path` varchar(255) DEFAULT NULL,
  `entered_by` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grades_student_id_foreign` (`student_id`),
  KEY `grades_entered_by_foreign` (`entered_by`),
  CONSTRAINT `grades_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `grades_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,5,'francais',12.00,2.00,'1er trimestre','2026-2027','scans-notes/MZ4xknj9XYMCSSHDmA8bjc8Iui0sf6rlchuWzXpU.jpg',NULL,'draft','2026-10-14 12:15:00','2026-10-14 12:15:00'),(2,5,'mathematiques',15.00,3.00,'1er trimestre','2026-2027',NULL,NULL,'draft','2026-10-14 22:13:56','2026-10-14 22:13:56'),(3,5,'SVT',13.00,2.00,'1er trimestre','2026-2027',NULL,NULL,'draft','2026-10-14 22:14:23','2026-10-14 22:14:23'),(4,5,'SCIENCE',19.00,2.00,'1er trimestre','2026-2027',NULL,NULL,'draft','2026-10-14 22:14:58','2026-10-14 22:14:58'),(5,5,'Eps',15.00,1.00,'1er trimestre','2026-2027',NULL,NULL,'draft','2026-10-14 22:15:18','2026-10-14 22:15:18'),(6,5,'Anglais',19.00,2.00,'1er trimestre','2026-2027',NULL,NULL,'draft','2026-10-14 22:15:45','2026-10-14 22:15:45');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
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
  `attempts` smallint(5) unsigned NOT NULL,
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
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint(20) unsigned NOT NULL,
  `sender_id` bigint(20) unsigned NOT NULL,
  `body` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_conversation_id_created_at_index` (`conversation_id`,`created_at`),
  CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,2,'Bonjour',NULL,'2026-10-16 19:41:12','2026-10-16 19:41:12'),(2,1,4,'Oui bonjour comment vous allez?',NULL,'2026-10-16 19:42:02','2026-10-16 19:42:02'),(3,1,2,'Ça va et vous?',NULL,'2026-10-16 19:42:39','2026-10-16 19:42:39'),(4,1,4,'bien',NULL,'2026-10-16 19:42:54','2026-10-16 19:42:54'),(5,2,3,'Cc',NULL,'2026-10-16 19:44:49','2026-10-16 19:44:49'),(6,2,4,'cc',NULL,'2026-10-16 19:45:06','2026-10-16 19:45:06'),(7,2,3,'Je voulais payer l\'ecolage pour mes enfants de sixième.',NULL,'2026-10-16 21:29:03','2026-10-16 21:29:03'),(8,2,4,'ok',NULL,'2026-10-16 21:29:58','2026-10-16 21:29:58'),(9,2,3,'C\'est a combien svp',NULL,'2026-10-16 21:30:18','2026-10-16 21:30:18'),(10,2,4,'pour les deux',NULL,'2026-10-16 21:30:37','2026-10-16 21:30:37'),(11,2,3,'Oui',NULL,'2026-10-16 21:43:19','2026-10-16 21:43:19'),(12,2,4,'ok je verifie',NULL,'2026-10-16 21:43:45','2026-10-16 21:43:45'),(13,2,4,'top',NULL,'2026-10-16 21:43:53','2026-10-16 21:43:53'),(14,2,3,'Ok',NULL,'2026-10-16 21:44:05','2026-10-16 21:44:05');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_08_132213_create_personal_access_tokens_table',1),(5,'2026_10_08_220743_create_students_table',2),(6,'2026_10_08_220758_create_parent_student_table',2),(7,'2026_10_12_154425_create_school_classes_table',3),(8,'2026_10_12_154433_create_announcements_table',3),(9,'2026_10_13_234145_add_gender_to_students_table',4),(10,'2026_10_14_000515_create_grades_table',5),(11,'2026_10_14_095205_create_bulletins_table',6),(12,'2026_10_14_102410_add_fields_to_announcements_table',7),(13,'2026_10_15_102359_add_attachment_to_announcements_table',8),(14,'2026_10_15_155255_create_conversations_table',9),(15,'2026_10_15_155301_create_messages_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_student`
--

DROP TABLE IF EXISTS `parent_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_student` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_student_user_id_student_id_unique` (`user_id`,`student_id`),
  KEY `parent_student_student_id_foreign` (`student_id`),
  CONSTRAINT `parent_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parent_student_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_student`
--

LOCK TABLES `parent_student` WRITE;
/*!40000 ALTER TABLE `parent_student` DISABLE KEYS */;
INSERT INTO `parent_student` VALUES (1,2,3,'2026-10-13 03:55:54','2026-10-13 03:55:54'),(2,3,4,'2026-10-13 06:52:01','2026-10-13 06:52:01'),(3,3,1,'2026-10-13 06:52:01','2026-10-13 06:52:01'),(4,3,2,'2026-10-13 06:52:01','2026-10-13 06:52:01'),(5,2,5,'2026-10-14 11:33:57','2026-10-14 11:33:57'),(6,2,2,'2026-10-14 11:33:57','2026-10-14 11:33:57'),(7,1,3,'2026-10-15 22:56:43','2026-10-15 22:56:43');
/*!40000 ALTER TABLE `parent_student` ENABLE KEYS */;
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'ecole-eden-mobile','8ff0e1fa0c28be5ff9bccf9b75736aedda2b47e569bdf1602b188576b22718bc','[\"*\"]',NULL,NULL,'2026-10-09 01:37:46','2026-10-09 01:37:46'),(2,'App\\Models\\User',1,'ecole-eden-mobile','cee72414f22c22447f3386c7aff407948da959a00d6455c2c702a6e6a3870bd8','[\"*\"]',NULL,NULL,'2026-10-09 01:43:03','2026-10-09 01:43:03'),(3,'App\\Models\\User',2,'ecole-eden-mobile','03a658bc7b5adfd436c0052c8ad9a50955ce136097063a1be05cddbf6f30af45','[\"*\"]',NULL,NULL,'2026-10-09 02:08:46','2026-10-09 02:08:46'),(4,'App\\Models\\User',2,'ecole-eden-mobile','711ce6c8f53fbc08f895bc30f3b0efb71eb8b9df264f7772be2fe53eb224ece4','[\"*\"]',NULL,NULL,'2026-10-09 02:09:13','2026-10-09 02:09:13'),(5,'App\\Models\\User',2,'ecole-eden-mobile','4130fbc512e535c371210bc1d1c430ba03926f6268b650104f0322733a63bd95','[\"*\"]',NULL,NULL,'2026-10-09 02:11:18','2026-10-09 02:11:18'),(6,'App\\Models\\User',2,'ecole-eden-mobile','bed8a2332551c230a4d3633423e85efaf8b6a698b249988247532316f8dc5eb0','[\"*\"]',NULL,NULL,'2026-10-09 02:31:54','2026-10-09 02:31:54'),(7,'App\\Models\\User',2,'ecole-eden-mobile','133e4e0bf65466fbbb4f06f21118ba6517e7d2a251943b5a856cbcc87f09b38c','[\"*\"]',NULL,NULL,'2026-10-09 02:50:15','2026-10-09 02:50:15'),(8,'App\\Models\\User',2,'ecole-eden-mobile','9ee1e82ed78df600f3645186a46a15be1e1d8e90851a80b0ede189c1ff857271','[\"*\"]',NULL,NULL,'2026-10-09 03:03:15','2026-10-09 03:03:15'),(9,'App\\Models\\User',2,'ecole-eden-mobile','eecec4dee1e06ec621ed05100cb84c74fa15baa5791fcd31798a1aa6521cc453','[\"*\"]',NULL,NULL,'2026-10-09 10:55:39','2026-10-09 10:55:39'),(10,'App\\Models\\User',2,'ecole-eden-mobile','d679ae45823d0c57c8628b995fe3730b55d8c2d088e431e80d13da4d14fb4709','[\"*\"]',NULL,NULL,'2026-10-09 11:07:33','2026-10-09 11:07:33'),(11,'App\\Models\\User',2,'ecole-eden-mobile','fe59e6019052e2814e7aa4b120dc102dddd2ed5e8fdf6cda5b86f5f1c48145f7','[\"*\"]',NULL,NULL,'2026-10-09 11:21:39','2026-10-09 11:21:39'),(12,'App\\Models\\User',2,'ecole-eden-mobile','891741eb24c4694d359c326318100f4c126a55b854fc46e982b341a87e61d2fe','[\"*\"]',NULL,NULL,'2026-10-09 11:29:46','2026-10-09 11:29:46'),(13,'App\\Models\\User',3,'ecole-eden-mobile','1099f9b08eea0e197971c265d47edaca2f811da6e29accad9b0d36ca0a18e704','[\"*\"]',NULL,NULL,'2026-10-09 11:32:21','2026-10-09 11:32:21'),(14,'App\\Models\\User',3,'ecole-eden-mobile','06676790c8d606251fc2633bb951aacabcb7aaa6fd3801bb3e94b2e7a329b687','[\"*\"]',NULL,NULL,'2026-10-09 11:32:45','2026-10-09 11:32:45'),(15,'App\\Models\\User',2,'ecole-eden-mobile','ad40b4f86ca35bdd74186eff7e5cacd991693a1e7c56a6c7ac783202f4ff7af6','[\"*\"]',NULL,NULL,'2026-10-12 23:08:59','2026-10-12 23:08:59'),(16,'App\\Models\\User',3,'ecole-eden-mobile','49c344ac25ea1539ecea344bf47819dcad10213e93fd0e88a280a2dc0bf44657','[\"*\"]',NULL,NULL,'2026-10-12 23:20:20','2026-10-12 23:20:20'),(17,'App\\Models\\User',2,'ecole-eden-mobile','77ac06f6abfd286331f50ae83f23b5a26d92a7ed5a2983f9313a3a5c113f4058','[\"*\"]',NULL,NULL,'2026-10-12 23:24:42','2026-10-12 23:24:42'),(18,'App\\Models\\User',2,'ecole-eden-mobile','274a5c408f4552480e77b7366cf4912cd834ad52369910d2fc4717b05eb82e37','[\"*\"]',NULL,NULL,'2026-10-12 23:33:58','2026-10-12 23:33:58'),(19,'App\\Models\\User',2,'ecole-eden-mobile','dfb2c248ec4e5a19423417166881c28b513595e23aaa8750037ab1d7db184be9','[\"*\"]',NULL,NULL,'2026-10-13 00:03:35','2026-10-13 00:03:35'),(20,'App\\Models\\User',2,'ecole-eden-mobile','6d72dd0165e5c3a7307a0cbb76148c8fec8bb3a91f87a5ebb8ad38bdf9ed7732','[\"*\"]',NULL,NULL,'2026-10-14 10:30:18','2026-10-14 10:30:18'),(21,'App\\Models\\User',2,'ecole-eden-mobile','5eafd1719b89024cc36bc52ef6c47bfbe2446543b924446e06bd897ffd421430','[\"*\"]','2026-10-14 11:38:34',NULL,'2026-10-14 11:28:28','2026-10-14 11:38:34'),(22,'App\\Models\\User',2,'ecole-eden-mobile','56efe2043d43917662d208829cd03ff3d38aedd4fed61287f762654114afff07','[\"*\"]','2026-10-14 11:44:40',NULL,'2026-10-14 11:39:52','2026-10-14 11:44:40'),(23,'App\\Models\\User',2,'ecole-eden-mobile','23cd6423f40a2d14560c6aecb6448da9a1a84ce68d5278893f51a439a1d10679','[\"*\"]','2026-10-14 11:50:15',NULL,'2026-10-14 11:46:25','2026-10-14 11:50:15'),(24,'App\\Models\\User',2,'ecole-eden-mobile','5a3ec0c787f4588c7e5005c1ab9d25348aaa69e8800e470fbf587aae572734e1','[\"*\"]','2026-10-14 23:22:57',NULL,'2026-10-14 23:07:21','2026-10-14 23:22:57'),(25,'App\\Models\\User',2,'ecole-eden-mobile','a3c677920ebf610aba3015f1aa714e550004de4f60869a4f3ead9ae75867c458','[\"*\"]','2026-10-14 23:30:12',NULL,'2026-10-14 23:29:45','2026-10-14 23:30:12'),(26,'App\\Models\\User',2,'ecole-eden-mobile','d9568322803e2fe13094f5145317f4cec7a8df571da056b3b63833e5843edaec','[\"*\"]','2026-10-14 23:42:55',NULL,'2026-10-14 23:36:39','2026-10-14 23:42:55'),(27,'App\\Models\\User',2,'ecole-eden-mobile','964b66d9e5aa6c15a23da3b4e05e4a5b601221d0af4b80eb39aeb63b15d534a3','[\"*\"]','2026-10-14 23:56:08',NULL,'2026-10-14 23:54:25','2026-10-14 23:56:08'),(28,'App\\Models\\User',2,'ecole-eden-mobile','789aa717dbc4ac05c8b1c537255a200fd982310e6b0cf018a3e8f2c0ada1f327','[\"*\"]','2026-10-15 01:06:56',NULL,'2026-10-15 01:06:48','2026-10-15 01:06:56'),(29,'App\\Models\\User',2,'ecole-eden-mobile','6179dde557db72928b04bec23115fce71a55e8f426a8f1981800f72c74d9153d','[\"*\"]','2026-10-15 01:28:07',NULL,'2026-10-15 01:09:24','2026-10-15 01:28:07'),(30,'App\\Models\\User',2,'ecole-eden-mobile','fa97eb44966bc2bba280509dfdda383f55dc037e24ed08967c155c3bf6955f19','[\"*\"]','2026-10-15 01:29:20',NULL,'2026-10-15 01:28:32','2026-10-15 01:29:20'),(31,'App\\Models\\User',2,'ecole-eden-mobile','ef70c9568734fe660b844d74e7967f40f010790f6ed8c8ca900226d7189be42a','[\"*\"]','2026-10-15 01:55:29',NULL,'2026-10-15 01:54:35','2026-10-15 01:55:29'),(32,'App\\Models\\User',3,'ecole-eden-mobile','ced005da6384c0c9cbed6839cce1a4b5a6416a9e2e4cf6d5743a804510114cbb','[\"*\"]','2026-10-15 22:31:33',NULL,'2026-10-15 22:14:26','2026-10-15 22:31:33'),(33,'App\\Models\\User',2,'ecole-eden-mobile','d46e28c3262bc07e726cf2e93f2537abe4adf1d0609e985c1db3cfe1c1f9458d','[\"*\"]','2026-10-15 22:32:28',NULL,'2026-10-15 22:32:03','2026-10-15 22:32:28'),(34,'App\\Models\\User',2,'ecole-eden-mobile','264ffd5ce28045fa098335b7fc1a587b3bc2cf12bb394a0d4214ba880991b700','[\"*\"]','2026-10-15 22:42:08',NULL,'2026-10-15 22:41:47','2026-10-15 22:42:08'),(35,'App\\Models\\User',2,'ecole-eden-mobile','9a0591f2e805f0c7b020fed7773f24b47e246c138b6e31ef2b34f31b16b5fa08','[\"*\"]','2026-10-15 22:44:39',NULL,'2026-10-15 22:43:54','2026-10-15 22:44:39'),(36,'App\\Models\\User',2,'ecole-eden-mobile','0fd878d06a25dea6fcf14f44bfc231e257d3aff6db429f9396669d75fe864806','[\"*\"]','2026-10-15 23:03:04',NULL,'2026-10-15 22:57:37','2026-10-15 23:03:04'),(37,'App\\Models\\User',2,'ecole-eden-mobile','c3e29e5a09f4e7e9767b3c4244ebfd96fd5dc15de888ebbf49ef7ca153d90bd4','[\"*\"]',NULL,NULL,'2026-10-16 00:03:48','2026-10-16 00:03:48'),(38,'App\\Models\\User',2,'ecole-eden-mobile','68e25d693d8704f9ae9f946b8d58be1d12637f7dde974783d78f17fdc9ea3760','[\"*\"]','2026-10-16 00:09:21',NULL,'2026-10-16 00:06:58','2026-10-16 00:09:21'),(39,'App\\Models\\User',2,'ecole-eden-mobile','b1ca0f68ec227cdc6fc95862be7fc2c7042a195105a0e98bb8e2754427ca05b5','[\"*\"]','2026-10-16 00:20:12',NULL,'2026-10-16 00:16:47','2026-10-16 00:20:12'),(40,'App\\Models\\User',2,'ecole-eden-mobile','eba7600fb06243f6ccca4f0c3c867df0362fe9acf58d6780640798ef8af20956','[\"*\"]','2026-10-16 00:33:16',NULL,'2026-10-16 00:20:38','2026-10-16 00:33:16'),(41,'App\\Models\\User',2,'ecole-eden-mobile','7141d6ed0294689090810cf73c302c4a2441c4b1f8e3072b1fcdc6749d04673d','[\"*\"]','2026-10-16 00:44:07',NULL,'2026-10-16 00:38:24','2026-10-16 00:44:07'),(42,'App\\Models\\User',2,'ecole-eden-mobile','ce1a0e05a6528eee66625178a09bd68f9edf6c9e673afd06b7455aff2db9eef0','[\"*\"]','2026-10-16 00:54:23',NULL,'2026-10-16 00:49:53','2026-10-16 00:54:23'),(43,'App\\Models\\User',2,'ecole-eden-mobile','ad13c5629b813a2c98c88930bbbbddcfb7ce47ae29ea9c3fa741af20f4e8743a','[\"*\"]','2026-10-16 01:00:24',NULL,'2026-10-16 00:55:10','2026-10-16 01:00:24'),(44,'App\\Models\\User',3,'ecole-eden-mobile','12f3fbae8bb21562612870be09f8cf7a32a1ecb3f879b5071e72c82cc630a6f5','[\"*\"]','2026-10-16 01:03:56',NULL,'2026-10-16 01:01:03','2026-10-16 01:03:56'),(45,'App\\Models\\User',2,'ecole-eden-mobile','212954952eb0e926887af27822bb04581c4ca3162c08acd6b9e19abf85b9f74d','[\"*\"]','2026-10-16 01:22:02',NULL,'2026-10-16 01:13:33','2026-10-16 01:22:02'),(46,'App\\Models\\User',2,'ecole-eden-mobile','30844e33976d3d87bea440c18769595e32a9cb6aa3ed8054ad499ad6796ab198','[\"*\"]','2026-10-16 01:41:15',NULL,'2026-10-16 01:22:45','2026-10-16 01:41:15'),(47,'App\\Models\\User',2,'ecole-eden-mobile','bdccb8dac0f02bfb8fb55dad3017003ec08ea43ea1219b65df448a405ae7b5f3','[\"*\"]','2026-10-16 01:47:41',NULL,'2026-10-16 01:41:58','2026-10-16 01:47:41'),(48,'App\\Models\\User',2,'ecole-eden-mobile','81da6d94961fc4624182b3ff1fa5f4cfa7e63246b0c360eb671ec18a4c678de8','[\"*\"]','2026-10-16 01:48:47',NULL,'2026-10-16 01:48:15','2026-10-16 01:48:47'),(49,'App\\Models\\User',2,'ecole-eden-mobile','ab3929739cd2abd594578f7319fb1913073331ccb7fe29ad9bb7cd57563e59b3','[\"*\"]','2026-10-16 19:43:14',NULL,'2026-10-16 19:39:10','2026-10-16 19:43:14'),(50,'App\\Models\\User',3,'ecole-eden-mobile','e77d64411d9e847cf98b9868555af06dd7502afd90ccc49fc59bcf6654ca0d64','[\"*\"]','2026-10-16 19:45:09',NULL,'2026-10-16 19:44:24','2026-10-16 19:45:09'),(51,'App\\Models\\User',3,'ecole-eden-mobile','90c9b11c7bd412ffd750f95f72d99f52a37f08059a5bbba9b6f54b75213ec3cf','[\"*\"]','2026-10-16 21:44:38',NULL,'2026-10-16 21:27:41','2026-10-16 21:44:38'),(52,'App\\Models\\User',2,'ecole-eden-mobile','3f1104f59cf55ac660743dce4fa3cec3e19fd26eb250ca965928a0626f7f3395','[\"*\"]','2026-10-16 22:13:12',NULL,'2026-10-16 22:05:14','2026-10-16 22:13:12'),(53,'App\\Models\\User',3,'ecole-eden-mobile','750cf092b1998eeec0e8012bb2d9419f39eff78c06abd4d8f18e4ac6a0a825d8','[\"*\"]','2026-10-16 22:50:42',NULL,'2026-10-16 22:20:35','2026-10-16 22:50:42'),(54,'App\\Models\\User',2,'ecole-eden-mobile','bc69faddd974fabc92862053da003586efa4af112e2e2754c484c5191e54ddcf','[\"*\"]','2026-10-16 23:09:49',NULL,'2026-10-16 23:03:28','2026-10-16 23:09:49');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_classes`
--

DROP TABLE IF EXISTS `school_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_classes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_classes`
--

LOCK TABLES `school_classes` WRITE;
/*!40000 ALTER TABLE `school_classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_classes` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('Fv5BP5k3GSfGqqH6dnZMbPXCWdVoNGm7Kc2ejhO1',4,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJLSmplY08yRmZLVHdjYWh6empCTTNiTm16STdtdnVYMXV0VmtHc2JyIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pbiIsInJvdXRlIjpudWxsfSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NCwicGFzc3dvcmRfaGFzaF93ZWIiOiIwMzY1ZTM4YWQxZmJjZGM1OTNhOTUxYzg5OGEyNmUyYTBhYTg0NjkwYTY1NmIyYzQzYjA0NWNlZWI4YTYwYmE0In0=',1792150803);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `matricule` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `class_name` varchar(255) NOT NULL,
  `school_year` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_matricule_unique` (`matricule`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'5258963','Test','TEST','2026-10-23','5e','2026-2027','2026-10-13 03:24:56','2026-10-13 03:24:56',NULL),(2,'5258964','Patrick','Toto','2026-10-24','6e','2026-2027','2026-10-13 03:25:59','2026-10-13 03:25:59',NULL),(3,'5258965','alice','aba','2026-10-29','5e','2026-2027','2026-10-13 03:26:58','2026-10-13 03:26:58',NULL),(4,'5258966','tt','rfgt','2026-10-30','3e','2026-2027','2026-10-13 03:28:08','2026-10-13 03:28:08',NULL),(5,'525869','Blessing','NYANYO','2013-07-12','4e','2026-2027','2026-10-14 01:27:47','2026-10-14 01:27:47',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
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
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'parent',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_phone_unique` (`phone`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alex Parent','parent@test.com','90000000',NULL,'$2y$12$gjQ2u6vFNI3fQVBchhGoqOelD9g8xwzLP71Abd2.ZJTKrcsScNo52','parent',NULL,'2026-10-09 01:37:46','2026-10-09 01:37:46'),(2,'Adjete Alex','wilsoncodemosaic@gmail.com','73152573',NULL,'$2y$12$6eSzxfq1Sx76ygzQVlHJ2.RVJMG9J20.utX8r/ns4DhsoXuGzWJ0W','parent',NULL,'2026-10-09 02:08:46','2026-10-09 02:08:46'),(3,'Test','test@gmail.com','90000001',NULL,'$2y$12$KMaabdvt/Pt1xN.H/qm8muBf1bqzpFgthqW6m29DnRGXvrBHv7G9K','parent',NULL,'2026-10-09 11:32:21','2026-10-09 11:32:21'),(4,'ecole eden','ecoleeden@gmail.com','70381818',NULL,'$2y$12$qHCj3v3aem3d3l/fZl3tWO/YdmUiPvVWch5wZi5EtNhUZQWL6jviO','admin',NULL,'2026-10-16 04:15:20','2026-10-16 04:24:50');
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

-- Dump completed on 2026-10-15 23:44:56
