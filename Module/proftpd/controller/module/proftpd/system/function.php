<?php

include_once project_path . '/controller/' . base::get('controller') . '/' . base::get('methode') . '/system/menu.php';

if (in_array('order', $url)) {
  Session::set('ordername', $url ['4']);
  Session::set('orderby', $url ['5']);
  base::setRoute('module', 'proftpd/index', TRUE);
}

if (!isset($_SESSION ['ordername'])) {
  Session::set('ordername', 'userid');
  Session::set('orderby', 'ASC');
}

if (in_array('block', $url)) {
  $proftpd->setStatus('block', end($url));
  base::setRoute('module', 'proftpd/index', TRUE);
}

if (in_array('unlock', $url)) {
  $proftpd->setStatus('unlock', end($url));
  base::setRoute('module', 'proftpd/index', TRUE);
}

if (in_array('delete', $url)) {
  $proftpd->setStatus('delete', end($url));
  base::setRoute('module', 'proftpd/index', TRUE);
}

if (end($url) == 'new') {
  $proftpd->newUser($_POST);
  base::setRoute('module', 'proftpd/index', TRUE);
}

if (in_array('save', $url)) {
  $proftpd->saveUser($_POST, end($url));
  base::setRoute('module', 'proftpd/index', TRUE);
}

?>

