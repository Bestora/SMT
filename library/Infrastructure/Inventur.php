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

class Inventur
{

    /**
     * Methode zum suche nach einer Hardware via Barcode
     * @param type $barcode
     * */
    public function searchItem($barcode)
    {
        $db = new Database('SMT-ADMIN');
        $barcode = str_replace('/', '-', $barcode);

        $db->getQuery("SELECT * FROM wos_hardware WHERE inventarnummer LIKE :barcode", array(':barcode' => $barcode));
        if ($db->getNumrows() == 1) {
            $this->saveItem($db->getValue(), 'Hardware');
        }

        $db->getQuery("SELECT * FROM wos_license WHERE barcode LIKE :barcode", array(':barcode' => $barcode));
        if ($db->getNumrows() == 1) {
            $this->saveItem($db->getValue(), 'Software');
        }
    }


    /**
     * Auslesen aller Einträge
     * @return array
     * */
    public function readAllItems()
    {
        $db = new Database('SMT-ADMIN');

        $har = $db->getQuery("SELECT * FROM wos_hardware WHERE inventur=:inventur", array(':inventur' => 'ja'), True);
        for ($i = 0; $i < count($har); $i++) {
            $db->getQuery("SELECT * FROM wos_inventur WHERE barcode=:barcode", array(':barcode' => $har[$i]['inventarnummer']));
            if ($db->getNumrows() > 0) {
                $har[$i]['status'] = "on";
            } else {
                $har[$i]['status'] = "info";
            }
            $har[$i]['bezeichnung'] = substr($har[$i]['bezeichnung'], 0, 15);
        }

        return $har;
    }

    /**
     * Scan der inventur speichern
     * @param type $post
     * */
    public function saveScan($post)
    {
        $db = new Database('SMT-ADMIN');
        $barcode = str_replace('/', '-', $post['barcode']);

        $query = "INSERT INTO wos_inventur (barcode) VALUE (:barcode)";
        $value = array(':barcode' => $barcode);

        $db->getQuery($query, $value);
    }

    /**
     * Inventur zurücksetzen
     * */
    public function clear()
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("TRUNCATE wos_inventur", array(), True);
    }

}

?>
