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
 * @author      Werner Pallentin <werner.pallentin@outlook.de>
 * @copyright   Copyright (c) Werner Pallentin <werner.pallentin@outlook.de>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v2.1
 * @link        http://palle.zapto.org/
 **/

class License
{

  /**
   * Methode zum auslesen aller Services eines bestimmten Systems
   *
   * @param type $iId
   * @return type
   */
  public function getAll()
  {
    $db = new Database('SMT-ADMIN');

    return $db->getQuery("SELECT * FROM wos_license ORDER BY hersteller", array(), True);
  }

  /**
   * Methode zum auslesen aller Services eines bestimmten Systems
   *
   * @param type $iId
   * @return type
   */
  public function getDetail($id)
  {
    $db = new Database('SMT-ADMIN');
    $file = new File;
    $result = $db->getQuery("SELECT * FROM wos_license WHERE id=:id", array(':id' => $id), True);
    $result['0']['anhang'] = $file->getAttachment('license', $id);

    return $result['0'];
  }

  /**
   * Löschen einer Lizenz
   * @param type $id
   */
  public function delLicense($id)
  {
    $db = new Database('SMT-ADMIN');

    $query = "DELETE FROM wos_license WHERE id=:id";
    $db->getQuery($query, array(':id' => $id));
  }

  /**
   * Methode zum speichern von Lizenzen
   * @param type $post
   * @return type
   */
  public function saveLicense($post)
  {
    $db = new Database('SMT-ADMIN');

    $db->getQuery("INSERT INTO wos_license (anzahl,vmware) VALUES (:anzahl,:vmware)", array(':anzahl' => 1, ':vmware' => 0));
    $id = $db->getLastID();
    $this->updateLicense($id, $post);

    return $id;
  }

  /**
   * Methode zum speichern von Lizenzen
   * @param type $post
   * @return type
   */
  public function updateLicense($id, $post)
  {
    $db = new Database('SMT-ADMIN');

    foreach ($post as $key => $value) {
      if ($value != '') {
        $query = "UPDATE wos_license SET $key=:value WHERE id=:id";
        $value = array(':value' => $value, ':id' => $id);

        $db->getQuery($query, $value);
      }
    }
  }

}

?>
