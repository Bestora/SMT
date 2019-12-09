<?php

setcookie('smtremember', false, time() - (3600 * 3650), '/', smt_cookie_domain);
$session->destroy();
base::setRoute('home', 'index', TRUE);

?>
