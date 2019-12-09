-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 05. Dez 2018 um 10:35
-- Server-Version: 10.1.26-MariaDB-0+deb9u1
-- PHP-Version: 7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `proftpd`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ftpgroup`
--

CREATE TABLE `ftpgroup` (
  `groupname` varchar(16) NOT NULL DEFAULT '',
  `gid` smallint(6) NOT NULL DEFAULT '5500',
  `members` varchar(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ProFTP group table';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ftpquotalimits`
--

CREATE TABLE `ftpquotalimits` (
  `name` varchar(30) DEFAULT NULL,
  `quota_type` enum('user','group','class','all') NOT NULL DEFAULT 'user',
  `per_session` enum('false','true') NOT NULL DEFAULT 'false',
  `limit_type` enum('soft','hard') NOT NULL DEFAULT 'soft',
  `bytes_in_avail` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `bytes_out_avail` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `bytes_xfer_avail` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `files_in_avail` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `files_out_avail` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `files_xfer_avail` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ftpquotatallies`
--

CREATE TABLE `ftpquotatallies` (
  `name` varchar(30) NOT NULL DEFAULT '',
  `quota_type` enum('user','group','class','all') NOT NULL DEFAULT 'user',
  `bytes_in_used` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `bytes_out_used` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `bytes_xfer_used` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `files_in_used` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `files_out_used` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `files_xfer_used` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ftpuser`
--

CREATE TABLE `ftpuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `userid` varchar(32) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `uid` smallint(6) NOT NULL DEFAULT '2001',
  `gid` smallint(6) NOT NULL DEFAULT '2001',
  `homedir` varchar(255) NOT NULL DEFAULT '',
  `shell` varchar(16) NOT NULL DEFAULT '/sbin/nologin',
  `count` int(11) NOT NULL DEFAULT '0',
  `accessed` datetime NOT NULL DEFAULT '1000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '1000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='ProFTP user table';

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ftpgroup`
--
ALTER TABLE `ftpgroup`
  ADD KEY `groupname` (`groupname`);

--
-- Indizes für die Tabelle `ftpuser`
--
ALTER TABLE `ftpuser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userid` (`userid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ftpuser`
--
ALTER TABLE `ftpuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
