<?php

$session = Session::getInstance();
$user = Base::get('Handler')->user;
$url = base::get('url');

if ($user->isLogged()) {
    $user_daten = $user->getUser();

    if (isset($_SESSION['rechte']) || $_SESSION['rechte'] == 'adm') {
        Template::setText('admin', True);
    }
}

if (Base::get('Handler')->config['authentication'] == 'intern') {
    Template::setText('authpass', True);
}

/**
 * Standardcontroller zur Steuerung der Benutzer
 * Loging aus Logout bereits implementiert
 */
require_once base::getSubcontroller();

?>
