<?php

$wos = new Server(base::get('controller'));

if (in_array('save', base::get('url'))) {
    $id = $wos->saveSystem($_POST);
    base::setRoute(Base::get('controller'), 'detail/' . $id, TRUE);
}

?>
