-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 09, 2025 at 02:54 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bivsi_klubovi`
--

INSERT INTO `bivsi_klubovi` (`id`, `igrac_id`, `naziv`, `drzava`, `sezona`, `stepen_takmicenja`, `broj_nastupa`, `broj_golova`, `created_at`, `updated_at`) VALUES
(5, 104, 'FK Galenika Zemun', 'SFRJ', '1982-83', '1', 18, 4, '2025-03-08 19:16:14', '2025-03-09 10:29:59'),
(6, 114, 'NK Dinamo Zagreb', 'SFRJ', '1980-81', '1', 17, 1, '2025-03-09 10:12:40', '2025-03-09 10:29:13');

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
  `minut` int NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `penal` tinyint(1) NOT NULL DEFAULT '0',
  `auto_gol` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `golovi_utakmica_id_foreign` (`utakmica_id`),
  KEY `golovi_igrac_id_foreign` (`igrac_id`),
  KEY `golovi_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `golovi`
--

INSERT INTO `golovi` (`id`, `utakmica_id`, `igrac_id`, `igrac_tip`, `minut`, `tim_id`, `penal`, `auto_gol`, `created_at`, `updated_at`) VALUES
(2, 2, 4, 'protivnicki', 48, 9, 0, 0, '2025-03-08 16:00:32', '2025-03-08 16:00:32'),
(3, 2, 5, 'protivnicki', 56, 9, 1, 0, '2025-03-08 16:09:28', '2025-03-08 16:09:28'),
(6, 2, 4, 'protivnicki', 1, 9, 0, 0, '2025-03-08 16:49:45', '2025-03-08 16:49:45'),
(8, 2, 4, 'protivnicki', 34, 9, 0, 1, '2025-03-08 16:58:35', '2025-03-08 16:58:35'),
(9, 3, 6, 'protivnicki', 88, 10, 0, 0, '2025-03-08 17:42:32', '2025-03-08 17:42:32'),
(10, 3, 7, 'protivnicki', 12, 10, 0, 0, '2025-03-08 17:43:31', '2025-03-08 17:43:31');

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
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(128, 'Ćalasan', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(129, 'Ćirić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(130, 'Ćirković', 'Milivoje', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(131, 'Ćirković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(132, 'Ćurčić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(133, 'Ćurić', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(134, 'Ćurković', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07');

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(40, '2025_03_09_144529_create_protivnicki_selektori_table', 9);

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(16, 'Zelimkhan', 'Bakaev', 2, 9, 0, '2025-03-08 18:17:38', '2025-03-08 18:17:38');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicki_selektori`
--

INSERT INTO `protivnicki_selektori` (`id`, `utakmica_id`, `tim_id`, `ime_prezime`, `napomena`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'Stanislav Cherchesov', NULL, '2025-03-09 14:38:11', '2025-03-09 14:38:11');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektori`
--

INSERT INTO `selektori` (`id`, `ime`, `prezime`, `datum_rodjenja`, `mesto_rodjenja`, `datum_smrti`, `mesto_smrti`, `drzavljanstvo`, `biografija`, `fotografija_path`, `created_at`, `updated_at`) VALUES
(1, 'Veljko', 'Ugrinić', '1885-12-28', 'Stara Gradiška', '1958-07-18', 'Zagreb', NULL, 'Veljko Ugrinić (Stara Gradiška, 28. prosinca 1885. - Zagreb, 15. srpnja 1958.) je bio hrvatski nogometni stručnjak, atletičar, poznati zagrebački športski radnik i svestrani aktivni športaš. Bio je članom športskog društva Concordije iz Zagreba.\r\n\r\nNogometom se bavio od 1903. godine. Jednim je od suosnivača PNIŠK-a. Bavio se lakom atletikom. 1906. je pobijedio na prvoj priredbi koja se je održala u Zagrebu. Natjecao se u disciplini trčanje 3000 m (trčalo se od Dubrave do Zagreba) i na 100 m.\r\n\r\nNakon što je završio Prvi svjetski rat, djeluje pri atletičarskom odjelu Concordije. 1919. je bio suosnivačem i prvim predsjednikom Lakoatletskog saveza Hrvatske i Slavonije te Jugoslavenskog lakoatletskog saveza 1921., čijim je čelnikom bio sve do 1937. godine. Od 1919. sve do 1937. bio je članom Jugoslavenskog olimpijskog odbora.\r\n\r\nKad je bio osnivan Jugoslavenski nogometni savez, na osnivačkoj sjednici bila su zastupljena nogometna središta: Beograd, Karlovac, Niš, Novi Sad, Osijek, Požega, Sisak, Skoplje, Slavonski Brod, Split, Valjevo, Varaždin i Zagreb (7 zagrebačkih klubova). Osnivačku sjednicu vodio je Hinko Würth koji je izabran za prvog predsjednika JNS-a. Prvim tajnikom Saveza postao je dr. Fran Šuklje. Priznata su nogometna pravila koja je preveo dr. Milovan Zoričić. Prof. Franjo Bučar je predviđen za predstavnika u FIFA-i, a izbornikom reprezentacije je postao Veljko Ugrinić. Vodio ju je od 1920. do 1924. godine.[1] Reprezentaciju je vodio na Olimpijskim igrama 1920., a bio je smijenjen uoči Olimpijskih igara 1924., jer su u savezu radije odlučili smijeniti trenera nego promijeniti problematične igrače. Kao trener, tri je puta pobijedio, jednom je igrao neriješeno te šest puta izgubio. Reprezentacija je pod njegovim vođenjem napredovala. Unutar samo dvije godine uspjela je pobijediti momčadi od kojih je prije dvije godine (teško) izgubila (Čehoslovačka 1920. 0:7 i 1921. 1:6, 1922. 4:3, Poljska, Rumunjska).\r\n\r\nPredsjedao je Jugoslavenskim nogometnim savezom od 1923. do 1924., naslijedivši Miroslava Petanjka. Ugrinića je na mjestu predsjednika naslijedio Hinko Würth.\r\n\r\nBio je godine bio jednim od suosnivača Balkanskih atletskih igara. 1934. je bio organizirao 5. Balkanske atletske igre u Zagrebu. Četiri godine je godine predsjedao Interbalkanskim komitetom.\r\n\r\n15. travnja 1936. je u Zagrebu održana utemeljiteljska skupština jugoslavenskog hokejskog (hockey) saveza. Na toj je sjednici za predsjednika saveza izabran Veljko Ugrinić.[2]\r\n\r\nDok je trajao travanjski rat 1941. nekoliko su ga puta uhitili i zatvorili.\r\n\r\nZadnji put se je natjecao u atletici 1947. za Omladinsko studentsko fiskulturno društvo Mladost. Osim toga, poslije rata organizirao je u Hrvatskoj streljačka natjecanja. Obnašao je razne visoke športske dužnosti, pa je potpredsjedao Fiskulturnim savezom Hrvatske, bio odbornikom Komiteta za fiskulturu Hrvatske, predsjedao je Atletskim savezom Hrvatske te je bio član inim športskim i društvenim organizacijama na razini grada Zagreba, Hrvatske te Jugoslavije.', NULL, '2025-03-09 12:06:25', '2025-03-09 13:11:58');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektor_mandati`
--

INSERT INTO `selektor_mandati` (`id`, `selektor_id`, `tim_id`, `pocetak_mandata`, `kraj_mandata`, `v_d_status`, `napomena`, `created_at`, `updated_at`) VALUES
(1, 2, 5, '1924-10-02', NULL, 0, NULL, '2025-03-09 12:06:49', '2025-03-09 12:06:49'),
(2, 1, 5, '1924-02-10', '1924-05-25', 0, NULL, '2025-03-09 12:13:16', '2025-03-09 12:13:16');

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
('7q99eCxSV6cFvM1xOCHjPCmGbxnRKzdTVlImP1sq', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWdQNEJ0ZTE3b2s0Rm5kb1RoeEE2TTBmeE1sNnlZc0o1azZ0dEc3SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9sb2NhbGhvc3QvcmVwcmV6ZW50YWNpamEvcHVibGljL3V0YWttaWNlLzE4L2VkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741532022);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `takmicenja`
--

INSERT INTO `takmicenja` (`id`, `naziv`, `sezona`, `organizator`, `created_at`, `updated_at`) VALUES
(1, 'Prijateljska', NULL, NULL, '2025-03-02 19:46:20', '2025-03-02 19:46:20'),
(2, 'Polufinale baraža za plasman na EURO 2020', NULL, NULL, '2025-03-08 17:17:54', '2025-03-08 17:17:54');

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
(13, 'Argentina', NULL, 'arg.png', 'arg.png', 'Argentina', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 09:56:37'),
(14, 'Australija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(16, 'Azerbejdžan', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(17, 'Belgija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(18, 'Bolivija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(19, 'Bosna i Hercegovina', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(20, 'Brazil', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(22, 'Crna Gora', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(23, 'Čehoslovačka', NULL, 'cze.png', 'cze.png', '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
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
(102, 'Egipat', 'EGY', NULL, NULL, 'Egipat', 0, NULL, NULL, NULL, NULL, NULL),
(103, 'Rumunija', 'ROU', NULL, NULL, 'Rumunija', 0, NULL, NULL, NULL, NULL, NULL),
(104, 'Poljska', 'POL', NULL, NULL, 'Poljska', 0, NULL, NULL, NULL, NULL, NULL),
(105, 'Austrija', 'AUT', 'aut.png', 'aut.png', 'Austrija', 0, NULL, NULL, NULL, NULL, '2025-03-09 14:52:13'),
(106, 'Urugvaj', 'URU', 'uru.png', 'uru.png', 'Urugvaj', 0, NULL, NULL, NULL, NULL, NULL),
(107, 'Italija', 'ITA', NULL, NULL, 'Italija', 0, NULL, NULL, NULL, NULL, NULL),
(108, 'Bugarska', 'BUL', NULL, NULL, 'Bugarska', 0, NULL, NULL, NULL, NULL, NULL),
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
(8, '1920-08-28', NULL, 5, 23, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(10, '1920-09-02', NULL, 5, 102, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
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
