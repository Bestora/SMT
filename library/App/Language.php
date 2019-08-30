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

class Language extends Base
{

  public function __construct()
  {
    $session = Session::getInstance();
    $language = $session->get('language');

    if (!isset($language) || $language == '') {
      $this->setLanguage();
      header("Refresh:0");
    }

    parent::__construct();
  }

  /**
   * Methode zum setzen einer Sprache
   * @param string $language
   */
  public function setLanguage($language = '')
  {
    $session = Session::getInstance();

    if (empty($language)) {
      $this->set('language', $this->get('language'));
      $session->set('language', $this->get('language'));
    } else {
      $this->set('language', $language);
      $session->set('language', $language);
    }
  }

  /**
   * Methode zum lesen der aktuelle Sprache
   * @return string
   */
  public function getLanguage()
  {
    $session = Session::getInstance();
    return $session->get('language');
  }

}

?>
