-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: homestead
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu0.14.04.1

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `commentable_id` int(10) unsigned DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `positive` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `negative` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_index` (`user_id`),
  KEY `comments_commentable_id_index` (`commentable_id`),
  KEY `comments_commentable_type_index` (`commentable_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'0000-00-00 00:00:00','0000-00-00 00:00:00','','This is a test comment by user 1 on game 5',NULL,1,2,0,5,'App\\Game',1,'user1','story','level_design');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `genre` enum('','action','action-adventure','idle','puzzle','role-playing','shooter','simulation','sports','strategy') COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `likes` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `link_social_greenlight` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_social_website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_social_twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_social_youtube` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_social_google_plus` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_social_facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `games_slug_unique` (`slug`),
  KEY `games_user_id_foreign` (`user_id`),
  CONSTRAINT `games_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,1,'Test Game 1','test-game-1','action','This is a description. This is a description. This is a description. This is a description. This is a description. This is a description.',1,1020,'http://greenlight.com','http://website.com','http://link-twitter.com','http://link-youtube.com','http://link-gplus.com','http://link-facebook.com','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,'Test Game 2','test-game-2','shooter','This my description',2,600000,'http://greenlight.com','http://website.com','http://link-twitter.com',NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,'Test Game 3','test-game-3','strategy','This is a teeny tiny description',1,764,NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,1,'Test Game 4','test-game-4','puzzle','This is a short description.',0,887,NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,2,'Test Game 5','test-game-5','strategy','This is a teeny tiny description',0,764,NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,3,'Test Game 6','test-game-6','strategy','text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href=\"http://google.com\">link</a><br /><br />\n                                <ul>\n                                <li>bullet1</li>\n                                <li>bullet2</li>\n                                <li>bullet3</li>\n                                </ul>\n                                <br />\n                                <ol>\n                                <li>number1</li>\n                                <li>number2</li>\n                                <li>number3</li>\n                                </ol>',0,764,NULL,NULL,NULL,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `likes_user_id_foreign` (`user_id`),
  KEY `likes_game_id_foreign` (`game_id`),
  CONSTRAINT `likes_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,2,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,3,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_09_28_032631_create_games_table',1),('2015_11_06_000000_create_comments_table',1),('2015_11_18_005701_create_versions_table',1),('2015_11_18_041506_create_likes_table',1),('2016_01_06_061534_games_table_description_to_text',1),('2016_01_06_062212_versions_table_changes_and_upcoming_features_to_text',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('good','warning','unconfirmed') COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'user1','user1@gmail.com','$2y$10$pf2DzhUOovbHIJZDUhnBLO9fGqxScaqpAy.GwX2WamUcD80uB9aua',NULL,'unconfirmed','1234567890ABCDE3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'user2','user2@gmail.com','$2y$10$T6tePcqfjFN3dSdkaAW1a.emiK/8giSzglUlDKcHvE3RzfCBPKiAW',NULL,'unconfirmed','1234567890ABCDE3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'user3','user3@gmail.com','$2y$10$2Bg5Ky8r2CNxEzYGLNHmPeV66oOXgSWmrKOz7X5yf.9C.z6Z1AKxO',NULL,'unconfirmed','1234567890ABCDE3','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `beta` tinyint(1) NOT NULL,
  `video_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_pc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_mac` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_ios` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_android` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_unity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link_platform_other` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upcoming_features` text COLLATE utf8_unicode_ci,
  `changes` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `versions_game_id_foreign` (`game_id`),
  CONSTRAINT `versions_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `versions`
--

LOCK TABLES `versions` WRITE;
/*!40000 ALTER TABLE `versions` DISABLE KEYS */;
INSERT INTO `versions` VALUES (1,1,'1.2.3','1.2.3',1,'https://www.youtube.com/watch?v=e-ORhEE9VVg','image1.jpg','image2.jpg','image3.jpg',NULL,'http://pc-game-1-version-1.2.3.com',NULL,NULL,'http://android-game-1-version-1.2.3.com',NULL,'http://other-web-game-1-version-1.2.3.com','Upcomming feaures 1.2.3','Changes made this version in 1.2.3','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,'1.2.5','1.2.5',1,'https://www.youtube.com/watch?v=WA4iX5D9Z64','image4.jpg','image5.jpg','image6.jpg',NULL,'http://pc-game-1-version-1.2.5.com','http://mac-game-1-version-1.2.5.com','http://ios-game-1-version-1.2.5.com','http://android-game-1-version-1.2.5.com','http://unity-game-1-version-1.2.5.com','http://other-web-game-1-version-1.2.5.com','Upcomming feaures 1.2.5','Changes made this version in 1.2.5','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,1,'1.1.1','1.1.1',1,'','image7.jpg',NULL,NULL,NULL,'http://pc-game-1-version-1.1.1.com','http://mac-game-1-version-1.1.1.com','http://ios-game-1-version-1.1.1.com','http://android-game-1-version-1.1.1.com','http://unity-game-1-version-1.1.1.com','http://other-web-game-1-version-1.1.1.com','Upcomming feaures 1.1.1','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,2,'1.1.1','1.1.1',1,'','image6.jpg',NULL,NULL,NULL,'http://pc-game-2-version-1.1.1.com','http://mac-game-2-version-1.1.1.com','http://ios-game-2-version-1.1.1.com','http://android-game-2-version-1.1.1.com','http://unity-game-2-version-1.1.1.com','http://other-web-game-2-version-1.1.1.com','Upcomming feaures 1.1.1','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,3,'1.1.1','1.1.1',1,'','image5.jpg','image3.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Upcomming feaures 1.1.1','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,4,'1.1.1','1.1.1',1,'','image2.jpg','image3.jpg','image5.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Upcomming feaures 1.1.1','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,5,'1.1.1','1.1.1',1,'','image3.jpg','image4.jpg','image5.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Upcomming feaures 1.1.1','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,6,'1.1.1','1.1.1',1,'','image3.jpg','image4.jpg','image5.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href=\"http://google.com\">link</a><br /><br />\n                                        <ul>\n                                        <li>bullet1</li>\n                                        <li>bullet2</li>\n                                        <li>bullet3</li>\n                                        </ul>\n                                        <br />\n                                        <ol>\n                                        <li>number1</li>\n                                        <li>number2</li>\n                                        <li>number3</li>\n                                        </ol>','text<br /><br />pharagraph text<br /><br /><strong>bold text</strong><br /><br /><em>italics text</em><br /><br /><a href=\"http://google.com\">link</a><br /><br />\n                            <ul>\n                            <li>bullet1</li>\n                            <li>bullet2</li>\n                            <li>bullet3</li>\n                            </ul>\n                            <br />\n                            <ol>\n                            <li>number1</li>\n                            <li>number2</li>\n                            <li>number3</li>\n                            </ol>','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-06  6:51:26
