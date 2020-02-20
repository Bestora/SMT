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

class Hardware
{
  
  /**
   * Hardwaredaten einlesen, ohne ID werden alle Datensätze gelesen
   * mit ID nur die Details zu einem Datensatz
   *
   * @param string $id
   *
   * @return string
   */
  public function getHardware($id = '')
  {
    $db = new Database('SMT-ADMIN');
    $file = new File;
    
    if (empty($id)) {
      $db->getQuery("SELECT *, DATE_FORMAT(kaufdatum,'%d.%m.%Y') FROM wos_hardware ORDER BY id DESC", array(), False);
      
      $hardware = $db->getValue();
      for ($i = 0; $i < count($hardware); $i++) {
        $hardware[$i]['kategorie'] = texte::getText($hardware[$i]['kategorie']);
      }
      return $hardware;
      
    } else {
      $det['hardware'] = $db->getQuery("SELECT * FROM wos_hardware WHERE id=:id", array(':id' => $id), True);
      $det['anhang'] = $db->getQuery("SELECT * FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'hardware'), True);
      $det['detail'] = $db->getQuery("SELECT * FROM wos_hardware_details WHERE hardware_id=:id", array(':id' => $id), True);
      
      return $det;
    }
  }
  
  /**
   * Methode zum speichern der Daten
   * Aufruf und Übergabe der Daten an die update Funktion
   *
   * @param $post
   *
   * @return |null
   */
  public function saveHardware($post)
  {
    $db = new Database('SMT-ADMIN');
    
    $query = "INSERT INTO wos_hardware (bezeichnung) VALUE (:bezeichnung)";
    $value = array(':bezeichnung' => $post['bezeichnung']);
    
    $db->getQuery($query, $value);
    $id = $db->getLastID();
    
    $this->updateHardware($id, $post);
    return $id;
  }
  
  /**
   *
   * @param type $id
   * @param $post
   */
  public function updateHardware($id, $post)
  {
    $db = new Database('SMT-ADMIN');
    
    if (empty($post['bezeichnung'])) {
      $post['bezeichnung'] = $post['hersteller'] . ' ' . $post['modell'];
      if (!empty($post['zuordnung'])) {
        $post['bezeichnung'] .= ' (' . $post['zuordnung'] . ')';
      } else {
        $post['bezeichnung'] .= ' (' . $post['inventarnummer'] . ')';
      }
    }
    
    foreach ($post as $key => $value) {
      if (!preg_match('/detail_/', $key)) {
        $query = "UPDATE wos_hardware SET $key=:value WHERE id=:id";
        $value = array(':value' => $value, ':id' => $id);
        
        $db->getQuery($query, $value);
      }
    }
    
    if (isset($post['detail_name'])) {
      // Vorhandene Werte löschen und dann neu schreiben
      $db->getQuery("DELETE FROM wos_hardware_details WHERE hardware_id=:id", array(':id' => $id));
      
      $detail_name = $post['detail_name'];
      $detail_value = $post['detail_value'];
      
      for ($i = 0; $i < count($detail_name); $i++) {
        $query = "INSERT INTO wos_hardware_details (hardware_id, form_name, form_value) VALUE (:id, :name, :value)";
        $value = array(':name' => $detail_name[$i], ':value' => $detail_value[$i], ':id' => $id);
        
        if (!empty($detail_name[$i]) && !empty($detail_value[$i])) {
          $db->getQuery($query, $value);
        }
      }
    }
  }
  
  /**
   * Methode zum löschen eines Eintrags
   *
   * @param type $id
   */
  public function deleteHardware($id)
  {
    $db = new Database('SMT-ADMIN');
    $db->getQuery("DELETE FROM wos_hardware WHERE id=:id", array(':id' => $id));
    $db->getQuery("DELETE FROM wos_hardware_details WHERE hardware_id=:id", array(':id' => $id));
    $db->getQuery("DELETE FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'hardware'));
  }
  
}