<?php

$lic = new License;
$had = new Hardware;
$wos = new Server('vmware');
$ses = Session::getInstance();
$url = base::get('url');
$file = new File;

if (isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'detail' || isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'edit') {

  if ($url['2'] == 'new' && end($url) == 'save') {
    $id = $lic->saveLicense($_POST);
    $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $id);
    header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
  }

  if ($url['2'] == 'edit' || $url['2'] == 'detail') {
    if (end($url) == 'save') {
      $lic->updateLicense($url['3'], $_POST);
      $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $url['3']);
      header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
    } else {
      template::setText('detail', $lic->getDetail(end($url)));
    }
  }

  template::setText('hardware', $had->getHardware());
  template::setText('images', $wos->getAllSystem(False, False));
  template::setText('lic_act', $url['2']);
}

if (in_array('delete', $url)) {
  $lic->delLicense(end($url));
  header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

template::setText('license_liste', $lic->getAll());

?>
