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

class Template
{
  
  public function __construct()
  {
    require project_vendor . '/phptal/phptal/classes/PHPTAL.php';
    $this->vorlage = project_path . '/template/index.xhtml';
    $this->setText('page_title', $this->get('page_title'));
    $this->set('phptal', new PHPTAL($this->vorlage));
    $this->showOuput();
  }
  
  public function setText($sName, $sValue)
  {
    $tpl = $this->get('tpl');
    $number = @count($tpl);
    
    if (!is_array($sName)) {
      $tpl [$number] ['name'] = $sName;
      $tpl [$number] ['value'] = $sValue;
    }
    
    if (is_array($sName) && !empty($sValue)) {
      $anzahl = count($sName);
      for ($i = 0; $i < $anzahl; $i++) {
        $tpl [$number] ['name'] = $sName [$i];
        $tpl [$number] ['value'] = $sValue [$i];
        
        $number++;
      }
    }
    
    if (is_array($sName) && empty($sValue)) {
      foreach ($sName as $name => $value) {
        $tpl [$number] ['name'] = $name;
        $tpl [$number] ['value'] = $value;
        
        $number++;
      }
    }
    $this->set('tpl', $tpl);
  }
  
  /**
   * Methode zur Ausgabe der Seite
   */
  public function showOuput()
  {
    $this->setText('getPath', $this->get('getPath'));
    $this->setText('getPathUrl', $this->get('getPath'));
    
    if (is_object($this->get('Handler')) && property_exists($this->get('Handler'), 'getPathUrl')) {
      $this->setText('getPathUrl', $this->get('Handler')->get('getPathUrl'));
    }
    
    $text = $this->get('text');
    
    if (is_object($this->get('Handler')) && property_exists($this->get('Handler'), 'tpl')) {
      $t ['1'] = $this->get('tpl');
      $t ['2'] = $this->get('Handler')->get('tpl');
      $tpl = array_merge($t ['1'], $t ['2']);
    } else {
      $tpl = $this->get('tpl');
    }
    
    if (is_array($text)) {
      $this->get('phptal')->text = $text;
    }
    
    for ($i = 0; $i < count($tpl); $i++) {
      $name = $tpl [$i] ['name'];
      $value = $tpl [$i] ['value'];
      
      $this->get('phptal')->$name = $value;
    }
    
    if (is_object($this->get('Texte'))) {
      $ov = get_object_vars($this->get('Texte'));
      if (isset($ov ['tpl'])) {
        for ($i = 0; $i < count($ov ['tpl']); $i++) {
          $name = $ov ['tpl'] [$i] ['name'];
          $value = $ov ['tpl'] [$i] ['value'];
          
          $this->get('phptal')->$name = $value;
        }
      }
    }
    
    
    $url = filter_input(INPUT_SERVER, 'REQUEST_URI');
    if (preg_match('/page/i', $url)) {
      $tmp = explode('/page', $url);
      $this->get('phptal')->getURL = $tmp['0'];
    } else {
      $this->get('phptal')->getURL = $url;
    }
    
    $this->get('phptal')->aSession = $_SESSION;
    $this->showTemplate();
  }
  
  /**
   * Template ausfuehren / anzeigen
   */
  public function showTemplate()
  {
    $this->get('phptal')->execute();
  }
  
}