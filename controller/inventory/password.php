<?php

$pas = new Password();
$ses = Session::getInstance();
$url = base::get('url');
$server = new Server;

if (in_array('new', $url)) {
  $pas->savePassword($_POST);
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

if (in_array('edit', $url)) {
  $pas->updatePassword(end($url), $_POST);
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

if (in_array('delete', $url)) {
  $pas->deletePassword(end($url));
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

template::setText('password_liste', $pas->getAll());
template::setText('server_liste', $server->getAllSystem(False, False));

?>
