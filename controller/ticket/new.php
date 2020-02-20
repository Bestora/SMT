<?php

if (end($url) == 'save') {
  $tid = $ticket->saveNewTicket($_POST);
  $_POST['anhang'] = $file->uploadFile(base::get('controller'), $_FILES['filesToUpload'], $tid);
  
  header("Location: " . base::get('getPath') . "/ticket/detail/" . $tid);
}

?>
