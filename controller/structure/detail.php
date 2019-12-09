<?php

$wos = new Server();
$url = base::get('url');
$sys = $url['2'];
$usr = Base::get('Handler')->user;
$pas = new Password();

// Passwortfunktion
if (in_array('new', $url)) {
  $pas->savePassword($_POST);
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/detail/" . $sys);
}
// Passwortfunktion
if (in_array('delete', $url)) {
  $pas->deletePassword(end($url));
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/detail/" . $sys);
}
// Passwortfunktion
if (in_array('edit', $url)) {
  $pas->updatePassword(end($url), $_POST);
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/detail/" . $sys);
}

if (end($url) == 'favorite') {
  $usr->Favorite($sys);
  die(header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/detail/" . $sys));
}

if (!$usr->checkFavorite($sys)) {
  Template::setText('add_favorite', True);
}

if ($usr->checkFavorite($sys)) {
  Template::setText('del_favorite', True);
}

if (end($url) == 'dnsreload') {
  $ssh = new SSH('localhost');
  $ssh->cmdExec('service nscd stop');
  $ssh->cmdExec('service nscd start');

  header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
}

if (end($url) == 'save') {
  $wos = new Server();
  $wos->updateSystem($sys, $_POST);

  die(header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/detail/" . $sys));
}

$server = $wos->getSystem($sys);
$server['password'] = $pas->getSystemPassword($sys);

if (count($server['password']) == 0) {
  unset($server['password']);
}

if ($server['live_dns'] == 'on') {
  $server['dns'] = $wos->checkDNS($server['ipadressen'], $server);
}

template::setText('server_detail', $server);
template::setText('server_liste', $wos->getAllSystem(False, False));

?>
