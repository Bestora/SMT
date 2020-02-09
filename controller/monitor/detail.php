<?php

// Neue Serverinstance 
$wos = new Service();
$url = base::get('url');
$sys = end($url);

template::setText('detail', $wos->getServiceDetail($sys, True, True));

$arc = new UptimeArchiver;
try {
    $arc->archive($sys);
} catch (Exception $e) {
}

$h = new HistoryGraph;
try {
    $g = $h->createHTML($sys);
} catch (Exception $e) {
}

$dataPointMin = array();
$dataPointAvg = array();
$dataPointMax = array();

for ($i = 0; $i < count($g['2']); $i++) {
    $dataPointMin[$i]['label'] = $g['2'][$i]['date'];
    $dataPointAvg[$i]['label'] = $g['2'][$i]['date'];
    $dataPointMax[$i]['label'] = $g['2'][$i]['date'];

    $dataPointMin[$i]['y'] = $g['2'][$i]['latency_min'];
    $dataPointAvg[$i]['y'] = $g['2'][$i]['latency_avg'];
    $dataPointMax[$i]['y'] = $g['2'][$i]['latency_max'];
}

for ($i = 0; $i < count($g['0']); $i++) {
    if (!empty(strtotime($g['0'][$i]['date']))) {
        $d = explode(' ', $g['0'][$i]['date']);
        $g['0']['chart_day'][$i] = array("label" => $g['0'][$i]['date'], "y" => $g['0'][$i]['latency']);
    }
}

for ($i = 0; $i < count($g['1']); $i++) {
    if (!empty(strtotime($g['1'][$i]['date']))) {
        $g['1']['chart_week'][$i] = array("label" => $g['1'][$i]['date'], "y" => $g['1'][$i]['latency']);
    }
}

template::setText('dataPoints1', json_encode($g['0']['chart_day'], JSON_NUMERIC_CHECK));
template::setText('dataPoints2', json_encode($g['1']['chart_week'], JSON_NUMERIC_CHECK));
template::setText('dataPointsMin', json_encode($dataPointMin, JSON_NUMERIC_CHECK));
template::setText('dataPointsAvg', json_encode($dataPointAvg, JSON_NUMERIC_CHECK));
template::setText('dataPointsMax', json_encode($dataPointMax, JSON_NUMERIC_CHECK));
