<?php

$db = new Database('SMT-MONITOR');
$referr = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$url = base::get('url');
$service = new Service;
$server = new Server;
$user = Base::get('Handler')->user;

template::setText('psm_last_update', Base::get('Handler')->getLastUpdate());

if (in_array('refresh', $url)) {
  $update = new Updater();
  $update->update(end($url));
  
  header("Location: " . $referr);
}

require_once base::getSubcontroller();

?>
