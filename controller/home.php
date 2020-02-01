<?php

$db = new Database('SMT-ADMIN');
$time = new Time();
template::setText('news_content', Base::get('Handler')->loadNews(Base::get('controller')));
template::setText('psm_last_update', Base::get('Handler')->getLastUpdate());


if (filter_input(INPUT_POST, 'search_string')) {
    include(project_path . '/controller/structure/search.php');
} else {
    include(project_path . '/controller/monitor/status.php');
}

?>  
