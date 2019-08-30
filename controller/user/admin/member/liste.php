<?php

Template::setText('admin_user_active', 'active');

if (in_array('delete', $url)) {
  $user->delUser(end($url));
  Base::setRoute('user', 'admin/member/liste', TRUE);
}

template::setText('user_liste', $user->listUsers());

?>
