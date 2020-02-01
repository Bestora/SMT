<?php
/*
 * Standarddaten bereitstellen
 */
$url = base::get('url');
$user = Base::get('Handler')->user;
$config = Base::get('Handler')->config;

/**
 * Datenbank des Moduls initiieren
 */
$db = new Database('SMT-FTP');

/**
 * FTP Klasse initiieren
 * @param array $config entählt die Variablen proftpd_server, proftp_username und proftp_password
 * Diese Daten werden aus der "wos_config" geladen
 */
$proftpd = new Proftpd();
include_once project_path . '/controller/' . base::get('controller') . '/' . base::get('methode') . '/system/function.php';

/**
 * FTP Klasse initieren und bereitstellen
 * AB HIER NICHTS MEHR ÄNDERN
 */
for ($m = 0; $m < $i; $m++) {
    if ($url['2'] == substr($menu[$m]['link'], -strlen($url['2']))) {
        $menu[$m]['aktiv'] = 'active';
    }
}

/**
 * Modul starten
 */
template::setText('proftpd_page', $url['2']);
template::setText('submenu_content', $menu);

include_once project_path . '/controller/' . base::get('controller') . '/' . base::get('methode') . '/' . $url['2'] . '.php';

?>
