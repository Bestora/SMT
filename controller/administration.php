<?php

$adm = new Administration();
$url = base::get('url');
$user = Base::get('Handler')->user;
$referr = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$db = new Database('SMT-MONITOR');
$dat = array();

require_once base::getSubcontroller();

?>