<?php

$ses = Session::getInstance();
$url = base::get('url');
$inv = new Inventur;

if (end($url) == 'clear') {
  $inv->clear();
  header("Location: " . base::get('getPath') . "/" . base::get('controller'));
}

if (end($url) == 'scan') {
  $inv->saveScan($_POST);
  header("Location: " . base::get('getPath') . "/" . base::get('controller'));
}

$data = $inv->readAllItems();
template::setText('hardware', $data);

?>
