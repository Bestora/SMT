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

class SSH
{
  private $host = 'localhost';
  private $port = '22';
  private $con = null;
  private $log = '';
  
  public function __construct()
  {
    $this->set('SSH', parse_ini_file(project_path . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.ini', TRUE));
    $this->set('con', ssh2_connect($this->host, $this->port));
    if (!$this->con) {
      $this->set('log', "Connection failed !");
    }
  }
  
  /**
   * @param $sName
   * @param $sValue
   * Standardsetter
   */
  public function set($sName, $sValue)
  {
    $this->$sName = $sValue;
  }
  
  /**
   * Methode zum ausführen des Kommandos auf der Shell
   */
  public function cmdExec()
  {
    $this->authPassword();
    $argc = func_num_args();
    $argv = func_get_args();
    
    $cmd = '';
    for ($i = 0; $i < $argc; $i++) {
      if ($i != ($argc - 1)) {
        $cmd .= $argv[$i] . " && ";
      } else {
        $cmd .= $argv[$i];
      }
    }
    
    $stream = ssh2_exec($this->con, $cmd);
    stream_set_blocking($stream, true);
    return fread($stream, 4096);
  }
  
  /**
   * Methode zum authentifizieren an der Shell
   *
   * @param string $user
   * @param string $password
   */
  protected function authPassword($user = '', $password = '')
  {
    $data = $this->get('SSH');
    
    $this->set('user', $data['SSH_USER']);
    $this->set('password', $data['SSH_PASS']);
    
    if (!ssh2_auth_password($this->get('con'), $this->get('user'), $this->get('password'))) {
      $this->log .= "Authorization failed !";
    }
  }
  
  /**
   * @param $sName
   *
   * @return |null |null
   * Standardgetter
   */
  public function get($sName)
  {
    if (property_exists($this, $sName)) {
      return $this->$sName;
    } else {
      return NULL;
    }
  }
  
  /**
   * Methode zum lesen des logs
   */
  public function getLog()
  {
    return $this->get('log');
  }
  
}