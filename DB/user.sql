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
-- Tabellenstruktur für Tabelle `mrb_userlogin`
--

CREATE TABLE IF NOT EXISTS `mrb_userlogin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `keylog` varbinary(255) NOT NULL,
  `keydoc` varchar(32) NOT NULL,
  `groupliqo` varchar(2) NOT NULL,
  PRIMARY KEY (`user_id`)
);
