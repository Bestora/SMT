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

class Config extends Language
{

  /**
   * Konstruktor, Config setzen und Autoloader starten
   * */
  public function __construct()
  {
    $this->set('url', explode('/', substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 1)));

    $this->loadConfig();
    $this->autoLoader();
    $this->loadModule();

    $this->registerClass('Session', True, False);

    $session = Session::getInstance();
    $session->set('BASEURL', $this->get('getPath'));
    $atmpurl = explode('/', filter_input(INPUT_SERVER, 'REQUEST_URI'));

    if (in_array('page', $atmpurl)) {
      $db_limit['start'] = (int)end($atmpurl);
    } else {
      $db_limit['start'] = 0;
    }

    $db_limit['limit'] = (int)$this->get('iAnzahl');
    $db_limit['next'] = ($db_limit['start'] + $db_limit['limit']);
    $db_limit['prev'] = ($db_limit['start'] - $db_limit['limit']);
    $session->set('db_limit', $db_limit);

    if ($session->get('db_summe') > (int)$this->get('iAnzahl')) {
      template::setText('Blaetter', True);
    }

    parent::__construct();
  }

  /**
   * Einlesen der Konfiguration
   * */
  public function loadConfig()
  {
    $url = $this->get('url');

    if (strlen(filter_input(INPUT_SERVER, 'REQUEST_URI')) > 1) {
      $this->set('controller', $url ['0']);

      if (isset($url ['1']) && !empty($url ['1'])) {
        $this->set('methode', $url ['1']);
      } else {
        $this->set('methode', 'index');
      }
    } else {
      $this->set('controller', 'home');
      $this->set('methode', 'index');
    }

    $this->getConfig('assets' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $_SERVER['SERVER_NAME'] . '.ini');
    $project = array();

    $project ['name'] = $this->get('project');
    $project ['path'] = project_path;
    $project ['base'] = project_base;

    $this->set('project', $project);
    define('USER_DB', $this->get('USER_DB'));
  }

  /**
   * Konstruktor, Config setzen und authentifizieren
   * */
  public function autoLoader()
  {
    if (!is_null($this->get('loader'))) {
      $class = explode(',', $this->get('loader'));

      if (count($class) >= 1 && !empty($class ['0'])) {
        for ($i = 0; $i < count($class); $i++) {
          $this->registerClass($class [$i]);
        }
      }
    }
  }

  /**
   * Methode zum einlesen der Module
   */
  public function loadModule()
  {
    $file = new File;
    $list = $file->readDir('/controller/module/');
    $menu = array();

    if (isset($list['ordner'])) {
      for ($i = 0; $i < count($list['ordner']); $i++) {
        $tmp = file_get_contents(project_path . '/controller/module/' . $list['ordner'][($i + 1)]['name'] . '/system/menu.php', true);
        $tmp = explode('::', $tmp);

        $menu[$i]['modul'] = $list['ordner'][($i + 1)]['name'];
        $menu[$i]['link'] = 'module/' . $list['ordner'][($i + 1)]['name'] . '/index';
        $menu[$i]['bezeichnung'] = $tmp['1'];
      }
    }

    template::setText('module_menu', $menu);
  }

}

?>
