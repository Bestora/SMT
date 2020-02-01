<?php

$date_1 = date('Y-m-d', time() - (86400 * base::get('iInitial')));
$date_2 = date('Y-m-d 00:00:00', time() - (86400 * base::get('iGueltigkeit')));

// Alle Accounts sperren die l�nger als X Tage inaktiv waren
$query = "SELECT * FROM ftpuser WHERE accessed <= :datum";
$value = array(':datum' => $date_2);

$db->getQuery($query, $value);
$user = $db->getValue();

for ($i = 0; $i < count($user); $i++) {
    $ftp->setStatus('block', $user [$i] ['userid']);
}

$ftp->weblog('sys', count($user) . " Benutzer gesperrt");

// Freigeschaltete Accounts sperren die nach X Tagen Reaktivierung den FTP nicht genutzt haben
$query = "SELECT * FROM ftpuser WHERE gueltig = :datum";
$value = array(
    ':datum' => $date_1
);

$db->getQuery($query, $value);
$user = $db->getValue();

for ($i = 0; $i < count($user); $i++) {
    $ftp->setStatus('block', $user [$i] ['userid']);
}

$ftp->weblog('sys', count($user) . " Benutzer gesperrt");

// Keine Ausgabe das es sich um einen cronjob handelt
die();

?>
