<?php

$list = $ticket->listTickets();

for ($l = 0; $l < count($list); $l++) {
  $detail = $ticket->readTicket($list[$l]['id']);
  include('ticket_details.php');
  
  $tmp[$l] = $detail;
  unset($detail);
}

if (isset($tmp)) {
  template::setText('ticket_liste', $tmp);
}

?>
