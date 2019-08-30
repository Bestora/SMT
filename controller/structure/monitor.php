<?php

$wos = new Server();
$url = base::get('url');
$sys = end($url);
$sta = $url['2'];

$wos->updateMonitor($sys, $sta);
die(header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER')));

?>
