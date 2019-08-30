<?php

$con = new Contract;
$ses = Session::getInstance();
$url = base::get('url');
$file = new File;

if (in_array('download', $url)) {
  $file->downloadFile(urldecode(end($url)));
  die();
}

if (in_array('deleteattachment', $url)) {
  $file->deleteFile(urldecode(end($url)));
  header("Location: " . base::get('getPath') . "/" . $url['0'] . "/" . $url['1'] . "/" . $url['2'] . "/". $url['3']);
}

if (isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'detail' || isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'edit') {
  if ($url['2'] == 'new' && end($url) == 'save') {
    $id = $con->saveContract($_POST);
    $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $id);

    header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
  }

  if ($url['2'] == 'edit' || $url['2'] == 'detail') {
    template::setText('referr', filter_input(INPUT_SERVER, 'HTTP_REFERER'));
    if (end($url) == 'save') {
      $con->updateContract($url['3'], $_POST);
      $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $url['3']);

      header("Location: " . $_POST['referr']);
    } else {
      $contract = $con->getContract(end($url));
      template::setText('detail', $contract);
    }
  }

  template::setText('det_act', $url['2']);
}


if (isset($url['2']) && $url['2'] == 'delete') {
  $con->deleteContract(end($url));
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

template::setText('contract_liste', $con->getContract());

