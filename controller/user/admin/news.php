<?php

Template::setText('admin_news_active', 'active');

if ($_SESSION['admin'] === False) {
  base::setRoute('home', 'index', TRUE);
}

// Datenbank initiieren
$db = new Database('SMT-ADMIN');
$url = base::get('url');

if (end($url) == 'save') {
  if (!isset($_POST['id'])) {
    $query = "INSERT INTO wos_news (author,titel,nachricht,controller) VALUE (:author, :titel, :nachricht, :controller)";
    $value = array(':author' => Session::get('username'), ':titel' => $_POST ['titel'], ':nachricht' => $_POST ['nachricht'], ':controller' => $_POST ['controller']);
    
    $db->getQuery($query, $value);
    header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
  }
}

if (end($url) == 'save') {
  if (isset($_POST['id'])) {
    $query = "UPDATE wos_news SET titel=:titel, nachricht=:nachricht, controller=:controller WHERE id=:server_id";
    $value = array(':titel' => $_POST ['titel'], ':nachricht' => $_POST ['nachricht'], ':server_id' => $_POST['id'], ':controller' => $_POST['controller']);
    
    $db->getQuery($query, $value);
    header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
  }
}

if (in_array('delete', $url)) {
  $query = "DELETE FROM wos_news WHERE id=:id";
  $value = array(':id' => end($url));
  
  $db->getQuery($query, $value);
  header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
}


$query = "SELECT * FROM wos_news ORDER BY id DESC";
$db->getQuery($query, array(''));

// Eingelesene Nachrichten ins Template übergeben
template::setText('news_edit', $db->getValue());

?>
