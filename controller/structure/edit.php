<?php

$wos = new Server();
$url = base::get('url');
$sys = $url['2'];

if (end($url) == 'save') {
    $wos->updateSystem($sys, $_POST);
    header("Location: " . $_POST['referr']);
}

template::setText('referr', $referr);
template::setText('server_detail', $wos->getSystem($sys));

?>
