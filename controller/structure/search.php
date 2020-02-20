<?php

// Dienste und Klassen initiieren
$url = base::get('url');
$time = new Time();
$user = Base::get('Handler')->user;
$ticket = new Ticket;
$server = new Server;
$contract = new Contract;
$active = False;
$referr = filter_input(INPUT_SERVER, 'HTTP_REFERER');

$server_treffer = '';
$services_treffer = '';
$hardware_treffer = '';
$license_treffer = '';
$logfile_treffer = '';
$knowledge_treffer = '';
$ticket_treffer = '';
$password_treffer = '';
$contract_treffer = '';

// Referr prüfen und ggf. umleiten zur KB
if (count($url) > 2) {
  Session::set('sst', urldecode($url['2']));
  Base::setRoute('inventory', 'search', TRUE);
}

// Referr prüfen und ggf. umleiten zur KB
if (NULL !== (filter_input(INPUT_POST, 'search'))) {
  Session::set('sst', filter_input(INPUT_POST, 'search'));
  
  if (preg_match('/knowledge/i', $referr)) {
    Base::setRoute('knowledge', 'index', TRUE);
  }
  
  // Andernfalls die Suchseite neu laden
  Base::setRoute('inventory', 'search', TRUE);
}

/*
 * Suche nach Systemen
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT wos_system_details.systemid,wos_system_details.form_value FROM wos_server,wos_system_details WHERE wos_system_details.form_value LIKE :sst && wos_system_details.systemid=wos_server.id";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);

if ($db->getNumrows() >= 1) {
  $sd = $db->getValue();
  $sdst = '';
  
  for ($i = 0; $i < count($sd); $i++) {
    $sdst .= ' || id=' . $sd[$i]['systemid'];
  }
  
  $query = "SELECT * FROM wos_server WHERE id LIKE :sst || ipadressen LIKE :sst || bezeichnung LIKE :sst || hostname LIKE :sst || aliase LIKE :sst || betriebssystem LIKE :sst || standort LIKE :sst || beschreibung LIKE :sst || verwendungszweck LIKE :sst || technischedaten LIKE :sst || standort LIKE :sst || aliase LIKE :sst $sdst ORDER BY bezeichnung";
  $value = array(':sst' => '%' . Session::get('sst') . '%', ':controller' => Session::get('ssc'), ':id');
} else {
  $query = "SELECT * FROM wos_server WHERE id LIKE :sst || ipadressen LIKE :sst || bezeichnung LIKE :sst || hostname LIKE :sst || aliase LIKE :sst || betriebssystem LIKE :sst || standort LIKE :sst || beschreibung LIKE :sst || verwendungszweck LIKE :sst || technischedaten LIKE :sst || standort LIKE :sst || aliase LIKE :sst ORDER BY bezeichnung";
  $value = array(':sst' => '%' . Session::get('sst') . '%', ':controller' => Session::get('ssc'));
}

$db->getQuery($query, $value, False, False);
template::setText('server_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  $active = True;
  $server_treffer = 'in active';
  template::setText('server_liste', $db->getValue());
}


/**
 * Suche nach Services / Diensten / Remindern
 */
$db = new Database('SMT-MONITOR');
$query = "SELECT *,DATE_FORMAT(last_online,'%d.%m.%Y %H:%i:%s') AS niceDatum FROM psm_servers WHERE ip LIKE :sst || label LIKE :sst || port LIKE :sst || type LIKE :sst || user LIKE :sst ORDER BY INET_ATON(ip)";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);
template::setText('services_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $services_treffer = 'in active';
  }
  template::setText('services_liste', $db->getValue());
}


/*
 * Suche nach Hardware
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT * FROM wos_hardware WHERE bezeichnung LIKE :sst || kategorie LIKE :sst || inventarnummer LIKE :sst || kaufdatum LIKE :sst || hersteller LIKE :sst || modell LIKE :sst || zuordnung LIKE :sst || beschreibung LIKE :sst || seriennummer LIKE :sst ORDER BY kategorie, hersteller, modell DESC";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);
template::setText('hardware_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $hardware_treffer = 'in active';
  }
  
  $hardware = $db->getValue();
  for ($i = 0; $i < count($hardware); $i++) {
    $hardware[$i]['kategorie'] = texte::getText($hardware[$i]['kategorie']);
  }
  template::setText('hardware_liste', $hardware);
}


/*
 * Suche nach Lizenzen
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT * FROM wos_license WHERE hersteller LIKE :sst || produkt LIKE :sst || version LIKE :sst || licensekey LIKE :sst || barcode LIKE :sst || zuordnung LIKE :sst || beschreibung LIKE :sst ORDER BY hersteller, produkt, version DESC";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);
template::setText('license_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1 && Session::get('admin') === True) {
  if ($active === False) {
    $active = True;
    $license_treffer = 'in active';
  }
  template::setText('license_liste', $db->getValue());
}


/*
 * Suche nach Logfileeinträgen
 */
