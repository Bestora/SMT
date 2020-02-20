<?php

/**
 * PHP SMT by palle
 * Monitor your servers and websites.
 *
 * This file is part of PHP SMT by palle.
 * PHP SMT by palle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP SMT by palle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP SMT by palle.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     SMT
 * @author      Werner Pallentin <wpa@palle.de>
 * @copyright   Copyright (c) Werner Pallentin <wpa@palle.de>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.1
 * @link        https://smt.palle.dev
 **/

class Ticket
{
  
  /**
   * Ticket und Antworten löschen
   *
   * @param int $id
   */
  public function deleteTicket($id)
  {
    $db = new Database('SMT-ADMIN');
    $db->getQuery("DELETE FROM wos_ticket WHERE id=:id || tid=:id", array(':id' => $id));
    $db->getQuery("DELETE FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'ticket'));
  }
  
  /**
   * Methode zum auflisten aller Tickets
   *
   * @param string $sUsername
   *
   * @return string
   */
  public function listTickets($sUsername = '')
  {
    $db = new Database('SMT-ADMIN');
    
    $sWhere = 'tid=:tid';
    $sValue = array(':tid' => 0);
    
    if (!empty($sUsername)) {
      $sWhere = 'zuordnung=:zuordnung AND tid=:tid AND closed=:closed';
      $sValue = array(':zuordnung' => $sUsername, ':tid' => 0, ':closed' => 0);
    }
    
    $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_ticket WHERE $sWhere ORDER BY closed ASC", $sValue);
    return $db->getValue();
  }
  
  /**
   * Details zu einem Ticket einlesen
   *
   * @param int $id
   *
   * @return array
   */
  public function readTicket($id)
  {
    $db = new Database('SMT-ADMIN');
    $ticket = array();
    
    $ticket['ticket'] = $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum, DATE_FORMAT(abgabetermin,'%d.%m.%Y') AS niceAbgabetermin FROM wos_ticket WHERE id=:id", array(':id' => $id), True);
    $ticket['comment'] = $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum, DATE_FORMAT(abgabetermin,'%d.%m.%Y') AS niceAbgabetermin FROM wos_ticket WHERE tid=:id ORDER BY id ASC", array(':id' => $id), True);
    $ticket['anhang'] = $db->getQuery("SELECT * FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'ticket'), True);
    
    
    return $ticket;
  }
  
  /**
   * Methode zum speichern eines Tickets
   *
   * @param array $post
   *
   * @return int $id
   */
  public function saveNewTicket($post)
  {
    $db = new Database('SMT-ADMIN');
    $db->getQuery("INSERT INTO wos_ticket (datum) VALUE (:datum)", array(':datum' => date("Y-m-d H:i:s")));
    
    $id = $db->getLastID();
    $this->updateTicket($post, $id);
    
    return $id;
  }
  
  /**
   * Methode zum updaten eines Eintrags
   *
   * @param array $post
   * @param int $id
   */
  public function updateTicket($post, $id)
  {
    $db = new Database('SMT-ADMIN');
    
    $aData = array();
    
    $aData[':id'] = $id;
    $aData[':user'] = $_SESSION['username'];
    $query = 'user=:user,';
    
    foreach ($post AS $name => $value) {
      if (is_array($value)) {
        $aData[':' . $name] = implode(',', $value);
        $query .= $name . '=:' . $name . ',';
      } else {
        $aData[':' . $name] = $value;
        $query .= $name . '=:' . $name . ',';
      }
    }
    
    $db->getQuery("UPDATE wos_ticket SET " . substr($query, 0, -1) . " WHERE id=:id", $aData, False);
    
    if (isset($_POST['tid'])) {
      $db->getQuery("UPDATE wos_ticket SET zuordnung=:zuordnung WHERE id=:tid", array(':zuordnung' => $_POST['zuordnung'], ':tid' => $_POST['tid']));
      if ($_POST['ticket_status'] == 'ticket_status_geschlossen') {
        $db->getQuery("UPDATE wos_ticket SET closed=:closed WHERE id=:tid", array(':closed' => 1, ':tid' => $_POST['tid']));
      } else {
        $db->getQuery("UPDATE wos_ticket SET closed=:closed WHERE id=:tid", array(':closed' => 0, ':tid' => $_POST['tid']));
      }
    }
  }
  
}