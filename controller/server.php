<?php

$db = new Database('SMT-MONITOR');
$referr = filter_input(INPUT_SERVER, 'HTTP_REFERER');

template::setText('active_server', 'active');
template::setText('active_systeme_' . Base::get('controller'), 'active');

template::setText('news_content', Base::get('Handler')->loadNews(Base::get('controller')));
template::setText('psm_last_update', Base::get('Handler')->getLastUpdate());

require_once base::getSubcontroller();

?>
