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

class LDAP
{

  // Active Directory server
  public $ldap_host;
  // Active Directory DN
  public $ldap_dn;
  // Active Directory user group
  public $ldap_user_group;
  // Active Directory manager group
  public $ldap_manager_group;
  // Domain, for purposes of constructing $user
  public $ldap_usr_dom;
  // ldap User
  protected $ldap_user;
  // ldap Pass
  protected $ldap_pass;
  // Verbindung wird hier zwischengepseichert
  protected $ldap;
  // Benutzerlogin speichern
  public $isAuth = False;

  /**
   * Konstruktor, Config setzen und authentifizieren
   * @param type $user
   * @param type $pass
   * @param type $conf
   */
  public function __construct($user, $pass, $conf)
  {
    $this->setConfig($conf);
    $this->ldapAuth($user, $pass);
  }

  /**
   * Methode zur Prüfung ob der Benutzer eingeloggt ist
   * @return boolean
   */
  public function getAuth()
  {
    return $isAuth;
  }

  /**
   * Methode zum setzen der Konfiguration
   * @param type $conf
   */
  public function setConfig($conf)
  {
    $this->ldap_host = $conf['ldap_host'];
    $this->ldap_dn = $conf['ldap_dn'];
    $this->ldap_user_group = $conf['ldap_user_group'];
    $this->ldap_manager_group = $conf['ldap_manager_group'];
    $this->ldap_usr_dom = $conf['ldap_usr_dom'];
    $this->ldap_user = $conf['ldap_user'];
    $this->ldap_pass = $conf['ldap_pass'];
    $this->user_auth_field = $conf['ldap_user_auth_field'];
  }

  /**
   * Prüfung ob der User eingeloggt ist
   * @param $sUser
   */
  public function checkUser($sUser)
  {
    $session = Session::getInstance();
    // Gruppe prüfen ob er berechtigt ist
    if ($this->ldapGroupSearch($this->ldap_manager_group, $sUser)) {
      $session->set('admin', True);
    } else {
      $session->destroy();
    }
  }

  /**
   * Methode zum verbinden zum LDAP
   * @param type $user
   * @param type $pass
   * @return type
   * @throws Exception
   */
  public function ldapAuth($user, $pass)
  {
    $ldap = ldap_connect($this->ldap_host) OR DIE ('LDAP connect failed');

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $res = ldap_bind($ldap, $user, $pass);
    $this->isAuth = $res;
  }

  /**
   * Methode zum verbinden zum LDAP
   * @param type $user
   * @param type $pass
   * @return type
   * @throws Exception
   */
  public function ldapConnect($user, $pass)
  {
    $ldap = ldap_connect($this->ldap_host);

    if ($ldap === false) {
      throw new Exception('LDAP connnect failed');
    }

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $res = ldap_bind($ldap, $user . $this->ldap_usr_dom, $pass);

    if ($res === True && !isset($_SESSION['username'])) {
      $_SESSION['username'] = $user;
    }

    return $ldap;
  }

  /**
   * Auslesen der Email Adresse zu einem Benutzerkürzel
   * @param type $field
   * @param type $search
   * @return type
   */
  public function ldapSearch($field, $sUser)
  {
    $this->ldap = $this->ldapConnect($this->ldap_user, $this->ldap_pass);
    $result = ldap_search($this->ldap, $this->ldap_dn, "(" . $this->user_auth_field . "=" . $sUser . ")", $field) or exit("Unable to search LDAP server");
    $entries = ldap_get_entries($this->ldap, $result);

    return $entries['0'];
  }

  /**
   * Prüfung ob der User in einer bestimmten Gruppe ist
   * @param type $group
   * @param type $search
   * @return boolean
   */
  public function ldapGroupSearch($group, $search)
  {
    $return = False;
    $this->ldap = $this->ldapConnect($this->ldap_user, $this->ldap_pass);
    $result = ldap_search($this->ldap, $this->ldap_dn, "(" . $this->user_auth_field . "=" . $search . ")", array('memberof')) or exit("Unable to search LDAP server");
    $entries = ldap_get_entries($this->ldap, $result);

    unset($entries['0']['memberof']['count']);
    $groups = array_merge($entries['0']['memberof']);

    for ($i = 0; $i < count($groups); $i++) {
      if (preg_match("/$group/i", $groups[$i]))
        $return = True;
    }

    return $return;
  }

}

?>
