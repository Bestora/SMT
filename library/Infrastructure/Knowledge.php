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

class Knowledge
{

  /**
   * Methode zum einlesen und übergeben vom Menü
   * @param type $page
   * @return string
   */
  public function loadMenu($page)
  {
    $session = Session::getInstance();
    $db = new Database('SMT-ADMIN');

    $q = '';
    $value = array('visible' => '1');
    $order = 'page_name';

    if ($session->get('sst')) {
      $ss = explode(' ', $session->get('sst'));

      for ($i = 0; $i < count($ss); $i++) {
        $q .= "page_content LIKE :sst$i && ";
        $value[':sst' . $i] = "%{$ss[$i]}%";
      }
    }

    $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_knowledge WHERE $q visible=:visible", $value, True);
    $v = $db->getValue();

    return $v;
  }

  /**
   * Lesen und Übergabe eines Eintrages
   * @param type $page
   * @return type
   */
  public function loadContent($page)
  {
    $file = new File;
    $db = new Database('SMT-ADMIN');
    $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_knowledge WHERE id=:id", array('id' => $page), True);

    $v = $db->getValue();
    $v = $v['0'];

    $v['uploads'] = explode(',', $v['uploads']);
    for ($i = 0; $i < count($v['uploads']); $i++) {
      $u[$i]['name'] = $v['uploads'][$i];
      $u[$i]['size'] = $file->get_size(project_path . '/assets/uploads/' . $u[$i]['name'], filesize(project_path . '/assets/uploads/' . $u[$i]['name']));
    }
    $v['uploads'] = $u;

    if (empty($v['uploads']['0']['name'])) {
      unset($v['uploads']);
    }

    return $v;
  }


  /**
   * Lesen und Übergabe eines Eintrages
   * @param type $page
   * @return type
   */
  public function loadHistory($page)
  {
    $file = new File;
    $db = new Database('SMT-ADMIN');
    $db->getQuery("SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_knowledge_history WHERE parent=:id", array('id' => $page), True);

    return $db->getValue();
  }

  /**
   * Die letzten 5 Beiträge laden
   * @return type
   */
  public function loadStart()
  {
    $db = new Database('SMT-ADMIN');
    $db->getQuery("SELECT * FROM wos_knowledge ORDER BY datum LIMIT 5", array(), True, False);

    return $db->getValue();
  }

  /**
   * Neuen Eintrag anlegen
   * @param type $post
   * @return type
   */
  public function saveNew($post)
  {
    $db = new Database('SMT-ADMIN');

    $query = "INSERT INTO wos_knowledge (datum,page_name,page_content,keywords,version,uploads) VALUE (:datum,:name,:content,:keywords,:version,:uploads)";
    $value = array(':datum' => date("Y-m-d H:i:s"), ':name' => $post['page_name'], ':content' => $post['page_content'], ':keywords' => $post['keywords'], ':version' => '1.0', ':uploads' => $post['uploads']);
    $db->getQuery($query, $value);

    $kb = $db->getLastID();

    $query = "INSERT INTO wos_knowledge_history (parent,version,datum,user,content,uploads) VALUE (:parent,:version,:datum,:user:,:content,:uploads)";
    $value = array(':parent' => $kb, ':version' => '1.00', ':datum' => date("Y-m-d H:i:s"), ':user' => $_SESSION['usernam'], ':content' => $post['page_content'], ':uploads' => $post['uploads']);
    $db->getQuery($query, $value);

    return $kb;
  }

  /**
   * Geänderten Eintrag speichern
   * @param type $post
   * @param type $id
   */
  public function saveEdit($post, $id)
  {
    $db = new Database('SMT-ADMIN');

    $query = "INSERT INTO wos_knowledge_history (parent,version,datum,user,content) VALUE (:parent,:version,:datum,:user,:content)";
    $value = array(':parent' => $id, ':version' => ($tmp['0']['version'] + 0.1), ':datum' => date("Y-m-d H:i:s"), ':user' => $_SESSION['username'], ':content' => $post['page_content']);
    $db->getQuery($query, $value);

    if (!empty($post['uploads'])) {
      $tmp = $db->getQuery("SELECT * FROM wos_knowledge WHERE id=:id", array(':id' => $id), True);
      $post['uploads'] = $post['uploads'] . ',' . $tmp['0']['uploads'];

      $query = "UPDATE wos_knowledge SET page_name=:name, page_content=:content, keywords=:keywords, version=version+0.1, uploads=:uploads WHERE id=:id";
      $value = array(':name' => $post['page_name'], ':content' => $post['page_content'], ':keywords' => $post['keywords'], ':id' => $id, ':uploads' => $post['uploads']);
    } else {
      $query = "UPDATE wos_knowledge SET page_name=:name, page_content=:content, keywords=:keywords, version=version+0.1 WHERE id=:id";
      $value = array(':name' => $post['page_name'], ':content' => $post['page_content'], ':keywords' => $post['keywords'], ':id' => $id);
    }

    $db->getQuery($query, $value);
  }

  /**
   * Einen Eintrag löschen
   * @param type $id
   */
  public function delete($id)
  {
    $db = new Database('SMT-ADMIN');

    $query = "DELETE FROM wos_knowledge WHERE id=:id";
    $value = array(':id' => $id);

    $db->getQuery($query, $value);
  }

}

?>
