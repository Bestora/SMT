<?php

// Hier die Benutzer (Zuordnung) durchlaufen und den Usernamen durch den DisplayNamen erstzen
$detail['ticket']['0']['user'] = $user->getUserDaten('db_user_private', $detail['ticket']['0']['user'], 'displayName');
$detail['ticket']['0']['zuordnung'] = $user->getUserDaten('db_user_private', $detail['ticket']['0']['zuordnung'], 'displayName');
$detail['ticket']['0']['hinweis_titel'] = texte::getText('hinweis_titel_ticket') . ' ' . texte::getText('system_blaetter_from') . ' ' . $detail['ticket']['0']['user'] . ' ' . $time->ago(new DateTime(date($detail['ticket']['0']['datum']))) . ' ' . texte::getText('hinweis_titel_gemeldet');

if (count($detail['comment']) > 0) {
  for ($c = 0; $c < count($detail['comment']); $c++) {
    $detail['comment'][$c]['hinweis_text'] = '';
    
    $detail['comment'][$c]['user'] = $user->getUserDaten('db_user_private', $detail['comment'][$c]['user'], 'displayName');
    $detail['comment'][$c]['zuordnung'] = $user->getUserDaten('db_user_private', $detail['comment'][$c]['zuordnung'], 'displayName');
    
    // Prüfung der Zuordnung
    if ($c != 0 && $detail['comment'][$c]['zuordnung'] != $detail['comment'][($c - 1)]['zuordnung']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_zuordnung') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . $detail['comment'][($c - 1)]['zuordnung'] . '</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . $detail['comment'][$c]['zuordnung'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung des Status
    if ($c != 0 && $detail['comment'][$c]['ticket_status'] != $detail['comment'][($c - 1)]['ticket_status']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_status') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . texte::getText($detail['comment'][($c - 1)]['ticket_status']) . '</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . texte::getText($detail['comment'][$c]['ticket_status']) . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung des Abgabetermins
    if ($c != 0 && $detail['comment'][$c]['abgabetermin'] != $detail['comment'][($c - 1)]['abgabetermin']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_abgabe_datum') . '</b> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . $detail['comment'][$c]['niceAbgabetermin'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung des Titels
    if ($c != 0 && $detail['comment'][$c]['titel'] != $detail['comment'][($c - 1)]['titel']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_titel') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . $detail['comment'][($c - 1)]['titel'] . '</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . $detail['comment'][$c]['titel'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung des Fortschitts
    if ($c != 0 && $detail['comment'][$c]['fortschritt'] != $detail['comment'][($c - 1)]['fortschritt']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_fortschritt') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . $detail['comment'][($c - 1)]['fortschritt'] . '%</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . $detail['comment'][$c]['fortschritt'] . '%</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung der Priorität
    if ($c != 0 && $detail['comment'][$c]['prio'] != $detail['comment'][($c - 1)]['prio']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_prio') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . texte::getText($detail['comment'][($c - 1)]['prio']) . '</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . texte::getText($detail['comment'][$c]['prio']) . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    // Prüfung der Anhänge
    if ($c != 0 && $detail['comment'][$c]['anhang'] != $detail['comment'][($c - 1)]['anhang'] && Base::get('methode') == 'detail') {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_anhang') . ' ' . texte::getText('ticket_historie_upload') . '</b></li>';
      $detail['comment'][$c]['hinweis_text'] .= '<ul>';
      
      if (!empty($detail['comment'][$c]['anhang'])) {
        $tmp = explode(',', $detail['comment'][$c]['anhang']);
        for ($a = 0; $a < count($tmp); $a++) {
          $detail['comment'][$c]['hinweis_text'] .= '<li><a href="/ticket/detail/download/' . urlencode($tmp[$a]) . '"><i>' . $tmp[$a] . '</i></a>';
        }
        $detail['comment'][$c]['hinweis_text'] .= '</ul>';
      }
    }
    if ($c != 0 && $detail['comment'][$c]['smt_system'] != $detail['comment'][($c - 1)]['smt_system']) {
      $detail['comment'][$c]['hinweis_text'] .= '<li><b>' . texte::getText('ticket_system') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' <i>' . $detail['comment'][($c - 1)]['smt_system'] . '</i> '
        . '' . texte::getText('ticket_detail_hinweis_2') . ' <i>' . $detail['comment'][$c]['smt_system'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
    }
    
    $detail['comment'][$c]['hinweis_titel'] = texte::getText('hinweis_titel_ticket') . ' ' . texte::getText('system_blaetter_from') . ' ' . $detail['comment'][$c]['user'] . ' ' . $time->ago(new DateTime(date($detail['comment'][$c]['datum']))) . ' ' . texte::getText('ticket_detail_hinweis_3');
  }
}


if (count($detail['comment']) >= 1) {
  // Prüfung der Zuordnung
  if ($detail['ticket']['0']['zuordnung'] != $detail['comment']['0']['zuordnung']) {
    $detail['comment']['0']['hinweis_text'] = '<li><b>' . texte::getText('ticket_zuordnung') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . $detail['ticket']['0']['zuordnung'] . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . $detail['comment']['0']['zuordnung'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung des Status
  if ($c != 0 && $detail['ticket']['0']['ticket_status'] != $detail['comment']['0']['ticket_status']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_status') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . texte::getText($detail['ticket']['0']['ticket_status']) . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . texte::getText($detail['comment']['0']['ticket_status']) . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung des Abgabetermins
  if ($detail['ticket']['0']['abgabetermin'] != $detail['comment']['0']['abgabetermin']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_abgabe_datum') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . $detail['ticket']['0']['abgabetermin'] . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . $detail['comment']['0']['niceAbgabetermin'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung des Titels
  if ($detail['ticket']['0']['titel'] != $detail['comment']['0']['titel']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_titel') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . $detail['ticket']['0']['titel'] . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . $detail['comment']['0']['titel'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung des Fortschritts
  if ($detail['ticket']['0']['fortschritt'] != $detail['comment']['0']['fortschritt']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_fortschritt') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . $detail['ticket']['0']['fortschritt'] . '%</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . $detail['comment']['0']['fortschritt'] . '%</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung der Priorität
  if ($c != 0 && $detail['ticket']['0']['prio'] != $detail['comment']['0']['prio']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_prio') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . texte::getText($detail['ticket']['0']['prio']) . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . texte::getText($detail['comment']['0']['prio']) . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  // Prüfung der Anhänge
  if ($detail['ticket']['0']['anhang'] != $detail['comment']['0']['anhang'] && Base::get('methode') == 'detail') {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_anhang') . ' ' . texte::getText('ticket_historie_upload') . '</b></li>';
    $detail['comment']['0']['hinweis_text'] .= '<ul>';
    
    if (!empty($detail['comment']['0']['anhang'])) {
      $tmp = explode(',', $detail['comment']['0']['anhang']);
      for ($a = 0; $a < count($tmp); $a++) {
        $detail['comment']['0']['hinweis_text'] .= '<li><a href="/ticket/detail/download/' . urlencode($tmp[$a]) . '"><i>' . $tmp[$a] . '</i></a>';
      }
      $detail['comment']['0']['hinweis_text'] .= '</ul>';
    }
  }
  // Prüfung des SMT Systems
  if ($detail['ticket']['0']['smt_system'] != $detail['comment']['0']['smt_system']) {
    $detail['comment']['0']['hinweis_text'] .= '<li><b>' . texte::getText('ticket_system') . '</b> ' . texte::getText('ticket_detail_hinweis_1') . ' '
      . '<i>' . $detail['ticket']['0']['smt_system'] . '</i> ' . texte::getText('ticket_detail_hinweis_2') . ' '
      . '<i>' . $detail['comment']['0']['smt_system'] . '</i> ' . texte::getText('ticket_detail_hinweis_3') . '</li>';
  }
  
  $last = (count($detail['comment']) - 1);
  $detail['ticket']['0']['zuordnung'] = $detail['comment'][$last]['zuordnung'];
  $detail['ticket']['0']['ticket_status'] = texte::getText($detail['comment'][$last]['ticket_status']);
  $detail['ticket']['0']['fortschritt'] = $detail['comment'][$last]['fortschritt'];
  $detail['ticket']['0']['prio'] = texte::getText($detail['comment'][$last]['prio']);
  $detail['ticket']['0']['abgabetermin'] = $detail['comment'][$last]['abgabetermin'];
  $detail['ticket']['0']['niceAbgabetermin'] = $detail['comment'][$last]['niceAbgabetermin'];
  $detail['ticket']['0']['comments'] = count($detail['comment']);
  
  if ($detail['comment'][$last]['smt_system'] != 0) {
    $detail['ticket']['0']['smt_system'] = $server->getSystem($detail['comment'][$last]['smt_system'], False, True);
  } else {
    unset($detail['ticket']['0']['smt_system']);
  }
} else {
  unset($detail['comment']);
  $detail['ticket']['0']['ticket_status'] = texte::getText($detail['ticket']['0']['ticket_status']);
  $detail['ticket']['0']['prio'] = texte::getText($detail['ticket']['0']['prio']);
  
  if ($detail['ticket']['0']['smt_system'] != 0) {
    $detail['ticket']['0']['smt_system'] = $server->getSystem($detail['ticket']['0']['smt_system'], False, True);
  } else {
    unset($detail['ticket']['0']['smt_system']);
  }
}

// Anhänge einlesen
if (!empty($detail['ticket']['0']['anhang'])) {
  $detail['ticket']['0']['anhang'] = explode(',', $detail['ticket']['0']['anhang']);
  for ($i = 0; $i < count($detail['ticket']['0']['anhang']); $i++) {
    $u[$i]['name'] = $detail['ticket']['0']['anhang'][$i];
    $u[$i]['size'] = $file->get_size(project_path . '/assets/uploads/' . $u[$i]['name'], filesize(project_path . '/assets/uploads/' . $u[$i]['name']));
  }
  $detail['ticket']['0']['anhang'] = $u;
}

if (empty($detail['ticket']['0']['anhang'])) {
  unset($detail['ticket']['0']['anhang']);
}

?>
