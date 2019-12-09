-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Nov 2016 um 23:25
-- Server-Version: 10.1.16-MariaDB
-- PHP-Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `server_admin`
--

--
-- Daten für Tabelle `db_user`
--

INSERT INTO `db_user` (`id`, `username`, `password`, `status`, `rechte`, `timestamp`) VALUES
(2, 'E673A64B-38A1-2F13-C45D-927F207AE309', '21232f297a57a5a743894a0e4a801fc3', 'on', 'adm', '2016-11-25 22:21:14');

--
-- Daten für Tabelle `db_user_config`
--

INSERT INTO `db_user_config` (`id`, `username`, `name`, `value`, `info`) VALUES
(2, 'E673A64B-38A1-2F13-C45D-927F207AE309', 'ldap_auth', 'wos', '');

--
-- Daten für Tabelle `db_user_contact`
--

INSERT INTO `db_user_contact` (`id`, `username`, `email`, `pushover`) VALUES
(2, 'E673A64B-38A1-2F13-C45D-927F207AE309', 'admin', '');

--
-- Daten für Tabelle `db_user_private`
--

INSERT INTO `db_user_private` (`id`, `username`, `salutation`, `company`, `lastname`, `firstname`, `displayName`) VALUES
(2, 'E673A64B-38A1-2F13-C45D-927F207AE309', 'Herr', 'SMT by palle', 'Administrator', 'Admin', 'Admin Administrator');

--
-- Daten für Tabelle `db_user_secure`
--

INSERT INTO `db_user_secure` (`id`, `username`, `countLogin`, `authCode`, `lastLogin`, `lastAuthCode`, `limitController`) VALUES
(2, 'E673A64B-38A1-2F13-C45D-927F207AE309', 30, '', '2016-11-25 22:16:26', '0000-00-00 00:00:00', '');

--
-- Daten für Tabelle `wos_config`
--

INSERT INTO `wos_config` (`id`, `value`, `field`, `textvalue`) VALUES
('allowed_controller_without_pass', 'cronjob,overview,inventur', 'text', 'nein'),
('authentication', 'intern', 'text', 'nein'),
('auto_refresh_servers', '60', 'text', 'nein'),
('fast_port_scanner', '5000', 'text', 'nein'),
('hardware_kategorie', 'hardware_kategorie_notebook,hardware_kategorie_telefon,hardware_kategorie_monitor,hardware_kategorie_drucker,hardware_kategorie_exthdd,hardware_kategorie_sonstiges,hardware_kategorie_server,hardware_kategorie_beamer,hardware_kategorie_handy', 'text', 'ja'),
('ip_adress_bereich', '192.168.0', 'text', 'nein'),
('ldap_dn', 'DC=SYSTEM,DC=DOMAIN', 'text', 'nein'),
('ldap_host', '', 'text', 'nein'),
('ldap_manager_group', 'SMT', 'text', 'nein'),
('ldap_pass', '', 'password', 'nein'),
('ldap_user', '', 'text', 'nein'),
('ldap_user_group', 'Users', 'text', 'nein'),
('ldap_usr_dom', '@system.domain', 'text', 'nein'),
('only_admin_methode', 'license,admin,hardware', 'text', 'nein'),
('pushover_api_token', '', 'text', 'nein'),
('messagebird_api_token', '', 'text', 'nein'),
('messsagebird_flowtoken', '', 'text', 'nein'),
('ticket_prio', 'ticket_prio_niedrig,ticket_prio_normal,ticket_prio_hoch', 'text', 'ja'),
('ticket_status', 'ticket_status_offen,ticket_status_planung,ticket_status_arbeit,ticket_status_feedback,ticket_status_fertig,ticket_status_geschlossen', 'text', 'ja'),
('version', '2.1', 'hidden', 'nein'),
('monitor_email_address', 'absender@domain.de', '', 'nein'),
('controller', 'server,administration,inventory,knowledge,ticket,monitor', 'text', 'nein'),
;

INSERT INTO `wos_config` (`id`, `value`, `field`, `textvalue`) VALUES ('allowed_auto_system_ip', 'on', 'text', 'nein');
INSERT INTO `wos_config` (`id`, `value`, `field`, `textvalue`) VALUES ('allowed_auto_system_port', 'on', 'text', 'nein');


--
-- Daten für Tabelle `wos_international`
--

INSERT INTO `wos_international` (`id`, `aktiv`) VALUES
('cz', 'nein'),
('de', 'ja'),
('dk', 'nein'),
('en', 'nein'),
('es', 'nein'),
('fi', 'nein'),
('fr', 'nein'),
('hu', 'nein'),
('it', 'nein'),
('nl', 'nein'),
('no', 'nein'),
('pl', 'nein'),
('ru', 'nein'),
('se', 'nein'),
('tr', 'nein');

