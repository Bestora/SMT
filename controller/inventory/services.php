<?php

$url = base::get('url');
$wos = new Service;
$ses = Session::getInstance();

if (end($url) == 'export') {
    $fp = fopen(project_path . '/assets/export/services.csv', 'w');

    foreach ($wos->getAllService() as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);

    header("Location: " . base::get('getPath') . "/assets/export/services.csv");
}

template::setText('services_liste', $wos->getAllService());

?>
