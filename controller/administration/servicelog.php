<?php

$wos = new Service();
$ses = Session::getInstance();
$url = base::get('url');

if (end($url) == 'empty') {
    $wos->clearLogfile();
    header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
}

$detail['log'] = $wos->getLog();
template::setText('detail', $detail);

?>
