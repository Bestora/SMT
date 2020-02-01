<?php

Template::setText('mypage_active', 'active');

$wos = new Server();
$server = $user_daten['favorite'];

for ($i = 0; $i < count($server); $i++) {
    $server[$i] = $wos->getSystem($server[$i]['server_id']);
}

template::SetText('list_art', 'server_liste');
template::setText('server_liste', $server);
template::setText('page_reload', base::get('Handler')->config['auto_refresh_servers']);
template::setText('psm_last_update', Base::get('Handler')->getLastUpdate());

?>