$db = new Database('SMT-MONITOR');
$query = "SELECT *,DATE_FORMAT(datetime,'%d.%m.%Y %H:%i') AS niceDatum FROM psm_log WHERE server_id LIKE :sst || message LIKE :sst || datetime LIKE :sst ORDER BY datetime DESC";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);
template::setText('logfile_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $logfile_treffer = 'in active';
  }
  template::setText('logfile_liste', $db->getValue());
}


/*
 * Suche nach Einträgen in der Knowledge Base
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT *,DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_knowledge WHERE id LIKE :sst || page_name LIKE :sst || page_content LIKE :sst || uploads LIKE :sst || keywords LIKE :sst ORDER BY datum DESC";
$value = array(':sst' => '%' . Session::get('sst') . '%');

$db->getQuery($query, $value, False, False);
template::setText('knowledge_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $knowledge_treffer = 'in active';
  }
  template::setText('knowledge_liste', $db->getValue());
}


/*
 * Suche nach Tickets
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT * FROM wos_ticket WHERE id LIKE :sst && tid=:tid || titel LIKE :sst && tid=:tid || beschreibung LIKE :sst && tid=:tid || anhang LIKE :sst && tid=:tid ORDER BY datum DESC";
$value = array(':sst' => '%' . Session::get('sst') . '%', ':tid' => 0);

$db->getQuery($query, $value, False, False);
template::setText('ticket_anzahl', $db->getNumrows());
$ticket_liste = $db->getValue();

for ($l = 0; $l < count($ticket_liste); $l++) {
  $detail = $ticket->readTicket($ticket_liste[$l]['id']);
  include(project_path . '/controller/ticket/ticket_details.php');
  
  $tmp[$l] = $detail;
  unset($detail);
}

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $ticket_treffer = 'in active';
  }
  template::setText('ticket_liste', $tmp);
}


/*
 * Suche nach Passwörtern
 */
$db = new Database('SMT-ADMIN');
$query = "SELECT * FROM wos_password WHERE username LIKE :sst && private=:notPrivate || verwendung LIKE :sst && private=:notPrivate || url LIKE :sst && private=:notPrivate";
$value = array(':sst' => '%' . Session::get('sst') . '%', ':notPrivate' => '0');

$db->getQuery($query, $value, False, False);
template::setText('password_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $password_treffer = 'in active';
  }
  template::setText('password_liste', $db->getValue());
}


/*
 * Suche nach Contracts
 */
$db = new Database('SMT-ADMIN');

$query = "SELECT * FROM wos_contract, wos_contract_details WHERE wos_contract.bezeichnung LIKE :sst || vertragsnummer LIKE :sst || vertragspartner LIKE :sst || beschreibung LIKE :sst || kategorie LIKE :sst || abteilung LIKE :sst || verantwortlicher LIKE :sst";
$value = array(':sst' => '%' . Session::get('sst') . '%');


$db->getQuery($query, $value, False, False);
template::setText('contract_anzahl', $db->getNumrows());

if ($db->getNumrows() >= 1) {
  if ($active === False) {
    $active = True;
    $contract_treffer = 'in active';
  }
  
  $contract = $db->getValue();
  template::setText('contract_liste', $contract);
}

template::setText('server_treffer', $server_treffer);
template::setText('services_treffer', $services_treffer);
template::setText('hardware_treffer', $hardware_treffer);
template::setText('license_treffer', $license_treffer);
template::setText('logfile_treffer', $logfile_treffer);
template::setText('knowledge_treffer', $knowledge_treffer);
template::setText('ticket_treffer', $ticket_treffer);
template::setText('password_treffer', $password_treffer);
template::setText('contract_treffer', $contract_treffer);

?>
