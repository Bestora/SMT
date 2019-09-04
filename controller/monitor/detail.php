<?php

// Neue Serverinstance 
$wos = new Service();
$url = base::get('url');
$sys = end($url);

template::setText('detail', $wos->getServiceDetail($sys, True, True));

$arc = new UptimeArchiver;
$arc->archive($sys);

$h = new HistoryGraph;
$g = $h->createHTML($sys);

for($i=7; $i>0; $i--) {
  $d[$i] = date("d.m.Y", mktime(0, 0, 0, date("m"), date("d") - $i, date("Y")));
}

$g['graphs']['0']['server_lines'] = explode("],", $g['graphs']['0']['server_lines']);
$g['graphs']['0']['server_lines'] = str_replace('[', '', $g['graphs']['0']['server_lines']);
$g['graphs']['0']['server_lines'] = str_replace(']', '', $g['graphs']['0']['server_lines']);

$g['graphs']['1']['server_lines'] = explode("],", $g['graphs']['1']['server_lines']);
$g['graphs']['1']['server_lines'] = str_replace('[', '', $g['graphs']['1']['server_lines']);
$g['graphs']['1']['server_lines'] = str_replace(']', '', $g['graphs']['1']['server_lines']);

for($i=0; $i<count($g['graphs']['0']['server_lines']); $i++) {
  $temp = explode(",", $g['graphs']['0']['server_lines'][$i]);
  $g['graphs']['0']['server_lines'][$i] = array("x" => $temp['0'], "y" => $temp['1']);
}

for($i=0; $i<count($g['graphs']['1']['server_lines']); $i++) {
  $temp = explode(",", $g['graphs']['1']['server_lines'][$i]);
  $g['graphs']['1']['server_lines'][$i] = array("x" => $temp['0'], "y" => $temp['1']);
}

template::setText('chartTage', $d);
template::setText('graphs', $g);
template::setText('uptime', round($g['graphs']['1']['uptime'], 2));
template::setText('latency', round($g['graphs']['1']['latency_avg'], 2));

$dataPoints1 = $g['graphs']['0']['server_lines'];
template::setText('dataPoints1', json_encode($dataPoints1, JSON_NUMERIC_CHECK));

$dataPoints2 = $g['graphs']['1']['server_lines'];
template::setText('dataPoints2', json_encode($dataPoints2, JSON_NUMERIC_CHECK));
