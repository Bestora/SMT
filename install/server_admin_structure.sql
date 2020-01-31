SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;

CREATE TABLE `db_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT 'bcfe9e3890e6c26deb554643e208bfb8',
  `status` enum('on','off','new') NOT NULL,
  `rechte` set('usr','mod','adm') NOT NULL DEFAULT 'adm',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sysadmin` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_user_config` (
  `id` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` char(15) NOT NULL,
  `value` varchar(255) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_user_contact` (
  `id` int(11) NOT NULL,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(60) NOT NULL,
  `pushover` varchar(200) NOT NULL,
  `mobile` char(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_user_favorite` (
  `id` int(11) NOT NULL,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `server_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_user_private` (
  `id` int(11) NOT NULL,
  `username` char(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `salutation` char(12) NOT NULL DEFAULT 'Herr',
  `company` varchar(100) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `displayName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_user_secure` (
  `id` int(11) NOT NULL,
  `username` char(100) NOT NULL,
  `countLogin` int(11) NOT NULL,
  `authCode` char(100) NOT NULL,
  `lastLogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastAuthCode` datetime NOT NULL,
  `limitController` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `psm_last_update` (
  `last_update` datetime NOT NULL,
  `counter` int(2) NOT NULL,
  `updatet` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `psm_log` (
  `log_id` int(11) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `type` enum('status','email','sms','pushover','updater') NOT NULL,
  `message` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(255) NOT NULL,
  `messageread` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `psm_servers` (
  `server_id` int(11) UNSIGNED NOT NULL,
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
  `messagebird` enum('yes','no') NOT NULL DEFAULT 'yes',
  `telegram` enum('yes','no') NOT NULL DEFAULT 'yes',
  `warning_threshold` mediumint(1) NOT NULL DEFAULT '1',
  `warning_threshold_counter` mediumint(1) NOT NULL,
  `description` text NOT NULL,
  `home_system` int(11) NOT NULL,
  `end_date` date NOT NULL,
  `warn_date` date NOT NULL,
  `isWarning` int(1) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `psm_servers_history` (
  `servers_history_id` int(11) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `latency_min` float(9,7) NOT NULL,
  `latency_avg` float(9,7) NOT NULL,
  `latency_max` float(9,7) NOT NULL,
  `checks_total` int(11) UNSIGNED NOT NULL,
  `checks_failed` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `psm_servers_uptime` (
  `servers_uptime_id` int(25) UNSIGNED NOT NULL,
  `server_id` int(11) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL,
  `latency` float(9,7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_attachments` (
  `id` int(11) NOT NULL,
  `controller` char(30) NOT NULL,
  `identkey` int(11) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `contenttext` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_config` (
  `id` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `field` char(20) NOT NULL DEFAULT 'text',
  `textvalue` enum('ja','nein') NOT NULL DEFAULT 'nein'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_contract` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `vertragsnummer` char(35) NOT NULL,
  `vertragspartner` varchar(255) NOT NULL,
  `kategorie` varchar(100) NOT NULL,
  `abteilung` varchar(100) NOT NULL,
  `verantwortlicher` char(50) NOT NULL,
  `vertragsbeginn` date NOT NULL,
  `vertragsende` date NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_contract_details` (
  `id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_dns_cron` (
  `id` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `ipadresse` char(15) NOT NULL,
  `hostname` char(100) NOT NULL,
  `serverart` char(120) NOT NULL,
  `meldung` varchar(255) NOT NULL,
  `fehler` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_hardware` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `kategorie` char(100) NOT NULL,
  `inventarnummer` char(100) NOT NULL,
  `kaufdatum` date NOT NULL,
  `hersteller` varchar(255) NOT NULL,
  `modell` varchar(255) NOT NULL,
  `seriennummer` char(100) NOT NULL,
  `zuordnung` char(100) NOT NULL,
  `beschreibung` text NOT NULL,
  `inventur` enum('ja','nein') NOT NULL DEFAULT 'ja'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_hardware_details` (
  `id` int(11) NOT NULL,
  `hardware_id` int(11) NOT NULL,
  `form_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `form_value` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_international` (
  `id` varchar(10) NOT NULL DEFAULT '',
  `aktiv` enum('ja','nein') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_inventur` (
  `id` int(11) NOT NULL,
  `barcode` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_knowledge` (
  `id` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `uploads` varchar(255) NOT NULL,
  `visible` int(1) NOT NULL DEFAULT '1',
  `version` decimal(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_knowledge_history` (
  `id` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `version` decimal(2,1) NOT NULL,
  `datum` datetime NOT NULL,
  `user` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_language_de` (
  `id` int(11) NOT NULL,
  `text_name` char(60) NOT NULL,
  `text_value` text NOT NULL,
  `art` enum('sys','usr','not') NOT NULL DEFAULT 'sys'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_license` (
  `id` int(11) NOT NULL,
  `hersteller` varchar(200) NOT NULL,
  `produkt` varchar(200) NOT NULL,
  `version` char(50) NOT NULL,
  `licensekey` varchar(255) NOT NULL,
  `anzahl` int(5) NOT NULL,
  `beschreibung` text NOT NULL,
  `vmware` int(11) NOT NULL DEFAULT '0',
  `barcode` varchar(200) NOT NULL,
  `zuordnung` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_news` (
  `id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` char(20) CHARACTER SET latin1 NOT NULL,
  `titel` varchar(255) CHARACTER SET tis620 COLLATE tis620_bin NOT NULL,
  `nachricht` text CHARACTER SET latin1 NOT NULL,
  `controller` char(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_password` (
  `id` int(255) NOT NULL,
  `user` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwort` binary(128) NOT NULL,
  `verwendung` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `private` int(1) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_server` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `inventarnummer` char(30) NOT NULL,
  `hostname` char(100) NOT NULL,
  `aliase` varchar(255) NOT NULL,
  `ipadressen` char(50) NOT NULL,
  `standort` char(255) NOT NULL,
  `betriebssystem` varchar(255) NOT NULL,
  `technischedaten` varchar(255) NOT NULL,
  `verwendungszweck` varchar(255) NOT NULL,
  `beschreibung` text NOT NULL,
  `serverart` enum('server','vmware') NOT NULL,
  `service_relations` char(50) NOT NULL,
  `live_dns` enum('on','off') NOT NULL DEFAULT 'on',
  `prio` int(1) NOT NULL,
  `wartung` tinyint(1) NOT NULL DEFAULT '0',
  `monitor` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `wos_server_dnsip` (
  `id` int(11) NOT NULL,
  `ip` char(15) NOT NULL,
  `port` char(25) NOT NULL,
  `hostname` char(40) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_server_ports` (
  `id` int(11) NOT NULL,
  `lastcheck` datetime NOT NULL,
  `ipadresse` char(20) NOT NULL,
  `port` int(5) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `beschreibung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_standby` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `kw` int(2) NOT NULL,
  `is_public_holiday` tinyint(4) NOT NULL,
  `username` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wos_system_details` (
  `id` int(11) NOT NULL,
  `systemid` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL,
  `form_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `wos_ticket` (
  `id` int(11) NOT NULL,
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
  `prio` char(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `db_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`);

ALTER TABLE `db_user_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

ALTER TABLE `db_user_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

ALTER TABLE `db_user_favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

ALTER TABLE `db_user_private`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

ALTER TABLE `db_user_secure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

ALTER TABLE `psm_log`
  ADD PRIMARY KEY (`log_id`);

ALTER TABLE `psm_servers`
  ADD PRIMARY KEY (`server_id`);

ALTER TABLE `psm_servers_history`
  ADD PRIMARY KEY (`servers_history_id`),
  ADD UNIQUE KEY `server_id_date` (`server_id`,`date`);

ALTER TABLE `psm_servers_uptime`
  ADD PRIMARY KEY (`servers_uptime_id`),
  ADD UNIQUE KEY `servers_uptime_id` (`servers_uptime_id`),
  ADD KEY `server_id` (`server_id`);

ALTER TABLE `wos_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `identkey` (`identkey`);

ALTER TABLE `wos_config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key` (`id`);

ALTER TABLE `wos_contract`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `bezeichnung` (`bezeichnung`),
  ADD KEY `vertragspartner` (`vertragspartner`);

ALTER TABLE `wos_dns_cron`
  ADD PRIMARY KEY (`id`),
  ADD KEY `server_id` (`sid`),
  ADD KEY `sid` (`sid`);

ALTER TABLE `wos_hardware`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_hardware_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_international`
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `wos_inventur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `id` (`id`),
  ADD KEY `barcode_2` (`barcode`);

ALTER TABLE `wos_knowledge`
  ADD UNIQUE KEY `page_name` (`page_name`),
  ADD KEY `id` (`id`);

ALTER TABLE `wos_knowledge_history`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_language_de`
  ADD PRIMARY KEY (`id`),
  ADD KEY `text_name` (`text_name`);

ALTER TABLE `wos_license`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_news`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_password`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_server`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hostname` (`hostname`),
  ADD UNIQUE KEY `ipadressen` (`ipadressen`),
  ADD KEY `id` (`id`);

ALTER TABLE `wos_server_dnsip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

ALTER TABLE `wos_server_ports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ipadresse` (`ipadresse`);

ALTER TABLE `wos_standby`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`),
  ADD KEY `username` (`username`);

ALTER TABLE `wos_system_details`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wos_ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zuordnung` (`zuordnung`);


ALTER TABLE `db_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_user_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_user_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_user_favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_user_private`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_user_secure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `psm_log`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `psm_servers`
  MODIFY `server_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `psm_servers_history`
  MODIFY `servers_history_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `psm_servers_uptime`
  MODIFY `servers_uptime_id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_contract`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_dns_cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_hardware`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_hardware_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_inventur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_knowledge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_knowledge_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_language_de`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_password`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_server_dnsip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_server_ports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_standby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_system_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `wos_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
