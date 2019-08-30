DROP TABLE IF EXISTS `db_user`;
CREATE TABLE IF NOT EXISTS `db_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT 'bcfe9e3890e6c26deb554643e208bfb8',
  `status` enum('on','off','new') NOT NULL,
  `rechte` set('usr','mod','adm') NOT NULL DEFAULT 'usr',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sysadmin` int(1) NOT NULL DEFAULT '0'
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_2` (`username`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `db_user_config`;
CREATE TABLE IF NOT EXISTS `db_user_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` char(15) NOT NULL,
  `value` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `db_user_contact`;
CREATE TABLE IF NOT EXISTS `db_user_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) NOT NULL,
  `pushover` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `db_user_favorite`;
CREATE TABLE IF NOT EXISTS `db_user_favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `server_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `db_user_private`;
CREATE TABLE IF NOT EXISTS `db_user_private` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `salutation` char(12) NOT NULL DEFAULT 'Herr',
  `company` varchar(100) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `displayName` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `db_user_secure`;
CREATE TABLE IF NOT EXISTS `db_user_secure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(100) NOT NULL,
  `countLogin` int(11) NOT NULL,
  `authCode` char(100) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastAuthCode` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_last_update`;
CREATE TABLE IF NOT EXISTS `psm_last_update` (
  `last_update` datetime NOT NULL,
  `counter` int(2) NOT NULL,
  `updatet` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_log`;
