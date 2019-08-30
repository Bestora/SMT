<?php

$url = base::get('url');
$referr = filter_input(INPUT_SERVER, 'HTTP_REFERER');
$user = Base::get('Handler')->user;
$config = Base::get('Handler')->config;


template::setText('news_content', Base::get('Handler')->loadNews(Base::get('controller')));
require_once project_path . '/controller/' . base::get('controller') . '/' . base::get('methode') . '/' . base::get('methode') . '.php';

?>
