<?php

$url = base::get('url');
$sip = end($url);

if (isset($url['2'])) {
  $db = new Database('SMT-ADMIN');
  $db->getQuery("DELETE FROM wos_server_ports WHERE ipadresse=:ipadresse", array(':ipadresse' => $sip));
  
  template::setText('target', $sip);
}
?>
