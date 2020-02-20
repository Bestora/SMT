<?php

$server = new Server();
$db = new Database('SMT-ADMIN');

$list_dns_systems = $db->getQuery("SELECT * FROM wos_server_dnsip", array(), True);

for ($i = 0; $i < count($list_dns_systems); $i++) {
  $list_dns_systems[$i]['existSystem'] = $server->checkHost($list_dns_systems[$i]['ip']);
}

template::setText('listip', $list_dns_systems);
template::setText('scanarea', explode(',', base::get('Handler')->config['ip_adress_bereich']));

