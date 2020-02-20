<?php

// Neuen Service definieren
if (in_array('new', $url)) {
  template::setText('server_detail', $server->getSystem(end($url)));
  template::setText('all_services', $service->getAllService());
  template::setText('user_liste', $user->listUsers());
  template::setText('referr', $referr);
  $old = explode('/', substr($referr, 7));
  $_SESSION['old'] = $old['1'];
  
}

// Einen vorhanden Service bearbeiten
if (in_array('edit', $url)) {
  $servid = end($url);
  $result = $service->getServiceDetail($servid, False, False);
  
  template::setText('service_detail', $result);
  session::set('service_detail', $result);
  template::setText('referr', $referr);
  template::setText('user_liste', $user->listUsers());
}

// Einen Service löschen
if (in_array('delete', $url)) {
  $service->deleteAllServices(end($url));
  header("Location: " . $referr);
}

// Update der Relationen
if (end($url) == 'relation') {
  header("Location: " . base::get('getPath') . "/" . $_SESSION['old'] . "/detail/" . $server->updateRelationSystem($_POST));
}

// Eine bestimmte Relation löschen
if (in_array('delete_relation', $url)) {
  $server->deleteSingleRelation($url['3'], end($url));
  header("Location: " . base::get('getPath') . "/server/detail/" . $url['3']);
}

// Einen neuen Service spreichern
if (end($url) == 'save') {
  $save = $service->saveService($_POST);
  header("Location: " . $_POST['referr']);
}

?>
