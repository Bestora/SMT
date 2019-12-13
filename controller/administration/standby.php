<?php

$wos = new Service();
$year = date("Y");
$userListe = $user->listUsers();
template::setText('user_liste', $userListe);
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

$standby = $adm->UpdateTableForStandby($year, $userListe);

template::setText('data', $standby);
