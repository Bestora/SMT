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

template::setText('chartTage', $d);
template::setText('graphs', $g);
