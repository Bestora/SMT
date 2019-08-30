<?php

if (end($url) == 'save') {
  $user->createUser($_POST);
  Base::setRoute('user', 'admin/member/liste');
}

?>
