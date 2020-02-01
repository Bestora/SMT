<?php

$query_open = "SELECT *, DATE_FORMAT(accessed,'%d.%m.%Y %H:%i') AS niceDatumLogin, DATE_FORMAT(modified,'%d.%m.%Y %H:%i') AS niceDatumChange FROM ftpuser ORDER BY " . $_SESSION ['ordername'] . " " . $_SESSION ['orderby'];
$query_closed = "SELECT *, DATE_FORMAT(accessed,'%d.%m.%Y %H:%i') AS niceDatumLogin, DATE_FORMAT(modified,'%d.%m.%Y %H:%i') AS niceDatumChange FROM ftpclosed ORDER BY " . $_SESSION ['ordername'] . " " . $_SESSION ['orderby'];

$db->getQuery($query_open, array());
template::setText('user', $db->getValue());

$db->getQuery($query_closed, array());
template::setText('closed', $db->getValue());


if (isset($_SESSION ['temp_passwd'])) {
    template::setText('temp_passwd', $_SESSION ['temp_passwd']);
    unset($_SESSION ['temp_passwd']);
}


template::setText('logfile', $proftpd->readLogfileFromServer());

?>
