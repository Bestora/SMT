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

class Session
{

    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;
    private static $instance;
    private $sessionState = self::SESSION_NOT_STARTED;

    public function __construct()
    {

    }

    /**
     * Methode zum instanzieren
     *
     * @return type
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self ();
        }

        self::$instance->startSession();
        return self::$instance;
    }

    /**
     * Session starten
     *
     * @return <string>
     */
    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        $this->set('ID', session_id());
        return $this->sessionState;
    }

    /**
     * Methode zum setzen eines Wertes in der Session
     *
     * @param <string> $name
     * @param <string> $value
     */
    public static function set($name, $value)
    {
        $_SESSION [$name] = $value;
    }

    /**
     * Methode zum abfragen eines Wertes aus der Session
     *
     * @param <string> $name
     * @return boolean
     */
    public static function get($name)
    {
        if (isset($_SESSION [$name])) {
            return $_SESSION [$name];
        } else {
            return False;
        }
    }

    /**
     * Methode zum prüfen ob es den Wert in der Session gibt
     *
     * @param <string> $name
     * @return <string>
     */
    public function __isset($name)
    {
        return isset($_SESSION [$name]);
    }

    /**
     * Methode um einen Wert aus der Session zu löschen
     *
     * @param <string> $name
     */
    public function __unset($name)
    {
        unset($_SESSION [$name]);
    }

    /**
     * Methode zum löschen der aktuellen Session
     *
     * @return boolean
     */
    public function destroy()
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return FALSE;
    }

}

?>
