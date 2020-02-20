<?php

$url = base::get('url');
$kb = new Knowledge;
$kc = end($url);
$file = new File;


if (in_array('download', $url)) {
  $file->downloadFile(end($url));
  die();
}

// Nach dem Editieren speichern
if ($kc == 'clear') {
  unset($_SESSION['sst']);
  die(header("Location: " . base::get('getPath') . "/knowledge/index"));
}


if (in_array('edit', $url)) {
  // Falls der User kein Admin ist umleiten
  if ($_SESSION['admin'] === False) {
    base::setRoute('home', 'index', TRUE);
  }
  template::setText('edit', True);
}

// Nach dem Editieren speichern
if (in_array('delete', $url) && $_SESSION['admin'] === True) {
  $kb->delete($kc);
  die(header("Location: " . base::get('getPath') . "/knowledge/index"));
}

// Nach dem Editieren speichern
if (in_array('save', $url) && $kc != 'save') {
  $kb->saveEdit($_POST, $kc);
  $_POST['uploads'] = $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $kb);
  die(header("Location: " . base::get('getPath') . "/knowledge/show/" . $kc));
}

// Neuen Eintrag speichern
if (in_array('save', $url) && $kc == 'save') {
  $id = $kb->saveNew($_POST);
  $_POST['uploads'] = $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $id);
  die(header("Location: " . base::get('getPath') . "/knowledge/show/" . $id));
}

// Content zum Beitrag einlesen
if ($kc == 'index') {
  template::setText('content_knowledge', $kb->loadStart($kc));
  template::setText('index', True);
}

// Content zum Beitrag einlesen
if ($kc != 'new' && $kc != 'index' && $kc != 'search') {
  template::setText('content_knowledge', $kb->loadContent($kc));
  template::setText('knowledge_history', $kb->loadHistory($kc));
  
}

// Template auf neuen Eintrag stellen
if ($kc == 'new') {
  template::setText('new', True);
}

// Ausgabe des Beitrags
if ($kc != 'new' && $kc != 'index' && !in_array('edit', $url)) {
  template::setText('show', True);
}

template::setText('knowledge_liste', $kb->loadMenu($kc));

?>
