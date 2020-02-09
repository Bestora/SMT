<?php

declare(strict_types=1);

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
class Password
{

    public function getAll()
    {
        $db = new Database('SMT-ADMIN');
        $session = Session::getInstance();

        if ($session->get('sysadmin') == 1) {
            $query = "SELECT * FROM wos_password WHERE private=:privateAdmin || private=:privateAll || private=:privateOwn && user=:user ORDER BY id";
            $value = array(':privateAdmin' => '2', ':privateAll' => '0', ':privateOwn' => '1', ':user' => $_SESSION['username']);
        } else {
            $query = "SELECT * FROM wos_password WHERE private=:privateAll || private=:privateOwn && user=:user ORDER BY id";
            $value = array(':privateAll' => '0', ':privateOwn' => '1', ':user' => $_SESSION['username']);
        }


        return $db->getQuery($query, $value, True);
    }

    /**
     * Löschen einer Lizenz
     * @param type $id
     */
    public function deletePassword($id)
    {
        $db = new Database('SMT-ADMIN');

        $query = "DELETE FROM wos_password WHERE id=:id";
        $db->getQuery($query, array(':id' => $id));
    }

    /**
     * Methode zum speichern von Lizenzen
     * @param type $post
     * @return void
     */
    public function savePassword($post)
    {
        $db = new Database('SMT-ADMIN');

        $query = "INSERT INTO wos_password (user) VALUES (:user)";
        $value = array(':user' => $_SESSION['username']);

        $db->getQuery($query, $value);
        $this->updatePassword($db->getLastID(), $post);
    }

    /**
     * Methode zum speichern von Lizenzen
     * @param $id
     * @param type $post
     * @return void
     */
    public function updatePassword($id, $post)
    {
        $db = new Database('SMT-ADMIN');

        foreach ($post as $key => $value) {
            if ($value != '') {
                $query = "UPDATE wos_password SET $key=:value WHERE id=:id";
                $nvalue = array(':value' => $value, ':id' => $id);
            }

            $db->getQuery($query, $nvalue);
        }
    }

    /**
     * Methode zum auslesen eines Eintrags zu einem Systen
     * @param type int $id
     * @return Exception
     */

    public function getSystemPassword($id)
    {
        $db = new Database('SMT-ADMIN');
        $session = Session::getInstance();

        if ($session->get('sysadmin') == 1) {
            $query = "SELECT * FROM wos_password WHERE system=:system && private=:privateAdmin || system=:system && private=:privateAll || system=:system && private=:privateOwn";
            $value = array(':system' => $id, ':privateAdmin' => '2', ':privateAll' => '0', ':privateOwn' => '1');
        } else {
            $query = "SELECT * FROM wos_password WHERE system=:system && private=:privateAll || system=:system && private=:privateOwn";
            $value = array(':system' => $id, ':privateAll' => '0', ':privateOwn' => '1');
        }

        return $db->getQuery($query, $value, True);
    }
}