<?php

$wos = new Service();
$year = date("Y");
template::setText('user_liste', $user->listUsers());
template::setText('StandbyJahre', array((date("Y")-1), date("Y"), (date("Y")+1)));

if(isset($url['3']) && $url['2'] == 'show') {
  $year = $url['3'];
}

template::setText('aktuellesJahr', $year);

if(isset($url['3']) && $url['2'] == 'save') {
  $adm->UpdateStandbyWithUsername($_POST, $url['3']);
  header("Location: " . $referr);
}

if(isset($url['3']) && $url['2'] == 'report') {
  $adm->UpdateStandbyReport($_POST, $url['3']);
  header("Location: " . $referr);
}

$standby = $adm->UpdateTableForStandby($year);

for($i=0; $i<count($standby); $i++) {
  $dat[$i]['KW'] = ($i+1);
  $dat[$i]['id'] = $standby[$i]['id'];
  $dat[$i]['username'] = $standby[$i]['username'];
  $dat[$i]['report'] = $standby[$i]['report'];
  $dat[$i]['lastupdate'] = $standby[$i]['lastupdate'];

  // Start und Ende ermitteln und die Logfiles prüfen und einlesen
  $dat[$i]['start'] = $adm->getStartDayforWeek($year, $dat[$i]['KW']);
  $dat[$i]['ende']  = $adm->getLastDayforWeek($year, $dat[$i]['KW']);
  $dat[$i]['logs'] = $wos->getLogDate($dat[$i]['start'] . ' 00:00:00', $dat[$i]['ende'] . ' 23:59:59');

  // Lesbares deutsches Datum
  $dat[$i]['start'] = $adm->getStartDayforWeek($year, $dat[$i]['KW'], 'de');
  $dat[$i]['ende']  = $adm->getLastDayforWeek($year, $dat[$i]['KW'], 'de');
}

template::setText('data', $dat);

