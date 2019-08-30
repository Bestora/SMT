<?php

$wos = new Server(base::get('controller'));
$ses = Session::getInstance();
$url = base::get('url');

template::setText('server_liste', $wos->getAllSystem(False));

?>