INSERT INTO `wos_language_de` (`id`, `text_name`, `text_value`, `art`) VALUES
(1, 'home_first_nav', 'SMT Monitor', 'sys'),
(2, 'home_second_nav', 'IT Systeme', 'sys'),
(3, 'home_third_nav', 'Virtuelle Systeme', 'sys'),
(4, 'home_fourth_nav', 'IT Infrastruktur', 'sys'),
(5, 'off_email_body', 'Kann keine funktionierende Verbindung zum Dienst bzw. der Webseite aufbauen:<br/><br/>Dienst/Webseite: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(6, 'off_email_subject', 'Warnung: Dienst/Webseite \'%LABEL%\' ist offline.', 'not'),
(7, 'off_pushover_message', 'Kann keine funktionierende Verbindung zum Dienst bzw. der Webseite aufbauen:<br/><br/>Dienst/Webseite: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(8, 'off_pushover_title', 'Dienst/Webseite \'%LABEL%\' ist offline.', 'not'),
(9, 'on_email_body', 'Dienst/Webseite \'%LABEL%\' ist wieder erreichbar:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(10, 'on_email_subject', 'Hinweis: Dienst/Webseite \'%LABEL%\' ist wieder online.', 'not'),
(11, 'on_pushover_message', 'Dienst/Webseite \'%LABEL%\' ist wieder erreichbar:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(12, 'on_pushover_title', 'Dienst/Webseite \'%LABEL%\' ist wieder online.', 'not'),
(14, 'warn_email_body', 'Dienst/Webseite \'%LABEL%\' läuft aus: %END_DATE%:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(15, 'warn_email_subject', 'Hinweis: Dienst/Webseite \'%LABEL%\' läuft demnächst ab !', 'not'),
(16, 'warn_pushover_message', 'Dienst/Webseite \'%LABEL%\' läuft aus: %END_DATE%:<br/><br/>Server: %LABEL%<br/>IP: %IP%<br/>Port: %PORT%<br/>Datum: %DATE% Uhr', 'not'),
(17, 'warn_pushover_title', 'Hinweis: Dienst/Webseite \'%LABEL%\' läuft demnächst ab !', 'not'),
(18, 'my_account', 'Mein Konto', 'sys'),
(19, 'logout', 'Ausloggen', 'sys'),
(20, 'nav_submenu', 'Untermenü', 'sys'),
(21, 'nav_administration', 'Administration', 'sys'),
(22, 'nav_home_updater', 'Systeme aktualisieren', 'sys'),
(23, 'nav_inventar_hardware', 'Hardwareverwaltung', 'sys'),
(24, 'nav_inventar_license', 'Lizenzmanagement', 'sys'),
(25, 'nav_inventar_logfile', 'Logfile Monitoring', 'sys'),
(26, 'nav_inventar_dns', 'DNS Check', 'sys'),
(27, 'nav_inventar_ip', 'IP Adressliste', 'sys'),
(28, 'nav_inventar_services', 'Alle Services', 'sys'),
(29, 'nav_server_liste', 'Liste aller Devices', 'sys'),
(30, 'nav_server_new', 'Neues Device', 'sys'),
(31, 'nav_vmware_liste', 'Liste der virtuellen Maschinen', 'sys'),
(32, 'nav_vmware_new', 'Neues Image eintragen', 'sys'),
(33, 'vmware_status_title', 'Hier eine Übersicht aller Systeme (Virtuelle Maschinen)', 'sys'),
(34, 'vmware_detail_edit', 'System bearbeiten', 'sys'),
(35, 'vmware_link_wartung_on', 'System in Wartung stellen, Benachrichtigungen werden ausgeschaltet', 'sys'),
(36, 'vmware_wartung_on', 'Wartung einschalten', 'sys'),
(37, 'vmware_link_wartung_off', 'Wartung abschalten, Benachrichtigungen werden eingeschaltet', 'sys'),
(38, 'vmware_wartung_off', 'Wartung ausschalten', 'sys'),
(39, 'user_admin_config_title', 'Systemkonfiguration bearbeiten', 'sys'),
(40, 'user_admin_password_placeholder', 'Aktuelles Passwort wird hier nicht dargestellt', 'sys'),
(41, 'user_admin_submit', 'Änderung speichern', 'sys'),
(43, 'user_admin_news_form_title', 'Titel und Inhalt der neuen Nachricht', 'sys'),
(44, 'user_admin_news_title_placeholder', 'Titel der Nachricht', 'sys'),
(45, 'user_admin_news_select_option_1', 'Alle Seiten', 'sys'),
(47, 'user_admin_news_select_option_3', 'Server Management', 'sys'),
(48, 'user_admin_news_select_option_4', 'Vmware Management', 'sys'),
(49, 'user_admin_news_select_option_5', 'IT Inventory', 'sys'),
(50, 'user_admin_news_select_option_6', 'Monitoring', 'sys'),
(51, 'user_admin_news_submit_new', 'Neue Nachricht speichern', 'sys'),
(52, 'user_admin_news_select_option_2', 'Startseite', 'sys'),
(53, 'user_admin_news_submit_edit', 'Änderung speichern', 'sys'),
(54, 'user_admin_news_link_del', 'Soll dieser Eintrag wirklich gelöscht werden ???\\nDer Inhalt ist dann unwiderruflich weg!!!', 'sys'),
(55, 'user_admin_news_del', 'Nachricht löschen', 'sys'),
(56, 'user_admin_texte_new', 'Neuen Textbaustein anlegen', 'sys'),
(57, 'nav_inventur', 'Inventur durchführen', 'sys'),
(58, 'home_fifth_nav', 'Knowledge Base', 'sys'),
(59, 'nav_submenu_knowledge', 'Knowledge Base', 'sys'),
(60, 'inventory_hardware_category', 'Kategorie', 'sys'),
(61, 'inventory_hardware_manufacturer', 'Hersteller', 'sys'),
(62, 'inventory_hardware_model', 'Modell', 'sys'),
(63, 'inventory_hardware_inventory', 'Inventar', 'sys'),
(64, 'inventory_hardware_assignment', 'Zuordnung', 'sys'),
(67, 'inventory_hardware_total_records', 'Einträge gesamt', 'sys'),
(69, 'inventory_hardware_delete', 'Soll dieser Eintrag wirklich gelöscht werden ???\\nDer Inhalt ist dann unwiderruflich weg!!!', 'sys'),
(70, 'inventory_hardware_new_save', 'Hardware speichern', 'sys'),
(72, 'inventory_license_list_number', 'Anzahl', 'sys'),
(73, 'inventory_license_list_product', 'Produkt', 'sys'),
(74, 'inventory_license_list_key', 'Lizenzkey', 'sys'),
(75, 'system_next_page', 'zur nächsten Seite', 'sys'),
(76, 'system_previous_page', 'zur vorherigen Seite', 'sys'),
(77, 'system_total_records', 'Einträge gesamt', 'sys'),
(78, 'system_cancel', 'Abbrechen', 'sys'),
(79, 'inventory_license_new_save', 'Lizenz speichern', 'sys'),
(80, 'inventory_host', 'Hostname', 'sys'),
(81, 'inventory_ip', 'IP Adresse', 'sys'),
(82, 'inventory_message', 'Meldung', 'sys'),
(83, 'inventory_dns_system_type', 'Systemart', 'sys'),
(84, 'inventory_dns_new', 'DNS Eintrag', 'sys'),
(85, 'inventory_dns_action', 'Aktion', 'sys'),
(86, 'inventory_portscan', 'Portscan starten', 'sys'),
(87, 'inventory_total_services', 'Dienste gesamt', 'sys'),
(88, 'monitor_detail_service_edit', 'Dienst/Service bearbeiten', 'sys'),
(89, 'monitor_overview_show_systemdetails', 'Systemdetails anzeigen', 'sys'),
(90, 'monitior_overview_page_refresh', 'Aktualisierung der Seite', 'sys'),
(91, 'monitior_overview_last_check', 'Letzter Check', 'sys'),
(92, 'monitior_overview_seconds', 'Sekunden', 'sys'),
(93, 'monitior_overview_server_management', 'Zum Server Management Tool', 'sys'),
(94, 'monitior_overview_monitoring', 'Monitoring', 'sys'),
(95, 'monitior_overview_ip', 'IP', 'sys'),
(96, 'monitor_overview_last_text', 'Letzte Prüfung', 'sys'),
(97, 'monitor_overview_last_online', 'Zuletzt Online', 'sys'),
(98, 'monitor_overview_rtime', 'Reaktionszeit', 'sys'),
(99, 'monitor_overview_configured_depende', 'Konfigurierte Abhängigkeiten zum System', 'sys'),
(100, 'monitor_overview_system_online', 'System ist Online', 'sys'),
(101, 'monitor_overview_system_offline', 'System ist Offline', 'sys'),
(102, 'monitor_overview_system_maintenance', 'Wartungsmodus', 'sys'),
(103, 'monitor_overview_one_of_its_depende', 'Eine Abhänigkeit ist nicht erfüllt', 'sys'),
(104, 'monitor_overview_unimportant_system', 'Unwichtiges System mit Fehler', 'sys'),
(105, 'monitor_service_designation', 'Bezeichnung', 'sys'),
(106, 'monitor_service_monitoring', 'Art der Überwachung', 'sys'),
(107, 'monitor_service_service', 'Service/Dienst', 'sys'),
(108, 'monitor_service_website', 'Website', 'sys'),
(109, 'monitor_service_expires', 'Ablaufdatum/Errinnerung', 'sys'),
(110, 'monitor_service_date', 'Datum (Ende)', 'sys'),
(111, 'monitor_service_date_warning', 'Datum (Warnung)', 'sys'),
(112, 'monitor_service_ip', 'IP Adresse', 'sys'),
(113, 'monitor_service_port', 'Port', 'sys'),
(114, 'monitor_service_searchpattern', 'Suchmuster', 'sys'),
(115, 'monitor_service_mo_and_no', 'Monitoring und Benachrichtigungen', 'sys'),
(116, 'monitor_service_user_notification', 'Folgender Benutzer informieren', 'sys'),
(117, 'monitor_service_push_notification', 'Push Notification', 'sys'),
(118, 'monitor_service_push_on', 'Push Notification einschalten', 'sys'),
(119, 'monitor_service_push_off', 'Push Notification ausschalten', 'sys'),
(120, 'monitor_service_push_mail', 'E-Mail Benachrichtigung', 'sys'),
(121, 'monitor_service_push_mail_on', 'E-Mail Benachrichtigung einschalten', 'sys'),
(122, 'monitor_service_push_mail_off', 'E-Mail Benachrichtigung ausschalten', 'sys'),
(123, 'monitor_service_system_description', 'Beschreibung des Systems', 'sys'),
(124, 'monitor_service_service_save', 'Service speichern', 'sys'),
(125, 'monitor_service_save_dependence', 'Abhänigkeit speichern', 'sys'),
(126, 'monitor_service_dependence_selectio', 'Oder vorhandenen Service als Abhängigkeit definieren (Mehrfachauswahl mit STRG)', 'sys'),
(127, 'monitor_service_monitoring_on', 'Monitoring aktivieren', 'sys'),
(128, 'monitor_service_without_monitoring', 'Service ohne Monitoring', 'sys'),
(129, 'inventory_hardware_designation', 'Bezeichnung', 'sys'),
(130, 'inventory_hardware_new_details', 'Details zur Hardware', 'sys'),
(131, 'inventory_hardware_inventorynumber', 'Inventarnummer', 'sys'),
(132, 'inventory_hardware_new_serial_numbe', 'Seriennummer', 'sys'),
(133, 'inventory_hardware_date_purchase', 'Kaufdatum', 'sys'),
(134, 'inventory_hardware_description', 'Beschreibung', 'sys'),
(135, 'inventory_license_license_data', 'Lizenzdaten erfassen', 'sys'),
(136, 'inventory_license_barcode', 'Barcode', 'sys'),
(137, 'inventory_license_license_descripti', 'Details zum Produkt sowie der Lizenz erfassen', 'sys'),
(138, 'inventory_license_version', 'Version', 'sys'),
(139, 'inventory_license_key_number', 'Key, Anzahl und Beschreibung', 'sys'),
(140, 'inventory_license_licensekey', 'Lizenzschlüssel', 'sys'),
(141, 'inventory_license_assigning_license', 'Lizenz einem Benutzer und/oder einem virtuellen System zuordnen', 'sys'),
(142, 'inventory_license_new_user', 'Benutzer', 'sys'),
(143, 'inventory_license_mapping_image', 'Zuordnung Image', 'sys'),
(144, 'monitor_status_number_monitoring', 'Monitoring', 'sys'),
(145, 'structure_history_availability', 'Statistik und Verfügbarkeit des Dienstes', 'sys'),
(146, 'structure_inventory_all_services', 'Liste aller konfigurierten Services', 'sys'),
(147, 'inventory_hardware_more', 'Freifelder erzeugen für weitere Informationen', 'sys'),
(148, 'structure_search', 'Search the site', 'sys'),
(149, 'structure_details_details', 'Details zu', 'sys'),
(150, 'structure_details_aliase', 'Aliase', 'sys'),
(151, 'structure_details_location', 'Standort', 'sys'),
(152, 'structure_details_os', 'Betriebssystem', 'sys'),
(153, 'structure_details_hardware', 'Technische Ausstattung', 'sys'),
(154, 'structure_details_use', 'Verwendungszeck', 'sys'),
(155, 'structure_details_more', 'Weitere Systemdetails', 'sys'),
(156, 'structure_form_new_system', 'Neues System erfassen', 'sys'),
(157, 'structure_form_priority', 'Priorität', 'sys'),
(158, 'structure_form_critical_system', 'Kritisches System', 'sys'),
(159, 'structure_form_important_system', 'Wichtiges System', 'sys'),
(160, 'structure_form_unimportant_sy', 'Unwichtiges System', 'sys'),
(161, 'structure_form_critical', 'Kritisch (wird jede Minute geprüft)', 'sys'),
(162, 'structure_form_important', 'Wichtig (wird alle 5 Minuten geprüft)', 'sys'),
(163, 'structure_form_standard', 'Standard (wird alle 10 Minuten geprüft)', 'sys'),
(164, 'inventory_hardware_info', 'Grundinformationen erfassen', 'sys'),
(165, 'inventory_hardware_if_empty', 'Wenn leer wird es automatisch ergänzt (Hersteller+Modell+(Zuordnung/Inventarnummer))...', 'sys'),
(166, 'inventory_license_placeholder', 'Leer lassen wenn es keinen gibt', 'sys'),
(167, 'inventory_license_software', 'Microsoft, VMWare oder soetwas', 'sys'),
(168, 'inventory_license_comment', 'Freifeld für Beschreibung oder sonstige Informationen ...', 'sys'),
(169, 'inventory_hardware_where', 'Wo steht es / Wer benutzt es', 'sys'),
(170, 'structur_metatags_placeholder', 'Key / Namen angeben Beispiel: Datenbank', 'sys'),
(171, 'structure_metatags_value', 'Hier den Wert zu dem Namen einegeben', 'sys'),
(172, 'structure_metatags_systemoverview', 'Systemübersicht', 'sys'),
(173, 'structure_form_unimportant', 'Unwichtig (wird alle 15 Minuten geprüft)', 'sys'),
(174, 'structure_form_standard_system', 'Standardpriorität', 'sys'),
(175, 'structure_form_free_space', 'Frei wählbare Bezeichnung ...', 'sys'),
(176, 'structure_form_host', 'Echten Hostnamen eingeben ...', 'sys'),
(177, 'structure_form_value', 'Kommagetrennte Werte eingeben (Alias1, Alias2 ...)', 'sys'),
(178, 'structure_form_ip', '10.0.x.x (Primäre zuerst, kommagetrennt)', 'sys'),
(179, 'structure_form_hardware', 'Technische Spezifikationen (Achte auf korrekte Werte)', 'sys'),
(180, 'structure_form_activ_dns_check', 'Aktiver DNS Check', 'sys'),
(181, 'structure_form_deactivate', 'Nein, deaktivieren', 'sys'),
(182, 'structure_form_activate', 'Ja, aktivieren', 'sys'),
(183, 'structure_form_hardware_info', 'Technische Informationen', 'sys'),
(184, 'structure_form_placeholder_loc', 'Standort oder ggf. VM Server Bezeichnung', 'sys'),
(185, 'structure_form_more_info', 'Weitere Informationen', 'sys'),
(186, 'structure_form_server_save', 'Server speichern', 'sys'),
(187, 'structure_list_total_systems', 'Systeme gesamt', 'sys'),
(188, 'structure_list_system_configuration', 'Konfigurierte Dienste / Services / Reminder für des Systems', 'sys'),
(189, 'structure_list_depende_system', 'Abhängigkeiten des Systems', 'sys'),
(190, 'structure_list_delet', 'Soll die Anhängigkeit wirklich entfernt werden ???', 'sys'),
(191, 'structure_sub_mypage', 'MyPage', 'sys'),
(192, 'structure_sub_mydata', 'Meine Daten', 'sys'),
(193, 'structure_sub_config', 'Konfiguration', 'sys'),
(194, 'structure_sub_users', 'Benutzerverwaltung', 'sys'),
(195, 'structure_sub_text_edit', 'Texte verwalten', 'sys'),
(196, 'structure_sub_messages', 'Nachrichten bearbeiten', 'sys'),
(197, 'structure_system_type', 'Typ', 'sys'),
(198, 'structure_system_status', 'Status', 'sys'),
(199, 'structure_system_monitor', 'Monitor', 'sys'),
(200, 'structure_system_pushover', 'Pushover', 'sys'),
(201, 'structure_system_email', 'Email', 'sys'),
(202, 'structure_system_message', 'Nachricht', 'sys'),
(203, 'structure_system_date_time', 'Datum/Zeit', 'sys'),
(204, 'structure_system_date', 'Datum', 'sys'),
(205, 'structure_system_dns_info', 'DNS Informationen', 'sys'),
(206, 'structure_system_real_host', 'Echter Hostname', 'sys'),
(207, 'structure_system_portscan', 'Portscan', 'sys'),
(208, 'system_blaetter_entry', 'Eintrag', 'sys'),
(209, 'system_blaetter_until', 'bis', 'sys'),
(210, 'system_blaetter_from', 'von', 'sys'),
(211, 'admin_texte_edit', 'Texte bearbeiten', 'sys'),
(212, 'admin_language', 'Sprachen', 'sys'),
(213, 'admin_text_save', 'speichern', 'sys'),
(214, 'user_admin_salutation', 'Anrede', 'sys'),
(215, 'user_admin_data_saved', 'Daten erfolgreich gespeichert ...', 'sys'),
(216, 'user_admin_wrong_password', 'Passwörter stimmen nicht überein, nicht gespeichert', 'sys'),
(217, 'user_admin_general_data', 'Allgemeine Daten', 'sys'),
(218, 'user_admin_man', 'Herr', 'sys'),
(219, 'user_admin_woman', 'Frau', 'sys'),
(220, 'user_admin_last_name', 'Nachname', 'sys'),
(221, 'user_admin_first_name', 'Vorname', 'sys'),
(222, 'user_admin_company', 'Firma', 'sys'),
(223, 'user_admin_contact_info', 'Kontaktinformationen', 'sys'),
(224, 'user_admin_email', 'Email Adresse', 'sys'),
(225, 'user_admin_push_api_key', 'Pushover API Key', 'sys'),
(226, 'user_admin_change_password', 'Passwort ändern', 'sys'),
(227, 'user_admin_enter_password', 'Passwort eingeben', 'sys'),
(228, 'user_admin_confirm_pw', 'Passwort bestätigen', 'sys'),
(229, 'user_admin_admin', 'Administrator', 'sys'),
(230, 'user_admin_manager', 'Manager', 'sys'),
(231, 'user_admin_user', 'Standarduser', 'sys'),
(232, 'user_admin_save_data', 'Daten speichern', 'sys'),
(233, 'user_admin_rights', 'Rechte', 'sys'),
(234, 'user_admin_user_del', 'Soll dieser Benutzer wirklich gelöscht werden ???\\nDer Inhalt ist dann unwiderruflich weg!!!', 'sys'),
(235, 'user_admin_user_total', 'Benutzer gesamt', 'sys'),
(236, 'user_smt_login', 'SMT Login', 'sys'),
(237, 'user_login', 'Login', 'sys'),
(238, 'template_inventory_clear', 'Inventur löschen', 'sys'),
(239, 'template_inventory_user', 'User', 'sys'),
(240, 'template_inventory_warning', 'Soll die Inventur zurückgesetzt werden???\\nAlle bisher eingescannten Geräte sind dann weg!!!', 'sys'),
(241, 'template_inventory_site_menu', 'Name der Seite, Darstellung für das Menü', 'sys'),
(242, 'template_inventory_search_help', 'Schlagworte, Kommagetrennte Eingabe', 'sys'),
(243, 'template_inventory_save_contributio', 'Beitrag speichern', 'sys'),
(244, 'structure_search_placeholder', 'Suche ...', 'sys'),
(245, 'structure_search_search', 'Suche', 'sys'),
(246, 'structure_search_searchtext', 'Volltextsuche', 'sys'),
(247, 'monitor_service_new_service', 'Neuen Dienst erfassen', 'sys'),
(248, 'inventory_license_scan', 'Scan', 'sys'),
(249, 'inventory_license_new_dns_test', 'DNS System neu prüfen', 'sys'),
(250, 'inventory_license_update_dns', 'DNS aktualisieren', 'sys'),
(251, 'monitor_reload_page', 'Seite neu laden', 'sys'),
(252, 'monitor_service_server_details', 'Systemdetails anzeigen', 'sys'),
(253, 'structure_sy_managment_tool', 'System Management Tool', 'sys'),
(254, 'structure_activ_monitoring', 'Monitoring ist aktiv', 'sys'),
(255, 'structure_email_message_on', 'E-Mail Benachrichtigung ist eingeschaltet', 'sys'),
(256, 'structure_push_message_on', 'Pushover Notification ist eingeschaltet', 'sys'),
(257, 'structure_del_service', 'Service löschen', 'sys'),
(258, 'structur_system_del', 'System löschen', 'sys'),
(259, 'structure_new_license', 'Neue Lizenz erfassen', 'sys'),
(260, 'structure_depende_del', 'Abhänigkeit löschen', 'sys'),
(261, 'structure_collect_details', 'Details erfassen', 'sys'),
(262, 'structur_del_search', 'Filter löschen und alle Einträge anzeigen', 'sys'),
(263, 'structure_new', 'Neuen Beitrag verfassen', 'sys'),
(264, 'system_blaetter_alt', 'vorherige Seite', 'sys'),
(265, 'system_blaetter_alt_next', 'naechste Seite', 'sys'),
(266, 'user_admin_text_edit', 'bearbeiten', 'sys'),
(267, 'user_admin_list_edit_user', 'Benutzer bearbeiten', 'sys'),
(268, 'user_admin_del_user', 'Benutzer löschen', 'sys'),
(269, 'user_admin_login_placeholder', 'Email Adresse oder LDAP Use', 'sys'),
(270, 'user_admin_login_placeholde_pw', 'Passwort', 'sys'),
(271, 'inventory_license_new_workspace', 'Office, Project oder Workstation', 'sys'),
(272, 'inventory_license_new_version', '2010 Home & Student, 2013 oder 12 Pro', 'sys'),
(273, 'inventory_portscan_start', 'Startport', 'sys'),
(274, 'inventory_portscan_end', 'Endport', 'sys'),
(275, 'inventory_service_show_off', 'Wenn das gesuchte Muster nicht in der Webseite ist, wird die Seite als offline markiert.', 'sys'),
(276, 'inventory_service_portnumber', 'Portnummer (z.b. 28000) ...', 'sys'),
(277, 'inventory_detail_system_maintenance', 'System in Wartung stellen', 'sys'),
(278, 'inventory_detail_maintenance_off', 'Wartung abschalten', 'sys'),
(279, 'inventory_server_fav_save', 'Als Favorit speichern (mypage)', 'sys'),
(280, 'inventory_server_fav_del', 'Aus meinen Favoriten entfernen', 'sys'),
(281, 'inventory_server_mt_off', 'Wartungsmodus abschalten', 'sys'),
(282, 'structure_inv_service_download', 'Download als CSV', 'sys'),
(283, 'inventory_hardware_placeholder', 'z.b. Dell', 'sys'),
(285, 'structure_form_os', 'Windows Server 2008 R2 oder Linux Debian 8 ...', 'sys'),
(287, 'structure_form_details_use', 'VM Server, Primärer AD, Mailserver, Filesharing etc ...', 'sys'),
(288, 'structure_service_new', 'Neuen Service anlegen', 'sys'),
(289, 'structure_form_new_dep', 'Neue Abhängigkeit definieren', 'sys'),
(290, 'user_admin_name', 'Variable / Name', 'sys'),
(291, 'user_admin_inventory', 'Inhalt eingeben', 'sys'),
(292, 'template_knowledge_fast_words', 'Schlagworte', 'sys'),
(293, 'template_knowledge_del', 'Eintrag löschen', 'sys'),
(294, 'empty_logfiles', 'Logfile Einträge leeren', 'sys'),
(295, 'structure_new_user', 'Neuen Benutzer anlegen', 'sys'),
(296, 'user_admin_texte_installed', 'Folgende Sprachen können aktiviert werden, bitte anklicken', 'sys'),
(297, 'user_admin_texte_hinweis', 'Nach dem Klick, bzw. der Aktivierung wird eine neue Tabelle in der Datenbank angelegt (wos_language_dk) und die Inhalte aus dem deutschen kopiert. Danach muss der Inhalt entsprechend übersetzt werden, wenn man also eine Sprache löscht / deaktiviert wird dieser Inhalt dann auch wieder vollständig entfernt', 'sys'),
(298, 'user_admin_texte_installing', 'Bitte mit OK die Installation der Sprache bestätigen, kann einige Sekunden dauern (bitte nicht abbrechen)', 'sys'),
(301, 'user_admin_text_delete', 'Diesen Textbaustein aus allen Sprachtabellen löschen', 'sys'),
(302, 'knowledge_upload_hinweis', 'Folgende Dateien wurden dem Eintrag hinzugefügt', 'sys'),
(303, 'home_six_nav', 'Ticketsystem', 'sys'),
(304, 'new_ticket', 'Neues Ticket aufgeben', 'sys'),
(305, 'list_ticket', 'Liste aller Tickets', 'sys'),
(306, 'ticket_status_offen', 'Offen', 'sys'),
(307, 'ticket_status_planung', 'in Planung', 'sys'),
(308, 'ticket_status_arbeit', 'In Arbeit', 'sys'),
(309, 'ticket_status_feedback', 'Feedback', 'sys'),
(310, 'ticket_status_fertig', 'Erledigt', 'sys'),
(311, 'ticket_status_geschlossen', 'Geschlossen', 'sys'),
(312, 'ticket_prio_niedrig', 'Niedrig', 'sys'),
(313, 'ticket_prio_normal', 'Normal', 'sys'),
(314, 'ticket_prio_hoch', 'Hoch', 'sys'),
(315, 'hardware_kategorie_notebook', 'Notebook', 'sys'),
(316, 'hardware_kategorie_telefon', 'Telefon', 'sys'),
(317, 'hardware_kategorie_monitor', 'Monitor', 'sys'),
(318, 'hardware_kategorie_drucker', 'Drucker', 'sys'),
(319, 'hardware_kategorie_exthdd', 'Externe HDD', 'sys'),
(320, 'hardware_kategorie_handy', 'Mobiltelefon', 'sys'),
(321, 'hardware_kategorie_sonstiges', 'Sonstiges', 'sys'),
(322, 'hardware_kategorie_server', 'Server', 'sys'),
(323, 'hardware_kategorie_beamer', 'Beamer', 'sys'),
(324, 'ticket_titel', 'Titel des Ticket', 'sys'),
(325, 'ticket_beschreibung', 'Beschreibung', 'sys'),
(326, 'ticket_abgabe_datum', 'Abgabedatum', 'sys'),
(327, 'ticket_zuordnung', 'Zuordnung', 'sys'),
(328, 'ticket_beobachter', 'Beobachter', 'sys'),
(329, 'ticket_system', 'Betroffenes System', 'sys'),
(330, 'ticket_dienst', 'Betroffener Dienst', 'sys'),
(331, 'ticket_prio', 'Priorität', 'sys'),
(332, 'ticket_anhang', 'Dateianhänge', 'sys'),
(333, 'ticket_status', 'Status des Tickets', 'sys'),
(334, 'ticket_titel_header_neu', 'Neues Ticket aufgeben', 'sys'),
(336, 'ticket_titel_header_2', 'Zu wann und von wem soll das Ticket bearbeitet werden', 'sys'),
(337, 'ticket_titel_header_3', 'Bitte bei Bedarf das entsprechende System wählen', 'sys'),
(338, 'ticket_titel_header_4', 'Beobachter auswählen (multiple) und ggf. Anhänge hochladen', 'sys'),
(339, 'ticket_detail_hinweis_1', 'wurde von', 'sys'),
(340, 'ticket_detail_hinweis_2', 'auf', 'sys'),
(341, 'ticket_detail_hinweis_3', 'geändert', 'sys'),
(342, 'ticket_fortschritt', 'Erledigt', 'sys'),
(343, 'hinweis_titel_gemeldet', 'gemeldet', 'sys'),
(344, 'hinweis_titel_ticket', 'Ticket', 'sys'),
(345, 'tickt_history_titel', 'Historie zum Ticket mit der ID:', 'sys'),
(346, 'ticket_save_button', 'Ticket speichern', 'sys'),
(347, 'ticket_titel_header_edit', 'Aktuelles Ticket bearbeiten', 'sys'),
(348, 'list_my_ticket', 'Meine Tickets anzeigen', 'sys'),
(349, 'time_ago_montag', 'Montag', 'sys'),
(350, 'time_ago_dienstag', 'Dienstag', 'sys'),
(351, 'time_ago_mittwoch', 'Mittwoch', 'sys'),
(352, 'time_ago_donnerstag', 'Donnerstag', 'sys'),
(353, 'time_ago_freitag', 'Freitag', 'sys'),
(354, 'time_ago_samstag', 'Samstag', 'sys'),
(355, 'time_ago_sonntag', 'Sonntag', 'sys'),
(356, 'time_ago_vor', 'vor', 'sys'),
(357, 'time_ago_jahr', 'Jahr', 'sys'),
(358, 'time_ago_monat', 'Monat', 'sys'),
(359, 'time_ago_tag', 'Tag', 'sys'),
(360, 'time_ago_stunde', 'Stunde', 'sys'),
(361, 'time_ago_minute', 'Minute', 'sys'),
(362, 'time_ago_sekunde', 'Sekunde', 'sys'),
(363, 'ticket_historie_upload', 'hochgeladen', 'sys'),
(364, 'monitor_service_dependence_selection', 'Oder hier einen vorhandenen Dienst als Abhängigkeit speichern', 'sys'),
(365, 'knowledge_base_header_neu', 'Neuen Eintrag in der Knowledge Base eintragen', 'sys'),
(366, 'knowledge_base_header_edit', 'Vorhandene Eintrag überarbeiten', 'sys'),
(367, 'copy_to_clipboard', 'In die Zwischenablage kopieren', 'sys'),
(368, 'search_knowledge_readmore', 'weiterlesen', 'sys'),
(369, 'search_systeme', 'Systeme', 'sys'),
(370, 'search_services', 'Services', 'sys'),
(371, 'search_hardware', 'Hardware', 'sys'),
(372, 'search_lizenzen', 'Lizenzen', 'sys'),
(373, 'search_logfile', 'Logfiles', 'sys'),
(374, 'search_knowledge', 'FAQ / KB', 'sys'),
(375, 'search_ticket', 'Tickets', 'sys'),
(376, 'search_systeme_noresult', 'Keine Server oder virtuellen Maschinen gefunden', 'sys'),
(377, 'search_services_noresult', 'Keine Dienste oder Reminder gefunden', 'sys'),
(378, 'search_hardware_noresult', 'Keine Hardware gefunden', 'sys'),
(379, 'search_lizenzen_noresult', 'Keine Lizenzen gefunden', 'sys'),
(380, 'search_logfile_noresult', 'Keine Daten im Logfile gefunden', 'sys'),
(381, 'search_knowledge_noresult', 'Keinen Treffer in der Wissensdatenbank gefunden', 'sys'),
(382, 'search_ticket_noresult', 'Keine Tickets gefunden', 'sys'),
(383, 'home_first_nav', 'Dashboard', 'sys'),
(384, 'home_seven_nav', 'Module', 'sys'),
(385, 'titel_priority', 'Priorität definieren', 'sys'),
(386, 'text_priority', 'Diese Einstellung hat Einfluss auf die Häufigkeit der Prüfung. Alle definierten Dienste werden den entsprechenden Intervallen einer Prüfung unterzogen.', 'sys'),
(387, 'title_help_dns', 'Aktive DNS Prüfung', 'sys'),
(388, 'text_help_dns', 'Dieses System wird dann jede Nacht überprüft, ob die Einträge im DNS Server mit den hier hinterlegten Daten übereinstimmen. Ausserdem werden die DNS Informationen bei jedem Aufruf dieses Systems geprüft', 'sys'),
(389, 'home_physische_nav', 'Physische Systeme', 'sys'),
(390, 'nav_inventar_index', 'Übersicht', 'sys'),
(391, 'text_monitor_service', 'Websiteüberwachung mit regulären Ausdrücken, Service/Dienst Monitoring an einem bestimmten Port oder Reminder Monitoring mit Ablaufdatum', 'sys'),
(392, 'titel_monitor_service', 'Definition des Überwachungsmodus', 'sys'),
(393, 'text_service_expire', 'Das Ablaufdatum und das Datum der Erinnerung angeben, Erinnerung wird 14 Tage vor Ablauf aktiv und erscheint dann auch in Gelb ', 'sys'),
(394, 'titel_service_expire', 'Erinnerungsfunktion', 'sys'),
(395, 'text_service_port', 'Hier den zu überwachenden Port eingeben, Portangabe nur erforderlich bei der Überwachungsart \"Service/Dienst\"', 'sys'),
(396, 'titel_service_port', 'Service Monitoring', 'sys'),
(397, 'text_service_searchpattern', 'Hier den Wert angeben nachdem auf der Webseite gesucht werden soll, reguläre Ausdrücke sind ebenfalls möglich. Nur angeben wenn die Art der Überwachung \"Website\" ist.', 'sys'),
(398, 'titel_service_searchpattern', 'Website Monitorung', 'sys'),
(399, 'nav_inventar_password', 'Passwortverwaltung', 'sys'),
(400, 'copy_to_clipboard_and_show', 'Passwort anzeigen und in die Zwischenablage kopieren', 'sys'),
(401, 'hardware_kategorie_computer', 'Computer', 'sys'),
(402, 'inventory_password_list_verwendung', 'Verwendung', 'sys'),
(403, 'inventory_password_list_url', 'URL', 'sys'),
(404, 'inventory_password_list_username', 'Username', 'sys'),
(405, 'inventory_password_list_password', 'Passwort', 'sys'),
(406, 'inventory_password_list_private', 'Sichtbar für', 'sys'),
(407, 'inventory_password_list_private_all', 'Gemeinsame Verwendung', 'sys'),
(408, 'inventory_password_list_private_own', 'Private Verwendung (nur für mich)', 'sys'),
(409, 'inventory_hardware_new_attachment', 'Anhänge zum Vorgang', 'sys'),
(410, 'inventory_hardware_attachment_new', 'Neue Anhänge', 'sys'),
(411, 'inventory_hardware_attachment_list', 'Vorhandene Anhänge', 'sys'),
(412, 'inventory_password_list_private_admin', 'Nur für Administratoren', 'sys'),
(413, 'inventory_contract_description', 'Bezeichnung', 'sys'),
(414, 'inventory_hardware_category', 'Kategorie', 'sys'),
(415, 'inventory_contract_department', 'Abteilung', 'sys'),
(416, 'inventory_contract_partner', 'Vertragspartner', 'sys'),
(417, 'inventory_contract_number', 'Dokumentennummer', 'sys'),
(418, 'structure_new_contract', 'Neu Dokument hinzufügen', 'sys'),
(419, 'contract_detail_edit', 'Dokument bearbeiten', 'sys'),
(420, 'contract_delete', 'Dokument löschen', 'sys'),
(421, 'inventory_contract_category', 'Dokumentenkategorie', 'sys'),
(422, 'inventory_contract_term', 'Vertragslaufzeit (von - bis)', 'sys'),
(423, 'nav_inventar_contract', 'Dokumentenverwaltung', 'sys'),
(424, 'search_password_noresult', 'Kein Passwort gefunden', 'sys'),
(425, 'search_contract_noresult', 'Kein Dokument gefunden', 'sys'),
(426, 'inventory_contract_responsible', 'Verwantwortlicher', 'sys'),
(427, 'home_eight_nav', 'IT Verwaltung', 'sys'),
(428, 'nav_inventar_standby', 'Rufbereitschaft', 'sys'),
(429, 'standby_kw', 'Woche', 'sys'),
(430, 'standby_date_start', 'Datum Start', 'sys'),
(431, 'standby_date_ende', 'Datum Ende', 'sys'),
(432, 'standby_user', 'Mitarbeiter', 'sys'),
(433, 'standby_anzahl_logs', 'Alarme', 'sys'),
(434, 'standby_report', 'Bericht schreiben', 'sys'),
(435, 'standby_edit_user', 'Benutzer ändern/zuweisen', 'sys'),
(436, 'monitor_service_messagebird', 'Messagebird', 'sys'),
(437, 'monitor_service_messagebird_on', 'Messagebird einschalten', 'sys'),
(438, 'monitor_service_messagebird_off', 'Messagebird ausschalten', 'sys'),
(439, 'user_admin_mobile', 'Mobilnummer', 'sys'),
(440, 'structure_messagebird_on', 'Anruffunktion ist eingeschalten', 'sys');