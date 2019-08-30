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

class Handler extends Texte
{

  public $config;
  public $user;

  public function __construct()
  {
    if (!isset($_SESSION['admin'])) {
      $_SESSION['admin'] = False;
    }

    // Config einlesen
    $this->loadConfig();
    // LDAP Authentifizierung
    $this->user = new User($this->config);
    // Prüfung ob es Systemfehler gibt
    $this->checkSystemDNS();
    // Aktuelle Version prüfen und Updatehinweis
    $this->checkVersion(False);
  }


  /**
   * News einlesen
   * @param type $controller
   * @return type
   */
  public function loadNews($controller)
  {
    $db = new Database('SMT-ADMIN');

    $query = "SELECT *, DATE_FORMAT(datum,'%d.%m.%Y %H:%i') AS niceDatum FROM wos_news WHERE controller=:controller || controller=:keineangabe ORDER BY id DESC";
    $db->getQuery($query, array(':controller' => $controller, ':keineangabe' => ''));

    $news = $db->getValue();
    for ($i = 0; $i < count($news); $i++) {
      $news_content[$i]['titel'] = $news[$i]['titel'];
      $news_content[$i]['nachricht'] = $news[$i]['nachricht'];
      $news_content[$i]['datum'] = $news[$i]['niceDatum'];
      $news_content[$i]['author'] = $news[$i]['author'];
    }

    if ($db->getNumrows() > 0) {
      return $news_content;
    }
  }

  /**
   * Lade Konfiguration für die Seite
   */
  protected function loadConfig()
  {
    $session = Session::getInstance();
    $db = new Database('SMT-ADMIN');

    $query = "SELECT * FROM wos_config";
    $db->getQuery($query, array());

    $config = $db->getValue();

    for ($i = 0; $i < count($config); $i++) {
      $this->config[$config[$i]['id']] = $config[$i]['value'];
      if ($config[$i]['id'] == 'pushover_api_token') {
        $session->set('pushover_api_token', $config[$i]['value']);
      }
    }
    Template::setText('config', $this->config);
    Template::setText('max_upload', ini_get('upload_max_filesize'));
  }

  /**
   * Methode zur Darstellung eines DNS Fehlers
   * */
  public function checkSystemDNS()
  {
    $db = new Database('SMT-ADMIN');
    $session = Session::getInstance();

    $db->getQuery("SELECT * FROM wos_dns_cron", array());
    template::setText('DNS_ALERT', $db->getNumrows());
    if ($db->getNumrows() > 0) {
      template::setText('DNSDETAIL', $db->getValue());
    }
  }


  /**
   * Methode zum auslesen des letzzten Updates
   * */
  public function getLastUpdate()
  {
    $db = new Database('SMT-MONITOR');
    $result = $db->getQuery("SELECT * FROM psm_last_update ORDER BY last_update DESC LIMIT 1", array(), True);

    if ($db->getNumrows() > 0) {
      return $result['0'];
    }
  }

  public function checkVersion($check)
  {
    Template::setText('SMTVERSION', $this->config['version']);
    if ($check === True) {
      $v = @file('https://www.php-smt.de/version');
      if ($v['0'] != $this->config['version']) {
        Template::setText('SMTUPDATE', $v['0']);
      }
    }
  }

}

?>
