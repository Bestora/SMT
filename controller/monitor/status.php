<?php

// Neue Serverinstance 
$url = base::get('url');
$dvw = False;
$sid = end($url);

/*
 * Detail zu einem System / Liste aller Services
 */
if (count($url) == '3' && $sid && preg_match("/[0-9]/", $sid)) {
    $dvw = True;
    $wos = new Server();

    $title = 'Detailinformationen zum System';
    $server = $wos->getSystem($sid);
    template::setText('detail', $sid);
}


/*
 * Detail zu einem System / Liste aller Services
 */
if (count($url) == '3' && $dvw === False) {
    $dvw = True;
    $wos = new Server($sid);

    $title = 'Detailinformationen zu Systemen: ' . strtoupper($sid);
    $server = $wos->getAllSystem();

    for ($i = 0; $i < count($server); $i++) {
        if ($server[$i]['anzahl_monitor'] == 0) {
            unset($server[$i]);
        }
    }
    $server = array_merge($server);
}


/*
 * Liste aller  Systeme
 */
if ($dvw === False) {
    $wos = new Server();
    $server = $wos->getAllSystem(True, False);

    for ($i = 0; $i < count($server); $i++) {
        $server[$i]['bezeichnung'] = substr($server[$i]['bezeichnung'], 0, 25);
        if ($server[$i]['anzahl_monitor'] == 0) {
            unset($server[$i]);
        }
    }
}

$server = array_merge($server);
template::setText('server_liste', $server);
template::setText('page_reload', base::get('Handler')->config['auto_refresh_servers']);

?>
