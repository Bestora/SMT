<?php

Template::setText('admin_user_active', 'active');

if (end($url) == 'save') {
  $post = $_POST;

  if (!empty($post['password_1']) && $post['password_1'] == $post['password_2']) {
    $post['user']['password'] = $post['password_1'];
    $user->saveUserdata($post, $post['username']);
    Template::setText('save', True);
  } elseif (!empty($post['password_1']) && $post['password_1'] != $post['password_2']) {
    Template::setText('password_error', True);
  } else {
    $user->saveUserdata($post, $post['username']);
    Template::setText('save', True);
  }

  /**
   * Rechte zum Benutzer speichern
   */
  $db = new Database('SMT-USER');
  $query = "UPDATE db_user SET rechte=:rechte WHERE username=:username";
  $value = array(':rechte' => $post['rechte'], ':username' => $post['username']);
  $db->getQuery($query, $value);

  Base::setRoute('user', 'admin/member/liste');
}

Template::setText('daten', $user->getUser(end($url)));

?>
