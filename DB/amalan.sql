-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Nov 2014 um 21:16
-- Server Version: 5.6.16
-- PHP-Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `mrb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `amalan`
--

CREATE TABLE IF NOT EXISTS `amalan` (
  `id_amalan` int(11) NOT NULL AUTO_INCREMENT,
  `amalan` varchar(30) COLLATE latin1_german2_ci DEFAULT NULL,
  `min_hari` int(11) DEFAULT NULL,
  `min_minggu` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_amalan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `amalan`
--

INSERT INTO `amalan` (`id_amalan`, `amalan`, `min_hari`, `min_minggu`) VALUES
(1, 'banyak_tilawah', 3, 24),
(2, 'almathurat', 1, 7),
(3, 'dhuha', 1, 4),
(4, 'sedekah', 1, 1),
(5, 'puasa', 1, 1),
(6, 'tahajud', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
