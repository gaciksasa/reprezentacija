-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 11, 2025 at 06:45 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reprezentacija`
--

-- --------------------------------------------------------

--
-- Table structure for table `bivsi_klubovi`
--

DROP TABLE IF EXISTS `bivsi_klubovi`;
CREATE TABLE IF NOT EXISTS `bivsi_klubovi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `naziv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `drzava` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sezona` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stepen_takmicenja` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `broj_nastupa` int DEFAULT NULL,
  `broj_golova` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bivsi_klubovi_igrac_id_foreign` (`igrac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bivsi_klubovi`
--

INSERT INTO `bivsi_klubovi` (`id`, `igrac_id`, `naziv`, `drzava`, `sezona`, `stepen_takmicenja`, `broj_nastupa`, `broj_golova`, `created_at`, `updated_at`) VALUES
(5, 104, 'FK Galenika Zemun', 'SFRJ', '1982-83', '1', 18, 4, '2025-03-08 19:16:14', '2025-03-09 10:29:59'),
(6, 114, 'NK Dinamo Zagreb', 'SFRJ', '1980-81', '1', 17, 1, '2025-03-09 10:12:40', '2025-03-09 10:29:13'),
(7, 545, 'FK Vojvodina', 'SFRJ', '1967-68', '1', 14, 5, '2025-03-09 16:22:37', '2025-03-09 16:22:37'),
(8, 128, 'FK Bačka 1901 Subotica', 'SRB', '2014-15', '4', 12, 0, '2025-03-10 17:52:14', '2025-03-10 17:52:14'),
(9, 128, 'FK Spartak Subotica', 'SRB', '2015-16', '1', 0, 0, '2025-03-10 17:54:23', '2025-03-10 17:54:23'),
(10, 128, 'FK Bačka 1901 Subotica (loan)', 'SRB', '2015-16', '4', 26, 4, '2025-03-10 17:54:56', '2025-03-10 17:54:56'),
(11, 128, 'FK Spartak Subotica', 'SRB', '2016-17', '1', 31, 1, '2025-03-10 17:55:26', '2025-03-10 17:55:26'),
(12, 128, 'FK Spartak Subotica', 'SRB', '2017-18', '1', 30, 0, '2025-03-10 17:56:03', '2025-03-10 17:56:03'),
(13, 128, 'FK Spartak Subotica', 'SRB', '2018-19', '1', 0, 0, '2025-03-10 17:56:31', '2025-03-10 17:56:31'),
(14, 859, 'HŠK Građanski (Zagreb)', NULL, NULL, NULL, NULL, NULL, '2025-03-10 20:00:44', '2025-03-10 20:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `golovi`
--

DROP TABLE IF EXISTS `golovi`;
CREATE TABLE IF NOT EXISTS `golovi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `igrac_tip` enum('regularni','protivnicki') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regularni',
  `minut` int DEFAULT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `penal` tinyint(1) NOT NULL DEFAULT '0',
  `auto_gol` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `golovi_utakmica_id_foreign` (`utakmica_id`),
  KEY `golovi_igrac_id_foreign` (`igrac_id`),
  KEY `golovi_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `golovi`
--

INSERT INTO `golovi` (`id`, `utakmica_id`, `igrac_id`, `igrac_tip`, `minut`, `tim_id`, `penal`, `auto_gol`, `created_at`, `updated_at`) VALUES
(2, 2, 4, 'protivnicki', 48, 9, 0, 0, '2025-03-08 16:00:32', '2025-03-08 16:00:32'),
(3, 2, 5, 'protivnicki', 56, 9, 1, 0, '2025-03-08 16:09:28', '2025-03-08 16:09:28'),
(6, 2, 4, 'protivnicki', 1, 9, 0, 0, '2025-03-08 16:49:45', '2025-03-08 16:49:45'),
(8, 2, 4, 'protivnicki', 34, 9, 0, 1, '2025-03-08 16:58:35', '2025-03-08 16:58:35'),
(9, 3, 6, 'protivnicki', 88, 10, 0, 0, '2025-03-08 17:42:32', '2025-03-08 17:42:32'),
(10, 3, 7, 'protivnicki', 12, 10, 0, 0, '2025-03-08 17:43:31', '2025-03-08 17:43:31'),
(11, 8, 26, 'protivnicki', 20, 23, 0, 0, '2025-03-10 18:42:16', '2025-03-10 18:42:16'),
(12, 8, 24, 'protivnicki', 34, 23, 0, 0, '2025-03-10 18:42:28', '2025-03-10 18:42:28'),
(13, 8, 23, 'protivnicki', 43, 23, 0, 0, '2025-03-10 18:42:44', '2025-03-10 18:42:44'),
(14, 8, 26, 'protivnicki', 46, 23, 0, 0, '2025-03-10 18:43:00', '2025-03-10 18:43:00'),
(15, 8, 24, 'protivnicki', 50, 23, 0, 0, '2025-03-10 18:43:16', '2025-03-10 18:43:16'),
(16, 8, 24, 'protivnicki', 75, 23, 0, 0, '2025-03-10 18:43:30', '2025-03-10 18:43:30'),
(17, 8, 26, 'protivnicki', 79, 23, 1, 0, '2025-03-10 18:43:46', '2025-03-10 18:43:46'),
(18, 10, 35, 'protivnicki', NULL, 102, 0, 0, '2025-03-10 19:36:22', '2025-03-10 19:36:22'),
(19, 10, 36, 'protivnicki', NULL, 102, 0, 0, '2025-03-10 19:36:39', '2025-03-10 19:36:39'),
(20, 10, 37, 'protivnicki', NULL, 102, 0, 0, '2025-03-10 19:36:54', '2025-03-10 19:36:54'),
(21, 10, 37, 'protivnicki', NULL, 102, 0, 0, '2025-03-10 19:37:07', '2025-03-10 19:37:07'),
(22, 10, 164, 'regularni', NULL, 5, 0, 0, '2025-03-10 19:37:49', '2025-03-10 19:37:49'),
(23, 10, 697, 'regularni', NULL, 5, 0, 0, '2025-03-10 19:38:02', '2025-03-10 19:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `igraci`
--

DROP TABLE IF EXISTS `igraci`;
CREATE TABLE IF NOT EXISTS `igraci` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `prezime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tim_id` int NOT NULL,
  `pozicija` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fotografija_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biografija` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `mesto_rodjenja` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktivan` tinyint(1) NOT NULL DEFAULT '0',
  `datum_smrti` date DEFAULT NULL,
  `mesto_smrti` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=906 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `igraci`
--

INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(106, 'Cimermančić', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(2, 'Abraham', 'Jenő – Száraz', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(3, 'Aćimović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(4, 'Agić', 'Đuro', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(5, 'Aksentijević', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(6, 'Aleksić', 'Branimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(7, 'Aleksić', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(8, 'Aleksić', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(9, 'Alivodić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(10, 'Anđelković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(11, 'Anđelković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(12, 'Anđelković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(13, 'Anković', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(14, 'Antić', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(15, 'Antić', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(16, 'Antić', 'Sava', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(17, 'Antolković', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(18, 'Antonijević', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(19, 'Arsenijević', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(20, 'Arslanagić', 'Zijad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(21, 'Arslanović', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(22, 'Asanović', 'Aljoša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(23, 'Atanacković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(24, 'Avramov', 'Vlada', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(25, 'Avramović', 'Radojko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(26, 'Babić', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(27, 'Babić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(28, 'Babović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(29, 'Babunski', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(30, 'Bahtiić', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(31, 'Bajević', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(32, 'Bajić', 'Mane', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(33, 'Bajić', 'Milenko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(34, 'Bakota', 'Bozo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(35, 'Bajić', 'Mirsad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(36, 'Banović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(37, 'Barbarić', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(38, 'Baša', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(39, 'Basta', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(40, 'Batričević', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(41, 'Batrović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(42, 'Baždarević', 'Mehmed', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(43, 'Beara', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(44, 'Bećir', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(45, 'Bećirić', 'Radoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(46, 'Bego', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(47, 'Bek', 'Ivan (Beck Yvan)', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(48, 'Beleslin', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(49, 'Beleslin', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(50, 'Belin', 'Bruno', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(51, 'Belin', 'Rodolfo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(52, 'Belošević', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(53, 'Beljić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(54, 'Bens', 'Steven', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(55, 'Benčić', 'Ljubo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(56, 'Benko', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(57, 'Benković', 'Milivoj', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(58, 'Binić', 'Dragiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(59, 'Biogradlić', 'Ibrahim', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(60, 'Bišćan', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(61, 'Bivec', 'August', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(62, 'Bjegović', 'Nikoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(63, 'Bjekovic', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(64, 'Blašković', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(65, 'Boban', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(66, 'Bobek', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(67, 'Bogavac', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(68, 'Bogdan', 'Srećko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(69, 'Bogdanović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(70, 'Bogdanović', 'Rade', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(71, 'Bogićević', 'Vladislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(72, 'Bogosavac', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(73, 'Bogunović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(74, 'Bojović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(75, 'Bolić', 'Darzen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(76, 'Bojat', 'Mario', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(77, 'Bonačić', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(78, 'Bonačić', 'Miljenko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(79, 'Borota', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(80, 'Borovcić', 'Kurti Mihovil', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(81, 'Boskov', 'Vujadin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(82, 'Bošković', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(83, 'Bošković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(84, 'Bošnjak', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(85, 'Božić', 'Radivoj', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(86, 'Božović', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(87, 'Božović', 'Vojin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(88, 'Brašanac', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(89, 'Bratić', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(90, 'Braulić', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(91, 'Braun', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(92, 'Brkić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(93, 'Brnčić', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(94, 'Brnović', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(95, 'Brnović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(96, 'Brnović', 'Dragoljub', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(97, 'Brnović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(105, 'Cicović', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(99, 'Brozović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(100, 'Brzić', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(101, 'Bukal', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(102, 'Buljan', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(103, 'Bunjevčević', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(104, 'Bursać', 'Miloš', 1, 'Napad', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 19:17:13'),
(107, 'Cindrić', 'Slavin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(108, 'Colnago', 'Ferante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(109, 'Cokić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(110, 'Crnković', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(111, 'Cukrov', 'Nikica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(112, 'Cvek', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(113, 'Cvetković', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(114, 'Cvetković', 'Zvjezdan', 1, 'Odbrana', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-03-09 10:12:40'),
(115, 'Čabrić', 'Ratomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(116, 'Čajkovski', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(117, 'Čajkovski', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(118, 'Čakar', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(119, 'Čapljić', 'Vlado', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(120, 'Čebinac', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(121, 'Čebinac', 'Zvezdan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(122, 'Čerček', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(123, 'Čolić', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(124, 'Čonč', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(125, 'Čop', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(126, 'Čop', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(127, 'Čulić', 'Bartul', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(128, 'Ćalasan', 'Nemanja', 1, 'Odbrana', 'igraci/0xa6sUrREe7VxQQ4W2ZIgPu1r0KnGbxtD2ASz3h7.png', NULL, '1996-03-17', 'Subotica', 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-10 17:52:14'),
(129, 'Ćirić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(130, 'Ćirković', 'Milivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(131, 'Ćirković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(132, 'Ćurčić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(133, 'Ćurić', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(134, 'Ćurković', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(135, 'Damjanović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(136, 'Damjanović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(137, 'Dasović', 'Eugen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(138, 'Dautbegović', 'Fahrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(139, 'Davidov', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(140, 'Davidović', 'Sreten', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(141, 'Demić', 'Sergije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(142, 'Desnica', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(143, 'Desković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(144, 'Despotović', 'Ranko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(145, 'Deverić', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(146, 'Dimitrijević', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(147, 'Dišljenković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(148, 'Divić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(149, 'Dmitrović', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(150, 'Dmitrović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(151, 'Dobrijević', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(152, 'Dojčinovski', 'Kiril', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(153, 'Dračić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(154, 'Dragićević', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(155, 'Dragićević', 'Prvoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(156, 'Dragutinović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(157, 'Drenovac', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(158, 'Drobnjak', 'Anto', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(159, 'Drobnjak', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(160, 'Drulić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(161, 'Drulović', 'Ljubinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(162, 'Dubac', 'Ernest', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(163, 'Dubajić', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(164, 'Dubravčić', 'Artur', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(165, 'Dudić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(166, 'Dudić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(167, 'Dujković', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(168, 'Dujmović', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(169, 'Duljaj', 'Igor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(170, 'Dunderski', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(171, 'Durković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(172, 'Dvornić', 'Dionizije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(173, 'Džajić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(174, 'Džanić', 'Svetozar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(175, 'Džeko', 'Jasmin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(176, 'Džodić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(177, 'Džoni', 'Vilson', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(178, 'Đajić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(179, 'Delmas', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(180, 'Denić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(181, 'Đokić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(182, 'Đokić', 'Momčilo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(183, 'Đorđević', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(184, 'Đorđević', 'Borivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(185, 'Đorđević', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(186, 'Đorđević', 'Kristijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(187, 'Đorđević', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(188, 'Đorđević', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(189, 'Đorđević', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(190, 'Đorić', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(191, 'Đorović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(192, 'Đukić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(193, 'Đukić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(194, 'Đurđić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(195, 'Đuričić', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(196, 'Đuričić', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(197, 'Đurić', 'Igor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(198, 'Đurić', 'Vladata', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(199, 'Đurovski', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(200, 'Đurovski', 'Milko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(201, 'Elsner', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(202, 'Ergić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(203, 'Fazlagić', 'Mirsad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(204, 'Fejsa', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(205, 'Ferderber', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(206, 'Ferhatović', 'Asim', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(207, 'Ferhatović', 'Nijaz', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(208, 'Filipović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(209, 'Firm', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(210, 'Fridrih', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(211, 'Gaćinović', 'Mijat', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(212, 'Gajer', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(213, 'Galić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(214, 'Gavrančić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(215, 'Georgijevski', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(216, 'Giler', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(217, 'Glaser', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(218, 'Glišović', 'Svetislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(219, 'Gobeljić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(220, 'Gojković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(221, 'Golac', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(222, 'Golob', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(223, 'Govedarica', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(224, 'Gračan', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(225, 'Gračanin', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(226, 'Granec', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(227, 'Grdenić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(228, 'Grozdić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(229, 'Grujić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(230, 'Grujić', 'Spira', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(231, 'Gudelj', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(232, 'Gudelj', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(233, 'Gugleta', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(234, 'Gvozdenović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(235, 'Hadžiabdić', 'Džemal', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(236, 'Hadžiabdić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(237, 'Hadžibegić', 'Faruk', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(238, 'Hadžić', 'Ismet', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(239, 'Halilhodžić', 'Vahid', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(240, 'Halilović', 'Sulejman', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(241, 'Hasanagić', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(242, 'Hatunić', 'Jusuf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(243, 'Herceg', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(244, 'Hügl', 'Bernard', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(245, 'Hitrec', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(246, 'Hitrec', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(247, 'Hlevnjak', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(248, 'Hočevar', 'Edvard', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(249, 'Holcer', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(250, 'Horvat', 'Drago', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(251, 'Horvat', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(252, 'Horvat', 'Janoš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(253, 'Hošić', 'Idriz', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(254, 'Hrnjičеk', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(255, 'Hrstić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(256, 'Hukić', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(257, 'Ignjovski', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(258, 'Ilić', 'Brana', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(259, 'Ilić', 'Radiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(260, 'Ilić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(261, 'Ilić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(262, 'Iliev', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(263, 'Injac', 'Dimitrije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(264, 'Isailović', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(265, 'Ivanović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(266, 'Ivanović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(267, 'Ivezić', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(268, 'Ivić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(269, 'Ivić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(270, 'Ivković', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(271, 'Ivković', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(272, 'Ivoš', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(273, 'Jakovetić', 'Lajoš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(274, 'Jakovljević', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(275, 'Jakšić', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(276, 'Janevski', 'Čedomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(277, 'Janjanin', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(278, 'Janković', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(279, 'Janković', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(280, 'Janković', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(281, 'Janković', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(282, 'Janković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(283, 'Jantoljak', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(284, 'Jarni', 'Robert', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(285, 'Jašarević', 'Ešref', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(286, 'Jazbec', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(287, 'Jazbinšek', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(288, 'Jelikić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(289, 'Jerković', 'Dražan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(290, 'Jerković', 'Jurica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(291, 'Jerolimov', 'Ive', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(292, 'Ješić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(293, 'Jestrović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(294, 'Jevtović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(295, 'Jevrić', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(296, 'Jevtić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(297, 'Jevtić', 'Živorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(298, 'Jezerkić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(299, 'Jocić', 'Stanoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(300, 'Jojić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(301, 'Jokanović', 'Slaviša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(302, 'Jokić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(303, 'Jorgačević', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(304, 'Jovanić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(305, 'Jovanović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(306, 'Jovanović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(307, 'Jovanović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(308, 'Jovanović', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(309, 'Jovanović', 'Mija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(310, 'Jovanović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(311, 'Jovanović', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(312, 'Jovanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(313, 'Jovanović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(314, 'Jović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(315, 'Jović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(316, 'Jovičić', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(317, 'Jovičić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(318, 'Jovin', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(319, 'Jozić', 'Davor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(320, 'Jugović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(321, 'Jurčić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(322, 'Jurić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(323, 'Jurić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(324, 'Jurić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(325, 'Jusufi', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(326, 'Kacian', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(327, 'Kačar', 'Gojko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(328, 'Kahriman', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(329, 'Kajtaz', 'Sead', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(330, 'Kaloperović', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(331, 'Kaluđerović', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(332, 'Kanatlarovski', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(333, 'Kapetanović', 'Mirza', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(334, 'Karasi', 'Stanislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(335, 'Kasalo', 'Vlado', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(336, 'Katai', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(337, 'Katalinić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(338, 'Katalinski', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(339, 'Katanec', 'Srećko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(340, 'Katić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(341, 'Kečkeš', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(342, 'Kesić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(343, 'Kežman', 'Mateja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(344, 'Kinert', 'Hugo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(345, 'Klaić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(346, 'Klinčarski', 'Nikica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(347, 'Klisura', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(348, 'Knez', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(349, 'Knežević', 'Bruno', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(350, 'Knežević', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(351, 'Kobešćak', 'Zdenko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(352, 'Kocić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(353, 'Kodrmja', 'Slavoljub', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(354, 'Kodro', 'Meho', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(355, 'Kojić', 'Andreja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(356, 'Kokeza', 'Ljubimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(357, 'Kolaković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(358, 'Kolaković', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(359, 'Kolaković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(360, 'Kolarov', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(361, 'Komljenović', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(362, 'Koroman', 'Ognjen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(363, 'Koščak', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(364, 'Kosanović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(365, 'Kostić', 'Borivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(366, 'Kostić', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(367, 'Kovačević', 'Abid', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(368, 'Kovačević', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(369, 'Kovačević', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(370, 'Kovačević', 'Oliver', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(371, 'Kovačević', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(372, 'Kovačević', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(373, 'Kovačić', 'Frane', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(374, 'Kozlina', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(375, 'Kragić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(376, 'Kralj', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(377, 'Kralj', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(378, 'Kranjčar', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(379, 'Krasić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(380, 'Kristić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(381, 'Krivokapić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(382, 'Krivokapić', 'Radovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(383, 'Krivokuća', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(384, 'Krivokuća', 'Srboljub', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(385, 'Kriz', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(386, 'Krmpotić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(387, 'Krnić', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(388, 'Krstajić', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(389, 'Krstić', 'Dobrosav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(390, 'Krstičević', 'Mišo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(391, 'Krstičić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(392, 'Kuci', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(393, 'Kujundžić', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(394, 'Kunst', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(395, 'Kustudić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(396, 'Kuzmanović', 'Zdravko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(397, 'Milović', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(398, 'Milunović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(399, 'Milutin', 'Šime', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(400, 'Milutinović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(401, 'Mirić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(402, 'Mirković', 'Miško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(403, 'Mirković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(404, 'Miročević', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(405, 'Mitić', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(406, 'Mitrović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(407, 'Mitrović', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(408, 'Mitrović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(409, 'Mitrović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(410, 'Mladenović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(411, 'Mladenović', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(412, 'Mladenović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(413, 'Mlinarić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(414, 'Mojsov', 'Sokrat', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(415, 'Monsider', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(416, 'Mrđa', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(417, 'Mrkela', 'Mitar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(418, 'Mrkić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15');
INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(419, 'Mrkušić', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(420, 'Mujić', 'Muhamed', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(421, 'Mujkić', 'Fikret', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(422, 'Musemić', 'Husref', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(423, 'Musemić', 'Vahidin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(424, 'Mušović', 'Džemaludin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(425, 'Mustedanagić', 'Dženal', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(426, 'Mutavdžić', 'Miljan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(427, 'Mutibarić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(428, 'Mužinić', 'Dražen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(429, 'Matošić', 'Jozo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(430, 'Matuš', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(431, 'Medarić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(432, 'Melić', 'Vojislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(433, 'Mešković', 'Rizah', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(434, 'Mihajlović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(435, 'Mihajlović', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(436, 'Mihajlović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(437, 'Mihajlović', 'Prvoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(438, 'Mihajlović', 'Radmilo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(439, 'Mihajlović', 'Siniša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(440, 'Mihalčić', 'Maksimilijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(441, 'Mijailović', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(442, 'Mijatović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(443, 'Mikačić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(444, 'Milanović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(445, 'Milanić', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(446, 'Milenković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(447, 'Milenković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(448, 'Miletić G.', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(449, 'Miletić R.', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(450, 'Milevoj', 'Anđelo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(451, 'Milijaš', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(452, 'Milinković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(453, 'Milinković-Savić', 'Sergej', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(454, 'Milivojević', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(455, 'Milić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(456, 'Miljanović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(457, 'Miljković', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(458, 'Miljuš', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(459, 'Milojević', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(460, 'Milojević', 'Sretko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(461, 'Milošević', 'Ćirjan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(462, 'Milošević', 'Savo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(463, 'Milošević', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(464, 'Milovanov', 'Sima', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(465, 'Milovanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(466, 'Maksimović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(467, 'Maksimović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(468, 'Malbaša', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(469, 'Malenčić', 'Rodoljub', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(470, 'Mance', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(471, 'Manić', 'Radivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(472, 'Manojlović', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(473, 'Manola', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(474, 'Mantula', 'Lav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(475, 'Maraš', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(476, 'Maravić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(477, 'Marcikić', 'Remija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(478, 'Marić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(479, 'Marić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(480, 'Marić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(481, 'Marinković', 'Sava', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(482, 'Marinov', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(483, 'Marjanović', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(484, 'Marjanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(485, 'Marjanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(486, 'Markovski', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(487, 'Marković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(488, 'Marković', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(489, 'Marković', 'Marjan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(490, 'Marković', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(491, 'Marković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(492, 'Marković', 'Vlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(493, 'Marović', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(494, 'Martinović', 'Egidio', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(495, 'Martinović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(496, 'Marušić', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(497, 'Maslovar', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(498, 'Matekalo', 'Florijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(499, 'Matić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(500, 'Matijević', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(501, 'Matošić', 'Frane', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(502, 'Ljajić', 'Adem', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(503, 'Ljubenović', 'Zarije-Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(504, 'Ljuboja', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(505, 'Ljukovčan', 'Živan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(506, 'Ladić', 'Dražen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(507, 'Lalatović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(508, 'Lamza', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(509, 'Lazarević', 'Vojin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(510, 'Lazetić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(511, 'Lazović', 'Danko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(512, 'Lazović', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(513, 'Lechner', 'Gustav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(514, 'Leinert', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(515, 'Lekić', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(516, 'Leković', 'Dragoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(517, 'Lemešić', 'Leo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(518, 'Lemić', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(519, 'Lešnik', 'August', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(520, 'Lipošinović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(521, 'Lojančić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(522, 'Lojen', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(523, 'Lomić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(524, 'Lončarević', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(525, 'Lović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(526, 'Löw', 'Pavao', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(527, 'Luburić', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(528, 'Lučić', 'Žarko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(529, 'Lukač', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(530, 'Lukarić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(531, 'Lukić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(532, 'Lukić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(533, 'Lukić', 'Vladan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(534, 'Luković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(535, 'Luštica', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(536, 'Načević', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(537, 'Nađ', 'Albert', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(538, 'Nadoveza', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(539, 'Najdanović', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(540, 'Najdoski', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(541, 'Nastasić', 'Matija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(542, 'Naumović', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(543, 'Nešticki', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(544, 'Neziri', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(545, 'Nikezić', 'Petar', 1, 'Napad', NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:22:37'),
(546, 'Nikolić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(547, 'Nikolić', 'Jovica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(548, 'Nikolić', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(549, 'Nikolić', 'Slavoljub', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(550, 'Nikolić', 'Žarko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(551, 'Ninkov', 'Pavle', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(552, 'Ninković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(553, 'Novak', 'Džoni', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(554, 'Novak', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(555, 'Novoselac', 'Martin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(556, 'Njeguš', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(557, 'Oblak', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(558, 'Obradović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(559, 'Obradović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(560, 'Obradović', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(561, 'Ocokoljić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(562, 'Ognjanov', 'Tihomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(563, 'Ognjanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(564, 'Ognjanović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(565, 'Ognjanović', 'Radivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(566, 'Ognjanović', 'Perica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(567, 'Omerović', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(568, 'Osim', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(569, 'Ostojić', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(570, 'Ožegović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(571, 'Pajević', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(572, 'Pajević', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(573, 'Palfi', 'Bela', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(574, 'Paločević', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(575, 'Panadić', 'Andrej', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(576, 'Pancev', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(577, 'Pandurović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(578, 'Panić', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(579, 'Pantelić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(580, 'Pantelić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(581, 'Pantelić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(582, 'Pantelić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(583, 'Pantić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(584, 'Pantić', 'Milinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(585, 'Papec', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(586, 'Pašić', 'Ilijas', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(587, 'Pašić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(588, 'Pašovan', 'Daniel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(589, 'Paunović', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(590, 'Paunović', 'Veljko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(591, 'Pavelić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(592, 'Pavkov', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(593, 'Pavlić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(594, 'Pavlica', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(595, 'Pavlović', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(596, 'Pavlović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(597, 'Pavlović', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(598, 'Pažur', 'Alfons', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(599, 'Pažur', 'Hugo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(600, 'Pejčinović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(601, 'Pejić', 'Aleksa', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(602, 'Percel', 'Adolf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(603, 'Perlić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(604, 'Perović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(605, 'Perska', 'Emanuel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(606, 'Perušić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(607, 'Peruzović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(608, 'Pešić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(609, 'Pešić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(610, 'Petaković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(611, 'Petković', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(612, 'Petković (Ilija)', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(613, 'Petković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(614, 'Petković', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(615, 'Petković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(616, 'Petrak', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(617, 'Petrić', 'Gordan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(618, 'Petronijević', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(619, 'Petrović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(620, 'Petrović', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(621, 'Petrović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(622, 'Petrović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(623, 'Petrović', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(624, 'Petrović', 'Miomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(625, 'Petrović', 'Ognjen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(626, 'Petrović', 'Radosav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(627, 'Petrović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(628, 'Petrović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(629, 'Petrović', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(630, 'Pirić', 'Danial', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(631, 'Pirmajer', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(632, 'Pjanović', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(633, 'Plavšić', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(634, 'Plazzeriano', 'Eugen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(635, 'Pleše', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(636, 'Podhradski', 'Jan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(637, 'Poduje', 'Šime', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(638, 'Poduje', 'Veljko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(639, 'Pogačnik', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(640, 'Poleksić', 'Vukašin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(641, 'Popivoda', 'Danilo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(642, 'Popović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(643, 'Popović', 'Stojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(644, 'Popović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(645, 'Porobić', 'Branimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(646, 'Požega', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(647, 'Praunsperger', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(648, 'Premerl', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(649, 'Prlјević', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(650, 'Primorac', 'Boro', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(651, 'Prljača', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(652, 'Prodanović', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(653, 'Prosinečki', 'Robert', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(654, 'Pudar', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(655, 'Radača', 'Vladan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(656, 'Radaković', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(657, 'Radaković', 'Radovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(658, 'Radanović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(659, 'Radenković', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(660, 'Radić', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(661, 'Radenović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(662, 'Radoja', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(663, 'Radonjić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(664, 'Radovanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(665, 'Radovanović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(666, 'Radović', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(667, 'Radović', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(668, 'Radović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(669, 'Radović', 'Vasilije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(670, 'Rajkov', 'Zdravko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(671, 'Rajković', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(672, 'Rajković', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(673, 'Rajković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(674, 'Rajković', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(675, 'Rajković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(676, 'Rajlić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(677, 'Ralić', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(678, 'Ramljak', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(679, 'Ranković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(680, 'Ranojević', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(681, 'Rašović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(682, 'Rašović', 'Vuk', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(683, 'Ravnić', 'Mauro', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(684, 'Repčić', 'Srebrenко', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(685, 'Ristović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(686, 'Rnić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(687, 'Rockov', 'Emil', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(688, 'Rodić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(689, 'Rodin', 'Janko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(690, 'Roganović', 'Novak', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(691, 'Rora', 'Krasnodar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(692, 'Rozić', 'Vedran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(693, 'Rudinski', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(694, 'Rukavina', 'Antonio', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(695, 'Rupec', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(696, 'Rupnik', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(697, 'Ružić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(698, 'Ružić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(699, 'Sakić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(700, 'Samardžić', 'Radoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(701, 'Samardžić', 'Spasoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(702, 'Sandić', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(703, 'Santrač', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(704, 'Sarić', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(705, 'Saveljić', 'Niša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(706, 'Savevski', 'Toni', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(707, 'Savić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(708, 'Savić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(709, 'Savićević', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(710, 'Scholz', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(711, 'Sedlar', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(712, 'Sekereš', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(713, 'Sekulić', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(714, 'Senčar', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(715, 'Simeunović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(716, 'Simić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(717, 'Simonović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(718, 'Simonović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(719, 'Simonović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(720, 'Simonovski', 'Kiril', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(721, 'Simović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(722, 'Šipoš', 'Vilmoš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(723, 'Skoblar', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(724, 'Slišković', 'Blaž', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(725, 'Slivak', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(726, 'Smajić', 'Admir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(727, 'Smajlović', 'Drago', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(728, 'Smiljanić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(729, 'Sombolac', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(730, 'Sotirović', 'Kuzman', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(731, 'Spajić', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(732, 'Spajić', 'Uroš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(733, 'Spasić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(734, 'Spasić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(735, 'Spasojević', 'Teofilo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(736, 'Spasovski', 'Metodije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(737, 'Sprečo', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(738, 'Stanić', 'Mario', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(739, 'Stanković', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(740, 'Stanković', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(741, 'Stanković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(742, 'Stanković', 'Vojislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(743, 'Stanojković', 'Vujadin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(744, 'Starovalah', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(745, 'Stefanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(746, 'Stefanović', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(747, 'Stepanov', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(748, 'Stepanović', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(749, 'Stevanović', 'Alen', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(750, 'Stevanović', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(751, 'Stevanović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(752, 'Stevanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(753, 'Stevanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(754, 'Stevanović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(755, 'Stević', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(756, 'Stevović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(757, 'Stincic', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(758, 'Stincic', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(759, 'Šupić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(760, 'Stojanović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(761, 'Stojanović', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(762, 'Stojanović', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(763, 'Stojić', 'Ranko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(764, 'Stojiljković', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(765, 'Stojiljković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(766, 'Stojković', 'Aranđel', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(767, 'Stojković', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(768, 'Stojković', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(769, 'Stojković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(770, 'Stošić', 'Vlada', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(771, 'Subotić', 'Neven', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(772, 'Sulejmani', 'Miralem', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(773, 'Sušić', 'Safet', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(774, 'Sušić', 'Sead', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(775, 'Svetličić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(776, 'Svilar', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(777, 'Svinjarević', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(778, 'Šabanadžović', 'Refik', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(779, 'Šalov', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(780, 'Šantek', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(781, 'Šarac', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(782, 'Šaranov', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(783, 'Šaula', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(784, 'Ščepović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(785, 'Ščepović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(786, 'Šećerbegović', 'Dževad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(787, 'Šefer', 'Bela', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(788, 'Šekularac', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(789, 'Šestić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(790, 'Šifer', 'Jaroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(791, 'Šifliš', 'Geza', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(792, 'Šijaković', 'Vasilije', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(793, 'Škorić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(794, 'Škoro', 'Haris', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(795, 'Škrbić', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(796, 'Škuletić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(797, 'Šljivo', 'Edhem', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(798, 'Šojat', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(799, 'Šoškić', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(800, 'Šoštarić', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(801, 'Šterk', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(802, 'Šuker', 'Davor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(803, 'Šurdonja', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(804, 'Šurjak', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(805, 'Švraka', 'Suad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(806, 'Tadić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(807, 'Takač', 'Silvester', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(808, 'Tasić', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(809, 'Tavčar', 'Stanko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(810, 'Tešan', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(811, 'Tirnanić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(812, 'Tomašević', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(813, 'Tomašević', 'Kosta', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(814, 'Tomić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(815, 'Tomić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(816, 'Tomić', 'Novak', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(817, 'Tomić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(818, 'Tomović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(819, 'Toplak', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(820, 'Tošić', 'Dragomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(821, 'Tošić', 'Duško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(822, 'Tošić', 'Rade', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(823, 'Tošić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(824, 'Trajković', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(825, 'Trajković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(826, 'Trifunović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(827, 'Trišović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(828, 'Trivić', 'Dobrivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(829, 'Trivunović', 'Veseljko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(830, 'Trobok', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(831, 'Tuce', 'Semir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30');
INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(832, 'Tutorić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(833, 'Urbanke', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(834, 'Urošević', 'Slobodan', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(835, 'Vabec', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(836, 'Valjarević', 'Svetislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(837, 'Valok', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(838, 'Valok', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(839, 'Vardić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(840, 'Vasković', 'Boris', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(841, 'Vasović', 'Velibor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(842, 'Velfl', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(843, 'Veljković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(844, 'Velker', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(845, 'Vermezović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(846, 'Veselinović', 'Todor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(847, 'Vidaković', 'Risto', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(848, 'Vidić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(849, 'Vidinić', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(850, 'Vidošević', 'Joško', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(851, 'Vidović', 'Želimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(852, 'Vilotić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(853, 'Vinek', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(854, 'Virić', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(855, 'Vitakić', 'Milivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(856, 'Vladić', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(857, 'Volkov', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(858, 'Vokri', 'Fadil', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(859, 'Vragović', 'Dragutin', 1, 'Sredina', 'igraci/SQzcfO8QM9RHgXxJJD0Ffb5KortqgjXXVehXBRyD.jpg', NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-10 20:03:44'),
(860, 'Vranješ', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(861, 'Vrđuka', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(862, 'Vrčak', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(863, 'Vujačić', 'Budimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(864, 'Vujadinović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(865, 'Vujkov', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(866, 'Vujović', 'Svetozar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(867, 'Vujović', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(868, 'Vujović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(869, 'Vukas', 'Bernard', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(870, 'Vukčević', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(871, 'Vukčević', 'Simon', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(872, 'Vukelić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(873, 'Vukić', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(874, 'Vukmir', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(875, 'Vukoje', 'Nedeljko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(876, 'Vukosavljević', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(877, 'Vukotić', 'Momčilo', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(878, 'Vuković', 'Jagoš', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(879, 'Vulić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(880, 'Vuličević', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(881, 'Zagorac', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(882, 'Zajec', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(883, 'Zajić', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(884, 'Zambata', 'Slaven', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(885, 'Zavišić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(886, 'Zdjelar', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(887, 'Zebec', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(888, 'Zečević', 'Dobrivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(889, 'Zeković', 'Miljan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(890, 'Zemko', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(891, 'Zinaja', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(892, 'Zinaja', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(893, 'Zorić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(894, 'Žanetić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(895, 'Žigić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(896, 'Žilić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(897, 'Živanović', 'Todor', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(898, 'Živković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(899, 'Živković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(900, 'Živković', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(901, 'Živković', 'Bratislav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(902, 'Živković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(903, 'Živković', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(904, 'Žungul', 'Slaviša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(905, 'Župančić', 'Vjekoslav', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `igraci_klubovi`
--

DROP TABLE IF EXISTS `igraci_klubovi`;
CREATE TABLE IF NOT EXISTS `igraci_klubovi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `klub` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `drzava_kluba` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `od_datuma` date DEFAULT NULL,
  `do_datuma` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `igraci_klubovi_igrac_id_foreign` (`igrac_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `izmene`
--

DROP TABLE IF EXISTS `izmene`;
CREATE TABLE IF NOT EXISTS `izmene` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `igrac_out_id` bigint UNSIGNED NOT NULL,
  `igrac_in_id` bigint UNSIGNED NOT NULL,
  `minut` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `izmene_utakmica_id_foreign` (`utakmica_id`),
  KEY `izmene_tim_id_foreign` (`tim_id`),
  KEY `izmene_igrac_out_id_foreign` (`igrac_out_id`),
  KEY `izmene_igrac_in_id_foreign` (`igrac_in_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kartoni`
--

DROP TABLE IF EXISTS `kartoni`;
CREATE TABLE IF NOT EXISTS `kartoni` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `tip` enum('zuti','crveni') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `minut` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kartoni_utakmica_id_foreign` (`utakmica_id`),
  KEY `kartoni_igrac_id_foreign` (`igrac_id`),
  KEY `kartoni_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '0001_01_01_000000_create_users_table', 2),
(19, '0001_01_01_000001_create_cache_table', 2),
(20, '0001_01_01_000002_create_jobs_table', 2),
(21, '2025_02_28_192711_create_timovi_table', 2),
(22, '2025_02_28_192712_create_igraci_table', 2),
(23, '2025_02_28_192712_create_stadioni_table', 2),
(24, '2025_02_28_192713_create_sudije_table', 2),
(25, '2025_02_28_192713_create_takmicenja_table', 2),
(26, '2025_02_28_192714_create_utakmice_table', 2),
(27, '2025_02_28_192715_create_golovi_table', 2),
(28, '2025_02_28_192715_create_sastavi_table', 2),
(29, '2025_02_28_192716_create_izmene_table', 2),
(16, '2025_03_02_000001_create_igraci_klubovi_table', 1),
(30, '2025_02_28_192717_create_kartoni_table', 2),
(31, '2025_03_01_142229_add_team_alias_columns_to_timovi_table', 2),
(32, '2025_03_01_192908_create_bivsi_klubovi_table', 2),
(33, '2025_03_02_000002_add_team_alias_columns_to_timovi_table', 2),
(34, '2025_03_05_200518_create_protivnicki_igraci_table', 3),
(35, '2025_03_08_165802_add_player_type_to_goals_table', 4),
(36, '2025_03_08_181016_modify_utakmice_table', 5),
(37, '2025_03_08_231310_make_takmicenje_nullable_in_utakmice_table', 6),
(38, '2025_03_09_121508_create_selektori_table', 7),
(39, '2025_03_09_125705_create_selektor_mandatii_table', 8),
(40, '2025_03_09_144529_create_protivnicki_selektori_table', 9),
(41, '2025_03_10_203217_allow_null_minut_in_golovi_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `protivnicki_igraci`
--

DROP TABLE IF EXISTS `protivnicki_igraci`;
CREATE TABLE IF NOT EXISTS `protivnicki_igraci` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `kapiten` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `protivnicki_igraci_utakmica_id_foreign` (`utakmica_id`),
  KEY `protivnicki_igraci_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicki_igraci`
--

INSERT INTO `protivnicki_igraci` (`id`, `ime`, `prezime`, `utakmica_id`, `tim_id`, `kapiten`, `created_at`, `updated_at`) VALUES
(1, 'Fehmi', 'Mert Günok', 1, 8, 0, '2025-03-05 19:24:18', '2025-03-05 19:24:18'),
(2, 'Hasan', 'Ali Kaldırım', 1, 8, 0, '2025-03-05 19:24:37', '2025-03-05 19:24:37'),
(3, 'Zeki', 'Çelik', 1, 8, 0, '2025-03-05 19:27:39', '2025-03-05 19:27:39'),
(4, 'Anton', 'Shunin', 2, 9, 0, '2025-03-05 19:58:37', '2025-03-05 19:58:37'),
(5, 'Mário', 'Fernandes', 2, 9, 0, '2025-03-05 19:58:51', '2025-03-05 19:58:51'),
(6, 'Rune', 'Jarstein', 2, 9, 0, '2025-03-08 17:37:32', '2025-03-08 17:37:32'),
(7, 'Omar', 'Elabdellaoui', 2, 9, 0, '2025-03-08 17:37:54', '2025-03-08 17:37:54'),
(8, 'Vyacheslav', 'Karavaev', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(9, 'Georgi', 'Dzhikiya', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(10, 'Andrei', 'Semenov', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(11, 'Aleksey', 'Ionov', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(12, 'Roman', 'Zobnin', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(13, 'Yuriy', 'Zhirkov', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(14, 'Magomed', 'Ozdoev', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(15, 'Artem', 'Dzyuba', 2, 9, 1, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(16, 'Zelimkhan', 'Bakaev', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(17, 'Rudolf', 'Klapka', 8, 23, 0, '2025-03-10 18:37:31', '2025-03-10 18:37:31'),
(18, 'Antonin', 'Hojer', 8, 23, 0, '2025-03-10 18:37:48', '2025-03-10 18:37:48'),
(19, 'Miroslav', 'Pospíšil', 8, 23, 0, '2025-03-10 18:38:01', '2025-03-10 18:38:01'),
(20, 'František', 'Kolenatý', 8, 23, 0, '2025-03-10 18:38:14', '2025-03-10 18:38:14'),
(21, 'Karel', 'Pešek ‘Káďa’', 8, 23, 1, '2025-03-10 18:38:31', '2025-03-10 18:38:31'),
(22, 'Antonín', 'Perner', 8, 23, 0, '2025-03-10 18:38:43', '2025-03-10 18:38:43'),
(23, 'Josef', 'Sedláček', 8, 23, 0, '2025-03-10 18:39:04', '2025-03-10 18:39:04'),
(24, 'Antonín', 'Janda', 8, 23, 0, '2025-03-10 18:39:19', '2025-03-10 18:39:19'),
(25, 'Václav', 'Pilát', 8, 23, 0, '2025-03-10 18:39:33', '2025-03-10 18:39:33'),
(26, 'Jan', 'Vaník', 8, 23, 0, '2025-03-10 18:39:55', '2025-03-10 18:39:55'),
(27, 'Otakar', 'Škvajn', 8, 23, 0, '2025-03-10 18:40:14', '2025-03-10 18:40:14'),
(28, 'Kamel', 'Taha', 10, 102, 0, '2025-03-10 19:18:45', '2025-03-10 19:18:45'),
(29, 'Mohamed', 'El Sayed', 10, 102, 0, '2025-03-10 19:19:02', '2025-03-10 19:19:02'),
(30, 'Abdel Salam', 'Hamdy', 10, 102, 0, '2025-03-10 19:19:19', '2025-03-10 19:19:19'),
(31, 'Riad', 'Shawid', 10, 102, 0, '2025-03-10 19:19:34', '2025-03-10 19:19:34'),
(32, 'Aly Fahmy', 'El Hassany', 10, 102, 0, '2025-03-10 19:19:48', '2025-03-10 19:19:48'),
(33, 'Gamil', 'Osman', 10, 102, 0, '2025-03-10 19:20:04', '2025-03-10 19:20:04'),
(34, 'Tawfik', 'Abdalla', 10, 102, 0, '2025-03-10 19:20:20', '2025-03-10 19:20:20'),
(35, 'Hassan', 'Allouba', 10, 102, 0, '2025-03-10 19:22:54', '2025-03-10 19:22:54'),
(36, 'Hussein', 'Hegazy', 10, 102, 1, '2025-03-10 19:23:08', '2025-03-10 19:23:08'),
(37, 'Sayed', 'Abaza', 10, 102, 0, '2025-03-10 19:23:23', '2025-03-10 19:23:23'),
(38, 'Zaki', 'Othman', 10, 102, 0, '2025-03-10 19:23:35', '2025-03-10 19:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `protivnicki_selektori`
--

DROP TABLE IF EXISTS `protivnicki_selektori`;
CREATE TABLE IF NOT EXISTS `protivnicki_selektori` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `ime_prezime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `napomena` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `protivnicki_selektori_utakmica_id_tim_id_unique` (`utakmica_id`,`tim_id`),
  KEY `protivnicki_selektori_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicki_selektori`
--

INSERT INTO `protivnicki_selektori` (`id`, `utakmica_id`, `tim_id`, `ime_prezime`, `napomena`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'Stanislav Cherchesov', NULL, '2025-03-09 14:38:11', '2025-03-09 14:38:11'),
(2, 8, 23, 'Josef Fanta', NULL, '2025-03-10 18:41:34', '2025-03-10 18:41:34'),
(3, 10, 102, 'Hussein Hegazi', NULL, '2025-03-10 19:16:51', '2025-03-10 19:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `sastavi`
--

DROP TABLE IF EXISTS `sastavi`;
CREATE TABLE IF NOT EXISTS `sastavi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `starter` tinyint(1) NOT NULL DEFAULT '1',
  `selektor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sastavi_utakmica_id_foreign` (`utakmica_id`),
  KEY `sastavi_tim_id_foreign` (`tim_id`),
  KEY `sastavi_igrac_id_foreign` (`igrac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sastavi`
--

INSERT INTO `sastavi` (`id`, `utakmica_id`, `tim_id`, `igrac_id`, `starter`, `selektor`, `created_at`, `updated_at`) VALUES
(4, 8, 5, 861, 1, 'Veljko Ugrinić', '2025-03-09 18:39:21', '2025-03-09 18:39:21'),
(5, 8, 5, 905, 1, 'Veljko Ugrinić', '2025-03-09 18:39:21', '2025-03-09 18:39:21'),
(6, 8, 5, 790, 1, 'Veljko Ugrinić', '2025-03-09 18:39:21', '2025-03-09 18:39:21'),
(7, 8, 5, 809, 1, NULL, '2025-03-09 18:42:42', '2025-03-09 18:42:42'),
(8, 8, 5, 107, 1, NULL, '2025-03-09 18:43:01', '2025-03-09 18:43:01'),
(9, 8, 5, 695, 1, NULL, '2025-03-09 18:43:15', '2025-03-09 18:43:15'),
(10, 8, 5, 859, 1, NULL, '2025-03-09 18:43:27', '2025-03-09 18:43:27'),
(11, 8, 5, 164, 1, NULL, '2025-03-09 18:43:38', '2025-03-09 18:43:38'),
(12, 8, 5, 605, 1, NULL, '2025-03-09 18:43:53', '2025-03-09 18:43:53'),
(13, 8, 5, 226, 1, NULL, '2025-03-09 18:44:05', '2025-03-09 18:44:05'),
(14, 8, 5, 697, 1, NULL, '2025-03-09 18:44:20', '2025-03-09 18:44:20'),
(15, 10, 5, 861, 1, NULL, '2025-03-10 19:13:07', '2025-03-10 19:13:07'),
(16, 10, 5, 790, 1, NULL, '2025-03-10 19:13:23', '2025-03-10 19:13:23'),
(17, 10, 5, 645, 1, NULL, '2025-03-10 19:13:34', '2025-03-10 19:13:34'),
(18, 10, 5, 809, 1, NULL, '2025-03-10 19:13:47', '2025-03-10 19:13:47'),
(19, 10, 5, 695, 1, NULL, '2025-03-10 19:13:57', '2025-03-10 19:13:57'),
(20, 10, 5, 859, 1, NULL, '2025-03-10 19:14:14', '2025-03-10 19:14:14'),
(21, 10, 5, 710, 1, NULL, '2025-03-10 19:14:24', '2025-03-10 19:14:24'),
(22, 10, 5, 716, 1, NULL, '2025-03-10 19:14:36', '2025-03-10 19:14:36'),
(23, 10, 5, 164, 1, NULL, '2025-03-10 19:14:50', '2025-03-10 19:14:50'),
(24, 10, 5, 605, 1, NULL, '2025-03-10 19:15:05', '2025-03-10 19:15:05'),
(25, 10, 5, 697, 1, NULL, '2025-03-10 19:15:18', '2025-03-10 19:15:18');

-- --------------------------------------------------------

--
-- Table structure for table `selektori`
--

DROP TABLE IF EXISTS `selektori`;
CREATE TABLE IF NOT EXISTS `selektori` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezime` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datum_rodjenja` date DEFAULT NULL,
  `mesto_rodjenja` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datum_smrti` date DEFAULT NULL,
  `mesto_smrti` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drzavljanstvo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biografija` text COLLATE utf8mb4_unicode_ci,
  `fotografija_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektori`
--

INSERT INTO `selektori` (`id`, `ime`, `prezime`, `datum_rodjenja`, `mesto_rodjenja`, `datum_smrti`, `mesto_smrti`, `drzavljanstvo`, `biografija`, `fotografija_path`, `created_at`, `updated_at`) VALUES
(1, 'Veljko', 'Ugrinić', '1885-12-28', 'Stara Gradiška', '1958-07-18', 'Zagreb', NULL, 'Veljko Ugrinić (Stara Gradiška, 28. prosinca 1885. - Zagreb, 15. srpnja 1958.) je bio hrvatski nogometni stručnjak, atletičar, poznati zagrebački športski radnik i svestrani aktivni športaš. Bio je članom športskog društva Concordije iz Zagreba.\r\n\r\nNogometom se bavio od 1903. godine. Jednim je od suosnivača PNIŠK-a. Bavio se lakom atletikom. 1906. je pobijedio na prvoj priredbi koja se je održala u Zagrebu. Natjecao se u disciplini trčanje 3000 m (trčalo se od Dubrave do Zagreba) i na 100 m.\r\n\r\nNakon što je završio Prvi svjetski rat, djeluje pri atletičarskom odjelu Concordije. 1919. je bio suosnivačem i prvim predsjednikom Lakoatletskog saveza Hrvatske i Slavonije te Jugoslavenskog lakoatletskog saveza 1921., čijim je čelnikom bio sve do 1937. godine. Od 1919. sve do 1937. bio je članom Jugoslavenskog olimpijskog odbora.\r\n\r\nKad je bio osnivan Jugoslavenski nogometni savez, na osnivačkoj sjednici bila su zastupljena nogometna središta: Beograd, Karlovac, Niš, Novi Sad, Osijek, Požega, Sisak, Skoplje, Slavonski Brod, Split, Valjevo, Varaždin i Zagreb (7 zagrebačkih klubova). Osnivačku sjednicu vodio je Hinko Würth koji je izabran za prvog predsjednika JNS-a. Prvim tajnikom Saveza postao je dr. Fran Šuklje. Priznata su nogometna pravila koja je preveo dr. Milovan Zoričić. Prof. Franjo Bučar je predviđen za predstavnika u FIFA-i, a izbornikom reprezentacije je postao Veljko Ugrinić. Vodio ju je od 1920. do 1924. godine.[1] Reprezentaciju je vodio na Olimpijskim igrama 1920., a bio je smijenjen uoči Olimpijskih igara 1924., jer su u savezu radije odlučili smijeniti trenera nego promijeniti problematične igrače. Kao trener, tri je puta pobijedio, jednom je igrao neriješeno te šest puta izgubio. Reprezentacija je pod njegovim vođenjem napredovala. Unutar samo dvije godine uspjela je pobijediti momčadi od kojih je prije dvije godine (teško) izgubila (Čehoslovačka 1920. 0:7 i 1921. 1:6, 1922. 4:3, Poljska, Rumunjska).\r\n\r\nPredsjedao je Jugoslavenskim nogometnim savezom od 1923. do 1924., naslijedivši Miroslava Petanjka. Ugrinića je na mjestu predsjednika naslijedio Hinko Würth.\r\n\r\nBio je godine bio jednim od suosnivača Balkanskih atletskih igara. 1934. je bio organizirao 5. Balkanske atletske igre u Zagrebu. Četiri godine je godine predsjedao Interbalkanskim komitetom.\r\n\r\n15. travnja 1936. je u Zagrebu održana utemeljiteljska skupština jugoslavenskog hokejskog (hockey) saveza. Na toj je sjednici za predsjednika saveza izabran Veljko Ugrinić.[2]\r\n\r\nDok je trajao travanjski rat 1941. nekoliko su ga puta uhitili i zatvorili.\r\n\r\nZadnji put se je natjecao u atletici 1947. za Omladinsko studentsko fiskulturno društvo Mladost. Osim toga, poslije rata organizirao je u Hrvatskoj streljačka natjecanja. Obnašao je razne visoke športske dužnosti, pa je potpredsjedao Fiskulturnim savezom Hrvatske, bio odbornikom Komiteta za fiskulturu Hrvatske, predsjedao je Atletskim savezom Hrvatske te je bio član inim športskim i društvenim organizacijama na razini grada Zagreba, Hrvatske te Jugoslavije.', NULL, '2025-03-09 12:06:25', '2025-03-09 13:11:58'),
(3, 'Todor', 'Sekulić', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-09 17:49:38', '2025-03-09 17:49:38'),
(4, 'Dušan', 'Zinaja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-09 17:51:40', '2025-03-09 17:51:40'),
(5, 'Ante', 'Pandaković', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-09 18:24:48', '2025-03-09 18:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `selektor_mandati`
--

DROP TABLE IF EXISTS `selektor_mandati`;
CREATE TABLE IF NOT EXISTS `selektor_mandati` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `selektor_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `pocetak_mandata` date NOT NULL,
  `kraj_mandata` date DEFAULT NULL,
  `v_d_status` tinyint(1) NOT NULL DEFAULT '0',
  `napomena` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `selektor_mandati_selektor_id_foreign` (`selektor_id`),
  KEY `selektor_mandati_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektor_mandati`
--

INSERT INTO `selektor_mandati` (`id`, `selektor_id`, `tim_id`, `pocetak_mandata`, `kraj_mandata`, `v_d_status`, `napomena`, `created_at`, `updated_at`) VALUES
(1, 2, 5, '1924-10-02', NULL, 0, NULL, '2025-03-09 12:06:49', '2025-03-09 12:06:49'),
(2, 1, 5, '1920-08-28', '1924-02-10', 0, NULL, '2025-03-09 12:13:16', '2025-03-09 12:13:16'),
(3, 3, 5, '1924-05-26', '1924-05-26', 0, NULL, '2025-03-09 17:49:38', '2025-03-09 17:49:38'),
(4, 4, 5, '1924-09-28', '1925-11-04', 0, NULL, '2025-03-09 17:51:40', '2025-03-09 17:51:40'),
(5, 5, 5, '1926-05-30', '1930-01-26', 0, NULL, '2025-03-09 18:24:48', '2025-03-09 18:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Ewlh4h77PlhNjhWPRzKr5nRrQUYNblRay4HcUWzx', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMk1oWkhpdmVrZkJEWDMzWjZYclZDNzhMR2h5T1F3dXVyN0NyaTU5MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3QvcmVwcmV6ZW50YWNpamEvcHVibGljL2lncmFjaS80Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741626782),
('JxWJQso1wycKxsXCRR4CuMsCCynv202qSL2AyZ8x', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2Q0cTdSTHFHSXhyRDBoUGFxcTZHdUlDdDFyZnJJRVpkN0x5UEJvUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3QvcmVwcmV6ZW50YWNpamEvcHVibGljL3V0YWttaWNlP3BhZ2U9MiI7fX0=', 1741718408),
('J9w1SPlR8sRvSCHeNQtP3TdkWzHB0HCGGiaolB5S', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWFpeWpMcmxISmxZZXpiSEw5enpIdGltbkp5cFpyUnBqUzRXY2R0ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3QvcmVwcmV6ZW50YWNpamEvcHVibGljL3V0YWttaWNlLzEwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1741637405);

-- --------------------------------------------------------

--
-- Table structure for table `stadioni`
--

DROP TABLE IF EXISTS `stadioni`;
CREATE TABLE IF NOT EXISTS `stadioni` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `naziv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grad` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zemlja` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kapacitet` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sudije`
--

DROP TABLE IF EXISTS `sudije`;
CREATE TABLE IF NOT EXISTS `sudije` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `ime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prezime` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nacionalnost` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `takmicenja`
--

DROP TABLE IF EXISTS `takmicenja`;
CREATE TABLE IF NOT EXISTS `takmicenja` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `naziv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sezona` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organizator` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `takmicenja`
--

INSERT INTO `takmicenja` (`id`, `naziv`, `sezona`, `organizator`, `created_at`, `updated_at`) VALUES
(1, 'Prijateljska', NULL, NULL, '2025-03-02 19:46:20', '2025-03-02 19:46:20'),
(2, 'Polufinale baraža za plasman na EURO 2020', NULL, NULL, '2025-03-08 17:17:54', '2025-03-08 17:17:54'),
(3, 'Olimpijske igre', NULL, NULL, '2025-03-10 18:47:32', '2025-03-10 18:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `timovi`
--

DROP TABLE IF EXISTS `timovi`;
CREATE TABLE IF NOT EXISTS `timovi` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `naziv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `skraceni_naziv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zastava_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grb_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zemlja` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `glavni_tim` tinyint(1) NOT NULL DEFAULT '0',
  `maticni_tim_id` bigint UNSIGNED DEFAULT NULL,
  `aktivan_od` datetime DEFAULT NULL,
  `aktivan_do` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timovi_maticni_tim_id_foreign` (`maticni_tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timovi`
--

INSERT INTO `timovi` (`id`, `naziv`, `skraceni_naziv`, `zastava_url`, `grb_url`, `zemlja`, `glavni_tim`, `maticni_tim_id`, `aktivan_od`, `aktivan_do`, `created_at`, `updated_at`) VALUES
(1, 'Srbija', 'SRB', 'ser.png', 'ser.png', 'Srbija', 1, NULL, '2006-06-05 00:00:00', NULL, '2025-03-02 18:11:49', '2025-03-02 18:11:49'),
(2, 'Srbija i Crna Gora', 'SCG', 'scg.png', 'scg.png', 'Srbija i Crna Gora', 0, 1, '2003-02-04 00:00:00', '2006-06-04 00:00:00', '2025-03-02 18:11:49', '2025-03-02 18:11:49'),
(3, 'SR Jugoslavija', 'SRJ', 'srj.png', 'srj.png', 'SR Jugoslavija', 0, 1, '1992-04-27 00:00:00', '2003-02-03 00:00:00', '2025-03-02 18:11:49', '2025-03-02 18:11:49'),
(4, 'SFRJ', 'YUG', 'jug.png', 'jug.png', 'SFRJ', 0, 1, '1945-11-29 00:00:00', '1992-04-26 00:00:00', '2025-03-02 18:11:49', '2025-03-02 18:11:49'),
(5, 'Kraljevina Jugoslavija', 'YUG', 'yug.png', 'yug.png', 'Kraljevina Jugoslavija', 0, 1, '1929-10-03 00:00:00', '1945-11-28 00:00:00', '2025-03-02 18:11:49', '2025-03-02 18:11:49'),
(8, 'Turska', 'TUR', 'tur.png', 'tur.png', 'Turska', 0, NULL, NULL, NULL, '2025-03-02 19:45:47', '2025-03-02 19:45:47'),
(9, 'Rusija', 'RUS', 'rus.png', 'rus.png', 'Rusija', 0, NULL, NULL, NULL, '2025-03-05 19:39:24', '2025-03-05 19:39:24'),
(10, 'Norveška', 'NOR', 'nor.png', 'nor.png', 'Norveška', 0, NULL, NULL, NULL, '2025-03-08 17:16:49', '2025-03-08 17:16:49'),
(11, 'Albanija', NULL, 'alb.png', 'alb.png', '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(12, 'Alžir', 'ALG', 'alg.png', 'alg.png', 'Alžir', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 09:46:08'),
(13, 'Argentina', 'ARG', 'arg.png', 'arg.png', 'Argentina', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 16:01:09'),
(14, 'Australija', 'AUT', 'aut.png', 'aut.png', 'Asutralija', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 16:01:28'),
(16, 'Azerbejdžan', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(17, 'Belgija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(18, 'Bolivija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(19, 'Bosna i Hercegovina', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(20, 'Brazil', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(22, 'Crna Gora', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(23, 'Čehoslovačka', 'CZE', 'cze.png', 'cze.png', 'Čehoslovačka', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 16:01:50'),
(24, 'Čile', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(25, 'Danska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(27, 'Ekvador', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(28, 'El Salvador', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(29, 'Engleska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(30, 'Estonija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(31, 'Etiopija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(32, 'Evropa', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(33, 'Farska Ostrva', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(34, 'Finska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(36, 'Gana', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(37, 'Grčka', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(38, 'Gruzija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(39, 'Holandija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(40, 'Hong Kong', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(41, 'Honduras', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(42, 'Hrvatska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(43, 'Indija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(44, 'Indonezija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(45, 'Iran', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(46, 'Republika Irska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(47, 'Severna Irska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(49, 'Izrael', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(50, 'Jamajka', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(51, 'Japan', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(52, 'Jermenija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(53, 'Južna Afrika', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(54, 'Južna Koreja', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(55, 'Kamerun', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(56, 'Kazahstan', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(57, 'Kina', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(58, 'Kipar', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(59, 'Kolumbija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(60, 'Kostarika', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(61, 'Litvanija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(62, 'Luksemburg', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(63, 'Malta', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(64, 'Mađarska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(65, 'BJR Makedonija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(66, 'Maroko', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(67, 'Meksiko', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(68, 'Moldavija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(69, 'Nemačka DR', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(70, 'Nemačka SR', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(71, 'Nigerija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(73, 'Novi Zeland', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(74, 'Obala Slonovače', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(75, 'Panama', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(76, 'Paragvaj', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(77, 'Peru', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(79, 'Portugal', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(82, 'SAD', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(83, 'San Marino', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(84, 'Saudijska Arabija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(85, 'Slovačka', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(86, 'Slovenija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(87, 'Škotska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(88, 'Španija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(89, 'Švajcarska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(90, 'Švedska', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(91, 'Tunis', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(93, 'UAE', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(94, 'Ukrajina', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-08 18:12:13'),
(96, 'Velika Britanija', NULL, NULL, NULL, 'Velika Britanija', 0, NULL, NULL, NULL, '2025-03-08 18:13:04', '2025-03-08 18:13:04'),
(97, 'Vels', NULL, NULL, NULL, 'Vels', 0, NULL, NULL, NULL, '2025-03-08 18:13:18', '2025-03-08 18:13:18'),
(98, 'Venecuela', NULL, NULL, NULL, 'Venecuela', 0, NULL, NULL, NULL, '2025-03-08 18:13:29', '2025-03-08 18:13:29'),
(99, 'Zair', NULL, NULL, NULL, 'Zair', 0, NULL, NULL, NULL, '2025-03-08 18:13:40', '2025-03-08 18:13:40'),
(102, 'Egipat', 'EGY', 'egy.png', 'egy.png', 'Egipat', 0, NULL, NULL, NULL, NULL, '2025-03-10 18:53:16'),
(103, 'Rumunija', 'ROU', NULL, NULL, 'Rumunija', 0, NULL, NULL, NULL, NULL, NULL),
(104, 'Poljska', 'POL', NULL, NULL, 'Poljska', 0, NULL, NULL, NULL, NULL, NULL),
(105, 'Austrija', 'AUT', 'aut.png', 'aut.png', 'Austrija', 0, NULL, NULL, NULL, NULL, '2025-03-09 14:52:13'),
(106, 'Urugvaj', 'URU', 'uru.png', 'uru.png', 'Urugvaj', 0, NULL, NULL, NULL, NULL, NULL),
(107, 'Italija', 'ITA', NULL, NULL, 'Italija', 0, NULL, NULL, NULL, NULL, NULL),
(108, 'Bugarska', 'BUL', 'bul.png', 'bul.png', 'Bugarska', 0, NULL, NULL, NULL, NULL, '2025-03-10 18:49:23'),
(109, 'Francuska', 'FRA', NULL, NULL, 'Francuska', 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utakmice`
--

DROP TABLE IF EXISTS `utakmice`;
CREATE TABLE IF NOT EXISTS `utakmice` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `takmicenje_id` bigint UNSIGNED DEFAULT NULL,
  `domacin_id` bigint UNSIGNED NOT NULL,
  `gost_id` bigint UNSIGNED NOT NULL,
  `stadion` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sudija` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rezultat_domacin` int NOT NULL DEFAULT '0',
  `rezultat_gost` int NOT NULL DEFAULT '0',
  `publika` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utakmice_domacin_id_foreign` (`domacin_id`),
  KEY `utakmice_gost_id_foreign` (`gost_id`),
  KEY `utakmice_takmicenje_id_foreign` (`takmicenje_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utakmice`
--

INSERT INTO `utakmice` (`id`, `datum`, `takmicenje_id`, `domacin_id`, `gost_id`, `stadion`, `sudija`, `rezultat_domacin`, `rezultat_gost`, `publika`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, '1988-02-05', 1, 4, 8, NULL, NULL, 0, 0, '2000', NULL, '2025-03-02 19:46:56', '2025-03-02 19:46:56'),
(2, '2020-09-03', 1, 9, 1, 'VTB Arena', 'William Collum (Sco)', 3, 5, '0', NULL, '2025-03-05 19:40:21', '2025-03-08 16:58:35'),
(3, '2020-08-10', 2, 10, 1, 'Ullevaal Stadion', 'Daniele Orsato (Ita)', 2, 0, '200', NULL, '2025-03-08 17:17:54', '2025-03-08 17:43:31'),
(8, '1920-08-28', 3, 5, 23, 'Stadion Broodstraat, Antwerp (Bel)', 'Raphael van Praag (Bel)', 0, 7, '600', NULL, NULL, '2025-03-10 18:47:32'),
(10, '1920-09-02', 1, 5, 102, 'Olympisch Stadion, Antwerp (Bel)', 'Raphaël Van Praag (Bel)', 2, 4, '500', NULL, NULL, '2025-03-10 19:38:02'),
(11, '1921-10-28', NULL, 23, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(12, '1922-06-08', NULL, 5, 103, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(13, '1922-06-28', NULL, 5, 23, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(14, '1922-10-01', NULL, 5, 104, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(15, '1923-06-03', NULL, 104, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(16, '1923-06-10', NULL, 103, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(17, '1923-10-28', NULL, 23, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(18, '1924-02-10', NULL, 5, 105, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(19, '1924-05-26', NULL, 5, 106, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(20, '1924-09-28', NULL, 5, 23, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(21, '1925-10-28', NULL, 23, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(22, '1925-11-04', NULL, 107, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(23, '1926-05-30', NULL, 5, 108, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(24, '1926-06-13', NULL, 109, 5, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(25, '1926-06-28', NULL, 5, 23, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(26, '1926-10-05', NULL, 5, 103, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
