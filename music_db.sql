-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 23 Eki 2024, 10:40:44
-- Sunucu sürümü: 8.3.0
-- PHP Sürümü: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `music_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `downloads`
--

DROP TABLE IF EXISTS `downloads`;
CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `download_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `file_size` int DEFAULT NULL,
  `duration` varchar(10) DEFAULT NULL,
  `download_count` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_youtube_url` (`youtube_url`(250))
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `downloads`
--

INSERT INTO `downloads` (`id`, `title`, `artist`, `youtube_url`, `file_path`, `download_date`, `file_size`, `duration`, `download_count`) VALUES
(4, 'Ufuk ', NULL, 'https://www.youtube.com/watch?v=fNFgigcIRQQ', 'Ufuk-al-kan-Unutmak-stiyorum.mp3', '2024-10-23 06:45:45', 4072868, '245', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `download_queue`
--

DROP TABLE IF EXISTS `download_queue`;
CREATE TABLE IF NOT EXISTS `download_queue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `youtube_url` varchar(255) NOT NULL,
  `status` enum('pending','processing','completed','failed') DEFAULT 'pending',
  `priority` int DEFAULT '1',
  `requested_by` varchar(255) DEFAULT NULL,
  `request_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `process_start` timestamp NULL DEFAULT NULL,
  `process_end` timestamp NULL DEFAULT NULL,
  `error_message` text,
  `attempts` int DEFAULT '0',
  `max_attempts` int DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_priority` (`priority`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lyrics`
--

DROP TABLE IF EXISTS `lyrics`;
CREATE TABLE IF NOT EXISTS `lyrics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `download_id` int DEFAULT NULL,
  `lyrics_text` text,
  `language` varchar(50) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `added_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_download_id` (`download_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
