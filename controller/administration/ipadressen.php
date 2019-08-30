<?php

$url = base::get('url');
$wos = new Server;
$res = $wos->getSystemIPs();


if (end($url) == 'export') {
  $fp = fopen(project_path . '/assets/export/ipadressen.csv', 'w');

  foreach ($res as $fields) {
    fputcsv($fp, $fields);
  }
  fclose($fp);

  header("Location: " . base::get('getPath') . "/assets/export/ipadressen.csv");
}

template::setText('server_liste', $res);
template::setText('csv_export', True);

?>
