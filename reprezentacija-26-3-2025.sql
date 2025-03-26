-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 26, 2025 at 08:15 PM
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bivsi_klubovi`
--

INSERT INTO `bivsi_klubovi` (`id`, `igrac_id`, `naziv`, `drzava`, `sezona`, `stepen_takmicenja`, `broj_nastupa`, `broj_golova`, `created_at`, `updated_at`) VALUES
(5, 104, 'FK Galenika Zemun', 'SFRJ', '1982-83', '1', 18, 4, '2025-03-08 19:16:14', '2025-03-09 10:29:59'),
(6, 114, 'NK Dinamo Zagreb', 'SFRJ', '1980-81', '1', 17, 1, '2025-03-09 10:12:40', '2025-03-09 10:29:13'),
(7, 545, 'FK Vojvodina', 'SFRJ', '1967-68', '1', 14, 5, '2025-03-09 16:22:37', '2025-03-09 16:22:37'),
(8, 128, 'FK Bačka 1901 Subotica', NULL, '2014-15', '4', 12, 0, '2025-03-10 17:52:14', '2025-03-14 15:24:28'),
(9, 128, 'FK Spartak Subotica', NULL, '2015-16', '1', 0, 0, '2025-03-10 17:54:23', '2025-03-14 15:24:28'),
(10, 128, 'FK Bačka 1901 Subotica (loan)', NULL, '2015-16', '4', 26, 4, '2025-03-10 17:54:56', '2025-03-14 15:24:28'),
(11, 128, 'FK Spartak Subotica', NULL, '2016-17', '1', 31, 1, '2025-03-10 17:55:26', '2025-03-14 15:24:28'),
(12, 128, 'FK Spartak Subotica', NULL, '2017-18', '1', 30, 0, '2025-03-10 17:56:03', '2025-03-14 15:24:28'),
(13, 128, 'FK Spartak Subotica', NULL, '2018-19', '1', 0, 0, '2025-03-10 17:56:31', '2025-03-14 15:24:28'),
(14, 859, 'HŠK Građanski (Zagreb)', NULL, NULL, NULL, NULL, NULL, '2025-03-10 20:00:44', '2025-03-10 20:00:44'),
(15, 860, 'HAŠK (Zagreb)', 'JUG', NULL, NULL, NULL, NULL, '2025-03-12 20:45:19', '2025-03-12 20:45:19'),
(16, 862, 'FK Sutjeska Nikšić', 'YUG', '1999-00', '1', 9, 3, '2025-03-12 20:47:35', '2025-03-12 20:47:35'),
(17, 605, 'HAŠK Građanski (Zagreb)', NULL, '1918-19', '1', 3, 1, '2025-03-13 18:42:25', '2025-03-13 19:26:20'),
(18, 605, 'HAŠK Građanski (Zagreb)', NULL, '1919', '1', 4, 4, '2025-03-13 19:09:22', '2025-03-13 19:22:16'),
(19, 605, 'HAŠK Građanski (Zagreb)', NULL, '1920', '1', 6, 6, '2025-03-13 19:09:22', '2025-03-13 19:22:16'),
(20, 576, 'FK Vardar Skoplje', 'YUG', '1982-83', '1', 4, 3, '2025-03-13 20:25:26', '2025-03-13 20:25:26'),
(21, 588, 'Victoria Sušak', 'YUG', NULL, NULL, NULL, NULL, '2025-03-13 20:27:02', '2025-03-13 20:27:02'),
(22, 597, 'FK Partizan Beograd', 'SRB', '2019-20', '1', 29, 1, '2025-03-13 20:28:56', '2025-03-13 20:28:56'),
(23, 649, 'Parma FC', 'ITA', '2007-08', '1', 7, 0, '2025-03-13 20:31:42', '2025-03-13 20:31:42');

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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(23, 10, 697, 'regularni', NULL, 5, 0, 0, '2025-03-10 19:38:02', '2025-03-10 19:38:02'),
(24, 11, 47, 'protivnicki', 27, 23, 0, 0, '2025-03-11 18:55:06', '2025-03-11 18:55:06'),
(25, 11, 47, 'protivnicki', 47, 23, 0, 0, '2025-03-11 18:55:21', '2025-03-11 18:55:21'),
(26, 11, 46, 'protivnicki', 53, 23, 0, 0, '2025-03-11 18:55:33', '2025-03-11 18:55:33'),
(27, 11, 47, 'protivnicki', 71, 23, 0, 0, '2025-03-11 18:55:47', '2025-03-11 18:55:47'),
(28, 11, 46, 'protivnicki', 78, 23, 0, 0, '2025-03-11 18:56:00', '2025-03-11 18:56:00'),
(29, 11, 47, 'protivnicki', 86, 23, 0, 0, '2025-03-11 18:56:12', '2025-03-11 18:56:12'),
(30, 11, 891, 'regularni', 72, 5, 0, 0, '2025-03-11 18:56:24', '2025-03-11 18:56:24'),
(37, 12, 790, 'regularni', 35, 5, 1, 0, '2025-03-26 20:13:13', '2025-03-26 20:13:13');

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
  `visina` int DEFAULT NULL COMMENT 'Visina igrača u cm',
  `fotografija_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biografija` text COLLATE utf8mb4_unicode_ci,
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

INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `visina`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(106, 'Cimermančić', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(2, 'Abraham', 'Jenő – Száraz', 1, 'Sredina', NULL, NULL, '<p>Jenő Abraham&nbsp; &ndash; Sz&aacute;raz je biv&scaron;i fudbaler Vojvodine, Građanskog i reprezentativac Jugoslavije.</p>\r\n<p>Pravo ime mu je Jene Abraham (Jen&ouml; &Aacute;brah&aacute;m), mada je nastupao pod različitim varijacijama svoga imena u drugim klubovima i tako je zabeleženo u klupskim i reprezentativnim hronikama, u svakom slučaju se radi o jednom te istom igraču. Nadimak Saraz, pod kojim je takođe nastupao na mađarskom jeziku znači suvi, koji je Jene verovatno dobio zbog svog izgleda.</p>\r\n<p>U Jugoslovenske fudbalske vode Abraham je do&scaron;ao iz Segedina, gde je započeo svoju fudbalsku karijeru. Od 1922. do 1925. igrač novosadske &ldquo;Vojvodine&rdquo;, a otada do 1927. zagrebačkog &ldquo;Građanskog&rdquo;. Posle uspe&scaron;ne jugoslovenske fudbalske karijere 1928. se ponovo vratio u rodni Segedin.</p>\r\n<p>Za reprezentaciju kraljevine Jugoslavije, Abraham je odigrao dve utakmice i postigao je isto toliko golova</p>\r\n<p>Prvu utakmicu za reprezentaciju Abraham je odigrao 28. jula 1922. godine u Zagrebu, protiv Čehoslovačke. Na toj utakmici Abraham je postigao dva gola. Krajnji rezultat je bio 4:3 za Jugoslaviju. To je ujedno bila i prva pobeda uop&scaron;te u istoriji Jugoslovenske fudbalske reprezentacije.</p>', NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-23 18:15:32'),
(3, 'Aćimović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(4, 'Agić', 'Đuro', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(5, 'Aksentijević', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(6, 'Aleksić', 'Branimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(7, 'Aleksić', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(8, 'Aleksić', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(9, 'Alivodić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(10, 'Anđelković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(11, 'Anđelković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(12, 'Anđelković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(13, 'Anković', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(14, 'Antić', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(15, 'Antić', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(16, 'Antić', 'Sava', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(17, 'Antolković', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(18, 'Antonijević', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(19, 'Arsenijević', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(20, 'Arslanagić', 'Zijad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(21, 'Arslanović', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(22, 'Asanović', 'Aljoša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(23, 'Atanacković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(24, 'Avramov', 'Vlada', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(25, 'Avramović', 'Radojko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:51:46', '2025-03-08 18:51:46'),
(26, 'Babić', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(27, 'Babić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(28, 'Babović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(29, 'Babunski', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(30, 'Bahtiić', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(31, 'Bajević', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(32, 'Bajić', 'Mane', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(33, 'Bajić', 'Milenko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(34, 'Bakota', 'Bozo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(35, 'Bajić', 'Mirsad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(36, 'Banović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(37, 'Barbarić', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(38, 'Baša', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(39, 'Basta', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(40, 'Batričević', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(41, 'Batrović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(42, 'Baždarević', 'Mehmed', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(43, 'Beara', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(44, 'Bećir', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(45, 'Bećirić', 'Radoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(46, 'Bego', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(47, 'Bek', 'Ivan (Beck Yvan)', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(48, 'Beleslin', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(49, 'Beleslin', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(50, 'Belin', 'Bruno', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(51, 'Belin', 'Rodolfo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(52, 'Belošević', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(53, 'Beljić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(54, 'Bens', 'Steven', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(55, 'Benčić', 'Ljubo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(56, 'Benko', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(57, 'Benković', 'Milivoj', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(58, 'Binić', 'Dragiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(59, 'Biogradlić', 'Ibrahim', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(60, 'Bišćan', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(61, 'Bivec', 'August', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(62, 'Bjegović', 'Nikoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(63, 'Bjekovic', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(64, 'Blašković', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(65, 'Boban', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(66, 'Bobek', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(67, 'Bogavac', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(68, 'Bogdan', 'Srećko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(69, 'Bogdanović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(70, 'Bogdanović', 'Rade', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(71, 'Bogićević', 'Vladislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(72, 'Bogosavac', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(73, 'Bogunović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(74, 'Bojović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(75, 'Bolić', 'Darzen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(76, 'Bojat', 'Mario', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(77, 'Bonačić', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(78, 'Bonačić', 'Miljenko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(79, 'Borota', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(80, 'Borovcić', 'Kurti Mihovil', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(81, 'Boskov', 'Vujadin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(82, 'Bošković', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(83, 'Bošković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(84, 'Bošnjak', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(85, 'Božić', 'Radivoj', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(86, 'Božović', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(87, 'Božović', 'Vojin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(88, 'Brašanac', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(89, 'Bratić', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(90, 'Braulić', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(91, 'Braun', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(92, 'Brkić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(93, 'Brnčić', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(94, 'Brnović', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(95, 'Brnović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(96, 'Brnović', 'Dragoljub', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(97, 'Brnović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(105, 'Cicović', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(99, 'Brozović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(100, 'Brzić', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(101, 'Bukal', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(102, 'Buljan', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(103, 'Bunjevčević', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 18:53:44'),
(104, 'Bursać', 'Miloš', 1, 'Napad', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-08 18:53:44', '2025-03-08 19:17:13'),
(107, 'Cindrić', 'Slavin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(108, 'Colnago', 'Ferante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(109, 'Cokić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(110, 'Crnković', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(111, 'Cukrov', 'Nikica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(112, 'Cvek', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(113, 'Cvetković', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(114, 'Cvetković', 'Zvjezdan', 1, 'Odbrana', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-03-09 10:12:40'),
(115, 'Čabrić', 'Ratomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(116, 'Čajkovski', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(117, 'Čajkovski', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(118, 'Čakar', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(119, 'Čapljić', 'Vlado', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(120, 'Čebinac', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(121, 'Čebinac', 'Zvezdan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(122, 'Čerček', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(123, 'Čolić', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(124, 'Čonč', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(125, 'Čop', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(126, 'Čop', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(127, 'Čulić', 'Bartul', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:42:34', '2025-03-09 10:42:34'),
(128, 'Ćalasan', 'Nemanja', 1, 'Odbrana', NULL, 'igraci/calasan_nemanja.png', NULL, '1996-03-17', 'Subotica', 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-14 15:24:28'),
(129, 'Ćirić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(130, 'Ćirković', 'Milivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(131, 'Ćirković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(132, 'Ćurčić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(133, 'Ćurić', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(134, 'Ćurković', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 10:59:07', '2025-03-09 10:59:07'),
(135, 'Damjanović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(136, 'Damjanović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(137, 'Dasović', 'Eugen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(138, 'Dautbegović', 'Fahrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(139, 'Davidov', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(140, 'Davidović', 'Sreten', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(141, 'Demić', 'Sergije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(142, 'Desnica', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(143, 'Desković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(144, 'Despotović', 'Ranko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(145, 'Deverić', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(146, 'Dimitrijević', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(147, 'Dišljenković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(148, 'Divić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(149, 'Dmitrović', 'Boban', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(150, 'Dmitrović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(151, 'Dobrijević', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(152, 'Dojčinovski', 'Kiril', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(153, 'Dračić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(154, 'Dragićević', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(155, 'Dragićević', 'Prvoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(156, 'Dragutinović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(157, 'Drenovac', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(158, 'Drobnjak', 'Anto', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(159, 'Drobnjak', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(160, 'Drulić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(161, 'Drulović', 'Ljubinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(162, 'Dubac', 'Ernest', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(163, 'Dubajić', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(164, 'Dubravčić', 'Artur', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(165, 'Dudić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(166, 'Dudić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(167, 'Dujković', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(168, 'Dujmović', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(169, 'Duljaj', 'Igor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(170, 'Dunderski', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(171, 'Durković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(172, 'Dvornić', 'Dionizije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(173, 'Džajić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(174, 'Džanić', 'Svetozar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(175, 'Džeko', 'Jasmin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(176, 'Džodić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(177, 'Džoni', 'Vilson', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(178, 'Đajić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(179, 'Delmas', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(180, 'Denić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(181, 'Đokić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(182, 'Đokić', 'Momčilo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(183, 'Đorđević', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(184, 'Đorđević', 'Borivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(185, 'Đorđević', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(186, 'Đorđević', 'Kristijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(187, 'Đorđević', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(188, 'Đorđević', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(189, 'Đorđević', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(190, 'Đorić', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(191, 'Đorović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(192, 'Đukić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(193, 'Đukić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(194, 'Đurđić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(195, 'Đuričić', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(196, 'Đuričić', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(197, 'Đurić', 'Igor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(198, 'Đurić', 'Vladata', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(199, 'Đurovski', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(200, 'Đurovski', 'Milko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(201, 'Elsner', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(202, 'Ergić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:25:46', '2025-03-09 15:25:46'),
(203, 'Fazlagić', 'Mirsad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(204, 'Fejsa', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(205, 'Ferderber', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(206, 'Ferhatović', 'Asim', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(207, 'Ferhatović', 'Nijaz', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(208, 'Filipović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(209, 'Firm', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(210, 'Fridrih', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(211, 'Gaćinović', 'Mijat', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(212, 'Gajer', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(213, 'Galić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(214, 'Gavrančić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(215, 'Georgijevski', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(216, 'Giler', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(217, 'Glaser', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(218, 'Glišović', 'Svetislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(219, 'Gobeljić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(220, 'Gojković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(221, 'Golac', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(222, 'Golob', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(223, 'Govedarica', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(224, 'Gračan', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(225, 'Gračanin', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(226, 'Granec', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(227, 'Grdenić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(228, 'Grozdić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(229, 'Grujić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(230, 'Grujić', 'Spira', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(231, 'Gudelj', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(232, 'Gudelj', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(233, 'Gugleta', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(234, 'Gvozdenović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(235, 'Hadžiabdić', 'Džemal', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(236, 'Hadžiabdić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(237, 'Hadžibegić', 'Faruk', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(238, 'Hadžić', 'Ismet', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(239, 'Halilhodžić', 'Vahid', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(240, 'Halilović', 'Sulejman', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(241, 'Hasanagić', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(242, 'Hatunić', 'Jusuf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(243, 'Herceg', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(244, 'Hügl', 'Bernard', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(245, 'Hitrec', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(246, 'Hitrec', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(247, 'Hlevnjak', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(248, 'Hočevar', 'Edvard', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(249, 'Holcer', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(250, 'Horvat', 'Drago', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(251, 'Horvat', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(252, 'Horvat', 'Janoš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(253, 'Hošić', 'Idriz', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(254, 'Hrnjičеk', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(255, 'Hrstić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(256, 'Hukić', 'Mustafa', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(257, 'Ignjovski', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(258, 'Ilić', 'Brana', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(259, 'Ilić', 'Radiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(260, 'Ilić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(261, 'Ilić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(262, 'Iliev', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(263, 'Injac', 'Dimitrije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(264, 'Isailović', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(265, 'Ivanović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(266, 'Ivanović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(267, 'Ivezić', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(268, 'Ivić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(269, 'Ivić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(270, 'Ivković', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(271, 'Ivković', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(272, 'Ivoš', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:30:38', '2025-03-09 15:30:38'),
(273, 'Jakovetić', 'Lajoš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(274, 'Jakovljević', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(275, 'Jakšić', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(276, 'Janevski', 'Čedomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(277, 'Janjanin', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(278, 'Janković', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(279, 'Janković', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(280, 'Janković', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(281, 'Janković', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(282, 'Janković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(283, 'Jantoljak', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(284, 'Jarni', 'Robert', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(285, 'Jašarević', 'Ešref', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(286, 'Jazbec', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(287, 'Jazbinšek', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(288, 'Jelikić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(289, 'Jerković', 'Dražan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(290, 'Jerković', 'Jurica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(291, 'Jerolimov', 'Ive', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(292, 'Ješić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(293, 'Jestrović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(294, 'Jevtović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(295, 'Jevrić', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(296, 'Jevtić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(297, 'Jevtić', 'Živorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(298, 'Jezerkić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(299, 'Jocić', 'Stanoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(300, 'Jojić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(301, 'Jokanović', 'Slaviša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(302, 'Jokić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(303, 'Jorgačević', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(304, 'Jovanić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(305, 'Jovanović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(306, 'Jovanović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(307, 'Jovanović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(308, 'Jovanović', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(309, 'Jovanović', 'Mija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(310, 'Jovanović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(311, 'Jovanović', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(312, 'Jovanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(313, 'Jovanović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(314, 'Jović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(315, 'Jović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(316, 'Jovičić', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(317, 'Jovičić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(318, 'Jovin', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(319, 'Jozić', 'Davor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(320, 'Jugović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(321, 'Jurčić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(322, 'Jurić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(323, 'Jurić', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(324, 'Jurić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(325, 'Jusufi', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(326, 'Kacian', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(327, 'Kačar', 'Gojko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(328, 'Kahriman', 'Damir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(329, 'Kajtaz', 'Sead', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(330, 'Kaloperović', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(331, 'Kaluđerović', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(332, 'Kanatlarovski', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(333, 'Kapetanović', 'Mirza', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(334, 'Karasi', 'Stanislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(335, 'Kasalo', 'Vlado', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(336, 'Katai', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(337, 'Katalinić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(338, 'Katalinski', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(339, 'Katanec', 'Srećko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(340, 'Katić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(341, 'Kečkeš', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(342, 'Kesić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(343, 'Kežman', 'Mateja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(344, 'Kinert', 'Hugo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(345, 'Klaić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(346, 'Klinčarski', 'Nikica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(347, 'Klisura', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(348, 'Knez', 'Tomislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(349, 'Knežević', 'Bruno', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(350, 'Knežević', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(351, 'Kobešćak', 'Zdenko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(352, 'Kocić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(353, 'Kodrmja', 'Slavoljub', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(354, 'Kodro', 'Meho', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(355, 'Kojić', 'Andreja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(356, 'Kokeza', 'Ljubimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(357, 'Kolaković', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(358, 'Kolaković', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(359, 'Kolaković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(360, 'Kolarov', 'Aleksandar', 1, 'Odbrana', 187, 'igraci/kolarov_aleksandar.png', NULL, '1985-11-10', 'Zemun', 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-15 17:38:31'),
(361, 'Komljenović', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(362, 'Koroman', 'Ognjen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(363, 'Koščak', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(364, 'Kosanović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(365, 'Kostić', 'Borivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(366, 'Kostić', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(367, 'Kovačević', 'Abid', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(368, 'Kovačević', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(369, 'Kovačević', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(370, 'Kovačević', 'Oliver', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(371, 'Kovačević', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(372, 'Kovačević', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(373, 'Kovačić', 'Frane', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(374, 'Kozlina', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(375, 'Kragić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(376, 'Kralj', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(377, 'Kralj', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(378, 'Kranjčar', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(379, 'Krasić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(380, 'Kristić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(381, 'Krivokapić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(382, 'Krivokapić', 'Radovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(383, 'Krivokuća', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(384, 'Krivokuća', 'Srboljub', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(385, 'Kriz', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(386, 'Krmpotić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(387, 'Krnić', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(388, 'Krstajić', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56');
INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `visina`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(389, 'Krstić', 'Dobrosav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(390, 'Krstičević', 'Mišo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(391, 'Krstičić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(392, 'Kuci', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(393, 'Kujundžić', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(394, 'Kunst', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(395, 'Kustudić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(396, 'Kuzmanović', 'Zdravko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:35:56', '2025-03-09 15:35:56'),
(397, 'Milović', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(398, 'Milunović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(399, 'Milutin', 'Šime', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(400, 'Milutinović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(401, 'Mirić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(402, 'Mirković', 'Miško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(403, 'Mirković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(404, 'Miročević', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(405, 'Mitić', 'Rajko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(406, 'Mitrović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(407, 'Mitrović', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(408, 'Mitrović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(409, 'Mitrović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(410, 'Mladenović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(411, 'Mladenović', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(412, 'Mladenović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(413, 'Mlinarić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(414, 'Mojsov', 'Sokrat', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(415, 'Monsider', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(416, 'Mrđa', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(417, 'Mrkela', 'Mitar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(418, 'Mrkić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(419, 'Mrkušić', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(420, 'Mujić', 'Muhamed', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(421, 'Mujkić', 'Fikret', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(422, 'Musemić', 'Husref', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(423, 'Musemić', 'Vahidin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(424, 'Mušović', 'Džemaludin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(425, 'Mustedanagić', 'Dženal', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(426, 'Mutavdžić', 'Miljan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(427, 'Mutibarić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(428, 'Mužinić', 'Dražen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(429, 'Matošić', 'Jozo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(430, 'Matuš', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(431, 'Medarić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(432, 'Melić', 'Vojislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(433, 'Mešković', 'Rizah', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(434, 'Mihajlović', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(435, 'Mihajlović', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(436, 'Mihajlović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(437, 'Mihajlović', 'Prvoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(438, 'Mihajlović', 'Radmilo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(439, 'Mihajlović', 'Siniša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(440, 'Mihalčić', 'Maksimilijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(441, 'Mijailović', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(442, 'Mijatović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(443, 'Mikačić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(444, 'Milanović', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(445, 'Milanić', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(446, 'Milenković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(447, 'Milenković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(448, 'Miletić G.', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(449, 'Miletić R.', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(450, 'Milevoj', 'Anđelo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(451, 'Milijaš', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(452, 'Milinković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(453, 'Milinković-Savić', 'Sergej', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(454, 'Milivojević', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(455, 'Milić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(456, 'Miljanović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(457, 'Miljković', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(458, 'Miljuš', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(459, 'Milojević', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(460, 'Milojević', 'Sretko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(461, 'Milošević', 'Ćirjan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(462, 'Milošević', 'Savo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(463, 'Milošević', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(464, 'Milovanov', 'Sima', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(465, 'Milovanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(466, 'Maksimović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(467, 'Maksimović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(468, 'Malbaša', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(469, 'Malenčić', 'Rodoljub', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(470, 'Mance', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(471, 'Manić', 'Radivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(472, 'Manojlović', 'Filip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(473, 'Manola', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(474, 'Mantula', 'Lav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(475, 'Maraš', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(476, 'Maravić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(477, 'Marcikić', 'Remija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(478, 'Marić', 'Enver', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(479, 'Marić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(480, 'Marić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(481, 'Marinković', 'Sava', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(482, 'Marinov', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(483, 'Marjanović', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(484, 'Marjanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(485, 'Marjanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(486, 'Markovski', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(487, 'Marković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(488, 'Marković', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(489, 'Marković', 'Marjan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(490, 'Marković', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(491, 'Marković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(492, 'Marković', 'Vlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(493, 'Marović', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(494, 'Martinović', 'Egidio', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(495, 'Martinović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(496, 'Marušić', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(497, 'Maslovar', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(498, 'Matekalo', 'Florijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(499, 'Matić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(500, 'Matijević', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(501, 'Matošić', 'Frane', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(502, 'Ljajić', 'Adem', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(503, 'Ljubenović', 'Zarije-Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(504, 'Ljuboja', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(505, 'Ljukovčan', 'Živan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(506, 'Ladić', 'Dražen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(507, 'Lalatović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(508, 'Lamza', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(509, 'Lazarević', 'Vojin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(510, 'Lazetić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(511, 'Lazović', 'Danko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(512, 'Lazović', 'Darko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(513, 'Lechner', 'Gustav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(514, 'Leinert', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(515, 'Lekić', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(516, 'Leković', 'Dragoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(517, 'Lemešić', 'Leo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(518, 'Lemić', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(519, 'Lešnik', 'August', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(520, 'Lipošinović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(521, 'Lojančić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(522, 'Lojen', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(523, 'Lomić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(524, 'Lončarević', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(525, 'Lović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(526, 'Löw', 'Pavao', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(527, 'Luburić', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(528, 'Lučić', 'Žarko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(529, 'Lukač', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(530, 'Lukarić', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(531, 'Lukić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(532, 'Lukić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(533, 'Lukić', 'Vladan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(534, 'Luković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(535, 'Luštica', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 15:43:15', '2025-03-09 15:43:15'),
(536, 'Načević', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(537, 'Nađ', 'Albert', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(538, 'Nadoveza', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(539, 'Najdanović', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(540, 'Najdoski', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(541, 'Nastasić', 'Matija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(542, 'Naumović', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(543, 'Nešticki', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(544, 'Neziri', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(545, 'Nikezić', 'Petar', 1, 'Napad', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:22:37'),
(546, 'Nikolić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(547, 'Nikolić', 'Jovica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(548, 'Nikolić', 'Milorad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(549, 'Nikolić', 'Slavoljub', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(550, 'Nikolić', 'Žarko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(551, 'Ninkov', 'Pavle', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(552, 'Ninković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(553, 'Novak', 'Džoni', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(554, 'Novak', 'Marijan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(555, 'Novoselac', 'Martin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(556, 'Njeguš', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(557, 'Oblak', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(558, 'Obradović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(559, 'Obradović', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(560, 'Obradović', 'Milovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(561, 'Ocokoljić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(562, 'Ognjanov', 'Tihomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(563, 'Ognjanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(564, 'Ognjanović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(565, 'Ognjanović', 'Radivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(566, 'Ognjanović', 'Perica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(567, 'Omerović', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(568, 'Osim', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(569, 'Ostojić', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(570, 'Ožegović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:21:04', '2025-03-09 16:21:04'),
(571, 'Pajević', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(572, 'Pajević', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(573, 'Palfi', 'Bela', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(574, 'Paločević', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(575, 'Panadić', 'Andrej', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(576, 'Pančev', 'Darko', 1, 'Napad', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-13 20:25:26'),
(577, 'Pandurović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(578, 'Panić', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(579, 'Pantelić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(580, 'Pantelić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(581, 'Pantelić', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(582, 'Pantelić', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(583, 'Pantić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(584, 'Pantić', 'Milinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(585, 'Papec', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(586, 'Pašić', 'Ilijas', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(587, 'Pašić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(588, 'Paškvan', 'Daniel', 1, 'Odbrana', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-13 20:27:02'),
(589, 'Paunović', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(590, 'Paunović', 'Veljko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(591, 'Pavelić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(592, 'Pavkov', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(593, 'Pavlić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(594, 'Pavlica', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(595, 'Pavlović', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(596, 'Pavlović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(597, 'Pavlović', 'Strahinja', 1, 'Odbrana', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-13 20:28:56'),
(598, 'Pažur', 'Alfons', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(599, 'Pažur', 'Hugo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(600, 'Pejčinović', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(601, 'Pejić', 'Aleksa', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(602, 'Percel', 'Adolf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(603, 'Perlić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(604, 'Perović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(605, 'Perška', 'Emanuel', 1, 'Napad', NULL, 'igraci/perska_emanuel.png', 'Rođen 20. juna 1896. u Staroj Pazovi, poginuo 8. maja 1945. u Zagrebu.\r\n\r\nBio je prvi jugoslovenski reprezentativac koji je “nanizao” 10 utakmica za nacionalni tim u prvoj deceniji njegove aktivnosti i, nesumnjivo, spadao među naše najbolje igrače.\r\n\r\nMeđutim, njegova igračka i životna biografija iz raznih razloga verovatno nikad neće biti upotpunjena. Zna se da je poreklom bio Slovak, kasnije novinar i istoričar sporta, ali su mnogi bitni podaci ostali nepotvrđeni, iako je u pitanju jedna od prvih fudbalskih zvezda i profesionalaca na prostorima bivše Jugoslavije.\r\n\r\nPočeo je igrati u HAŠK-u. Za vreme Prvog svetskog rata kao vojnik je poslat u Austrougarsku gde je u slobodno vreme igrao za Györ. Posle prvog svetskog rata, kako se priča, nije smeo da se vrati u Jugoslaviju, jer je tokom rata bio – vojni dezerter. Zbog toga je pristupnicu za 1. HŠK Građanski potpisao 1919. godine – u Beču. Papire je doneo ondašnji član uprave “purgera” Gabi Feldbauer, a zahvaljujući velikom angažovanju onda uticajnih “modrih” – bio je pomilovan i vratio se u Zagreb.\r\n\r\nIgrao je na prvoj utakmici ondašnje Kraljevine Srba, Hrvata i Slovenaca, na olimpijskom turniru 1920. u Anversu, posle koga je, uz pomoć i znanje jezika Jovana – Jove Ružića iz beogradske SK Jugoslavije, otišao za Francusku i uz mesečnu platu od onda velikih 3.000 franaka igrao u dresu pariskog FC Generaux. U Zagreb ga je vratio onda uticajni bečki menadžer David Vajs.\r\n\r\nU najvećem delu karijere, tokom koje je ispoljavao vrlo visoku igračku klasu, nosio je dres 1. HŠK Građanski – Zagreb, sa kojim je osvajao tri nacionalna prvenstva (1923, 1926. i 1928).\r\n\r\nZa reprezentaciju Jugoslavije odigrao je 14 utakmica (1920-1927) i postigao dva gola. Debitovao je 28. avgusta 1920. protiv Čehoslovačke (0:7) na olimpijskom turniru u Anversu, a poslednji put je obukao nacionalni dres 31. jula 1928. opet protiv Čehoslovačke (1:1) u Beogradu, kada je postigao jedini gol za “Bele orlove”.\r\n\r\nPrema nekim informacijama, tokom drugog svetskog rata bio je policijski službenik i, kažu, vatreni pristalica ustaškog pokreta, što ga je, u maju 1945. – koštalo glave. Po nekim kazivanjima, tokom borbi za oslobođenje Zagreba, poginuo je u naizmeničnoj vatri, pucajući sa balkona svog doma na Zvijezdi.', '1896-06-20', 'Stara Pazova', 0, '1945-05-08', 'Zagreb', '2025-03-09 16:25:53', '2025-03-13 19:26:20'),
(606, 'Perušić', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(607, 'Peruzović', 'Luka', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(608, 'Pešić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(609, 'Pešić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(610, 'Petaković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(611, 'Petković', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(612, 'Petković (Ilija)', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(613, 'Petković', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(614, 'Petković', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(615, 'Petković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(616, 'Petrak', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(617, 'Petrić', 'Gordan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(618, 'Petronijević', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(619, 'Petrović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(620, 'Petrović', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(621, 'Petrović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(622, 'Petrović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(623, 'Petrović', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(624, 'Petrović', 'Miomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(625, 'Petrović', 'Ognjen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(626, 'Petrović', 'Radosav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(627, 'Petrović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(628, 'Petrović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(629, 'Petrović', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(630, 'Pirić', 'Danial', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(631, 'Pirmajer', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(632, 'Pjanović', 'Mihajlo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(633, 'Plavšić', 'Srđan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(634, 'Plazzeriano', 'Eugen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(635, 'Pleše', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(636, 'Podhradski', 'Jan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(637, 'Poduje', 'Šime', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(638, 'Poduje', 'Veljko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(639, 'Pogačnik', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(640, 'Poleksić', 'Vukašin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(641, 'Popivoda', 'Danilo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(642, 'Popović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(643, 'Popović', 'Stojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(644, 'Popović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(645, 'Porobić', 'Branimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(646, 'Požega', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(647, 'Praunsperger', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(648, 'Premerl', 'Danijel', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(649, 'Priјović', 'Aleksandar', 1, 'Napad', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-13 20:31:42'),
(650, 'Primorac', 'Boro', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(651, 'Prljača', 'Fahrudin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(652, 'Prodanović', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(653, 'Prosinečki', 'Robert', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(654, 'Pudar', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:25:53', '2025-03-09 16:25:53'),
(655, 'Radača', 'Vladan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(656, 'Radaković', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(657, 'Radaković', 'Radovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(658, 'Radanović', 'Ljubomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(659, 'Radenković', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(660, 'Radić', 'Vinko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(661, 'Radenović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(662, 'Radoja', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(663, 'Radonjić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(664, 'Radovanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(665, 'Radovanović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(666, 'Radović', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(667, 'Radović', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(668, 'Radović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(669, 'Radović', 'Vasilije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(670, 'Rajkov', 'Zdravko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(671, 'Rajković', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(672, 'Rajković', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(673, 'Rajković', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(674, 'Rajković', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(675, 'Rajković', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(676, 'Rajlić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(677, 'Ralić', 'Boško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(678, 'Ramljak', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(679, 'Ranković', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(680, 'Ranojević', 'Miodrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(681, 'Rašović', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(682, 'Rašović', 'Vuk', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(683, 'Ravnić', 'Mauro', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(684, 'Repčić', 'Srebrenко', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(685, 'Ristović', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(686, 'Rnić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(687, 'Rockov', 'Emil', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(688, 'Rodić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(689, 'Rodin', 'Janko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(690, 'Roganović', 'Novak', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(691, 'Rora', 'Krasnodar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(692, 'Rozić', 'Vedran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(693, 'Rudinski', 'Antun', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(694, 'Rukavina', 'Antonio', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(695, 'Rupec', 'Rudolf', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(696, 'Rupnik', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(697, 'Ružić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(698, 'Ružić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(699, 'Sakić', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(700, 'Samardžić', 'Radoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(701, 'Samardžić', 'Spasoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(702, 'Sandić', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(703, 'Santrač', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(704, 'Sarić', 'Mladen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(705, 'Saveljić', 'Niša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(706, 'Savevski', 'Toni', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(707, 'Savić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(708, 'Savić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(709, 'Savićević', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(710, 'Scholz', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(711, 'Sedlar', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(712, 'Sekereš', 'Stevan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(713, 'Sekulić', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(714, 'Senčar', 'Božidar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(715, 'Simeunović', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(716, 'Simić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(717, 'Simonović', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(718, 'Simonović', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(719, 'Simonović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(720, 'Simonovski', 'Kiril', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(721, 'Simović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(722, 'Šipoš', 'Vilmoš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(723, 'Skoblar', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(724, 'Slišković', 'Blaž', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(725, 'Slivak', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(726, 'Smajić', 'Admir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(727, 'Smajlović', 'Drago', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(728, 'Smiljanić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(729, 'Sombolac', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(730, 'Sotirović', 'Kuzman', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(731, 'Spajić', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(732, 'Spajić', 'Uroš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(733, 'Spasić', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(734, 'Spasić', 'Predrag', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(735, 'Spasojević', 'Teofilo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(736, 'Spasovski', 'Metodije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(737, 'Sprečo', 'Edin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(738, 'Stanić', 'Mario', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(739, 'Stanković', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(740, 'Stanković', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(741, 'Stanković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(742, 'Stanković', 'Vojislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(743, 'Stanojković', 'Vujadin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(744, 'Starovalah', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(745, 'Stefanović', 'Dejan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(746, 'Stefanović', 'Ljubiša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(747, 'Stepanov', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(748, 'Stepanović', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(749, 'Stevanović', 'Alen', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(750, 'Stevanović', 'Borislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(751, 'Stevanović', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(752, 'Stevanović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(753, 'Stevanović', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(754, 'Stevanović', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(755, 'Stević', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(756, 'Stevović', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(757, 'Stincic', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(758, 'Stincic', 'Željko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(759, 'Šupić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(760, 'Stojanović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(761, 'Stojanović', 'Mirko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(762, 'Stojanović', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34');
INSERT INTO `igraci` (`id`, `prezime`, `ime`, `tim_id`, `pozicija`, `visina`, `fotografija_path`, `biografija`, `datum_rodjenja`, `mesto_rodjenja`, `aktivan`, `datum_smrti`, `mesto_smrti`, `created_at`, `updated_at`) VALUES
(763, 'Stojić', 'Ranko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(764, 'Stojiljković', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(765, 'Stojiljković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(766, 'Stojković', 'Aranđel', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(767, 'Stojković', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(768, 'Stojković', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(769, 'Stojković', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(770, 'Stošić', 'Vlada', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(771, 'Subotić', 'Neven', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(772, 'Sulejmani', 'Miralem', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(773, 'Sušić', 'Safet', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(774, 'Sušić', 'Sead', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(775, 'Svetličić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(776, 'Svilar', 'Ratko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(777, 'Svinjarević', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 16:54:34', '2025-03-09 16:54:34'),
(778, 'Šabanadžović', 'Refik', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(779, 'Šalov', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(780, 'Šantek', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(781, 'Šarac', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(782, 'Šaranov', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(783, 'Šaula', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(784, 'Ščepović', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(785, 'Ščepović', 'Stefan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(786, 'Šećerbegović', 'Dževad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(787, 'Šefer', 'Bela', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(788, 'Šekularac', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(789, 'Šestić', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(790, 'Šifer', 'Jaroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(791, 'Šifliš', 'Geza', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(792, 'Šijaković', 'Vasilije', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(793, 'Škorić', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(794, 'Škoro', 'Haris', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(795, 'Škrbić', 'Slobodan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(796, 'Škuletić', 'Petar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(797, 'Šljivo', 'Edhem', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(798, 'Šojat', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(799, 'Šoškić', 'Milutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(800, 'Šoštarić', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(801, 'Šterk', 'Stjepan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(802, 'Šuker', 'Davor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(803, 'Šurdonja', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(804, 'Šurjak', 'Ivica', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(805, 'Švraka', 'Suad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:00:15', '2025-03-09 17:00:15'),
(806, 'Tadić', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(807, 'Takač', 'Silvester', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(808, 'Tasić', 'Lazar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(809, 'Tavčar', 'Stanko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(810, 'Tešan', 'Anđelko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(811, 'Tirnanić', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(812, 'Tomašević', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(813, 'Tomašević', 'Kosta', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(814, 'Tomić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(815, 'Tomić', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(816, 'Tomić', 'Novak', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(817, 'Tomić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(818, 'Tomović', 'Nenad', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(819, 'Toplak', 'Ivan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(820, 'Tošić', 'Dragomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(821, 'Tošić', 'Duško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(822, 'Tošić', 'Rade', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(823, 'Tošić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(824, 'Trajković', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(825, 'Trajković', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(826, 'Trifunović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(827, 'Trišović', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(828, 'Trivić', 'Dobrivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(829, 'Trivunović', 'Veseljko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(830, 'Trobok', 'Goran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(831, 'Tuce', 'Semir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(832, 'Tutorić', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:39:30', '2025-03-09 17:39:30'),
(833, 'Urbanke', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(834, 'Urošević', 'Slobodan', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL),
(835, 'Vabec', 'Dragutin', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(836, 'Valjarević', 'Svetislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(837, 'Valok', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(838, 'Valok', 'Marko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(839, 'Vardić', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(840, 'Vasković', 'Boris', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(841, 'Vasović', 'Velibor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(842, 'Velfl', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(843, 'Veljković', 'Miloš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(844, 'Velker', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(845, 'Vermezović', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(846, 'Veselinović', 'Todor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(847, 'Vidaković', 'Risto', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(848, 'Vidić', 'Nemanja', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(849, 'Vidinić', 'Blagoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(850, 'Vidošević', 'Joško', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(851, 'Vidović', 'Želimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(852, 'Vilotić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(853, 'Vinek', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(854, 'Virić', 'Dragoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(855, 'Vitakić', 'Milivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(856, 'Vladić', 'Franjo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(857, 'Volkov', 'Vladimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(858, 'Vokri', 'Fadil', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(859, 'Vragović', 'Dragutin', 1, 'Sredina', NULL, 'igraci/vragovic_dragutin.jpg', NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-14 15:25:31'),
(860, 'Vrbančić', 'Stjepan', 1, 'Odbrana', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-12 20:45:19'),
(861, 'Vrđuka', 'Dragutin', 1, 'Golman', NULL, 'igraci/vrdjuka_dragutin.png', '<p>Prvi jugoslovenski golman &ndash; reprezentativac, dugo godina uspe&scaron;an čuvar mreže 1. H&Scaron;K Građanski, među na&scaron;im najboljim golmanima između dva svetska rata.</p>\r\n<p>U vreme kad se kod nas jo&scaron; nije igralo prvenstvo (prvo je održano 1923), proslavio se sjajnim odbranama 1920. u Pragu i Beču, a posebno prilikom turneje Građanskog 1922. i 1923. po &Scaron;paniji. U dresu Građanskog osvojio je 1923. i prvi trofej nacionalnog prvaka.</p>\r\n<p>Uz 15 utakmica za gradsku selekciju Zagreba, boje reprezentacije Jugoslavije branio je na sedam utakmica (1920-1924), debitujući zajedno sa reprezentacijom 28. avgusta 1920. protiv Čehoslovačke (0:7) na olimpijskom turniru u Anversu.</p>\r\n<p>I na poslednjoj utakmici za nacionalni tim primio je sedam golova: 26. maja 1924. protiv Urugvaja (0:7) na olimpijskom turniru u Parizu. Na sedam utakmica primio je 35 golova (u proseku po pet), ali je bio među na&scaron;im najboljim igračima i onda kad je primao &ldquo;sedmice&rdquo;.</p>\r\n<p>Po zanimanju je bio tapetar, a umro je u 53. godini u Zagrebu od tuberkuloze.</p>', '1895-04-03', 'Zagreb', 0, '1948-01-23', 'Zagreb', '2025-03-09 17:41:56', '2025-03-16 20:02:21'),
(862, 'Vučinić', 'Mirko', 1, 'Napad', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-12 20:47:35'),
(863, 'Vujačić', 'Budimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(864, 'Vujadinović', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(865, 'Vujkov', 'Đorđe', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(866, 'Vujović', 'Svetozar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(867, 'Vujović', 'Zlatko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(868, 'Vujović', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(869, 'Vukas', 'Bernard', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(870, 'Vukčević', 'Radomir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:41:56', '2025-03-09 17:41:56'),
(871, 'Vukčević', 'Simon', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(872, 'Vukelić', 'Milan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(873, 'Vukić', 'Zvonimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(874, 'Vukmir', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(875, 'Vukoje', 'Nedeljko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(876, 'Vukosavljević', 'Branislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(877, 'Vukotić', 'Momčilo', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(878, 'Vuković', 'Jagoš', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(879, 'Vulić', 'Zoran', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(880, 'Vuličević', 'Miroslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(881, 'Zagorac', 'Slavko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(882, 'Zajec', 'Velimir', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(883, 'Zajić', 'Bojan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(884, 'Zambata', 'Slaven', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(885, 'Zavišić', 'Ilija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(886, 'Zdjelar', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(887, 'Zebec', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(888, 'Zečević', 'Dobrivoje', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(889, 'Zeković', 'Miljan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(890, 'Zemko', 'Josip', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(891, 'Zinaja', 'Branko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(892, 'Zinaja', 'Dušan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(893, 'Zorić', 'Saša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(894, 'Žanetić', 'Ante', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(895, 'Žigić', 'Nikola', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(896, 'Žilić', 'Dragan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(897, 'Živanović', 'Todor', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(898, 'Živković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(899, 'Živković', 'Aleksandar', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(900, 'Živković', 'Andrija', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(901, 'Živković', 'Bratislav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(902, 'Živković', 'Jovan', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(903, 'Živković', 'Zvonko', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(904, 'Žungul', 'Slaviša', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13'),
(905, 'Župančić', 'Vjekoslav', 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, '2025-03-09 17:45:13', '2025-03-09 17:45:13');

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `izmene`
--

INSERT INTO `izmene` (`id`, `utakmica_id`, `tim_id`, `igrac_out_id`, `igrac_in_id`, `minut`, `created_at`, `updated_at`) VALUES
(17, 10, 5, 605, 355, 46, '2025-03-26 20:05:19', '2025-03-26 20:05:19'),
(13, 2, 1, 597, 360, 64, '2025-03-15 15:45:53', '2025-03-15 15:45:53');

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
  `drugi_zuti` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kartoni_utakmica_id_foreign` (`utakmica_id`),
  KEY `kartoni_igrac_id_foreign` (`igrac_id`),
  KEY `kartoni_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(41, '2025_03_10_203217_allow_null_minut_in_golovi_table', 10),
(42, '2025_03_11_203714_create_protivnicke_izmene_table', 11),
(43, '2025_03_13_194949_change_biografija_to_text_in_igraci_table', 12),
(44, '2025_03_14_224608_add_u_sastavu_to_protivnicki_igraci_table', 13),
(45, '2025_03_15_182809_add_visina_to_igraci_table', 14),
(46, '2025_03_15_191651_create_protivnicki_kartoni_table', 15),
(47, '2025_03_15_194816_add_drugi_zuti_to_kartoni_tables', 16),
(48, '2025_03_15_214616_add_penalty_shootout_to_utakmice_table', 17),
(49, '2025_03_22_191106_add_is_admin_to_users_table', 18),
(50, '2025_03_22_192551_add_role_to_users_table', 18),
(51, '2025_03_24_185545_add_redosled_to_sastavi_table', 19),
(52, '2025_03_24_192628_add_redosled_to_protivnicki_igraci', 20);

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
-- Table structure for table `protivnicke_izmene`
--

DROP TABLE IF EXISTS `protivnicke_izmene`;
CREATE TABLE IF NOT EXISTS `protivnicke_izmene` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `igrac_out_id` bigint UNSIGNED NOT NULL,
  `igrac_in_id` bigint UNSIGNED NOT NULL,
  `minut` int NOT NULL,
  `napomena` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `protivnicke_izmene_utakmica_id_foreign` (`utakmica_id`),
  KEY `protivnicke_izmene_tim_id_foreign` (`tim_id`),
  KEY `protivnicke_izmene_igrac_out_id_foreign` (`igrac_out_id`),
  KEY `protivnicke_izmene_igrac_in_id_foreign` (`igrac_in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicke_izmene`
--

INSERT INTO `protivnicke_izmene` (`id`, `utakmica_id`, `tim_id`, `igrac_out_id`, `igrac_in_id`, `minut`, `napomena`, `created_at`, `updated_at`) VALUES
(7, 2, 9, 10, 64, 77, NULL, '2025-03-15 13:03:48', '2025-03-15 13:03:48'),
(6, 2, 9, 16, 63, 68, NULL, '2025-03-15 13:03:13', '2025-03-15 13:03:13'),
(8, 2, 9, 13, 65, 80, NULL, '2025-03-15 13:04:11', '2025-03-15 13:04:11'),
(11, 11, 23, 49, 69, 23, NULL, '2025-03-26 20:08:15', '2025-03-26 20:08:15');

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
  `u_sastavu` tinyint(1) NOT NULL DEFAULT '1',
  `redosled` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `protivnicki_igraci_utakmica_id_foreign` (`utakmica_id`),
  KEY `protivnicki_igraci_tim_id_foreign` (`tim_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicki_igraci`
--

INSERT INTO `protivnicki_igraci` (`id`, `ime`, `prezime`, `utakmica_id`, `tim_id`, `kapiten`, `u_sastavu`, `redosled`, `created_at`, `updated_at`) VALUES
(1, 'Fehmi', 'Mert Günok', 1, 8, 0, 1, NULL, '2025-03-05 19:24:18', '2025-03-05 19:24:18'),
(2, 'Hasan', 'Ali Kaldırım', 1, 8, 0, 1, NULL, '2025-03-05 19:24:37', '2025-03-05 19:24:37'),
(3, 'Zeki', 'Çelik', 1, 8, 0, 1, NULL, '2025-03-05 19:27:39', '2025-03-05 19:27:39'),
(4, 'Anton', 'Shunin', 2, 9, 0, 1, NULL, '2025-03-05 19:58:37', '2025-03-05 19:58:37'),
(5, 'Mário', 'Fernandes', 2, 9, 0, 1, NULL, '2025-03-05 19:58:51', '2025-03-05 19:58:51'),
(8, 'Vyacheslav', 'Karavaev', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(9, 'Georgi', 'Dzhikiya', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(10, 'Andrei', 'Semenov', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(11, 'Aleksey', 'Ionov', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(12, 'Roman', 'Zobnin', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(13, 'Yuriy', 'Zhirkov', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(14, 'Magomed', 'Ozdoev', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(15, 'Artem', 'Dzyuba', 2, 9, 1, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(16, 'Zelimkhan', 'Bakaev', 2, 9, 0, 1, NULL, '2025-03-08 18:17:38', '2025-03-08 18:17:38'),
(17, 'Rudolf', 'Klapka', 8, 23, 0, 1, 0, '2025-03-10 18:37:31', '2025-03-26 18:44:04'),
(18, 'Antonin', 'Hojer', 8, 23, 0, 1, 1, '2025-03-10 18:37:48', '2025-03-26 18:44:04'),
(19, 'Miroslav', 'Pospíšil', 8, 23, 0, 1, 2, '2025-03-10 18:38:01', '2025-03-26 18:44:04'),
(20, 'František', 'Kolenatý', 8, 23, 0, 1, 3, '2025-03-10 18:38:14', '2025-03-25 19:36:26'),
(21, 'Karel', 'Pešek ‘Káďa’', 8, 23, 1, 1, 4, '2025-03-10 18:38:31', '2025-03-25 19:36:26'),
(22, 'Antonín', 'Perner', 8, 23, 0, 1, 5, '2025-03-10 18:38:43', '2025-03-25 19:36:26'),
(23, 'Josef', 'Sedláček', 8, 23, 0, 1, 6, '2025-03-10 18:39:04', '2025-03-25 19:36:26'),
(24, 'Antonín', 'Janda', 8, 23, 0, 1, 7, '2025-03-10 18:39:19', '2025-03-25 19:36:26'),
(25, 'Václav', 'Pilát', 8, 23, 0, 1, 8, '2025-03-10 18:39:33', '2025-03-25 19:36:26'),
(26, 'Jan', 'Vaník', 8, 23, 0, 1, 9, '2025-03-10 18:39:55', '2025-03-25 19:36:26'),
(27, 'Otakar', 'Škvajn', 8, 23, 0, 1, 10, '2025-03-10 18:40:14', '2025-03-25 19:36:01'),
(28, 'Kamel', 'Taha', 10, 102, 0, 1, 0, '2025-03-10 19:18:45', '2025-03-26 20:03:38'),
(29, 'Mohamed', 'El Sayed', 10, 102, 0, 1, 1, '2025-03-10 19:19:02', '2025-03-26 20:03:44'),
(30, 'Abdel Salam', 'Hamdy', 10, 102, 0, 1, 2, '2025-03-10 19:19:19', '2025-03-26 20:03:50'),
(31, 'Riad', 'Shawid', 10, 102, 0, 1, 3, '2025-03-10 19:19:34', '2025-03-26 20:03:56'),
(32, 'Aly Fahmy', 'El Hassany', 10, 102, 0, 1, 4, '2025-03-10 19:19:48', '2025-03-26 20:04:07'),
(33, 'Gamil', 'Osman', 10, 102, 0, 1, 5, '2025-03-10 19:20:04', '2025-03-26 20:04:22'),
(34, 'Tawfik', 'Abdalla', 10, 102, 0, 1, 6, '2025-03-10 19:20:20', '2025-03-26 20:04:22'),
(35, 'Hassan', 'Allouba', 10, 102, 0, 1, 7, '2025-03-10 19:22:54', '2025-03-26 20:04:19'),
(36, 'Hussein', 'Hegazy', 10, 102, 1, 1, 8, '2025-03-10 19:23:08', '2025-03-26 20:04:16'),
(37, 'Sayed', 'Abaza', 10, 102, 0, 1, 9, '2025-03-10 19:23:23', '2025-03-26 20:04:13'),
(38, 'Zaki', 'Othman', 10, 102, 0, 1, 10, '2025-03-10 19:23:35', '2025-03-26 20:03:56'),
(39, 'Jaroslav', 'Cháňa', 11, 23, 0, 1, 0, '2025-03-11 18:45:33', '2025-03-26 20:06:16'),
(40, 'Karel', 'Nytl', 11, 23, 0, 1, 1, '2025-03-11 18:45:33', '2025-03-26 20:06:16'),
(41, 'Miroslav', 'Pospíšil', 11, 23, 0, 1, 2, '2025-03-11 18:45:33', '2025-03-26 20:06:20'),
(42, 'František', 'Plodr', 11, 23, 0, 1, 3, '2025-03-11 18:45:33', '2025-03-26 20:06:28'),
(43, 'Karel', 'Pešek', 11, 23, 1, 1, 4, '2025-03-11 18:45:33', '2025-03-26 20:06:37'),
(44, 'Emil', 'Seifert', 11, 23, 0, 1, 5, '2025-03-11 18:45:33', '2025-03-26 20:06:54'),
(45, 'Josef', 'Sedláček', 11, 23, 0, 1, 6, '2025-03-11 18:45:33', '2025-03-26 20:06:54'),
(46, 'Antonín', 'Janda', 11, 23, 0, 1, 7, '2025-03-11 18:45:33', '2025-03-26 20:06:50'),
(47, 'Jan', 'Vaník', 11, 23, 0, 1, 8, '2025-03-11 18:45:33', '2025-03-26 20:06:46'),
(48, 'Josef', 'Šroubek', 11, 23, 0, 1, 9, '2025-03-11 18:45:33', '2025-03-26 20:06:46'),
(49, 'Otakar', 'Škvajn', 11, 23, 0, 1, 10, '2025-03-11 18:45:33', '2025-03-26 20:06:41'),
(53, 'Rezső', 'Szulik', 27, 64, 0, 1, NULL, '2025-03-12 20:52:00', '2025-03-12 20:52:00'),
(63, 'Anton', 'Miranchuk', 2, 9, 0, 0, NULL, '2025-03-15 13:03:13', '2025-03-15 13:03:13'),
(64, 'Roman', 'Neustädter', 2, 9, 0, 0, NULL, '2025-03-15 13:03:48', '2025-03-15 13:03:48'),
(65, 'Daler', 'Kuzyaev', 2, 9, 0, 0, NULL, '2025-03-15 13:04:11', '2025-03-15 13:04:11'),
(69, 'Jelínek', 'Josef', 11, 23, 0, 0, NULL, '2025-03-26 20:08:15', '2025-03-26 20:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `protivnicki_kartoni`
--

DROP TABLE IF EXISTS `protivnicki_kartoni`;
CREATE TABLE IF NOT EXISTS `protivnicki_kartoni` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `utakmica_id` bigint UNSIGNED NOT NULL,
  `tim_id` bigint UNSIGNED NOT NULL,
  `igrac_id` bigint UNSIGNED NOT NULL,
  `tip` enum('zuti','crveni') COLLATE utf8mb4_unicode_ci NOT NULL,
  `minut` int NOT NULL,
  `drugi_zuti` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `protivnicki_kartoni_utakmica_id_foreign` (`utakmica_id`),
  KEY `protivnicki_kartoni_tim_id_foreign` (`tim_id`),
  KEY `protivnicki_kartoni_igrac_id_foreign` (`igrac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `protivnicki_selektori`
