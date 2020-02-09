<?php

$db = new Database('SMT-ADMIN');
$server = new Server;
$user = Base::get('Handler')->user;
$ticket = new Ticket;
$file = new File;
$url = base::get('url');
$time = new Time();
$ses = Session::getInstance();

$conf = explode(',', base::get('Handler')->config['ticket_prio']);
for ($f = 0; $f < count($conf); $f++) {
    $prio[$f] = array();
    $prio[$f]['key'] = $conf[$f];
    $prio[$f]['val'] = texte::getText($conf[$f]);
}
template::setText('ticket_prio', $prio);

$conf = explode(',', base::get('Handler')->config['ticket_status']);
for ($f = 0; $f < count($conf); $f++) {
    $status[$f] = array();
    $status[$f]['key'] = $conf[$f];
    $status[$f]['val'] = texte::getText($conf[$f]);
}
template::setText('ticket_status', $status);

if (in_array('download', $url)) {
    $file->downloadFile(urldecode(end($url)));
    die();
}

// Standardabfragen ins Template übergeben
template::setText('erledigt', array('0', '10', '20', '30', '40', '50', '60', '70', '80', '90', '100'));

// Bei NEU oder EDIT Server und Userdaten ins Template übergeben
if (in_array('new', $url) || in_array('edit', $url)) {
    template::setText('user_liste', $user->listUsers());
    template::setText('server_liste', $server->getAllSystem(False, False));
}

require_once base::getSubcontroller();

?>
