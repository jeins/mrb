-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Nov 2014 um 00:10
-- Server Version: 5.6.16
-- PHP-Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `mrb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mrb_groupliqo`
--

CREATE TABLE IF NOT EXISTS `mrb_groupliqo` (
  `id_groupliqo` int(11) NOT NULL AUTO_INCREMENT,
  `groupliqo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_groupliqo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `mrb_groupliqo`
--

INSERT INTO `mrb_groupliqo` (`id_groupliqo`, `groupliqo`) VALUES
(1, 'BunGalau');
