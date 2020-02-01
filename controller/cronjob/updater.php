<?php

$url = base::get('url');
$wos = new Service();
$upd = new Updater();
$las = Base::get('Handler')->getLastUpdate();
$arg = filter_input(INPUT_SERVER, 'argv');

// Alles Service die geprüft werden sollen einlesen
$result = $wos->getAllUpdateService($las['counter']);

if (!empty($argv)) {
    foreach ($arg as $argv) {
        $argi = explode('=', ltrim($argv, '--'));
        if (count($argi) !== 2) {
            continue;
        }
        switch ($argi[0]) {
            case 'uri':
                define('BASE_URL', $argi[1]);
                break;
            case 'timeout':
                $cron_timeout = intval($argi[1]);
                break;
        }
    }
}

for ($i = 0; $i < count($result); $i++) {
    for ($s = 0; $s < count($result[$i]); $s++) {
        $v = $upd->update($result[$i][$s]['server_id']);
    }
}

/*
 * Automatisches Update
 */
if (!isset($url['2'])) {
    die('FERTIG');
}

if (isset($url['2'])) {
    header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
} 
