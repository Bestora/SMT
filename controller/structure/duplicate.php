<?php

$wos = new Server(base::get('controller'));
$url = base::get('url');
$sys = $url['2'];

if (end($url) == 'save') {
    $id = $wos->saveSystem($_POST);
    base::setRoute(Base::get('controller'), 'detail/' . $id, TRUE);
}

template::setText('referr', $referr);
template::setText('server_detail', $wos->getSystem($sys));

?>
