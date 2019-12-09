<?php

template::setText('psm_last_update', Base::get('Handler')->getLastUpdate());
include(project_path . '/controller/monitor/status.php');

?>

