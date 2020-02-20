<?php

Template::setText('daten_active', 'active');

if (end($url) == 'save') {
  $post = $_POST;
  
  if (!empty($post['password_1']) && $post['password_1'] == $post['password_2']) {
    $post['user']['password'] = $post['password_1'];
    $user->saveUserdata($post);
    Template::setText('save', True);
  } elseif (!empty($post['password_1']) && $post['password_1'] != $post['password_2']) {
    Template::setText('password_error', True);
  } else {
    $user->saveUserdata($post);
    Base::setRoute('user', 'daten');
  }
}

Template::setText('daten', $user_daten);

?>
