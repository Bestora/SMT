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

class Base extends Content
{
  
  public function __construct()
  {
    parent::__construct();
  }
  
  /**
   * Erstellt einen beliebigen Zufallscode
   *
   * @staticvar <string> $code
   * @param int $iLength
   *
   * @return <string> code
   */
  public static function createCode($iLength = 8)
  {
    static $code = '';
    
    $zeichen = "qwertzupasdfghkyxcvbnm";
    $zeichen .= "123456789";
    $zeichen .= "WERTZUPLKJHGFDSAYXCVBNM";
    
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $iLength; $i++) {
      $code .= substr($zeichen, (rand() % (strlen($zeichen))), 1);
    }
    
    return $code;
  }
  
  /**
   * INI Konfiguration oeffnen
   *
   * @param <string> $sFile
   */
  public function getConfig($sFile)
  {
    $aData = array();
    $aData = parse_ini_file($sFile, TRUE);
    $this->readConfig($aData);
  }
  
  /**
   * Konfigurationsdaten verabeiten und ueber
   * den Standardgetter der Anwedung verarbeiten
   *
   * @param <array> $aData
   */
  public function readConfig($aData)
  {
    foreach ($aData as $name => $value) {
      $this->set($name, $value);
    }
  }
  
  /**
   * Standardsetter der Anwendung
   *
   * @param <string> $sName
   * @param <beliebig> $sValue
   * @param bool $text
   */
  public function set($sName, $sValue, $text = False)
  {
    $this->$sName = $sValue;
  }
  
  /**
   * Methode zum umleiten bzw.
   * registrieren eines Controllers / Methode
   *
   * @param <type> $controller
   * @param <type> $methode
   * @param bool $full
   */
  public function setRoute($controller, $methode, $full = TRUE)
  {
    if ($controller == '') {
      $url = $this->get('url');
      
      if (is_array($url)) {
        $controller = $url ['0'];
        $methode = $url ['1'];
      } else {
        $controller = 'home';
        $methode = 'index';
      }
    }
    
    if ($full === TRUE && $controller != 'content') {
      die(header("Location: " . $this->get('getPath') . '/' . $controller . '/' . $methode));
    } elseif ($full === TRUE && $controller == 'content') {
      die(header("Location: " . $this->get('getPath') . '/' . $methode));
    } else {
      $this->set('controller', $controller);
      $this->set('methode', $methode);
    }
  }
  
  /**
   * Standardgetter der Anwendung
   *
   * @param <string> $sName
   *
   * @return <beliebig>
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
   * Klasse dem System bereit stellen
   *
   * @param <type> $sClass
   * @param bool $gInstance
   * @param bool $bReturn
   *
   * @return <type> $gInstance
   */
  public function registerClass($sClass, $gInstance = False, $bReturn = False)
  {
    if ($gInstance === True) {
      $this->set($sClass, True, False);
    } else {
      if ($gInstance === False) {
        $this->set($sClass, new $sClass());
        
        if ($bReturn === TRUE) {
          return $this->get($sClass);
        }
      } else {
        $this->set($gInstance, new $sClass($gInstance));
        
        if ($bReturn === TRUE) {
          return $this->get($gInstance);
        }
      }
    }
  }
}
