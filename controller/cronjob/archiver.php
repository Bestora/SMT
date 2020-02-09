<?php

$arc = new UptimeArchiver;

// Alles Service die geprüft werden sollen einlesen
$db = new Database('SMT-MONITOR');
$result = $db->getQuery("SELECT server_id FROM psm_servers", array(), True);

for ($i = 0; $i < count($result); $i++) {
    try {
        $arc->archive($result[$i]['server_id']);
    } catch (Exception $e) {
    }
}

$db->getQuery("DELETE FROM psm_servers_uptime WHERE date NOT LIKE '%:00:%' && date NOT LIKE '%:30:%'", array(), True);

die($i . ' Monitordaten verarbeiten');

