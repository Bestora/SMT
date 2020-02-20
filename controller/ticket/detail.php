<?php

$detail = $ticket->readTicket(end($url));


if (in_array('download', $url)) {
  $file->downloadFile(urldecode(end($url)));
  die();
}

if (in_array('delete', $url) && isset($_SESSION['admin'])) {
  $ticket->deleteTicket(end($url));
  header("Location: " . base::get('getPath') . "/ticket/index");
}

if (in_array('edit', $url)) {
  template::setText('edit', True);
}

if (in_array('save', $url)) {
  $ticket->saveNewTicket($_POST);
  $_POST['anhang'] = $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], end($url));
  
  header("Location: " . base::get('getPath') . "/ticket/detail/" . end($url));
}

// umleiten wenn es das ticket nicht gibt
if (count($detail['ticket']) == 0) {
  header("Location: " . base::get('getPath') . "/ticket/new/");
}

include_once 'ticket_details.php';

// Alle Daten ins Template übergeben
template::setText('detail', $detail);


?>
