<?php

/*
 * Subcontroller zum ändern des eigenen Passworts
 * Anlegen eines Auth Codes (24 Std. haltbar)
 * nach 24 Stunden muß der Vorgang widerholt werden
 */
if (isset($_POST ['pass_1']) && isset($_POST ['pass_2'])) {
  $database = new Database('SMT-ADMIN');
  if ($_POST ['pass_1'] == $_POST ['pass_2']) {
    $passwd = md5($_POST ['pass_1']);

    $query = "UPDATE db_user SET password=:password WHERE username=:username";
    $value = array(
      ':username' => $session->get('username'),
      ':password' => $passwd
    );

    $database->getQuery($query, $value);

    $query = "UPDATE db_user_secure SET authCode=:authCode WHERE username=:username";
    $value = array(
      ':username' => $session->get('username'),
      ':authCode' => ''
    );

    $database->getQuery($query, $value);
    unset($session->authCode);

    die(header("Location: " . $_POST ['location']));
  } else {
    die('Die Passwörter stimmen nicht überein');
  }
}

?>
