-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 08, 2019 at 01:45 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lifemo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `email`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'mohsen', '$2y$10$hcsp8/xsP/aNH/4Q3dYXIOVFLeTq0/vHA4hTkEOT6uhC5fCQMrZKW', 'mohsen@gmail.com', 1, 'jVsP0TmMzvjKhW5ukG43AvggbJLP0Cvv596f1O0arqSxapSb228qhoYTxyUc', '2019-05-07 17:24:42', '2019-05-07 17:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_07_05_072454_create_photos_table', 1),
(4, '2018_07_05_072510_create_tags_table', 1),
(5, '2018_07_05_073043_create_posts_table', 1),
(6, '2018_07_05_075141_create_post_tag_table', 1),
(7, '2018_07_05_075743_create_post_informations_table', 1),
(8, '2018_07_05_081523_create_saved_posts_table', 1),
(9, '2018_07_05_081940_add_user_name_column_to_user_table', 1),
(10, '2018_07_14_112544_create_admin_table', 1),
(11, '2018_07_14_151932_add_deleted_at_column_to_users_table', 1),
(12, '2019_05_08_130125_add_fields_to_users_table', 2),
(13, '2019_05_08_130725_add_fields_to_posts_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url_low` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_informations`
--

DROP TABLE IF EXISTS `post_informations`;
CREATE TABLE IF NOT EXISTS `post_informations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `saved_count` int(11) NOT NULL,
  `shared_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tag`
--

DROP TABLE IF EXISTS `post_tag`;
CREATE TABLE IF NOT EXISTS `post_tag` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_posts`
--

DROP TABLE IF EXISTS `saved_posts`;
CREATE TABLE IF NOT EXISTS `saved_posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(8, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(9, 'view', '2019-05-08 07:36:24', '2019-05-08 07:36:24'),
(10, 'nature', '2019-05-08 07:36:26', '2019-05-08 07:36:26'),
(11, 'world', '2019-05-08 07:36:35', '2019-05-08 07:36:35'),
(12, 'computer', '2019-05-08 07:36:37', '2019-05-08 07:36:37'),
(13, 'education', '2019-05-08 07:43:15', '2019-05-08 07:43:15'),
(14, 'sky', '2019-05-08 07:48:31', '2019-05-08 07:48:31'),
(15, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(16, 'view', '2019-05-08 07:36:24', '2019-05-08 07:36:24'),
(17, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(18, 'nature', '2019-05-08 07:36:26', '2019-05-08 07:36:26'),
(19, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(20, 'nature', '2019-05-08 07:36:26', '2019-05-08 07:36:26'),
(21, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(22, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22'),
(23, 'education', '2019-05-08 07:43:15', '2019-05-08 07:43:15'),
(24, 'computer', '2019-05-08 07:36:37', '2019-05-08 07:36:37'),
(25, 'view', '2019-05-08 07:36:24', '2019-05-08 07:36:24'),
(26, 'nature', '2019-05-08 07:36:26', '2019-05-08 07:36:26'),
(27, 'nature', '2019-05-08 07:36:26', '2019-05-08 07:36:26'),
(28, 'home', '2019-05-08 07:36:22', '2019-05-08 07:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_user_name_unique` (`user_name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `user_name`, `password`, `remember_token`, `client_key`, `app_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'mohsen1@gmail.com', 'mohsen1', '$2y$10$wFDRgHzzncGkJswNY2WvcexQz9N2mLteqAodIfpvX2gCJbWiYrDZq', NULL, '83bcd5da8065c63570575efc15f50054', '0Oysmohsen1e9442f0a5d95dec266d792d57d6224a', '2019-05-08 08:45:24', '2019-05-08 08:48:22', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
