<?php

$list = $ticket->listTickets($ses->get('username'));

for ($l = 0; $l < count($list); $l++) {
  if ($list[$l]['tid'] != 0) {
    $list[$l]['id'] = $list[$l]['tid'];
  }
  
  $detail = $ticket->readTicket($list[$l]['id']);
  include('ticket_details.php');
  
  $tmp[$l] = $detail;
  unset($detail);
}

if (isset($tmp)) {
  template::setText('ticket_liste', $tmp);
}

?>
