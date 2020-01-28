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
 * @link        https://smt.palle.dev
 **/

namespace App;

spl_autoload_register('App\SMT');

class App extends \Config
{

  public function __construct()
  {
    parent::__construct();
  }

}

$App = new App ();

/**
 *
 * @param type $class
 */
function SMT($class)
{
  // Erlabute folder für Klassen
  $allowed = array(
    'App',
    'ServerService',
    'Infrastructure',
    'Module',
    'System',
    'TicketSystem');

  // Aktuellen folder einlesen
  $folder = scandir(dirname(__FILE__));

  for ($i = 0; $i < count($folder); $i++) {
    if (!strstr($folder [$i], '.')) {
      $class_folder [$i] = scandir(dirname(__FILE__) . '/' . $folder [$i]);
      for ($c = 0; $c < count($class_folder [$i]); $c++) {
        if (is_dir(dirname(__FILE__) . '/' . $folder [$i] . '/' . $class_folder [$i] [$c])) {
          $sub_class_folder [$i] = scandir(dirname(__FILE__) . '/' . $folder [$i] . '/' . $class_folder [$i] [$c]);
          for ($s = 0; $s < count($sub_class_folder [$i]); $s++) {
            $ClassName = str_replace('.php', '', $sub_class_folder [$i] [$s]);
            if ($ClassName == $class) {
              require_once dirname(__FILE__) . '/' . $folder [$i] . '/' . $class_folder [$i] [$c] . '/' . $sub_class_folder [$i] [$s];
            }
          }
        }

        if (strstr($class_folder [$i] [$c], '.php')) {
          $ClassName = str_replace('.php', '', $class_folder [$i] [$c]);
          if ($ClassName == $class) {
            require_once dirname(__FILE__) . '/' . $folder [$i] . '/' . $class_folder [$i] [$c];
          }
        }
      }
    }

    if (strstr($folder [$i], '.php')) {
      $ClassName = str_replace('.php', '', $folder [$i]);
      if ($ClassName == $class) {
        require_once dirname(__FILE__) . '/' . $folder [$i];
      }
    }
  }
}

?>