CREATE TABLE IF NOT EXISTS `psm_log` (
  `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_id` int(11) UNSIGNED NOT NULL,
  `type` enum('status','email','sms','pushover','updater') NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(255) NOT NULL,
  `messageread` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_servers`;
CREATE TABLE IF NOT EXISTS `psm_servers` (
  `server_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) NOT NULL,
  `port` int(5) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` enum('service','website','reminder') NOT NULL DEFAULT 'service',
  `pattern` varchar(255) NOT NULL,
  `status` enum('on','off','warn') NOT NULL DEFAULT 'on',
  `rtime` float(9,7) DEFAULT NULL,
  `last_online` datetime DEFAULT NULL,
  `last_check` datetime DEFAULT NULL,
  `active` enum('yes','no') NOT NULL DEFAULT 'yes',
  `email` enum('yes','no') NOT NULL DEFAULT 'yes',
  `pushover` enum('yes','no') NOT NULL DEFAULT 'yes',
  `warning_threshold` mediumint(1) NOT NULL DEFAULT '1',
  `warning_threshold_counter` mediumint(1) NOT NULL,
  `description` text NOT NULL,
  `home_system` int(11) NOT NULL,
  `end_date` date NOT NULL,
  `warn_date` date NOT NULL,
  `isWarning` int(1) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  PRIMARY KEY (`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_servers_history`;
CREATE TABLE IF NOT EXISTS `psm_servers_history` (
  `servers_history_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `latency_min` float(9,7) NOT NULL,
  `latency_avg` float(9,7) NOT NULL,
  `latency_max` float(9,7) NOT NULL,
  `checks_total` int(11) UNSIGNED NOT NULL,
  `checks_failed` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`servers_history_id`),
  UNIQUE KEY `server_id_date` (`server_id`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_servers_uptime`;
CREATE TABLE IF NOT EXISTS `psm_servers_uptime` (
  `servers_uptime_id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `server_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `latency` float(9,7) DEFAULT NULL,
  PRIMARY KEY (`servers_uptime_id`),
  UNIQUE KEY `servers_uptime_id` (`servers_uptime_id`),
  KEY `server_id` (`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `psm_users`;
CREATE TABLE IF NOT EXISTS `psm_users` (
  `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) NOT NULL COMMENT 'user''s name, unique',
  `pushover_key` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_username` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_config`;
CREATE TABLE IF NOT EXISTS `wos_config` (
  `id` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `field` char(20) NOT NULL DEFAULT 'text',
  `textvalue` enum('ja','nein') NOT NULL DEFAULT 'nein',
  PRIMARY KEY (`id`),
  KEY `key` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_dns_cron`;
CREATE TABLE IF NOT EXISTS `wos_dns_cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `ipadresse` char(15) NOT NULL,
  `hostname` char(20) NOT NULL,
  `serverart` char(120) NOT NULL,
  `meldung` varchar(255) NOT NULL,
  `fehler` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `server_id` (`sid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_hardware`;
CREATE TABLE IF NOT EXISTS `wos_hardware` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(255) NOT NULL,
  `kategorie` char(100) NOT NULL,
  `inventarnummer` char(100) NOT NULL,
  `kaufdatum` date NOT NULL,
  `hersteller` varchar(255) NOT NULL,
  `modell` varchar(255) NOT NULL,
  `seriennummer` char(100) NOT NULL,
  `zuordnung` char(100) NOT NULL,
  `beschreibung` text NOT NULL,
  `inventur` enum('ja','nein') NOT NULL DEFAULT 'ja',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventarnummer` (`inventarnummer`,`seriennummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_hardware_details`;
CREATE TABLE IF NOT EXISTS `wos_hardware_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hardware_id` int(11) NOT NULL,
  `form_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `form_value` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_international`;
CREATE TABLE IF NOT EXISTS `wos_international` (
  `id` varchar(10) NOT NULL DEFAULT '',
  `aktiv` enum('ja','nein') NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_inventur`;
CREATE TABLE IF NOT EXISTS `wos_inventur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode` char(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_2` (`id`),
  UNIQUE KEY `barcode` (`barcode`),
  KEY `id` (`id`),
  KEY `barcode_2` (`barcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_knowledge`;
CREATE TABLE IF NOT EXISTS `wos_knowledge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` datetime NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `uploads` varchar(255) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT '1',
  `version` decimal(2,1) NOT NULL,
  UNIQUE KEY `page_name` (`page_name`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_knowledge_history`;
CREATE TABLE IF NOT EXISTS `wos_knowledge_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `version` decimal(2,1) NOT NULL,
  `datum` datetime NOT NULL,
  `user` varchar(100) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_language_de`;
CREATE TABLE IF NOT EXISTS `wos_language_de` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text_name` char(60) NOT NULL,
  `text_value` text NOT NULL,
  `art` enum('sys','usr','not') NOT NULL DEFAULT 'sys',
  PRIMARY KEY (`id`),
  KEY `text_name` (`text_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_license`;
CREATE TABLE IF NOT EXISTS `wos_license` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hersteller` varchar(200) NOT NULL,
  `produkt` varchar(200) NOT NULL,
  `version` char(50) NOT NULL,
  `licensekey` varchar(255) NOT NULL,
  `anzahl` int(5) NOT NULL,
  `beschreibung` text NOT NULL,
  `vmware` int(11) NOT NULL DEFAULT '0',
  `barcode` varchar(200) NOT NULL,
  `zuordnung` char(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_news`;
CREATE TABLE IF NOT EXISTS `wos_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` char(20) CHARACTER SET latin1 NOT NULL,
  `titel` varchar(255) CHARACTER SET tis620 COLLATE tis620_bin NOT NULL,
  `nachricht` text CHARACTER SET latin1 NOT NULL,
  `controller` char(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_server`;
CREATE TABLE IF NOT EXISTS `wos_server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(255) NOT NULL,
  `inventarnummer` char(30) NOT NULL,
  `hostname` char(30) NOT NULL,
  `aliase` varchar(255) NOT NULL,
  `ipadressen` char(50) NOT NULL,
  `standort` char(25) NOT NULL,
  `betriebssystem` varchar(255) NOT NULL,
  `technischedaten` varchar(255) NOT NULL,
  `verwendungszweck` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `serverart` enum('server','vmware') NOT NULL,
  `service_relations` char(50) NOT NULL,
  `live_dns` enum('on','off') NOT NULL DEFAULT 'on',
  `prio` int(1) NOT NULL,
  `wartung` tinyint(1) NOT NULL DEFAULT '0',
  `monitor` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hostname` (`hostname`),
  UNIQUE KEY `ipadressen` (`ipadressen`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `wos_server_dnsip`;
CREATE TABLE IF NOT EXISTS `wos_server_dnsip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL,
  `port` int(5) NOT NULL,
  `hostname` char(40) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`),
  KEY `hostname` (`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_server_ports`;
CREATE TABLE IF NOT EXISTS `wos_server_ports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastcheck` datetime NOT NULL,
  `ipadresse` char(20) NOT NULL,
  `port` int(5) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `beschreibung` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ipadresse` (`ipadresse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wos_system_details`;
CREATE TABLE IF NOT EXISTS `wos_system_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `systemid` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `wos_ticket`;
CREATE TABLE IF NOT EXISTS `wos_ticket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) NOT NULL DEFAULT '0',
  `closed` int(1) NOT NULL DEFAULT '0',
  `datum` datetime NOT NULL,
  `titel` varchar(200) NOT NULL,
  `beschreibung` mediumtext NOT NULL,
  `smt_system` int(5) NOT NULL DEFAULT '0',
  `smt_service` int(5) NOT NULL DEFAULT '0',
  `user` varchar(50) NOT NULL,
  `zuordnung` varchar(50) NOT NULL,
  `beobachter` mediumtext NOT NULL,
  `anhang` varchar(255) NOT NULL,
  `abgabetermin` date NOT NULL,
  `ticket_status` char(25) NOT NULL DEFAULT '0',
  `fortschritt` int(3) NOT NULL DEFAULT '0',
  `prio` char(25) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `zuordnung` (`zuordnung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_password` (
  `id` int(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwort` binary(128) NOT NULL,
  `verwendung` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `private` int(1) NOT NULL,
  `system` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
ALTER TABLE `wos_password`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_password`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

  CREATE TABLE `wos_attachments` (
  `id` int(11) NOT NULL,
  `controller` char(30) NOT NULL,
  `identkey` int(11) NOT NULL,
  `attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `wos_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identkey` (`identkey`);
