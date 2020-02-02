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

class Content extends Template
{

    public function __construct()
    {
        $this->loadController();
        parent::__construct();
    }

    /**
     * Methode zum laden des Controllers
     * wenn kein Controller gefunden wird
     * wird der Content Controller geladen
     */
    private function loadController()
    {
        $session = Session::getInstance();

        if (is_object($this->get('Handler'))) {
            $ov = get_object_vars($this->get('Handler'));
            if (isset($ov ['controller']) && !empty($ov ['controller'])) {
                $this->set('controller', $ov ['controller']);
                $this->set('methode', $ov ['methode']);
            }
        }

        // Auf Projektcontroller prÃ¼fen
        if (file_exists(project_path . '/controller/' . $this->get('controller') . '.php')) {
            $controller = project_path . '/controller/' . $this->get('controller') . '.php';
        }

        // Falls kein Controller gefunden wird ist es automatisch der content controller
        if (!isset($controller)) {
            header("Location: " . base::get('getPath') . "/error");
        }

        template::setText('controller', $this->get('controller'));
        template::setText('methode', $this->get('methode'));

        template::setText('active_' . $this->get('controller'), 'active');
        template::setText('active_' . $this->get('controller') . '_' . $this->get('methode'), 'active');

        $session->set('controller', $this->get('controller'));
        $session->set('methode', $this->get('methode'));

        if (isset($_SESSION['limitController']) && !in_array($session->get('controller'), $session->get('limitController')) && $session->get('controller') != 'home' && $session->get('controller') != 'user') {
            header("Location: " . filter_input(INPUT_SERVER, 'HTTP_REFERER'));
        } else {
            require_once $controller;
        }
    }

    /**
     * Methode zum einlesen und Ã¼bergeben des Subcontroller
     */
    public function getSubcontroller()
    {
        $subcontroller = project_path . '/controller/' . $this->get('controller') . '/' . $this->get('methode') . '.php';


        if (!file_exists($subcontroller)) {
            $subcontroller = project_path . '/controller/structure/' . $this->get('methode') . '.php';
        }

        if ($this->get('methode') == 'search') {
            template::setText('showSearch', True);
        }

        return $subcontroller;
    }

}

?>
