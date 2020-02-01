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

class Contract
{

    /**
     * Methode zum abrufen der Verträge
     */
    public function getContract($id = '')
    {
        $db = new Database('SMT-ADMIN');

        if (empty($id)) {
            $db->getQuery("SELECT * FROM wos_contract ORDER BY id DESC", array(), False);
            return $db->getValue();
        } else {
            $det['contract'] = $db->getQuery("SELECT * FROM wos_contract WHERE id=:id", array(':id' => $id), True);
            $det['anhang'] = $db->getQuery("SELECT * FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'contract'), True);
            $det['detail'] = $db->getQuery("SELECT * FROM wos_contract_details WHERE contract_id=:id", array(':id' => $id), True);

            return $det;
        }

    }

    /**
     * Methode zum speichern der Daten
     * Aufruf und Übergabe der Daten an die update Funktion
     */
    public function saveContract($post)
    {
        $db = new Database('SMT-ADMIN');

        $db->getQuery("INSERT INTO wos_contract (bezeichnung) VALUE (:bezeichnung)", array(':bezeichnung' => $post['bezeichnung']));
        $id = $db->getLastID();
        $this->updateContract($id, $post);
        return $id;
    }

    /**
     * Mehtode zumk updaten eines Datensatzes
     * @param type $id
     */
    public function updateContract($id, $post)
    {
        $db = new Database('SMT-ADMIN');

        foreach ($post as $key => $value) {
            if (!preg_match('/detail_/', $key)) {
                $query = "UPDATE wos_contract SET $key=:value WHERE id=:id";
                $value = array(':value' => $value, ':id' => $id);

                $db->getQuery($query, $value);
            }
        }

        if (isset($post['detail_name'])) {
            // Vorhandene Werte löschen und dann neu schreiben
            $db->getQuery("DELETE FROM wos_contract_details WHERE contract_id=:id", array(':id' => $id));

            $detail_name = $post['detail_name'];
            $detail_value = $post['detail_value'];

            for ($i = 0; $i < count($detail_name); $i++) {
                $query = "INSERT INTO wos_contract_details (contract_id, form_name, form_value) VALUE (:id, :name, :value)";
                $value = array(':name' => $detail_name[$i], ':value' => $detail_value[$i], ':id' => $id);

                if (!empty($detail_name[$i]) && !empty($detail_value[$i])) {
                    $db->getQuery($query, $value);
                }
            }
        }
    }

    /**
     * Methode zum löschen eines Eintrags
     * @param type $id
     */
    public function deleteContract($id)
    {
        $db = new Database('SMT-ADMIN');
        $db->getQuery("DELETE FROM wos_contract WHERE id=:id", array(':id' => $id));
        $db->getQuery("DELETE FROM wos_contract_details WHERE contract_id=:id", array(':id' => $id));
        $db->getQuery("DELETE FROM wos_attachments WHERE identkey=:id && controller=:controller", array(':id' => $id, ':controller' => 'contract'));
    }

}