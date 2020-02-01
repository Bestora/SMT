<?php

if (!isset($_SESSION['rechte']) || $_SESSION['rechte'] != 'adm') {
    base::setRoute('home', 'index', TRUE);
}

template::setText('admin_page', $url['2']);
include('admin/' . $url['2'] . '.php');

?>