--

INSERT INTO `protivnicki_selektori` (`id`, `utakmica_id`, `tim_id`, `ime_prezime`, `napomena`, `created_at`, `updated_at`) VALUES
(1, 2, 9, 'Stanislav Cherchesov', NULL, '2025-03-09 14:38:11', '2025-03-09 14:38:11'),
(2, 8, 23, 'Josef Fanta', NULL, '2025-03-10 18:41:34', '2025-03-10 18:41:34'),
(3, 10, 102, 'Hussein Hegazi', NULL, '2025-03-10 19:16:51', '2025-03-10 19:16:51'),
(4, 11, 23, 'Ferdinand Scheinost', NULL, '2025-03-11 18:46:28', '2025-03-23 19:14:53');

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
  `redosled` int DEFAULT '999',
  PRIMARY KEY (`id`),
  KEY `sastavi_utakmica_id_foreign` (`utakmica_id`),
  KEY `sastavi_tim_id_foreign` (`tim_id`),
  KEY `sastavi_igrac_id_foreign` (`igrac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sastavi`
--

INSERT INTO `sastavi` (`id`, `utakmica_id`, `tim_id`, `igrac_id`, `starter`, `selektor`, `created_at`, `updated_at`, `redosled`) VALUES
(69, 8, 5, 861, 1, NULL, '2025-03-14 21:49:17', '2025-03-25 19:36:23', 0),
(5, 8, 5, 905, 1, 'Veljko Ugrinić', '2025-03-09 18:39:21', '2025-03-25 19:36:23', 1),
(6, 8, 5, 790, 1, 'Veljko Ugrinić', '2025-03-09 18:39:21', '2025-03-25 19:36:23', 2),
(7, 8, 5, 809, 1, NULL, '2025-03-09 18:42:42', '2025-03-25 19:36:23', 3),
(8, 8, 5, 107, 1, NULL, '2025-03-09 18:43:01', '2025-03-25 19:36:23', 4),
(9, 8, 5, 695, 1, NULL, '2025-03-09 18:43:15', '2025-03-25 19:36:23', 5),
(10, 8, 5, 859, 1, NULL, '2025-03-09 18:43:27', '2025-03-25 19:36:23', 6),
(11, 8, 5, 164, 1, NULL, '2025-03-09 18:43:38', '2025-03-26 20:01:42', 7),
(12, 8, 5, 605, 1, NULL, '2025-03-09 18:43:53', '2025-03-26 20:01:42', 8),
(13, 8, 5, 226, 1, NULL, '2025-03-09 18:44:05', '2025-03-26 20:01:42', 9),
(14, 8, 5, 697, 1, NULL, '2025-03-09 18:44:20', '2025-03-25 19:36:05', 10),
(15, 10, 5, 861, 1, NULL, '2025-03-10 19:13:07', '2025-03-26 20:03:15', 0),
(16, 10, 5, 790, 1, NULL, '2025-03-10 19:13:23', '2025-03-26 20:03:18', 1),
(17, 10, 5, 645, 1, NULL, '2025-03-10 19:13:34', '2025-03-26 20:03:21', 2),
(18, 10, 5, 809, 1, NULL, '2025-03-10 19:13:47', '2025-03-26 20:03:21', 3),
(19, 10, 5, 695, 1, NULL, '2025-03-10 19:13:57', '2025-03-26 20:03:21', 4),
(20, 10, 5, 859, 1, NULL, '2025-03-10 19:14:14', '2025-03-26 20:03:21', 5),
(21, 10, 5, 710, 1, NULL, '2025-03-10 19:14:24', '2025-03-26 20:03:21', 6),
(22, 10, 5, 716, 1, NULL, '2025-03-10 19:14:36', '2025-03-26 20:03:21', 7),
(23, 10, 5, 164, 1, NULL, '2025-03-10 19:14:50', '2025-03-26 20:03:21', 8),
(24, 10, 5, 605, 1, NULL, '2025-03-10 19:15:05', '2025-03-26 20:03:21', 9),
(25, 10, 5, 697, 1, NULL, '2025-03-10 19:15:18', '2025-03-26 20:03:21', 10),
(26, 11, 5, 861, 1, NULL, '2025-03-11 18:51:45', '2025-03-11 18:51:45', 999),
(27, 11, 5, 393, 1, NULL, '2025-03-11 18:52:25', '2025-03-11 18:52:25', 999),
(28, 11, 5, 790, 1, NULL, '2025-03-11 18:52:37', '2025-03-11 18:52:37', 999),
(29, 11, 5, 588, 1, NULL, '2025-03-11 18:53:34', '2025-03-11 18:53:34', 999),
(30, 11, 5, 164, 1, NULL, '2025-03-11 18:53:45', '2025-03-11 18:53:45', 999),
(31, 11, 5, 695, 1, NULL, '2025-03-11 18:53:53', '2025-03-11 18:53:53', 999),
(32, 11, 5, 344, 1, NULL, '2025-03-11 18:54:02', '2025-03-11 18:54:02', 999),
(33, 11, 5, 891, 1, NULL, '2025-03-11 18:54:22', '2025-03-11 18:54:22', 999),
(34, 11, 5, 605, 1, NULL, '2025-03-11 18:54:30', '2025-03-11 18:54:30', 999),
(35, 11, 5, 477, 1, NULL, '2025-03-11 18:54:40', '2025-03-11 18:54:40', 999),
(36, 11, 5, 26, 1, NULL, '2025-03-11 18:54:47', '2025-03-11 18:54:47', 999),
(39, 27, 5, 210, 1, NULL, '2025-03-12 20:42:41', '2025-03-12 20:42:41', 999),
(40, 27, 5, 860, 1, NULL, '2025-03-12 20:49:01', '2025-03-12 20:49:01', 999),
(41, 27, 5, 137, 1, NULL, '2025-03-12 20:49:12', '2025-03-12 20:49:12', 999),
(42, 27, 5, 19, 1, NULL, '2025-03-12 20:49:26', '2025-03-12 20:49:26', 999),
(43, 27, 5, 648, 1, NULL, '2025-03-12 20:49:36', '2025-03-12 20:49:36', 999),
(44, 27, 5, 394, 1, NULL, '2025-03-12 20:49:48', '2025-03-12 20:49:48', 999),
(45, 27, 5, 26, 1, NULL, '2025-03-12 20:49:59', '2025-03-12 20:49:59', 999),
(46, 27, 5, 307, 1, NULL, '2025-03-12 20:50:13', '2025-03-12 20:50:13', 999),
(47, 27, 5, 605, 1, NULL, '2025-03-12 20:50:36', '2025-03-12 20:50:36', 999),
(48, 27, 5, 602, 1, NULL, '2025-03-12 20:50:48', '2025-03-12 20:50:48', 999),
(51, 27, 5, 591, 1, NULL, '2025-03-12 22:18:56', '2025-03-12 22:18:56', 999),
(52, 2, 1, 150, 1, NULL, '2025-03-13 20:21:33', '2025-03-13 20:21:33', 999),
(53, 2, 1, 446, 1, NULL, '2025-03-13 20:21:53', '2025-03-13 20:21:53', 999),
(54, 2, 1, 467, 1, NULL, '2025-03-13 20:22:03', '2025-03-13 20:22:03', 999),
(55, 2, 1, 597, 1, NULL, '2025-03-13 20:33:54', '2025-03-13 20:33:54', 999),
(56, 2, 1, 466, 1, NULL, '2025-03-13 20:34:08', '2025-03-13 20:34:08', 999),
(57, 2, 1, 232, 1, NULL, '2025-03-13 20:34:20', '2025-03-13 20:34:20', 999),
(58, 2, 1, 512, 1, NULL, '2025-03-13 20:34:33', '2025-03-13 20:34:33', 999),
(59, 2, 1, 453, 1, NULL, '2025-03-13 20:34:53', '2025-03-13 20:34:53', 999),
(60, 2, 1, 366, 1, NULL, '2025-03-13 20:35:06', '2025-03-13 20:35:06', 999),
(61, 2, 1, 806, 1, NULL, '2025-03-13 20:35:15', '2025-03-13 20:35:15', 999),
(62, 2, 1, 406, 1, NULL, '2025-03-13 20:35:23', '2025-03-13 20:35:23', 999),
(74, 2, 1, 360, 0, NULL, '2025-03-15 15:45:53', '2025-03-15 15:45:53', 999),
(78, 10, 5, 355, 0, NULL, '2025-03-26 20:05:19', '2025-03-26 20:05:19', 999),
(79, 12, 5, 210, 1, NULL, '2025-03-26 20:10:04', '2025-03-26 20:10:04', 999),
(80, 12, 5, 393, 1, NULL, '2025-03-26 20:10:14', '2025-03-26 20:10:14', 999),
(81, 12, 5, 790, 1, NULL, '2025-03-26 20:10:43', '2025-03-26 20:10:43', 999),
(82, 12, 5, 801, 1, NULL, '2025-03-26 20:11:19', '2025-03-26 20:11:19', 999),
(83, 12, 5, 164, 1, NULL, '2025-03-26 20:11:36', '2025-03-26 20:11:36', 999),
(84, 12, 5, 695, 1, NULL, '2025-03-26 20:11:46', '2025-03-26 20:11:46', 999),
(85, 12, 5, 26, 1, NULL, '2025-03-26 20:11:58', '2025-03-26 20:11:58', 999),
(86, 12, 5, 891, 1, NULL, '2025-03-26 20:12:16', '2025-03-26 20:12:16', 999),
(87, 12, 5, 605, 1, NULL, '2025-03-26 20:12:30', '2025-03-26 20:12:30', 999),
(88, 12, 5, 853, 1, NULL, '2025-03-26 20:12:41', '2025-03-26 20:12:41', 999),
(89, 12, 5, 798, 1, NULL, '2025-03-26 20:12:54', '2025-03-26 20:12:54', 999);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektori`
--

INSERT INTO `selektori` (`id`, `ime`, `prezime`, `datum_rodjenja`, `mesto_rodjenja`, `datum_smrti`, `mesto_smrti`, `drzavljanstvo`, `biografija`, `fotografija_path`, `created_at`, `updated_at`) VALUES
(1, 'Veljko', 'Ugrinić', '1885-12-28', 'Stara Gradiška', '1958-07-18', 'Zagreb', NULL, '<p>Veljko Ugrinić (Stara Gradi&scaron;ka, 28. prosinca 1885. - Zagreb, 15. srpnja 1958.) je bio hrvatski nogometni stručnjak, atletičar, poznati zagrebački &scaron;portski radnik i svestrani aktivni &scaron;porta&scaron;. Bio je članom &scaron;portskog dru&scaron;tva Concordije iz Zagreba. Nogometom se bavio od 1903. godine. Jednim je od suosnivača PNI&Scaron;K-a. Bavio se lakom atletikom. 1906. je pobijedio na prvoj priredbi koja se je održala u Zagrebu. Natjecao se u disciplini trčanje 3000 m (trčalo se od Dubrave do Zagreba) i na 100 m.</p>\r\n<p>Nakon &scaron;to je zavr&scaron;io Prvi svjetski rat, djeluje pri atletičarskom odjelu Concordije. 1919. je bio suosnivačem i prvim predsjednikom Lakoatletskog saveza Hrvatske i Slavonije te Jugoslavenskog lakoatletskog saveza 1921., čijim je čelnikom bio sve do 1937. godine. Od 1919. sve do 1937. bio je članom Jugoslavenskog olimpijskog odbora. Kad je bio osnivan Jugoslavenski nogometni savez, na osnivačkoj sjednici bila su zastupljena nogometna sredi&scaron;ta: Beograd, Karlovac, Ni&scaron;, Novi Sad, Osijek, Požega, Sisak, Skoplje, Slavonski Brod, Split, Valjevo, Varaždin i Zagreb (7 zagrebačkih klubova). Osnivačku sjednicu vodio je Hinko W&uuml;rth koji je izabran za prvog predsjednika JNS-a. Prvim tajnikom Saveza postao je dr. Fran &Scaron;uklje. Priznata su nogometna pravila koja je preveo dr. Milovan Zoričić. Prof. Franjo Bučar je predviđen za predstavnika u FIFA-i, a izbornikom reprezentacije je postao Veljko Ugrinić. Vodio ju je od 1920. do 1924. godine.&nbsp;</p>\r\n<p>Reprezentaciju je vodio na Olimpijskim igrama 1920., a bio je smijenjen uoči Olimpijskih igara 1924., jer su u savezu radije odlučili smijeniti trenera nego promijeniti problematične igrače. Kao trener, tri je puta pobijedio, jednom je igrao nerije&scaron;eno te &scaron;est puta izgubio. Reprezentacija je pod njegovim vođenjem napredovala. Unutar samo dvije godine uspjela je pobijediti momčadi od kojih je prije dvije godine (te&scaron;ko) izgubila (Čehoslovačka 1920. 0:7 i 1921. 1:6, 1922. 4:3, Poljska, Rumunjska).</p>\r\n<p>Predsjedao je Jugoslavenskim nogometnim savezom od 1923. do 1924., naslijediv&scaron;i Miroslava Petanjka. Ugrinića je na mjestu predsjednika naslijedio Hinko W&uuml;rth. Bio je godine bio jednim od suosnivača Balkanskih atletskih igara. 1934. je bio organizirao 5. Balkanske atletske igre u Zagrebu. Četiri godine je godine predsjedao Interbalkanskim komitetom. 15. travnja 1936. je u Zagrebu održana utemeljiteljska skup&scaron;tina jugoslavenskog hokejskog (hockey) saveza. Na toj je sjednici za predsjednika saveza izabran Veljko Ugrinić. Dok je trajao travanjski rat 1941. nekoliko su ga puta uhitili i zatvorili. Zadnji put se je natjecao u atletici 1947. za Omladinsko studentsko fiskulturno dru&scaron;tvo Mladost. Osim toga, poslije rata organizirao je u Hrvatskoj streljačka natjecanja.&nbsp;</p>\r\n<p>Obna&scaron;ao je razne visoke &scaron;portske dužnosti, pa je potpredsjedao Fiskulturnim savezom Hrvatske, bio odbornikom Komiteta za fiskulturu Hrvatske, predsjedao je Atletskim savezom Hrvatske te je bio član inim &scaron;portskim i dru&scaron;tvenim organizacijama na razini grada Zagreba, Hrvatske te Jugoslavije.</p>', 'selektori/AsQUxXOq2ghhtMPq6IQzYRvkfOXepoK4BsvRkhM9.jpg', '2025-03-09 12:06:25', '2025-03-16 20:10:02'),
(3, 'Todor', 'Sekulić', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-09 17:49:38', '2025-03-09 17:49:38'),
(4, 'Dušan', 'Zinaja', '1893-10-23', 'Budimpešta (HUN)', '1948-09-26', 'Zagreb', NULL, '<p>Rođen 23. oktobra 1893. u Budimpe&scaron;ti, poginuo 26. septembra 1948. kod sela Poklek na Žumberku, u blizini Zagreba.</p>\r\n<p>Zavr&scaron;io je pučku &scaron;kolu i gimnaziju u Zagrebu. Već tokom &scaron;kolovanja posvećuje se fudbalu, a pre Prvog svetskog rata, zajedno s mlađim bratom Brankom, pristupa HA&Scaron;K-u gde se ubrzo ističe dobrim igrama na levom krilu. Narednih godina standardni je prvotimac HA&Scaron;K-a, s kim 1921/22. osvaja prvenstvo Zagrebačkog nogometnog podsaveza, a u sezoni 1923/24. postaje i kapiten kluba. Poznat pod nadimkom &ldquo;Stari Bampas&rdquo;, Du&scaron;an Zinaja vrhunac karijere doživeo je 10. juna 1923. u Bukure&scaron;tu kada je zaigrao za reprezentaciju Kraljevine Jugoslavije u gostujućoj pobedi (2:1) protiv Rumunije. Upravo na toj utakmici, &ldquo;pred oba kralja i obe kraljice, celom kraljevskom porodicom i 15.000 gledalaca&rdquo; kako javlja beogradska Politika, Du&scaron;an je zajedno s mlađim bratom Brankom nastupio kao prvi dvojac braće u reprezentaciji i u&scaron;ao u istoriju jugoslovenskog fudbala.</p>\r\n<p>Ta utakmica bila je prvi i jedini nastup Du&scaron;ana Zinaje za reprezentaciju jer ga već iduće 1924. godine Jugoslovenski nogometni savez imenuje na funkciju selektora nacionalnog tima. Zinaja tako postaje prvi biv&scaron;i reprezentativac koji obavlja dužnost trenera reprezentacije. U razdoblju 1924-1925. tri puta vodi reprezentaciju Jugoslavije, sva tri puta bez pobede: gubi utakmice protiv Čehoslovačke, u Zagrebu (0:2) i u Pragu (0:7), a ne uspeva ni u Padovi protiv Italije (1:2).</p>\r\n<p>Osim u fudbalu, Du&scaron;an Zinaja bio je aktivan i u HA&Scaron;K-ovoj skija&scaron;koj sekciji. Redovno je učestvovao na državnim prvenstvima u skija&scaron;kom trčanju, a pobedom 1923. godine stiče pravo nastupa na prvim Zimskim olimpijskim igrama u francuskom &Scaron;amoniju 1924. Na svečanom otvaranju Igara Jugoslaviju predstavljaju četiri takmičara, a Zinaji pripada čast da nosi državnu zastavu. Učestvuje na dve trke: na 18 km zauzima 35. mesto dok u trci na 50 km, koja se odvijala u nemogućim vremenskim uvjetima, ostaje bez plasmana iako je pro&scaron;ao kroz cilj s četiri sata zaka&scaron;njenja. No, danas je manje poznato da je Du&scaron;an Zinaja bio ne samo svestrani sportista već takođe novinar i urednik tada popularnog Ilustrovanog nedeljnika &ldquo;Sport&rdquo;, koji je izlazio u Zagrebu od 1922-1924.</p>\r\n<p>Bez obzira na sportsku slavu, braća Zinaja nisu zaboravljala roditeljski dom u Glini kojem su se vraćali svakog leta jo&scaron; od &scaron;kolskih dana. Verovatno su kao &scaron;kolarci nastupili u prvoj zabeleženoj utakmici u Glini između Banovca i Hrvatskog Sokola iz Siska 1913. godine, međutim, pouzdano se zna da su 1920. braća (u to vreme već igrači HA&Scaron;K-a) zaigrali za svoje Glinjane na prijateljskoj utakmici kada je novoosnovani Glinski &scaron;portski klub sa 5:2 porazio favoriziranu sisačku Segestu.</p>\r\n<p>Braća Zinaja pripadali su pionirskoj generaciji fudbalskih reprezentativaca prve Jugoslavije. Nakon uspe&scaron;ne igračke karijere, Branko se vratio pozivu vi&scaron;eg poreznog službenika, dok se Du&scaron;an posvetio sportskom novinarstvu. Obojica su nastavila živeti u Zagrebu i nekako su uspeli preživeti sve strahote Drugog svetskog rata.</p>\r\n<p>Nažalost, u poratnoj obnovi zemlje Du&scaron;an nesrećno zavr&scaron;ava svoj život od posledica saobraćajne nesreće koju je doživeo na radnoj akciji kod sela Poklek na Žumberku 1948. godine. Bratova prerana i tragična smrt snažno je uticala na mlađeg Branka koji već sledeće 1949. umire u Opatiji od moždanog udara, u 54-oj godini života.</p>\r\n<p>Braća Zinaja sahranjena su u porodičnoj grobnici na zagrebačkom Mirogoju, na pravoslavnom delu groblja u blizini kapele sv. Petra i Pavla.</p>', 'selektori/gO2Q65pd2rO5P1P34eZ7Ydx2h6S2bU3ZgCuKi555.jpg', '2025-03-09 17:51:40', '2025-03-23 19:23:25'),
(5, 'Ante', 'Pandaković', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-09 18:24:48', '2025-03-09 18:24:48'),
(6, 'Boško', 'Simonović', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-12 19:57:51', '2025-03-12 19:57:51'),
(7, 'Branislav', 'Veljković', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-12 20:07:53', '2025-03-12 20:07:53');

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selektor_mandati`
--

INSERT INTO `selektor_mandati` (`id`, `selektor_id`, `tim_id`, `pocetak_mandata`, `kraj_mandata`, `v_d_status`, `napomena`, `created_at`, `updated_at`) VALUES
(7, 7, 5, '1933-04-03', '1933-11-06', 0, NULL, '2025-03-12 20:07:53', '2025-03-12 20:07:53'),
(2, 1, 5, '1920-08-28', '1924-02-10', 0, NULL, '2025-03-09 12:13:16', '2025-03-09 12:13:16'),
(3, 3, 5, '1924-05-26', '1924-05-26', 0, NULL, '2025-03-09 17:49:38', '2025-03-09 17:49:38'),
(4, 4, 5, '1924-09-28', '1925-11-04', 0, NULL, '2025-03-09 17:51:40', '2025-03-09 17:51:40'),
(5, 5, 5, '1926-05-30', '1930-01-26', 0, NULL, '2025-03-09 18:24:48', '2025-03-09 18:24:48'),
(6, 6, 5, '1930-04-13', '1932-10-09', 0, NULL, '2025-03-12 19:57:51', '2025-03-12 19:57:51'),
(8, 7, 5, '1933-09-10', '1933-09-24', 0, NULL, '2025-03-16 07:33:15', '2025-03-16 07:33:15');

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
('F2evIecye50brqQIqeOoCYDfqomqBlCy05zVPSkU', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia05rWWE3RVdpeEkzckt3d0pnbDNOWG95akhNbEtsMVBjWFZlWDQxayI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3QvcmVwcmV6ZW50YWNpamEvcHVibGljL3V0YWttaWNlLzEyIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1743019993);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `takmicenja`
--

INSERT INTO `takmicenja` (`id`, `naziv`, `sezona`, `organizator`, `created_at`, `updated_at`) VALUES
(1, 'Prijateljska', NULL, NULL, '2025-03-02 19:46:20', '2025-03-02 19:46:20'),
(2, 'Polufinale baraža za plasman na EURO 2020', NULL, NULL, '2025-03-08 17:17:54', '2025-03-08 17:17:54'),
(3, 'Olimpijske igre', NULL, NULL, '2025-03-10 18:47:32', '2025-03-10 18:47:32'),
(4, 'Liga Nacija', NULL, NULL, '2025-03-13 20:21:01', '2025-03-13 20:21:01'),
(5, 'aaa', NULL, NULL, '2025-03-16 07:22:45', '2025-03-16 07:22:45'),
(6, 'Kup prijateljskih zemalja', NULL, NULL, '2025-03-26 20:09:32', '2025-03-26 20:09:32');

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
(5, 'Kraljevina Jugoslavija', 'YUG', 'yug.png', 'yug.png', 'Kraljevina Jugoslavija', 0, 1, '1929-10-03 00:00:00', '1945-11-28 00:00:00', '2025-03-02 18:11:49', '2025-03-15 16:06:57'),
(8, 'Turska', 'TUR', 'tur.png', 'tur.png', 'Turska', 0, NULL, NULL, NULL, '2025-03-02 19:45:47', '2025-03-02 19:45:47'),
(9, 'Rusija', 'RUS', 'rus.png', 'rus.png', 'Rusija', 0, NULL, NULL, NULL, '2025-03-05 19:39:24', '2025-03-05 19:39:24'),
(10, 'Norveška', 'NOR', 'nor.png', 'nor.png', 'Norveška', 0, NULL, NULL, NULL, '2025-03-08 17:16:49', '2025-03-08 17:16:49'),
(11, 'Albanija', 'ALB', 'alb.png', 'alb.png', 'ALbanija', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-16 07:15:07'),
(12, 'Alžir', 'ALG', 'alg.png', 'alg.png', 'Alžir', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 09:46:08'),
(13, 'Argentina', 'ARG', 'arg.png', 'arg.png', 'Argentina', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-09 16:01:09'),
(14, 'Australija', 'AUS', 'aus.png', 'aus.png', 'Australija', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-13 19:51:44'),
(16, 'Azerbejdžan', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(17, 'Belgija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(18, 'Bolivija', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(19, 'Bosna i Hercegovina', NULL, NULL, NULL, '', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-08 18:10:19'),
(20, 'Brazil', 'BRA', 'bra.png', 'bra.png', 'Brazil', 0, NULL, NULL, NULL, '2025-03-08 18:10:19', '2025-03-23 19:32:05'),
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
(64, 'Mađarska', 'HUN', 'hun.png', 'hun.png', 'Mađarska', 0, NULL, NULL, NULL, '2025-03-08 18:12:13', '2025-03-12 20:41:20'),
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
(103, 'Rumunija', 'ROU', 'rou.png', 'rou.png', 'Rumunija', 0, NULL, NULL, NULL, NULL, '2025-03-14 21:33:57'),
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
  `role` enum('admin','editor','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Administrator', 'admin@example.com', NULL, '$2y$12$pqFEzfFRdQDo2hb40QSdXut7RhCDPwRfFNWH0QYXmjCff5xOlyD12', NULL, '2025-03-22 18:54:45', '2025-03-22 18:54:45', 'admin');

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
  `imao_jedanaesterce` tinyint(1) NOT NULL DEFAULT '0',
  `jedanaesterci_domacin` int DEFAULT NULL,
  `jedanaesterci_gost` int DEFAULT NULL,
  `publika` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utakmice_domacin_id_foreign` (`domacin_id`),
  KEY `utakmice_gost_id_foreign` (`gost_id`),
  KEY `utakmice_takmicenje_id_foreign` (`takmicenje_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `utakmice`
--

INSERT INTO `utakmice` (`id`, `datum`, `takmicenje_id`, `domacin_id`, `gost_id`, `stadion`, `sudija`, `rezultat_domacin`, `rezultat_gost`, `imao_jedanaesterce`, `jedanaesterci_domacin`, `jedanaesterci_gost`, `publika`, `admin_id`, `created_at`, `updated_at`) VALUES
(2, '2020-09-03', 4, 9, 1, 'VTB Arena', 'William Collum (Sco)', 3, 5, 0, NULL, NULL, 'Bez publike', NULL, '2025-03-05 19:40:21', '2025-03-16 07:09:33'),
(3, '2020-08-10', 2, 10, 1, 'Ullevaal Stadion', 'Daniele Orsato (Ita)', 2, 0, 0, NULL, NULL, '200', NULL, '2025-03-08 17:17:54', '2025-03-08 17:43:31'),
(8, '1920-08-28', 3, 5, 23, 'Stadion Broodstraat, Antwerp (Bel)', 'Raphael van Praag (Bel)', 0, 7, 0, NULL, NULL, '600', NULL, NULL, '2025-03-16 07:51:38'),
(10, '1920-09-02', 1, 5, 102, 'Olympisch Stadion, Antwerp (Bel)', 'Raphaël Van Praag (Bel)', 2, 4, 0, NULL, NULL, '500', NULL, NULL, '2025-03-10 19:38:02'),
(11, '1921-10-28', 1, 23, 5, 'Letná Stadium, Praha (Cze)', 'Wolf Simon Boas (Ned)', 6, 1, 0, NULL, NULL, '10000', NULL, NULL, '2025-03-11 19:20:35'),
(12, '1922-06-08', 6, 5, 103, 'Stadion SK Jugoslavija', 'Heinrich Retschury (Aut)', 1, 0, 0, NULL, NULL, '5000', NULL, NULL, '2025-03-26 20:13:13'),
(13, '1922-06-28', NULL, 5, 23, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '1922-10-01', NULL, 5, 104, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '1923-06-03', NULL, 104, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '1923-06-10', NULL, 103, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '1923-10-28', NULL, 23, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '1924-02-10', NULL, 5, 105, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '1924-05-26', NULL, 5, 106, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '1924-09-28', NULL, 5, 23, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '1925-10-28', NULL, 23, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '1925-11-04', NULL, 107, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '1926-05-30', NULL, 5, 108, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '1926-06-13', NULL, 109, 5, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '1926-06-28', NULL, 5, 23, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '1926-10-05', NULL, 5, 103, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '1927-04-10', 1, 64, 5, 'Ullüi ut, Budapest (Hun)', 'Heinrich Retschury (Aut)', 0, 0, 0, NULL, NULL, '6000', NULL, '2025-03-12 20:10:12', '2025-03-12 20:42:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
