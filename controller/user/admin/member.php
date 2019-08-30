<?php

template::setText('admin_user_page', $url['3']);
include(project_path . '/controller/user/admin/' . $url['2'] . '/' . $url['3'] . '.php');

?>
