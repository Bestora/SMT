<?php

$ftpuser = $proftpd->getUser(end($url));
template::setText('user', $ftpuser);

$query = "SELECT * FROM weblog WHERE userid=:userid ORDER BY id DESC";
$db->getQuery($query, array(':userid' => end($url)));

if (isset($_SESSION ['aForm']) && isset($_SESSION ['pwalert'])) {
    template::setText('aForm', $_SESSION ['aForm']);
    template::setText('pwalert', $_SESSION ['pwalert']);
    template::setText('user', True);
    unset($_SESSION ['aForm']);
    unset($_SESSION ['pwalert']);
}

?>
