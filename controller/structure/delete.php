<?php

$url = base::get('url');
$sys = end($url);
$wos = new Server();
$wos->deleteSystem($sys);

die(header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/liste"));

?>
