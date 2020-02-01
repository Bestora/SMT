<?php

$had = new Hardware;
$ses = Session::getInstance();
$url = base::get('url');
$file = new File;


$conf = explode(',', base::get('Handler')->config['hardware_kategorie']);
for ($f = 0; $f < count($conf); $f++) {
    $cat[$f] = array();
    $cat[$f]['key'] = $conf[$f];
    $cat[$f]['val'] = texte::getText($conf[$f]);
}

if (in_array('download', $url)) {
    $file->downloadFile(urldecode(end($url)));
    die();
}

if (isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'detail' || isset($url['2']) && $url['2'] == 'new' || isset($url['2']) && $url['2'] == 'edit') {
    if ($url['2'] == 'new' && end($url) == 'save') {
        $id = $had->saveHardware($_POST);
        $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $id);
        header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
    }

    if ($url['2'] == 'edit' || $url['2'] == 'detail') {
        template::setText('referr', filter_input(INPUT_SERVER, 'HTTP_REFERER'));
        if (end($url) == 'save') {
            $had->updateHardware($url['3'], $_POST);
            $file->uploadFile(base::get('methode'), $_FILES['filesToUpload'], $url['3']);
            header("Location: " . $_POST['referr']);
        } else {
            $hardware = $had->getHardware(end($url));
            template::setText('detail', $hardware);
        }
    }

    template::setText('det_act', $url['2']);
}

if (isset($url['2']) && $url['2'] == 'delete') {
    $had->deleteHardware(end($url));
    header("Location: " . base::get('getPath') . "/" . base::get('controller') . "/" . base::get('methode'));
}

template::setText('hardware_kategorie', $cat);
template::setText('hardware_liste', $had->getHardware());

