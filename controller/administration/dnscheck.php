<?php

$db = new Database('SMT-ADMIN');

template::setText('listip', $db->getQuery("SELECT * FROM wos_server_dnsip GROUP BY hostname ORDER BY datum DESC", array(), True));
template::setText('scanarea', explode(',', base::get('Handler')->config['ip_adress_bereich']));

?>
