<?php

$url = base::get('url');
$wos = new Server();
$res = $wos->getAllSystem(False);

// Alte Einträge löschen
$db = new Database('SMT-ADMIN');
$db->getQuery("TRUNCATE TABLE `wos_dns_cron`", array());

// Tabelle neu einlesen und speichern
for ($i = 0; $i < count($res); $i++) {
  if ($res[$i]['live_dns'] == 'on') {
    $wos->checkDNS($res[$i]['ipadressen'], $res[$i], True);
  }
}

if (isset($url['2'])) {
  header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
}

die();

