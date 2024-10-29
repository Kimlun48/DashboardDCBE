-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: db_dashboard
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_12_05_065145_create_posts_table',1),(6,'2024_07_25_071511_create_permission_tables',1),(7,'2024_10_06_141535_create_refresh_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\admin\\User',1),(1,'App\\Models\\admin\\User',7),(1,'App\\Models\\admin\\User',9),(1,'App\\Models\\admin\\User',13),(4,'App\\Models\\admin\\User',14),(5,'App\\Models\\admin\\User',15),(5,'App\\Models\\admin\\User',16),(6,'App\\Models\\admin\\User',17),(6,'App\\Models\\admin\\User',18),(6,'App\\Models\\admin\\User',19),(2,'App\\Models\\admin\\User',20),(5,'App\\Models\\admin\\User',21),(6,'App\\Models\\admin\\User',22),(1,'App\\Models\\admin\\User',23),(4,'App\\Models\\admin\\User',24);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'dashboard.index','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(2,'dashboard.statistics','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(3,'dashboard.chart','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(4,'inbound.index','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(5,'inbound.create','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(6,'inbound.edit','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(7,'inbound.delete','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(8,'storage.index','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(9,'storage.create','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(10,'storage.edit','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(11,'storage.delete','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(12,'outbound.index','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(13,'outbound.create','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(14,'outbound.edit','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(15,'outbound.delete','api','2024-10-07 08:11:14','2024-10-07 08:11:14'),(16,'users.index','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(17,'users.create','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(18,'users.edit','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(19,'users.delete','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(20,'roles.index','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(21,'roles.create','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(22,'roles.edit','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(23,'roles.delete','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(24,'permissions.index','api','2024-10-07 08:11:15','2024-10-07 08:11:15'),(25,'permissions.create','api','2024-10-14 09:10:09','2024-10-14 09:10:09'),(26,'permissions.update','api','2024-10-14 09:10:53','2024-10-14 09:10:53'),(27,'permissions.delete','api','2024-10-14 09:11:04','2024-10-14 09:11:04'),(28,'permissions.edit','api','2024-10-14 09:12:04','2024-10-14 09:12:04'),(29,'shipment.inbound.index','api','2024-10-14 09:15:00','2024-10-14 09:15:00'),(30,'transport.create','api','2024-10-14 10:42:53','2024-10-15 07:27:19'),(31,'transport.edit','api','2024-10-14 10:43:11','2024-10-14 10:43:11'),(32,'transport.delete','api','2024-10-14 10:43:27','2024-10-14 10:43:27'),(33,'jobtask.action','api','2024-10-15 05:00:03','2024-10-15 05:00:03'),(34,'transport.action','api','2024-10-15 05:08:38','2024-10-15 05:08:50'),(35,'jobtask.create','api','2024-10-15 07:42:49','2024-10-15 07:42:49'),(36,'jobtask.edit','api','2024-10-15 07:43:05','2024-10-15 07:43:05'),(37,'jobtask.delete','api','2024-10-15 07:43:16','2024-10-15 07:43:16'),(38,'jobtask.index','api','2024-10-15 07:43:25','2024-10-15 07:43:25'),(39,'schedule.create','api','2024-10-16 01:22:47','2024-10-16 01:22:47'),(40,'users.status','api','2024-10-18 06:24:23','2024-10-18 06:24:23'),(41,'reports.inbound','api','2024-10-22 07:35:12','2024-10-22 07:36:13'),(42,'reports.storage','api','2024-10-22 07:35:48','2024-10-22 07:35:48'),(43,'reports.outbound','api','2024-10-22 07:36:02','2024-10-22 07:36:02'),(44,'view.idbooking','api','2024-10-25 07:49:20','2024-10-25 07:49:20');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=583 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (275,'App\\Models\\admin\\User',14,'dashDc','bace5d91e9f0d54680fff80a759b31380de1a3e13f45ddd9a04da4de2492070c','[\"*\"]','2024-10-17 04:57:59',NULL,'2024-10-17 04:35:11','2024-10-17 04:57:59'),(300,'App\\Models\\admin\\User',9,'dashDc','95f108a2cf0cd7d53aabd80c5bb84a6f3f32579a6e2d138c99b77990dbd06992','[\"*\"]','2024-10-18 08:47:54',NULL,'2024-10-18 04:18:46','2024-10-18 08:47:54'),(324,'App\\Models\\admin\\User',9,'dashDc','f78389ee9b64b9f076f38e31b3ef1b3cd750ec39e92406f5191f47f60562879b','[\"*\"]','2024-10-18 08:55:11',NULL,'2024-10-18 08:53:03','2024-10-18 08:55:11'),(325,'App\\Models\\admin\\User',9,'dashDc','799bce6c5f105fc322279567feda79c30f76934a22cb56b7d8a9780c073fa592','[\"*\"]','2024-10-18 08:57:00',NULL,'2024-10-18 08:55:44','2024-10-18 08:57:00'),(326,'App\\Models\\admin\\User',9,'dashDc','4e199f8c97d915267b524e9aefd0449ab970b6d95deaf2122cb5425d9451f814','[\"*\"]','2024-10-18 08:57:47',NULL,'2024-10-18 08:57:28','2024-10-18 08:57:47'),(331,'App\\Models\\admin\\User',9,'dashDc','456d5504d5089f8a71eb1ecfa93695117fbac947ca0fe2bdc4d96199c45cd163','[\"*\"]','2024-10-21 10:01:41',NULL,'2024-10-19 00:57:22','2024-10-21 10:01:41'),(349,'App\\Models\\admin\\User',14,'dashDc','d996eff9913ea94e81cab1afaf4242fc428e759c084f7d78bffa7467d85d4530','[\"*\"]','2024-10-20 03:22:36',NULL,'2024-10-20 00:45:28','2024-10-20 03:22:36'),(371,'App\\Models\\admin\\User',14,'dashDc','d177a85680845ad2e8c31a618c7719e38f40ca473641d019babba3be2d77665d','[\"*\"]','2024-10-21 14:37:27',NULL,'2024-10-21 02:44:25','2024-10-21 14:37:27'),(380,'App\\Models\\admin\\User',9,'dashDc','27d4dc08e10148adacf0e0cea24602aaec4a18623e619c4c09bc8ffea71aaec9','[\"*\"]','2024-10-21 10:36:36',NULL,'2024-10-21 07:43:29','2024-10-21 10:36:36'),(385,'App\\Models\\admin\\User',14,'dashDc','0c786ded6079bc4961b103a82178bd6f1818ebdb748450f22d6aed56ee218c47','[\"*\"]','2024-10-21 11:47:57',NULL,'2024-10-21 10:03:21','2024-10-21 11:47:57'),(387,'App\\Models\\admin\\User',14,'dashDc','b0059722f9f625765989c8393ab9adac2220ded4f48daa2c74f4a46256ee87b4','[\"*\"]','2024-10-22 15:23:44',NULL,'2024-10-22 00:43:05','2024-10-22 15:23:44'),(394,'App\\Models\\admin\\User',9,'dashDc','6b5005013c67541fb31560ea132e7c53524316677b21ba03f9b44d8c2feea41f','[\"*\"]','2024-10-22 09:34:52',NULL,'2024-10-22 01:28:08','2024-10-22 09:34:52'),(423,'App\\Models\\admin\\User',14,'dashDc','18d406dda907721be583d3fa07841a831d6f29c7af587f62957821c8e08df917','[\"*\"]','2024-10-23 15:18:18',NULL,'2024-10-23 00:26:10','2024-10-23 15:18:18'),(436,'App\\Models\\admin\\User',9,'dashDc','4a8e4cd140fa2072ccaff0440017ae2055bd73d3ad874ad8b23d925e99620e8a','[\"*\"]','2024-10-23 11:16:14',NULL,'2024-10-23 09:02:17','2024-10-23 11:16:14'),(449,'App\\Models\\admin\\User',14,'dashDc','8bc4700f8cb0355b680211f82e6d645d1dfbc3136ba467c684cd0140a3d197e0','[\"*\"]','2024-10-24 15:18:37',NULL,'2024-10-24 00:53:50','2024-10-24 15:18:37'),(456,'App\\Models\\admin\\User',9,'dashDc','c8937366cde0cfcf136afac8bf299ea0d524b785c159f7805aeebc5988c5298f','[\"*\"]','2024-10-24 09:50:01',NULL,'2024-10-24 02:50:32','2024-10-24 09:50:01'),(471,'App\\Models\\admin\\User',15,'dashDc','85b0dd6482e19846e2ad5f079f169a4790eb4ea986bf5e42dbd626c28b59711c','[\"*\"]','2024-10-24 08:30:23',NULL,'2024-10-24 08:00:58','2024-10-24 08:30:23'),(480,'App\\Models\\admin\\User',14,'dashDc','9c6f216e0ff454ebc6deb1fa54b353a0ee1e8cdf34e0c96a24731406f6b8e9bf','[\"*\"]','2024-10-26 11:05:36',NULL,'2024-10-25 00:59:19','2024-10-26 11:05:36'),(492,'App\\Models\\admin\\User',18,'dashDc','29e4f54262ad1bc0e987275144e831b2381b3fcceb17ee5296dfff80c4b025aa','[\"*\"]','2024-10-25 14:52:25',NULL,'2024-10-25 01:55:08','2024-10-25 14:52:25'),(498,'App\\Models\\admin\\User',9,'dashDc','c2d4833b882c4ed0253af8f4c3219a997725afdf23ead92f9a535a53bdca0efa','[\"*\"]','2024-10-25 10:47:21',NULL,'2024-10-25 02:41:01','2024-10-25 10:47:21'),(502,'App\\Models\\admin\\User',18,'dashDc','dffce690ddaaa98cc7a6b102e5d4bf4a49ba05fc9a874dc0579fe618e838296a','[\"*\"]','2024-10-25 09:42:05',NULL,'2024-10-25 05:06:32','2024-10-25 09:42:05'),(518,'App\\Models\\admin\\User',13,'dashDc','c406689b25efd73f93abf511f22d49007b65b7bd7e84521ffa2ca26ada101768','[\"*\"]','2024-10-25 11:19:39',NULL,'2024-10-25 10:01:12','2024-10-25 11:19:39'),(523,'App\\Models\\admin\\User',18,'dashDc','51e4d415293bd0fa0438d4be0bfe38a3cf45e127a450cb764a99f4b5fb387590','[\"*\"]','2024-10-26 13:21:08',NULL,'2024-10-26 01:34:17','2024-10-26 13:21:08'),(551,'App\\Models\\admin\\User',18,'dashDc','0618707fcf0e9e7b765d9b1ef2c8e1116aa8efd7627b579db2b344d659d392fe','[\"*\"]','2024-10-27 14:46:32',NULL,'2024-10-26 12:41:59','2024-10-27 14:46:32'),(555,'App\\Models\\admin\\User',18,'dashDc','2e3d20bdef24a4458d0f4ff0bd3961932f21dfb99d8268f4b459b54b91e94a57','[\"*\"]','2024-10-27 15:10:34',NULL,'2024-10-27 00:43:55','2024-10-27 15:10:34'),(558,'App\\Models\\admin\\User',14,'dashDc','2cefe1fcb69699b8717fee736fbba02e67d9dc380be2b900ef5340fa03c8c77f','[\"*\"]','2024-10-27 12:33:04',NULL,'2024-10-27 00:46:45','2024-10-27 12:33:04'),(560,'App\\Models\\admin\\User',21,'dashDc','d6c695e5606fad1208f41817a0368d2e608a9511c59d0e8073e1b4442a48a7bc','[\"*\"]','2024-10-27 14:23:17',NULL,'2024-10-27 04:16:00','2024-10-27 14:23:17'),(564,'App\\Models\\admin\\User',22,'dashDc','a63056f9f8a797fdda52f8c34c953f59d778514cba91007b5a9c036dd77cf14a','[\"*\"]','2024-10-28 04:11:04',NULL,'2024-10-28 00:47:22','2024-10-28 04:11:04'),(565,'App\\Models\\admin\\User',20,'dashDc','88d091a1ad8f99126c30dbb2f7c48965e9c8a46c33d7c67ebee0eaf146a25f57','[\"*\"]','2024-10-28 03:24:24',NULL,'2024-10-28 01:04:39','2024-10-28 03:24:24'),(566,'App\\Models\\admin\\User',16,'dashDc','eb445206dc00e9647a189d529cd60288ee7d5327d709c02ba76937f6c64dac2e','[\"*\"]','2024-10-28 04:12:37',NULL,'2024-10-28 01:05:53','2024-10-28 04:12:37'),(567,'App\\Models\\admin\\User',7,'dashDc','416323a0dfb7a5180d0a46aa6071e38f52e5e1ebb85b610e9cf8c49c70b803f4','[\"*\"]','2024-10-28 01:21:10',NULL,'2024-10-28 01:06:57','2024-10-28 01:21:10'),(568,'App\\Models\\admin\\User',18,'dashDc','c4e30df9b1f4c469298e1020418f05960b126c8ad2f76ed7743895f66eeb91a1','[\"*\"]','2024-10-28 01:12:23',NULL,'2024-10-28 01:09:19','2024-10-28 01:12:23'),(569,'App\\Models\\admin\\User',14,'dashDc','b7d980210dcfd358cc4010edf9732fea87b6c2c61a92391420502c2ac65b98ab','[\"*\"]','2024-10-28 07:07:00',NULL,'2024-10-28 01:14:08','2024-10-28 07:07:00'),(573,'App\\Models\\admin\\User',17,'dashDc','8197ab346a0bca0fcd476ead0f45028ce2e2426fce36879d7c75256a4e03fb56','[\"*\"]','2024-10-28 03:45:15',NULL,'2024-10-28 02:27:53','2024-10-28 03:45:15'),(576,'App\\Models\\admin\\User',17,'dashDc','c49a869ff866a8ead594509408f6e490e9e344c0713a90accf3184045a8a3b05','[\"*\"]','2024-10-28 07:09:18',NULL,'2024-10-28 03:55:13','2024-10-28 07:09:18'),(578,'App\\Models\\admin\\User',16,'dashDc','f18d18422aa5078a025ddbe2572f26dd482d6534eda343e8dd4e9fd2e858511f','[\"*\"]','2024-10-28 07:12:58',NULL,'2024-10-28 05:21:21','2024-10-28 07:12:58'),(579,'App\\Models\\admin\\User',19,'dashDc','438ed42ae49fe25914a04754d7d81a8ba9ba38434b0c27b4041077da1733081e','[\"*\"]','2024-10-28 07:04:17',NULL,'2024-10-28 05:23:22','2024-10-28 07:04:17'),(580,'App\\Models\\admin\\User',19,'dashDc','c2edc2c611bc17496d544c613b4c4afd6e0f07cf79935f7620831b59952a5359','[\"*\"]','2024-10-28 06:38:31',NULL,'2024-10-28 05:52:36','2024-10-28 06:38:31'),(582,'App\\Models\\admin\\User',7,'dashDc','540050f1a800296ca61a0a6a8bf25338514f2f9c78f2f740889202385dbf8c87','[\"*\"]','2024-10-28 07:14:27',NULL,'2024-10-28 06:40:38','2024-10-28 07:14:27');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `refresh_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refresh_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `refresh_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=577 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refresh_tokens`
--

LOCK TABLES `refresh_tokens` WRITE;
/*!40000 ALTER TABLE `refresh_tokens` DISABLE KEYS */;
INSERT INTO `refresh_tokens` VALUES (269,14,'75b2146f9314b2a491c7275cb4506e4e4531d205300717befe1d9b9025c2d3bb','2024-10-18 04:35:11','2024-10-17 04:35:11','2024-10-17 04:35:11'),(294,9,'46b1b1ddd4e52bf689ccb2ed3fd9b743d43d4189619156c0513b85134e782ffd','2024-10-19 04:18:46','2024-10-18 04:18:46','2024-10-18 04:18:46'),(318,9,'49f860c73594d902078babdd85c9facca6f85dae7b8bbe58c7cfbd278d8469db','2024-10-19 08:53:03','2024-10-18 08:53:03','2024-10-18 08:53:03'),(319,9,'5943b0280017bb6a43f1836239166374ead24bad434a5634c41d7b3930f75cf1','2024-10-19 08:55:45','2024-10-18 08:55:45','2024-10-18 08:55:45'),(320,9,'db92c0a2f8e6505f1e27477512f65c8c7bef7c3a2d673d1712cb44ebb373a530','2024-10-19 08:57:28','2024-10-18 08:57:28','2024-10-18 08:57:28'),(325,9,'72270eaea8b37cc4fb44f4b3fc15465fea4f908b8c709c90332c193944de903b','2024-10-20 00:57:22','2024-10-19 00:57:22','2024-10-19 00:57:22'),(343,14,'039c6cbf89274437908a8c4aeb09b945629be832a82b0bfc394820981a616247','2024-10-21 00:45:28','2024-10-20 00:45:28','2024-10-20 00:45:28'),(365,14,'4d35bd612c4cf400b5ab4d8ef0d2d813750797f875e50114a546805ad1bda582','2024-10-22 02:44:25','2024-10-21 02:44:25','2024-10-21 02:44:25'),(374,9,'02d629de756adbeebd8d2a5f67cc3dfec0256eabdedab038cfc53748a10ba3ff','2024-10-22 07:43:29','2024-10-21 07:43:29','2024-10-21 07:43:29'),(379,14,'5bc4427917e43147383a5c914f9dcc9dbb5f43f8d71494ba1814a3a87f7e9d25','2024-10-22 10:03:21','2024-10-21 10:03:21','2024-10-21 10:03:21'),(381,14,'157262377dfd77f873a68871b04c69f54e6e0922061574569f9e874bea98e6ca','2024-10-23 00:43:05','2024-10-22 00:43:05','2024-10-22 00:43:05'),(388,9,'6f94abdbdecec44180ac904d9cbb2947f24386a943ccd9d15d259baf81802593','2024-10-23 01:28:08','2024-10-22 01:28:08','2024-10-22 01:28:08'),(417,14,'7dddf1e36d1e33ac51d1b7760bc6b32cc21ebf1a5a1a765ea32794d287fb87d9','2024-10-24 00:26:10','2024-10-23 00:26:10','2024-10-23 00:26:10'),(430,9,'2800f2bc76b44a9c4ebd54f1e06ba9d78f79a061b24b8dd922892beb9d0c9c27','2024-10-24 09:02:18','2024-10-23 09:02:18','2024-10-23 09:02:18'),(443,14,'f04021ddc32014d80706ee2b929e6c82f6b82a5523390a4e712e88090808884c','2024-10-25 00:53:50','2024-10-24 00:53:50','2024-10-24 00:53:50'),(450,9,'58e194c4dc29625c8e5c3f1e39deb9755fe5f621d3607200982c915f2370271d','2024-10-25 02:50:32','2024-10-24 02:50:32','2024-10-24 02:50:32'),(465,15,'e761a1b94246dc15d3a53b0b718028378970f3c04c84e54f1c5b468bce61ba3c','2024-10-25 08:00:58','2024-10-24 08:00:58','2024-10-24 08:00:58'),(474,14,'679e1619b0ca36ce5405690fc35b48fd344d0ed3f868734bede1bb73668b0283','2024-10-26 00:59:19','2024-10-25 00:59:19','2024-10-25 00:59:19'),(486,18,'5e083763237d37db84a258b76bb3882ed93f755d0d2d58607f859434d6070c1e','2024-10-26 01:55:09','2024-10-25 01:55:09','2024-10-25 01:55:09'),(492,9,'48dceceb73b85d4967ec965d38cad289de309e8ff7d14419e2542dd84864017f','2024-10-26 02:41:01','2024-10-25 02:41:01','2024-10-25 02:41:01'),(496,18,'5d0f2bd28a5d7db9c753c37d3bcf6a10f0d08b3d82778ca4f0680b2597d82a44','2024-10-26 05:06:32','2024-10-25 05:06:32','2024-10-25 05:06:32'),(512,13,'1a80c85df3bd70897becbe33e90d90691712f137fb24bd2f95575be1a28779dd','2024-10-26 10:01:13','2024-10-25 10:01:13','2024-10-25 10:01:13'),(517,18,'12bcbefba4f22353ad37bedae9737e4cf52ee375ab022106d53d89e9922d6a41','2024-10-27 01:34:17','2024-10-26 01:34:17','2024-10-26 01:34:17'),(545,18,'d7a2a94165b2bc56ff8298fdd2276edf58f493348344fc8fd91e187ac49d793f','2024-10-27 12:41:59','2024-10-26 12:41:59','2024-10-26 12:41:59'),(549,18,'1abe05a5c9665387c9250477f79eb373a9acfc032a9e21bbbb5984addfbe4dda','2024-10-28 00:43:55','2024-10-27 00:43:55','2024-10-27 00:43:55'),(552,14,'b25aea45d924a22fa8456471811211dd0cf510afc68c499468025f611dc30467','2024-10-28 00:46:45','2024-10-27 00:46:45','2024-10-27 00:46:45'),(554,21,'f252185bfce7c1b704b1024bf1ba7f90e07f002893ac9448e5c57b63a415c0cb','2024-10-28 04:16:00','2024-10-27 04:16:00','2024-10-27 04:16:00'),(558,22,'f97b98d3d286a6e9579e9c8df001342b25009b526c04ef2fd37719dc174811bd','2024-10-29 00:47:22','2024-10-28 00:47:22','2024-10-28 00:47:22'),(559,20,'8b121ddea86eb46114b183a381fee3ccb1005dcccd4b381c9abf305d08ff6d25','2024-10-29 01:04:39','2024-10-28 01:04:39','2024-10-28 01:04:39'),(560,16,'ae620efa8a092f284d440d5c255d1e81e1d639213e2e3c9461dd8173a4a5acf4','2024-10-29 01:05:53','2024-10-28 01:05:53','2024-10-28 01:05:53'),(561,7,'5472c678bdb841bcea2079941a5021e4c2b762c163d1db2d89238b451ab2bdc3','2024-10-29 01:06:58','2024-10-28 01:06:58','2024-10-28 01:06:58'),(562,18,'65eb5cabd0d85104fe2ffa3ba7e52df6e1b3d1a286311962ad2b5aec7344a733','2024-10-29 01:09:20','2024-10-28 01:09:20','2024-10-28 01:09:20'),(563,14,'a4818abb463f0b1aef070034c8ac2dcbef9591a99cdab296db7ddef63af2eb05','2024-10-29 01:14:08','2024-10-28 01:14:08','2024-10-28 01:14:08'),(567,17,'33f41d40e042503bba1b6e1e444c50f749fe8b6821ca5914987b7f64c2111a49','2024-10-29 02:27:53','2024-10-28 02:27:53','2024-10-28 02:27:53'),(570,17,'38c74b168fc1790c07c01627a7de8a16143e090413b484fa81569854a6fdd039','2024-10-29 03:55:13','2024-10-28 03:55:13','2024-10-28 03:55:13'),(572,16,'a55090d15a9f0c5e4348fe531664ba8b66558b276c4acbb8c2955b01ad4d0f99','2024-10-29 05:21:21','2024-10-28 05:21:21','2024-10-28 05:21:21'),(573,19,'4fb8ddaa88f88be18747611be7fe73abcb75c8f015e1f6e8e8bd3fd5a4647191','2024-10-29 05:23:22','2024-10-28 05:23:22','2024-10-28 05:23:22'),(574,19,'74efb9951d78567305ebc1986f95da6ef28ddfbbbb0aa8887eb9d5909b4b0f8e','2024-10-29 05:52:36','2024-10-28 05:52:36','2024-10-28 05:52:36'),(576,7,'7f7890d30547c1aea5e26292134d7fa5ae7ff4510a81c777b41b964114144c52','2024-10-29 06:40:38','2024-10-28 06:40:38','2024-10-28 06:40:38');
/*!40000 ALTER TABLE `refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(1,2),(4,2),(8,2),(12,2),(16,2),(18,2),(29,2),(41,2),(42,2),(43,2),(1,4),(4,4),(16,4),(18,4),(29,4),(41,4),(1,5),(8,5),(16,5),(18,5),(42,5),(1,6),(12,6),(16,6),(18,6),(43,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(2,'admin','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(4,'user_inbound','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(5,'user_storage','api','2024-10-07 08:11:13','2024-10-07 08:11:13'),(6,'user_outbound','api','2024-10-07 08:11:13','2024-10-07 08:11:13');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_branch` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_online` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'superadmin','superadmin@gmail.com',NULL,'$2y$12$4aGKipvf2Dk1zH3bbGp7hutRw/cHT/g1wqbWkvtz3FMJdfBu77by2',NULL,NULL,NULL,'2024-10-07 08:11:16','2024-10-28 06:23:19',0),(7,'asep','asep@rkm.co.id',NULL,'$2y$12$A.BeM.Frvj8Al1Xp.N1I9.O9ahLoa/nzJ4U1k5k7SP9qNsuE3WhBa',NULL,'000','HO','2024-10-15 05:48:29','2024-10-28 06:40:38',1),(9,'IT_Specialist','it.helpdesk@rkm.co.id',NULL,'$2y$12$P1KH0grhFlwsDLAxbDUChOYEo0iVeor.rNjl4dcTrubYTN4.oruPe',NULL,'0001','Distribution Center Rancaekek','2024-10-15 07:18:03','2024-10-28 06:22:13',0),(13,'IT0101','nandang.hermawan@rkm.co.id',NULL,'$2y$12$X9WPrCLiT0q.3fE0s0SizOwc0UnprSntK2Chg5i8lESB17lAIVwri',NULL,'000','HO','2024-10-16 00:53:20','2024-10-25 10:01:12',1),(14,'inb.00101','inb.00101@manhathan.local',NULL,'$2y$12$8XrvZ.eIFViMFYH3W9tBOuSwktutVqnHmMP.aEYPP23rUHX.HkJPC',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:27:12','2024-10-28 01:14:08',1),(15,'stg.00101','stg.00101@manhathan.local',NULL,'$2y$12$RMOd6C4fH2r0/wAQNLwjS.a8Aypz/3TyHSQ/t9oWLup7sM2nt0P5W',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:27:47','2024-10-24 08:00:58',1),(16,'stg.00102','stg.00102@manhathan.local',NULL,'$2y$12$H9sRmn8zH14RAjO0HN8wtu90FTjIT3GYNalcgaOocoS.eAHoM49vG',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:28:14','2024-10-28 06:24:39',0),(17,'otb.00101','otb.00101@manhathan.local',NULL,'$2y$12$os4EqeapsYR0Csy6.ip2g.YaZp68zqNVEaucJwYPDSeUdA3Fx5vcO',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:28:48','2024-10-28 03:55:12',1),(18,'otb.00102','otb.00102@manhathan.local',NULL,'$2y$12$xtUsXE5dFcHaHz6isXp5I.82E2grliFDw5yIVnkH8oZ2OnoFVP.Ua',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:29:17','2024-10-28 01:09:19',1),(19,'otb.00103','otb.00103@manhathan.local',NULL,'$2y$12$I2R.9RcX/Prw3zb33KO4nupN950daq4CGjksBDf3PP.snNvg0FoYm',NULL,'0001','Distribution Center Rancaekek','2024-10-16 01:29:44','2024-10-28 05:52:36',1),(20,'rizal.taufik','rizal.taufik@rkm.co.id',NULL,'$2y$12$pBUB02HrUVCkeeVqzUTJkuHazHni9pdIs56c2akX8M4GDkHQAXS/G',NULL,'0001','Distribution Center Rancaekek','2024-10-17 01:14:51','2024-10-28 01:04:39',1),(21,'stg.00103','stg.00103@manhathan.local',NULL,'$2y$12$2eGSYo2qloezlGiVMsqZC.4WRWAxBlNUBLE8fsPT7koPcPT4ZYFWC',NULL,'0001','Distribution Center Rancaekek','2024-10-17 01:15:45','2024-10-27 11:18:23',0),(22,'otb.00104','otb.00104@manhathan.local',NULL,'$2y$12$70d/0NYr7Nn9KN.N4nG7A.4/mZYqv24iKCxBZApFZE/kmbP0XAcIu',NULL,'0001','Distribution Center Rancaekek','2024-10-17 02:00:15','2024-10-28 06:22:46',0),(23,'admin_1','admin_1@rkm.co.id',NULL,'$2y$12$na4GQlHzJfUxqiuTQrK6D.k0jW7MaOL1nASEH0EQC0PctntXtCrmi',NULL,'000','HO','2024-10-23 09:47:10','2024-10-23 09:47:10',0),(24,'test_inbound','test_inbound@rkm.co.id',NULL,'$2y$12$X..C7Zke7oUWDvKXY046OusCf78zx38fSrgFFxuhnAskRXkX53gSO',NULL,'000','HO','2024-10-25 08:35:42','2024-10-25 09:05:50',0);
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

-- Dump completed on 2024-10-28 14:15:01
