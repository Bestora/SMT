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
      if ($config[$i]['id'] == 'messsagebird_flowtoken') {
        $session->set('messsagebird_flowtoken', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'messagebird_api_token') {
        $session->set('messagebird_api_token', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'monitor_email_address') {
        $session->set('monitor_email_address', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'starface_login_id') {
        $session->set('starface_login_id', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'starface_login_pw') {
        $session->set('starface_login_pw', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'starface_user_id') {
        $session->set('starface_user_id', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'telegram_api_key') {
        $session->set('telegram_api_key', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'telegram_bot') {
        $session->set('telegram_bot', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'telegram_chat_id') {
        $session->set('telegram_chat_id', $config[$i]['value']);
      }
      if ($config[$i]['id'] == 'controller') {
        Template::setText('configController', explode(',', $config[$i]['value']));
        $session->set('configController', explode(',', $config[$i]['value']));
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
   * Methode zum prüfen der Version
   *
   * @param $check
   */
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
  
}