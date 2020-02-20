<?php

Template::setText('admin_config_active', 'active');
$db = new Database('SMT-ADMIN');

if (end($url) == 'save') {
  foreach ($_POST as $key => $value) {
    if (!empty($value)) {
      $query = "UPDATE wos_config SET value=:value WHERE id=:key";
      $value = array(':value' => $value, ':key' => $key);
      
      $db->getQuery($query, $value);
      header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
    }
  }
}

$query = "SELECT * FROM wos_config WHERE field!=:field";
$db->getQuery($query, array(':field' => 'hidden'));

template::setText('editconfig', $db->getValue());

?>
