<?php

template::setText('authentication', Base::get('Handler')->config['authentication']);

if (isset($_POST ['username']) && isset($_POST ['passwort'])) {
  $login = $user->loginUser($_POST ['username'], $_POST ['passwort'], Base::get('Handler')->config);
  
  if ($login) {
    header("Location: " . base::get('getPath'));
  }
}

?>
